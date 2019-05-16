<?php 
	//$SetFullPage=1;
	
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();
	$objBankAccount = new BankAccount();
	$objReport = new report();
         
	 
	$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']); 
	if(!in_array($Config['Currency'],$arrySelCurrency)){
		$arrySelCurrency[] = $Config['Currency'];
	}
	sort($arrySelCurrency);


        $currencyArray = array();
        $query = explode("&",$_SERVER['QUERY_STRING']);
        foreach($query as $val){
            $valArrray =  explode("=",$val);
            if($valArrray[0] == 'Currency'){
                array_push($currencyArray, $valArrray[1]);
            }
        }
        



	$arryAging=$objReport->arAgingReportList($_GET['CustCode'],$currencyArray);
        /* END's HERE */
        
        
	$num=$objReport->numRows();
        
        //Get Customer
        $arryCustomer=$objBankAccount->getCustomerList();


	/*$pagerLink=$objPager->getPager($arryAging,$RecordsPerPage,$_GET['curP']);
	(count($arryAging)>0)?($arryAging=$objPager->getPageRecords()):("");*/
	/*************************/
 
	/***************************************/
	/*******Get Sales Person List***********/
	unset($arryInDepartment);	
	if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],1)==1){
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

		$arryEmployee = $objEmployee->GetEmployeeList($_GET);		
	}
	/***************************************/
	/***************************************/



	

	//require_once("../includes/footer.php"); 	
?>


