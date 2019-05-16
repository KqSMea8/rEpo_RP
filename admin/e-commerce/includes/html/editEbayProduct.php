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

	
});
</script>

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
							<td colspan="4" align="left" class="head">Add Ebay Credentials</td>
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
								onkeypress="return isCharKey(event);" /></td>
						</tr>
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold" width="15%">Sandbox
								ApplicationID:<span class="red">*</span>
							</td>
							<td align="left"><input name="ApplicationID" type="text"
								class="inputbox" id="ApplicationID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_appID']); ?>"
								onkeypress="return isCharKey(event);" /></td>
						</tr>


						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox CertificateID:<span
								class="red">*</span>
							</td>
							<td align="left"><input name="CertificateID" type="text"
								class="inputbox" id="CertificateID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_certID']); ?>"
								onkeypress="return isCharKey(event);" /></td>
						</tr>



						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox UserToken:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="UserToken" type="text"
								class="inputbox" id="UserToken"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_userToken']); ?>"
								onkeypress="return isCharKey(event);" /></td>
						</tr>
						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox payment method:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="s_payment_method"
								type="text" class="inputbox" id="s_payment_method"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_payment_method']); ?>"
								onkeypress="return isCharKey(event);" /></td>
						</tr>
						
						<tr class="SandboxActiveCredential">
							<td align="right" class="blackbold">Sandbox payment method EmailAddress:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="PaypalEmailAddress"
								type="text" class="inputbox" id="PaypalEmailAddress"
								value="<?php echo stripslashes($arryEbayCredentials[0]['s_paypalEmailAddress']); ?>"
								onkeypress="return isCharKey(event);" /></td>
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
								onkeypress="return isCharKey(event);" /></td>
						</tr>
						<tr class="activeCredential">
							<td align="right" class="blackbold" width="15%">Production
								ApplicationID:<span class="red">*</span>
							</td>
							<td align="left"><input name="PApplicationID" type="text"
								class="inputbox" id="PApplicationID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_appID']); ?>"
								onkeypress="return isCharKey(event);" /></td>


						</tr>


						<tr class="activeCredential">
							<td align="right" class="blackbold">Production CertificateID:<span
								class="red">*</span>
							</td>
							<td align="left"><input name="PCertificateID" type="text"
								class="inputbox" id="PCertificateID"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_certID']); ?>"
								onkeypress="return isCharKey(event);" /></td>


						</tr>



						<tr class="activeCredential">
							<td align="right" class="blackbold">Production UserToken:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="PUserToken" type="text"
								class="inputbox" id="PUserToken"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_userToken']); ?>"
								onkeypress="return isCharKey(event);" /></td>
						</tr>
						
						<tr class="activeCredential">
							<td align="right" class="blackbold">Payment Method:<span
								class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="p_payment_method"
								type="text" class="inputbox" id="p_payment_method"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_payment_method']); ?>"
								onkeypress="return isCharKey(event);" /></td>
						</tr>
						
						<tr class="activeCredential">
							<td align="right" class="blackbold">Production
								Payment Method EmailAddress:<span class="red">*</span>
							</td>
							<td align="left" colspan="3"><input name="PPaypalEmailAddress"
								type="text" class="inputbox" id="PPaypalEmailAddress"
								value="<?php echo stripslashes($arryEbayCredentials[0]['p_paypalEmailAddress']); ?>"
								onkeypress="return isCharKey(event);" /> 
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
								onkeypress="return isCharKey(event);" />
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
								onkeypress="return isCharKey(event);" />
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




