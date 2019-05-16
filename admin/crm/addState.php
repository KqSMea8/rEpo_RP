<?php

/* * *********************************************** */
$ThisPageName = 'generateInvoice.php';
/* * *********************************************** */
$HideNavigation = 1;
include_once("../includes/header.php");
require_once($Prefix."classes/territory.class.php");

/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
        
$objTerritory=new territory();


 
if($_GET['country_id'] > 0){
   $arryState =  $objRegion->getStateByCountryForTerritory($_GET['country_id'],$_GET['key']);
}


require_once("../includes/footer.php");
?>
