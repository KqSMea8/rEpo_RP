<?php
$HideNavigation = 1;
/**************************************************/
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/function.class.php");
$objFunction=new functions();
$objShipment = new shipment();
$objWarehouse=new warehouse();
$objCustomer=new Customer();
$NumLine=(!empty($_POST['NumLine']))?($_POST['NumLine']):('');
$CustID=(!empty($_GET['CustID']))?($_GET['CustID']):('');
$strPath='';
 
$AutoFreightBilling = $objConfigure->getSettingVariable('AutoFreightBilling');
?>

<script language="JavaScript1.2" type="text/javascript">
var AutoFreightBilling = '<?=$AutoFreightBilling?>';

function SetShippingRate(TotalFrieght,InsureAmount,InsureValue){
	//parent.$("#ShippingRateTr").show();
	parent.$("#ShippingRateVal").val(TotalFrieght);
	parent.$("#InsureAmount").val(InsureAmount);
	parent.$("#InsureValue").val(InsureValue);

	parent.$("#ActualFreightDiv").show();
	parent.$("#ActualFreight").val(TotalFrieght);

	if(AutoFreightBilling=='1'){
		if(window.parent.document.getElementById("Freight") != null){
			window.parent.document.getElementById("Freight").value=TotalFrieght;
			parent.calculateGrandTotal(); 
		}
	}

	parent.jQuery.fancybox.close();	 
}
</script>

<?
(!isset($_GET['ModuleType']))?($_GET['ModuleType']=""):("");


$objShipment->saveToandFromData($_POST);

if($_GET["ModuleType"]=="SalesRMA"){
	$arryAddBookShFrom=$objShipment->addBookShTo();
	$arryAddBookShTo=$objShipment->addBookShFrom();	

	$arryAddressFrom = $objShipment->defaultAddressBook("ShippingTo");	
	$arryAddressTo = $objShipment->defaultAddressBook("ShippingFrom");

	if(empty($arryAddressFrom[0]['adbID'])){
		$arryAddressFrom=$objShipment->defaultAddress();
	}
}else{
	$arryAddBookShFrom=$objShipment->addBookShFrom();
	$arryAddBookShTo=$objShipment->addBookShTo();

	$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");	
	$arryAddressTo = $objShipment->defaultAddressBook("ShippingTo");

	if(empty($arryAddressFrom[0]['adbID'])){
		$arryAddressFrom=$objShipment->defaultAddress();
	}
}




$arrayFdDfService=$objShipment->defaultFedexShippingMethod();
$arrayFdDfpackage=$objShipment->defaultFedexPack();

#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');
$arryApiACDetails=$objShipment->ShipAccountByDeault('fedex');
$MultilpleShipAccountDetail=$objShipment->ListMultilpleShipAccount('fedex'); 
////////////////////////////////////

if(!empty($_POST['Action'])){
	CleanPost();

		
		 
 

		(empty($_POST['DeliverySignature']))?($_POST['DeliverySignature']=""):(""); 
		 

		 if(empty($_POST['CustomValue'])) $_POST['CustomValue']='0.00';
 

if($_POST['CountryCgFrom']=='US' && $_POST['CountryCgTo']=='CA' && $_POST['ShippingMethod'] == 'INTERNATIONAL_GROUND'){
$_POST['ShippingMethod'] = 'FEDEX_GROUND';
}

		if(!empty($_POST['ShipAccountNumber'])){
			$ShipAccountDetail=$objShipment->ShipAccountByACNumber($_POST['ShipAccountNumber'],'fedex');
			$Config['Fedex_account_number'] = $ShipAccountDetail[0]['api_account_number'];
			$Config['Fedex_meter_number'] = $ShipAccountDetail[0]['api_meter_number'];
			$Config['Fedex_key'] = $ShipAccountDetail[0]['api_key'];
			$Config['Fedex_password'] = $ShipAccountDetail[0]['api_password'];
		}else{
			$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
			$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
			$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
			$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];
		}
		 
		$Config['live'] = $arryApiACDetails[0]['live'];

		//$strPath = "FD/";
		include_once($strPath.'fedex.settings.php');
		require_once($strPath.'classes/class.fedex.php');
		require_once ($strPath.'classes/class.fedex.rate.php');
		require_once($strPath.'classes/class.fedex.shipments.php');      
		require_once($strPath.'classes/class.fedex.package.php');
			
		$objRate = new fedexRates();
		$objRate->requestType("rate");  

$Config['live']=1;

		if($Config['live']==1){  
			$objRate->wsdl_root_path = "wsdl-live/";
		}else{
			$objRate->wsdl_root_path = "wsdl-test/";
		}
		$client = new SoapClient($objRate->wsdl_root_path.$objRate->wsdl_path, array('trace' => 1));
		
		$freigh='';
		$totalFreight='';
		$success='';
	 	$total_packages = $_POST['NoOfPackages'];

		$INVOICENO = $_POST['INVOICENO'];

		if($_POST['ShippingMethod'] == 'GROUND_HOME_DELIVERY'){
			$Res = '1';
		}else{
			$Res = '0';
		}

		$packages = array();
		$aryPackage = array();

		$aryRecipient = array(
			'Contact' => array(
				'PersonName' => $_POST['ContactNameTo'],
				'CompanyName' => $_POST['CompanyTo'],
				'PhoneNumber' => $_POST['PhoneNoTo']
				),
			'Address' => array(
				'StreetLines' => array($_POST['Address1To'], $_POST['Address2To']),
				'City' => $_POST['CityTo'],
				'StateOrProvinceCode' => $_POST['StateTo'],
				'PostalCode' =>  $_POST['ZipTo'],
				'CountryCode' => $_POST['CountryCgTo'],
				'Residential' => $Res)
                );
    
		$aryOrder = array(
			'TotalPackages' => $total_packages,
			'PackageType' => $_POST['packageType'],        //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
			'ServiceType' => $_POST['ShippingMethod'],
			//'ServiceType' => 'INTERNATIONAL_PRIORITY',
			'TermsOfSaleType' => "DDU",         #    DDU/DDP
			'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
		);  

		$LineItemDetail='';
		$totalWeight=0;
   		for($k=0;$k<$total_packages;$k++){ 
			$lineItemCount=$k+1;

			if($_POST['packageType'] == 'YOUR_PACKAGING'){
				$totalWeight += $_POST['Weight'.$lineItemCount];
				$Weight = $_POST['Weight'.$lineItemCount];
				$wtUnit = $_POST['wtUnit'.$lineItemCount];
				$htUnit = $_POST['htUnit'.$lineItemCount];
				$Length = $_POST['Length'.$lineItemCount];
				$Width =  $_POST['Width'.$lineItemCount];
				$Height = $_POST['Height'.$lineItemCount];
				if(empty($Length)) $Length=1;
				if(empty($Width)) $Width=1;
				if(empty($Height)) $Height=1;

				/***************************/
$LineItemDetail .= $Weight.','.$wtUnit.','.$Length.','.$Width.','.$Height.','. $htUnit.'#';
				/***************************/

			}else{
				$Weight=$_POST['WPK'];
				$wtUnit = $_POST['WPK_Unit'];
				$Length="";
				$Width="";
				$Height="";
				$htUnit="IN";
			}

	 	
  
 		    $packages[$k] = new Package("FEDEX Package # ".$lineItemCount, $total_packages, 1);
		    $packages[$k]->setPackageWeight($Weight,$wtUnit);     //Package Actual Weight
		 
		    $packages[$k]->setPackageDimensions($Length, $Width, $Height,$htUnit); //Package (Length x Width x Height)
		 

		
			$aryPackage[$k] = $packages[$k]->getObjectArray();
		}
       
    		$request = $objRate->rateRequest($aryRecipient, $aryOrder, $aryPackage);
	 
	try 
    {
        if($objRate->setEndpoint('changeEndpoint'))
        {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

        $response = $client->getRates($request);
	//echo '<pre>';print_r($response);exit;
        if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR')
        {
		$success = $objRate->showResponseMessage($response);                        
		$rateReply = $response -> RateReplyDetails;

		$amount = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
		$freightCurrency = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;

		$freigh=$amount;
		$totalFreight=$amount;
		
		/* Insure rate */
		$InsureValue = 0;
		$InsureAmount = $_POST['InsureAmount'];

		if(!empty($InsureAmount)){
			$IV1=$IV2=0;
			if($InsureAmount>100) $IV1 = 3.00;
			if($InsureAmount>300){
				$IV2 = (ceil($InsureAmount/100)-3)*(1.00);
			}
			$InsureValue = $IV1 + $IV2;
			$totalFreight = $freigh=$amount+$InsureValue;
		}else{
			$freigh = $totalFreight=$amount;
		} 
		/*****/
		
		
        }
        else
        {
            $error = $objRate->showResponseMessage($response);
           
        }

    } 
    catch (SoapFault $exception) 
    {
        $error = $objRate->requestError($exception, $client);
    }
    
 
	if($totalFreight<=0){
		echo "<div class=redmsg align='center'>Please Enter Correct Information : <br>".$error.'</div><br>';
	}


	if(!empty($_POST['pickEnable'])){
		
	include 'fedexPickup.php';


	}

			
	       /* AES Internal Transaction Number (ITN) */
		$CustomValueInt = $_POST['CustomValue'];
		if($CustomValueInt>=2500 ){
			$_POST['AES_NUMBER'] = $_POST['AES'];
			
		}else{
			
			$_POST['AES_NUMBER'] = '';
		}

	
	    /* AES Internal Transaction Number (ITN) */

	   
if($totalFreight>0 && !empty($_POST['Submit'])){
		$PdfFolder='fedex/';
		$_POST['fedexLabel']='Yes';
		$MainDir = "upload/fedex/".$_SESSION['CmpID']."/";						
		if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
		}	
	
		if($total_packages>1){  /*************LABEL FOR MPS ***************/

			//$error = 'Multi package shipment is under construction.';

			include 'fedexMPS.php';


			/*if($_POST['ShippingMethod']=='STANDARD_OVERNIGHT' || $_POST['ShippingMethod']=='PRIORITY_OVERNIGHT' || $_POST['ShippingMethod']=='FEDEX_GROUND'){

				include 'fedexMPS.php';

			}else{
				$error = 'Multi package shipment is not allowed for this shipping method.';
				echo "<div class='redmsg' align='center'>".$error."</div>"; 
			}*/


		}else{  /*************LABEL FOR SPS ***************/

				include 'fedexSPS.php';

		}

		echo "<div class='redmsg' align='center'>".$error."</div>"; 
}

		

		


	
		/************************************/




if(!empty($_POST['Preview']) && empty($error)){?>
<SCRIPT TYPE="text/javascript">
$.fancybox({
	 'href' :'previewfedex.php?total=<?=$totalFreight?>',
	 'type' : 'iframe',
	 'width': '500',
	 'height': '200'
	 });

</SCRIPT>

<?php }else if(empty($error)){
		if($_POST['AccountType']==1 || $_POST['AccountType']==3){
			$freigh = 0;			
			$totalFreight = 0;
		}
		$arr_freigh = (array) $freigh;
		$arr_totalFreight = (array) $totalFreight;
		$_SESSION['Shipping']['ShipType'] = 'FedEx';
		$_SESSION['Shipping']['file_name'] = (!empty($file_name)) ? $file_name : 'No Label';
		$_SESSION['Shipping']['tracking_id'] = (!empty($TrackingID)) ? $TrackingID : '';
		$_SESSION['Shipping']['freigh'] = ($arr_freigh[0]>0) ? $arr_freigh[0] : 0;
		$_SESSION['Shipping']['totalFreight'] = ($arr_totalFreight[0]>0) ? $arr_totalFreight[0] : 0;
		$_SESSION['Shipping']['freightCurrency'] = $freightCurrency;

		if($_POST['COD']==1){
			$_SESSION['Shipping']['sendingLabel'] = $file_name1;
			$_SESSION['Shipping']['COD']=1;
		}else{
			$_SESSION['Shipping']['sendingLabel'] = '';
			$_SESSION['Shipping']['COD']=0;
		}

		$freightVal = ($_SESSION['Shipping']['freigh']>0)?($_SESSION['Shipping']['freigh']):($_SESSION['Shipping']['totalFreight']);

		$_SESSION['Shipping']['ZipFrom']=$_POST['ZipFrom'];
		$_SESSION['Shipping']['CityFrom']=$_POST['CityFrom'];
		$_SESSION['Shipping']['StateFrom']=$_POST['StateFrom'];
		$_SESSION['Shipping']['CountryFrom']=$_POST['CountryCgFrom'];
		$_SESSION['Shipping']['ZipTo']=$_POST['ZipTo'];
		$_SESSION['Shipping']['CityTo']=$_POST['CityTo'];
		$_SESSION['Shipping']['StateTo']=$_POST['StateTo'];
		$_SESSION['Shipping']['CountryTo']=$_POST['CountryCgTo'];
		$_SESSION['Shipping']['ShippingMethod']=$_POST['ShippingMethod'];
		$_SESSION['Shipping']['NoOfPackages']=$_POST['NoOfPackages'];
		$_SESSION['Shipping']['Weight']=$_POST['WPK'];
		$_SESSION['Shipping']['WeightUnit']=$_POST['WPK_Unit'];
		$_SESSION['Shipping']['PackageType']=$_POST['packageType'];
		$_SESSION['Shipping']['DeliveryDate']=$DeliveryDate;
		$_SESSION['Shipping']['LineItem'] = $LineItemDetail;

		
		$_SESSION['Shipping']['CompanyFrom']=$_POST['CompanyFrom'];
		$_SESSION['Shipping']['FirstnameFrom']=$_POST['FirstnameFrom'];
		$_SESSION['Shipping']['LastnameFrom']=$_POST['LastnameFrom'];
		$_SESSION['Shipping']['Contactname']=$_POST['Contactname'];
		$_SESSION['Shipping']['Address1From']=$_POST['Address1From'];
		$_SESSION['Shipping']['Address2From']=$_POST['Address2From'];

		$_SESSION['Shipping']['CompanyTo']=$_POST['CompanyTo'];
		$_SESSION['Shipping']['FirstnameTo']=$_POST['FirstnameTo'];
		$_SESSION['Shipping']['LastnameTo']=$_POST['LastnameTo'];
		$_SESSION['Shipping']['ContactNameTo']=$_POST['ContactNameTo'];
		$_SESSION['Shipping']['Address1To']=$_POST['Address1To'];
		$_SESSION['Shipping']['Address2To']=$_POST['Address2To'];


		$_SESSION['Shipping']['AccountType']=$_POST['AccountType'];
		$_SESSION['Shipping']['AccountNumber']=$_POST['AccountNumber'];
		$_SESSION['Shipping']['ShipAccountNumber']=$_POST['ShipAccountNumber'];
		$_SESSION['Shipping']['AesNumber']=$_POST['AES_NUMBER'];
	
		/************************Extra field for seprate*************/
		$_SESSION['Shipping']['PhonenoFrom']   = $_POST['PhonenoFrom'];
		$_SESSION['Shipping']['DepartmentFrom']= $_POST['DepartmentFrom'];
		$_SESSION['Shipping']['FaxnoFrom']     = $_POST['FaxnoFrom'];
		$_SESSION['Shipping']['PhoneNoTo']   = $_POST['PhoneNoTo'];
		$_SESSION['Shipping']['DepartmentTo']= $_POST['DepartmentTo'];
		$_SESSION['Shipping']['FaxNoTo']     = $_POST['FaxNoTo'];
		$_SESSION['Shipping']['InsureAmount'] = $_POST['InsureAmount'];
		$_SESSION['Shipping']['InsureValue']  = $_POST['InsureValue'];
		$_SESSION['Shipping']['DestinationZipcode'] = $_POST['DestinationZipcode'];
		$_SESSION['Shipping']['CustomValue'] = $_POST['CustomValue'];
		$_SESSION['Shipping']['DeliverySignature']  = $_POST['DeliverySignature'];
		$_SESSION['Shipping']['TotalFreight']  = $freightVal;
		/************************************************************/

		//Save Customer Shipping Account
		if(!empty($CustID) && !empty($_POST['AccountNumber']) && $_POST['AccountType']=='1' && $_POST['CustAccountNumber']=='ADD' && $_POST['SaveCustAccount']=='1'){ 					 
			$objCustomer->SaveCustShipAcount($CustID,'Fedex',$_POST['AccountNumber']);
		}
		//Save BillToCustomer Shipping Account
		if(!empty($CustID) && !empty($_POST['BillDutiesTaxAccount']) && $_POST['BillDutiesTaxOpt']=='RECIPIENT' && $_POST['SaveCustAccount2']=='1'){ 					 
			$objCustomer->SaveCustShipAcount($CustID,'Fedex',$_POST['BillDutiesTaxAccount']);
		}

		echo "<script>SetShippingRate('".$freightVal."','".$InsureAmount."','".$InsureValue."');</script>";
		exit;
	
}
     
}


/***************************/
if(!empty($CustID)) { 
	$CustID = (int)$CustID; 
	$arryCustAccount=$objShipment->GetCustShipAccount('fedex',$CustID); 
}
/***************************/

require_once("../includes/footer.php");
?>

