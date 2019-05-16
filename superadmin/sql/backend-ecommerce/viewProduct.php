<?php 
 	include_once("includes/header.php");
	require_once("classes/product.class.php");
	require_once("classes/category.class.php");
		
	$objProduct=new product();
	$objCategory=new category();
	
	$arryProduct=$objProduct->GetProductsView('',$_GET['CatID'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	$num=$objProduct->numRows();
        /*if($RecordsPerPage == 10)
        {
            $RecordsPerPage = $RecordsPerPage;
        }
        else{
            $RecordsPerPage = 10;
        }*/

	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 
	
	$sync_items = $objCompany->checkItemSyncSetting();
      

        require_once("includes/footer.php");

?>
