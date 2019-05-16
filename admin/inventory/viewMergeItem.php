<?php 
 	include_once("../includes/header.php");

	require_once($Prefix."classes/bom.class.php");
#echo "bbbbbb"; exit;
	require_once($Prefix."classes/category.class.php");
		
	$objBom=new bom();
	$objCategory=new category();

	/*if($_GET['CatID']<=0){
		header('location:viewProductCategory.php');
		exit;
	}*/	 
         //($id=0,$SearchKey,$SortBy,$AscDesc,$Status)

       /************************************************/

        /************************************************/

	 $arryMergeItem = $objBom->ListMergeItem('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['Status']);
                
	 $num=$objBom->numRows();
       



	 $pagerLink=$objPager->getPager($arryMergeItem,$RecordsPerPage,$_GET['curP']);
	 (count($arryMergeItem)>0)?($arryMergeItem=$objPager->getPageRecords()):(""); 
	 
         //$listAllCategory =  $objCategory->ListAllCategories();
	
		  

  require_once("../includes/footer.php");

?>
