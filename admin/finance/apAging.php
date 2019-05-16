<?php 
	//$SetFullPage=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	
        $objBankAccount=new BankAccount();
	$objReport = new report();
 
	(empty($_GET['s']))?($_GET['s']=""):(""); 
	(empty($_GET['InvDtType']))?($_GET['InvDtType']=""):(""); 
	(empty($_GET['InvDt']))?($_GET['InvDt']=""):(""); 
	$InvDt=$ModuleName='';

  	$arrySelCurrency=array();
	if(!empty($arryCompany[0]['AdditionalCurrency']))  $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']); 
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
        $arryVendorList=$objBankAccount->getVendorList();
	
	

	/*$pagerLink=$objPager->getPager($arryAging,$RecordsPerPage,$_GET['curP']);
	(count($arryAging)>0)?($arryAging=$objPager->getPageRecords()):("");*/
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


