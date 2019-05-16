<?php 


	/**************************************************/
	$ThisPageName = 'viewManageBin.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");	

	require_once($Prefix."classes/warehouse.class.php");

        $Module="Warehouse";
	$objwarehouse=new warehouse();		
	
	$ModuleName = "Manage Bin";
	$RedirectURL = "viewManageBin.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Manage Bin";

	$EditUrl = "editManageBin.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vManageBin.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 	


	require_once("../includes/footer.php"); 	 
?>


