<?php
ValidateCrmSession();
require_once("../classes/cmp.class.php");
require_once("../classes/company.class.php");
$objCmp=new cmp();
$objCompany=new company();


if(!empty($_POST['paySubmit'])){
	
	        $packData=array();
            $packData=$objCmp->getPackagesByName($_POST['PaymentPlan']);
            //echo '<pre>';print_r($packData);
            $packDataUnserialize=unserialize($packData[0]['features']);
            $packageFeatureId = implode(",", $packDataUnserialize);
 
       
		 
		require_once("paypal_pro.inc.php");
		$firstName =urlencode($_POST['customer_first_name']);
		$lastName =urlencode($_POST['customer_last_name']);
		$creditCardType =urlencode($_POST['customer_credit_card_type']);
		$creditCardNumber = urlencode($_POST['customer_credit_card_number']);
		$expDateMonth =urlencode($_POST['cc_expiration_month']);
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		$expDateYear =urlencode($_POST['cc_expiration_year']);
		$cvv2Number = urlencode($_POST['cc_cvv2_number']);
		$address1 = urlencode($_POST['customer_address1']);
		$address2 = urlencode($_POST['customer_address2']);
		$city = urlencode($_POST['customer_city']);
		$state =urlencode( $_POST['customer_state']);
		$zip = urlencode($_POST['customer_zip']);
		$amount = urlencode($_POST['TotalAmount']);
		$currencyCode="USD";
		$paymentAction = urlencode("Sale");
		if($_POST['recurring'] == 1) // For Recurring
		{
			$profileStartDate = urlencode(date('Y-m-d h:i:s'));
			$billingPeriod = urlencode($_POST['billingPeriod']);// or "Day", "Week", "SemiMonth", "Year"
			$billingFreq = urlencode($_POST['billingFreq']);// combination of this and billingPeriod must be at most a year
			$initAmt = $amount;
			$failedInitAmtAction = urlencode("ContinueOnFailure");
			$desc = urlencode("Recurring $".$amount);
			$autoBillAmt = urlencode("AddToNextBilling");
			$profileReference = urlencode("Anonymous");
			$methodToCall = 'CreateRecurringPaymentsProfile';
			$nvpRecurring ='&BILLINGPERIOD='.$billingPeriod.'&BILLINGFREQUENCY='.$billingFreq.'&PROFILESTARTDATE='.$profileStartDate.'&INITAMT='.$initAmt.'&FAILEDINITAMTACTION='.$failedInitAmtAction.'&DESC='.$desc.'&AUTOBILLAMT='.$autoBillAmt.'&PROFILEREFERENCE='.$profileReference;
		}
		else
		{
			$nvpRecurring = '';
			$methodToCall = 'doDirectPayment';
		}
		
		
		
		$nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.         $padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;
		
		
		$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );
		$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		
		if($ack!="SUCCESS")
		{
			echo '<tr>';
				echo '<td colspan="2" style="font-weight:bold;color:red;" align="center">Error! Please check that u will provide all information correctly :(</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td align="right">Ack:</td>';
				echo '<td>'.$resArray["ACK"].'</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td align="right">Correlation ID:</td>';
				echo '<td>'.$resArray['CORRELATIONID'].'</td>';
			echo '</tr>';
			
			exit;
		}
		else
		{
			/*echo '<tr>';
				echo '<td colspan="2" style="font-weight:bold;color:Green" align="center">Thank You For Your Payment :)</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td align="right"> Transaction ID:</td>';
				echo '<td>'.$resArray["TRANSACTIONID"].'</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td align="right"> Amount:</td>';
				echo '<td>'.$currencyCode.$resArray['AMT'].'</td>';
			echo '</tr>';*/
		
		///////////////////////////////////	
	   	$OrderID=$objCmp->AddOrder($_POST);
	   
	     if($OrderID>0){	   		
	   		$objCmp->ActivateOrder($_SESSION['CrmAdminID'],$OrderID,$resArray["TRANSACTIONID"]);
	   		$UpdateAdminMenu = 1;	   	 
		   	 /************************/
			 if($UpdateAdminMenu == 1){
				 $DbName = $Config['DbName']."_".$_SESSION['CrmDisplayName'];
				 $Config['DbName'] = $DbName;
				 $objConfig->dbName = $Config['DbName'];
				 $objConfig->connect();
				 $objCompany->UpdateAdminModules($_SESSION['CrmAdminID'],5);
				 //$objCompany->UpdateAdminSubModules($_SESSION['CrmAdminID'],5,strtolower($_POST['PaymentPlan']));
			 	 $objCmp->UpdateAdminSubModules($_SESSION['CrmAdminID'],5,strtolower($_POST['PaymentPlan']),$packageFeatureId);
			 
			 }
			 /************************/
			 
	    }	  
		///////////////////////////////////	
		
			$_SESSION['mess_dash'] = 'Your package has been upgraded successfully.';
			header("location: dashboard");
			exit;
			
		}
			
}




if(!empty($_POST['pack_id']) &&  !empty($_POST['TotalAmount'])){
	$arrayPkj=$objCmp->getPackagesById($_POST['pack_id']);
	if(empty($arrayPkj[0]['name'])){
		header("location: dashboard");
		exit;
	}
}else{
	header("location: dashboard");
	exit;
}

/*require_once("../classes/region.class.php");
$objRegion=new region();
$arryCountry = $objRegion->getCountry('','');*/



?>


<!DOCTYPE html>
<html style="" class="js js no-touch csstransforms csstransitions"
	lang="en-US">
<head profile="http://www.w3.org/1999/xhtml/vocab">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon"
	href="http://www.eznetcrm.com/misc/favicon.ico"
	type="image/vnd.microsoft.icon">
<link rel="shortlink" href="http://www.eznetcrm.com/node/14">

<link rel="canonical" href="http://www.eznetcrm.com/home">

<meta name="<?php echo $datah['Title'];?>" content="">
<title><?php echo $datah['MetaTitle'];?></title>

<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body
	class="html front not-logged-in no-sidebars page-node page-node- page-node-14 node-type-page responsive-menus-load-processed">
	<div id="skip-link">
		<a href="#main-content" class="element-invisible element-focusable">Skip
			to main content</a>
	</div>
	<style>
.tabs {
	display: block;
}

#page-title {
	color: #333;
	font-size: 32px;
	font-weight: 300;
	margin: 50px 0 0;
	padding: 0 0 30px;
	text-align: left;
}
</style>

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
	<div id="wrapper">

		<div id="mainContainer">

			<header id="headerArea">

				<div class="wrap clearfix">

					<div class="logo">
						<a href="index.php" title="Home" rel="home" id="logo"> <img
							src="img/eZnetLogo.png" alt="Home"> </a>
					</div>
					<?php include('includes/user_menu.php');?>
					<nav class="menuArea">
						<div class="region region-main-menu">
							<div id="block-superfish-1" class="block block-superfish">


								<div class="content">
									<ul id="superfish-1"
										class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow">
										<?php
										$bannerDt=showBanner();
										foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

										<li id="menu-218-1"
											class=" middle even sf-item-2 sf-depth-1 sf-no-children <?php if($_GET['slug']==$meData['UrlCustom']){echo 'active-trail first odd sf-item-1 sf-depth-1 sf-no-children';}?>"><a
											href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
											class="sf-depth-1"><?php echo $meData['Title'];?> </a>
										</li>


										<?php } ?>

									</ul>
								</div>
							</div>
						</div>
					</nav>

				</div>

			</header>


			<section id="mainContent">
			<?php //echo $datah['Content'];?>



				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title" style="text-align:center;">Payment Information</h1>
										<div class="tabs"></div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-payment-form-errors"
														style="display: none;">
														<ul style="display: none;"></ul>
													</div>
													<form accept-charset="UTF-8" id="payment-form"
														method="post" action="" novalidate="novalidate"
														onSubmit="return validatePayment(this);">
														<div>
															<div id="PlanDetail">
															
													<?php 
													$arrDuration = explode("/", $_POST['PlanDuration']);
													
													?>		
															
																<span class="label">Total Amount:-</span> <span
																	class="value">$<?php echo $_POST['TotalAmount'];?></span><br> <span class="label">Number
																	of users:-</span> <span class="value"><?php echo $_POST['MaxUser'];?></span><br> <span
																	class="label">Plan Type:-</span> <span class="value"><?php echo $arrayPkj[0]['name'];?></span><br>
																<span class="label">Duration:-</span> <span
																	class="value">1 <?php echo $arrDuration[1];?>(s)</span>
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-first-name">
																<label for="edit-customer-first-name">First Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="128" size="60" value=""
																	name="customer_first_name" id="customer_first_name">
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-last-name">
																<label for="edit-customer-last-name">Last Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="128" size="60" value=""
																	name="customer_last_name" id="customer_last_name">
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-email-id">
																<label for="edit-customer-email-id">Email <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="128" size="60"
																	value="<?php echo $_SESSION['CrmAdminEmail'];?>"
																	name="customer_email_id" id="customer_email_id">
															</div>
															<div
																class="form-item form-type-select form-item-customer-credit-card-type">
																<label for="edit-customer-credit-card-type">Card Type </label>
																<select class="form-select valid"
																	name="customer_credit_card_type"
																	id="customer_credit_card_type"><option value="Visa">Visa</option>
																	<option value="MasterCard">MasterCard</option>
																	<option value="Discover">Discover</option>
																	<option value="Amex">American Express</option>
																</select>
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-credit-card-number">
																<label for="edit-customer-credit-card-number">Card
																	Number <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="128"
																	size="60" value="" name="customer_credit_card_number"
																	id="customer_credit_card_number">
															</div>
															<div
																class="form-item form-type-select form-item-cc-expiration-month">
																<label for="edit-cc-expiration-month">Expiry Month </label>
																<select class="form-select" name="cc_expiration_month"
																	id="edit-cc-expiration-month">
																	<?php
																	for($i=1;$i<=12;$i++){?>
																	<option value="<?php echo $i;?>">
																	<?php echo $i;?>
																	</option>
																	<?php } ?>

																</select>
															</div>
															<div
																class="form-item form-type-select form-item-cc-expiration-year">
																<label for="edit-cc-expiration-year">Expiry Year </label>
																<select class="form-select" name="cc_expiration_year"
																	id="edit-cc-expiration-year">
																	<?php
																	$startYear=date("Y");

																	for($j=$startYear;$j<=$startYear+20;$j++){?>
																	<option value="<?php echo $j;?>">
																	<?php echo $j;?>
																	</option>
																	<?php } ?>
																</select>
															</div>
															<div
																class="form-item form-type-textfield form-item-cc-cvv2-number">
																<label for="edit-cc-cvv2-number">CSV Number <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="5" size="60" value="" name="cc_cvv2_number"
																	id="edit-cc-cvv2-number">
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-address1">
																<label for="edit-customer-address1">Address Line 1 <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="150" size="60" value=""
																	name="customer_address1" id="edit-customer-address1">
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-address2">
																<label for="edit-customer-address2">Address Line 2
																	(Optional) </label> <input type="text"
																	class="form-text" maxlength="150" size="60" value=""
																	name="customer_address2" id="edit-customer-address2">
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-city">
																<label for="edit-customer-city">City <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="40" size="60" value="" name="customer_city"
																	id="edit-customer-city">
															</div>
															<div
																class="form-item form-type-textfield form-item-customer-state">
																<label for="edit-customer-state">State <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="40" size="60" value="" name="customer_state"
																	id="edit-customer-state">
															</div>
															<div
																class="form-item form-type-select form-item-customer-country">
																<label for="edit-customer-country">Country </label> <select
																	class="form-select valid" name="country_id"
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
																	<option value="KP">Korea, Democratic Peoples Republic
																		Of</option>
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
																	<option value="MK">Macedonia, Former Yugoslav Republic
																		Of</option>
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
																	<option value="GS">South Georgia, South Sandwich
																		Islands</option>
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
															</div>

															<div
																class="form-item form-type-textfield form-item-customer-zip">
																<label for="edit-customer-zip">Zip Code <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="20" size="60" value="" name="customer_zip"
																	id="edit-customer-zip">
															</div>
															
															
															<?php 
															foreach($_POST as $key=>$values){
															  echo '<input type="hidden" name="'.$key.'" value="'.$values.'">';	
															}
															
															?>
															
															
															<input type="hidden" name="PaymentPlan" value="<?php echo $arrayPkj[0]['name'];?>">
															
															
															<input	type="submit" class="form-submit" value="Submit"
																name="paySubmit" id="paySubmit">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>


			</section>

		</div>


		<footer id="footer">

			<div class="wrap clearfix">

				<div class="followUs">
					<h2>Follow Us</h2>
					<div class="region region-footer-firstcolumn">
						<div id="block-block-1" class="block block-block">


							<div class="content">
								<ul>
									<?php
								$socialDat=getSocialLinks();
								foreach($socialDat as $socialData){?>
									<li><a href="<?php echo $socialData['URI'];?>" target="_blank"><img
											src="../images/<?php echo $socialData['Icon'];?>"> </a></li>
									<?php } ?>


								</ul>


								<br> <br> <br> <br> <br>
								<h2>Subscribe to our Newsletter</h2>
							</div>
						</div>
						<div id="block-simplenews-1" class="block block-simplenews">


							<div class="content">

								<div style="display: none;"
									id="clientsidevalidation-simplenews-block-form-1-errors"
									class="messages error clientside-error">
									<ul></ul>
								</div>
								<form novalidate="novalidate" class="simplenews-subscribe"
									id="srform" name="form" accept-charset="UTF-8">
									<div>
										<div class="form-item form-type-textfield form-item-mail">
											<label for="edit-mail">E-mail <span class="form-required"
												title="This field is required.">*</span> </label> <input
												placeholder="Your Email" id="email" name="email" size="20"
												maxlength="128" class="form-text required" type="text">
										</div>
										<a href="javascript:void(0)" id="submit"
											onclick="subcription()">Subscribe</a>
										<!-- <input id="submit" onclick="subcription()" name="submit" value="Subscribe" type="submit"> -->
										<div class="msg"></div>
									</div>
								</form>


							</div>
						</div>
					</div>

				</div>

				<div class="quickLinks">

					<div class="region region-footer-secondcolumn">
						<div id="block-system-main-menu"
							class="block block-system block-menu">

							<h2>Main menu</h2>

							<div class="content">
								<ul class="menu">
									<?php
								$bannerDt=showBanner();
								foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

									<li id="menu-218-1" class="leaf"><a
										href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
										class="sf-depth-1"><?php echo $meData['Title'];?> </a>
									</li>


									<?php } ?>

								</ul>

							</div>
						</div>
					</div>
					<div class="region region-footer">
						<div id="block-block-17" class="block block-block">


							<div class="content">
								<p
									style="font-size: 14px; font-family: 'Open Sans', sans-serif; text-align: center; font-weight: 400;">
									&#169;
									<?php echo date("Y"); ?>
									, eZnet CRM. All Rights Reserved
								</p>
							</div>
						</div>
					</div>

				</div>

				<div class="newsLetter logedout">

					<div class="region region-footer-thirdcolumn">
						<div id="block-block-15" class="block block-block">


							<div class="content">
								<p style="line-height: 175%;">
									<img src="img/eZnetLogo_0_1.png">
								</p>
								<p>
									<span
										style="font-size: 15px; font-weight: 400; font-family: 'Open Sans', sans-serif; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; 650 Technology Park</span>
								</p>
								<p>
									<span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; Lake Mary, FL 32746</span>
								</p>
								<p>
									<span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1-877-368-4446</span>
								</p>
								<p>
									<span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										&nbsp; &nbsp; &nbsp; <a href="mailto:info@eznetcrm.com">info@eznetcrm.com</a>
									</span>
								</p>
							</div>
						</div>
					</div>

				</div>

			</div>

		</footer>


	</div>


	<p style="display: none;" id="back-top">
		<a href="#top"><span id="button"></span><span id="link">Back to top</span>
		</a>
	</p>
</body>
</html>
