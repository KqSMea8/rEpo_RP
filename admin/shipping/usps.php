<?php
$HideNavigation = 1;
/**************************************************/
$ThisPageName = 'usps.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/sales.customer.class.php");
$objShipment = new shipment();
$objWarehouse=new warehouse();
$objCustomer=new Customer();
$NumLine=(!empty($_POST['NumLine']))?($_POST['NumLine']):('');
$CustID=(!empty($_GET['CustID']))?($_GET['CustID']):('');
(empty($accessNumber))?($accessNumber=""):("");
(empty($password))?($password=""):("");

$AutoFreightBilling = $objConfigure->getSettingVariable('AutoFreightBilling');

/***************************/
if(!empty($CustID)){ 
	$CustID = (int)$CustID; 
	$arryCustAccount=$objShipment->GetCustShipAccount('USPS',$CustID); 
}
/***************************/
?>

<script language="JavaScript1.2" type="text/javascript">

var AutoFreightBilling = '<?=$AutoFreightBilling?>';


function SetShippingRate(TotalFrieght){
	//parent.$("#ShippingRateTr").show();
	parent.$("#ShippingRateVal").val(TotalFrieght);
	//parent.$("#InsureAmount").val(InsureAmount);
	//parent.$("#InsureValue").val(InsureValue);

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


$arrayUSPSService=$objShipment->defaultUSPSShippingMethod();

// Add New Section Mail Type
$arrayUspsMailType=$objShipment->defaultUSPSMailtype();

// Add New Section Package Size
$arrayUspsPackageSize=$objShipment->defaultUSPSPackageSize();

#$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('USPS');
$arryApiACDetails=$objShipment->ShipAccountByDeault('USPS');
$MultilpleShipAccountDetail=$objShipment->ListMultilpleShipAccount('USPS'); 
////////////////////////////////////

if(!empty($_POST['ShipAccountNumber'])){
	$ShipAccountDetail=$objShipment->ShipAccountByACNumber($_POST['ShipAccountNumber'],'USPS');
	$username = $ShipAccountDetail[0]['api_key'];
}else{
	$username = $arryApiACDetails[0]['api_key'];
}




//echo "<pre>";print_r($arrayFdDfService);
////////////////////////////////////



// Load the class
require_once('classes/USPSRate.php');
require_once('classes/USPSPriorityLabel.php');

if(!empty($_POST['Action'])){
 	 
	 
	$rate = new USPSRate($username);

	$weightgram = $_POST['Weight'];

	$weight=$weightgram * 0.035274;

	$total_packages = $_POST['NoOfPackages'];

// During test mode this seems not to always work as expected
//$rate->setTestMode(true);

// Create new package object and assign the properties
// apartently the order you assign them is important so make sure
// to set them as the example below
// set the USPSRatePackage for more info about the constants
$package = new USPSRatePackage;


//$package->setService(USPSRatePackage::SERVICE_FIRST_CLASS);

$package->setService($_POST['ShippingMethod']);

$package->setFirstClassMailType(USPSRatePackage::MAIL_TYPE_LETTER);

$package->setFirstClassMailType($_POST['FirstClassMailType']);

//SourceZipcode  91601
//DestinationZipcode 91730

$package->setZipOrigination($_POST['SourceZipcode']);
$package->setZipDestination($_POST['DestinationZipcode']);
$package->setPounds(0);
$package->setOunces($weight);
$package->setContainer('');

//$package->setSize(USPSRatePackage::SIZE_REGULAR);

$package->setSize($_POST['PackageSize']);

$package->setField('Machinable', true);

//echo "<pre>";print_r($package);


// add the package to the rate stack
$rate->addPackage($package);
//echo "<pre>";print_r($rate);
// Perform the request and print out the result
$rate->getRate();
//$rate->getArrayResponse();
//echo "<pre>";print_r($rate->getRate());die;

$results=$rate->getArrayResponse();

$error = $rate->isError();

foreach($results as $result){
	
	 $totalFreight=$result['Package']['Postage']['Rate'];
	
}

//echo 'Rate='.$totalFreight.'<br>';
// Was the call successful

if($rate->isSuccess()) {
  //echo 'Done';
  
//$_SESSION['freigh'] = $totalFreight;
	
	
} else {
  //echo 'Error: ' . $rate->getErrorMessage();
  echo "<div class='redmsg' align='center'>".$rate->getErrorMessage()."</div>";
  $_SESSION['totalFreight'] = '';
}

   /*if($_POST['COD']==1){

   $_SESSION['COD']=1;

}else{
    $_SESSION['sendingLabel'] = 'No Sending Label';
    $_SESSION['COD']=0;


}*/


/*if($totalFreight<=0){
   echo "<div class=redmsg align='center'>Please Enter Correct Information : <br>".$error.'</div><br>';
}*/
	
if($totalFreight>0 && !empty($_POST['Submit'])){
	$_POST['uspsLabel'] = 'Yes';

     if($total_packages>=1){ 
           /************* Print the label ***************/  
           
		$uspsDate = date("m/d/Y");
		/* Insured Amount Rate */
		$InsureValue = 0;
		$InsureAmount = 600;

		if(!empty($InsureAmount)){
			$IV1=$IV2=$IV3=$IV4=$IV5=0;
			
			if($InsureAmount>=0.01 && $InsureAmount<=50) $IV1 = 1.65;
			
			if($InsureAmount>=50.01 && $InsureAmount<=100) $IV2 = 2.05;
			
			if($InsureAmount>=100.01 && $InsureAmount<=200) $IV3 = 2.45;
			
			if($InsureAmount>=200.01 && $InsureAmount<=300) $IV4 = 4.60;
			
			if($InsureAmount>300){
			        $IVPr=4.60;
				$IV5 = (ceil($InsureAmount/100)-3)*(0.90);
			}
			
			#echo '1=>'.$IV1.'2=>'.$IV2.'3=>'.$IV3.'4=>'.$IV4.'5=>'.$IV5;
		        $InsureValue = $IV1+$IV2+$IV3+$IV4+$IV5+$IVPr;
			
		}
              /*****/
		 // Load the class
		// Initiate and set the username provided from usps
		$label = new USPSPriorityLabel($username);
		// During test mode this seems not to always work as expected
		$label->setTestMode(true);
		$label->setFromAddress($_POST['FirstnameFrom'], $_POST['LastnameFrom'], $_POST['CompanyFrom'], $_POST['Address1From'],$_POST['CityFrom'],$_POST['StateFrom'], $_POST['ZipFrom'], $_POST['Address2From'], '',$_POST['PhonenoFrom']);
		//$label->setToAddress($_POST['FirstnameTo'], $_POST['LastnameTo'], $_POST['CompanyTo'], '650 technology Park', 'Lake Mary', 'FL', '32746','', '', $_POST['PhoneNoTo']);
	$label->setToAddress($_POST['FirstnameTo'], $_POST['LastnameTo'], $_POST['CompanyTo'], $_POST['Address1To'],$_POST['CityTo'], $_POST['StateTo'], $_POST['ZipTo'],'', '',$_POST['PhoneNoTo']);		
		$label->setWeightOunces($weight);
		$label->setField(36, 'LabelDate',$uspsDate);
		$label->setField(44, 'InsuredAmount', $InsureValue);
		//'44:InsuredAmount' => '20',
		//$label->setField(32, 'SeparateReceiptPage', 'true');
		// Perform the request and return result
		//$label->addContent('Shirt', '10', 0, 10);
		$label->createLabel();
		/*echo "<pre>";print_r($label);
		echo "<br><br>";
		echo "<pre>";print_r($label->getArrayResponse());die;*/

		// $rate->getErrorMessage()
                $error = $label->getErrorMessage();
                //var_dump($label->getErrorMessage());
		//echo "hello";die;
		//echo "<pre>";print_r($label->getPostData());
		//var_dump($label->isError());
               //$error = $label->isError();  42032746 9470101699320029288464
		// See if it was successful
		if($label->isSuccess()) {
		  //echo 'Done';
		  //echo "\n Confirmation:" . $label->getConfirmationNumber();
		  $TrackId = $label->getConfirmationNumber();
		  $TrackNum=substr($TrackId,8);  
		  $label = $label->getLabelContents();
		  $trackingId = $TrackNum;
		 
		  $contents = base64_decode($label);
		  $MainDir = "upload/usps/".$_SESSION['CmpID']."/";						
		if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
		}
		
		$file_name = 'USPS000_'.$_POST['ShippingMethod'].'_'.$trackingId.'.pdf';
	        $fp = fopen($MainDir.$file_name, 'wb');  
		fwrite($fp, $contents);
		fclose($fp);	

	        }else {
		   echo "<div class='redmsg' align='center'>".$error."</div>";
	        }
         }


} else { 
  //echo 'Error: ' . $label->getErrorMessage();
  //echo "<div class='redmsg' align='center'>Error:".$rate->getErrorMessage()."</div>"; 
}

 
	if(!empty($_POST['Preview']) && empty($error)){?>
	<SCRIPT TYPE="text/javascript">
	$.fancybox({
		 'href' :'previewusps.php?total=<?=$totalFreight?>',
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
		$_SESSION['Shipping']['ShipType'] = 'USPS';
		$_SESSION['Shipping']['file_name'] = (!empty($file_name)) ? $file_name : 'No Label';
		$_SESSION['Shipping']['tracking_id'] = (!empty($trackingId)) ? $trackingId : '';
	        $_SESSION['Shipping']['totalFreight'] = $totalFreight;
		$_SESSION['Shipping']['sendingLabel'] = $trackingId.'.pdf';

		
		//$freightVal = ($_SESSION['freigh']>0)?($_SESSION['freigh']):($_SESSION]['totalFreight']);
                //$totalFreight = ($_SESSION['freigh']>0)?($_SESSION['freigh']):($_SESSION]['totalFreight']);
                
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
			$objCustomer->SaveCustShipAcount($CustID,'USPS',$_POST['AccountNumber']);
		}


		echo "<script>SetShippingRate('".$totalFreight."');</script>";
		//exit;
		
	}


}//  Action Is Closed
			
 


require_once("../includes/footer.php");
?>



