<?php 
 //$NavText=1; 
if($ThisPageName=='viewPosLicenseeReport.php') $ThisPageName = 'viewPosLicenseeReport.php';
$_GET['report']='licensee';
$_GET['menu'] == 1;
$HideNavigation=0;

	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	
	
	
	$objReport = new report();

	$ModuleName = "licensee Report";
	 
        if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}
        if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-1');}
        
	$arrySale=$objReport->licenseeReport($_GET['fby'],$FromDate,$ToDate,$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);
	$num=$objReport->numRows();
	
	
	
	

	/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>



