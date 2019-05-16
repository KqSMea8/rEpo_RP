<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewItem.php'; 
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem=new items();

	$_GET['Status'] = 1;
	$arryProduct = $objItem->GetItemsView($_GET);
	
	$num=$objItem->numRows();
        if($RecordsPerPage == 10)
        {
            $RecordsPerPage = $RecordsPerPage;
        }
        else{
            $RecordsPerPage = 10;
        }

	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 		  

  	require_once("../includes/footer.php");
?>
