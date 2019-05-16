<?php if($_POST['TotalAmount']>0){?>
<script language="JavaScript1.2" type="text/javascript">
function validatePayment(frm){
	if( ValidateForSimpleBlank(frm.customer_first_name, "First Name")
		&& ValidateForSimpleBlank(frm.customer_last_name, "Last Name")
		&& ValidateForSimpleBlank(frm.customer_email_id, "Email")
		&& isEmail(frm.customer_email_id)
		&& ValidateMandRange(frm.customer_credit_card_number, "Card Number",10,20)
		&& ValidateForSimpleBlank(frm.cc_cvv2_number, "CSV Number")
		&& ValidateForSimpleBlank(frm.customer_address1, "Address Line 1")
		&& ValidateForSimpleBlank(frm.customer_city, "City")
		&& ValidateForSimpleBlank(frm.customer_state, "State")
		&& isZipCode(frm.customer_zip)
		&& ValidateForSimpleBlank(frm.CompanyName, "Company Name")		
		){  
				return true;					
		}else{
				return false;	
		}	

}
</script>
<?php } ?>


<div class="clear"></div>
<br>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?>
</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
<td align="left" >
	<a href="cmpList.php?link=viewPackageLog.php" class="fancybox action_bt fancybox.iframe" class="action_bt">Select Company</a></td>
</tr>

<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="50%" > Company Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryCompany[0]['CompanyName']); ?></strong>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Company ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['CmpID']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Display Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>
           </td>
      </tr>
<tr>
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
</table>

</td>
</tr>


<? } ?>


</table>

<br>
<br>
<br>

<div id="PlanDetail">

<?php
$arrDuration = explode("/", $_POST['PlanDuration']);

?>

	<span class="label">Total Amount:-</span> <span class="value">$<?php echo $_POST['TotalAmount'];?>
	</span><br> <span class="label">Number of users:-</span> <span
		class="value"><?php echo $_POST['MaxUser'];?> </span><br> <span
		class="label">Plan Type:-</span> <span class="value"><?php echo $_POST['PlanType'];?>
	</span><br> <span class="label">Duration:-</span> <span class="value">1
	<?php echo $arrDuration[1];?>(s)</span>
</div>


<table width="100%" border="0" align="center" cellpadding="0" 
	cellspacing="0" style="margin-left:18%;">

	
	<form accept-charset="UTF-8" id="payment-form" method="post" action=""
		novalidate="novalidate" onSubmit="return validatePayment(this);">
		
<?php if($_POST['TotalAmount']>0 && $PaymentMethodCR == 'credit card'){?>
						<tr>
							<td align="right" class="blackbold" valign="top">First Name<span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="128" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_first_name'])?stripslashes($arrayOrderInfo[0]['customer_first_name']):''; ?>"
								name="customer_first_name" id="customer_first_name">
							</td>
						</tr>

						<tr>
							<td align="right" class="blackbold" valign="top">Last Name <span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="128" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_last_name'])?stripslashes($arrayOrderInfo[0]['customer_last_name']):''; ?>"
								name="customer_last_name" id="customer_last_name">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Email<span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="128" size="60"
								value="<?php echo $_SESSION['CrmAdminEmail'];?>"
								name="customer_email_id" id="customer_email_id">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Card Type <span
								class="red">*</span></td>
							<td align="left"><select class="inputbox"
								name="customer_credit_card_type" id="customer_credit_card_type"><option
										value="Visa">Visa</option>
									<option value="MasterCard"
									<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="MasterCard"){ echo "selected";}?>>MasterCard</option>
									<option value="Discover"
									<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="Discover"){ echo "selected";}?>>Discover</option>
									<option value="Amex"
									<?php if($arrayOrderInfo[0]['customer_credit_card_type']=="Amex"){ echo "selected";}?>>American
										Express</option>
							</select>
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Card Number <span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="128" size="60" value=""
								name="customer_credit_card_number"
								id="customer_credit_card_number"> <span class="odr-cl"
								style="display: none;"><?= !empty($arrayOrderInfo[0]['customer_credit_card_number'])? '***********'. substr($arrayOrderInfo[0]['customer_credit_card_number'],-2-3):''; ?>
							</span>
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Expiry Month<span
								class="red">*</span></td>
							<td align="left"><select class="inputbox"
								name="cc_expiration_month" id="edit-cc-expiration-month">
								<?php
								for($i=1;$i<=12;$i++){?>
									<option value="<?php echo $i;?>"
									<?php if($arrayOrderInfo[0]['cc_expiration_month']==$i){ echo "selected";}?>>
										<?php echo $i;?>
									</option>
									<?php } ?>

							</select>
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Expiry Year<span
								class="red">*</span></td>
							<td align="left"><select class="inputbox"
								name="cc_expiration_year" id="edit-cc-expiration-year">
								<?php
								$startYear=date("Y");

								for($j=$startYear;$j<=$startYear+20;$j++){?>
									<option value="<?php echo $j;?>"
									<?php if($arrayOrderInfo[0]['cc_expiration_year']==$j){ echo "selected";}?>>
										<?php echo $j;?>
									</option>
									<?php } ?>
							</select>
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">CSV Number<span
								class="red">*</span></td>
							<td align="left"><input type="password" class="inputbox"
								maxlength="5" size="60"
								value="<?= !empty($arrayOrderInfo[0]['cc_cvv2_number'])?stripslashes($arrayOrderInfo[0]['cc_cvv2_number']):''; ?>"
								name="cc_cvv2_number" id="edit-cc-cvv2-number">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Address Line 1 <span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="150" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_address1'])?stripslashes($arrayOrderInfo[0]['customer_address1']):''; ?>"
								name="customer_address1" id="edit-customer-address1">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Address Line 2 <span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="150" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_address2'])?stripslashes($arrayOrderInfo[0]['customer_address2']):''; ?>"
								name="customer_address2" id="edit-customer-address2">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">City<span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="40" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_city'])?stripslashes($arrayOrderInfo[0]['customer_city']):''; ?>"
								name="customer_city" id="edit-customer-city">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">State<span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="40" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_state'])?stripslashes($arrayOrderInfo[0]['customer_state']):''; ?>"
								name="customer_state" id="edit-customer-state">
							</td>
						</tr>


						<tr>
							<td align="right" class="blackbold" valign="top">Country<span
								class="red">*</span></td>
							<td align="left">

		<?
	if($arryCountry[0]['country_id'] != ''){
		$CountrySelected = $arryCountry[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id">
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select> 
            
							</td>
						</tr>



						<tr>
							<td align="right" class="blackbold" valign="top">Zip Code<span
								class="red">*</span></td>
							<td align="left"><input type="text" class="inputbox"
								maxlength="20" size="60"
								value="<?= !empty($arrayOrderInfo[0]['customer_zip'])?stripslashes($arrayOrderInfo[0]['customer_zip']):''; ?>"
								name="customer_zip" id="edit-customer-zip">
							</td>
						</tr>
		<?php } ?>
		

						<tr>
							<td align="right" class="blackbold" valign="top" width="30%"></td>
							<td align="left">
							<input type="submit" class="button"
							value="<?php if($_POST['TotalAmount']<=0){echo "Continue";}else{ echo "Submit";}?>"
							name="paySubmit" id="paySubmit">
							
							</td>
						</tr>
			


					<input type="hidden" name="MaxUser" id="MaxUser"
					value="<?php echo $_POST['MaxUser'];?>">
										<input type="hidden" name="AdditionalSpace" id="AdditionalSpace"
					value="<?php echo $_POST['AdditionalSpace'];?>">
										<input type="hidden" name="AdditionalSpaceUnit" id="AdditionalSpaceUnit"
					value="<?php echo $_POST['AdditionalSpaceUnit'];?>">
										<input type="hidden" name="PlanDuration" id="PlanDuration"
					value="<?php echo $_POST['PlanDuration'];?>">
					
					
										<input type="hidden" name="CouponCode" id="CouponCode"
					value="<?php echo $_POST['CouponCode'];?>">
										<input type="hidden" name="FreeSpace" id="FreeSpace"
					value="<?php echo $_POST['FreeSpace'];?>">
										<input type="hidden" name="FreeSpaceUnit" id="FreeSpaceUnit"
					value="<?php echo $_POST['FreeSpaceUnit'];?>">
										<input type="hidden" name="Price" id="Price"
					value="<?php echo $_POST['Price'];?>">
					
					
					<input type="hidden" name="AdditionalSpacePrice" id="AdditionalSpacePrice"
					value="<?php echo $_POST['AdditionalSpacePrice'];?>">
										<input type="hidden" name="Deduction" id="Deduction"
					value="<?php echo $_POST['Deduction'];?>">
										<input type="hidden" name="DaysLeft" id="DaysLeft"
					value="<?php echo $_POST['DaysLeft'];?>">
										<input type="hidden" name="Duration" id="Duration"
					value="<?php echo $_POST['Duration'];?>">
					
					
					<input type="hidden" name="TotalAmount" id="TotalAmount"
					value="<?php echo $_POST['TotalAmount'];?>">
										<input type="hidden" name="CouponType" id="CouponType"
					value="<?php echo $_POST['CouponType'];?>">
										<input type="hidden" name="DiscountType" id="DiscountType"
					value="<?php echo $_POST['DiscountType'];?>">
										<input type="hidden" name="NumUser" id="NumUser"
					value="<?php echo $_POST['NumUser'];?>">
					
							<input type="hidden" name="PaymentPlan" id="PaymentPlan"
					value="<?php echo $_GET['pack_id'];?>">
					
					
	
	
	</form>
</table>

