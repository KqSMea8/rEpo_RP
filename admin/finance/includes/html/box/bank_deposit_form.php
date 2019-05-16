<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
    if(frm.AccountID.value == "")
     {
	  alert("Please Select Account");
	  frm.AccountID.focus();
	  return false;
    }
    else if(frm.Amount.value == "" || frm.Amount.value == 0)
     {
	  alert("Please Enter Amount");
	  frm.Amount.focus();
	  return false;
    }
    else if(frm.Method.value == "")
     {
	alert("Please Select Payment Method");
	frm.Method.focus();
	return false;
     }
     else{	 
	  ShowHideLoader('1','S');
	  return true;
	}

   }
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
	<td  align="right"   class="blackbold"  width="45%"> Account Name :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="AccountID" class="inputbox" id="AccountID">
		  	<option value="">--- Select ---</option>
			<?php for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>">
			 <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> - (<?=$arryBankAccount[$i]['AccountType']?>)</option>
				<? } ?>
		</select> 
	</td>
	</tr>	
	
	 <tr>
        <td align="right"   class="blackbold"> Amount : <span class="red">*</span></td>
        <td align="left">
	<input name="Amount" type="text" class="inputbox" id="Amount" onkeypress="return isNumberKey(event);" value="0.00"  />
		   
		</td>
     </tr>
	
	<tr>
		<td  align="right"   class="blackbold"> Date  :<span class="red">*</span> </td>
		<script type="text/javascript">
			$(function() {
			$('#DepositDate').datepicker(
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
		<? 	
			$arryTime = explode(" ",$Config['TodayDate']);
			 
		?>
		 <input id="DepositDate" name="DepositDate" readonly="" class="datebox" value="<?=$arryTime[0]?>"  type="text" > 
		</td>
	</tr>	
	
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Received From : </td>
	<td   align="left" >
	 <select name="ReceivedFrom" class="inputbox" id="ReceivedFrom">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			 <option value="<?=$arryCustomer[$i]['Cid']?>">
			 <?=stripslashes(ucfirst($arryCustomer[$i]["FirstName"])." ".ucfirst($arryCustomer[$i]["LastName"]))?></option>
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
        <td  align="right"   class="blackbold">Reference No#  : </td>
        <td   align="left">
		 <input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value=""  />
		</td>
    </tr>
	 <tr>
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment"></textarea></td>
	</tr>
	 
</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
	</td>
	</tr>
 </form>
</table>

