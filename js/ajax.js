jQuery(function() {

	jQuery(".green, .red").fadeOut(7000);
	jQuery("#nmuploader-container li:odd ul").css("background-color", "#f1f1f1");
	
	// hiding all fileuploader but only page-1
	jQuery("ul#nmuploader-container li.nm-c-p-1").show();

});

function setupUploader() {
	/*
	 * uploadify version 2.1.4
	 */

	jQuery('#file_upload').uploadify(
					{
						'swf' : fileuploader_vars.fileuploader_plugin_url
								+ 'js/uploadify-v-3-1-1/uploadify.swf',
						//'uploader' : fileuploader_vars.fileuploader_plugin_url+'/uploadify.php',
						'uploader' : fileuploader_vars.ajaxurl,
						'formData' : {
							'action' : 'fileuploader_file',
							'username' : fileuploader_vars.current_user
						},
						'auto' : true,
						'buttonText' : fileuploader_vars.buttonText,
						'onUploadComplete' : function(fileObj) {
							alert('There are ' + fileObj.name);
							jQuery("#file-name").attr("value", fileObj.name);
							jQuery("#upload-response").html(fileObj.name + ' file uploaded successfully').fadeIn(200);
						},
						'onUploadError' : function(file, errorCode, errorMsg, errorString) {
				            alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
				        },
				        'onUploadSuccess' : function(file, data, response) {
				            alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
				        }
					});
}


function sendTestPost(){
	
	jQuery.post(fileuploader_vars.ajaxurl, {action: 'fileuploader_file', d: 'test', d2: 'Test2'}, function(resp){
		
		alert(resp);
	});
}