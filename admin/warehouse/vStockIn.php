<?php 
	//if(!empty($_GET['pop'])) //$HideNavigation = 1;

	/**************************************************/
	$ThisPageName = 'viewStockIn.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");	

	require_once($Prefix."classes/purchase.class.php");
	$Module="StockIn";
	$objPurchase=new purchase();
	$ModuleName = "Manage StockIn";	
	$RedirectURL = "viewStockIn.php?curP=".$_GET['curP'];
	
	if(empty($_GET['tab'])) $_GET['tab']="Manage Bin";

	$EditUrl = "editSockIn.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vStockIn.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 	

	
	require_once("../includes/footer.php"); 	 
?>



