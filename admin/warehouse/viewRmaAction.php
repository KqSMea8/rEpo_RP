<?php  
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.class.php");

	$objrmaaction=new warehouse();
        
     $data_Collection = $objrmaaction->Allviewaction();   
		
	$num=$objrmaaction->numRows();

	$pagerLink=$objPager->getPager($data_Collection,$RecordsPerPage,$_GET['curP']);
	(count($data_Collection)>0)?($data_Collection=$objPager->getPageRecords()):("");
	require_once("../includes/footer.php"); 	 
?>
