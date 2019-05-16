<div id="image_uploader_div" style="width:320px;height:130px;display:none;">
	<form name="ImageForm" action="" method="post" onSubmit="return validate_upload_image(this);" enctype="multipart/form-data">

<div id="uploader_msg" align="center" class="blacknormal" style="display:none">
<?=LOADER_MSG_IMG?>
</div>
<div id="uploader_frm">
<table cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td colspan="2" height="20"></td>
</tr>	
<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :&nbsp;	&nbsp;	</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;		</td>
  </tr>
	

<tr>
  <td  align="right"    class="blackbold" valign="top">&nbsp;</td>
  <td  align="left"  ><input name="SbButton" type="submit" class="button" id="SbButton" value="Submit &raquo;"  />
<? (empty($OldImage))?($OldImage=""):(""); ?>
  <input type="hidden" name="OldImage" value="<?=$OldImage?>">
  <input type="hidden" name="tab" value="image" />
  
  </td>
</tr>	
  </table>
	</div>


	</form>
</div>	

<script language="JavaScript1.2" type="text/javascript">
function validate_upload_image(frm){
	if( ValidateMandImage(frm.Image, "Image")
	){
		document.getElementById("uploader_frm").style.display= 'none'; 
		document.getElementById("uploader_msg").style.display= 'block'; 
		return true;	
	}else{ 
		return false;	
	}	
}
</script>

