<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
        require_once($Prefix."classes/purchase.class.php");
		
	$objItem=new items();
	$objCategory=new category();
        $objPurchase= new purchase();

	/*if($_GET['CatID']<=0){
		header('location:viewProductCategory.php');
		exit;
	}*/
        
         //$_GET['Status']=1;
          $ViewUrl = "viewPriceList.php?curP=".$_GET['curP'];

	
         $arryItemOrder=$objItem->GetPurchasedPriceItem($_GET['key']);
		 
		
       
	
	    $num=$objItem->numRows();
        if($RecordsPerPage == 1000)
        {
            $RecordsPerPage = $RecordsPerPage;
        }
        else{
            $RecordsPerPage = 1000;
        }

	$pagerLink=$objPager->getPager($arryItemOrder,$RecordsPerPage,$_GET['curP']);
	(count($arryItemOrder)>0)?($arryItemOrder=$objPager->getPageRecords()):(""); 
	 
          //$listAllCategory =  $objCategory->ListAllCategories();
	
		  

  require_once("../includes/footer.php");

?>
