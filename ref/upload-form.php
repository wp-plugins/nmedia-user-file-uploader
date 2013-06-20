<?php
global $current_user;
get_currentuserinfo();
?>

<?php
//check if allowUplaod is True
if(nmFileUploader::$allowUpload)
{
	
$max_file_size = (nmFileUploader::$fileSize == '') ? '' : __('Max file size limit: ', 'nm_file_uploader_pro').(nmFileUploader::$fileSize/(1024*1024)).'MB';
	
nmFileUploader::makeUploadDirectory();
?>

<!-- loading custom css here -->
<style>
<?php echo get_option('nm_file_custom_css')?>
</style>

<div id="nm-upload-container">
<p style="text-align:center">
<strong><?php _e('Upload file(s):', nmFileUploader::$short_name)?></strong>
<span style="font-style: italic"><?php _e('click button below and browse for your file(s), then click "Save"', nmFileUploader::$short_name)?></span>
</p>
<div id="error"></div>
<form method="post" onSubmit="return validate('<?php echo plugins_url('', __FILE__);?>')" id="frm_upload">
<input type="hidden" name="file-name" id="file-name">


<div class="nm-uploader-area" id="drag-drop-queue">
	
  <input id="file_upload" name="file_upload" type="file" />
  <span id="upload-response"></span>
</div>

<table>

<?php nmFileUploader::renderInput()?>

<!-- saving button -->
<tr>
<td colspan="2" style="text-align: center">
<input class="nm-submit-button" type="submit" value="<?php _e('Save', 'nm_file_uploader_pro')?>" name="nm-submit" id="nm-upload">
    <div id="working-area" style="display:none">
		<?php
			echo "<img src=".plugins_url( 'images/loading.gif' , __FILE__)." />";
		?>
    </div>	
</td>
</tr>
</table>

</form>

<div style="clear:both"></div>
</div>

<script type="text/javascript">fileuploader_vars.buttonText	= '<?php echo nmFileUploader::$buttonText?>';
		fileuploader_vars.multiAllow 	= '<?php echo nmFileUploader::$multiAllow?>';
		fileuploader_vars.fileLimit		= '<?php echo nmFileUploader::$fileLimit?>';
		fileuploader_vars.fileExt		= '<?php echo nmFileUploader::$fileExt?>';
		fileuploader_vars.sizeLimit		= '<?php echo nmFileUploader::$fileSize?>';
		setupUploader();
</script>
<?php
}	//if(nmFileUploder::$allowUpload)
?>


<!-- don't remove these lines these link to download all zip -->
<a name="download-zip"></a>
<!-- don't remove these lines these link to download all zip -->


<?php
//file list
//check if displayFiles is True
if(nmFileUploader::$displayFiles)
{
	$list_path = dirname(__FILE__).'/_template_uploader.php';
	include ($list_path);
}
?>