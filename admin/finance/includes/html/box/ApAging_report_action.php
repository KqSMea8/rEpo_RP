<?php require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	
        $objBankAccount=new BankAccount();
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
       
	$arryAging=$objReport->apAgingReportList($_GET['s'],$currencyArray);

	$num=$objReport->numRows();
        //$arryVendorList=$objBankAccount->getVendorList();
	
	


?>
