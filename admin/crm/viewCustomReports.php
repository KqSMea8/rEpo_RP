<?php
	include_once("../includes/header.php");
	require_once($Prefix."classes/custom_reports.class.php");
       // require_once($Prefix."classes/region.class.php");
		//require_once($Prefix."classes/employee.class.php");
		//require_once($Prefix."classes/crm.class.php");
	
	$objReports=new customreports();
	$RedirectURL = "viewCustomReports.php?curP=" . $_GET['curP'];
	
	if (isset($_GET['Del_ID']) && $_GET['Del_ID']!=0){
		$Del_ID = $_GET['Del_ID'];
		$_SESSION['message'] = CR_DEL_ERROR;
		$delete = $objReports->deleteReportList($Del_ID);
        header('Location:'.$RedirectURL);exit;
	
	}
        
    $showsavedata = $objReports->GetReportLists();
	$num = $objReports->numRows();
        
	$pagerLink = $objPager->getPager($showsavedata, $RecordsPerPage, $_GET['curP']);
	(count($showsavedata) > 0) ? ($showsavedata = $objPager->getPageRecords()) : ("");
	require_once("../includes/footer.php"); 	
?>
