<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$_GET['att'] = (int)$_GET['att'];

	if($_GET['att']>0){	
		$arryAtt=$objCommon->getAttribute('',$_GET['att'],'');
		$num=sizeof($arryAtt);

		$arryAttribute=$objCommon->AllAttributes($_GET['att']);  
		$ModuleName = $arryAttribute[0]["attribute"];
	 }	 	
	require_once("../includes/footer.php");
?>

