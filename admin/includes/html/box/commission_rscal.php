<?

	$TotalCommission=0; $TotalSales=0; $TotalSalesComm=0; $TotalSalesSpiff=0;

	if($Config['SalesCommission']==1 && $RsID>0){		
		unset($arrySalesCommission);
		//$arrySalesCommission = $objReseller->GetSalesCommission($RsID);
		 $arrySalesCommission = $arrySalesCommReseller[$RsID];


if(!empty($arrySalesCommission[0]['CommType'])){

#if(!empty($arrySalesCommission[0]['CommType']) && !empty($FromDate)  && !empty($ToDate)){	
	/*	
	$RangeFrom = $arrySalesCommission[0]["RangeFrom"];
	$PrevRange = $objEmployee->GerPrevTier($RangeFrom);
	$NextRange = $objEmployee->GerNextTier($RangeFrom);
	if(empty($PrevRange)) $PrevRange=0;
	$TargetFrom = $PrevRange+1;
	$TargetTo = $RangeFrom;
	if($RangeFrom==$TargetTo && empty($NextRange)) $TargetTo=0;
	//echo $RangeFrom.' = '.$TargetFrom.' - '.$TargetTo;exit;
	*/

	
	$TargetFrom = $arrySalesCommission[0]["TargetFrom"];
	$TargetTo = $arrySalesCommission[0]["TargetTo"];

	//echo $TargetFrom;exit;

/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$TotalSalesComm=$objReseller->GetSalesPaymentNonResidual($FromDate,$ToDate,$RsID);		
	}else{
		$TotalSalesComm=$objReseller->GetSalesPayment($FromDate,$ToDate,$RsID);	
	}
	
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
/*********************/	


/***Start spiff*******/	
if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //
	
	$TotalSalesSpiff = $objReseller->GetSalesPayment($FromDate,$ToDate,$RsID);	

	if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
	if($arrySalesCommission[0]["SpiffTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SpiffTarget"]){
		$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
	}


} 
/*********************/
//echo $FromDate.','.$ToDate.','.$TotalCommission.'<br>';			


						
		}
	}
?>
