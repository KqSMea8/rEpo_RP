<script language="JavaScript1.2" type="text/javascript">
function validate_auth_form(frm){ 
	$("#msgauthdiv").html("&nbsp;");
	var AmountToCharge = parseFloat(document.getElementById("AmountToCharge").value);  
	var AmountToChargeMax = parseFloat(document.getElementById("AmountToChargeMax").value);
	if(Trim(document.getElementById("AmountToCharge")).value <= 0 ){ 	
			$("#msgauthdiv").html('Please Enter Amount.');		
			return false;
		}else if(AmountToCharge > AmountToChargeMax){	 	
			$("#msgauthdiv").html('Authorize Amount should not exceed '+AmountToChargeMax+'.');		
			return false;
		}else{
			$.fancybox.close();
			ShowHideLoader('1','P');
			return true;
		}

}
</script>
<div id="authorize_card_div" style="display:none;width:400px;">
<form name="formConvert" action="<?=$AuthorizeCardUrl?>" method="post"  enctype="multipart/form-data" onSubmit="return validate_auth_form(this);">
<TABLE width="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	<td height="20" class="ui-dialog-titlebar had">
	Authorize Credit Card
	</td >
	</tr>
	<tr>
	<td height="20">
	<div id="msgauthdiv" class="redmsg" align="center"> </div>
	</td >
	</tr>
	<tr> 
	<td >
		<table width="100%" border="0" cellpadding="5" cellspacing="1" align="center" bgcolor="#FFFFFF" class="borderall">
		<tr>
		<td align="right"   class="blackbold" valign="top">Authorize Amount :</td>
		<td  align="left" >

		<input name="AmountToCharge" type="text" class="datebox" id="AmountToCharge" value="<?=$AmountToCharge?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('msgauthdiv'); Javascript: return isDecimalKey(event);"  />
		<?=$arryInvoice[0]['CustomerCurrency']?>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	 
	<tr>
	<td align="center" valign="top">
	<input name="AuthCardSubmit" type="submit" class="button" value=" Submit " />
	<input type="hidden" name="AmountToChargeMax" id="AmountToChargeMax" value="<?=$AmountToCharge?>" />
	</td>
	</tr>
	<tr>
	<td height="20">
	</td >
	</tr>
</TABLE>
</form>
</div>
