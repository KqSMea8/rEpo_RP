<div id="image_uploader_div" style="width:300px;height:120px;display:none;">
	<form name="ImageForm" action="" method="post" onSubmit="return validate_upload_image(this);" enctype="multipart/form-data">


<table cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td colspan="2" height="20"><div id="uploader_msg" align="center" class="redmsg" style="display:none">Uploading.....</div></td>
</tr>	
<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :&nbsp;	&nbsp;	</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;		</td>
  </tr>
	

<tr>
  <td  align="right"    class="blackbold" valign="top">&nbsp;</td>
  <td  align="left"  ><input name="SbButton" type="submit" class="button" id="SbButton" value="Submit &raquo;"  />
  
  <input type="hidden" name="tab" value="image" />
  
  </td>
</tr>	
  </table>
	
	</form>
</div>	

<script language="JavaScript1.2" type="text/javascript">
function validate_upload_image(frm){
	if( ValidateMandImage(frm.Image, "Image")
	){
		$("#uploader_msg").show();

		var SendUrl = "&action=emp_image&Image="+document.getElementById("Image").value+"&r="+Math.random(); 

		$.ajax({
			type: "REQUEST",
			url: "upload.php",
			data: SendUrl,
			success: function (responseText) {
				$("#uploader_msg").html(responseText);

			}
		});



		return false;	
	}else{ 
		return false;	
	}	
}
</script>

