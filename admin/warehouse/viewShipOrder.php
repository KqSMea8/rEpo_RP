<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");

	$ModuleName = "Ship";
	$objWarehouse = new warehouse();

	

	$ViewUrl = "viewShipOrder.php";
	$AddUrl = "editShipOrder.php";
	$EditUrl = "editShipOrder.php?curP=".$_GET['curP'];
	$ViewUrl = "vShipOrder.php?curP=".$_GET['curP'];
	$RedirectURL = "viewShipOrder.php";
	$ModuleIDTitle = "Ship Number"; $ModuleID = "InvoiceID";
	
	/*************************/
	$arryShip=$objWarehouse->GetShipDetail($_GET);
	$num=$objWarehouse->numRows();
	
	#echo "<pre>";
	#print_r($arryShip);
	#exit;
	$pagerLink=$objPager->getPager($arryShip,$RecordsPerPage,$_GET['curP']);
	(count($arryShip)>0)?($arryShip=$objPager->getPageRecords()):("");
	/*************************/

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_Invoice'] = SHIP_REMOVED;
		$objWarehouse->RemoveShip($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
 
	require_once("../includes/footer.php"); 	
?>


