<?php 
$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem = new items();

	//$RedirectURL = "viewReturn.php?module=Return";
	$ModuleName = "Sales History";
	

	/*************************/
	if($_GET['comp'] == 'yes' && $_GET['condition']!='')
	{	
		$values = $objItem->GetItemBySku($_GET['sku']);
		$bomArr = $objItem->GetKitItem($values[0]['ItemID']);
		$allBomItemidArr = array_column($bomArr, 'item_id');
		array_push($allBomItemidArr,$values[0]['ItemID']);
		$allItemid = implode("','",$allBomItemidArr);#print_r($allItemid);
		$arrySaleHistory = $objItem->GetSOHistory('','',$_GET['numHistory'],$allItemid,$_GET['condition'],$_GET['WID']); //updated by chetan on 5Apr2017//
	}else{
		$values = $objItem->GetItemBySku($_GET['sku']);
	 	$arrySaleHistory = $objItem->GetSOHistory('','',$_GET['numHistory'],$values[0]['ItemID'],$_GET['condition'],$_GET['WID']);//updated by chetan on 5Apr2017//

	}
	$num=$objItem->numRows();

	$pagerLink=$objPager->getPager($arrySaleHistory,$RecordsPerPage,$_GET['curP']);
	(count($arrySaleHistory)>0)?($arrySaleHistory=$objPager->getPageRecords()):("");
	/*************************/
 
  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>

