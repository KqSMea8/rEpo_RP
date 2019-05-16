<?php

$HideNavigation = 1; #$_GET['debug']=1;
/**************************************************/
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/function.class.php");

// Require the main ups class and upsRate
require('classes/class.ups.php');
require('classes/class.upsRate.php');
require('classes/class.upsShip.php');

$objFunction=new functions();
$objShipment = new shipment();
$objWarehouse=new warehouse();
$objCustomer=new Customer();
$NumLine=(!empty($_POST['NumLine']))?($_POST['NumLine']):('');
$CustID=(!empty($_GET['CustID']))?($_GET['CustID']):('');
$MainDir = "upload/ups/".$_SESSION['CmpID']."/";
//$DocumentDir = _ROOT.'/admin/warehouse/'.$MainDir;

$DocumentDir = _ROOT.'/admin/shipping/'.$MainDir;

$AutoFreightBilling = $objConfigure->getSettingVariable('AutoFreightBilling');

/***************************/
if(!empty($CustID)) { 
	$CustID = (int)$CustID; 
	$arryCustAccount=$objShipment->GetCustShipAccount('UPS',$CustID); 
}
/***************************/

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


<?php

(!isset($_GET['ModuleType']))?($_GET['ModuleType']=""):("");

//////////////////bydefault value //////////////////

$objShipment->saveToandFromData($_POST);

if($_GET["ModuleType"]=="SalesRMA"){
	$arryAddBookShFrom=$objShipment->addBookShTo();
	$arryAddBookShTo=$objShipment->addBookShFrom();	

	$arryAddressFrom = $objShipment->defaultAddressBook("ShippingTo");	
	$arryAddressTo = $objShipment->defaultAddressBook("ShippingFrom");

	if(empty($arryAddressFrom[0]['adbID'])){
		$arryListWareh=$objShipment->defaultAddress();
	}
}else{
	$arryAddBookShFrom=$objShipment->addBookShFrom();
	$arryAddBookShTo=$objShipment->addBookShTo();

	$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");
	$arryAddressTo = $objShipment->defaultAddressBook("ShippingTo");

	if(empty($arryAddressFrom[0]['adbID'])){
		$arryListWareh=$objShipment->defaultAddress();
	}
}




$arrayService=$objShipment->defaultUPSShippingMethod();
$arrayPackage=$objShipment->defaultUPSPack();

#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('UPS');
$arryApiACDetails=$objShipment->ShipAccountByDeault('UPS');
$MultilpleShipAccountDetail=$objShipment->ListMultilpleShipAccount('UPS'); 

if(!empty($_POST['ShipAccountNumber'])){
	$ShipAccountDetail=$objShipment->ShipAccountByACNumber($_POST['ShipAccountNumber'],'UPS');
	$Config['ups_account_number']= $ShipAccountDetail[0]['api_account_number'];
	$Config['ups_key']= $ShipAccountDetail[0]['api_key'];
	$Config['ups_password']= $ShipAccountDetail[0]['api_password'];
	$Config['ups_ShipperNumber'] = $ShipAccountDetail[0]['api_meter_number'];
}else{
	$Config['ups_account_number']= $arryApiACDetails[0]['api_account_number'];
	$Config['ups_key']= $arryApiACDetails[0]['api_key'];
	$Config['ups_password']= $arryApiACDetails[0]['api_password'];
	$Config['ups_ShipperNumber'] = $arryApiACDetails[0]['api_meter_number'];
}

/*************************/
#$arrayPickup = array('DailyPickup'=>'Daily Pickup','CustomerCounter'=>'Customer Counter','OneTimePickup'=>'One Time Pickup','OnCallAir'=>'On Call Air','LetterCenter'=>'Letter Center','AirServiceCenter'=>'Air Service Center');
$arrayPickup = array('OnCallAir'=>'On Call Air');
/*************************/






////////////////////////////////////

//echo "<pre>";print_r($arrayFdDfService);
////////////////////////////////////

// Get credentials from a form
/*$accessNumber = '2CF8EA8CA48FB215';
 $username = 'mkbtechnology';
 $password = 'mkbTech2014#';*/
/*
 $accessNumber = '3D0AAD3E8E63E378';
 $username = 'virtualstacks';
 $password = '84733Mkb#';

 */

/*
$Config['ups_account_number']= '2CF8EA8CA48FB215';
$Config['ups_key']= 'mkbtechnology';
$Config['ups_password']= 'mkbTech2014#';
*/




$upsConnect = new ups($Config['ups_account_number'],$Config['ups_key'],$Config['ups_password']);
$upsConnect->setTemplatePath('xml/');
$upsConnect->setTestingMode(0); // Change this to 0 for production

$upsShip = new upsShip($upsConnect);

if(!empty($_POST['Action'])){

	CleanPost();
	(empty($_POST['DeliverySignature']))?($_POST['DeliverySignature']=""):(""); 

     if(!empty($_POST['DeliverySignature'])){
		
		$Config['DSFlag'] = 1;
		
		if($_POST['DSOptionsType']==1){
			$SignatureRate=2.00;
		}elseif ($_POST['DSOptionsType']==2){
			$SignatureRate=4.25;
		}elseif($_POST['DSOptionsType']==3){
			$SignatureRate=5.25;
		}else{
			$SignatureRate='';
		}
		
		
	
}



$PdfFolder='ups/';

/*******Setting For other account***/
if($_POST['AccountType']==1){
	
    $_POST['AccountCountry']= $_POST['CountryCgTo'];
    $_POST['AccountZipCode']= $_POST['ZipTo'];
   
}elseif($_POST['AccountType']==3){
	
	$_POST['AccountCountry']= $_POST['ThirdPartyCountry'];
    $_POST['AccountZipCode']= $_POST['ThirdPartyZipFrom'];
    
}else{
	
	$_POST['AccountCountry']= 'US';
    $_POST['AccountZipCode']= '32746';
}
/**********************************/


 	$WeightLabel = $LengthLabel = $WidthLabel = $HeightLabel = '';

	for($i=1;$i<=$NumLine;$i++){ 
		$WeightLabel += $_POST['Weight'.$i];
		$LengthLabel += $_POST['Length'.$i];
		$WidthLabel += $_POST['Width'.$i];
		$HeightLabel += $_POST['Height'.$i];
	}
	
	$_POST['WeightLabel']=$WeightLabel;
	$_POST['LengthLabel']=$LengthLabel;
	$_POST['WidthLabel']=$WidthLabel;
	$_POST['HeightLabel']=$HeightLabel;
	
	$wtUnit = $_POST['wtUnit1'];
	$htUnit = $_POST['htUnit1'];
	
	include 'upsRate.php';

	/* Insure rate */
	/* less than 100 no charges and 100+ charges 2.70 and if amount greater than 300 charges 0.90 every 100+ 
 	* and insure value multiply by number of packages * */
	
		$numberPack = $_POST['NoOfPackages'];
		$InsureValue = 0;
		$InsureAmount = $_POST['InsureAmount'];

		if(!empty($InsureAmount)){
			$IV1=$IV2=0;
			if($InsureAmount>100) $IV1 = 2.70;
			if($InsureAmount>300){
				$IV2 = (ceil($InsureAmount/100)-3)*(.90);
			}
			$InsureValue = ($IV1 + $IV2)*($numberPack);
			$totalFreight += $InsureValue;
		}else{


$_POST['InsureAmount']= 0.00;
		}
		
	/*****/
	

	if($_POST['DeliverySignature']==1 && !empty($SignatureRate)){
		$totalFreight +=$SignatureRate;
	}

	if($totalFreight>0 &&  !empty($_POST['Submit'])){
		$_POST['fedexLabel']='Yes';
	$upsShip->buildRequestXML();
	$responseArray = $upsShip->responseArray();
#echo "<pre>";print_r($responseArray['ShipmentConfirmResponse']['Response']['Error']);die;
        $errorTypeWarning = $responseArray['ShipmentConfirmResponse']['Response']['Error']['ErrorSeverity']['VALUE'];
	$error = $responseArray['ShipmentConfirmResponse']['Response']['Error']['ErrorDescription']['VALUE'];

if($errorTypeWarning=='Warning'){
	unset($error);
}



$pakNumber=$_POST['NoOfPackages'];
if($pakNumber==1){
include 'upsSPS.php';
}else{
include 'upsMPS.php';
}

	}


if(!empty($_POST['Preview']) && empty($error)){?>
<SCRIPT TYPE="text/javascript">
$.fancybox({
	 'href' :'previewups.php?total=<?=$totalFreight;?>',
	 'type' : 'iframe',
	 'width': '500',
	 'height': '200'
	 });
</SCRIPT>

	<? }else if(empty($error)){
		if($_POST['AccountType']==1 || $_POST['AccountType']==3){
			$freigh = 0;			
			$totalFreight = 0;
		}
		$arr_freigh = (array) $freigh;
		$arr_totalFreight = (array) $totalFreight;
		$_SESSION['Shipping']['ShipType'] = 'UPS';
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
			$objCustomer->SaveCustShipAcount($CustID,'UPS',$_POST['AccountNumber']);
		}

		echo "<script>SetShippingRate('".$freightVal."','".$InsureAmount."','".$InsureValue."');</script>";
		exit;

	}else{
		echo "<div class=redmsg align='center'>Please Enter Correct Information : <br>".$error.'</div><br>';
	}
	
}


require_once("../includes/footer.php");
?>


