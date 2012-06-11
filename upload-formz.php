<?php
global $wpdb, $current_user;

nmFileUploader::makeUploadDirectory();
/*
delete file
*/
if(isset($_GET['fid']))
{
	if(nmFileUploader::deleteFile($_GET['fid']))
	{
		echo "<div class=\"red\">". get_option('nm_file_deleted_msg') ."</div>";
	}
	
}

/*$wpdb->show_errors();
$wpdb->print_error(); */

/*
save file
*/
if(isset($_POST['nm-submit']))
{
	nmFileUploader::$title 		= '';
	nmFileUploader::$file_name 	= $_POST['file-name'];
	nmFileUploader::$desc		= $_POST['description'];
	nmFileUploader::$file_type	= "." . nmFileUploader::getFileExtension($_POST['file-name']);
	
	if(nmFileUploader::saveFile())
	{
		echo "<div class=\"green\">". get_option('nm_file_uploaded_msg') ."</div>";
	}
	
}

$arrFiles = nmFileUploader::getUserFiles();
?>
<div style="margin:5px;padding:5px;border:1px solid #CCC; background-color:#f5f5f5">
<div id="notices" style="color:red"></div>
<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])?>" method="post" onSubmit="return validate()">
<input type="hidden" name="file-name" id="file-name">
<table width="100%" cellspacing="2" cellpadding="2" style="font-size:.7em;border:none;padding:0px;margin:0px;">
  <tbody>
  <tr>
    <td>File upload:</td>
    <td>
    <input id="file_upload" name="file_upload" type="file" />
    <span id="upload-response" style="display:none"></span>
    </td>
  </tr>
  <tr>
    <td>Additional notes:</td>
    <td><textarea name="description" style="width:90%;height:70px" class="" id="description"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
						<div class="dlg_change_indicator_button"><input type="submit" value="Upload" name="nm-submit" id="nm-upload" class="nm-file-uploader-button"></div>
						<div id="working-area" style="display:none">
                        <?php
							echo "<img src=".plugins_url( 'images/loading.gif' , __FILE__)." />";
						?>
                        </div>	
							</td>
  </tr>
</tbody></table>
</form>

<br>
<div class="user-uploaded-files">
<h2>Uploaded Files</h2>
<table width="100%" border="0" id="user-files">
<thead>
	<tr>
        <th width="233" valign="middle"><strong>File Name</strong></th>
        <th width="516" valign="middle"><strong>Notes</strong></th>
        <th width="71" align="center" valign="middle"><strong>Date</strong></th>
        <th width="97" align="center" valign="middle"><strong>Action</strong></th>
      </tr>
</thead>


<tbody>
<?php foreach($arrFiles as $file):
//print_r(parse_url($_SERVER['HTTP_REFERER']));
$urlQuertyString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

if($urlQuertyString == '')
	$urlDelete = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'?fid='.$file -> fileID;
else
	$urlDelete = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'&fid='.$file -> fileID;

$uploads = wp_upload_dir();

if($file -> fileFor == 0)
{
	$bg_color = '';
	$urlDwnld = $uploads['baseurl'] . '/user_uploads/'.$current_user -> user_login.'/' . $file -> fileName;
}
else
{
	//it is uploaded by admin for this user
	$user_info = get_userdata($file -> userID);
	$bg_color = '#33CC00';
	$urlDwnld = $uploads['baseurl'] . '/user_uploads/'.$user_info -> user_login.'/' . $file -> fileName;
	$urlDelete = "0";
}

//Prior to 1.5 Version fix
if(file_exists($uploads['basedir'] . '/user_uploads/'. $file -> fileName))
{
	$urlDwnld = $uploads['baseurl'] . '/user_uploads/'. $file -> fileName;
}
?>
  <tr>
    <td><?php _e($file -> fileName)?></td>
    <td><?php _e($file -> fileDescription)?></td>
    <td width="71" align="center"><?php _e(date('d-M,y', strtotime($file -> fileUploadedOn)))?></td>
    <td width="97" align="center">
    <a href="<?php _e($urlDwnld)?>">
	<?php echo "<img border=\"0\" src=".plugins_url( 'images/down_16.png' , __FILE__)." />";	?>
    </a>
     | 
    <a href="javascript:confirmFirst('<?php echo $urlDelete?>')">
	<?php echo "<img border=\"0\" src=".plugins_url( 'images/delete_16.png' , __FILE__)." />";	?>
    </a></td>
  </tr>
<?php endforeach;?>
  
</tbody>
</table>
</div>
<div style="clear:both"></div>
</div>


<script type="text/javascript">
	
	//uploadify
	callUploadify('<?php echo plugins_url('', __FILE__);?>', '<?php echo $current_user -> user_login?>');

</script>