<div id="payInvoice_div" style="display:none; width: 100%; height: 280px;">
<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	var ReceivedAmount = frm.ReceivedAmount.value;
	var TotalPaidAmount = frm.TotalPaidAmount.value;

	if(frm.ReceivedAmount.value == "" || frm.ReceivedAmount.value == 0)
     {
		  alert("Please Enter Paid Amount");
		  frm.ReceivedAmount.focus();
		  return false;
	 }
    else if(parseFloat(ReceivedAmount) > parseFloat(TotalPaidAmount)){
		alert("Please Pay Only "+TotalPaidAmount);
		return false;

		}
  else if(frm.PaidTo.value == "")
     {
		  alert("Please Select Account");
		  frm.PaidTo.focus();
		  return false;
	 }else if(frm.Method.value == "")
          {
		  alert("Please Select Payment Method");
		  frm.Method.focus();
		  return false;
	 }
      else{
		 parent.jQuery.fancybox.close();
	         ShowHideLoader('1','P');
	 }

		
}
</script>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="2" align="left" class="head">Receive Invoice</td>
	</tr>	
	
	<tr>
	 <td align="left" valign="top">
	 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	
	<!-- <tr>
        <td  align="right"  class="blackbold">Customer Name : </td>
        <td  align="left">
			<input name="CustomerName" type="text" readonly="" class="inputbox disabled" id="CustomerName" value="<?php //echo stripslashes($arrySale[0]['CustomerName']); ?>"  />
			
		</td>-->
     </tr>
	 <tr>
        <td align="right"   class="blackbold">Paid Amount : <span class="red">*</span></td>
        <td align="left">
		  <input name="ReceivedAmount" type="text" class="inputbox" id="ReceivedAmount" onkeypress="return isDecimalKey(event);" value="<?=$remainInvoiceAmount;?>"  />
		   <input name="TotalPaidAmount" type="hidden" class="inputbox" id="TotalPaidAmount" value="<?=$remainInvoiceAmount;?>"  />
		</td>
     </tr>
	  </tr>
	 <tr>
        <td  align="right"  class="blackbold">Paid To : <span class="red">*</span></td>
        <td   align="left">
		
		
		   <select name="PaidTo" class="inputbox" id="PaidTo">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>">
			 <?=$arryBankAccount[$i]['AccountName']?>- (<?=$arryBankAccount[$i]['AccountType']?>)</option>
				<? } ?>
		</select> 
		
		</td>
     </tr>
	<tr>
        <td  align="right" class="blackbold">Payment Method : <span class="red">*</span></td>
        <td   align="left">
		  <select name="Method" class="inputbox" id="Method">
		  	<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>">
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
  </tr>
   <tr>
        <td  align="right"   class="blackbold">Difference Amount : </td>
        <td   align="left">
		 <div id="DiffAmount">0.00</div>
		</td>
     </tr>
	  <tr>
        <td colspan="2" align="right">
		 <b>All amounts stated in <?=$arrySale[0]['CustomerCurrency'];?></b>
		</td>
     </tr>
 
	</table>
	 
	 </td>
	 <td align="right" valign="top">
	 <table width="100%" border="0" cellpadding="5" style="height: 152px;"  cellspacing="0" class="borderall">
	<tr>
	 <td  align="right"   class="blackbold"> Date  : </td>
		<td   align="left" >

			<script type="text/javascript">
			$(function() {
			$('#Date').datepicker(
			{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

			}
			);
			});
			</script>

		<? 	
		$arryTime = explode(" ",$Config['TodayDate']);
		$Date = ($arrySale[0]['Date']>0)?($arrySale[0]['Date']):($arryTime[0]); 
		?>
		<input id="Date" name="Date" readonly="" class="datebox" value="<?=$Date?>"  type="text" > 

		</td>
	</tr>
	
	 <tr>
        <td  align="right"   class="blackbold">Reference No#  : </td>
        <td   align="left">
		 <input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value=""  />
		</td>
    </tr>
	 <tr>
		<td valign="top" align="right" class="blackbold">Payment Comment :</td>
		<td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment"></textarea></td>
	</tr>
	
	
	</table>
	 
	 </td>
	</tr>
	 
	 
	<tr>
	<td  colspan="2" valign="top" style="padding-left:208px;">
		<input type="hidden" name="OrderID" id="OrderID" value="<?php echo stripslashes($arrySale[0]['OrderID']); ?>" />
		<input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes" />
		<input name="CustID" type="hidden" id="CustID" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>"  />
		<input name="CustCode" type="hidden" id="CustCode" value="<?php echo stripslashes($arrySale[0]['CustCode']); ?>"  />
		<input name="InvoiceID" type="hidden" id="InvoiceID" value="<?php echo stripslashes($arrySale[0]['InvoiceID']); ?>"  />
		<input name="SaleID" type="hidden" id="SaleID" value="<?php echo stripslashes($arrySale[0]['SaleID']); ?>"  />
		<input name="Currency" type="hidden" id="Currency" value="<?=$arrySale[0]['CustomerCurrency'];?>"  />
		<input name="CustomerName" type="hidden" id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>"  />
		<input type="submit" value="Pay" id="SubmitButton" class="button" name="Submit">
	</td>
	</tr>
	</table>
 </form>
</div>
