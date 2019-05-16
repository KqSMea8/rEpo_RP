<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
		
	$objItem=new items();
	$objCategory=new category();

	$arryProduct = $objItem->getAllwritedown(''); 
	//print_r($arryProduct);
	
	$num=$objItem->numRows();        

	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 
	 

  	require_once("../includes/footer.php");
?>
