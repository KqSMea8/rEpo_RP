<script language="JavaScript1.2" type="text/javascript">
function ResetDiv(){
	$("#prv_msg_div").show();
	$("#preview_div").hide();	
}

function validateBank(frm){
	if( ValidateForSimpleBlank(frm.BankName, "Bank Name")
	&& ValidateForSimpleBlank(frm.AccountName, "Account Name")
	&& ValidateForSimpleBlank(frm.AccountNumber,"Account Number")
	&& ValidateForSimpleBlank(frm.RoutingNumber,"Routing Number")
	){
		ResetDiv();		
		return true;	
	}else{
		return false;	
	}	
}

</script>

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:300px;" >

<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">
<? echo $PageAction." Bank Detail"; ?>   </div>


<form name="formContact" action=""  method="post" onSubmit="return validateBank(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" class="borderall">


			<tr>
				<td align="right" class="blackbold" width="45%">Bank Name :<span
					class="red">*</span></td>
				<td align="left"><input type="text" name="BankName" maxlength="40"
					class="inputbox" id="BankName"
					value="<?=stripslashes($arryBank[0]['BankName'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Account Name :<span class="red">*</span>
				</td>
				<td align="left"><input type="text" name="AccountName"
					maxlength="50" class="inputbox" id="AccountName"
					value="<?=stripslashes($arryBank[0]['AccountName'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Account Number :<span
					class="red">*</span></td>
				<td align="left"><input type="text" name="AccountNumber"
					maxlength="30" class="inputbox" id="AccountNumber"
					value="<?=stripslashes($arryBank[0]['AccountNumber'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Routing Number :<span
					class="red">*</span></td>
				<td align="left"><input type="text" name="RoutingNumber" maxlength="30"
					class="inputbox" id="RoutingNumber"
					value="<?=stripslashes($arryBank[0]['RoutingNumber'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Swift Code : </td>
				<td align="left"><input type="text" name="SwiftCode" maxlength="30"
					class="inputbox" id="SwiftCode"
					value="<?=stripslashes($arryBank[0]['SwiftCode'])?>"
					onKeyPress="Javascript:return isAlphaKey(event);"></td>
			</tr>

			<!--tr>
				<td  align="right"   class="blackbold" 
			>Default Account : </td>
				<td   align="left"  >
				  <? 
			   $ActiveChecked = ' checked';
			if($_GET['edit'] > 0){
			 	if($arryBank[0]['DefaultAccount'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
			 	if($arryBank[0]['DefaultAccount'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
			  ?>
				  <label><input type="radio" name="DefaultAccount" id="DefaultAccount" value="1" <?=$ActiveChecked?> />
				  Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="radio" name="DefaultAccount" id="DefaultAccount" value="0" <?=$InActiveChecked?> />
				  No</label> </td>
			      </tr-->	


        

</table>		
	
	</td>
	
  </tr>

	<tr>
    <td align="center">
<input type="Submit" class="button" name="Submit" id="Submit" value="<?=$ButtonAction?>" >
<input type="hidden" name="SuppID" id="SuppID" value="<?=$_GET['SuppID']?>" />
<input type="hidden" name="BankID" id="BankID" value="<?=$_GET['edit']?>" />


</td>	
  </tr>


</table>
</form>
</div>


<? } ?>
