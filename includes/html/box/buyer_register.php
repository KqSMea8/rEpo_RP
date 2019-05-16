<script language="JavaScript1.2" type="text/javascript">


function validateBuyer(frm){
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
		&& ValidateForSimpleBlank(frm.Address,BLANK_ADDRESS)
		&& isPostCode(frm.PostCode)
		&& ValidateOptPhoneNumber(frm.LandlineNumber)
		//&& ValidateForSelect(frm.isd_code,SELECT_ISD_CODE)
		&& ValidateMandMobileNumber(frm.Phone)
		&& ValidateOptFaxNumber(frm.Fax)
		//&& ValidateForBlankOpt(frm.CompanyName, BLANK_COMPANY_NAME , SPECIAL_CHAR_COMPANY_NAME)
		&& ValidateForBlankOpt(frm.ContactPerson, BLANK_CONTACT_PERSON_NAME , SPECIAL_CHAR_CONTACT_PERSON_NAME)
		&& ValidateOptContactNumber(frm.ContactNumber)
		//&& ValidateForBlankOpt(frm.Position, BLANK_POSITION , SPECIAL_CHAR_POSITION)
		//&& ValidateOptNumField(frm.RegistrationNumber, "Registration Number")
		&& ValidateForVerification(frm.verifyText,frm.verifyHidden)
		&& ValidateCheckBox(frm.agree, AGREE_TO_TERMS)
	){
		var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&UserName="+escape(document.getElementById("UserName").value)+"&Type="+document.getElementById("Type").value+"&editID="+document.getElementById("MemberID").value;
		SendMultipleExistRequest(Url,"UserName","User Name","Email","Email");	
		return false;	
	}else{
		return false;	
	}

}

</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" onSubmit="return validateBuyer(this);">
    
	 <tr>
      <td height="32" align="right" valign="top" class="generaltxt_inner">
          <?=MANDATORY_REGISTRATION?>
      </td>
    </tr>
	
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
           
          </table></td>
          <td valign="top" width="50%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="30" align="left" valign="middle" ><?=PASSWORD?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="Password" type="password" class="txtfield_normal"id="Password" value="<? echo stripslashes($arryMember[0]['Password']); ?>"  maxlength="15"  /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=CONFIRM_PASSWORD?>
                      <span class="bluestar">*</span></td>
              <td height="30" align="left" valign="middle"><input name="ConfirmPassword" type="password" class="txtfield_normal" id="ConfirmPassword" value="<? echo stripslashes($arryMember[0]['Password']); ?>"  maxlength="15" /></td>
            </tr>
            <tr>
              <td colspan="2" height="30" valign="middle" class="generaltxt_inner"><?=PASSWORD_LIMIT?></td>
            </tr>
          </table></td>
        </tr>
      </table>
          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> </tr>
            <tr> </tr>
            <tr> </tr>
        </table></td>
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
			
			<tr>
              <td width="40%" height="30" align="left" valign="top" ><?=ADDRESS?>
                      <span class="bluestar">*</span></td>
              <td  height="30" align="left" valign="middle">
                  <textarea name="Address" rows="3"  class="txtfield_normal" id="Address"><? echo $arryMember[0]['Address'];?></textarea>              </td>
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
              <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=LANDLINE_NUMBER?>
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
  </select>	-->			  
			  
			  
			  
			  
			  <input name="Phone" type="text" class="txtfield_normal"id="Phone" value="<? echo $arryMember[0]['Phone']; ?>"  maxlength="30"   /></td></tr>
			
            <tr>
              <td height="30" align="left" valign="middle" ><?=FAX?></td>
              <td height="30" align="left" valign="middle"><input name="Fax" type="text" class="txtfield_normal" id="Fax" value="<? echo $arryMember[0]['Fax']; ?>"  maxlength="30"/></td>
            </tr>
           
			<tr>
              <td  height="30" width="38%" align="left" valign="middle" ><?=COUNTRY?></td>
              <td  height="30" align="left" valign="middle"><? 
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
              <td height="30" align="left" >&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
   
   
   
   
    <tr>
      <td height="84" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        
		
		<tr>
          <td  width="50%" height="105" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
           
		    <tr>
      <td class="graybox" align="left" colspan="2"><?=COMPANY_INFORMATION?>
      </td>
    </tr>
		    <tr>
              <td width="40%" height="30" align="left" valign="middle" ><?=COMPANY_NAME?>                      </td>
              <td  height="30" align="left" valign="middle"><input name="CompanyName" type="text" class="txtfield_normal"  id="CompanyName" value="<? echo stripslashes($arryMember[0]['CompanyName']); ?>"  maxlength="50" /></td>
            </tr>
			
            <tr>
              <td height="30" align="left" valign="middle" ><?=CONTACT_PERSON?></td>
              <td height="30" align="left" valign="middle"><input name="ContactPerson" type="text" class="txtfield_normal"  id="ContactPerson" value="<? echo stripslashes($arryMember[0]['ContactPerson']); ?>"  maxlength="50" /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=CONTACT_NUMBER?></td>
              <td height="30" align="left" valign="middle"><input name="ContactNumber" type="text" class="txtfield_normal"  id="ContactNumber" value="<? echo stripslashes($arryMember[0]['ContactNumber']); ?>"  maxlength="30" /></td>
            </tr>
			
          
          </table></td>
          <td height="105" width="50%" valign="top">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none">
           <tr >
              <td  height="30" width="38%" align="left" valign="middle" ><?=POSITION?>                      </td>
              <td  height="30" align="left" valign="middle">
                <input name="Position" type="text" class="txtfield_normal" id="Position" value="<? echo stripslashes($arryMember[0]['Position']); ?>"  maxlength="30" />             </td>
            </tr>
           <tr >
              <td height="30" align="left" valign="middle" ><?=REGISTRATION_NUMBER?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="RegistrationNumber" type="text" class="txtfield_normal"  id="RegistrationNumber" value="<? echo stripslashes($arryMember[0]['RegistrationNumber']); ?>"  maxlength="30" /></td>
            </tr>
            <tr>
              <td height="30" colspan="2" align="left" valign="middle" >&nbsp;</td>
              </tr>
           
          </table>
		  
		  
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
		    <tr>
      <td class="graybox"><?=WORD_VERIFICATION?></td>
    </tr>
    <tr>
      <td height="30" class="generaltxt_inner" align="left" style="padding-left:10px;"><input name="verifyText" type="text" class="txtfield_normal"  id="verifyText"  maxlength="15" autocomplete="off" />
          <input name="verifyHidden" type="hidden" id="verifyHidden" value="<? echo $_SESSION['randomString'];?>" /></td>
    </tr>
    <tr>
      <td valign="top" align="left"style="padding-left:10px;" ><span class="generaltxt_inner">
        <?=TYPE_VERIFICATION_WORD?>
      </span></td>
    </tr>
    <tr>
      <td valign="top" align="left" ><iframe src="randomCh.php?randomStr=123456" width="100" height="56" frameborder="0" scrolling="No" id="ImageFrame" name="ImageFrame" ></iframe></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
    </tr>
		   </table>
		  
		  
		  
		  </td>
        </tr>
      </table></td>
    </tr>
  
   
    <tr>
      <td class="graybox" <? if(empty($content)) echo 'Style="display:none"'; ?>><?=TERMS_CONDITIONS?>
      </td>
    </tr>
    <tr <? if(empty($content)) echo 'Style="display:none"'; ?>>
      <td height="25" class="generaltxt_inner"><? //echo TERMS_CONDITIONS_MSG_BUYER; ?>
        
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
      <td height="25" class="generaltxt_inner" valign="bottom" >
	  <input name="SmsSubscribe" id="SmsSubscribe" type="checkbox" value="1" />
          <strong>
            <?=SUBSCRIBE_SMS?>
          </strong> </td>
    </tr>
    <tr>
      <td height="79"  valign="middle">
	  <table  border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td  align="left"><input name="SubmitButton" id="SubmitButton" type="Submit" value="Submit" class="button" ></td>
		  <td>&nbsp;</td>
          <td align="left"><input type="reset" name="Reset"  value="Reset" class="button"  />
                <input type="hidden" name="MembershipID" id="MembershipID" value="1" />
                <input type="hidden" name="templateID" id="templateID" value="0" />
                <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
                <input type="hidden" name="Status" id="Status" value="<?=$Status?>" />
                <input type="hidden" name="MemberApproval" id="MemberApproval" value="<?=$MemberApproval?>" />
                <input type="hidden" name="Type" id="Type" value="<? echo $_GET['opt']; ?>" />
                <input type="hidden" name="Featured" id="Featured" value="No" />
                <input type="hidden" name="JoiningDate" id="JoiningDate" value="<? echo $arryMember[0]['JoiningDate']; ?>" />
                <input type="hidden" name="ExpiryDate" id="ExpiryDate" value="<? echo $arryMember[0]['ExpiryDate']; ?>" />
                <input type="hidden" name="main_state_id" id="main_state_id"  value="<? echo $arryMember[0]['state_id']; ?>" />
            <input type="hidden" name="main_city_id" id="main_city_id"  value="<? echo $arryMember[0]['city_id']; ?>" /></td>
        </tr>
      </table></td>
    </tr>
   
  </form>
</table>
