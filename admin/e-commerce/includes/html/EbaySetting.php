<script language="JavaScript1.2" type="text/javascript">
function validateEmployee(frm)
{

	var DataExist=0;

	if(document.getElementById("Uid").value>0)
	{
		
	
	/*
	if(!isPassword(frm.Password))
		{
		return false;
	}*/
	if(!ValidateMandRange(frm.newPassword, "Password",5,15))
		{
		return false;
	}
	if(!ValidateForPasswordConfirm(frm.newPassword,frm.ConfirmPassword)){
		return false;
	}
	}
	

	if(ValidateForSimpleBlank(frm.DeveloperID, "Sandbox DeveloperID") 
			&& ValidateForSimpleBlank(frm.ApplicationID, "Sandbox ApplicationID")
		&& ValidateForSimpleBlank(frm.CertificateID, "Sandbox CertificateID") 
		
		
		
		&& ValidateForSimpleBlank(frm.UserToken,"Sandbox UserToken")
		&& ValidateForSimpleBlank(frm.PaypalEmailAddress,"Sandbox PaypalEmailAddress")
		
			
		&& ValidateForSimpleBlank(uEmail, "Email")
		&& isEmail(frm.uEmail)
		)
		{
									
		
					if(document.getElementById("Uid").value<=0)
						{
					
						if(!ValidateForSimpleBlank(frm.uPassword, "Password"))
							{
							return false;
						}
						
						/*
						if(!isPassword(frm.Password)){
							return false;
						}*/
						if(!ValidateMandRange(frm.uPassword, "Password",5,15))
							{
							return false;
						}
						if(!ValidateForPasswordConfirm(frm.uPassword,frm.ConfirmPassword)){
							return false;
						}
					
					}
					
					

										
				


					

					/**********************
					DataExist = CheckExistingData("isRecordExists.php", "&Type=User&Email="+escape(document.getElementById("uEmail").value)+"&Uid="+document.getElementById("Uid").value, "Email","Email Address");

						if(DataExist==1)return false;
					/**********************/

					
					var Url = "isRecordExists.php?Type=User&uEmail="+escape(document.getElementById("uEmail").value)+"&Uid="+document.getElementById("Uid").value;
					SendExistRequest(Url,"uEmail", "Email Address");

					return false;	
					
			}
	
	       else
		     {
					return false;	
			}
}
$(document).ready(function() {
	$(".activeCredential").hide();
	$(".SandboxActiveCredential").hide();
	if($('input[name=Credentials]:checked').val()=='Sandbox'){
		$(".SandboxActiveCredential").show();
	}else{
		$(".activeCredential").show();
	}
	
    $('input[type=radio][name=Credentials]').change(function() {
		if($('input[name=Credentials]:checked').val()=='Sandbox'){
			$(".SandboxActiveCredential").show();
			$(".activeCredential").hide();
		}else{
			$(".SandboxActiveCredential").hide();
			$(".activeCredential").show();
		}
	});

	$("#sync_product").change(function(){
		if($( this ).val() =='1'){
			$(".sync_product").show();
		}else{
			$(".sync_product").hide();
		}
	});
});

function ShowFeeRate(){
	if($("#Fee").val() =='1'){
		$(".fee_rate").show();
	}else{
		$(".fee_rate").hide();
	}
}
</script>

<?php $display1 = 'display:none'; 
	if($arryEbayCredentials[0]['sync_product']) $display1 = '';
	
?>

<div class="e_right_box">

	<div class="message" align="center"><? if(!empty($_SESSION['CRE_Update'])) {echo $_SESSION['CRE_Update']; unset($_SESSION['CRE_Update']); }?></div>

	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<form name="form1" action="" method="post"
			onSubmit="return validateEmployee(this);"
			enctype="multipart/form-data">

<?

if (($_GET ["tab"] == "user" || $_GET ["curP"] == "1" || $_GET ["tab"] == "personal") && ($_GET ["tab"] != "account" && $_GET ["tab"] != "role")) {
	?>
<input type="hidden" name="ebayid" id="ebayid" value="<?php echo stripslashes($arryEbayCredentials[0]['ebay_ID']); ?>" />

   <tr>
				<td align="center" valign="top">

  
					<table width="100%" border="0" cellpadding="5" cellspacing="0"
						class="borderall">


						<tr>
							<td colspan="4" align="left" class="head">

 <a href="vEbayInfo.php" class="grey_bt">Ebay API Instructions</a>
Ebay Credentials</td>
						</tr>
						<tr>

							<td align="right" class="blackbold">Set Credentials :</td>
							<td align="left">




          <?
	$ActiveChecked = 'checked';
	
	if ($arryEbayCredentials [0] ['credential_Type'] == 'Sandbox') {
		$ActiveChecked = ' checked';
		$InActiveChecked = '';
	}
	if ($arryEbayCredentials [0] ['credential_Type'] == 'Production') {
		$ActiveChecked = '';
		$InActiveChecked = ' checked';
	}
	
	?>
          <input type="radio" name="Credentials" id="Credentials"
								value="Sandbox" <?=$ActiveChecked?> />
								Sandbox&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
								name="Credentials" id="Credentials" value="Production"
								<?=$InActiveChecked?> /> Production
							</td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold"><b> Basic Settings For Sandbox</b>
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold" width="20%">Sandbox
								DeveloperID:<span class="red">*</span>
							</td>
							<td align="left" width="40%"><input name="DeveloperID"
								type="text" class="inputbox" id="DeveloperID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_devID']); ?>"
								onkeypress="" /></td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold" width="15%">Sandbox
								ApplicationID:<span class="red">*</span>
							</td>
							<td align="left"><input name="ApplicationID" type="text"
								class="inputbox" id="ApplicationID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_appID']); ?>"
								onkeypress="" /></td>
						</tr>


						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox CertificateID:<span
								class="red">*</span>
							</td>
							<td align="left"><input name="CertificateID" type="text"
								class="inputbox" id="CertificateID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_certID']); ?>"
								onkeypress="" /></td>
						</tr>



						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox UserToken:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="UserToken" type="text"
								class="inputbox" id="UserToken"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_userToken']); ?>"
								onkeypress="" /></td>
						</tr>
						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox payment method:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="s_payment_method"
								type="text" class="inputbox" id="s_payment_method"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_payment_method']); ?>"
								onkeypress="" /></td>
						</tr>
						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox payment method EmailAddress:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="PaypalEmailAddress"
								type="text" class="inputbox" id="PaypalEmailAddress"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_paypalEmailAddress']); ?>"
								onkeypress="" /></td>
						</tr>



						
						<tr class="activeCredential">
							<td align="right" class="blackbold"><b> Basic Settings For Production</b>
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						<tr class="activeCredential">
							<td align="right" class="blackbold" width="20%">Production
								DeveloperID:<span class="red">*</span>
							</td>
							<td align="left" width="40%"><input name="PDeveloperID"
								type="text" class="inputbox" id="PDeveloperID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_devID']); ?>"
								onkeypress="" /></td>
						</tr>
						<tr class="activeCredential">
							<td align="right" class="blackbold" width="15%">Production
								ApplicationID:<span class="red">*</span>
							</td>
							<td align="left"><input name="PApplicationID" type="text"
								class="inputbox" id="PApplicationID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_appID']); ?>"
								onkeypress="" /></td>


						</tr>


						<tr class="activeCredential">
							<td align="right" class="blackbold">Production CertificateID:<span
								class="red">*</span>
							</td>
							<td align="left"><input name="PCertificateID" type="text"
								class="inputbox" id="PCertificateID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_certID']); ?>"
								onkeypress="" /></td>


						</tr>



						<tr class="activeCredential">
							<td align="right" class="blackbold">Production UserToken:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="PUserToken" type="text"
								class="inputbox" id="PUserToken"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_userToken']); ?>"
								onkeypress="" /></td>
						</tr>
						
						<tr class="activeCredential">
							<td align="right" class="blackbold">Payment Method:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="p_payment_method"
								type="text" class="inputbox" id="p_payment_method"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_payment_method']); ?>"
								onkeypress="" /></td>
						</tr>
						
						<tr class="activeCredential">
							<td align="right" class="blackbold">Production
								Payment Method EmailAddress:<span class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="PPaypalEmailAddress"
								type="text" class="inputbox" id="PPaypalEmailAddress"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_paypalEmailAddress']); ?>"
								onkeypress="" /> 
							</td>
						</tr>


 
<tr style="display:none5">
		<td align="right" class="blackbold"> Fee Calculation:<span
			class="red">*</span>
		</td>
		<td align="left" colspan="3"> 
<select name="Fee" id="Fee" class="inputbox" onchange="Javascript:ShowFeeRate();">
	<option value="0" <?=($arryEbayCredentials[0]['Fee']!="1")?("selected"):("")?>>Ebay + Payment Provider</option>
	<option value="1" <?=($arryEbayCredentials[0]['Fee']=="1")?("selected"):("")?>>Only Ebay</option>
</select>

</td>
	</tr>
<tr   <?=($arryEbayCredentials[0]['Fee']=="1")?(""):('style="display:none"')?> class="fee_rate">
		<td align="right" class="blackbold"> Payment Provider Rate [%]: 
		</td>
		<td align="left" colspan="3"> 
 
<input name="FeeRate" type="text" class="inputbox" id="FeeRate" value="<?php echo stripslashes($arryEbayCredentials[0]['FeeRate']); ?>" onkeypress="return isDecimalKey(event);" maxlength="5" />
</td>
	</tr>

						
						<?php $returnpolicy = (array)json_decode($arryEbayCredentials[0]['s_return_policy']);?>
<!-- Return Policy Settings Sandbox-->						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold"><b> Return Policy Settings For Sandbox</b>
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Returns Within Option:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<select class="inputbox" name="s_ReturnsWithin">
				  				 	<option value="Days_7" <?php if($returnpolicy['s_ReturnsWithin']=='Days_7') echo 'selected';?>>7 days</option>
						             <option value="Days_30" <?php if($returnpolicy['s_ReturnsWithin']=='Days_30') echo 'selected';?>>30 days</option>
						             <option value="Days_180" <?php if($returnpolicy['s_ReturnsWithin']=='Days_180') echo 'selected';?>>180 days</option>
						             <option value="Days_360" <?php if($returnpolicy['s_ReturnsWithin']=='Days_360') echo 'selected';?>>360 days</option>
					          </select>             
						  </td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Description:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<input name="s_ReturnsDesc"
								type="text" class="inputbox" id="s_ReturnsDesc"
								value="<?php echo stripslashes($returnpolicy['s_ReturnsDesc']); ?>"
								onkeypress="" />
						  </td>
						</tr>
						
						<?php $Shipping = (array) json_decode($arryEbayCredentials[0]['s_shipping_details']);?>
<!-- Shipping Details Settings Sandbox-->						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold"><b> Shipping Details Settings For Sandbox</b>
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Returns Within Option:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<select class="inputbox" name="s_ShippingType">
				  				 	<option value="Calculated" <?php if($Shipping['s_ShippingType']=='Calculated') echo 'selected';?>>Calculated</option>
						             <option value="CalculatedDomesticFlatInternational" <?php if($Shipping['s_ShippingType']=='CalculatedDomesticFlatInternational') echo 'selected';?>>Calculated Domestic Flat International</option>
						             <option value="Flat" <?php if($Shipping['s_ShippingType']=='Flat') echo 'selected';?>>Flat</option>
						             <option value="FlatDomesticCalculatedInternational" <?php if($Shipping['s_ShippingType']=='FlatDomesticCalculatedInternational') echo 'selected';?>>Flat Domestic Calculated International</option>
						             <option value="Free" <?php if($Shipping['s_ShippingType']=='Free') echo 'selected';?>>Free</option>
						             <option value="Freight" <?php if($Shipping['s_ShippingType']=='Freight') echo 'selected';?>>Freight</option>
						             <option value="FreightFlat" <?php if($Shipping['s_ShippingType']=='FreightFlat') echo 'selected';?>>FreightFlat</option>
					          </select>             
						  </td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Shipping Service:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<select class="inputbox" name="s_ShippingService">
				  				 	<option value="USPSMedia" <?php if($Shipping['s_ShippingService']=='USPSMedia') echo 'selected';?>>USPS Media</option>
						             <option value="USPSGlobalExpress" <?php if($Shipping['s_ShippingService']=='USPSGlobalExpress') echo 'selected';?>>USPS Global Express Mail</option>
						             <option value="USPSGround" <?php if($Shipping['s_ShippingService']=='USPSGround') echo 'selected';?>>USPS Ground</option>
						             <option value="UPSGround" <?php if($Shipping['s_ShippingService']=='UPSGround') echo 'selected';?>>UPS Ground</option>
					          </select>             
						  </td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Shipping Service Cost:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<input name="s_ShippingServiceCost"
								type="text" class="inputbox" id="s_ShippingServiceCost"
								value="<?php echo stripslashes($Shipping['s_ShippingServiceCost']); ?>" />
						  </td>
						</tr>
<!-- end Shipping Details Settings -->	

<!-- Return Policy Settings Production-->				
<?php $p_returnpolicy = (array) json_decode($arryEbayCredentials[0]['p_return_policy']);?>		
						<tr class="activeCredential">
							<td align="right" class="blackbold"><b> Return Policy Settings For Production</b>
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						
						<tr class="activeCredential">
							<td align="right" class="blackbold">Returns Within Option:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<select class="inputbox" name="p_ReturnsWithin">
				  				 	<option value="Days_7" <?php if($p_returnpolicy['p_ReturnsWithin']=='Days_7') echo 'selected';?>>7 days</option>
						             <option value="Days_30" <?php if($p_returnpolicy['p_ReturnsWithin']=='Days_30') echo 'selected';?>>30 days</option>
						             <option value="Days_180" <?php if($p_returnpolicy['p_ReturnsWithin']=='Days_180') echo 'selected';?>>180 days</option>
						             <option value="Days_360" <?php if($p_returnpolicy['p_ReturnsWithin']=='Days_360') echo 'selected';?>>360 days</option>
					          </select>             
						  </td>
						</tr>
						<tr class="activeCredential">
							<td align="right" class="blackbold">Description:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<input name="p_ReturnsDesc"
								type="text" class="inputbox" id="p_ReturnsDesc"
								value="<?php echo stripslashes($p_returnpolicy['p_ReturnsDesc']); ?>"
								onkeypress="" />
						  </td>
						</tr>
				<?php $p_Shipping = (array) json_decode($arryEbayCredentials[0]['p_shipping_details']);?>		
<!-- Shipping Details Settings Production-->						
						<tr class="activeCredential">
							<td align="right" class="blackbold"><b> Shipping Details Settings For Production</b>
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						
						<tr class="activeCredential">
							<td align="right" class="blackbold">Returns Within Option:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<select class="inputbox" name="p_ShippingType">
				  				 	<option value="Calculated" <?php if($p_Shipping['p_ShippingType']=='Calculated') echo 'selected';?>>Calculated</option>
						             <option value="CalculatedDomesticFlatInternational" <?php if($p_Shipping['p_ShippingType']=='CalculatedDomesticFlatInternational') echo 'selected';?>>Calculated Domestic Flat International</option>
						             <option value="Flat" <?php if($p_Shipping['p_ShippingType']=='Flat') echo 'selected';?>>Flat</option>
						             <option value="FlatDomesticCalculatedInternational" <?php if($p_Shipping['p_ShippingType']=='FlatDomesticCalculatedInternational') echo 'selected';?>>Flat Domestic Calculated International</option>
						             <option value="Free" <?php if($p_Shipping['p_ShippingType']=='Free') echo 'selected';?>>Free</option>
						             <option value="Freight" <?php if($p_Shipping['p_ShippingType']=='Freight') echo 'selected';?>>Freight</option>
						             <option value="FreightFlat" <?php if($p_Shipping['p_ShippingType']=='FreightFlat') echo 'selected';?>>FreightFlat</option>
					          </select>             
						  </td>
						</tr>
						<tr class="activeCredential">
							<td align="right" class="blackbold">Shipping Service:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<select class="inputbox" name="p_ShippingService">
				  				 	<option value="USPSMedia" <?php if($p_Shipping['p_ShippingService']=='USPSMedia') echo 'selected';?>>USPS Media</option>
						             <option value="USPSGlobalExpress" <?php if($p_Shipping['p_ShippingService']=='USPSGlobalExpress') echo 'selected';?>>USPS Global Express Mail</option>
						             <option value="USPSGround" <?php if($p_Shipping['p_ShippingService']=='USPSGround') echo 'selected';?>>USPS Ground</option>
						             <option value="UPSGround" <?php if($p_Shipping['p_ShippingService']=='UPSGround') echo 'selected';?>>UPS Ground</option>
						             <option value="UPS3rdDay" <?php if($p_Shipping['p_ShippingService']=='UPS3rdDay') echo 'selected';?>>UPS 3rd Day</option>
						             <option value="USPSPriorityMailInternational" <?php if($p_Shipping['p_ShippingService']=='USPSPriorityMailInternational') echo 'selected';?>>USPS Priority MailInternational</option>
						             <option value="UPSWorldwideSaver" <?php if($p_Shipping['p_ShippingService']=='UPSWorldwideSaver') echo 'selected';?>>UPS Worldwide Saver</option>
						             <option value="UPSWorldWideExpress" <?php if($p_Shipping['p_ShippingService']=='UPSWorldWideExpress') echo 'selected';?>>UPS WorldWide Express</option>
					          </select>             
						  </td>
						</tr>
						<tr class="activeCredential">
							<td align="right" class="blackbold">Shipping Service Cost:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3">
				  				<input name="p_ShippingServiceCost"
								type="text" class="inputbox" id="p_ShippingServiceCost"
								value="<?php echo stripslashes($p_Shipping['p_ShippingServiceCost']); ?>"/>
						  </td>
						</tr>
<!-- end Shipping Details Settings -->	

<!-- Sync products settings -->
						<tr>
							<td align="right" class="blackbold">
								<b>Sync Products: </b> <br/>  (Set defaults for product addition as a batch or direct submit)
							</td>
							<td align="left" colspan="3"></td>
						</tr>
						
						<tr>
							<td align="right" class="blackbold">
							List item under condition in the category with the lowest price? 
							</td>
							<td align="left" colspan="3">
							<select class=" inputbox select" title="sync_product" name=sync_product id="sync_product">
									<option value="0" <?php if(isset($arryEbayCredentials[0]['sync_product']) && $arryEbayCredentials[0]['sync_product']==0) echo "selected";?>>No</option> 			
									<option value="1" <?php if($arryEbayCredentials[0]['sync_product']==1) echo "selected";?> >Yes</option>
							</select>  
							</td>
						</tr>
						
						<tr style="<?=$display1?>" class="sync_product">
					        <td  align="right"   class="blackbold" width="20%">Site Name:</td>
					        <td   align="left" width="40%">
 
								 <select class="inputbox" name="site_id" id="site_id">
								 	<?php foreach($objProduct->ebaySiteList() as $siteID=>$siteName):?>
						         	<option value="<?=$siteID?>" <?php if($arryEbayCredentials[0]['site_id']==$siteID && !empty($arryEbayCredentials[0]['Cat'])) echo 'selected'; ?>><?=$siteName?></option>
						         	<?php endforeach;?>
						       	</select>            
							</td>
				   		</tr>
   
						<tr style="<?=$display1?>" class="sync_product">
							<td align="right" class="blackbold">Set Description:</td>
							<td align="left" colspan="3">
							 <select class=" inputbox select" title="active" name="set_desc" id="set_desc">
									<option value="0" <?php if($arryEbayCredentials[0]['set_desc']=='0') echo "selected";?> >Ebay Defined</option>
									<option value="1" <?php if($arryEbayCredentials[0]['set_desc']=='1') echo "selected";?> >Your Own</option>
							</select>  
							</td>
						</tr>
						
						<tr style="<?=$display1?>" class="sync_product">
					        <td  align="right"   class="blackbold" >Listing Type: </td>
					        <td   align="left" colspan="3">
							 <select class="inputbox" name="product_type">
					         <option value="FixedPriceItem" <?php if($arryEbayCredentials[0]['product_type']=='FixedPriceItem') echo 'selected';?>>Fixed Price Item</option>
					         <option value="Chinese" <?php if($arryEbayCredentials[0]['product_type']=='Chinese') echo 'selected';?>>Chinese</option>
					         <option value="Half" <?php if($arryEbayCredentials[0]['product_type']=='Half') echo 'selected';?>>Half</option>
					       </select>
					      </td>
						 </tr>
						 
						<tr style="<?=$display1?>" class="sync_product">
							<td align="right" class="blackbold">Listing Duration:
							</td>
							<td align="left" colspan="3">
								<select class="inputbox" name="listing_duration">
						             <option value="Days_30" <?php if($arryEbayCredentials[0]['listing_duration']=='Days_30') echo 'selected';?>>30 days</option>
				  				 	<option value="Days_7" <?php if($arryEbayCredentials[0]['listing_duration']=='Days_7') echo 'selected';?>>7 days</option>
						             <option value="Days_180" <?php if($arryEbayCredentials[0]['listing_duration']=='Days_180') echo 'selected';?>>180 days</option>
						             <option value="Days_360" <?php if($arryEbayCredentials[0]['listing_duration']=='Days_360') echo 'selected';?>>360 days</option>
					          </select>    
							</td>
						</tr>
						
						 <tr style="<?=$display1?>" class="sync_product">
				        <td  align="right"   class="blackbold" >Condition: </td>
				        <td   align="left" colspan="3">
						<select class="inputbox" id="item_condition" name="item_condition" title="item_condition">
								<option value="1000" <?php if($arryEbayCredentials[0]['item_condition']==1000) echo 'selected';?> >New</option>
								<option value="3000" <?php if($arryEbayCredentials[0]['item_condition']==3000) echo 'selected';?>>Used</option>
								<option value="1500" <?php if($arryEbayCredentials[0]['item_condition']==1500) echo 'selected';?>>New other</option>
								<option value="1750" <?php if($arryEbayCredentials[0]['item_condition']==1750) echo 'selected';?>>New with defects</option>
								<option value="2000" <?php if($arryEbayCredentials[0]['item_condition']==2000) echo 'selected';?>>Manufacturer refurbished</option>
								<option value="2500" <?php if($arryEbayCredentials[0]['item_condition']==2500) echo 'selected';?>>Seller refurbished</option>
								<option value="4000" <?php if($arryEbayCredentials[0]['item_condition']==4000) echo 'selected';?>>Very Good</option>
								<option value="5000" <?php if($arryEbayCredentials[0]['item_condition']==5000) echo 'selected';?>>Good</option>
								<option value="6000" <?php if($arryEbayCredentials[0]['item_condition']==6000) echo 'selected';?>>Acceptable</option>
							</select>
					 	</td>
					</tr>
						
						<tr style="<?=$display1?>" class="sync_product">
							<td align="right" class="blackbold">Condition Note:
							</td>
							<td align="left" colspan="3">
							<input name="condition_note" type="text" class="inputbox" id="condition_note" value="<?=$arryEbayCredentials[0]['condition_note']?>" />
							</td>
						</tr>
<!-- end of Sync products settings -->
						<tr>
							<td align="right" class="blackbold">Select Order:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><select class=" inputbox select"
								title="sync_orders" name="sync_orders" id="sync_orders">
									<option value="0">New Orders Only</option>
									<option value="1"
										<?=($arryEbayCredentials[0]['syncOders']==1)?("selected"):("")?>>All
										Orders</option>
							</select></td>
						</tr>


						<tr>

							<td align="right" class="blackbold">Status :</td>
							<td align="left">
          <?
	$ActiveChecked = 'checked';
	
	if ($arryEbayCredentials [0] ['status'] == 1) {
		$ActiveChecked = ' checked';
		$InActiveChecked = '';
	}
	if ($arryEbayCredentials [0] ['status'] == 0) {
		$ActiveChecked = '';
		$InActiveChecked = ' checked';
	}
	
	?>
          <input type="radio" name="Status" id="Status" value="1"
								<?=$ActiveChecked?> /> Active&nbsp;&nbsp;&nbsp;&nbsp; <input
								type="radio" name="Status" id="Status" value="0"
								<?=$InActiveChecked?> /> InActive
							</td>
						</tr>

					</table>

				</td>
			</tr>

  
   <? } ?>
   
   
   	
   
 

 <tr>

				<td align="left" valign="top">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">
						<tr>
							<td width="33%"></td>
							<td width="37%" align="left">


								<div id="SubmitDiv" style="display: none1" align="left">
	
<? if(($_GET['active_id']=="add")&&(sizeof($arryEbayCredentials)<=0)) $ButtonTitle = 'Submit'; else $ButtonTitle ='Update';?>
	
  <input name="Submit" type="submit" class="button" id="SubmitButton"
										value=" <?=$ButtonTitle?> " /> <input type="hidden" name="Uid"
										id="Uid" value="<?=$_GET['edit']?>" />

								</div>
							</td>
							<td width="30%"></td>
						</tr>
					</table>
				</td>
			</tr>
		</form>
	</table>
</div>




