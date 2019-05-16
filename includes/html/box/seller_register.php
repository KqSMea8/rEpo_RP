<?
	$arrayPaymentGateways = $objConfig->GetPaymentGateways();
	$arryCurrency = $objRegion->getCurrency('',1);

?>
<script language="JavaScript1.2" type="text/javascript">

function ShowDeliveryOptions(){
	for(var i=1;i<=document.getElementById('NumDeliveryOption').value;i++){
		document.getElementById("DeliveryOptionDiv"+i).style.display = 'none';
	}
	for(i=1;i<=document.getElementById('DeliveryOption').value;i++){
		document.getElementById("DeliveryOptionDiv"+i).style.display = 'inline';
	}
	
	
}

function ShowPayDiv(opt,fieldname){
	if(document.getElementById(fieldname).checked == true){
		document.getElementById("PaymentDiv"+opt).style.display = 'inline';
	}else{
		
		if(opt==3){
			if(document.getElementById('EftPayment').checked == true || document.getElementById('DepositPayment').checked == true){
				document.getElementById("PaymentDiv"+opt).style.display = 'inline';
			}else{
				document.getElementById("PaymentDiv"+opt).style.display = 'none';
			}
		}else{
			document.getElementById("PaymentDiv"+opt).style.display = 'none';
		}


	}
	

	/*
	document.getElementById("ShippingDiv").style.display = 'none';
	
	for(var i=1;i<=3;i++){
		if(document.getElementById("PaymentDiv"+i).style.display != 'none' ) {
			document.getElementById("ShippingDiv").style.display = 'inline';
		}
	}*/
	

}


function validateSeller(frm){

	var mmspobj=document.getElementById("ImageFrame");
	
	if (mmspobj.tagName=='IFRAME'){
		var myval=window.frames[0].document.getElementById("verifyHiddenIframe").value; 
		document.getElementById("verifyHidden").value=myval;
	}


	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	//if(frm.Website.value == 'http://')  frm.Website.value ='';

	var paymentSelected = 0;
	for(var i=1;i<=3;i++){
		if(document.getElementById("PaymentDiv"+i).style.display != 'none' ) {
			paymentSelected = 1;
			break;
		}
	}


	if( ValidateForBlank(frm.UserName, BLANK_USER_NAME , SPECIAL_CHAR_USER_NAME)
		&& isUserName(frm.UserName)
		&& ValidateMandRange(frm.UserName, 2,25,BLANK_USER_NAME,NUM_CHAR_USER_NAME)
		&& ValidateForEmail(frm.Email)
		&& isEmail(frm.Email)
		&& ValidateForPassword(frm.Password)
		&& ValidateMandRange(frm.Password, 5,15,BLANK_PASSWORD,NUM_CHAR_PASSWORD)
		&& ValidateForPasswordConfirm(frm.Password, frm.ConfirmPassword)
		&& ValidateForBlank(frm.FirstName, BLANK_FIRST_NAME, SPECIAL_CHAR_FIRST_NAME)
		&& ValidateForBlank(frm.LastName, BLANK_LAST_NAME, SPECIAL_CHAR_LAST_NAME)
		//&& ValidateIDNumber(frm.IDNumber,"ID Number")
		//&& isSkypeAddress(frm.SkypeAddress)
		&& ValidateForSimpleBlank(frm.Address,BLANK_ADDRESS)
		&& isPostCode(frm.PostCode)
		&& ValidateOptPhoneNumber(frm.LandlineNumber)
		&& ValidateMandMobileNumber(frm.Phone)
		&& ValidateOptFaxNumber(frm.Fax)
		&& ValidateForSimpleBlank(frm.CompanyName, BLANK_COMPANY_NAME)
		&& ValidateForBlankOpt(frm.ContactPerson, BLANK_CONTACT_PERSON_NAME , SPECIAL_CHAR_CONTACT_PERSON_NAME)
		&& ValidateOptContactNumber(frm.ContactNumber)
		&& ValidateOptionalUpload(frm.Image)
		&& ValidateOptionalUpload(frm.Banner)
		//&& ValidateForBlankOpt(frm.Position, BLANK_POSITION , SPECIAL_CHAR_POSITION)
		//&& ValidateOptNumField(frm.RegistrationNumber, "Registration Number")
		&& isEmailOpt(frm.AlternateEmail)
		//&& isValidLinkOpt(frm.Website,"Website")
		//&& ValidateOptNumField(frm.VatNumber, "Sales Tax Number")
		//&& ValidateOptDecimalField(frm.VatPercentage, NUM_VAT_PERCENTAGE,VALID_VAT_PERCENTAGE)
		//&& ValidateForBlank(frm.BillingFirstName, BLANK_BILLING_FIRST_NAME, SPECIAL_CHAR_FIRST_NAME)
		//&& ValidateForBlank(frm.BillingLastName, BLANK_BILLING_LAST_NAME, SPECIAL_CHAR_LAST_NAME)
		//&& ValidateForSimpleBlank(frm.BillingCompany, BLANK_COMPANY_NAME)
		//&& ValidateForSimpleBlank(frm.BillingAddress,BLANK_BILLING_ADDRESS)
		//&& ValidateOptPhoneNumber(frm.BillingLandline)
		//&& isEmailOpt(frm.BillingEmail)
	){
		
		if(document.getElementById('DeliveryOption').value>=1){
			for(var i=1;i<=document.getElementById('DeliveryOption').value;i++){
				if(!ValidateForSimpleBlank(document.getElementById('DeliveryName'+i),'Please Enter Delivery Option '+i+'.')){
					return false;
				}
				if(!ValidateMandDecimalField(document.getElementById('DeliveryFee'+i),'Please Enter Delivery Fee '+i+'.', 'Please Enter Valid Delivery Fee '+i+'.')){
					return false;
				}
			}
		}

	
		/*
		if(paymentSelected==0){
			alert(SELECT_PAYMENT_TYPE);
			return false;
		}*/

	
	  if(document.getElementById("PaymentDiv1").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.MyGate_MerchantID, BLANK_MERCHANT_ID)){
				return false;
			}
			
			if(!ValidateForSimpleBlank(frm.MyGate_ApplicationID, BLANK_APPLICATION_ID)){
				return false;
			}
			
		}
		
		
		if(document.getElementById("PaymentDiv2").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.PaypalID, BLANK_PAYPAL_ID)){
				return false;
			}
			
			if(!isEmail(frm.PaypalID)){
				return false;	
			}

		}


		if(document.getElementById("PaymentDiv3").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.AccountHolder, BLANK_ACCOUNT_HOLDER)){
				return false;
			}
			
			if(!ValidateMandNumField(frm.AccountNumber, BLANK_ACCOUNT_NUMBER, VALID_ACCOUNT_NUMBER)){
				return false;
			}
			
			if(!ValidateForSimpleBlank(frm.BankName,BLANK_BANK_NAME)){
				return false;	
			}

			if(!ValidateForSimpleBlank(frm.BranchCode,BLANK_BRANCH_CODE)){
				return false;	
			}

		}

		/*
		if(document.getElementById("ShippingDiv").style.display != 'none'){
			if(!ValidateOptDecimalField(frm.Shipping,"",VALID_SHIPPING)){
				return false;	
			}
		}*/
	
		/*
		if(!ValidateOptNumField(frm.AreaCode, "Area/Promotion Code")){
			return false;	
		}*/
	
		if(!ValidateForVerification(frm.verifyText,frm.verifyHidden)){
			return false;	
		}
		if(!ValidateCheckBox(frm.agree, AGREE_TO_TERMS)){
			return false;	
		}

	
	
		var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&UserName="+escape(document.getElementById("UserName").value)+"&Type="+document.getElementById("Type").value+"&editID="+document.getElementById("MemberID").value;
		SendMultipleExistRequest(Url,"UserName","User Name","Email","Email");	
		return false;	
	}else{
		return false;	
	}

}
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
      <td height="32" align="right" valign="top" class="generaltxt_inner">
          <?=MANDATORY_REGISTRATION?>
      </td>
    </tr>
  <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" onSubmit="return validateSeller(this);">
    <tr>
      <td class="graybox"><?=ACCOUNT_INFORMATION?></td>
    </tr>
	 
    <tr>
      <td height="105" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=USER_NAME?>
                      <span class="bluestar">*</span></td>
              <td  height="30" align="left" valign="middle"><input name="UserName" type="text" class="txtfield_normal"  id="UserName" value="<? echo stripslashes($arryMember[0]['UserName']); ?>"  maxlength="50" /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=EMAIL?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="Email" type="text" class="txtfield_normal"id="Email" value="<? echo $arryMember[0]['Email']; ?>"  maxlength="80"  /></td>
            </tr>
            <tr>
              <td colspan="2" height="30" valign="middle" class="generaltxt_inner">&nbsp;</td>
            </tr>
          </table></td>
          <td valign="top" width="50%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="30" width="40%" align="left" valign="middle" ><?=PASSWORD?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="Password" type="password" class="txtfield_normal"id="Password" value="<? echo stripslashes($arryMember[0]['Password']); ?>"  maxlength="15"  /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=CONFIRM_PASSWORD?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="ConfirmPassword" type="password" class="txtfield_normal" id="ConfirmPassword" value="<? echo stripslashes($arryMember[0]['Password']); ?>"  maxlength="15" /></td>
            </tr>
            <tr>
				<td>&nbsp;</td>
              <td height="30" valign="middle" align="left" ><?=PASSWORD_LIMIT?></td>
            </tr>
          </table></td>
        </tr>
      </table>
          </td>
    </tr>
    <tr>
      <td class="graybox"><?=PERSONAL_INFORMATION?>
      </td>
    </tr>
    <tr>
      <td height="84" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=FIRST_NAME?>
                      <span class="bluestar">*</span></td>
              <td  height="30" align="left" valign="middle"><input name="FirstName" type="text" class="txtfield_normal"id="FirstName" value="<? echo stripslashes($arryMember[0]['FirstName']); ?>"  maxlength="50"  /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=LAST_NAME?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="LastName" type="text" class="txtfield_normal" id="LastName" value="<? echo stripslashes($arryMember[0]['LastName']); ?>"  maxlength="50" /></td>
            </tr>
            <tr style="display:none">
              <td height="30" align="left" valign="middle" ><?=ID_NUMBER?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="IDNumber" type="text" class="txtfield_normal" id="IDNumber" value="<? echo stripslashes($arryMember[0]['IDNumber']); ?>"  maxlength="30" /></td>
            </tr>
			 <tr style="display:none">
              <td height="30" align="left" valign="middle" ><?=SKYPE_ADDRESS?>
                      </td>
              <td height="30" align="left" valign="middle"><input name="SkypeAddress" type="text" class="txtfield_normal" id="SkypeAddress" value="<? echo stripslashes($arryMember[0]['SkypeAddress']); ?>"  maxlength="80" /></td>
            </tr>
			 <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=ADDRESS?>
                      <span class="bluestar">*</span></td>
              <td  height="30" align="left" valign="top"><textarea name="Address" rows="3"  class="txtfield_normal" id="Address"><? echo $arryMember[0]['Address'];?></textarea></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=POSTAL_CODE?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><span >
                <input name="PostCode" type="text" class="txtfield_normal"  id="PostCode" value="<? echo $arryMember[0]['PostCode']; ?>" maxlength="10" />
              </span></td>
            </tr>
          </table></td>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td  height="30" width="40%" align="left" valign="middle"  nowrap="nowrap"><?=LANDLINE_NUMBER?>
                &nbsp;&nbsp;&nbsp;</td>
              <td  height="30" align="left" valign="middle"><input name="LandlineNumber" type="text" class="txtfield_normal" id="LandlineNumber" value="<? echo $arryMember[0]['LandlineNumber']; ?>"  maxlength="30"  /></td>
            </tr>
            <tr>
              <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=MOBILE_NUMBER?>
                      <span class="bluestar">*</span>&nbsp;&nbsp;&nbsp;</td>
              <td  height="30" align="left" valign="middle">
<? 
	if($arryMember[0]['isd_code'] != ''){
		$IsdSelected = $arryMember[0]['isd_code']; 
	}else{
		$IsdSelected = 1;
	}
	?>
	<!--
   <select name="isd_code" class="txtfield_normal" id="isd_code" style="width: 72px;"  >
   			<option value="">ISD Code</option>
                        <? for($i=0;$i<sizeof($arryIsd);$i++) {
						  if($arryIsd[$i]['isd_code']>0){
						?>
                        <option value="<?=$arryIsd[$i]['isd_code']?>" <?  if($arryIsd[$i]['isd_code']==$IsdSelected){echo "selected";}?>>
                        <?=$arryIsd[$i]['isd_code']?>
                        </option>
				
                        <? }} ?>
  </select>			  
			  -->
			  
			  <input name="Phone" type="text" class="txtfield_normal"id="Phone" value="<? echo $arryMember[0]['Phone']; ?>"  maxlength="30"     /></td></tr>
		
            <tr>
              <td height="30" align="left" valign="middle" ><?=FAX?></td>
              <td height="30" align="left" valign="middle"><input name="Fax" type="text" class="txtfield_normal" id="Fax" value="<? echo $arryMember[0]['Fax']; ?>"  maxlength="30"/></td>
            </tr>
           
			 <tr>
              <td  height="30" align="left" valign="middle" ><?=COUNTRY?></td>
              <td  height="30" align="left" valign="middle">
			  <? 
	if($arryMember[0]['country_id'] != ''){
		$CountrySelected = $arryMember[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
                      <select name="country_id" class="txtfield_normal" id="country_id"  onchange="Javascript: StateListSend();" >
                        <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                        <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
                        <?=$arryCountry[$i]['name']?>
                        </option>
                        <? } ?>
                      </select>              </td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=STATE?></td>
              <td height="30" align="left" valign="middle" id="state_td" ><img src="images/loading.gif" /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=CITY?></td>
              <td height="30" align="left" valign="middle" id="city_td"><img src="images/loading.gif" /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" >&nbsp;</td>
              <td height="30" align="left" valign="middle" id="city_td">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
   
 
   
   
    <tr>
      <td height="84" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td  width="50%" height="105" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            
			 <tr>
      <td class="graybox" colspan="2"><?=COMPANY_INFORMATION?>
      </td>
    </tr>
			<tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=COMPANY_NAME?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="CompanyName" type="text" class="txtfield_normal"  id="CompanyName" value="<? echo stripslashes($arryMember[0]['CompanyName']); ?>"  maxlength="50" /></td>
            </tr>
			
            <tr >
              <td height="30" align="left" valign="top" ><?=COMPANY_TAG_LINE?></td>
              <td height="30" align="left" valign="top" class="generaltxt_inner"><textarea name="TagLine" type="text" class="txtfield_normal"  id="TagLine" rows="3" ><? echo stripslashes($arryMember[0]['TagLine']); ?></textarea></td>
            </tr>			
			 <tr>
              <td height="30" align="left" valign="middle" ><?=CONTACT_PERSON?></td>
              <td height="30" align="left" valign="middle"><input name="ContactPerson" type="text" class="txtfield_normal"  id="ContactPerson" value="<? echo stripslashes($arryMember[0]['ContactPerson']); ?>"  maxlength="50" /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=CONTACT_NUMBER?></td>
              <td height="30" align="left" valign="middle"><input name="ContactNumber" type="text" class="txtfield_normal"  id="ContactNumber" value="<? echo stripslashes($arryMember[0]['ContactNumber']); ?>"  maxlength="30" /></td>
            </tr>
			
            <tr>
              <td height="30" align="left" valign="middle" ><?=COMPANY_LOGO?></td>
              <td height="30" align="left" valign="middle"><input name="Image" type="file" class="txtfield_normal" id="Image" style="width:188px;"  onkeypress="javascript: return false;" onkeydown="javascript: return false;"  oncontextmenu="return false" ondragstart="return false" onselectstart="return false" /></td>
            </tr>
			
			 <tr>
              <td height="30" align="left" valign="middle" >Banner</td>
              <td height="30" align="left" valign="middle"><input name="Banner" type="file" class="txtfield_normal" id="Banner" style="width:188px;"  onkeypress="javascript: return false;" onkeydown="javascript: return false;"  oncontextmenu="return false" ondragstart="return false" onselectstart="return false" /></td>
            </tr>
           
			 <tr style="display:none">
              <td  height="30" align="left" valign="middle" ><?=POSITION?>                      </td>
              <td  height="30" align="left" valign="middle">
                <input name="Position" type="text" class="txtfield_normal" id="Position" value="<? echo stripslashes($arryMember[0]['Position']); ?>"  maxlength="30" />             </td>
            </tr>
			<tr style="display:none">
              <td height="30" align="left" valign="middle" ><?=REGISTRATION_NUMBER?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="RegistrationNumber" type="text" class="txtfield_normal"  id="RegistrationNumber" value="<? echo stripslashes($arryMember[0]['RegistrationNumber']); ?>"  maxlength="30" /></td>
            </tr>
			 <tr>
              <td height="30" align="left" valign="middle" ><?=ALTERNATE_EMAIL?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="AlternateEmail" type="text" class="txtfield_normal"  id="AlternateEmail" value="<? echo stripslashes($arryMember[0]['AlternateEmail']); ?>"  maxlength="70" /></td>
            </tr>
			
           
          </table></td>
          <td height="105" width="50%" valign="top">
		  
	<table width="100%" border="0" cellspacing="0" cellpadding="0">	  
	 <tr>
      <td class="graybox" align="left"><?=WORD_VERIFICATION?></td>
    </tr>
    <tr>
      <td height="30" class="generaltxt_inner" align="left"><input name="verifyText" type="text" class="txtfield_normal"  id="verifyText"  maxlength="15" style="margin-left:8px;" autocomplete="off" />
          <input name="verifyHidden" type="hidden" id="verifyHidden" value="<? echo $_SESSION['randomString'];?>" />
                 
      </td>
    </tr>
	 <tr>
      <td class="generaltxt_inner" height="30" align="left" style="padding-left:8px;"><?=TYPE_VERIFICATION_WORD?></td>
    </tr>
    <tr>
      <td valign="top" align="left" ><iframe src="randomCh.php?randomStr=123456" width="100" height="56" frameborder="0" scrolling="No" id="ImageFrame" name="ImageFrame" ></iframe></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
    </tr>
	</table>	  
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none">
          
           
			<!--
		    <tr>
              <td  height="30"  align="left" valign="middle" ><?=WEBSITE?>
                      </td>
              <td  height="30" align="left" valign="middle">
                <input name="Website" type="text" class="txtfield_normal" id="Website" value="http://"  maxlength="100" />
             </td>
            </tr>-->

           <tr style="display:none">
              <td height="30" align="left" valign="middle" ><?=VAT_NUMBER?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="VatNumber" type="text" class="txtfield_normal"  id="VatNumber" value="<? echo stripslashes($arryMember[0]['VatNumber']); ?>"  maxlength="50" /></td>
            </tr>
			<tr style="display:none">
              <td height="30" align="left" valign="middle" ><?=VAT_PERCENTAGE?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="VatPercentage" type="text" class="txtfield_normal"  id="VatPercentage" value="<? echo stripslashes($arryMember[0]['VatPercentage']); ?>"  maxlength="5" /></td>
            </tr>
			<tr style="display:none">
              <td height="30" align="left" valign="top" ><?=VAT_TAX_TYPE?></td>
              <td height="30" align="left" valign="top" class="generaltxt_inner">
			  
	<?
		if($arryMember[0]['TaxType'] != '' && $arryMember[0]['TaxType'] != 'VAT' && $arryMember[0]['TaxType'] != 'GST'){
			$OtherChecked = ' checked';
			$TaxType = $arryMember[0]['TaxType'];
		}else if($arryMember[0]['TaxType'] == 'VAT'){
			$VatChecked = ' checked';
		}else if($arryMember[0]['TaxType'] == 'GST'){
			$GstChecked = ' checked';
		}else{
			$NoneChecked = ' checked';
		}
		?>
		<input type="radio" name="TaxType" value="" <?=$NoneChecked?> /> None<br>
		<input type="radio" name="TaxType" value="VAT" <?=$VatChecked?> /> VAT <br>
		<input type="radio" name="TaxType" value="GST" <?=$GstChecked?> /> GST<br>
		<input type="radio" name="TaxType" value="Other" <?=$OtherChecked?> /> State if other
		<input name="TaxTypeOther" type="text" class="txtfield_normal" value="<? echo $TaxType; ?>" size="10" maxlength="30" /> 
			  
			  
			  
			  </td>
            </tr>
			
			 <tr>
              <td  colspan="2" height="10" valign="middle" class="generaltxt_inner"></td>
            </tr>
			
          </table></td>
        </tr>
      </table></td>
    </tr>
	
	<tr>
      <td class="graybox" style="display:none">
	  <?=BILLING_DETAILS?>
      </td>
    </tr>
	
	 <tr style="display:none">
      <td height="84" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" width="50%" height="100"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=FIRST_NAME?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="BillingFirstName" type="text" class="txtfield_normal"id="BillingFirstName" value="<? echo stripslashes($arryMember[0]['BillingFirstName']); ?>"  maxlength="50"  /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=LAST_NAME?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="BillingLastName" type="text" class="txtfield_normal" id="BillingLastName" value="<? echo stripslashes($arryMember[0]['BillingLastName']); ?>"  maxlength="50" /></td>
            </tr>
            <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=COMPANY_NAME?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="BillingCompany" type="text" class="txtfield_normal"  id="BillingCompany" value="<? echo stripslashes($arryMember[0]['BillingCompany']); ?>"  maxlength="50" /></td>
            </tr>
			
          </table></td>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=ADDRESS?>
                      <span class="bluestar">*</span></td>
              <td  height="30" align="left" valign="middle">
                <input name="BillingAddress" type="text" class="txtfield_normal"  id="BillingAddress" value="<? echo $arryMember[0]['BillingAddress']; ?>" maxlength="100" />
              </td>
            </tr>
			<tr>
              <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=LANDLINE_NUMBER?>
                &nbsp;&nbsp;&nbsp;</td>
              <td  height="30" align="left" valign="middle"><input name="BillingLandline" type="text" class="txtfield_normal" id="BillingLandline" value="<? echo $arryMember[0]['BillingLandline']; ?>"  maxlength="30"  /></td>
            </tr>
          <tr>
              <td height="30" align="left" valign="middle" ><?=ALTERNATE_EMAIL?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="BillingEmail" type="text" class="txtfield_normal"  id="BillingEmail" value="<? echo stripslashes($arryMember[0]['BillingEmail']); ?>"  maxlength="70" /></td>
            </tr>
          
           
          </table></td>
        </tr>
      </table></td>
    </tr>
	<tr>
      <td class="graybox" style="display:none">
	  <?=DELIVERY_FEE?>
      </td>
    </tr>
	
	 <tr style="display:none">
      <td  align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" width="50%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=DELIVERY_OPTIONS?>                     </td>
              <td  height="30" align="left" valign="middle"><select name="DeliveryOption" class="txtfield_normal" id="DeliveryOption" style="width: 180px;" onchange="Javascript: ShowDeliveryOptions();" >
			  	<option value="0" >None</option>
                <? for($i=1;$i<=$Config['NumDeliveryOption'];$i++) {?>
                <option value="<?=$i?>" <?  if($i==sizeof($arryDelivery)){echo "selected";}?>>
                <?=$i?>
                </option>
                <? } ?>
              </select> </td>
            </tr>
            
            
			
          </table></td>
          <td class="smalltxt" height="30"><?=DELIVERY_FEE_ZERO?></td>
        </tr>
      </table>
	  <? for($i=1;$i<=$Config['NumDeliveryOption'];$i++) { ?>
	    <Div id="DeliveryOptionDiv<?=$i?>" style="display:none">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	<tr>
      <td height="1" bgcolor="#d6d6d6" style="padding:0px; margin:0px;" colspan="2"></td>
    </tr>
		  <tr>
            <td  width="50%" height="40"  ><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                  <td width="40%" height="30" align="left" valign="middle"  >
				  <input type="checkbox" name="DeliveryStatus<?=$i?>" id="DeliveryStatus<?=$i?>"  value="1" />
				  <?=DELIVERY_OPTION?> <?=$i?> <span class="bluestar">*</span></td>
                  <td  height="30" align="left" valign="middle">
		 <input name="DeliveryName<?=$i?>" type="text" class="txtfield_normal" id="DeliveryName<?=$i?>" value=""  maxlength="200"  />
				  </td>
                </tr>
            </table></td>
            <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="40%" height="30" align="left" valign="middle" >
				<?=DELIVERY_FEE?> <?=$i?> <span class="bluestar">*</span> </td>
                <td  height="30" align="left" valign="middle" class="generaltxt_inner"><input name="DeliveryFee<?=$i?>" type="text" class="txtfield_normal" id="DeliveryFee<?=$i?>" value=""  maxlength="6" size="23" /> <span id="DeliverySpanCurrency<?=$i?>"><?=$Config['Currency']?></span>
                  </td>
              </tr>
            </table></td>
          </tr>
	
        </table>
		</Div>
		<? } ?>
		</td>
    </tr>
	
	<tr>
      <td height="10">
	</td>
    </tr>
    <tr style="display:none">
      <td class="graybox" >
	  <?=PAYMENT_INFORMATION?>
	 
      </td>
    </tr>
		
	 <tr style="display:none">
      <td valign="top">
	  
	  
	  
 <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
        <td  class="generaltxt_inner" height="90"> <strong><?=CURRENCY_ACCEPTED?></strong>:&nbsp;&nbsp; 
		
  <? 
	if($arryMember[0]['currency_id'] != ''){
		$CurrencySelected = $arryMember[0]['currency_id']; 
	}else{
		$CurrencySelected = 9;
	}
	?>
           <select name="currency_id" class="txtfield_normal" id="currency_id" onchange="Javascript:SetDeliveryCurrency();"  >
             <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
               <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>><?=$arryCurrency[$i]['name']?></option>
             <? } ?>
         </select>		
		</td>
     </tr>	
 <tr >
            <td class="generaltxt_inner" height="60">
			<strong><?=PAYMENT_TYPE?></strong>:
			<? for($i=0;$i<sizeof($arrayPaymentGateways);$i++){
				$Line = $i+1;
				$fieldname = $arrayPaymentGateways[$i]['fieldname'];
				if($Line==4) { 
					$Line=3; 
				}
			?>
		<input type="checkbox" name="<?=$arrayPaymentGateways[$i]['fieldname']?>" id="<?=$arrayPaymentGateways[$i]['fieldname']?>" onclick="Javascript:ShowPayDiv('<?=$Line?>','<?=$fieldname?>');" value="1"  <? if($arryMember[0][$arrayPaymentGateways[$i]['fieldname']] == '1') echo 'checked';?>><?=$arrayPaymentGateways[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;		
			<? } ?>
			</td>
          </tr> 
		
			
<tr>
              <td align="center" valign="top"  >
			  <Div id="PaymentDiv1" <? if($arryMember[0]['MyGatePayment'] != 1) echo 'style="display:none"';?>>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
            <td class="graybox" colspan="2"><?=$arrayPaymentGateways[0]['name']?> </td>
          </tr>   
					<tr>
				  <td colspan=2 class="generaltxt_inner" height=60><?=MY_GATE_MEANING?></td>
				  </tr>
					    <tr>
                          <td width="20%" height="30" align="left" valign="middle" ><?=MYGATE_MODE?><span class="bluestar">*</span> 
                              </td>
                          <td  height="30" align="left" valign="middle">
						  <select name="MyGate_Mode" id="MyGate_Mode" class="txtfield_normal" style="width: 180px;">
                            <option value="0" <? if($arryMember[0]['MyGate_Mode'] == '0') echo 'selected';?>> Test Mode </option>
                            <option value="1" <? if($arryMember[0]['MyGate_Mode'] == '1') echo 'selected';?>> Live Mode </option>
                          </select>
						  </td>
                        </tr>
				
						<tr>
                          <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=MYGATE_MERCHANT_ID?><span class="bluestar">*</span>       </td>
                          <td  height="30" align="left" valign="middle"><input name="MyGate_MerchantID" type="text" class="txtfield_normal" id="MyGate_MerchantID" value="<? echo $arryMember[0]['MyGate_MerchantID']; ?>"  maxlength="50"  /></td>
                        </tr>
						
                      
						 <tr>
                          <td w height="30" align="left" valign="middle" ><?=MYGATE_APPLICATION_ID?><span class="bluestar">*</span>
                              </td>
                          <td height="30" align="left" valign="middle"><input name="MyGate_ApplicationID" type="text" class="txtfield_normal" id="MyGate_ApplicationID" value="<? echo stripslashes($arryMember[0]['MyGate_ApplicationID']); ?>"  maxlength="50"  /></td>
                        </tr>
						
						  <tr>
				  <td colspan=2  height=20></td>
				  </tr>
				
                    </table>
			  </Div>
			  
			  
	<Div id="PaymentDiv2" <? if($arryMember[0]['PaypalPayment'] != 1) echo 'style="display:none"';?>>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
            <td class="graybox" colspan="2"><?=$arrayPaymentGateways[1]['name']?> </td>
          </tr>  
				
					<tr>
				  <td colspan=2 class="generaltxt_inner" height=40><?=PAYPAL_MEANING?></td>
				  </tr>
						<tr>
                          <td  width="20%"  align="left" valign="top"  nowrap="nowrap"><?=PAYPAL_ID?><span class="bluestar">*</span>       </td>
                          <td align="left" valign="top"><input name="PaypalID" type="text" class="txtfield_normal" id="PaypalID" value="<? echo stripslashes($arryMember[0]['PaypalID']); ?>"  maxlength="80"  /></td>
                        </tr>
				<tr>
				  <td colspan=2  height=20></td>
				  </tr>
				
                    </table>
			  </Div>		  
			  
	 <Div id="PaymentDiv3" <? if($arryMember[0]['EftPayment'] != 1) echo 'style="display:none"';?>>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
            <td class="graybox" colspan="2"><?=$arrayPaymentGateways[2]['name']?> / <?=$arrayPaymentGateways[3]['name']?></td>
          </tr>  
		 
		 <tr>
           <td colspan="2" class="generaltxt_inner" height="60" ><?=EFT_DIRECT_PAYMENT_MEANING?></td>
         </tr>
         <tr>
           <td  height="30" width="20%"  align="left" valign="middle"  nowrap="nowrap"><?=ACCOUNT_HOLDER?>
               <span class="bluestar">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountHolder" type="text" class="txtfield_normal" id="AccountHolder" value="<? echo stripslashes($arryMember[0]['AccountHolder']); ?>"  maxlength="50"  /></td>
         </tr>
         <tr>
           <td  height="30"  align="left" valign="middle"  nowrap="nowrap"><?=ACCOUNT_NUMBER?>
               <span class="bluestar">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountNumber" type="text" class="txtfield_normal" id="AccountNumber" value="<? echo stripslashes($arryMember[0]['AccountNumber']); ?>"  maxlength="40"  /></td>
         </tr>
         <tr>
           <td  height="30" align="left" valign="middle" ><?=BANK_NAME?>
               <span class="bluestar">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BankName" type="text" class="txtfield_normal" id="BankName" value="<? echo stripslashes($arryMember[0]['BankName']); ?>"  maxlength="40"  /></td>
         </tr>
<tr>
           <td  height="30" align="left" valign="middle" ><?=BRANCH_CODE?>
               <span class="bluestar">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BranchCode" type="text" class="txtfield_normal" id="BranchCode" value="<? echo stripslashes($arryMember[0]['BranchCode']); ?>"  maxlength="30"  /></td>
         </tr>
		  <tr>
           <td  height="30" align="left" valign="middle" ><?=SWIFT_NUMBER?>
                </td>
           <td height="30" align="left" valign="middle"><input name="SwiftNumber" type="text" class="txtfield_normal" id="SwiftNumber" value="<? echo stripslashes($arryMember[0]['SwiftNumber']); ?>"  maxlength="30"  /></td>
         </tr>
		   <tr>
            <td height="20"></td>
          </tr>  
       </table>
	 </Div>		  			  
			  
			  
		<Div id="ShippingDiv"
	<? if($arryMember[0]['MyGatePayment'] == 1 ||  $arryMember[0]['PaypalPayment'] == 1 || $arryMember[0]['EftPayment'] == 1 ||  $arryMember[0]['DepositPayment'] == 1) echo 'style="display:inline"'; else echo 'style="display:none"';?>	
		
		>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
			    <tr>
            <td class="graybox" colspan="2"><?=SHIPPING_CHARGES?> </td>
          </tr>  
			   <tr>
					  <td  height="40" width="40%" align="left" valign="middle"  nowrap="nowrap"><?=SHIPPING_CHARGES?> (%)      </td>
					  <td   align="left" valign="middle"><input name="Shipping" type="text" class="txtfield_normal" id="Shipping" value="<? echo $arryMember[0]['Shipping']; ?>"  maxlength="3"  /></td>
					</tr>
		  </table>
		  
		</Div>  
			  
			  
			  
			  </td>
            </tr>	
</table>

	
	
	
	
	 
      </td>
    </tr>
	
	
 <tr style="display:none">
      <td class="graybox"><?=AREA_CODE?></td>
    </tr> 	
 <tr style="display:none">
      <td height="30" class="generaltxt_inner"><input name="AreaCode" type="text" class="txtfield_normal"  id="AreaCode"  maxlength="8" style="margin-left:8px;" />
      </td>
    </tr> 
	
   
	
    <tr>
      <td class="graybox" <? if(empty($content)) echo 'Style="display:none"'; ?>><?=TERMS_CONDITIONS?>
      </td>
    </tr> 
    <tr <? if(empty($content)) echo 'Style="display:none"'; ?>>
      <td height="30" class="generaltxt_inner" >
	  <? //echo TERMS_CONDITIONS_MSG_SELLER ; ?>
          
          <input name="agree" id="agree" type="checkbox" value="checkbox" <? if(empty($content)) echo 'checked'; ?> />
          <strong>I agree to the following terms & conditions: </strong></td>
    </tr>
    <tr <? if(empty($content)) echo 'Style="display:none"'; ?>>
      <td><div class="terms_box">
        <? if(stripslashes($content) != '') { echo stripslashes($content);} ?>
      </div></td>
    </tr>
	 <tr>
      <td height="10"></td>
    </tr>
	
    <tr>
      <td height="25" class="generaltxt_inner" valign="bottom"><input name="EmailSubscribe" id="EmailSubscribe" type="checkbox" value="1" />
          <strong>
            <?=SUBSCRIBE_EMAIL?>
          </strong> </td>
    </tr>
	 <tr style="display:none">
      <td height="25" class="generaltxt_inner" valign="bottom">
	  <input name="SmsSubscribe" id="SmsSubscribe" type="checkbox" value="1" />
          <strong>
            <?=SUBSCRIBE_SMS?>
          </strong> </td>
    </tr>
    <tr>
      <td height="79" valign="middle"><table border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="left"><input name="SubmitButton" id="SubmitButton" type="submit" value="Submit" class="button"></td>
		  <td>&nbsp;</td>
		  
          <td align="left"><input type="reset" name="Reset"  value="Reset" class="button"  />
                <input type="hidden" name="MembershipID" id="MembershipID" value="1" />
                <input type="hidden" name="templateID" id="templateID" value="0" />
                <input type="hidden" name="MemberID" id="MemberID" value="<?=$_SESSION['MemberID']?>" />
                <input type="hidden" name="Status" id="Status" value="<?=$Status?>" />
                <input type="hidden" name="MemberApproval" id="MemberApproval" value="<?=$MemberApproval?>" />
                <input type="hidden" name="Type" id="Type" value="<? echo $_GET['opt']; ?>" />
                <input type="hidden" name="Featured" id="Featured" value="No" />
				 <input type="hidden" name="NumDeliveryOption" id="NumDeliveryOption" value="<?=$Config['NumDeliveryOption']?>" />
                <input type="hidden" name="JoiningDate" id="JoiningDate" value="<? echo $arryMember[0]['JoiningDate']; ?>" />
                <input type="hidden" name="ExpiryDate" id="ExpiryDate" value="<? echo $arryMember[0]['ExpiryDate']; ?>" />
                <input type="hidden" name="main_state_id" id="main_state_id"  value="<? echo $arryMember[0]['state_id']; ?>" />
                <input type="hidden" name="main_city_id" id="main_city_id"  value="<? echo $arryMember[0]['city_id']; ?>" /></td>
        </tr>
      </table></td>
    </tr>
   
  </form>
</table>
