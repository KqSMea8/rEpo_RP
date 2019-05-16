<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
    
if(frm.PaidTo.value == "")
     {
		  alert("Please Select Vendor.");
		  frm.PaidTo.focus();
		  return false;
    }
 if(frm.ExpenseTypeID.value == "")
     {
		  alert("Please Select GL Account.");
		  frm.ExpenseTypeID.focus();
		  return false;
	 }
 else if(frm.PaymentMethod.value == "")
     {
		  alert("Please Select Payment Method.");
		  frm.PaymentMethod.focus();
		  return false;
	 }
        else if(frm.PaymentDate.value == "")
        {
		  alert("Please Select Payment Date.");
		  frm.PaymentDate.focus();
		  return false;
	 }
         
          //CODE FOR PERIOD END SETTING
        var BackFlag = 0;
        var PaymentDate = Trim(document.getElementById("PaymentDate")).value;
        var CurrentPeriodDate = Trim(document.getElementById("CurrentPeriodDate")).value;
        var CurrentPeriodMsg = Trim(document.getElementById("CurrentPeriodMsg")).value;
        var strBackDate = Trim(document.getElementById("strBackDate")).value;
        var strSplitBackDate = strBackDate.split(",");
        var backDateLength = strSplitBackDate.length;
        
        var spliPDate = PaymentDate.split("-");
        var StrspliPDate = spliPDate[0]+"-"+spliPDate[1];
        
        
        for(var bk=0;bk<backDateLength;bk++)
            {
                if(strSplitBackDate[bk] == StrspliPDate)
                    {
                        BackFlag = 1;
                        break;
                    }
               
            }
        
        
        var CurrentPeriodDate = Date.parse(CurrentPeriodDate);
        var PDate = Date.parse(PaymentDate);
       
        if(PDate < CurrentPeriodDate && BackFlag == 0) 
            {
                alert("Sorry! You Can Not Enter Back Date Entry.\n"+CurrentPeriodMsg+".");
                document.getElementById("PaymentDate").focus();
		return false;
            }
            
          //END PERIOD SETTING  
	 else if(frm.BankAccount.value == "")
         {
		  alert("Please Select Account.");
		  frm.BankAccount.focus();
		  return false;
	 }else if(frm.Amount.value == "" || frm.Amount.value == 0)
         {
		  alert("Please Enter Amount.");
		  frm.Amount.focus();
		  return false;
	 }else if(frm.InvoiceID.value != ''){
			var Url = "isRecordExists.php?InvoiceID="+escape(frm.InvoiceID.value);
                        //alert(Url);return false;
			SendExistRequest(Url,InvoiceID, "InvoiceID");
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
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left">
		 <input name="InvoiceID" type="text" class="datebox" id="InvoiceID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_InvoiceID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_InvoiceID','InvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
		 &nbsp;&nbsp;<span id="MsgSpan_InvoiceID"></span>
		</td>
     </tr>	
     
        <tr>
	<td  align="right"   class="blackbold"  width="45%">Pay to Vendor : <span class="red">*</span></td>
	<td   align="left" >
	 <select name="PaidTo" class="inputbox" id="PaidTo">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arrySupplier);$i++) {?>
			 <option value="<?=$arrySupplier[$i]['SuppCode']?>" <?php if($arryOtherExpense[0]['PaidTo'] == $arrySupplier[$i]['SuppCode']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arrySupplier[$i]["CompanyName"]))?></option>
				<? } ?>
		</select> 
	</td>
	</tr>	
	<tr>
		<td  align="right" class="blackbold">GL Account : <span class="red">*</span></td>
		<td  align="left">
	<select name="ExpenseTypeID" class="inputbox" id="ExpenseTypeID">
	<option value="">&nbsp;--- Select ---</option>
	<? for($i=0;$i<sizeof($arryExpenseType);$i++) {?>
	<option value="<?=$arryExpenseType[$i]['BankAccountID']?>" <?php if($arryOtherExpense[0]['ExpenseTypeID'] == $arryExpenseType[$i]['BankAccountID']){echo "selected";}?>>
	&nbsp;<?=$arryExpenseType[$i]['AccountName']?> - (<?=$arryExpenseType[$i]['Type']?>)
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
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?php if($arryOtherExpense[0]['PaymentMethod'] == $arryPaymentMethod[$i]['attribute_value']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
	</tr>  
	
	<tr>
		<td  align="right"   class="blackbold">Payment Date  :<span class="red">*</span> </td>
		
		<td   align="left" >
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
		<?php 	
			
			if(!empty($arryOtherExpense[0]['PaymentDate'])){
				$paymentDate = $arryOtherExpense[0]['PaymentDate'];
			}else{
			 $arryTime = explode(" ",$Config['TodayDate']);
			 $paymentDate = $arryTime[0];
			}
			 
		?>
		 <input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$paymentDate;?>"  type="text" > 
                 
                 <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $IECurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>
		</td>
	</tr>	
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Paid From A/C :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="BankAccount" class="inputbox" id="BankAccount">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?php if($arryOtherExpense[0]['BankAccount'] == $arryBankAccount[$i]['BankAccountID']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> - <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountType']))?></option>
				<? } ?>
		</select> 
	</td>
	</tr>	
	
	 <tr>
        <td align="right"   class="blackbold"> Amount : <span class="red">*</span></td>
        <td align="left">
		<?php if(!empty($arryOtherExpense[0]['Amount'])){$Amnt = $arryOtherExpense[0]['Amount'];}else{$Amnt = "0.00";}?>
    	<input name="Amount" type="text" class="textbox" id="Amount" onkeypress="return isDecimalKey(event);" value="<?=$Amnt;?>"  /><?=$Config['Currency'];?>
		   
		</td>
     </tr>
	 
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Tax Rate : </td>
	<td   align="left" >
	 <select name="TaxRateDesc" class="inputbox" id="TaxRateDesc">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryTax);$i++) {?>
			<option value="<?=$arryTax[$i]['RateId'].':'.$arryTax[$i]['TaxRate']?>" <?php if($arryOtherExpense[0]['TaxID'] == $arryTax[$i]['RateId']){echo "selected";}?>>
			<?=$arryTax[$i]['RateDescription'].' : '.$arryTax[$i]['TaxRate']?>
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
		<?php if(!empty($arryOtherExpense[0]['TotalAmount'])){$TotalAmnt = $arryOtherExpense[0]['TotalAmount'];}else{$TotalAmnt = "0.00";}?>
    	<input name="TotalAmount" type="text" readonly="" class="disabled" id="TotalAmount" onkeypress="return isDecimalKey(event);" value="<?=$TotalAmnt;?>"  /><?=$Config['Currency'];?>
		</td>
     </tr>
	
   <tr>
        <td  align="right"   class="blackbold">Reference No#  : </td>
        <td   align="left">
		 <input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value="<?=$arryOtherExpense[0]['ReferenceNo']?>"  />
		</td>
    </tr>
	 <tr>
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment"><?=$arryOtherExpense[0]['Comment']?></textarea></td>
	</tr>
	 
</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
	    <input type="hidden" name="ExpenseID" id="ExpenseID" value="<?=$_GET['edit'];?>">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="<?php if(!empty($_GET['edit'])){echo "Update";}else{echo "Submit";} ?>"  />
	</td>
	</tr>
 </form>
</table>

