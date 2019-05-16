<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();
	$objSale = new sale();

	$ModuleName = "Sales by Sales Person";
	$ViewUrl = "viewSalesbySalesPerson.php";
	$RedirectURL = "viewSalesbySalesPerson.php";
	
	$arrySale=$objSale->SalesReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$_GET['s'],$_GET['st']);
	$num=$objSale->numRows();
	
	//get order total amnt by customer
	 $totalOrderAmnt = $objSale->getSalesPersonOrderedAmount($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['s'],$_GET['st']);;
	
	//get employee list
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
		if($_GET["dv"]>0){
			$arryDepartmentRec = $objConfigure->GetDepartmentInfo($_GET["dv"]);
			$PageHeading .= ' from '.$arryDepartmentRec[0]['Department'];
		}
		
		if($numInDept>0){
			if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
			if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];

			$arryEmployee = $objEmployee->GetEmployeeList($_GET);
			
		}else{
			$ErrorMSG = NO_DEPARTMENT;
		}

	/***********End****************************************/
	
	
	
	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


