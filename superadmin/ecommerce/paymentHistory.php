<?php 
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
    include_once("includes/FieldArray.php");
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	$arryPaymentHistory=$supercmsObj->getPaymentHistory($_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num=$supercmsObj->numRows();
	$pagerLink=$objPager->getPager($arryPaymentHistory,$RecordsPerPage,$_GET['curP']);
	(count($arryPaymentHistory)>0)?($arryPaymentHistory=$objPager->getPageRecords()):("");

}
 require_once("includes/footer.php"); 	 
?>
