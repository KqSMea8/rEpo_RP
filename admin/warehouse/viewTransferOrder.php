<?php 


	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/category.class.php");
		
	$objItem=new items();
	$objCategory=new category();
	$RedirectURL = "viewTransfer.php".$_GET['curp'];

	$arryTransfer = $objItem->ListingTransfer($_GET);

	$num=$objItem->numRows();
    $pagerLink=$objPager->getPager($arryTransfer,$RecordsPerPage,$_GET['curP']);
	(count($arryTransfer)>0)?($arryTransfer=$objPager->getPageRecords()):(""); 
	 
         // $listAllCategory =  $objCategory->ListAllCategories();
	
		  

  require_once("../includes/footer.php")
 
	
?>


