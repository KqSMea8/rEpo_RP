<script language="JavaScript1.2" type="text/javascript">
function validateTransfer(frm){
  var DataExist=0;
  
	if(ValidateForSelect(frm.TransferFrom, "Transfer From")
	    && ValidateForSelect(frm.TransferTo, "Transfer To")
		){
		   if(document.getElementById('TransferAmount').value == "" || document.getElementById('TransferAmount').value=="0.00"){
		   
			alert("Amount cannot be 0");
			document.getElementById('TransferAmount').focus();
			return false;
		   }
		   
			var TransferFrom = document.getElementById('TransferFrom').value;
			var TransferTo = document.getElementById('TransferTo').value;

			if(TransferFrom == TransferTo)
			{
				alert("Please Select Different Account to Processed.");
				document.getElementById('TransferTo').focus();
				return false
			}
		  	
			 
			 
		}else{
		  
			return false;	
		}
		
		ShowHideLoader('1','S');
	
}

$(document).ready(function(){

 $("#TransferFrom").change(function() {
  
     var PaidFrom = $("#TransferFrom").val();
	/* var PaidTo = $("#TransferTo").val();
	 
	 if(PaidFrom == PaidTo)
	 {
		alert("Please Select Different Account to Processed.");
		$("#TransferTo").focus();
		return false
	 }else{
		return true;
	 }
	 
     });*/

 var data = 'AccountID=' + PaidFrom +'&action=checkBalance';
	 if(PaidFrom != "")
                    {
			$.ajax({
			type: "GET",
			url: "ajax.php",
			data: data,
			success: function (msg) {
				$("#balanceFrom").show(1000);	
				 $("#balanceFrom").html(msg);

				}
			});

                   }
	});

 $("#TransferTo").change(function() {
  
       var TransferTo = $("#TransferTo").val();
       var data = 'AccountID=' + TransferTo +'&action=checkBalance';
	 if(TransferTo != "")
                    {
			$.ajax({
			type: "GET",
			url: "ajax.php",
			data: data,
			success: function (msg) {
				$("#balanceTo").show(1000);	
				 $("#balanceTo").html(msg);

				}
			});

                   }
	});

});	
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateTransfer(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Transfer From :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="TransferFrom" class="inputbox" id="TransferFrom">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>">
			<?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> - (<?=$arryBankAccount[$i]['AccountType']?>)
			</option>
				<? } ?>
		</select>&nbsp;&nbsp;&nbsp;<span id="balanceFrom" style="display:none;"></span> 

		
	</td>
	</tr>	
	<tr>
	<td  align="right"   class="blackbold"> Transfer To  :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="TransferTo" class="inputbox" id="TransferTo">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>">
			<?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> - (<?=$arryBankAccount[$i]['AccountType']?>)
			</option>
				<? } ?>
		</select>&nbsp;&nbsp;&nbsp;<span id="balanceTo" style="display:none;"></span> 
	</td>
	</tr>	  
	<tr>
		<td  align="right"   class="blackbold"> Transfer Amount  :<span class="red">*</span> </td>
		<td   align="left" >
		<input name="TransferAmount" type="text" class="inputbox" style="width:90px;" id="TransferAmount" onkeypress="return isNumberKey(event);" value="0.00"  /><?=$Config['Currency'];?>
		</td>
	</tr>	
	<tr>
		<td  align="right"   class="blackbold"> Transfer Date  :<span class="red">*</span> </td>
		<script type="text/javascript">
			$(function() {
			$('#TransferDate').datepicker(
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
		 <input id="TransferDate" name="TransferDate" readonly="" class="datebox" value="<?=$arryTime[0]?>"  type="text" > 
		</td>
	</tr>	
	
	<tr>
		<td align="right" class="blackbold">Ref :</td>
		<td  align="left">
		<input type="text" name="ReferenceNo" maxlength="30"  class="inputbox" id="ReferenceNo" value="">
		</td>
	</tr>	
	  
	 
</table>	
  </td>
 </tr>

	<tr>
	<td  align="center">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Save"  />
	</td>
	</tr>
 </form>
</table>
