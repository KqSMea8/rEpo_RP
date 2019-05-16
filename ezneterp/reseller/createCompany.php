<?php

/**************************************************/
#$ThisPageName = 'viewCompany.php'; if(empty($_GET["edit"]))$EditPage = 1;
/**************************************************/
include ('includes/function.php');
ValidateCrmSession();
include ('includes/header.php');
require_once($Prefix."classes/company.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/configure.class.php");
require_once($Prefix."classes/dbfunction.class.php");
require_once($Prefix."classes/function.class.php");
require_once($Prefix."classes/cmp.class.php");
//require_once($Prefix."classes/admin.class.php");
//require_once($Prefix."classes/rsl.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/sales.customer.class.php");

$objSale = new sale();
$objReseller=new rs();
$objConfig=new admin();
$objCmp=new cmp();
$objConfigure=new configure();
$objFunction=new functions();
$objCompany=new company();
$objRegion=new region();
//echo 'wehjdqkew fdiehfiwreewgeywrghruwehg fwerufu';
/*******************************/
	/*$rsAccountLimit=$objReseller->resellerAccountLimit($_SESSION['CrmRsID']);
	$PaymentMethodCR = trim(strtolower($rsAccountLimit[0]['PaymentMethod']));
	
	$rsOrderedAmount=$objReseller->resellerOrderAmount($_SESSION['CrmRsID']);
	$DebitAmount=$rsAccountLimit[0]['AccountLimit']-$rsOrderedAmount[0]['TotalAmount'];
	if($DebitAmount<0) $DebitAmount=0;*/

if(!empty($_POST['pack_id'])){
	$arrayPkjName=$objCmp->getPackagesById($_POST['pack_id']);

}else{
	header("location: priceSignup.php");
	exit;
}


if(!empty($_POST['Email']) && !empty($_POST['DisplayName'])){

    unset($_SESSION['mess_company']);
    
    
   if($PaymentMethodCR == 'credit card'){
      $_POST["PaymentStatus"] = 1;
   }
   
        if($_POST['TotalAmount'] > $DebitAmount){
	 $_SESSION['mess_company'] = RESELLER_ACCOUNT_LIMIT;
	}else if($objConfig->isCmpEmailExists($_POST['Email'],'')){
	 $_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
	}else if($objCompany->isDisplayNameExists($_POST['DisplayName'],'')){
		$_SESSION['mess_company'] = DISPLAY_ALREADY_REGISTERED;
	}else{

		$packData=array();
		$packData=$objCmp->getPackagesByName($_POST['PaymentPlan']);
		//echo '<pre>';print_r($packData);
		$packDataUnserialize=unserialize($packData[0]['features']);
		$packageFeatureId = implode(",", $packDataUnserialize);

		//require_once("paypal_pro.inc.php");
		require_once ("paypalfunctions.php");
		
		/* order  */


		$_POST['customer_first_name'] =urlencode($_POST['FirstName']);
		$_POST['customer_last_name'] =urlencode($_POST['LastName']);
		$_POST['customer_credit_card_type']  =urlencode($_POST['customer_credit_card_type']);
		$_POST['customer_credit_card_number']  = urlencode($_POST['customer_credit_card_number']);
		$_POST['cc_expiration_month']  =urlencode($_POST['cc_expiration_month']);
		$_POST['cc_expiration_year']  =urlencode($_POST['cc_expiration_year']);
		$_POST['cc_cvv2_number']  = urlencode($_POST['cc_cvv2_number']);
		$_POST['customer_address1']  = urlencode($_POST['customer_address1']);
		$_POST['customer_city']  = urlencode($_POST['customer_city']);
		$_POST['customer_state']  =urlencode( $_POST['customer_state']);
		$_POST['customer_zip']  = urlencode($_POST['customer_zip']);
		$_POST['TotalAmount']  = urlencode($_POST['TotalAmount']);
		$_POST['customer_email_id'] =$_POST['Email'];
		
		/* */
		
		
		/* for invoice */
		
		$firstName =urlencode($_POST['FirstName']);
	    $lastName =urlencode($_POST['LastName']);
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
		if($_POST['recurring'] == 1) 
		
			// For Recurring
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

		if($_POST['TotalAmount']>0 && $PaymentMethodCR == 'credit card'){
			/*$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );
			$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
			$ack = strtoupper($resArray["ACK"]);*/


			$paymentType = "Sale";
			$expDate = $padDateMonth.$expDateYear;
			$countryCode = "US";
			$orderDescription  = "Upgrade Package Payment";
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

			echo  '<div class="redmsg" align="center"><br><br><br><br>Payment Error : '.$resArray["RESPMSG"].'</div>';exit;


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

			//$OrderID=$objCmp->AddOrder($_POST);


			/*  add company start from here*/

			/**************************/

			$_POST['Status']=1;
			$_POST['Department'] = 5;
			//$_POST["Timezone"]= '-04:00';
			$_POST["DateFormat"]= 'j M, Y';
			$_POST["currency_id"]= '9';

			// need to get from packages



			$arrayPkj=$objCmp->getPackagesByName($arrayPkjName[0]['name']);

			/*****************/
			$packDataUnserialize=unserialize($arrayPkj[0]['features']);
			$packageFeatureId = implode(",", $packDataUnserialize);
			/*****************/

			//$_POST["MaxUser"]= $arrayPkj[0]['allow_users']; //edited
			$_POST['PaymentPlan'] = $arrayPkj[0]['name'];
			$_POST['StorageLimit'] = $arrayPkj[0]['space'];
			$_POST['StorageLimitUnit'] = 'GB';

			$_POST['ContactPerson'] = $_POST['customer_first_name'].' '.$_POST['customer_last_name'];
			$_POST['Address'] = $_POST['customer_address1'].' '.$_POST['customer_address2'];
			$_POST['ZipCode'] = $_POST['customer_zip'];

			$NumMonth = 1;
			$arryDate = explode("-",date('Y-m-d'));
			list($year, $month, $day) = $arryDate;
			$TempDate  = mktime(0, 0, 0, $month+$NumMonth , $day, $year);
			$ExpiryDate = date("Y-m-d",$TempDate);
			$_POST["ExpiryDate"]= $ExpiryDate;
				
			$_POST["RsID"] = $_SESSION['CrmRsID'];
		
			
			/***********************/

			$CmpID = $objCompany->AddCompany($_POST);
			
			#$arryCompany['Email'] = $_POST['Email'];
			#$arryCompany['BuyNow'] = 1;
			#$arryCompany['Password'] = $_POST['Password'];
			#$objCmp->ActiveCompany($arryCompany);

			// add order /

				
			$arryCountryCode = $objRegion->getCountry($_POST['country_id'],'');
			$_POST['country_id'] = $arryCountryCode[0]['code'];
			$_POST['CrmAdminID'] = $CmpID;

			$OrderID=$objCmp->AddOrder($_POST);
			$objCmp->ActivateOrder($CmpID,$OrderID,$resArray["TRANSACTIONID"]);
			// add order /

			

		            
			$results=$objCompany->GetDefaultCompany();
            	$count=sizeof($results);
           
            if(!empty($results[0]['DisplayName'])){
		// $results[0]['DisplayName']='sakshay';  //for testing only
		$DbName = $Config['DbMain']."_".$results[0]['DisplayName'];
		$Config['DbName'] = $DbName;
		$objConfig->dbName = $Config['DbName'];
		$link=$objConfig->connect();

		$_SESSION['CmpDatabase'] = $DbName; $_SESSION['CmpID']=$CmpID;

		$order_id = $objSale->GenerateInVoiceEntryUI($_POST);              

		$objSale->basicInv($order_id,$_POST); 

		unset($_SESSION['CmpDatabase']); unset($_SESSION['CmpID']);
                 
            }

			/*************************/
			//$_SESSION['mess_company'] = COMPANY_REG;
			$AddDatabase = 1;
			$UpdateAdminMenu = 1;

			/************************/
			if($AddDatabase == 1){
				$DbName = $Config['DbMain'];
				$Config['DbName'] = $DbName;
				$objConfig->dbName = $Config['DbName'];
				$link=$objConfig->connect();
				//echo $Config['DbName'];exit;

				$DbName = $objCompany->AddDatabse($_POST['DisplayName']);
				if(!empty($DbName)){
					ImportDatabase($Config['DbHost'],$DbName,$Config['DbUser'],$Config['DbPassword'],$Prefix.'superadmin/sql/erp_company.sql');
				}
			}

			/************************/


			/* add company end  from here */

			if($OrderID>0 && $UpdateAdminMenu == 1){


				$UpdateAdminMenu = 1;
				/************************/
				if($UpdateAdminMenu == 1){
					$DbName = $Config['DbMain']."_".$_POST['DisplayName'];
					$Config['DbMain'] = $DbName;
					$objConfig->dbName = $Config['DbMain'];
					$objConfig->connect();
					$objCompany->UpdateAdminModules($CmpID,5);
					//$objCompany->UpdateAdminSubModules($CmpID,5,strtolower($_POST['PaymentPlan']));
					$objCmp->UpdateAdminSubModules($CmpID,5,strtolower($_POST['PaymentPlan']),$packageFeatureId);

				}
				/************************/

			}
			///////////////////////////////////

			header("location: thanks.php");
			exit;
				

		}


	}

}


#$arryCountry = $objRegion->getCountryWithCode('','');


/*******************************/
$arryCountry = $objRegion->getCountry('','');

include ('includes/footer.php');
?>


