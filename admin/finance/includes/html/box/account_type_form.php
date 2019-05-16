<script language="JavaScript1.2" type="text/javascript">
function validateAccount(frm){
  var DataExist=0;
  
	if(ValidateForSimpleBlank(frm.AccountType, "Account Type")){
	            ShowHideLoader('1','S');
		    return true;	
		
	}else{
		return false;	
	}

	
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	

	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Account Type :<span class="red">*</span> </td>
	<td   align="left" >
	<input type="text" name="AccountType" maxlength="40" class="inputbox" id="AccountType" value="<?=$arryAccountType[0]['AccountType'];?>">
	</td>
	</tr>	
	<tr>
	<td  align="right" class="blackbold" valign="top">Description : </td>
	<td  align="left">
	 <textarea id="Description" class="textarea" type="text" name="Description"><?=$arryAccountType[0]['Description'];?></textarea>
	</td>
	</tr>	  
	<tr>
		<td  align="right"   class="blackbold">Status  : </td>
		<td   align="left"  >
		<?php 
			$ActiveChecked = ' checked';
			if($arryAccountType[0]['Status'] == "Yes") {$ActiveChecked = ' checked'; $InActiveChecked ='';}
			if($arryAccountType[0]['Status'] == "No") {$ActiveChecked = ''; $InActiveChecked = ' checked';}

		?>
		<input type="radio" name="Status" id="Status" value="Yes" <?=$ActiveChecked?> />
		Active&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="Status" id="Status" value="No" <?=$InActiveChecked?> />
		InActive </td>
	</tr>
	 
	

</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
		 <input type="hidden" name="AccountTypeID" id="AccountTypeID"  value="<?=$_GET['edit'];?>" />
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
	</td>
	</tr>
 </form>
</table>

