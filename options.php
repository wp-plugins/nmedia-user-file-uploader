<?php
//print_r(get_option('widget_nmedia_mail_chimp'));
if ( count($_POST) > 0 && isset($_POST['btn_options']) )
	{

		delete_option('nm_file_uploaded_msg');
		add_option('nm_file_uploaded_msg', $_POST['nm_file_uploaded_msg']);	 
		
		delete_option('nm_file_deleted_msg');
		add_option('nm_file_deleted_msg', $_POST['nm_file_deleted_msg']);	
		
		delete_option('uploader_page_url');
		add_option('uploader_page_url', $_POST['uploader_page_url']);	
}

$nm_file_uploaded_msg = get_option('nm_file_uploaded_msg');
$nm_file_deleted_msg = get_option('nm_file_deleted_msg');
$uploader_page_url = get_option('uploader_page_url');


?>

<h1>Nmedia User Files Manager Plugin</h1>
<div style="padding:10px; background-color:#CCC; border:#999 1px dashed; width:800px">
<h3>Use following Shortcode in page</h3>
[nm-wp-file-uploader]
</div>
<br />


<div style="padding:10px; background-color:#CCC; border:#999 1px dashed; width:800px">
<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])?>" method="post">
<table width="800" class="xet_settings_tbl">
<!--<tr>
    <td valign="middle">Page URL</td>
    <td valign="top"><input type="text" name="uploader_page_url" id="uploader_page_url" size="63" value="<?php echo $uploader_page_url?>" /><br>
	<span class="nm_help">e.g. where to you want to use this plugin</span>
    </td>
  </tr>-->
  
  
  <tr>
    <td valign="middle">Message when file uploaded (HTML supported)</td>
    <td valign="top"><input type="text" name="nm_file_uploaded_msg" id="nm_file_uploaded_msg" size="63" value="<?php echo $nm_file_uploaded_msg?>" /><br />
    <span class="help">e.g File uploaded successfully</span>
</td>
  </tr>
  
  <tr>
    <td valign="middle">Message when file deleted (HTML supported)</td>
    <td valign="top"><input type="text" name="nm_file_deleted_msg" id="nm_file_deleted_msg" size="63" value="<?php echo $nm_file_deleted_msg?>" /><br />
    <span class="help">e.g File deleted successfully</span>
</td>
  </tr>
  
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input type="submit" value="Save Settings" name="btn_options" /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
</form>
</div>
<br /><br />

<div style="padding:10px; background-color:#CCC; border:#999 1px dashed; width:800px">
<h2>See Users Files (Pro Feature for only $25 USD)</h2>
This is Pro Feature, to get this featured enabled please contact me at <a href="mailto:ceo@najeebmedia.com">ceo@najeebmedia.com</a> with Subject: &quot;Need Pro Version&quot;. You can see screenshot of this feature by click below link.<br />

	<a href="http://www.najeebmedia.com/pro-feature/" target="_blank">Users Files (A Pro Feature)</a>
</div>

<br />
<br />

<a href="http://www.najeebmedia.com/"><img src="http://www.najeebmedia.com/logo.png" alt="Nmedia Logo" border="0" width="175" /></a>
<p>
Nmedia providing Web Application Development and Designing services with a team of Skilled and Professional Buddies. We have developed many E-commerce, Wordpress, Bespoke web projects at very reasonable prices. Must see our projects and feedbacks from our respected clients by visiting company site: <a href="http://www.najeebmedia.com/">Nmedia</a><br />
<br />
Thanks<br />
Najeeb Ahmad<br />
<a href="mailto:ceo@najeebmedia.com">ceo@najeebmedia.com</a>
</p>