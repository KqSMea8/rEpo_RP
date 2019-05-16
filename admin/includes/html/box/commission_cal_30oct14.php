<?
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();	
	if(substr_count("5,6,7", $EmpDivision)==0){
		$Config['SalesCommission']=0;
	}
	$ShowSalesReport=1;
	$TotalCommission=0; $TotalSales=0; $TotalSalesComm=0; $TotalSalesSpiff=0;
	if($Config['SalesCommission']==1 && $EmpID>0){		
		$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID);
		

		if(!empty($arrySalesCommission[0]['CommType']) && !empty($FromDate)  && !empty($ToDate)){	
		
$RangeFrom = $arrySalesCommission[0]["RangeFrom"];

$PrevRange = $objEmployee->GerPrevTier($RangeFrom);
$NextRange = $objEmployee->GerNextTier($RangeFrom);
if(empty($PrevRange)) $PrevRange=0;

$TargetFrom = $PrevRange+1;
$TargetTo = $RangeFrom;

if($RangeFrom==$TargetTo && empty($NextRange)) $TargetTo=0;


if(!empty($_GET['sb'])){
	//echo $RangeFrom.' = '.$TargetFrom.' - '.$TargetTo;exit;
}


/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$TotalSalesComm=$objSale->GetSalesPaymentNonResidual($FromDate,$ToDate,$EmpID);		
	}else{
		$TotalSalesComm=$objSale->GetSalesPayment($FromDate,$ToDate,$EmpID);			
	}
	
	$TotalSales += $TotalSalesComm;

	if($TargetFrom>0 && $TotalSalesComm>=$TargetFrom){
		$Percentage = $arrySalesCommission[0]['Percentage'];
		if($arrySalesCommission[0]['Accelerator']=="Yes" && $TotalSalesComm>$TargetFrom){
			$Percentage += $arrySalesCommission[0]['AcceleratorPer'];
		}
		
		$TotalCommission += ($TotalSales*$Percentage)/100;	
	}
} 
/*********************/	


/***Start spiff*******/	
if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //
	
	$TotalSalesSpiff = $objSale->GetSalesPayment($FromDate,$ToDate,$EmpID);	

	if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
	if($arrySalesCommission[0]["SalesTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SalesTarget"]){
		$TotalCommission += $arrySalesCommission[0]["SpiffAmount"];	
	}

} 
/*********************/
//echo $FromDate.','.$ToDate.','.$TotalCommission.'<br>';			


						
		}
	}
?>
