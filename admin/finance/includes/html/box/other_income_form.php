<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

 if(frm.IncomeTypeID.value == "")
     {
		  alert("Please Select Income Type");
		  frm.IncomeTypeID.focus();
		  return false;
	 }
 else if(frm.PaymentMethod.value == "")
     {
		  alert("Please Select Payment Method");
		  frm.PaymentMethod.focus();
		  return false;
	 }
else if(frm.PaymentDate.value == "")
     {
		  alert("Please Select Payment Date");
		  frm.PaymentDate.focus();
		  return false;
	 }
	 else if(frm.BankAccount.value == "")
     {
		  alert("Please Select Account");
		  frm.BankAccount.focus();
		  return false;
	 }else if(frm.Amount.value == "" || frm.Amount.value == 0)
     {
		  alert("Please Enter Amount");
		  frm.Amount.focus();
		  return false;
	 }else if(frm.TaxRate.value == "")
     {
		  alert("Please Select Tax Rate");
		  frm.TaxRate.focus();
		  return false;
	 }else{
		 
	     ShowHideLoader('1','S');
		 return true;
	 }

		
}

	/*******************************************************************************/
	   $(document).ready(function(){
		var TaxRateVal = $("#TaxRateDesc").val();
		var TaxRateSplit = TaxRateVal.split(":");
		$("#TaxID").val(TaxRateSplit[0]);
		$("#TaxRate").val(TaxRateSplit[1]);
		var Amount = $("#Amount").val();
		if(TaxRateSplit[0] > 0 && Amount >0){
		 $("#totalAmnt").show(1000);
		 var TaxAmnt = Math.round(Amount*TaxRateSplit[1])/100;
		 var TotalAmntVal = parseFloat(Amount)+parseFloat(TaxAmnt);
		 $("#TotalAmount").val(TotalAmntVal);
		
		}
	});	 
	/**********************************************************************************/
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	
      <tr>
		<td  align="right" class="blackbold">Type of Income : <span class="red">*</span></td>
		<td  align="left">
		  <select name="IncomeTypeID" class="inputbox" id="IncomeTypeID">
			<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryIncomeType);$i++) {?>
					<option value="<?=$arryIncomeType[$i]['BankAccountID']?>" <?php if($arryOtherIncome[0]['IncomeTypeID'] == $arryIncomeType[$i]['BankAccountID']){echo "selected";}?>>
					<?=$arryIncomeType[$i]['AccountName']?>
			</option>
				<? } ?>
		</select> 
		</td>
	</tr>  
	<tr>
		<td  align="right" class="blackbold">Payment Method : <span class="red">*</span></td>
		<td   align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
			<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?php if($arryOtherIncome[0]['PaymentMethod'] == $arryPaymentMethod[$i]['attribute_value']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
	</tr>  
	
	<tr>
		<td  align="right"   class="blackbold">Payment Date  :<span class="red">*</span> </td>
		<script type="text/javascript">
			$(function() {
			$('#PaymentDate').datepicker(
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
		<td   align="left" >
		<?php 	
			
			if(!empty($arryOtherIncome[0]['PaymentDate'])){
				$paymentDate = $arryOtherIncome[0]['PaymentDate'];
			}else{
			 $arryTime = explode(" ",$Config['TodayDate']);
			 $paymentDate = $arryTime[0];
			}
			 
		?>
		 <input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$paymentDate;?>"  type="text" > 
		</td>
	</tr>	
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Paid To A/C :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="BankAccount" class="inputbox" id="BankAccount">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?php if($arryOtherIncome[0]['BankAccount'] == $arryBankAccount[$i]['BankAccountID']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> - (<?=$arryBankAccount[$i]['AccountType']?>)</option>
				<? } ?>
		</select> 
	</td>
	</tr>	
	
	 <tr>
        <td align="right"   class="blackbold"> Amount : <span class="red">*</span></td>
        <td align="left">
		<?php if(!empty($arryOtherIncome[0]['Amount'])){$Amnt = $arryOtherIncome[0]['Amount'];}else{$Amnt = "0.00";}?>
    	<input name="Amount" type="text" class="textbox" id="Amount" onkeypress="return isDecimalKey(event);" value="<?=$Amnt;?>"  /><?=$Config['Currency'];?>
		   
		</td>
     </tr>
	 
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Tax Rate :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="TaxRateDesc" class="inputbox" id="TaxRateDesc">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryTax);$i++) {?>
			<option value="<?=$arryTax[$i]['TaxID'].':'.$arryTax[$i]['TaxRate']?>" <?php if($arryOtherIncome[0]['TaxID'] == $arryTax[$i]['TaxID']){echo "selected";}?>>
			<?=$arryTax[$i]['TaxName'].' : '.$arryTax[$i]['TaxRate']?>
			</option>
			<? } ?>		
		</select> 
		<input type="hidden" name="TaxID" id="TaxID" value="">
		<input type="hidden" name="TaxRate" id="TaxRate" value="">
	</td>
	</tr>	
	 <tr id="totalAmnt" style="display:none;">
        <td align="right" class="blackbold">Total Amount : <span class="red">*</span></td>
        <td align="left">
		<?php if(!empty($arryOtherIncome[0]['TotalAmount'])){$TotalAmnt = $arryOtherIncome[0]['TotalAmount'];}else{$TotalAmnt = "0.00";}?>
    	<input name="TotalAmount" type="text" readonly="" class="disabled" id="TotalAmount" onkeypress="return isDecimalKey(event);" value="<?=$TotalAmnt;?>"  /><?=$Config['Currency'];?>
		</td>
     </tr>
	
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Received From(Customer) : </td>
	<td   align="left" >
	 <select name="ReceivedFrom" class="inputbox" id="ReceivedFrom">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			 <option value="<?=$arryCustomer[$i]['Cid']?>" <?php if($arryOtherIncome[0]['ReceivedFrom'] == $arryCustomer[$i]['Cid']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arryCustomer[$i]["FirstName"])." ".ucfirst($arryCustomer[$i]["LastName"]))?></option>
				<? } ?>
		</select> 
	</td>
	</tr>	
	 
  
   <tr>
        <td  align="right"   class="blackbold">Reference No#  : </td>
        <td   align="left">
		 <input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value="<?=$arryOtherIncome[0]['ReferenceNo']?>"  />
		</td>
    </tr>
	 <tr>
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment"><?=$arryOtherIncome[0]['Comment']?></textarea></td>
	</tr>
	 
</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
	    <input type="hidden" name="IncomeID" id="IncomeID" value="<?=$_GET['edit'];?>">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="<?php if(!empty($_GET['edit'])){echo "Update";}else{echo "Submit";} ?>"  />
	</td>
	</tr>
 </form>
</table>

