


<? 
$Step1 = 'class=active';
require_once("includes/nav.php");
?>



<div class="message"><? if(!empty($_SESSION['mess_install_1'])) {echo $_SESSION['mess_install_1']; unset($_SESSION['mess_install_1']); }?></div>

<br><br><br>
		
<form name="form1" action="" method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">	
	<table width="70%" border="0" cellpadding="0" cellspacing="0" >       

	<tr>
	<td align="center" valign="top" >
	<table width="100%"  border="0" align="right" cellpadding="4" cellspacing="0" class="borderall">

	<tr>
	<td colspan="2" align="left" class="head">License Key Verification</td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	<td width="45%" align="right" valign="top"  class="blackbold">License Key :  </td>
	<td align="left" valign="middle">

	<textarea class="bigbox" name="LicenseKey" id="LicenseKey" maxlength="500"></textarea>

	</td>
	</tr>
	<tr>
	<td colspan="2" >&nbsp;</td>
	</tr>
	</table>

	</td>
	</tr>
	<tr>   						
	<td align="center">
	<input name="Submit" type="submit" value="Continue &raquo;" class="button" />				
	</td>
	</tr>
	</table>
</form>


<SCRIPT LANGUAGE=JAVASCRIPT>
function validateForm(frm){
	
	if(ValidateForTextareaMand(frm.LicenseKey,"License Key",50,250)	
	){  
		ShowHideLoader(1,'P');
		return true;	
			
	}else{
		return false;	
	}	
	
}
</SCRIPT>
