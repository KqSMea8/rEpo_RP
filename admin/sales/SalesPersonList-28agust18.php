<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'editSalesQuoteOrder.php';
	/**************************************************/

	include_once("../includes/header.php");
require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();

	if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],1)==1){
		$_GET["dv"] = '5,6,7';
	}else if(substr_count($Config['CmpDepartment'],5)==1){
		$_GET["dv"] = '5';
	}else{
		$_GET["dv"] = '6';
	}
	
	(!isset($_GET["sp"]))?($_GET["sp"]="0"):(""); 

	$CommissionAp = $objConfigure->getSettingVariable('CommissionAp');
	if($CommissionAp!=1){
		$_GET['sp']=0;
	}

	

	unset($arryInDepartment);
	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
    
 
	if($_GET["d"]>0) {
	    $_GET["Department"] = $_GET["d"];
	}
	if($_GET["dv"]>0) { 
		$_GET["Division"] = $_GET["dv"];
	}

	/*******Get Employee Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
	$arryCount=$objEmployee->GetEmployeeList($_GET);
	//$num=sizeof($arryCount);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
 
 
	require_once("../includes/footer.php"); 	

?>


