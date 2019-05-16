<?php  $HideNavigation = 1;
	require_once("includes/header.php");
	require_once("includes/helpinc.php");
	
	$arryHelpModule= $objConfig->GetDepartment();
    $NumAllowedHelp = sizeof($arryHelpModule);
    //echo '<pre>';print_r($listworkflow);die('raj');
	//$num=$objConfig->numRows();
    $pagerLink=$objPager->getPager($arryHelpModule,$RecordsPerPage,$_GET['curP']);
	(count($arryHelpModule)>0)?($arryHelpModule=$objPager->getPageRecords()):("");
    
    require_once("includes/footer.php"); 
?>
