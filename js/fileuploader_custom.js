// JavaScript Document

String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g,"");
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

	