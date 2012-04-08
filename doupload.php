<?php
/*
** uploading file to server 
*/

$url = filter_var ($_REQUEST['plugin_url'], FILTER_VALIDATE_URL);
$arr = explode('plugins/', $url);
$plugin_name = $arr[1];
$wp_path = dirname(__FILE__);
$generate_path = str_replace("wp-content/plugins/".$plugin_name, "wp-load.php", $wp_path);

if(file_exists($generate_path))
	require $generate_path;
else
	die('file could not be loaded '. $generate_path);
	  
global $current_user;

$upload_dir = wp_upload_dir();
$path_folder = $upload_dir['basedir'].'/user_uploads/'.$current_user -> user_login.'/';

		

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $path_folder;
	$targetFile =  str_replace('//','/',$targetPath) . sanitize_file_name($_FILES['Filedata']['name']);
	
		move_uploaded_file($tempFile,$targetFile);
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
}
?>