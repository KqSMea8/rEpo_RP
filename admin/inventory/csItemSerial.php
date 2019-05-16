<?php 
        $HideNavigation = 1;   
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
        require_once($Prefix."classes/purchase.class.php");
	include_once("includes/FieldArray.php");
	$objItem=new items();
	
        $ViewUrl = "viewSerial.php?curP=".$_GET['curP'];
	$_GET['key'] = 'available';
	$_GET['sortby'] = '';
$_GET['warehouse'] = '1';
	
	$arrySerial=$objItem->ListSerialNumber($_GET);
	$num=$objItem->numRows();

	$pagerLink=$objPager->getPager($arrySerial,$RecordsPerPage,$_GET['curP']);
	(count($arrySerial)>0)?($arrySerial=$objPager->getPageRecords()):(""); 
	 		  

  	require_once("../includes/footer.php");

?>
