<? if(empty($DocType)) $DocType='Document'; 


(empty($SupportedDoc))?($SupportedDoc=""):("");
?>
<div id="doc_uploader_div" style="width:370px;height:180px;display:none;">
	<form name="DocForm" action="" method="post" onSubmit="return validate_upload_doc(this);" enctype="multipart/form-data">

<div id="docuploader_msg" align="center" class="blacknormal" style="display:none">
<?=LOADER_MSG_IMG?>
</div>
<div id="uploader_doc_frm">
<table cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td colspan="2" height="20"></td>
</tr>	
<tr>
    <td  align="right"    class="blackbold" valign="top" width="30%"> Document Title :	</td>
    <td  align="left"  >
	
	<input name="DocumentTitle" type="text" class="inputbox" id="DocumentTitle" maxlength="40" onkeypress="return isAlphaKey(event);">&nbsp;		</td>
  </tr>
  
  <tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Document  :	</td>
    <td  align="left"  >
	
	<input name="Document" type="file" class="inputbox" id="Document" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">

<?=$SupportedDoc?>

		</td>
  </tr>
	

<tr>
  <td  align="right"    class="blackbold" valign="top">&nbsp;</td>
  <td  align="left"  ><input name="SbButton" type="submit" class="button" id="SbButton" value="Submit &raquo;"  />
  
  <input type="hidden" name="tab" value="image" />
    <input type="hidden" name="DocType" id="DocType" value="<?=$DocType?>" />

  </td>
</tr>	
  </table>
	</div>


	</form>
</div>	

<script language="JavaScript1.2" type="text/javascript">
function validate_upload_doc(frm){
	if( ValidateForSimpleBlank(frm.DocumentTitle, "Document Title")
	){
		if(document.getElementById("DocType").value=="Image"){
			if(!ValidateMandImage(frm.Document, "Document")){
				return false;	
			}
		}else if(document.getElementById("DocType").value=="Scan"){
			if(!ValidateMandScan(frm.Document, "Document")){
				return false;	
			}

		}else{
			if(!ValidateMandDoc(frm.Document, "Document")){
				return false;	
			}

		}

		document.getElementById("uploader_doc_frm").style.display= 'none'; 
		document.getElementById("docuploader_msg").style.display= 'block'; 
		return true;	
	}else{ 
		return false;	
	}	
}
</script>

