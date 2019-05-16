<script language="JavaScript1.2" type="text/javascript">


function ContinueForm(){

		var mmspobj=document.getElementById("TemplateIframe");
			
			if (mmspobj.tagName=='IFRAME'){
			
				var myval=window.frames[0].document.getElementById("TemplateIdHidden").value; 
				var myval2=window.frames[0].document.getElementById("templatePageHidden").value; 
				
				document.getElementById("templateID").value=myval;
				document.getElementById("templatePage").value=myval2;
				
				if(myval<=0){
					alert('Please select template.');
				}else{
					document.getElementById("TemplateDiv").style.display = 'none';
					document.getElementById("ContinueDiv").style.display = 'none';
					document.getElementById("FormDiv").style.display = 'inline';
					document.getElementById("BackDiv").style.display = 'inline';
					document.getElementById("SubmitDiv").style.display = 'inline';
					
				}			
				
			}	



	
}

function BackForm(){
	document.getElementById("TemplateDiv").style.display = 'inline';
	document.getElementById("ContinueDiv").style.display = 'inline';
	document.getElementById("FormDiv").style.display = 'none';
	document.getElementById("BackDiv").style.display = 'none';
	document.getElementById("SubmitDiv").style.display = 'none';
}

function ShowFetOption(){
	if(document.getElementById("Featured").value == 'Yes'){
		document.getElementById("FeaturedOptionDiv").style.display = 'inline';
	}else{
		document.getElementById("FeaturedOptionDiv").style.display = 'none';
	
	}
		document.getElementById("ImpressionDiv").style.display = 'none';
		document.getElementById("DurationDiv").style.display = 'none';

}

function ShowFetDiv(opt){

	if(opt==1){
		document.getElementById("ImpressionDiv").style.display = 'inline';
		document.getElementById("DurationDiv").style.display = 'none';
	}else if(opt==2){
		document.getElementById("ImpressionDiv").style.display = 'none';
		document.getElementById("DurationDiv").style.display = 'inline';
	}
	
}


 function ShowFetOption2(){
	if(document.getElementById("FeaturedWeb").value == 'Yes'){
		document.getElementById("FeaturedWebOptionDiv").style.display = 'inline';
	}else{
		document.getElementById("FeaturedWebOptionDiv").style.display = 'none';
	
	}
		document.getElementById("WebImpressionDiv").style.display = 'none';
		document.getElementById("WebDurationDiv").style.display = 'none';

}

function ShowFetDiv2(opt){

	if(opt==1){
		document.getElementById("WebImpressionDiv").style.display = 'inline';
		document.getElementById("WebDurationDiv").style.display = 'none';
	}else if(opt==2){
		document.getElementById("WebImpressionDiv").style.display = 'none';
		document.getElementById("WebDurationDiv").style.display = 'inline';
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


function ShowDeliveryOptions(){
	for(var i=1;i<=document.getElementById('NumDeliveryOption').value;i++){
		document.getElementById("DeliveryOptionDiv"+i).style.display = 'none';
	}
	for(i=1;i<=document.getElementById('DeliveryOption').value;i++){
		document.getElementById("DeliveryOptionDiv"+i).style.display = 'inline';
	}
}


function validateSeller(frm){
	
		if(frm.numTemplate.value>0){
		
			var mmspobj=document.getElementById("TemplateIframe");
			
			if (mmspobj.tagName=='IFRAME'){
			
				var myval=window.frames[0].document.getElementById("TemplateIdHidden").value; 
				var myval2=window.frames[0].document.getElementById("templatePageHidden").value; 
				
				document.getElementById("templateID").value=myval;
				document.getElementById("templatePage").value=myval2;
				
				if(myval<=0){
					alert('Please select template.');
					location.href="#";
					return false;
				}				
				
			}		
		

			/*
			if(!ValidateRadioButtons(frm.templateID, "Template")){
				return false;
			}*/
		}
		
		
		
		//if(frm.Website.value == 'http://')  frm.Website.value ='';

		var paymentSelected = 0;
		for(var i=1;i<=3;i++){
			if(document.getElementById("PaymentDiv"+i).style.display != 'none' ) {
				paymentSelected = 1;
				break;
			}
		}


		
			if(  ValidateForBlank(frm.UserName, "User Name")
					&& isUserName(frm.UserName)
					&& ValidateMandRange(frm.UserName, "User Name", 2, 25)
					&& ValidateForEmail(frm.Email, "Email")
					&& isEmail(frm.Email)
					&& ValidateForPassword(frm.Password, "Password")
					 && isPassword(frm.Password)
					&& ValidateMandRange(frm.Password, "Password",5,15)
					//&& ValidateOptNumField(frm.MaxEmail, "Email Credits")
					//&& ValidateOptNumField(frm.MaxSms, "Sms Credits")
					&& ValidateForSimpleBlank(frm.FirstName, "First Name")
					&& ValidateForSimpleBlank(frm.LastName, "Last Name")
					//&& ValidateIDNumber(frm.IDNumber,"ID Number")
					//&& isSkypeAddress(frm.SkypeAddress)
					&& ValidateForSimpleBlank(frm.Address, "Address")
					&& isPostCode(frm.PostCode)
					&& ValidateOptPhoneNumber(frm.LandlineNumber,"Landline Number")
					&& ValidateOptPhoneNumber(frm.Phone,"Mobile Number")
					&& ValidateOptFax(frm.Fax,"Fax Number")
					&& ValidateForSimpleBlank(frm.CompanyName, "Company Name")
					&& ValidateForBlankOpt(frm.ContactPerson, "Contact Person")
					//&& ValidateForBlankOpt(frm.Position, "Position")
					//&& ValidateOptNumField(frm.RegistrationNumber, "Registration Number")
					&& ValidateOptPhoneNumber(frm.ContactNumber,"Contact Number")
					//&& ValidateOptNumField(frm.VatNumber,"Sales Tax Number")
					//&& ValidateOptDecimalField(frm.VatPercentage,"Sales Tax Percentage")
					&& ValidateOptionalUpload(frm.Image, "Company Logo")
					&& ValidateOptionalUpload(frm.Banner, "Banner")
					//&& isValidLinkOpt(frm.Website,"Website")
					&& isEmailOpt(frm.AlternateEmail)
					//&& ValidateForSimpleBlank(frm.BillingFirstName, "First Name for Billing Information")
					//&& ValidateForSimpleBlank(frm.BillingLastName, "Last Name for Billing Information")
					//&& ValidateForSimpleBlank(frm.BillingCompany, "Company Name")
					//&& ValidateForSimpleBlank(frm.BillingAddress, "Billing Address")
					//&& isEmailOpt(frm.BillingEmail)
					//&& ValidateOptDecimalField(frm.PostalCourier,'Postal / Courier Fee')
					//&& ValidateOptDecimalField(frm.Airmail,'Airmail Fee')
					//&& ValidateOptDecimalField(frm.SeaFreight,'Sea-freight Fee')
				){
				
				
					if(frm.ExpiryDate.value>0){
						if(frm.JoiningDate.value > frm.ExpiryDate.value){
							alert("Expiry Date should be greater than Joining Date !!");
							frm.ExpiryDate.focus();
							return false;	
						}
					}


			/*
			if(document.getElementById("Featured").value == 'Yes'){
			
				if(!ValidateRadioButtons(frm.FeaturedType,"Featured Type")){
					return false;
				}
			
				if(document.getElementById("DurationDiv").style.display != 'none'){

					if(!ValidateForSimpleBlank(frm.FeaturedStart, "Featured Starting Date")){
						return false;
					}
					if(!ValidateForSimpleBlank(frm.FeaturedEnd, "Featured Closing Date")){
						return false;
					}
					
					if(frm.FeaturedStart.value>=frm.FeaturedEnd.value){
						alert("Featured Closing Date should be greater than Featured Starting Date !!");
						return false;
					}
				
				}


				if(document.getElementById("ImpressionDiv").style.display != 'none'){
					if(!ValidateOptNumField2(frm.Impression,"Total Impressions",1,1000000)){
						return false;
					}
					if(!ValidateOptNumField2(frm.ImpressionCount,"Impressions Shown",1,1000000)){
						return false;
					}
				}
				
				

			}

			
		if(document.getElementById("FeaturedWeb").value == 'Yes'){
			
				if(!ValidateRadioButtons(frm.FeaturedWebType,"Featured Type")){
					return false;
				}
			
				if(document.getElementById("WebDurationDiv").style.display != 'none'){

					if(!ValidateForSimpleBlank(frm.FeaturedWebStart, "Featured Starting Date")){
						return false;
					}
					if(!ValidateForSimpleBlank(frm.FeaturedWebEnd, "Featured Closing Date")){
						return false;
					}
					
					if(frm.FeaturedWebStart.value>=frm.FeaturedWebEnd.value){
						alert("Featured Closing Date should be greater than Featured Starting Date !!");
						return false;
					}
				
				}


				if(document.getElementById("WebImpressionDiv").style.display != 'none'){
					if(!ValidateOptNumField2(frm.WebImpression,"Total Impressions",1,1000000)){
						return false;
					}
					if(!ValidateOptNumField2(frm.WebImpressionCount,"Impressions Shown",1,1000000)){
						return false;
					}
				}
				
				

			}	
			
		*/	
		
		/*******  Delivery Fee Area *****/			
		/*
		if(document.getElementById('DeliveryOption').value>=1){
			for(var i=1;i<=document.getElementById('DeliveryOption').value;i++){
				if(!ValidateForSimpleBlank(document.getElementById('DeliveryName'+i),'Delivery Option-'+i)){
					return false;
				}
				if(!ValidateMandDecimalField(document.getElementById('DeliveryFee'+i),'Delivery Fee-'+i)){
					return false;
				}
			}
		}*/		
		/********* Payment Area *****/
		
		/*
		if(paymentSelected==0){
			alert('Please select atleast one payment type.');
			return false;
		}
	

		if(document.getElementById("PaymentDiv1").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.MyGate_MerchantID, "MyGate MerchantID")){
				return false;
			}
			
			if(!ValidateForSimpleBlank(frm.MyGate_ApplicationID, "MyGate ApplicationID")){
				return false;
			}
			
		}
		
		
		if(document.getElementById("PaymentDiv2").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.PaypalID, "PayPal ID")){
				return false;
			}
			
			if(!isEmail(frm.PaypalID)){
				return false;	
			}

		}


		if(document.getElementById("PaymentDiv3").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.AccountHolder, "Account Holder Name")){
				return false;
			}
			
			if(!ValidateMandNumField(frm.AccountNumber, "Account Number")){
				return false;
			}
			
			if(!ValidateForSimpleBlank(frm.BankName,"Bank Name")){
				return false;	
			}
			if(!ValidateForSimpleBlank(frm.BranchCode,"Branch Code")){
				return false;	
			}
			
		}

		
		if(!ValidateOptNumField(frm.AreaCode, "Area/Promotion Code")){
			return false;	
		}*/
		


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

<? if(sizeof($arryTemplate)>0) { ?>
	
 <tr>
    <td  align="center" valign="top" >
	
	<div id="TemplateDiv" style="display:none">
	<table width="100%" border="0" cellpadding="0" cellspacing="0"  >
	<tr>
	  <td   class="head1">&nbsp;Select Template </td>
	</tr> 	
	
	 <tr>
        <td height="32" valign="top" class="borderall">
		<iframe src="store_templates.php?templateID=<?=$arryMember[0]['templateID']?>&curP=<?=$arryMember[0]['templatePage']?>&templatePage=<?=$arryMember[0]['templatePage']?>" name="TemplateIframe" id="TemplateIframe" frameborder="0" style="border:none; margin:0px 0 0 0;" width="100%" height="140" scrolling="auto" ></iframe>        </td>
      </tr>
	<tr>
    <td  align="center"  >&nbsp;</td>
	</tr>	
	</table>
	
	</div>
	
<div align="center" id="ContinueDiv" style="display:none">
<input type="button" name="Continue" class="button" onclick="Javascript:ContinueForm();" value="Continue">
</div>
	
<div style="display:none; float:right; padding-right:90px;" id="BackDiv">
<a href="Javascript:BackForm();"><strong>Back</strong></a>
<br />
</div>
	
	
</td>
	</tr>		
<? } ?>
   <tr>
    <td  align="center" valign="top" >
	
	<div id="FormDiv" style="display:none1">
	<table width="80%" border="0" cellpadding="5" cellspacing="1"   class="borderall">
      
		<tr>
       		 <td colspan="2" align="left"   class="head1">Account Information</td>
        </tr>	  

     
      <tr>
        <td align="right"   class="blackbold"> Membership <span class="red">*</span> </td>
        <td height="30" align="left" >
	<?
	if($arryMember[0]['MembershipID'] != ''){
		$MembershipID = $arryMember[0]['MembershipID']; 
	}else{
		$MembershipID = 1;
	}
	?>
            <select name="MembershipID" class="inputbox" id="MembershipID" style="width: 195px;"
			<? // if(!empty($_GET['edit'])) echo " disabled "; ?> >
              <? for($i=0;$i<sizeof($arryMembership);$i++) {?>
              <option value="<?=$arryMembership[$i]['MembershipID']?>" <?  if($arryMembership[$i]['MembershipID']==$MembershipID){echo "selected";}?>>
              <?=$arryMembership[$i]['Name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
   

   
      <tr>
        <td  align="right" width="37%"   class="blackbold">User Name <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="UserName" type="text" class="inputbox" id="UserName" value="<?php echo stripslashes($arryMember[0]['UserName']); ?>" size="30" maxlength="50" <? if($arryMember[0]['UserName'] != '') echo 'Readonly';?>/>          <span class="blacknormal" >(Display Name) </span>
		
		<? /*
		 if($arryMember[0]['Status']==1) {
			$StoreLink = $Config['Url'].$Config['StorePrefix'].$arryMember[0]['UserName'].'/store.php';
		 	echo '<Span class=red>&nbsp;<a href="'.$StoreLink.'" target="_blank">(View Store)</a></span>';
		 } */
		
		?>		</td>
      </tr>
	
      <tr>
        <td  align="right"   class="blackbold">Email <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryMember[0]['Email']; ?>" size="30" maxlength="80"  <? if($arryMember[0]['Email'] != '') echo 'Readonly';?>/> <span class="blacknormal" >(Login ID) </span></td>
      </tr>
        <tr>
        <td  align="right"   class="blackbold">Password <span class="red">*</span> </td>
        <td  height="30" align="left" ><input name="Password" type="text" class="inputbox" id="Password" value="<?php echo stripslashes($arryMember[0]['Password']); ?>" size="30" maxlength="15" />          <span class="blacknormal" >(Password Limit: 5 to 15 characters.) </span></td>
      </tr>
    

	<tr style="display:none">
        <td  align="right"   class="blackbold" valign="top">Website / Online Store  </td>
        <td  height="30" align="left"  valign="top">
		<input type="radio" name="WebsiteStoreOption"  value="" <? if($arryMember[0]['WebsiteStoreOption'] == '') echo 'checked';?> /> None<br />
		<input type="radio" name="WebsiteStoreOption"  value="w" <? if($arryMember[0]['WebsiteStoreOption'] == 'w') echo 'checked';?> /> Website Only<br />
		<input type="radio" name="WebsiteStoreOption"   value="s" <? if($arryMember[0]['WebsiteStoreOption'] == 's') echo 'checked';?>/> Online Store Only<br />
		<input type="radio" name="WebsiteStoreOption"   value="ws" <? if($arryMember[0]['WebsiteStoreOption'] == 'ws') echo 'checked';?>/> Website with Online Store		</td>
      </tr>
	   <tr Style="display:none">
        <td  align="right"   class="blackbold" >Email Credits </td>
        <td height="30" align="left" ><input name="MaxEmail" type="text" class="inputbox" id="MaxEmail" value="<?php echo $arryMember[0]['MaxEmail']; ?>" size="6" maxlength="6" /></td>
      </tr>	 
	   <tr Style="display:none">
        <td  align="right"   class="blackbold" >Sms Credits </td>
        <td height="30" align="left" ><input name="MaxSms" type="text" class="inputbox" id="MaxSms" value="<?php echo $arryMember[0]['MaxSms']; ?>" size="6" maxlength="6" /></td>
      </tr>	

	
  	<? if($_GET['edit'] > 0 && ($arryMember[0]['WebsiteStoreOption']=='s' || $arryMember[0]['WebsiteStoreOption']=='ws')){?>
      <tr Style="display:none">
        <td align="right"   class="blackbold">Store Ranking </td>
        <td height="30" align="left"  class="red"><?=$RatingHTML?></td>
      </tr>
	  
	 	 <tr Style="display:none">
		  <td align="right" valign="middle"  class="blackbold">Product Posting Approval  </td>
		  <td align="left" valign="middle" class="blacknormal">
			<select name="PostingApproval" id="PostingApproval" class="inputbox" >
				<option value="" <? if($arryMember[0]['PostingApproval'] == '') echo 'selected';?>> Default </option>
				<option value="Admin" <? if($arryMember[0]['PostingApproval'] == 'Admin') echo 'selected';?>> Admin </option>
				<option value="Auto" <? if($arryMember[0]['PostingApproval'] == 'Auto') echo 'selected';?>> Auto </option>
			 </select>	 	</td>
	  </tr>		
  
	  <? } ?>
	  
	 
	  
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

	  
	  
<tr style="display:none" >
    <td align="right"  valign="top"  class="blackbold"> Featured  Store</td>
    <td height="30" align="left" valign="top">
      <select name="Featured" id="Featured" class="inputbox" onchange="Javascript: ShowFetOption();">
        <option value="No" <? if($arryMember[0]['Featured'] == 'No') echo 'selected';?>>No</option>
        <option value="Yes" <? if($arryMember[0]['Featured'] == 'Yes') echo 'selected';?>>Yes</option>
      </select>
	  
<Div id="FeaturedOptionDiv" <? if($arryMember[0]['Featured'] != 'Yes') echo 'style="display:none"';?>>
	 <br> 
<input type="radio" name="FeaturedType" onclick="Javascript:ShowFetDiv(1);" value="Impression"  <? if($arryMember[0]['FeaturedType'] == 'Impression') echo 'checked';?>>Impression<br>
		  <input type="radio" name="FeaturedType" onclick="Javascript:ShowFetDiv(2);"  value="Duration" <? if($arryMember[0]['FeaturedType'] == 'Duration') echo 'checked';?>>Duration		  
	  
	  
	  
<Div id="DurationDiv" <? if($arryMember[0]['FeaturedType'] == 'Impression' || $arryMember[0]['FeaturedType'] == '') echo 'style="display:none"';?>>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" >
      <tr>
        <td width="30%" height="30" class="blackbold"   >Starting Date <span class="red">*</span></td>
        <td width="70%"  ><? $FeaturedStart=$arryMember[0]['FeaturedStart']; if($FeaturedStart < 1) $FeaturedStart = ''; echo date_picker($FeaturedStart,'FeaturedStart');?></td>
      </tr>
      <tr>
        <td class="blackbold" height="30"   >Closing Date<span class="red">*</span> </td>
        <td  ><? $FeaturedEnd=$arryMember[0]['FeaturedEnd']; if($FeaturedEnd < 1) $FeaturedEnd = ''; echo date_picker($FeaturedEnd,'FeaturedEnd');?></td>
      </tr>
    </table>
	</Div>
	
	
	<Div id="ImpressionDiv" <? if($arryMember[0]['FeaturedType'] == 'Duration' || $arryMember[0]['FeaturedType'] == '') echo 'style="display:none"';?>>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" >
        <tr>
        <td width="27%" height="30"  class="blackbold"  ="">Total Impressions</td>
        <td width="73%"   ><input name="Impression" type="text" class="inputbox" id="Impression" value="<? echo $arryMember[0]['Impression']; ?>" size="10" maxlength="10"> </td>
      </tr>
	  <tr>
        <td  height="30"  class="blackbold" ="" >Impressions Shown</td>
        <td  ><input name="ImpressionCount" type="text" class="inputbox" id="ImpressionCount" value="<? echo $arryMember[0]['ImpressionCount']; ?>" size="10" maxlength="10">	</td>
      </tr>
    </table>
	</Div>		  
</Div>	  </td>
	 </tr>
	 
	 
	<tr style="display:none" >
    <td align="right"  valign="top"  class="blackbold"> Featured  Website</td>
    <td height="30" align="left" valign="top">
      <select name="FeaturedWeb" id="FeaturedWeb" class="inputbox" onchange="Javascript: ShowFetOption2();">
        <option value="No" <? if($arryMember[0]['FeaturedWeb'] == 'No') echo 'selected';?>>No</option>
        <option value="Yes" <? if($arryMember[0]['FeaturedWeb'] == 'Yes') echo 'selected';?>>Yes</option>
      </select>
	  
<Div id="FeaturedWebOptionDiv" <? if($arryMember[0]['FeaturedWeb'] != 'Yes') echo 'style="display:none"';?>>
	 <br> 
<input type="radio" name="FeaturedWebType" onclick="Javascript:ShowFetDiv2(1);" value="Impression"  <? if($arryMember[0]['FeaturedWebType'] == 'Impression') echo 'checked';?>>Impression<br>
		  <input type="radio" name="FeaturedWebType" onclick="Javascript:ShowFetDiv2(2);"  value="Duration" <? if($arryMember[0]['FeaturedWebType'] == 'Duration') echo 'checked';?>>Duration		  
	  
	  
	  
<Div id="WebDurationDiv" <? if($arryMember[0]['FeaturedWebType'] == 'Impression' || $arryMember[0]['FeaturedWebType'] == '') echo 'style="display:none"';?>>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" >
      <tr>
        <td width="30%" height="30" class="blackbold"   >Starting Date <span class="red">*</span></td>
        <td width="70%"  ><? $FeaturedWebStart=$arryMember[0]['FeaturedWebStart']; if($FeaturedWebStart < 1) $FeaturedWebStart = ''; echo date_picker($FeaturedWebStart,'FeaturedWebStart');?></td>
      </tr>
      <tr>
        <td class="blackbold" height="30"   >Closing Date<span class="red">*</span> </td>
        <td  ><? $FeaturedWebEnd=$arryMember[0]['FeaturedWebEnd']; if($FeaturedWebEnd < 1) $FeaturedWebEnd = ''; echo date_picker($FeaturedWebEnd,'FeaturedWebEnd');?></td>
      </tr>
    </table>
	</Div>
	
	
	<Div id="WebImpressionDiv" <? if($arryMember[0]['FeaturedWebType'] == 'Duration' || $arryMember[0]['FeaturedWebType'] == '') echo 'style="display:none"';?>>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" >
        <tr>
        <td width="27%" height="30"  class="blackbold"  ="">Total Impressions</td>
        <td width="73%"   ><input name="WebImpression" type="text" class="inputbox" id="WebImpression" value="<? echo $arryMember[0]['WebImpression']; ?>" size="10" maxlength="10"> </td>
      </tr>
	  <tr>
        <td  height="30"  class="blackbold" ="" >Impressions Shown</td>
        <td  ><input name="WebImpressionCount" type="text" class="inputbox" id="WebImpressionCount" value="<? echo $arryMember[0]['WebImpressionCount']; ?>" size="10" maxlength="10">	</td>
      </tr>
    </table>
	</Div>		  
</Div>	  </td>
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
	
	  <tr style="display:none">
        <td align="right"   class="blackbold">Skype Address  </td>
        <td height="30" align="left" ><input name="SkypeAddress" type="text" class="inputbox" id="SkypeAddress" value="<?php echo $arryMember[0]['SkypeAddress']; ?>" size="30" maxlength="50" /></td>
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
		Company Name <span class="red">*</span> </td>
        <td height="30" align="left" ><input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryMember[0]['CompanyName']); ?>" size="30" maxlength="50" /></td>
      </tr>
	   <tr >
        <td align="right"   class="blackbold" valign="top">Company Tag Line </td>
        <td height="30" align="left"  valign="top"> 
		<textarea name="TagLine" type="text" class="inputbox" id="TagLine" cols="27" rows="3"/><?=stripslashes($arryMember[0]['TagLine'])?></textarea></td>
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
	  
	
	  
	  
	  

	 <tr style="display:none">
        <td align="right"   class="blackbold">Sales Tax Number  </td>
        <td height="30" align="left" ><input name="VatNumber" type="text" class="inputbox" id="VatNumber" value="<?php echo stripslashes($arryMember[0]['VatNumber']); ?>" size="30" maxlength="50" /></td>
      </tr>
	  
	 <tr style="display:none">
        <td align="right"   class="blackbold">Sales Tax Percentage </td>
        <td height="30" align="left" ><input name="VatPercentage" type="text" class="inputbox" id="VatPercentage" value="<?php echo stripslashes($arryMember[0]['VatPercentage']); ?>" size="6" maxlength="5" /> %</td>
      </tr>
	  
	  <tr style="display:none">
        <td align="right"   class="blackbold" valign="top">Type of Sales Tax  </td>
        <td height="30" align="left" >
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
		<input name="TaxTypeOther" type="text" class="inputbox" value="<? echo $TaxType; ?>" size="12" maxlength="30" />		</td>
      </tr> 
	  

	  
	 
<tr>
    <td height="30" align="right" valign="top"   class="blackbold"> Company Logo  </td>
    <td  align="left" valign="top" class="blacknormal">
	<input name="Image" type="file" class="inputbox" id="Image" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	<?=$MSG[201]?>	</td>
  </tr>
<?php if($arryMember[0]['Image'] !='' && file_exists('../upload/company/'.$arryMember[0]['Image']) ){ ?>
<tr>
  <td  align="right"   class="blackbold">Current Logo </td>
    <td  height="30" align="left">
				
				
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=upload/company/<?=$arryMember[0][Image]?>', 150, 100, 'yes' );"><? echo '<img src="../resizeimage.php?w=70&h=70&img=upload/company/'.$arryMember[0]['Image'].'" border=0 >';?>			</a>				  </td>
  </tr>  
<?	} ?>
	  
	  
<tr>
    <td height="30" align="right" valign="top"   class="blackbold"> Banner  </td>
    <td  align="left" valign="top" class="blacknormal">
	<input name="Banner" type="file" class="inputbox" id="Banner" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	<?=$MSG[201]?>	</td>
  </tr>
<?php if($arryMember[0]['Banner'] !='' && file_exists('../upload/company/'.$arryMember[0]['Banner']) ){ ?>
<tr>
  <td  align="right"   class="blackbold">Current Banner </td>
    <td  height="30" align="left">
				
				
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=upload/company/<?=$arryMember[0]['Banner']?>', 150, 100, 'yes' );"><? echo '<img src="../resizeimage.php?w=300&h=300&img=upload/company/'.$arryMember[0]['Banner'].'" border=0 >';?>			</a>				  </td>
  </tr>  
<?	} ?>	  
	  
	  
	  <!--
	    <tr>
        <td align="right"   class="blackbold" valign="top">Website </td>
        <td height="30" align="left"  class="blacknormal"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arryMember[0]['Website']))?($arryMember[0]['Website']):("http://")?>" size="30" maxlength="100" /> <?=$MSG[205]?></td>
      </tr>-->
	 


		
	
	 
	  <tr>
        <td align="right"   class="blackbold">Alternate Email  </td>
        <td height="30" align="left" ><input name="AlternateEmail" type="text" class="inputbox" id="AlternateEmail" value="<?php echo $arryMember[0]['AlternateEmail']; ?>" size="30" maxlength="50" /></td>
      </tr>

       
	   
	   
   
		 <tr style="display:none">
       		 <td colspan="2" align="left"   class="head1">Billing Information</td>
        </tr> 
		  <tr style="display:none">
        <td  align="right"   class="blackbold"> First Name <span class="red">*</span> </td>
        <td  height="30" align="left" >
<input name="BillingFirstName" type="text" class="inputbox" id="BillingFirstName" value="<?php echo stripslashes($arryMember[0]['BillingFirstName']); ?>" size="30" maxlength="50" />            </td>
      </tr>
	     <tr style="display:none">
        <td  align="right"   class="blackbold"> Last Name <span class="red">*</span> </td>
        <td  height="30" align="left" >
<input name="BillingLastName" type="text" class="inputbox" id="BillingLastName" value="<?php echo stripslashes($arryMember[0]['BillingLastName']); ?>" size="30" maxlength="50" />            </td>
      </tr>
	   <tr style="display:none">
        <td  align="right"   class="blackbold"> Company <span class="red">*</span> </td>
        <td  height="30" align="left" >
<input name="BillingCompany" type="text" class="inputbox" id="BillingCompany" value="<?php echo stripslashes($arryMember[0]['BillingCompany']); ?>" size="30" maxlength="50" />            </td>
      </tr>
	   <tr style="display:none">
        <td  align="right"   class="blackbold" valign="top">Address <span class="red">*</span> </td>
        <td  height="30" align="left" >
 <textarea name="BillingAddress" type="text" class="inputbox" id="BillingAddress" cols="27" rows="3"/><?php echo stripslashes($arryMember[0]['BillingAddress']); ?></textarea>           </td>
      </tr>
	    <tr style="display:none">
        <td  align="right"   class="blackbold"> Alternate Email </td>
        <td  height="30" align="left" >
<input name="BillingEmail" type="text" class="inputbox" id="BillingEmail" value="<?php echo stripslashes($arryMember[0]['BillingEmail']); ?>" size="30" maxlength="50" />            </td>
      </tr>
	  
	  <tr style="display:none">
       		 <td colspan="2" align="left"   class="head1">Delivery Fee Information</td>
        </tr>
		
		 <tr style="display:none">
            <td  class="blackbold" align="right" >Delivery Options </td>
            <td valign="middle">
			<select name="DeliveryOption"  id="DeliveryOption" class="blacknormal" style="width: 200px;" onchange="Javascript: ShowDeliveryOptions();" >
              <option value="0" >None</option>
              <? for($i=1;$i<=$Config['NumDeliveryOption'];$i++) {?>
              <option value="<?=$i?>" <?  if($i==sizeof($arryDelivery)){echo "selected";}?>>
              <?=$i?>
              </option>
              <? } ?>
            </select></td>
          </tr>
		
         <tr>
           <td  colspan="2" valign="top">
		   
  <? for($i=1;$i<=$Config['NumDeliveryOption'];$i++) { 
	  	$Counter = $i-1;
	  ?>
	  
	    <Div id="DeliveryOptionDiv<?=$i?>" <? if(sizeof($arryDelivery)<$i) echo 'style="display:none"';?> >
       <table width="100%" border="0" cellspacing="1" cellpadding="4" >
                <tr>
                  <td height="30" width="37%" align="right" valign="middle"  class="blackbold">
				  
				  Delivery Option
				    <?=$i?> <span class="red">*</span></td>
                  <td  height="30" align="left" valign="middle" >
		 <input name="DeliveryName<?=$i?>" type="text" class="txtfield" id="DeliveryName<?=$i?>" value="<?=stripslashes($arryDelivery[$Counter]['Name'])?>"  maxlength="200" size="30" />
		 <span class="blackbold">
		 <input type="checkbox" name="DeliveryStatus<?=$i?>" id="DeliveryStatus<?=$i?>"  value="1" 
				  <? if($arryDelivery[$Counter]['Status']==1) echo 'checked';?> />
		 </span>				  </td>
                </tr>
				 <tr>
                <td height="30" align="right" valign="middle" class="blackbold" >
				Delivery Fee <?=$i?> <span class="red">*</span> </td>
                <td  height="30" align="left" valign="middle" class="blacknormal" ><input name="DeliveryFee<?=$i?>" type="text" class="txtfield" id="DeliveryFee<?=$i?>" value="<?=stripslashes($arryDelivery[$Counter]['Price'])?>"  maxlength="6" size="23" /> <span id="DeliverySpanCurrency<?=$i?>"><?=$StoreCurrency?></span>                  </td>
              </tr>
            </table>
		</Div>
		<? } ?>		   </td>
         </tr>
          <tr style="display:none">
       		 <td colspan="2" align="left"   class="head1">Payment Information </td>
        </tr>
		<tr style="display:none">
			  <td align="right" valign="middle"  class="blackbold">Store Currency <span class="red">*</span></td>
			  <td align="left" valign="middle" class="blacknormal">
			   <? 
	if($arryMember[0]['currency_id'] != ''){
		$CurrencySelected = $arryMember[0]['currency_id']; 
	}else{
		$CurrencySelected = 9;
	}
	?>
           <select name="currency_id" class="blacknormal" id="currency_id" onchange="Javascript:SetDeliveryCurrency();" >
             <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
               <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>><?=$arryCurrency[$i]['name']?></option>
             <? } ?>
         </select>			  		  </td>
			  </tr>	 	
		<tr style="display:none">
			  <td align="right" valign="middle"  class="blackbold">Payment Type <span class="red">*</span></td>
			  <td align="left" valign="middle" class="blacknormal">
			  
			  <? for($i=0;$i<sizeof($arrayPaymentGateways);$i++){
				$Line = $i+1;
				$fieldname = $arrayPaymentGateways[$i]['fieldname'];
				if($Line==4) { 
					$Line=3; 
				}
			?>
		<input type="checkbox" name="<?=$arrayPaymentGateways[$i]['fieldname']?>" id="<?=$arrayPaymentGateways[$i]['fieldname']?>" onclick="Javascript:ShowPayDiv('<?=$Line?>','<?=$fieldname?>');" value="1"  <? if($arryMember[0][$arrayPaymentGateways[$i]['fieldname']] == '1' || $i==1) echo 'checked';?>><?=$arrayPaymentGateways[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;		
			<? } ?>			  </td>
			  </tr>	  
			  
			    <tr>
			      <td colspan="2" valign="top" >
			
			
				  
<table width="100%" border="0" cellspacing="0" cellpadding="0">

			
<tr>
              <td align="center" valign="top"  >
			  <Div id="PaymentDiv1" <? if($arryMember[0]['MyGatePayment'] != 1) echo 'style="display:none"';?>>
			  <table width="100%" border="0" cellspacing="1" cellpadding="4" >
                 
					
					    <tr>
                          <td width="37%" height="30" align="right" valign="middle"  class="blackbold">MyGate Mode<span class="red">*</span>                              </td>
                          <td width="63%"  height="30" align="left" valign="middle">
						  <select name="MyGate_Mode" id="MyGate_Mode" class="blacknormal" style="width: 200px;">
                            <option value="0" <? if($arryMember[0]['MyGate_Mode'] == '0') echo 'selected';?>> Test Mode </option>
                            <option value="1" <? if($arryMember[0]['MyGate_Mode'] == '1') echo 'selected';?>> Live Mode </option>
                          </select>						  </td>
                        </tr>
				
						<tr>
                          <td  height="30" align="right" valign="middle"  class="blackbold" ="">MyGate MerchantID<span class="red">*</span>       </td>
                          <td  height="30" align="left" valign="middle"><input name="MyGate_MerchantID" type="text" class="inputbox"id="MyGate_MerchantID" value="<? echo $arryMember[0]['MyGate_MerchantID']; ?>"  maxlength="50" size="30" /></td>
                        </tr>
						
                      
						 <tr>
                          <td w height="30" align="right" valign="middle"  class="blackbold">MyGate ApplicationID<span class="red">*</span>                              </td>
                          <td height="30" align="left" valign="middle"><input name="MyGate_ApplicationID" type="text" class="inputbox"id="MyGate_ApplicationID" value="<? echo stripslashes($arryMember[0]['MyGate_ApplicationID']); ?>"  maxlength="50" size="30" /></td>
                        </tr>
                    </table>
			  </Div>
			  
			  
	<Div id="PaymentDiv2" style="display:none" <? //if($arryMember[0]['PaypalPayment'] != 1) echo 'style="display:none"';?>>
			<table width="100%" border="0" cellspacing="1" cellpadding="4" >
				    
				
						<tr>
                          <td  width="37%"  align="right" valign="top"  class="blackbold" ="">PayPal ID<span class="red">*</span>       </td>
                          <td width="63%" align="left" valign="top"><input name="PaypalID" type="text" class="inputbox"id="PaypalID" value="<? echo stripslashes($arryMember[0]['PaypalID']); ?>"  maxlength="80" size="30" /></td>
                        </tr>
                    </table>
			  </Div>		  
			  
	 <Div id="PaymentDiv3" <? if($arryMember[0]['EftPayment'] != 1) echo 'style="display:none"';?>>
	   <table width="100%" border="0" cellspacing="1" cellpadding="4" >
           
             
		 
		
         <tr>
           <td  height="30" width="37%"  align="right" valign="middle"  class="blackbold" ="">
		  Account Holder 
               <span class="red">*</span> </td>
           <td width="63%"  height="30" align="left" valign="middle"><input name="AccountHolder" type="text" class="inputbox"id="AccountHolder" value="<? echo stripslashes($arryMember[0]['AccountHolder']); ?>"  maxlength="50" size="30" /></td>
         </tr>
         <tr>
           <td  height="30"  align="right" valign="middle"  class="blackbold" ="">Account Number 
               <span class="red">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountNumber" type="text" class="inputbox"id="AccountNumber" value="<? echo stripslashes($arryMember[0]['AccountNumber']); ?>"  maxlength="40" size="30" /></td>
         </tr>
         <tr>
           <td  height="30" align="right" valign="middle"  class="blackbold">Bank Name
               <span class="red">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BankName" type="text" class="inputbox"id="BankName" value="<? echo stripslashes($arryMember[0]['BankName']); ?>"  maxlength="40" size="30" /></td>
         </tr>
		  <tr>
           <td  height="30" align="right" valign="middle"  class="blackbold">Branch Code
               <span class="red">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BranchCode" type="text" class="inputbox"id="BranchCode" value="<? echo stripslashes($arryMember[0]['BranchCode']); ?>"  maxlength="30" size="30" /></td>
         </tr>
		  <tr>
           <td  height="30" align="right" valign="middle"  class="blackbold">Swift Number                </td>
           <td height="30" align="left" valign="middle"><input name="SwiftNumber" type="text" class="inputbox"id="SwiftNumber" value="<? echo stripslashes($arryMember[0]['SwiftNumber']); ?>"  maxlength="30" size="30" /></td>
         </tr>
       </table>
	 </Div>		  			  
			  
			  
		<Div id="ShippingDiv"
	<? if($arryMember[0]['MyGatePayment'] == 1 ||  $arryMember[0]['PaypalPayment'] == 1 || $arryMember[0]['EftPayment'] == 1 ||  $arryMember[0]['DepositPayment'] == 1) echo 'style="display:inline"'; else echo 'style="display:none"';?>	
		
		>
		 <table width="100%" border="0" cellspacing="0" cellpadding="4" style="display:none">
			  
			   <tr>
					  <td width="37%" height="30" align="right" valign="middle"  class="blackbold">Shipping Charge (%)      </td>
					  <td width="63%"   align="left" valign="middle"><input name="Shipping" type="text" class="inputbox"id="Shipping" value="<? echo $arryMember[0]['Shipping']; ?>"  maxlength="5" size="30" /></td>
					</tr>
		  </table>
		</Div>			  </td>
            </tr>	           
</table>				  </td>
			      </tr>	  
	  
	   <tr style="display:none">
       		 <td colspan="2" align="left"   class="head1">Area/Promotion Code </td>
        </tr>
		  <tr style="display:none">
           <td  height="30" align="right" valign="middle"  class="blackbold">Area/Promotion Code                </td>
           <td height="30" align="left" valign="middle"><input name="AreaCode" type="text" class="inputbox" id="AreaCode" value="<? echo stripslashes($arryMember[0]['AreaCode']); ?>"  maxlength="8" size="30" /></td>
         </tr>
		
	  
	 
    
    </table>
	
	</div>
	
	
	</td>
   </tr>
   <tr>
    <td  align="center"  height="40" >
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="MemberID" id="MemberID" value="<?php echo $_REQUEST['edit']; ?>" />
<input type="hidden" name="MemberApproval" id="MemberApproval" value="Auto" />
<input type="hidden" name="JoiningDate" id="JoiningDate" value="<? echo $arryMember[0]['JoiningDate']; ?>" />
<input type="hidden" name="PackageID" id="PackageID" value="<? echo $arryMember[0]['MembershipID']; ?>" />
<input type="hidden" name="Type" id="Type" value="<?php echo $_GET['opt']; ?>">
<input type="hidden" name="numTemplate" id="numTemplate" value="<?php echo sizeof($arryTemplate); ?>">

<input type="hidden" name="OldTemplateID" id="OldTemplateID" value="<? echo $arryMember[0]['templateID']; ?>">

<input name="templateID" id="templateID" type="hidden" value="<?=$arryMember[0]['templateID']?>" />
<input name="templatePage" id="templatePage" type="hidden" value="<?=$arryMember[0]['templatePage']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryMember[0]['state_id']; ?>" />	
		<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryMember[0]['city_id']; ?>" />
 <input type="hidden" name="NumDeliveryOption" id="NumDeliveryOption" value="<?=$NumDeliveryOption?>" />

</div>

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