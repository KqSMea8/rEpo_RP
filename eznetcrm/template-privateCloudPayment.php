<?php
require_once("../classes/cmp.class.php");
require_once("../classes/company.class.php");
require_once("../classes/license.class.php");
require_once("../classes/sales.quote.order.class.php");
require_once("../classes/sales.customer.class.php");
require_once("../classes/region.class.php");
	
$objRegion=new region();
$objSale = new sale();
$objCmp=new cmp();
$objCompany=new company();
$objLicense=new license();

$arrayOrderInfo=$objCmp->showOderInformation();
$arryCountry = $objRegion->getCountry('','');

	$Price = 30;
	$PaymentPlan = "PRIVATE CLOUD";
    $PlanDuration = $_POST['PlanDuration'];
	$MaxUser = $_POST['MaxUser'];
	
	if($PlanDuration=='user/month'){
	     $TotalAmount=$Price*$MaxUser;
	}
	if($PlanDuration=='user/year'){
		
		 $TotalAmount=($Price*$MaxUser)*12;
		
	}
	
if(!empty($_POST['customer_email_id'])){

	//$packData=array();
	//$packData=$objCmp->getPackagesByName($_POST['PaymentPlan']);
	//echo '<pre>';print_r($packData);
	//$packDataUnserialize=unserialize($packData[0]['features']);
	//$packageFeatureId = implode(",", $packDataUnserialize);
	
	//require_once("paypal_pro.inc.php");
	require_once ("paypalfunctions.php");

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

	if($TotalAmount>0){
		/*$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );
		$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
		$ack = strtoupper($resArray["ACK"]);*/

		$paymentType = "Sale";
		$expDate = $padDateMonth.$expDateYear;
		$countryCode = "US";
		$orderDescription  = "Private Cloud Payment";
		$resArray = DirectPayment ( $paymentType, $amount, $creditCardType, $creditCardNumber, $expDate, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $countryCode, $currencyCode, $orderDescription );
		if($resArray["RESPMSG"]=="Approved"){
			$ack="SUCCESS";
			$resArray["TRANSACTIONID"] = $resArray["CORRELATIONID"];
		}
	
		//echo '<pre>'; print_r($resArray);exit;



			
	}else{
		$ack="SUCCESS";
	}
	
	


	if($ack!="SUCCESS")
	{
		/*echo '<tr>';
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
			
		exit;*/

		$_SESSION["PricingMsg"] = 'Payment Error : '.$resArray["RESPMSG"];

		header('location:privateCloudUser');
		exit;

	}
	else
	{
		echo '<tr>';
		 echo '<td colspan="2" style="font-weight:bold;color:Green" align="center">Thank You For Your Payment :)</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td align="right"> Transaction ID:</td>';
			echo '<td>'.$resArray["TRANSACTIONID"].'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td align="right"> Amount:</td>';
			echo '<td>'.$currencyCode.$resArray['AMT'].'</td>';
			echo '</tr>';

		///////////////////////////////////
		$_POST['TransactionID'] = $resArray["TRANSACTIONID"];
		
		$_SESSION['down']= $resArray["TRANSACTIONID"];
		
	    $country_id = $_POST['country_id'];
	    $arryCountryCode = $objRegion->getCountry($_POST['country_id'],'');
	    $country_code = $arryCountryCode[0]['code'];
	    $_POST['country_id']=$country_code;
		
		$OrderID=$objCmp->AddOrderForPrivateCloud($_POST);
		

		//if($OrderID>0){
			//$objCmp->ActivateOrder($_SESSION['CrmAdminID'],$OrderID,$resArray["TRANSACTIONID"]);
			//$UpdateAdminMenu = 1;
			/************************/
			//if($UpdateAdminMenu == 1){
				//$DbName = $Config['DbName']."_".$_SESSION['CrmDisplayName'];
				//$Config['DbName'] = $DbName;
				//$objConfig->dbName = $Config['DbName'];
				//$objConfig->connect();
				//$objCompany->UpdateAdminModules($_SESSION['CrmAdminID'],5);
				//$objCompany->UpdateAdminSubModules($_SESSION['CrmAdminID'],5,strtolower($_POST['PaymentPlan']));
				//$objCmp->UpdateAdminSubModules($_SESSION['CrmAdminID'],5,strtolower($_POST['PaymentPlan']),$packageFeatureId);

			//}
			/************************/

		//}
		///////////////////////////////////
		
		
					/* invoice start here */
			
				            
			$results=$objCompany->GetDefaultCompany();
        
            $count=count($results);
           
            if($count>0){
            	
				  $_POST['country_id']=$country_id;
                 // $results[0]['DisplayName']='sakshay';  //for testing only
                  $DbName = $Config['DbMain']."_".$results[0]['DisplayName'];
                    $Config['DbName'] = $DbName;
                  $objConfig->dbName = $Config['DbName'];
                  $link=$objConfig->connect();
                  
                  $order_id = $objSale->GenerateInVoiceEntryUI($_POST); 
            
                  $objSale->basicInv($order_id,$_POST); 
                 
            }
            
			
			/* invoice end here */
            

		$_SESSION['mess_dash'] = 'Your package has been upgraded successfully.';
		header("location: privateCloudSuccess");
		exit;
			
	}
		
}


/*require_once("../classes/region.class.php");
 $objRegion=new region();
 $arryCountry = $objRegion->getCountry('','');*/



?>

<style type="text/css">
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
.value {
    display: inline-block;
    text-align: left;
    width: 130px;
}

</style>

<script language="JavaScript1.2" type="text/javascript">

function validatePayment(frm){
	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateForTextareaMand(frm.DomainName, "Domain Name / IP Address",5,50)
		&& ValidateForSimpleBlank(frm.customer_first_name, "First Name")
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

		var Url = "isRecordExists.php?editID=&DomainName="+escape(document.getElementById("DomainName").value);
	
		SendExistRequest(Url,"DomainName", "Domain Name / IP Address");

		return false;	
        				
		}else{
				return false;	
		}	

		
}



</script>

<div class="top-cont1"></div>

<section id="mainContent"> <?php //echo $datah['Content'];?>



<div class="InfoText">

<div class="wrap clearfix"><article id="leftPart">

<div class="detailedContent">
<div class="column" id="content">
<div class="section"><a id="main-content"></a>

<h1 id="page-title" class="title" style="text-align: center;">Private
Cloud Payment Information</h1>
<div class="tabs"></div>



<div id="banner"></div>
<div class="region region-content">
<div class="block block-system" id="block-system-main">



<div id="PlanDetail">
<span class="label">Total Amount:-</span> <span class="value"> $ <?php echo $TotalAmount;?></span><br> <span class="label">Number
of users:-</span> <span class="value"><?php echo $MaxUser;?></span><br> <span class="label">Plan Type:-</span> <span class="value"><?php echo $PaymentPlan;?></span><br>
<span class="label">Duration:-</span> <span class="value"><?php echo $PlanDuration;?></span>
</div>



<div class="content">
<div class="messages error clientside-error"
	id="clientsidevalidation-payment-form-errors" style="display: none;">
<ul style="display: none;"></ul>
</div>

<form accept-charset="UTF-8" id="payment-form" name="paymentform" method="post"
	action="" novalidate="novalidate" onSubmit="return validatePayment(this);">
<div>

<div class="cccc">

<div class="form-item form-type-textfield form-item-customer-first-name">
<label for="edit-customer-first-name">Company Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value=""
	name="CompanyName" id="CompanyName"></div>
	
	
	<div class="form-item form-type-textfield form-item-customer-first-name">
<label for="edit-customer-first-name">Domain Name<span
	title="This field is required." class="form-required">*</span> </label>

<input name="DomainName" type="text" <?=$BoxReadOnly?> class="inputbox <?=$DisabledClass?>" id="DomainName" value="<?php echo stripslashes($arryLicense[0]['DomainName']); ?>"  maxlength="50" onKeyPress="Javascript:ClearAvail('MsgSpan_Domain');" onBlur="Javascript:CheckAvailField('MsgSpan_Domain','DomainName','<?=$_GET['edit']?>');"/>   

<div class="dmn">
<span id="MsgSpan_Domain"></span>
<br>Without http://
</div>

</div>

	
	


<div class="form-item form-type-textfield form-item-customer-first-name">
<label for="edit-customer-first-name">First Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value=""
	name="customer_first_name" id="customer_first_name"></div>
	
	
<div class="form-item form-type-textfield form-item-customer-last-name">
<label for="edit-customer-last-name">Last Name <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value=""
	name="customer_last_name" id="customer_last_name"></div>
<div class="form-item form-type-textfield form-item-customer-email-id">
<label for="edit-customer-email-id">Email <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value=""
	name="customer_email_id" id="customer_email_id"></div>
<div
	class="form-item form-type-select form-item-customer-credit-card-type">
<label for="edit-customer-credit-card-type">Card Type </label> <select
	class="form-select valid" name="customer_credit_card_type"
	id="customer_credit_card_type">
	<option value="Visa">Visa</option>
	<option value="MasterCard">MasterCard</option>
	<option value="Discover">Discover</option>
	<option value="Amex">American Express</option>
</select></div>
<div
	class="form-item form-type-textfield form-item-customer-credit-card-number">
<label for="edit-customer-credit-card-number">Card Number <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="128" size="60"
	value="" name="customer_credit_card_number"
	id="customer_credit_card_number"> <span class="odr-cl"
	style="display: none;">
</span></div>
<div class="form-item form-type-select form-item-cc-expiration-month"><label
	for="edit-cc-expiration-month">Expiry Month </label> <select
	class="form-select" name="cc_expiration_month"
	id="edit-cc-expiration-month">
	<?php
	for($i=1;$i<=12;$i++){?>
	<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php } ?>

</select></div>
<div class="form-item form-type-select form-item-cc-expiration-year"><label
	for="edit-cc-expiration-year">Expiry Year </label> <select
	class="form-select" name="cc_expiration_year"
	id="edit-cc-expiration-year">
	<?php
	$startYear=date("Y");

	for($j=$startYear;$j<=$startYear+20;$j++){?>
	<option value="<?php echo $j;?>">
		<?php echo $j;?></option>
		<?php } ?>
</select></div>
<div class="form-item form-type-textfield form-item-cc-cvv2-number"><label
	for="edit-cc-cvv2-number">CSV Number <span
	title="This field is required." class="form-required">*</span> </label>
<input type="password" class="form-text required" maxlength="5"
	size="60"
	value=""
	name="cc_cvv2_number" id="edit-cc-cvv2-number"></div>
<div class="form-item form-type-textfield form-item-customer-address1">
<label for="edit-customer-address1">Address Line 1 <span
	title="This field is required." class="form-required">*</span> </label>
<input type="text" class="form-text required" maxlength="150" size="60"
	value=""
	name="customer_address1" id="edit-customer-address1"></div>
<div class="form-item form-type-textfield form-item-customer-address2">
<label for="edit-customer-address2">Address Line 2 (Optional) </label> <input
	type="text" class="form-text" maxlength="150" size="60"
	value=""
	name="customer_address2" id="edit-customer-address2"></div>
<div class="form-item form-type-textfield form-item-customer-city"><label
	for="edit-customer-city">City <span title="This field is required."
	class="form-required">*</span> </label> <input type="text"
	class="form-text required" maxlength="40" size="60"
	value=""
	name="customer_city" id="edit-customer-city"></div>
<div class="form-item form-type-textfield form-item-customer-state"><label
	for="edit-customer-state">State <span title="This field is required."
	class="form-required">*</span> </label> <input type="text"
	class="form-text required" maxlength="40" size="60"
	value=""
	name="customer_state" id="edit-customer-state"></div>
<div class="form-item form-type-select form-item-customer-country"><label
	for="edit-customer-country">Country </label>


<?
if($arryCompany[0]['country_id'] != ''){
$CountrySelected = $arryCompany[0]['country_id']; 
}else{
$CountrySelected = 1;
}
?>
            <select class="form-select valid" name="country_id" id="country_id">
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>       

            

</div>

<div class="form-item form-type-textfield form-item-customer-zip"><label
	for="edit-customer-zip">Zip Code <span title="This field is required."
	class="form-required">*</span> </label> <input type="text"
	class="form-text required" maxlength="20" size="60"
	value=""
	name="customer_zip" id="edit-customer-zip"></div>

</div>

<input type="hidden" value="<?php echo $MaxUser;?>" name="MaxUser">
<input type="hidden" value="<?php echo $TotalAmount;?>" name="TotalAmount">
<input type="hidden" value="<?php echo $PaymentPlan;?>" name="PaymentPlan">
<input type="hidden" value="<?php echo $PlanDuration;?>" name="PlanDuration">
<input type="hidden" value="<?php echo $Price;?>" name="Price">

<input type="submit" class="continue-cl"
	value="Submit"
	name="paySubmit" id="paySubmit"></div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

</article></div>

</div>


</section></div>

