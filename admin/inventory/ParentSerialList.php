<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAssemble.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
        require_once($Prefix."classes/purchase.class.php");
		
	$objItem=new items();
	$objCategory=new category();
        $objPurchase= new purchase();

	$_GET['Line']='';
         // $ViewUrl = "viewSerial.php?curP=".$_GET['curP'];
$_GET['Used'] ='1';
$_GET['UsedMergeItem'] ='1';
	$arrySerial=$objItem->ListSerialNumber($_GET);
	$num=$objItem->numRows();
        
   
	$pagerLink=$objPager->getPager($arrySerial,$RecordsPerPage,$_GET['curP']);
	(count($arrySerial)>0)?($arrySerial=$objPager->getPageRecords()):(""); 
	 
          //$listAllCategory =  $objCategory->ListAllCategories();
	
		  
	require_once("../includes/footer.php"); 	
?>


