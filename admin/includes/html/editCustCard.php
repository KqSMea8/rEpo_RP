<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="JavaScript1.2" type="text/javascript">

function ResetDiv(){
	$("#prv_msg_div").show();
	$("#preview_div").hide();	
}

function validateCard(frm){
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

		DataExist = CheckExistingData("isRecordExists.php","&CustCardNumber="+escape(document.getElementById("CardNumber").value)+"&CustID="+document.getElementById("CustID").value+"&editID="+document.getElementById("CardID").value, "CardNumber","Card Number");
		if(DataExist==1)return false;


		ResetDiv();		
		return true;	
	}else{
		return false;	
	}	
}

</script>

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:550px;" >

<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">
<? echo $PageAction." Card Detail"; ?>   </div>


<form name="formContact" action=""  method="post" onSubmit="return validateCard(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left" valign="top">

<? require_once("includes/html/box/card_form.php"); ?>
		
	
	</td>
	
  </tr>

	<tr>
    <td align="center">
<input type="Submit" class="button" name="Submit" id="Submit" value="<?=$ButtonAction?>" >
<input type="hidden" name="CustID" id="CustID" value="<?=$_GET['CustID']?>" />
<input type="hidden" name="CardID" id="CardID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="">
<input type="hidden" name="OldDefaultCard" id="OldDefaultCard" value="<?=$arryCard[0]['DefaultCard']?>" />

</td>	
  </tr>


</table>
</form>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
  StateListSend();
</SCRIPT>

<? } ?>
