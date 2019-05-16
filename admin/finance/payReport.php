<?php 
	if($_GET['pop']==1){$HideNavigation = 1;$_GET['sb']=1;}
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");		
	$objSale = new sale();
	$objEmployee=new employee();
	/*************************/
	
	if($_GET['sp']=="1"){
		$EmpID = 0; $SuppID = $_GET['s'];
	}else{
		$EmpID = $_GET['s']; $SuppID=0;
	}

	if($_GET['f']>0) $FromDate = $_GET['f'];
	if($_GET['t']>0) $ToDate = $_GET['t']; 
	if(!empty($_GET['sb'])){
		$arryPayment=$objSale->PaymentReport($_GET['f'],$_GET['t'],$_GET['s'],$_GET['sp']);
		$num=$objSale->numRows();
 
		/*$pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
		(count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");*/
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


