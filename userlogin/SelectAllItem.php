<?php 
	$HideNavigation = 1;
	/**************************************************/
	//$ThisPageName = 'viewItem.php'; 
	/**************************************************/
 	include_once("includes/header.php");
	require_once("../classes/item.class.php");
	$objItem=new items();

	$_GET['Status'] = 1;
	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryProduct = $objItem->GetItemsViewForSale($_GET);
	$Config['GetNumRecords'] = 1;
	$arryCount=$objItem->GetItemsViewForSale($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	
	
	
		  

 require_once("includes/footer.php"); 

?>
