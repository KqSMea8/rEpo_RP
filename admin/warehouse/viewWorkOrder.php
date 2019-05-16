<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/category.class.php");
	include_once("includes/FieldArray.php");	
	$objBom=new bom();
	$objCategory=new category();

	$MainModuleName = 'Work Order';

	 $arryWorkOrder = $objBom->ListWorkOrder($_GET);
         
         
	 $num=$objBom->numRows();
       
	 $pagerLink=$objPager->getPager($arryWorkOrder,$RecordsPerPage,$_GET['curP']);
	(count($arryWorkOrder)>0)?($arryWorkOrder=$objPager->getPageRecords()):(""); 
	 
         // $listAllCategory =  $objCategory->ListAllCategories();
	
		  

  require_once("../includes/footer.php");

?>
