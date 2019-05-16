<?php
	require_once("includes/header.php");
require_once("../classes/region.class.php");
	
	$ModuleName = "Currency";
	
	if (class_exists(region)) {
		$objRegion=new region();
	} else {
		echo "Class Not Found Error !! Region Class Not Found !";
		exit;
	}


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_currency'] = $ModuleName.$MSG[103];
		$objRegion->deleteCurrency($_REQUEST['del_id']);
		header("location:viewCurrencies.php?curP=".$_GET['curP']);
	}


	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_currency'] = $ModuleName.$MSG[104];
		$objRegion->changeCurrencyStatus($_REQUEST['active_id']);
		header("location:viewCurrencies.php?curP=".$_GET['curP']);
	}
	
	

	if ($_POST) {
	
		if (!empty($_POST['currency_id'])) {
			$objRegion->updateCurrency($_POST);
			$_SESSION['mess_currency'] = $ModuleName.$MSG[102];
		} else {		
			$objRegion->addCurrency($_POST);
			$_SESSION['mess_currency'] = $ModuleName.$MSG[101];
		}
	
		header("location: viewCurrencies.php?curP=".$_GET['curP']);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryMember = $objRegion->getCurrency($_GET['edit'],'');
		extract($arryMember[0]);
	}

	
 require_once("includes/footer.php");
 
 
 ?>
