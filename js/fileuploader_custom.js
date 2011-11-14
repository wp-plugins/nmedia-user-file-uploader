// JavaScript Document

String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g,"");
}



jQuery(function(){
	
	jQuery(".green, .red").fadeOut(7000);
	jQuery("table#user-file tr:odd").css("background-color", "#f1f1f1");	
});


/* valums uplaoder script */
function createUploader(pluginURL){            
			var running = 0; 
			var images = [];
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader'),
                action: pluginURL + '/phpImageUploader.php',
                debug: true,
				multiple: false,
				showMessage: true,
				//sizeLimit: 500000,
				onSubmit: function(id, fileName)
						  {
							 running++; 
							 /*var loadingImageSrc = pluginURL + "/images/loading-image.gif";*/
							 //jQuery("#fileNames ul").append('<li id="img-id-'+id+'">Loading image</li>');
						  },
						  
				onProgress: function(id, fileName, loaded, total)
							{
								//var per = 100;
								//alert(total);
								//jQuery("#fileNames").append(fileName + "<br>")
								var p = (loaded/total)*400;
								/*jQuery("#progress").append('<li>'+loaded+'/'+total+'='+p+'</li>');*/
								jQuery("#fileNames ul").html('<li id="img-id-'+id+'">Loading image - '+loaded+'/'+total+'</li>');
								jQuery("#runner").css("width", p);
								
							},
				onCancel: function(id, fileName)
					      {
							jQuery( "#progressbar" ).slideUp();
						  },
				onComplete: function(id, fileName, responseJSON)
					      {
							// images.push(fileName);
							 var uploadedImageSrc = pluginURL + "/uploads/"+fileName;
							 jQuery("#fileNames ul li#img-id-"+id).html('<span class="imgName">'+fileName+' uploaded</span>');
							 
							 running--;
							 if(running==0){
								 //alert(images);
								 jQuery("#file-name").attr("value", fileName);
							 }

						  }
							
            });           
}


/*
uploadify
*/
function callUploadify(pluginURL, uploadPath)
{
	jQuery('#file_upload').uploadify({
    'uploader'  : pluginURL + '/js/uploadify/uploadify.swf',
    'script'    : pluginURL + '/js/uploadify/uploadify.php',
    'cancelImg' : pluginURL + '/js/uploadify/cancel.png',
    'folder'    : uploadPath,
    'auto'      : true,
	'onComplete'  : function(event, ID, fileObj, response, data) {
      //alert('There are ' + fileObj.name);
	  jQuery("#file-name").attr("value", fileObj.name);
	  jQuery("#upload-response").html(fileObj.name + ' loaded, Please now click \'Upload\' to upload the file').fadeIn(200);
    }
  });
}

/*
validate me
*/

function validate()
{
	jQuery("#working-area").show();
	
	var upload_file_name	= jQuery("#nm-upload-name").val();
	var file_name			= jQuery("#file-name").val();
	var notes				= jQuery("#nm-notes").val();
	
	var notices 			= jQuery("#notices");
	notices.html('');
	
	var vFlag				= false;
	 
	if(upload_file_name == '')
	{
		notices.append('File Name cannot be empty<br>');
		vFlag = true;
	}
	
	if(file_name == '')
	{
		notices.append('Select any file first<br>');
		vFlag = true;
	}
	
	if(notes == '')
	{
		notices.append('Files Notes cannot be empty<br>');
		vFlag = true;
	}
	
	
	if(vFlag)
	{
		jQuery("#working-area").hide();
		return false;
		
	}
	else
	{
		return true;
	}
}
		
function confirmFirst(url)
{
	var a = confirm('Are you sure to delete this file?');
	if(a)
	{
		window.location = url;
	}
}


function showDetail(id)
{
	jQuery(".detail-all").hide();
	jQuery("#detail-all-"+id).fadeIn(1000);
	
}

	