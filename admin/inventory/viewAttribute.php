<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/inv.class.php");
if($_GET['att'] == 5){
require_once($Prefix."classes/item.class.php");
$objItem=new items();
}
	$objCommon=new common();
	if($_GET['att']>0){	
		$arryAtt=$objCommon->getAllCrmAttribute('',$_GET['att'],'');
		$num=sizeof($arryAtt);
	 }	 
	$arryAttribute=$objCommon->AllAttributes($_GET['att']);  
	$ModuleName = $arryAttribute[0]["attribute"];
	require_once("../includes/footer.php");
?>

