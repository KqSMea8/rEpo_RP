<?php 
    /**************************************************/
    $ThisPageName = 'upgradePackages.php'; $EditPage = 1; 
    /**************************************************/
    
	include_once("includes/header.php");
	include ('includes/function.php');
	require_once("../../classes/company.class.php");
	require_once("../../classes/user.class.php");
	require_once("../../classes/cmp.class.php");
	require_once("../../classes/region.class.php");
	require_once("../../classes/sales.quote.order.class.php");
	require_once("../../classes/sales.customer.class.php");

	$objSale = new sale();
    $objCmp=new cmp();
	$objCompany=new company();
	$objRegion=new region();

	$objUser=new user();
	$id=$_GET['cmp'];
   $arrayOrderInfo=$objCmp->showOderInformationSA($id);

if(!empty($_POST['paySubmit'])){
	
	    unset($_SESSION['mess_dash']);
	    
  if($PaymentMethodCR == 'credit card'){
      $_POST["PaymentStatus"] = 1;
   }

   
		if($_POST['PaymentPlan']== 7){
			$_POST['PaymentPlan']="STANDARD";
		} 
		
		if ($_POST['PaymentPlan']== 8){
			$_POST['PaymentPlan']="PROFESSIONAL";
		}
		
		if ($_POST['PaymentPlan']== 9){
			$_POST['PaymentPlan']="ENTERPRISE";
		}
	
		
    if($_POST['TotalAmount'] > $DebitAmount){
	 $_SESSION['mess_dash'] = "<div align='center' class='redmsg' height='2'>You do not have sufficient credit balance in your account.</div>";
    }else{
	    $packData=array();
        $packData=$objCmp->getPackagesByName($_POST['PaymentPlan']);

        $packDataUnserialize=unserialize($packData[0]['features']);
        $packageFeatureId = implode(",", $packDataUnserialize);
  
         
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
		
			    $_POST['Status']=1;
				$_POST['Department'] = 5;
				$_POST["Timezone"]= '-04:00';
				$_POST["DateFormat"]= 'j M, Y';
				$_POST["currency_id"]= '9';
			
				$_SESSION['CrmAdminID']=$_GET['cmp'];
				$arryCountryCode = $objRegion->getCountry($_POST['country_id'],'');
				$_POST['country_id'] = $arryCountryCode[0]['code'];
				$_POST['RsID']=$_SESSION['CrmRsID'];
			
		
	   	        $OrderID=$objCmp->AddOrder($_POST);
	   	       
				$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');
				$CmpID= $arryCompany[0]['CmpID'];	
	   	  
	   	       	$objCmp->ActivateOrder($CmpID,$OrderID,$resArray["TRANSACTIONID"]);
	   	       	
	           $results=$objCompany->GetDefaultCompany();
	        
	            $count=count($results);
	           
	            if($count>0){
	                  //$results[0]['DisplayName']='sakshay';  //for testing only
	                   $DbName = $Config['DbMain']."_".$results[0]['DisplayName'];
	                  
	                  $Config['DbName'] = $DbName;
	                 
	                   $objConfig->dbName = $Config['DbName'];
	                 
	                  $link=$objConfig->connect();
	                
	                  $order_id = $objSale->GenerateInVoiceEntryUI($_POST); 
	            
	                  $objSale->basicInv($order_id,$_POST); 
	                  
	                  /* recipt*/
	  
	                 
	            }
          
	   	

	   
	     if($OrderID>0){
	     		   	
	   		$UpdateAdminMenu = 1;	   	 
		   	 /************************/
			 if($UpdateAdminMenu == 1){
				 $DbName = $Config['DbMain']."_".$arryCompany[0]['DisplayName'];
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
		    unset($_SESSION['CrmAdminID']);
			$_SESSION['mess_dash'] = 'Package has been upgraded successfully.';
			header("location: viewPackageLog.php?cmp=$CmpID");
			exit;
			
		}
		
    }
			
}



/*require_once("../classes/region.class.php");
$objRegion=new region();
$arryCountry = $objRegion->getCountry('','');*/


	
	if($_GET['cmp']>0){
		$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');
		$CmpID   = $arryCompany[0]['CmpID'];
		$RedirectUrl = 'viewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'];	
		
		
	}

	
	$viewAll = 'viewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'];
	
	$arryCountry = $objRegion->getCountry('','');

	require_once("includes/footer.php"); 	 
?>
