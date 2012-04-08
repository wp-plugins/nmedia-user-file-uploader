<?php
/*
** uploading file to server 
*/

$plugin_dir = dirname(__FILE__);
$peices = explode("/", $plugin_dir);
$plugin_name = end($peices);

$wp_path = dirname(__FILE__);
$generate_path = str_replace("wp-content/plugins/".$plugin_name, "wp-load.php", $wp_path);

if(file_exists($generate_path))
	require $generate_path;
else
	die('file could not be loaded '. $generate_path);

$user_name = sanitize_file_name($_REQUEST['folder']);

$upload_dir = wp_upload_dir();
$path_folder = $upload_dir['basedir'].'/user_uploads/'.$user_name.'/';

		

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $path_folder;
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
		move_uploaded_file($tempFile,$targetFile);
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
}
?>