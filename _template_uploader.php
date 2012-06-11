<?php
/*
** This is main temlate for loading file list, 
do not change until you are like me (ceo@najeebmedia.com)
*/

?>
<script type="text/javascript">
	plugin_path = '<?php echo dirname(__FILE__)?>';
</script>
<div id="nmuploader-wrapper">
<h2 class="nm-list-header"><?php _e('Uploaded Files', nmFileUploader::$short_name)?></h2>

<?php
$arrFiles = nmFileUploader::getUserFiles();
nmFileUploader::$files_per_page = ( get_option('nm_file_file_limit') == 0) ? 5 : get_option('nm_file_file_limit');

nmFileUploader::$total_pages = ceil(count($arrFiles) / nmFileUploader::$files_per_page);


if(isset($_POST['chk-files']))
{
	
	$zip_url = nmFileUploader::downloadFilesAsZip($_POST['chk-files']);
	if($zip_url != 'err')
	{
		
		echo '<p class="download-zip">
				<a href="'.$zip_url.'" target="_blank">'.__('Zip archive ready to download',  nmFileUploader::$short_name);
		echo '<img src="'.plugins_url('images/zip_file_download.png', __FILE__).'" alt="Download all as zip" title="Download all as zip" width="32" border="0">';
		echo  '</a></p>';
	}
	else
	{
		echo '<div class="red">'.__('Some error in creating zip archive',  nmFileUploader::$short_name).'</div>';
	}
}

?>

  
    
    <ul id="nmuploader-top">
    	<li>
        	<ul>
            
            	<li class="sorts">
               <a href="javascript:downloadZip()">
               <!--  <a href="<?php echo $urlDnldAll?>"> -->
                <?php _e('Download selectes files as zip', nmFileUploader::$short_name)?><br />
                <img src="<?php echo plugins_url('/images/zip_file_download.png', __FILE__)?>"
                alt="<?php _e('Download all as zip', nmFileUploader::$short_name)?>"
                title="<?php _e('Download all as zip', nmFileUploader::$short_name)?>"
                width="32" border="0" />
                </a>
                </li>
            </ul>
        </li>
    </ul>
    
    
   
    <ul id="nmuploader-container">
    <li class="heading">
        	<ul class="nmuploader-row" id="nmuploader-<?php echo $nmuploader-> fileID?>">
            	
                <li class="check">
                &nbsp;
                </li>
                <li class="filename"><?php _e('Filename', nmFileUploader::$short_name)?></li>
                <li class="meta">
				<?php _e('File meta', nmFileUploader::$short_name)?>
                </li>
                <li class="time">
                	<?php _e('Date', nmFileUploader::$short_name)?>
                </li>
                
                <li class="tool">
                	<?php _e('Delete', nmFileUploader::$short_name)?>
                </li>
            </ul>
         <div class="fix_height"></div>
        </li>
        
       <form id="frm_nm_files" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])?>#download-zip" method="post">
       <input type="hidden" name="plugin_url" value="<?php echo plugins_url('', __FILE__)?>" />
        <?php 
		$uploader_row_count = 0;
		foreach($arrFiles as $file):
			
			$urlDelete = plugins_url('', __FILE__);
			
			$user_name = '';
			if($file -> userID != 0) 			//public upload
			{
				$user_info = get_userdata($file -> userID);
				$user_name = $user_info -> user_login;
			}
			
			$bg_color = '';
			$urlDwnld = nmFileUploader::makeFileDownloadable($file -> fileName, 
															$file -> fileSize,	
															$user_name,
															$file -> bucketName);
			
			$ajaxDownload = '<a href="javascript:downloadFile(\''.$file -> fileName.'\')">Download</a>';
			
			$uploader_row_count++;
			$page_number = ceil($uploader_row_count / nmFileUploader::$files_per_page);
			
			$isMyFile = nmFileUploader::isIOwn($file -> userID);
			
			/* $filename_admin = !$isMyFile ? 'admin' : ''; */
			
			$urlExtImage = plugins_url('images/ext/48px/'.$file -> fileType, __FILE__);
		?>
            
       
        <li style="display:none" class="nm-c-p-<?php echo $page_number?>">
        	<ul class="nmuploader-row" id="nmuploader-<?php echo $file -> fileID?>">
            	<li class="check">
                	<input type="checkbox" name="chk-files[]" value="<?php echo $file -> fileID?>" />
                </li>
                
                <li>	
                	<img src="<?php echo $$urlExtImage?>" title="<?php echo $file -> fileName?>" />
                </li>
                
                <li class="meta">
                	<a href=""><?php echo $file -> fileName?></a> - <span class="nm-file-meta-more"><?php echo $file -> fileSize?></span><br />
                    <span class="nm-file-meta-more">owner: xendo - 5 days ago</span>
                </li>
                
				<li class="tool">
                <?php
                if(nmFileUploader::$allowDelete and $isMyFile):  //allow user to delete ?> 
                    <a href="javascript:confirmFirst('<?php echo $urlDelete?>', <?php echo $file -> fileID?>,'<?php echo $file -> fileName?>', '<?php echo $file -> bucketName?>')" title="Delete">
					<?php 
						echo '<img id="del-file-'.$file -> fileID.'" border="0" src="'.plugins_url( 'images/delete_16.png' , __FILE__).'" />';	?>
                 </a>
                 <?php
				endif;    //allow user to delete ENDS
				?>
                 </li>
                 
            
            
            </ul>
        </li>
        
      <div class="fix_height"></div>
      <?php endforeach;?>
      </form>
  	</ul>
     
    <ul id="nmuploader-bottom">
        
        <li>
        	<ul>
            	<li id="prev-page">
                <a href="javascript:loadUploaderPagePrev()">
                &laquo; <?php _e('Previous', nmFileUploader::$short_name)?></a></li>
                <li id="page-count">2 of 11</li>
                <li id="next-page"><a href="javascript:loadUploaderPageNext()">
                <?php _e('Next', nmFileUploader::$short_name)?> &raquo;</a></li>
            </ul>
        </li>  
        </ul>
    <script type="text/javascript">
			total_pages = <?php echo nmFileUploader::$total_pages?>;
			setUploaderPagination();
	</script>
    
<div class="fix_height"></div>
</div>