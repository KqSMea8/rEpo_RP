<?php
$HideNavigation = 1;
/**************************************************/

$ThisPageName = 'usps.php';

/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");

$objShipment = new shipment();
$objWarehouse=new warehouse();
$NumLine=$_POST['NumLine'];

$objShipment->saveToandFromData($_POST);

$arryAddBookShFrom=$objShipment->addBookShFrom();

$arryAddBookShTo=$objShipment->addBookShTo();

//////////////////bydefault value //////////////////

$arryListWareh=$objShipment->defaultAddress();
$arrayUSPSService=$objShipment->defaultUSPSShippingMethod();

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('USPS');

$username = $arryApiACDetails[0]['api_key'];


//echo "<pre>";print_r($arrayFdDfService);
////////////////////////////////////



// Load the class
require_once('classes/USPSRate.php');
require_once('classes/USPSPriorityLabel.php');

 if($_POST['Action']){
 	//echo "<pre>";print_r($_POST);die;
// Initiate and set the username provided from usps
$rate = new USPSRate($username);

$weightgram = $_POST['Weight'];

$weight=$weightgram * 0.035274;

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

// add the package to the rate stack
$rate->addPackage($package);

// Perform the request and print out the result
$rate->getRate();
//$rate->getArrayResponse();


$results=$rate->getArrayResponse();

foreach($results as $result){
	
	 $totalFreight=$result['Package']['Postage']['Rate'];
	
}

//echo 'Rate='.$totalFreight.'<br>';
// Was the call successful

if($rate->isSuccess()) {
  //echo 'Done';
  
	//$_SESSION['freigh'] = $totalFreight;
	
	
} else {
  echo 'Error: ' . $rate->getErrorMessage();
  $_SESSION['totalFreight'] = '';
}

   if($_POST['COD']==1){

   $_SESSION['COD']=1;

}else{
    $_SESSION['sendingLabel'] = 'No Sending Label';
$_SESSION['COD']=0;


}




 /* label **/
 
 $uspsDate = date("m/d/Y");
 // Load the class

// Initiate and set the username provided from usps
$label = new USPSPriorityLabel($username);

// During test mode this seems not to always work as expected
$label->setTestMode(true);

//$label->setFromAddress('John', 'Doe', '', '5161 Lankershim Blvd', 'North Hollywood', 'CA', '91601', '# 204', '', '8882721214');

$label->setFromAddress($_POST['FirstnameFrom'], $_POST['LastnameFrom'], $_POST['CompanyFrom'], $_POST['Address1From'],'CA',$_POST['SourceZipcode'], $_POST['SourceZipcode'], $_POST['Address2From'], '','8882721214');

//$label->setToAddress($_POST['FirstnameTo'], $_POST['LastnameTo'], '', $_POST['Address1To'],'New York', 'NY', '10282');


$label->setToAddress($_POST['FirstnameTo'], $_POST['LastnameTo'], '', '230 Murray St', 'New York', 'NY', '10282');


$label->setWeightOunces($weight);
$label->setField(36, 'LabelDate',$uspsDate);

//$label->setField(32, 'SeparateReceiptPage', 'true');

// Perform the request and return result
$label->createLabel();

//echo "<pre>";print_r($label->getArrayResponse());

//die;
//echo "<pre>";print_r($label->getPostData());
//var_dump($label->isError());


// See if it was successful
if($label->isSuccess()) {
  //echo 'Done';
  //echo "\n Confirmation:" . $label->getConfirmationNumber();

  $label = $label->getLabelContents();
  
   
 $trackingId = time();

 file_put_contents('uspsLabel/'.$trackingId.'.pdf',base64_decode($label));

/*$_SESSION['tracking_id'] = $trackingId;
$_SESSION['ShipType'] = 'USPS';
$_SESSION['sendingLabel'] = $trackingId.'.pdf';
*/
   
 /* 
  * 
  if($label) {
  	$contents = base64_decode($label);
  	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="label.pdf"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . strlen($contents));
	echo $contents;
	exit;
  }*/
   
//echo 'Label='.$trackingId.'.pdf';

} else {
  echo 'Error: ' . $label->getErrorMessage();
}

 
	if($_POST['Preview']){?>
	<SCRIPT TYPE="text/javascript">
	$.fancybox({
		 'href' :'previewusps.php?total=<?=$totalFreight?>',
		 'type' : 'iframe',
		 'width': '500',
		 'height': '200'
		 });
	
	</SCRIPT>
	
	<?php }else{
		
		$_SESSION['tracking_id'] = $trackingId;
		$_SESSION['ShipType'] = 'USPS';
		$_SESSION['sendingLabel'] = $trackingId.'.pdf';
		$_SESSION['freigh'] = $totalFreight;
		
	}


}
			
//$arryApiACDetails = $objShipment->getApiAccountDetail();


require_once("../includes/footer.php");
?>



