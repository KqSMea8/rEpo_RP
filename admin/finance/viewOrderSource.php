<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/saleSetting.class.php");
	$objSaleconfig=new saleconfig();
$ModuleName = "Order Source";
	$_GET['att'] = 5;
	if($_GET['att']>0){	
		$arryAtt=$objSaleconfig->getAllCrmAttribute('',$_GET['att'],'');
		$num=sizeof($arryAtt);

		$arryAttribute=$objSaleconfig->AllAttributes($_GET['att']);
	 }	 
	

	require_once("../includes/footer.php");
?>

