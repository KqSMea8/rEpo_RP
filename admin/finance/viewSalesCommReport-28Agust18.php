<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");		
	$objSale = new sale();
	$objEmployee=new employee();
	/*************************/
	(empty($_GET['m']))?($_GET['m']=""):("");
	(empty($_GET['y']))?($_GET['y']=""):("");
	(empty($_GET['s']))?($_GET['s']=""):("");
  	(!isset($_GET['sp']))?($_GET['sp']=""):("");
	$TotalAmount=0;
	/*************************/
	if(!empty($_GET['m']) && !empty($_GET['y'])){		
		$FromDate = $_GET['y']."-".$_GET['m']."-01";
		$NumDayMonth = date('t', strtotime($FromDate));
		$ToDate = $_GET['y']."-".$_GET['m']."-".$NumDayMonth;
	}else if(!empty($_GET['y'])){
		$FromDate = $_GET['y']."-01-01";		
		$ToDate = $_GET['y']."-12-31";
	}

	$CommissionAp = $objConfigure->getSettingVariable('CommissionAp');
	if($CommissionAp!=1){
		$_GET['sp']=0;
	}



	if(!empty($_GET['sb'])){	
		$arryPayment=$objSale->SalesCommissionReport($FromDate,$ToDate,$_GET['s'],$_GET['sp']); 
		$num=$objSale->numRows();
 
		/*if($_GET['s'] >0){
			$arryEmp = $objEmployee->GetEmployeeBrief($_GET['s']);
		}*/

	}
	/*************************/
	/*if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],1)==1){
		$_GET["Division"] = '5,6,7';
	}else if(substr_count($Config['CmpDepartment'],5)==1){
		$_GET["Division"] = '5';
	}else{
		$_GET["Division"] = '6';
	} 
	
	$_GET['Status']= 1;
	$_GET['Department']= 17;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	*/
	 
	$arrySalesPerson=$objSale->SalesCommissionReport('','','',$_GET['sp']); 

 
	require_once("../includes/footer.php"); 	
?>


