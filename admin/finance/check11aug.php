<?php 
	$HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	$objReport = new report();
	$objSupplier=new supplier();
	$objTransaction=new transaction();
 	$TransactionID   = $_GET['TransactionID'];
 	

	if(!empty($TransactionID)){
		/*****************/
		$_GET['PaymentType'] = 'Purchase';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
		$CheckFormat = (!empty($_GET['frm']))?($_GET['frm']):($arryTransaction[0]['CheckFormat']);
		$CheckNumber = (!empty($_GET['Chk']))?($_GET['Chk']):($arryTransaction[0]['CheckNumber']);
		$PaymentDate = (!empty($_GET['Date']))?($_GET['Date']):($arryTransaction[0]['PaymentDate']);		
		/*****************/
		$arryTemplate = $objReport->GetCheckTemplate();	
		$arryTransactionData = $objTransaction->ListSessionTransaction('AP',$TransactionID ,''); 		
		//echo '<pre>';print_r($arryTransaction);exit;
		$Count=0;
		foreach($arryTransactionData as $key=>$values){
			$SuppCode = $values['SuppCode'];							
			foreach($values as $k=>$val){  
				$arryVendorData[$SuppCode][$Count][$k] = $val;			
			}
			$Count++;
		}
		//print_r($arryVendorData);exit;		
		 
		
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}        

	$Config['DateFormat'] = 'm/d/Y';
 	require_once("../includes/footer.php"); 	
?>



