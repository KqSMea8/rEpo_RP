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

//echo "=>".$_GET['state_id'];exit;
if($_GET['state_id'] > 0){

    $allState = explode(",", $_GET['state_id']);
    
}
        
 
$arryCity = array();

if(sizeof($allState) > 0){
    foreach($allState as $value){
       
            $arryCity[]['StateName'] =  $objRegion->getStateName($value);
            $arryCity[]['CityList'] =  $objRegion->getCityByStateForTerritory($value,$_GET['key']);

          
    }
}
 

//echo "<pre>";
//print_r($arryCity);
//exit;


require_once("../includes/footer.php");
?>
