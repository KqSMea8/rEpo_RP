<?php 

	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
		
	$objItem=new items();
	$objCategory=new category();


        $ViewUrl = "viewItem.php?curP=".$_GET['curP'];




	/******Get Model Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryModel = $objItem->ListModel($_GET);	


	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objItem->ListModel($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	


	

	
	
		  

  require_once("../includes/footer.php");

?>
