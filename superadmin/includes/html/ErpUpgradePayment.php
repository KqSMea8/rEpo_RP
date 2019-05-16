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



<div id="PlanDetail">

<?php
$arrDuration = explode("/", $_POST['PlanDuration']);

?>

	<span class="label">Total Amount:-</span> <span class="value">$<?php echo $_POST['TotalAmount'];?>
	</span><br> <span class="label">Number of users:-</span> <span
		class="value"><?php echo $_POST['MaxUser'];?> </span><br> <span
		class="label">Plan Type:-</span> <span class="value"><?php echo $arrayPkj[0]['name'];?>
	</span><br> <span class="label">Duration:-</span> <span class="value">1
	<?php echo $arrDuration[1];?>(s)</span>
</div>


<table width="42%" border="0" align="center" cellpadding="0" 
	cellspacing="0">

	
	<form accept-charset="UTF-8" id="payment-form" method="post" action=""
		novalidate="novalidate" onSubmit="return validatePayment(this);">
		
<?php if($_POST['TotalAmount']!=0){?>
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
							<td align="left"><select class="inputbox" name="country_id"
								id="country_id">

									<option value="US">United States</option>
									<option value="GB">United Kingdom</option>
									<option value="AF">Afghanistan</option>
									<option value="AL">Albania</option>
									<option value="DZ">Algeria</option>
									<option value="AS">American Samoa</option>
									<option value="AD">Andorra</option>
									<option value="AO">Angola</option>
									<option value="AI">Anguilla</option>
									<option value="AQ">Antarctica</option>
									<option value="AG">Antigua And Barbuda</option>
									<option value="AR">Argentina</option>
									<option value="AM">Armenia</option>
									<option value="AU">Australia</option>
									<option value="AT">Austria</option>
									<option value="AZ">Azerbaijan</option>
									<option value="BS">Bahamas</option>
									<option value="BD">Bangladesh</option>
									<option value="BB">Barbados</option>
									<option value="BY">Belarus</option>
									<option value="BE">Belgium</option>
									<option value="BZ">Belize</option>
									<option value="BJ">Belize</option>
									<option value="BM">Benin</option>
									<option value="BT">Bhutan</option>
									<option value="BO">Bolivia</option>
									<option value="BA">Bosnia And Herzegowina</option>
									<option value="BW">Botswana</option>
									<option value="BV">Bouvet Island</option>
									<option value="BR">Brazil</option>
									<option value="IO">British Indian Ocean Territory</option>
									<option value="BN">Brunei Darussalam</option>
									<option value="BG">Bulgaria</option>
									<option value="BF">Burkina Faso</option>
									<option value="BI">Burundi</option>
									<option value="KH">Cambodia</option>
									<option value="CM">Cameroon</option>
									<option value="CA">Canada</option>
									<option value="CV">Cape Verde</option>
									<option value="KY">Cayman Islands</option>
									<option value="CF">Central African Republic</option>
									<option value="TD">Chad</option>
									<option value="CL">Chile</option>
									<option value="CN">China</option>
									<option value="CX">Christmas Island</option>
									<option value="CC">Cocos (Keeling) Islands</option>
									<option value="CO">Colombia</option>
									<option value="KM">Comoros</option>
									<option value="CG">Congo</option>
									<option value="CD">Congo The Democratic Republic Of The</option>
									<option value="CK">Cook Islands</option>
									<option value="CR">Costa Rica</option>
									<option value="CI">Cote D Ivoire</option>
									<option value="HR">Croatia (Local Name: Hrvatska)</option>
									<option value="CU">Cuba</option>
									<option value="CY">Cyprus</option>
									<option value="CZ">Czech Republic</option>
									<option value="DK">Denmark</option>
									<option value="DJ">Djibouti</option>
									<option value="DM">Dominica</option>
									<option value="DO">Dominican Republic</option>
									<option value="TP">East Timor</option>
									<option value="EC">Ecuador</option>
									<option value="EG">Egypt</option>
									<option value="SV">El Salvador</option>
									<option value="GQ">Equatorial Guinea</option>
									<option value="ER">Eritrea</option>
									<option value="EE">Estonia</option>
									<option value="ET">Ethiopia</option>
									<option value="FK">Falkland Islands (Malvinas)</option>
									<option value="FO">Faroe Islands</option>
									<option value="FJ">Fiji</option>
									<option value="FI">Finland</option>
									<option value="FR">France</option>
									<option value="FX">France, Metropolitan</option>
									<option value="GF">French Guiana</option>
									<option value="PF">French Polynesia</option>
									<option value="TF">French Southern Territories</option>
									<option value="GA">Gabon</option>
									<option value="GM">Gambia</option>
									<option value="GE">Georgia</option>
									<option value="DE">Germany</option>
									<option value="GH">Ghana</option>
									<option value="GI">Gibraltar</option>
									<option value="GR">Greece</option>
									<option value="GL">Greenland</option>
									<option value="GD">Grenada</option>
									<option value="GP">Guadeloupe</option>
									<option value="GU">Guam</option>
									<option value="GT">Guatemala</option>
									<option value="GN">Guinea</option>
									<option value="GW">Guinea-Bissau</option>
									<option value="GY">Guyana</option>
									<option value="HT">Haiti</option>
									<option value="HM">Heard And Mc Donald Islands</option>
									<option value="VA">Holy See (Vatican City State)</option>
									<option value="HN">Honduras</option>
									<option value="HK">Hong Kong</option>
									<option value="HU">Hungary</option>
									<option value="IS">Iceland</option>
									<option value="IN">India</option>
									<option value="ID">Indonesia</option>
									<option value="IR">Iran (Islamic Republic Of)</option>
									<option value="IQ">Iraq</option>
									<option value="IE">Ireland</option>
									<option value="IL">Israel</option>
									<option value="IT">Italy</option>
									<option value="JM">Jamaica</option>
									<option value="JP">Japan</option>
									<option value="JO">Jordan</option>
									<option value="KZ">Kazakhstan</option>
									<option value="KE">Kenya</option>
									<option value="KI">Kiribati</option>
									<option value="KP">Korea, Democratic Peoples Republic Of</option>
									<option value="KR">Korea, Republic Of</option>
									<option value="KW">Kuwait</option>
									<option value="KG">Kyrgyzstan</option>
									<option value="JA">Lao Peoples Democratic Republic</option>
									<option value="LV">Latvia</option>
									<option value="LB">Lebanon</option>
									<option value="LS">Lesotho</option>
									<option value="LR">Liberia</option>
									<option value="LY">Libyan Arab Jamahiriya</option>
									<option value="LI">Liechtenstein</option>
									<option value="LT">Lithuania</option>
									<option value="LU">Luxembourg</option>
									<option value="MO">Macau</option>
									<option value="MK">Macedonia, Former Yugoslav Republic Of</option>
									<option value="MG">Madagascar</option>
									<option value="MW">Malawi</option>
									<option value="MY">Malaysia</option>
									<option value="MV">Maldives</option>
									<option value="ML">Mali</option>
									<option value="MT">Malta</option>
									<option value="MH">Marshall Islands</option>
									<option value="MQ">Martinique</option>
									<option value="MR">Mauritania</option>
									<option value="MU">Mauritius</option>
									<option value="YT">Mayotte</option>
									<option value="MX">Mexico</option>
									<option value="FM">Micronesia</option>
									<option value="MD">Moldova, Republic Of</option>
									<option value="MC">Monaco</option>
									<option value="MN">Mongolia</option>
									<option value="MS">Montserrat</option>
									<option value="MA">Morocco</option>
									<option value="MZ">Mozambique</option>
									<option value="MM">Myanmar</option>
									<option value="NA">Namibia</option>
									<option value="NR">Nauru</option>
									<option value="NP">Nepal</option>
									<option value="NL">Netherlands</option>
									<option value="AN">Netherlands Antilles</option>
									<option value="NC">New Caledonia</option>
									<option value="NZ">New Zealand&lt;</option>
									<option value="NI">Nicaragua</option>
									<option value="NE">Niger</option>
									<option value="NG">Nigeria</option>
									<option value="NU">Niue</option>
									<option value="NF">Norfolk Island</option>
									<option value="MP">Northern Mariana Islands</option>
									<option value="NO">Norway</option>
									<option value="OM">Oman</option>
									<option value="PK">Pakistan</option>
									<option value="PW">Palau</option>
									<option value="PA">Panama</option>
									<option value="PG">Papua New Guinea</option>
									<option value="PY">Paraguay</option>
									<option value="PE">Peru</option>
									<option value="PH">Philippines</option>
									<option value="PN">Pitcairn</option>
									<option value="PL">Poland</option>
									<option value="PT">Portugal</option>
									<option value="PR">Puerto Rico</option>
									<option value="QA">Qatar</option>
									<option value="RE">Reunion</option>
									<option value="RO">Romania</option>
									<option value="RU">Russian Federation</option>
									<option value="RW">Rwanda</option>
									<option value="KN">Saint Kitts And Nevis</option>
									<option value="LC">Saint Lucia</option>
									<option value="VC">Saint Vincent And The Grenadines</option>
									<option value="WS">Samoa</option>
									<option value="SM">San Marino</option>
									<option value="ST">Sao Tome And Principe</option>
									<option value="SA">South Africa</option>
									<option value="SN">Senegal</option>
									<option value="SC">Seychelles</option>
									<option value="SL">Sierra Leone</option>
									<option value="SG">Singapore</option>
									<option value="SK">Slovakia (Slovak Republic)</option>
									<option value="SI">Slovenia</option>
									<option value="SB">Solomon Islands</option>
									<option value="SO">Somalia</option>
									<option value="GS">South Georgia, South Sandwich Islands</option>
									<option value="ES">Spain</option>
									<option value="LK">Sri Lanka</option>
									<option value="SH">St. Helena</option>
									<option value="PM">St. Pierre And Miquelon</option>
									<option value="SD">Sudan</option>
									<option value="SR">Suriname</option>
									<option value="SJ">Svalbard And Jan Mayen Islands</option>
									<option value="SZ">Swaziland</option>
									<option value="SE">Sweden</option>
									<option value="CH">Switzerland</option>
									<option value="SY">Syrian Arab Republic</option>
									<option value="TW">Taiwan</option>
									<option value="TJ">Tajikistan</option>
									<option value="TZ">Tanzania, United Republic Of</option>
									<option value="TH">Thailand</option>
									<option value="TG">Togo</option>
									<option value="TK">Tokelau</option>
									<option value="TO">Tonga</option>
									<option value="TT">Trinidad And Tobago</option>
									<option value="TN">Tunisia</option>
									<option value="TR">Turkey</option>
									<option value="TM">Turkmenistan</option>
									<option value="TC">Turks And Caicos Islands</option>
									<option value="TV">Tuvalu</option>
									<option value="UG">Uganda</option>
									<option value="UA">Ukraine</option>
									<option value="AE">United Arab Emirates</option>
									<option value="UM">United States Minor Outlying Islands</option>
									<option value="UY">Uruguay</option>
									<option value="UZ">Uzbekistan</option>
									<option value="VU">Vanuatu</option>
									<option value="VE">Venezuela</option>
									<option value="VN">Viet Nam</option>
									<option value="VG">Virgin Islands (British)</option>
									<option value="VI">Virgin Islands (U.S.)</option>
									<option value="WF">Wallis And Futuna Islands</option>
									<option value="EH">Western Sahara</option>
									<option value="YE">Yemen</option>
									<option value="YU">Yugoslavia</option>
									<option value="ZM">Zambia</option>
									<option value="ZW">Zimbabwe</option>
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
							<td align="right" class="blackbold" valign="top"></td>
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

