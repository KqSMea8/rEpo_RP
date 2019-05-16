<?php

/**************************************************/
require_once($Prefix."classes/warehouse.shipment.class.php");

$objShipment = new shipment();
/*
$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('USPS');
$username = $arryApiACDetails[0]['api_key'];
*/
$username = $_POST['api_key'];


// Load the class
require_once('classes/USPSPriorityLabel.php');

$weightgram = 12;

$weight=$weightgram * 0.035274;

 /* label **/
 
$uspsDate = date("m/d/Y");
 // Load the class

// Initiate and set the username provided from usps
$label = new USPSPriorityLabel($username);

// During test mode this seems not to always work as expected
$label->setTestMode(true);

$label->setFromAddress('John', 'Doe', '', '5161 Lankershim Blvd', 'North Hollywood', 'CA', '91601', '# 204', '', '8882721214');

//$label->setFromAddress($_POST['FirstnameFrom'], $_POST['LastnameFrom'], $_POST['CompanyFrom'], $_POST['Address1From'],'CA',$_POST['SourceZipcode'], $_POST['SourceZipcode'], $_POST['Address2From'], '','8882721214');

//$label->setToAddress($_POST['FirstnameTo'], $_POST['LastnameTo'], '', $_POST['Address1To'],'New York', 'NY', '10282');

$label->setToAddress('Rajveer', 'Singh', '', '230 Murray St', 'New York', 'NY', '10282');


$label->setWeightOunces($weight);
$label->setField(36, 'LabelDate',$uspsDate);

//$label->setField(32, 'SeparateReceiptPage', 'true');

// Perform the request and return result
$label->createLabel();
//echo "<pre>";print_r($label);
//echo "<pre>";print_r($label->getArrayResponse());exit;

if($label->isSuccess()) {
  //echo 'Done';
  //echo "\n Confirmation:" . $label->getConfirmationNumber();
  $_SESSION['mess_ship']=1;
  $label = $label->getLabelContents();
  
} else {
  $_SESSION['mess_ship']=0;
  //echo 'Error: ' . $label->getErrorMessage();
}
?>



