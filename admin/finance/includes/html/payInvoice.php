
<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="JavaScript1.2" type="text/javascript">

function ShowLoader(){
	$("#prv_msg_div").show();
	$("#preview_div").hide();	
}

function HideLoader(){
	$("#prv_msg_div").hide();
	$("#preview_div").show();	
}


function processCard(){
	var ReturnFlag = CheckAmountToCharge();
	if(!ReturnFlag){
		return false;
	}

	ShowLoader();
	return true;
}

function validate_auth_form(frm){ 
	$("#msgdiv").html("&nbsp;");
	var AmountToCharge = parseFloat(document.getElementById("AmountToCharge").value);  
	var AmountToChargeMax = parseFloat(document.getElementById("AmountToChargeMax").value);
	if(Trim(document.getElementById("AmountToCharge")).value <= 0 ){ 	
		$("#msgdiv").html('Please Enter Amount.');		
		return false;
	}else if(AmountToCharge > AmountToChargeMax){	 	
		$("#msgdiv").html('Authorize Amount should not exceed '+AmountToChargeMax+'.');		
		return false;
	}else{
		ShowLoader();		
		return true;
	}

} 

function CheckAmountToCharge(){
	$("#msgdiv").html("&nbsp;");
	var AmountToCharge = parseFloat(document.getElementById("AmountToCharge").value);  
	var AmountToChargeMax = parseFloat(document.getElementById("AmountToChargeMax").value);
	if(Trim(document.getElementById("AmountToCharge")).value <= 0 ){ 	
		$("#msgdiv").html('Please Enter Amount.');		
		return false;
	}else if(AmountToCharge > AmountToChargeMax){	 	
		$("#msgdiv").html('Authorize Amount should not exceed '+AmountToChargeMax+'.');		
		return false;
	}else{
		return true;
	}

   
}


function validateCard(){

	var ReturnFlag = CheckAmountToCharge();
	if(!ReturnFlag){
		return false;
	}
	
	var frm = document.forms[0];
	 	
	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	var DataExist=0;
	if(window.parent.document.getElementById("CurrentDivision") != null){
  		document.getElementById("CurrentDivision").value = window.parent.document.getElementById("CurrentDivision").value;
	}

	if( ValidateForSelect(frm.CardType, "Card Type")
	&& ValidateForSimpleBlank(frm.CardNumber, "Card Number")
	&& ValidateForSelect(frm.ExpiryMonth, "Card Expiry Month")
	&& ValidateForSelect(frm.ExpiryYear, "Card Expiry Year")
	&& ValidateForSimpleBlank(frm.securityCode, "Security Code of 4 digit for Amex,3 for others")
	&& ValidateForSimpleBlank(frm.CardHolderName,"Card Holder Name")
	&& ValidateForSimpleBlank(frm.ZipCode,"Zip Code")
	){
		
		ShowLoader();
		var CardNumber = $('#CardNumber').val();	
		var CardType = $('#CardType').val(); 
		var arryCard = CardNumber.split("-");
		var CardNumberTemp = '';
		if(CardType=="Amex"){
			CardNumberTemp = 'xxxx-xxxxxx-'+arryCard[2];
		}else{
			CardNumberTemp = 'xxxx-xxxx-xxxx-'+arryCard[3];
		}

		var SendUrl = "&action=CreditCardInfoPost&country_id="+escape($('#country_id').val())+"&state_id="+escape($('#main_state_id').val())+"&OtherState="+escape($('#OtherState').val())+"&city_id="+escape($('#main_city_id').val())+"&OtherCity="+escape($('#OtherCity').val())+"&r="+Math.random();
		 

	   	$.ajax({
		type: "GET",
		url: "../ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText){			 			
			$("#CreditCardID").val('');	 
			$("#CreditCardType").val(CardType);	 
	 		$("#CreditCardNumber").val(CardNumber);
			$("#CreditCardNumberTemp").val(CardNumberTemp);
			$("#CreditExpiryMonth").val(frm.ExpiryMonth.value);	 
			$("#CreditExpiryYear").val(frm.ExpiryYear.value);	 
	 		$("#CreditSecurityCode").val(frm.securityCode.value);
			$("#CreditCardHolderName").val(frm.CardHolderName.value);
			$("#CreditAddress").val(frm.Address.value);		
			$("#CreditZipCode").val(frm.ZipCode.value);
		 		
			$("#CreditCountry").val(responseText["CountryCode"]);
			$("#CreditState").val(responseText["State"]);
			$("#CreditCity").val(responseText["City"]);	

			$("#CreditCardInfo").show();		
			$(".CreditCardAdd").hide();	 			
			$(".ConfirmButton").show();
			HideLoader();
			return false;				   
		}
		});
			
					
		return false;	
	}else{
		return false;	
	}	
}

</script>
<div class="had">Credit Card Payment</div>
<div class="message" align="center"><?php
if (!empty($_SESSION['mess_pay'])) {
    echo $_SESSION['mess_pay'];
    unset($_SESSION['mess_pay']);
}
?></div>
		
	  <?	if(!empty($ErrorMSG)){	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';}else{?>
	


<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:650px;" >

 <?	if(!empty($ResposeMSG)){	echo '<div class="message" align="center">'.$ResposeMSG.'</div>';} ?>
<form name="formCard" action=""  method="post"  enctype="multipart/form-data">

		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
		 
		<tr>
			 <td align="left">
                             
                                                    
                             <?php
                             
                                   include("includes/html/box/invoice_brief_view.php");
                                
                                ?>
                         
                         </td>
		</tr>

 

 <? if($AmountToCharge>0){?>
<tr>
	 <td align="right">
<a class="fancybox grey_bt fancybox.iframe" href="../selectCustCard.php?CustID=<?=$CustID?>">Select Existing Card</a>	
 
	 </td>
</tr>
<? } ?>		 


<tr class="CreditCardAdd">
	 <td align="right">
 	
<?php

   include("../includes/html/box/card_form.php");


(empty($TotalCharge))?($TotalCharge=""):(""); 
?> 
	 </td>
</tr>


<tr class="CreditCardAdd">
    <td align="center">
 <? if($AmountToCharge>0){?>
<input type="Submit" class="button" name="Submit" id="Submit" value="Continue &raquo;" onClick="return validateCard();">
<? } ?>
<input type="hidden" name="CustID" id="CustID" value="<?=$CustID?>" />
<input type="hidden" name="CardID" id="CardID" value="" />
<input type="hidden" name="OrderID" id="OrderID" value="<?=$OrderID?>" />
<input type="hidden" name="TotalCharge" id="TotalCharge" value="<?=$TotalCharge?>" /> 
</td>	
  </tr>

</table>

 

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
 <td align="left">
<? if($AmountToCharge>0){?>
<a href="#" onClick="javascript: SetDefault();" class="back ConfirmButton"  style="display:none">Back</a>
<? } ?>
<br>
<? $BoxPrefix = '../sales/'; include($BoxPrefix."includes/html/box/sale_card.php");?>


</td>	
  </tr>

<tr class="ConfirmButton" style="display:none">
    <td align="center">
  <? if($AmountToCharge>0){?>
<input type="Submit" class="button" name="Confirm" id="ConfirmPayment" value="Confirm Payment" onClick="return processCard();">
<? } ?>

</td>	
  </tr>



</table>

</form>





</div>


<SCRIPT LANGUAGE=JAVASCRIPT>

function SetDefault(){
	$("#CreditCardInfo").hide();		
	$(".CreditCardAdd").show();	 			
	$(".ConfirmButton").hide();	 
}


function SelectCreditCard(){
	var CreditCardNumber = $('#CreditCardNumber').val();	
	var CreditCardType = $('#CreditCardType').val();
	var TotalCharge = $('#TotalCharge').val();
	if(TotalCharge>0){
		$("#CreditCardInfo").show();			
		$(".CreditCardAdd").hide();	 			
		$(".ConfirmButton").hide();
		$(".grey_bt").hide();
		
	}else if(CreditCardType!='' && CreditCardNumber!=''){
		$("#CreditCardInfo").show();	
		$(".CreditCardAdd").hide();	 			
		$(".ConfirmButton").show();
	}else{
		$('#CreditCardInfo').hide();
	
	}

 
}

  StateListSend();
  SelectCreditCard();
</SCRIPT>
<? } ?>


