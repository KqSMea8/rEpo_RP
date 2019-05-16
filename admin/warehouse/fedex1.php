<?php
$HideNavigation = 1;
/**************************************************/

$ThisPageName = 'editReturn.php';

/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();
$NumLine=$_POST['NumLine'];

?>

<script language="JavaScript1.2" type="text/javascript">
function SetShippingRate(TotalFrieght,InsureAmount,InsureValue){
	parent.$("#ShippingRateTr").show();
	parent.$("#ShippingRateVal").val(TotalFrieght);
	parent.$("#InsureAmount").val(InsureAmount);
	parent.$("#InsureValue").val(InsureValue);
	parent.jQuery.fancybox.close();	 
}
</script>

<?

 
	
$objShipment->saveToandFromData($_POST);

$arryAddBookShFrom=$objShipment->addBookShFrom();

$arryAddBookShTo=$objShipment->addBookShTo();

//////////////////bydefault value //////////////////
$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");	
$arryAddressTo = $objShipment->defaultAddressBook("ShippingTo");

if(empty($arryAddressFrom[0]['adbID'])){
	$arryAddressFrom=$objShipment->defaultAddress();
}


$arrayFdDfService=$objShipment->defaultFedexShippingMethod();
$arrayFdDfpackage=$objShipment->defaultFedexPack();

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('FedEx');

 
////////////////////////////////////

switch ($_POST['Action']){
	case 'Fedex': 

//echo "<pre>";print_r($_POST);die;

		$Config['Fedex_account_number'] = $arryApiACDetails[0]['api_account_number'];
		$Config['Fedex_meter_number'] = $arryApiACDetails[0]['api_meter_number'];
		$Config['Fedex_key'] = $arryApiACDetails[0]['api_key'];
		$Config['Fedex_password'] = $arryApiACDetails[0]['api_password'];
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
				'Residential' => false)
                );
    
		$aryOrder = array(
			'TotalPackages' => $total_packages,
			'PackageType' => $_POST['packageType'],        //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
			'ServiceType' => $_POST['ShippingMethod'],
			//'ServiceType' => 'INTERNATIONAL_PRIORITY',
			'TermsOfSaleType' => "DDU",         #    DDU/DDP
			'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
		);  


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





	   
if($totalFreight>0 && $_POST['fedexLabel']=='Yes' && $_POST['Submit']){

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




if($_POST['Preview'] && empty($error)){?>
<SCRIPT TYPE="text/javascript">
$.fancybox({
	 'href' :'previewfedex.php?total=<?=$totalFreight?>',
	 'type' : 'iframe',
	 'width': '500',
	 'height': '200'
	 });

</SCRIPT>

<?php }else if(empty($error)){
	
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

		echo "<script>SetShippingRate('".$freightVal."','".$InsureAmount."','".$InsureValue."');</script>";
		exit;
	
}
      break;
}


/* Global Setting Data*/


//$arryApiACDetails = $objShipment->getApiAccountDetail();

require_once("../includes/footer.php");
?>

