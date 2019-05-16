<?

	$TotalCommission=0; $TotalSales=0; $TotalSalesComm=0; $TotalSalesSpiff=0;

	if($Config['SalesCommission']==1 && $RsID>0){	
		unset($arrySalesCommission);	
		//$arrySalesCommission = $objReseller->GetSalesCommission($RsID);
		 $arrySalesCommission = $arrySalesCommReseller[$RsID];

if(!empty($arrySalesCommission[0]['CommType'])){
	
	$TargetFrom = $arrySalesCommission[0]["TargetFrom"];
	$TargetTo = $arrySalesCommission[0]["TargetTo"];

	//if($_GET['a']==1){echo $TargetFrom;exit;}

/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesComm=$objReseller->GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$RsID);		
	}else{
		$arryTotalSalesComm=$objReseller->GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$RsID);				
	}	
	
	foreach($arryTotalSalesComm as $key_cm=>$values_cm){
		$TotalSalesComm = $values_cm['TotalSales'];
		$TotalSales += $TotalSalesComm;
		if($TargetFrom>=0 && $TotalSalesComm>=$TargetFrom){
			$Percentage = $arrySalesCommission[0]['CommPercentage'];
			if($arrySalesCommission[0]['Accelerator']=="Yes" && $TotalSalesComm>$TargetTo){
				$OriginalComm = ($TargetTo*$Percentage)/100;	
				$Percentage += $arrySalesCommission[0]['AcceleratorPer'];
				$AccComm = (($TotalSalesComm-$TargetTo)*$Percentage)/100;

				$TotalCommission += $OriginalComm + $AccComm;
			}else{		
				$TotalCommission += ($TotalSalesComm*$Percentage)/100;	
			}

		}
		
	}
} 
/*********************/	


/***Start spiff*******/	
if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //
	
	$arryTotalSalesSpiff = $objReseller->GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$RsID);	
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
