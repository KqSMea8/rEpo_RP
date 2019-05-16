<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix . "classes/custom_search.class.php");
	$objItem = new items();
	$csearch = new customsearch();

	/*************************/
	if($_GET['condition'] != '' && $_GET['type']!='')
	{	
		$ItemIds = $_SESSION['allBomItemidArr'];
		$arrorderHistory = $csearch->getQtyOrderfr($_GET['type'],$ItemIds,$_GET['condition'],'rows');//echo "<pre/>";print_r($arrorderHistory);
	}

	$num=$csearch->numRows();

	$pagerLink=$objPager->getPager($arrorderHistory,$RecordsPerPage,$_GET['curP']);
	(count($arrySaleHistory)>0)?($arrorderHistory=$objPager->getPageRecords()):("");
	/*************************/
 

	require_once("../includes/footer.php"); 	
?>


