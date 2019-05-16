<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrde.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem=new items();
 
	 
	$arryOptionCode = $objItem->getOptionCode($_GET['ItemID']);
	$num=$objItem->numRows();
	/*By Chetan*/
        $arryAlias  =   $objItem->GetAliasbyItemID($_GET['ItemID']);
	$AliasNum   =   $objItem->numRows();
        /****/ 
	require_once("../includes/footer.php"); 	
?>


