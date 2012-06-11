<?php
/*
Plugin Name: Nmedia File Uploader Plugin
Plugin URI: http://www.najeebmedia.com
Description: This Plugin is developed by NajeebMedia.com
Version: 1.8
Author: Najeeb Ahmad
Author URI: http://www.najeebmedia.com/
*/

/*ini_set('display_errors',1);
error_reporting(E_ALL);*/


class nmFileUploader {
	
	var $fileupload_db_version = "1.6";
	
	/*
	data vars
	*/
	
	static $title;
	static $file_name;
	static $desc;
	static $file_type;
	static $pathUploads;
		
	
	static $tblName = 'userfiles';
	
	
	
	/**
	* constructor
	*/	 
	function nmFileUploader() {
		
		//$this -> loadJS();
	}
	
	

	function renderUserArea()
	{
		global $wpdb ;
		global $user_ID;
		global $current_user;
		get_currentuserinfo();
		
		
		if ( is_user_logged_in() ) { 
			ob_start();
	         nmFileUploader::renderForm();
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;
		}
		else
		{
		
			/*wp_redirect( home_url() ); exit;*/
			echo '<script type="text/javascript">
			window.location = "'.wp_login_url( get_permalink() ).'"
			</script>';
		}
		
	}
	
	/*
	This function is making directory in follownig path
	wp-content/uploads/user_uploads
	*/
	
	function makeUploadDirectory()
	{
		global $current_user;
		get_currentuserinfo();
		
		$upload_dir = wp_upload_dir();
		nmFileUploader::$pathUploads = $upload_dir['basedir'].'/user_uploads/'.$current_user -> user_nicename.'/';
		

		if(!is_dir(nmFileUploader::$pathUploads))
		{
			if(mkdir(nmFileUploader::$pathUploads, 0777, true))
				return true;
			else
				return false;
		}
		else
		{
			return true;
		}
	}
	
	
	/*
	Getting file extension
	*/
	function getFileExtension($file_name)
	{
		//echo substr(strrchr($file_name,'.'),1);
	 	return substr(strrchr($file_name,'.'),1);
	}
	
	public function fileuploader_install() {
		global $wpdb;
		global $fileupload_db_version;
	
		$table_name = $wpdb->prefix . nmFileUploader::$tblName;
		  
		$sql = "CREATE TABLE `$table_name` 
				(`fileID` INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`userID` INT( 7 ) NOT NULL ,
				`fileTitle` VARCHAR( 250 ) NULL ,
				`fileName` VARCHAR( 250 ) NULL ,
				`fileDescription` MEDIUMTEXT NULL ,
				`fileType` VARCHAR( 15 ) NULL ,
				`fileUploadedOn` DATETIME NOT NULL )ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	
	   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	   dbDelta($sql);
	 
	   add_option("fileupload_db_version", $fileupload_db_version);
	}


	/*
	form uploader
	*/
	public function renderForm()
	{
		$file = dirname(__FILE__).'/upload-form.php';
		include($file);
	}
	
	
	/*
	Listing user files in admin
	*/
	public function renderListings()
	{
		$file = dirname(__FILE__).'/listings.php';
		include($file);
	}
	

  
  
	public function saveFile()
	{
		global $user_ID;
		global $wpdb;
		
		$dt = array(	'fileTitle'			=> nmFileUploader::$title,
						'fileName'			=> nmFileUploader::$file_name,
						'fileDescription'	=> nmFileUploader::$desc,
						'userID'			=> $user_ID,
						'fileType'			=> nmFileUploader::$file_type,
						'fileUploadedOn'	=> current_time('mysql')
					 );
					 
					 
		//var_dump($dt);
		
		$wpdb -> insert($wpdb->prefix . nmFileUploader::$tblName,
						$dt		
						);
		
		if($wpdb->insert_id)
			return true;
		else
			return false;
						
		//$wpdb->print_error(); 
	}
	
	/*
	deleting file
	*/
	public function deleteFile($fileid)
	{
		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		
		
		$rsObj = $wpdb->get_row("SELECT fileName FROM ".$wpdb->prefix . nmFileUploader::$tblName." WHERE fileID = ".$fileid);
		$res = $wpdb->query(
						"
						DELETE FROM ".$wpdb->prefix . nmFileUploader::$tblName."
						WHERE fileID = $fileid"
					);
		if($res){
			$upPath=wp_upload_dir();
			$path=$upPath['basedir']."/user_uploads/".$current_user -> user_nicename.'/'.$rsObj->fileName;
			$del=@unlink($path);
		}
		
		//print_r($res);
		return $res;
	}
	
	
	/*
	** Get Files Detail
	*/
	
	function getUserFiles()
	{
		//echo "hello";
		global $wpdb;
		
		if(@$_REQUEST['user_id'] != '')
		{
			$userID = $_REQUEST['user_id'];
		}
		else
		{
			global $user_ID;
			$userID = $user_ID;
		}
		
		$myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix . nmFileUploader::$tblName."
						  			   where userID = $userID
									   ORDER BY fileUploadedOn DESC");
	   return $myrows;
	}
	
	
	/*
	** Get All Files Detail
	*/
	
	function getAllUserFiles()
	{
		global $wpdb;
		
		$myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix . nmFileUploader::$tblName."
						  			   ORDER BY fileUploadedOn DESC");
	   return $myrows;
	}
	
	
	function nm_user_upload_admin(){
	
		$user_id = $_REQUEST['user_id'];
	
		nmFileUploader::renderListings();	
	
	}
	
	
	
	/*
	** listing all files uploaded by users
	*/
	
	function listUserFiles()
	{
		$file = dirname(__FILE__).'/listings-all.php';
		include($file);	
	}
	
	
	/*
	 * upload file
	*/
	
	function uploadFile($username){
	
	
		$upload_dir = wp_upload_dir();
		$path_folder = $upload_dir['basedir'].'/user_uploads/'.$username.'/';
	
		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $path_folder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
			if(move_uploaded_file($tempFile,$targetFile)){
				echo '1';
			}
	
			else{
				echo 'Error in file uploading';
			}
		}
	}

  
  
}

register_activation_hook(__FILE__, array('nmFileUploader','fileuploader_install'));




function load_fileuploader_script() {
	/*wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', plugins_url('js/jquery-1.4.4.min.js', __FILE__));
	wp_enqueue_script( 'jquery' );*/
	
	wp_enqueue_script("jquery");
	
	wp_register_script('swfobject_script', plugins_url('js/uploadify/swfobject.js', __FILE__));
	wp_enqueue_script('swfobject_script');
	
	wp_register_script('uploadify_script', plugins_url('js/uploadify/jquery.uploadify.v2.1.4.min.js', __FILE__));
	wp_enqueue_script('uploadify_script');
	
	
     wp_register_script( 'fileuploader_custom_script', plugins_url('js/fileuploader_custom.js', __FILE__), 
	 					array('uploadify_script'));
	 wp_enqueue_script('fileuploader_custom_script');
	 
	 $nonce= wp_create_nonce  ('fileuploader-nonce');
	global $user_login;
	get_currentuserinfo();
	
	wp_enqueue_script( 'fileuploader_ajax', plugin_dir_url( __FILE__ ) . 'js/ajax.js', array( 'jquery' ) );
	wp_localize_script( 'fileuploader_ajax', 'fileuploader_vars', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'fileuploader_token'	=> $nonce,
			'fileuploader_plugin_url' => plugin_dir_url( __FILE__ ),
			'current_user'	=> $user_login
	) );
}    

add_action('wp_enqueue_scripts', 'load_fileuploader_script');

add_shortcode( 'nm-wp-file-uploader', array('nmFileUploader', 'renderUserArea'));
add_action('wp_print_styles', 'nm_fileuploader_style');

//edit user action
add_action( 'edit_user_profile', array('nmFileUploader', 'nm_user_upload_admin'));
add_action( 'show_user_profile', array('nmFileUploader', 'nm_user_upload_admin'));

/*
 * ajax action callback to upload file
* defined in js/ajax.js
*/
add_action( 'wp_ajax_nopriv_fileuploader_file', 'fileuploader_post_file' );
function fileuploader_post_file(){

	nmFileUploader::uploadFile($_REQUEST['username']);

	die(0);
}

/*
* Enqueue style-file, if it exists.
*/

function nm_fileuploader_style() {
	//uploadify css
	wp_register_style('fileuploader_stylesheet', plugins_url('js/uploadify/uploadify.css', __FILE__));
    wp_enqueue_style( 'fileuploader_stylesheet');
		
	wp_register_style('plugin_fileuploader_stylesheet', plugins_url('nm_fileuploader_style.css', __FILE__));
    wp_enqueue_style( 'plugin_fileuploader_stylesheet');        
}

$options_file = dirname(__FILE__).'/file-upload-options.php';
include ($options_file);


?>