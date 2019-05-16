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
		
if(!empty($arrySalesCommission[0]['CommType'])){
	
	$TargetFrom = $arrySalesCommission[0]["TargetFrom"];
	$TargetTo = $arrySalesCommission[0]["TargetTo"];

	//if($_GET['a']==1){echo $TargetFrom;exit;}

/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesComm=$objSale->GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$EmpID);		
	}else{
		$arryTotalSalesComm=$objSale->GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$EmpID);				
	}	
	
	foreach($arryTotalSalesComm as $key_cm=>$values_cm){
		$TotalSalesComm = $values_cm['TotalSales'];
		$TotalSales += $TotalSalesComm;
		if($TargetFrom>=0 && $TotalSalesComm>=$TargetFrom){
			$Percentage = $arrySalesCommission[0]['CommPercentage'];
			if($arrySalesCommission[0]['Accelerator']=="Yes" && $TotalSalesComm>$TargetTo){
				$Percentage += $arrySalesCommission[0]['AcceleratorPer'];
			}		
			$TotalCommission += ($TotalSalesComm*$Percentage)/100;	

		}
		
	}
} 
/*********************/	


/***Start spiff*******/	
if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //
	
	$arryTotalSalesSpiff = $objSale->GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$EmpID);	
	foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
		if($arrySalesCommission[0]["SpiffTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SpiffTarget"]){
			$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		}
	}


} 
/*********************/
//echo $FromDate.','.$ToDate.','.$TotalCommission.'<br>';			


						
		}
	}
?>
