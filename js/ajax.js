jQuery(function() {

	jQuery(".green, .red").fadeOut(7000);
	jQuery("table#user-file tr:odd").css("background-color", "#f1f1f1");

});

function setupUploader() {
	/*
	 * uploadify version 2.1.4
	 */

	jQuery('#file_upload')
			.uploadify(
					{
						'uploader' : fileuploader_vars.fileuploader_plugin_url
								+ 'js/uploadify/uploadify.swf',
						'script' : fileuploader_vars.ajaxurl,
						'scriptData' : {
							'action' : 'fileuploader_file',
							'username' : fileuploader_vars.current_user
						},
						'cancelImg' : fileuploader_vars.fileuploader_plugin_url
								+ 'js/uploadify/cancel.png',
						'auto' : true,
						'buttonText' : fileuploader_vars.buttonText,
						'onComplete' : function(event, ID, fileObj, response,
								data) {
							// alert('There are ' + fileObj.name);
							jQuery("#file-name").attr("value", fileObj.name);
							jQuery("#upload-response")
									.html(
											fileObj.name
													+ ' file uploaded successfully')
									.fadeIn(200);
						}
					});
}