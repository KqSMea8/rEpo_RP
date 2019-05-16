<?php 
	if($_GET['pop']==1){$HideNavigation = 1;}
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/sales.customer.class.php"); //added by nisha on 13th sept
	$objSale = new sale();
	$objEmployee=new employee();
	$objCustomer=new Customer();
	/*************************/	
	if($_GET['sp']=="1"){
		$EmpID = 0; $SuppID = $_GET['s'];
	}else{
		$EmpID = $_GET['s']; $SuppID=0;
	}

	if($EmpID>0 || $SuppID>0){			
		$arrySalesCommissionComm = $objEmployee->GetSalesCommission($EmpID,$SuppID);
	}
 
	if($_GET['f']>0) $FromDate = $_GET['f'];
	if($_GET['t']>0) $ToDate = $_GET['t']; 
	if(!empty($_GET['s'])){
		$arryPayment=$objSale->CommReport($arrySalesCommissionComm[0], $_GET['f'],$_GET['t'],$_GET['s'],$_GET['sp']);
		$num=$objSale->numRows(); 
		//pr($arryPayment);
	}
	/*************************/	
	$salesPersonName=''; 
	if(!empty($_GET['s'])){
		$salesPersonName = $objConfig->getSalesPersonName($_GET['s'],$_GET['sp']);
	}
	if($_GET['pop']==1)$MainModuleName = 'Sales Report';
	require_once("../includes/footer.php"); 	
?>


