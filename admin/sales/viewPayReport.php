<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");		
	$objSale = new sale();
	$objEmployee=new employee();
	/*************************/
	if(!empty($_GET['f']) && !empty($_GET['t'])){
		$arryPayment=$objSale->PaymentReport($_GET['f'],$_GET['t'],$_GET['s']);
		$num=$objSale->numRows();

		$pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
		(count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");
	}
	/*************************/
	if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],1)==1){
		$_GET["Division"] = '5,6,7';
	}else if(substr_count($Config['CmpDepartment'],5)==1){
		$_GET["Division"] = '5';
	}else{
		$_GET["Division"] = '6';
	}
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	if($_GET['pop']==1)$MainModuleName = 'Sales Report';
	require_once("../includes/footer.php"); 	
?>


