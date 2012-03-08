=== Nmedia Users File Uploader Plugin ===
Contributors: nmedia
Donate link: http://www.najeebmedia.com/donate/
Tags: File uploader, User files, User files manager, File uploaders, User Desgins uploader, Image uploader, ajax based file uploader, progress bar
Requires at least: 3.2.1
Tested up to: 3.3
Stable tag: 1.7

Nmedia Users File Uploader Plugin is AJAX bassed file uploader that lets your site users to upload files with Progress Bar.


== Description ==
This plugin lets the wordpress site users to upload files and then can download. It uses flash uploader with progress bar. Users can see all uploaded files and also can download it or delete these files. All is done using a simple short code: [nm-wp-file-uploader] 

<h3>Features</h3>
<ol>
	<li>Flash Uploader</li>
	<li>Ajax based validation</li>
	<li>File Name</li>
	<li>File Detail</li>
	<li>Download Files</li>
	<li>Delete File</li>
	<li>Customized Upload Message, Delete Message</li>
</ol>

<a href="http://www.najeebmedia.com/nmedia-file-uploader-plugin/">View Demo</a><br>
username: test<br>
password: password


<h3>Pro Features</h3>
Pro version gives you AWSOME control over this plugin. Like Admin can upload files for Roles or for Public. Also, now you can control the plugin with shortcode parameters listed below:
<ul>
	<li><strong>multi</strong>: multiple upload</li>
	<li><strong>file_limit</strong>: control file limits</li>
	<li><strong>file_ext</strong>: restrict file extension</li>
	<li><strong>allow_delete</strong>: switch on/off delete control</li>
	<li><strong>allow_upload</strong>: switch on/ff to upload files</li>
	<li><strong>display_files</strong>: show/hide files</li>
	<li><strong>is_public:</strong> allow all users to see uploaded files</li>
	<li><strong>size_limit: </strong>control file size uploaded by users</li>
</ul>

For more information please visit: <a href="http://www.najeebmedia.com/nmedia-file-uploader-v5/">Pro Version</a>

== Installation ==

1. Upload plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. After activation, you can set options from `NM FileUploader` menu

== Frequently Asked Questions ==

= Can I change the message when file uploaded or deleted? =

Yes you can.

= Can I see its working Demo? =
Yes, http://www.najeebmedia.com/nmedia-file-uploader-plugin/<br>
username: test<br>
password: password


= Does this uploader will show progressbar =
Yes nice progressbar with percentage

= Why I see HTTP Error message =
it is because of your server side settings, sometime php.ini does not allow to upload big files. You need to check following two settings in php.ini:<br>
1- post_max_size<br>
2- upload_max_filesize


== Screenshots ==

1. Option settings under `NM FileUploader` menu
2. using short code in page
3. Front end view
4. Admin area for user uploaded files

== Changelog ==

= 1.0 =
* It is first version, and working perfectly

= 1.1 =
* Just fixed the delete file bug.

= 1.2 =
* Fixed content placement issue when using shortcode in middle of post/page.

= 1.3 =
* Fixed the bug for php short code

= 1.4 =
* Change the Upload File button 

= 1.5 = 
* Physical file deleted from folder
* Every user will have its own upload directory as `user_name`
* File Name field is removed

= 1.6 =
* there was error sometimes when creating directory for users, not it is fixed.

= 1.7 =
* Admin can see the file uploade by users




== Upgrade Notice ==

= 1.0 =
Nothing for now.

= 1.1 =
Update to this version, Delete File issue is just fixed.

= 1.2 =
Update to this version, Content Placement issue is being fixed

= 1.3 =
Fixed the bug for php short code

= 1.4 =
Wrapped up the Upload File Button with some CSS.

= 1.5 =
This plugin has three major changes, please update to get these.

= 1.6 =
Upload directory was not creating due to some server side settings, now it is fixed

= 1.7 =
Admin can see the file uploade by users



1. It is very light plugin
2. We are working on more plugins to get our users more excited.
3. More options/controls will be given soon.