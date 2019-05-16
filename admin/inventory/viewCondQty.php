<?php 
$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem = new items();

	//$RedirectURL = "viewReturn.php?module=Return";
	$ModuleName = "Condition Qty";
	

	/*************************/
	
	 $arryCondQty=$objItem->getItemCondionQty($_GET['sku'],'');

	$num=$objItem->numRows();

	$pagerLink=$objPager->getPager($arryCondQty,$RecordsPerPage,$_GET['curP']);
	(count($arryCondQty)>0)?($arrySaleHistory=$objPager->getPageRecords()):("");
	/*************************/
 
  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>


