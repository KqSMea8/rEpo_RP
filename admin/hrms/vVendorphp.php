<?php 
	if($_GET['pop']==1)$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; 
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/supplier.class.php");


	$objSupplier=new supplier();
	
	$ModuleName = "Supplier";
	$RedirectURL = "viewSupplier.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "editSupplier.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vSupplier.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$arrySupplier = $objSupplier->GetSupplier($_GET['view'],'','');
		$SuppID   = $_REQUEST['view'];	
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}

	}else{
		header('location:'.$RedirectURL);
		exit;
	}



	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';
	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';
	}else if($_GET['tab']=='currency'){
		$SubHeading = 'Currency';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
		$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Supplier','');	
	}



	

	require_once("../includes/footer.php"); 	 
?>


