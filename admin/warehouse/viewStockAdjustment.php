<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/category.class.php");
		
	$objItem=new items();
	$objCategory=new category();

	/*if($_GET['CatID']<=0){
		header('location:viewProductCategory.php');
		exit;
	}*/	 
//($id=0,$SearchKey,$SortBy,$AscDesc,$Status)

	 $arryAdjustment = $objItem->GetAdjustment('',2);
	 $num=$objItem->numRows();
       
	  $pagerLink=$objPager->getPager($arryAdjustment,$RecordsPerPage,$_GET['curP']);
	 (count($arryAdjustment)>0)?($arryAdjustment=$objPager->getPageRecords()):(""); 
	 
      // $listAllCategory =  $objCategory->ListAllCategories();
	
		  

  require_once("../includes/footer.php");

?>
