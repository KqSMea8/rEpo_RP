<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/field.class.php");
	$objField=new field();
	$_GET['mod'] = (isset($_GET['mod'])) ? (int)$_GET['mod'] : '';
	if($_GET['mod']>0){	
		$arryAtt=$objField->getAllCrmHead('',$_GET['mod'],'');
		$num=sizeof($arryAtt);
	 }	 
	  //$arryAttribute=$objField->AllFields($_GET['att']);
	$ModuleName = "Header";
	require_once("../includes/footer.php");
?>

