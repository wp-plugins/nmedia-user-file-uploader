<?php
/*
Plugin Name: Nmedia File Uploader Plugin
Plugin URI: http://www.najeebmedia.com
Description: This Plugin is developed by NajeebMedia.com
Version: 1.1
Author: Najeeb Ahmad
Author URI: http://www.najeebmedia.com/
*/

/*ini_set('display_errors',1);
error_reporting(E_ALL);*/


class nmFileUploader {
	
	var $fileupload_db_version = "1.0";
	
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
	
	
	function test()
	{
		echo 'yes man';
	}
	
	function renderUserArea()
	{
		global $wpdb ;
		global $user_ID;
		global $current_user;
		get_currentuserinfo();
		
		
		if ( is_user_logged_in() ) { 
			nmFileUploader::renderForm();
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
		nmFileUploader::$pathUploads = ABSPATH . 'wp-content/uploads/user_uploads/';
		if(!is_dir(nmFileUploader::$pathUploads))
		{
			if(mkdir(nmFileUploader::$pathUploads, 0777))
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
				`fileUploadedOn` DATETIME NOT NULL );";
	
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
	

  
  public function set_up_admin_page () {
	
	add_menu_page(	'FileUploader', 
					'NM FileUploader', 
					'manage_options', 
					'nmuploader-settings', 
					array('nmFileUploader', 'show_admin_options'),
					'',
					4);
	
	/*add_submenu_page( 'nmuploader-settings',
					  'Settings', 
					  'Settings', 
					  'manage_options', 
					  'upload-files', 
					  array('nmFileUploader', 'setting_main_page'));*/
  	
	}
	
	
	public function show_admin_options()
	{
		$file = dirname(__FILE__).'/options.php';
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
		$res = $wpdb->query(
						"
						DELETE FROM ".$wpdb->prefix . nmFileUploader::$tblName."
						WHERE fileID = $fileid"
					);
		return $res;
	}
	
	
	/*
	Get Files Detail
	*/
	
	function getUserFiles()
	{
		//echo "hello";
		global $wpdb;
		
		if($_REQUEST['user_id'] != '')
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
	
	
	function nm_user_upload_admin(){
	
	global $wpdb;
	
	$user_id = $_REQUEST['user_id'];
	
	if($_GET['dlg-delete-file'] != ""){
		$wpdb->query("
					DELETE FROM ".$wpdb->prefix."dlg_cu WHERE id = ".$_GET['dlg-delete-file']."
					");
	
	}
	
		nmFileUploader::renderListings();	
	
	}	

  
  
}

register_activation_hook(__FILE__, array('nmFileUploader','fileuploader_install'));

add_action('admin_menu', array('nmFileUploader', 'set_up_admin_page'));



function load_fileuploader_script() {
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', plugins_url('js/jquery-1.4.4.min.js', __FILE__));
	wp_enqueue_script( 'jquery' );
	
	wp_register_script('swfobject_script', plugins_url('js/uploadify/swfobject.js', __FILE__));
	wp_enqueue_script('swfobject_script');
	
	wp_register_script('uploadify_script', plugins_url('js/uploadify/jquery.uploadify.v2.1.4.min.js', __FILE__));
	wp_enqueue_script('uploadify_script');
	
	
     wp_register_script( 'fileuploader_custom_script', plugins_url('js/fileuploader_custom.js', __FILE__), 'uploadify_script');
	 wp_enqueue_script('fileuploader_custom_script');
	 
	 //fancy box
}    

add_action('wp_enqueue_scripts', 'load_fileuploader_script');

add_shortcode( 'nm-wp-file-uploader', array('nmFileUploader', 'renderUserArea'));



add_action('wp_print_styles', 'nm_fileuploader_style');

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

?>
