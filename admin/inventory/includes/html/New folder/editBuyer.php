<script language="JavaScript1.2" type="text/javascript">



function validateBuyer(frm){
		
			if( ValidateForBlank(frm.UserName, "User Name")
					&& isUserName(frm.UserName)
					&& ValidateMandRange(frm.UserName, "User Name", 2, 25)
					&& ValidateForEmail(frm.Email, "Email")
					&& isEmail(frm.Email)
					&& ValidateForPassword(frm.Password, "Password")
					&& isPassword(frm.Password)
					&& ValidateMandRange(frm.Password, "Password",5,15)
					&& ValidateForSimpleBlank(frm.FirstName, "First Name")
					&& ValidateForSimpleBlank(frm.LastName, "Last Name")
					//&& ValidateIDNumber(frm.IDNumber,"ID Number")
					&& ValidateForSimpleBlank(frm.Address, "Address")
					&& isPostCode(frm.PostCode)
					&& ValidateOptPhoneNumber(frm.LandlineNumber,"Landline Number")
					&& ValidateOptPhoneNumber(frm.Phone,"Mobile Number")
					&& ValidateOptFax(frm.Fax,"Fax Number")
					//&& ValidateForBlankOpt(frm.CompanyName, "Company Name")
					&& ValidateForBlankOpt(frm.ContactPerson, "Contact Person")
					&& ValidateForBlankOpt(frm.Position, "Position")
					//&& ValidateOptNumField(frm.RegistrationNumber, "Registration Number")
					&& ValidateOptPhoneNumber(frm.ContactNumber,"Contact Number")
				){
				
					if(frm.ExpiryDate.value>0){
						if(frm.JoiningDate.value > frm.ExpiryDate.value){
							alert("Expiry Date should be greater than Joining Date !!");
							frm.ExpiryDate.focus();
							return false;	
						}
					}

				

					var Url = "isRecordExists.php?Email="+document.getElementById("Email").value+"&UserName="+document.getElementById("UserName").value+"&editID="+document.getElementById("MemberID").value+"&Type="+document.getElementById("Type").value;
					SendMultipleExistRequest(Url,"UserName","User Name","Email","Email Address");
					return false;	
					
			}else{
					return false;	
			}	
	
		
}









</script>

<div class="had">
<? 
		$BannerTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
		echo $BannerTitle.$ModuleName;
		?>
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 class="">
	
	<tr><td height="314" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <?php if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <?php } ?>
  <tr>
    <td align="right" height="30" valign="top">&nbsp;<a href="<?=$RedirectURL?>" class="Blue">List <?=$ModuleName?>s</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>
</table>
<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" <?=$OnSubmitFunction?> enctype="multipart/form-data">


   <tr>
    <td  align="center" ><table width="80%" border="0" cellpadding="5" cellspacing="1"   class="borderall">
      
		<tr>
       		 <td colspan="2" align="left"   class="head1">Account Information</td>
        </tr>	  

   
      <tr>
        <td  align="right" width="37%"   class="blackbold">User Name <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="UserName" type="text" class="inputbox" id="UserName" value="<?php echo stripslashes($arryMember[0]['UserName']); ?>" size="30" maxlength="50" <? if($arryMember[0]['UserName'] != '') echo 'Readonly';?>/>          <span class="blacknormal" >(Display Name) </span>
		
			</td>
      </tr>
	
      <tr>
        <td  align="right"   class="blackbold">Email <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryMember[0]['Email']; ?>" size="30" maxlength="80"  <? if($arryMember[0]['Email'] != '') echo 'Readonly';?>/> <span class="blacknormal" >(Login ID) </span></td>
      </tr>
        <tr>
        <td  align="right"   class="blackbold">Password <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="Password" type="text" class="inputbox" id="Password" value="<?php echo stripslashes($arryMember[0]['Password']); ?>" size="30" maxlength="15" />          <span class="blacknormal" >(Password Limit: 5 to 15 characters.) </span></td>
      </tr>
    
	
	  
	 
	  
	  <? if($arryMember[0]['JoiningDate'] > 0){?>
      <tr>
        <td align="right"   class="blackbold">Joining Date </td>
        <td height="30" align="left"  class="red"><? echo $arryMember[0]['JoiningDate']; ?></td>
      </tr>
	  <? } ?>
     

      <tr <? if($arryMember[0]['ExpiryDate'] <= 0) echo 'Style="display:none"'; ?>>
        <td align="right"   class="blackbold">Expiry Date  <span class="red">*</span></td>
        <td height="30" align="left"  class="red">
		<? 	$ExpiryDate = $arryMember[0]['ExpiryDate']; 
			if($ExpiryDate < 1) $ExpiryDate = '';
			echo calender_picker($ExpiryDate,'ExpiryDate');?>		</td>
      </tr>

      

<tr <? if(empty($_GET['edit'])) echo 'Style="display:none"'; ?>>
        <td  align="right"   class="blackbold" 
		>Status  </td>
        <td  height="30" align="left"  ><span class="blacknormal">
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryMember[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryMember[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </span></td>
      </tr>

	  
	  
	
	 <tr>
         <td align="right"   class="blackbold" 
		>Subscribe for Email Service</td>
         <td height="30" align="left"  >
		 <input name="EmailSubscribe" id="EmailSubscribe" type="checkbox" value="1"
		  <?  if($arryMember[0]['EmailSubscribe'] == 1) { echo 'checked';}?> /></td>
       </tr>

 <tr style="display:none">
         <td align="right"   class="blackbold" 
		>Subscribe for SMS Service</td>
         <td height="30" align="left"  >
		 <input name="SmsSubscribe" id="SmsSubscribe" type="checkbox" value="1"
		  <?  if($arryMember[0]['SmsSubscribe'] == 1) { echo 'checked';}?> /></td>
       </tr>

	<tr>
       		 <td colspan="2" align="left"   class="head1">Personal Information</td>
        </tr>
   <tr>
        <td  align="right"   class="blackbold"> First Name <span class="red">*</span> </td>
        <td  height="30" align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryMember[0]['FirstName']); ?>" size="30" maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name <span class="red">*</span> </td>
        <td  height="30" align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryMember[0]['LastName']); ?>" size="30" maxlength="50" />            </td>
      </tr>
	   <tr style="display:none">
        <td  align="right"   class="blackbold">ID Number <span class="red">*</span> </td>
        <td height="30" align="left" ><input name="IDNumber" type="text" class="inputbox" id="IDNumber" value="<?php echo $arryMember[0]['IDNumber']; ?>" size="30" maxlength="20" /></td>
      </tr>	 
	 
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address <span class="red">*</span></td>
          <td height="30" align="left" >
            <textarea name="Address" type="text" class="inputbox" id="Address" cols="27" rows="3"/><?php echo stripslashes($arryMember[0]['Address']); ?></textarea>          </td>
        </tr>
        
	<tr>
        <td  align="right"   class="blackbold"> Country </td>
        <td  height="30" align="left" >
		<?
	if($arryMember[0]['country_id'] != ''){
		$CountrySelected = $arryMember[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id" style="width: 200px;" onchange="Javascript: StateListSend();">
             
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" =""  class="blackbold"> State </td>
	  <td  align="left" id="state_td" class="blacknormal">
	   <img src="images/loading.gif"></td>
	</tr>
	   
     
	   <tr>
        <td  align="right"   class="blackbold"> City  </td>
        <td  height="30" id="city_td" align="left"  class="blacknormal"><img src="images/loading.gif"></td>
      </tr> 
	    
	  <tr>
        <td  align="right"   class="blackbold"> Postal Code <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="PostCode" type="text" class="inputbox" id="PostCode" value="<?php echo $arryMember[0]['PostCode']; ?>" size="30" maxlength="10" />            </td>
      </tr>
	   
 <tr>
        <td  align="right"   class="blackbold">Landline Number  </td>
        <td  height="30" align="left" ><input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?php echo $arryMember[0]['LandlineNumber']; ?>" size="30" maxlength="20" /></td>
      </tr>
	  
	  
       <tr>
        <td align="right"   class="blackbold">Mobile Number  </td>
        <td height="30" align="left" >
<? 
	if($arryMember[0]['isd_code'] != ''){
		$IsdSelected = $arryMember[0]['isd_code']; 
	}else{
		//$IsdSelected = 1;
	}
	?>
	<!--
   <select name="isd_code" class="inputbox" id="isd_code" style="width: 80px;"  >
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
						  
								
		
		
		<input name="Phone" type="text" class="inputbox" id="Phone" value="<?php echo $arryMember[0]['Phone']; ?>"   size="30"  maxlength="20" /> </td>
      </tr>
       <tr>
        <td align="right"   class="blackbold">Fax  </td>
        <td height="30" align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?php echo $arryMember[0]['Fax']; ?>" size="30" maxlength="20" /></td>
      </tr>
	  
	  
	<tr>
       		 <td colspan="2" align="left"   class="head1">Company Information</td>
        </tr>
		
	    <tr>
        <td align="right"   class="blackbold">
		Company Name  </td>
        <td height="30" align="left" ><input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryMember[0]['CompanyName']); ?>" size="30" maxlength="50" /></td>
      </tr>
	  
	
	 <tr>
        <td align="right"   class="blackbold"> Contact Person </td>
        <td  height="30" align="left" >
<input name="ContactPerson" type="text" class="inputbox" id="ContactPerson" value="<?php echo stripslashes($arryMember[0]['ContactPerson']); ?>" size="30" maxlength="60" />            </td>
      </tr>
	  
	 <tr style="display:none">
        <td align="right"   class="blackbold"> Position </td>
        <td  height="30" align="left" >
<input name="Position" type="text" class="inputbox" id="Position" value="<?php echo stripslashes($arryMember[0]['Position']); ?>" size="30" maxlength="30" />           </td>
      </tr>


	<tr style="display:none">
        <td align="right"   class="blackbold"> Registration Number </td>
        <td  height="30" align="left" >
<input name="RegistrationNumber" type="text" class="inputbox" id="RegistrationNumber" value="<?php echo stripslashes($arryMember[0]['RegistrationNumber']); ?>" size="30" maxlength="30" />            </td>
      </tr>
	 <tr>
        <td align="right"   class="blackbold"> Contact Number </td>
        <td  height="30" align="left" >
<input name="ContactNumber" type="text" class="inputbox" id="ContactNumber" value="<?php echo stripslashes($arryMember[0]['ContactNumber']); ?>" size="30" maxlength="50" />            </td>
      </tr>
	  
	
	  
	  
	  
      
	   
	 
    
    </table></td>
   </tr>
   <tr>
    <td  align="center"  height="40" ><? if($_GET['edit'] >0) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
&nbsp;
<input type="reset" name="Reset" value="Reset" class="button" />
<input type="hidden" name="MemberID" id="MemberID" value="<?php echo $_REQUEST['edit']; ?>" />
<input type="hidden" name="MemberApproval" id="MemberApproval" value="Auto" />
<input type="hidden" name="JoiningDate" id="JoiningDate" value="<? echo $arryMember[0]['JoiningDate']; ?>" />
<input type="hidden" name="PackageID" id="PackageID" value="<? echo $arryMember[0]['MembershipID']; ?>" />
<input type="hidden" name="Type" id="Type" value="<?php echo $_GET['opt']; ?>">
<input type="hidden" name="numTemplate" id="numTemplate" value="<?php echo sizeof($arryTemplate); ?>">






<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryMember[0]['state_id']; ?>" />	
		<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryMember[0]['city_id']; ?>" />




</td>
   </tr>
   </form>
</table>
	
	</td>
    </tr>
 
</table>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>