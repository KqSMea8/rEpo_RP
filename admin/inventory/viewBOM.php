<?php 
 	include_once("../includes/header.php");
require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
	include_once("includes/FieldArray.php");

	//$RecordsPerPage=10;	
	$objBom=new bom();
$objItem=new items();
	/*if (isset($_GET["curP"])) { $page  = $_GET["curP"]; } else { $page=1; }
             $start_from = ($page-1) * $RecordsPerPage;
	$Config['$start_from'] = $start_from;
	$Config['RecordsPerPage'] = $RecordsPerPage;*/

        	//$arryBOM = $objBom->ListBOMListing($_GET);
         
	 //$num=$objBom->numRows();
       
	/*$pagerLink=$objPager->getPager($arryBOM,$RecordsPerPage,$_GET['curP']);
	(count($arryBOM)>0)?($arryBOM=$objPager->getPageRecords()):(""); */
	 
    
/******Get Item Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryBOM = $objBom->ListBOMListing($_GET);	
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
  $arryCount = $objBom->ListBOMListing($_GET);      
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	
 
	
		  

  require_once("../includes/footer.php");

?>
