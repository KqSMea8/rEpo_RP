<?
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();	

	(empty($OrderID))?($OrderID=""):("");


	if($EmpID>0 && @substr_count("5,6,7", $EmpDivision)==0){
		$Config['SalesCommission']=0;
	}
	$ShowSalesReport=1;
	$TotalCommission=0; $TotalSales=0; $TotalSalesComm=0; $TotalSalesSpiff=0;

	if($Config['SalesCommission']==1 && ($EmpID>0 || $SuppID>0)){			
		$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID,$SuppID);
		
		//pr($arrySalesCommission);
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

	//if($_GET['a']==1){echo $TargetFrom;exit;}
/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){ 

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesComm=$objSale->GetInvPaymentNonResidual($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		
	}else{
		$arryTotalSalesComm=$objSale->GetInvPaymentCal($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);			
	}
 
 //pr($arryTotalSalesComm);
	foreach($arryTotalSalesComm as $key_cm=>$values_cm){
		$TotalSalesComm = $values_cm['TotalSales'];
		$TotalSalesItemComm = $values_cm['TotalItemSales'];
		$TotalSales += $TotalSalesComm;

		if($TargetFrom>=0 && $TotalSalesComm>=$TargetFrom){	

			$Percentage = $arrySalesCommission[0]['CommPercentage'];
			$Percentage = (!empty($values_cm['CommPercentage']) ? $values_cm['CommPercentage'] : $Percentage);

#echo $TargetTo.'-Target<br>Totalsales-'.$TotalSalesComm;
			if($arrySalesCommission[0]['Accelerator']=="Yes" && $TotalSalesComm>$TargetTo){
				$OriginalComm = ($TargetTo*$Percentage)/100;	
				$Percentage += $arrySalesCommission[0]['AcceleratorPer'];
				$AccComm = (($TotalSalesComm-$TargetTo)*$Percentage)/100;
				$TotalCommission += $OriginalComm + $AccComm;
			}else{		
				$TotalCommission += ($TotalSalesComm*$Percentage)/100;	

				#echo '<br>'.$TotalSalesComm.'#'.$Percentage;
			}	
			
		}



	}
	
} 
/*********************/	
#echo '<br>pk: '.$TotalSales.'#'.$TotalCommission.'<br>';
#pr($arrySalesCommission);
/***Commision & Spiff*******/	
if($arrySalesCommission[0]['CommType']=="Commision & Spiff"){   

/*	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesSpiff=$objSale->GetInvPaymentNonResidual($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		
	}else{
		$arryTotalSalesSpiff=$objSale->GetInvPaymentCal($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);			
	}	 */
	
	if($arrySalesCommission[0]['SpiffType']=="one"){
	
	$oneTime =0;
	$TotalSales=0;
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);	
	
	}else{
		$arryTotalSalesSpiff=$objSale->GetInvPaymentCal($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		
	}
	
	
 
 //pr($arryTotalSalesSpiff);
	/*foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		if($arrySalesCommission[0]["SpiffTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SpiffTarget"]){
			if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;

			$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		}
	}*/
	
		foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		
		
		}
			if($TotalSalesSpiff>0){
			if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
			if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
			$TotalCommission += $values_sp['TotalItemSales'];
			
			}else{
			
     if($arrySalesCommission[0]["amountType"]=='Percentage'){
        $TotalCommission += ($TotalSalesSpiff*$arrySalesCommission[0]["SpiffEmp"])/100;
     }else{
        $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];
     }
			
			
			}
	}
	}

	
	
	
} 
/*********************/


/***Spiff Only*******/	
if($arrySalesCommission[0]['CommType']=="Spiff" && empty($arrySalesCommission[0]['SpiffOn'])){   

#pr($arrySalesCommission);
	
	//$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);
	
		if($arrySalesCommission[0]['SpiffType']=="one"){
		
		$TotalSales=0;
		$oneTime = 0;
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		
	
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);
		
	
	
	}else{
		$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		
	}
	

	
 #pr($arryTotalSalesSpiff);
	foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		
		#echo $TotalSalesSpiff.'#TotalSale';
		
		$TotalSales += $TotalSalesSpiff;
		
	/*foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		if($arrySalesCommission[0]["SpiffTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SpiffTarget"]){
			if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;

			$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		}
	}*/
	if($TotalSalesSpiff>0){
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
	     $TotalCommission += $values_sp['TotalItemSales'];
	  }else{
		   if($arrySalesCommission[0]["amountType"]=='Percentage'){
		     $TotalCommissionPercen = ($TotalSalesSpiff*$arrySalesCommission[0]["SpiffEmp"])/100;
		     $TotalCommission +=$TotalCommissionPercen;
		   }else{
	      $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];
		   }
		}
		}	
	}
} 
/*********************/
 
/*********************/


#echo '<br>pk: '.$TotalSales.'#'.$TotalCommission.'<br>';			


						
		}
	}
?>
