<?php 
	 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();
	$objCustomer = new Customer();
 
	(empty($_GET['sp']))?($_GET['sp']=""):(""); 

	/*******Get Sales Person List***********/
	unset($arryInDepartment);	
	if(empty($arryCompany[0]['Department']) || in_array("1",$arryCmpDepartment)){
		$_GET["dv"] = '5,6,7';
	}else if(substr_count($Config['CmpDepartment'],5)==1){
		$_GET["dv"] = '5';
	}else{
		$_GET["dv"] = '6';
	}

	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
	if($numInDept>0){
		if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
		if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
		$_GET["Status"]=1;
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);		
	}
	/***************************************/

	/*******Get Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;	
	$arryRecord=$objCustomer->GetCustomerBySalesPerson($_GET);        
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCustomer->GetCustomerBySalesPerson($_GET);      
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/


	require_once("../includes/footer.php"); 	
?>


