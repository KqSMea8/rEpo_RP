<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewPo.php'; 
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");
require_once($Prefix."classes/item.class.php");
	$objWarehouse=new warehouse();
$objItem =new items();

	/******Get Item Records***********/	
	$_GET['Status'] = 1;
if($_GET['key']!=''){

$Config['key'] = $_GET['key'];

}

 #$arryWbin=$objItem->GetBinBySku($arryProduct[0]['Sku'],$_GET['WID']);


	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryProduct=$objWarehouse->getBinByWarehouse($_GET['WID'],$_GET['key']);	
	
	#print_r($arryProduct);

	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objWarehouse->getBinByWarehouse($_GET['WID'],$_GET['key']);	
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/		  
	 		  

  	require_once("../includes/footer.php");

?>
