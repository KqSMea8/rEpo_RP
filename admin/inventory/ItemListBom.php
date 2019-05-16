<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewItem.php'; 
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem=new items();
        $_GET['Status']=1;
	$arryProduct=$objItem->GetBillItems($_GET);
	
	$num=$objItem->numRows();
       $RecordsPerPage = 20;


	if($num>0){
		$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
		(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 
	}else{
		$errorMsg = NO_RECORD;
	}
	

	if(!empty($_GET['key']) && $num<=0){
		if($objItem->isSkuBomExists($_GET['key'])){
			$errorMsg = BOM_PART_EXIST;
		} 
	}	
  

	require_once("../includes/footer.php");

?>
