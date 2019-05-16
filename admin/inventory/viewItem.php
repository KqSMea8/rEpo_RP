<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
	include_once("includes/FieldArray.php");	
//require_once($Prefix."classes/custom_search.class.php");
//$csearch = new customsearch();
	$objItem=new items();
	$objCategory=new category();
    
         //$_GET['Status']=1;
          $ViewUrl = "viewItem.php?curP=".$_GET['curP'];




	

	/******Get Item Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryProduct=$objItem->GetItemsView($_GET);	
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objItem->GetItemsView($_GET);	
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	


$arryItemsCustomers = $objItem->getExlusiveItemsCustomers();  //By chetan 14Sept. 2016//
         $listAllCategory =  $objCategory->ListAllCategories();
	
		  

  	require_once("../includes/footer.php");

?>
