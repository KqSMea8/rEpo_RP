<?
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();	

if($EmpID>0 && @substr_count("5,6,7", $EmpDivision)==0){
		$Config['SalesCommission']=0;
}
	$ShowSalesReport=1;
	$TotalCommission=0; $TotalSales=0; $TotalSalesComm=0; $TotalSalesSpiff=0;
// changes for sales commission
	if($Config['SalesCommission']==1 && ($EmpID>0 || $SuppID>0)){		
		$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID,$SuppID);
	
		
if(!empty($arrySalesCommission[0]['CommType'])){
	
	$TargetFrom = $arrySalesCommission[0]["TargetFrom"];
	$TargetTo = $arrySalesCommission[0]["TargetTo"];

	//if($_GET['a']==1){echo $TargetFrom;exit;}

/**Start commission***/
if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesComm=$objSale->GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID);		
		
	}else{
		$arryTotalSalesComm=$objSale->GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID);	
				
	}	


 
	foreach($arryTotalSalesComm as $key_cm=>$values_cm){
		if($values_cm['InvoicePaid']=="Paid" ||  $values_cm['InvoicePaid']=="Part Paid") {
			$TotalSalesComm = $values_cm['TotalSales'];
			$TotalSales += $TotalSalesComm;
			$TotalSalesItemComm = $values_cm['setSpiffamt'];
			if($TargetFrom>=0 && $TotalSalesComm>=$TargetFrom){
				$Percentage = $arrySalesCommission[0]['CommPercentage'];
				 
				$Percentage = (!empty($values_cm['CommPercentage']) ? $values_cm['CommPercentage'] : $Percentage);
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
	
} 
/*********************/	


/***Commision & Spiff*******/	
if($arrySalesCommission[0]['CommType']=="Commision & Spiff"){  

	/*if($arrySalesCommission[0]['SalesPersonType']=="Non Residual"){
		$arryTotalSalesSpiff=$objSale->GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID);		
		
	}else{
		$arryTotalSalesSpiff=$objSale->GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID);	
				
	}*/
	
	
	if($arrySalesCommission[0]['SpiffType']=="one"){
	$oneTime =0;
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);	
	
	}else{
		$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		
	}
	
	
	
#pr($arryTotalSalesSpiff);
	 	
	/*foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
		if($arrySalesCommission[0]["SpiffTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SpiffTarget"]){
			$TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		}
	}*/
	
	
	foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
		$TotalSalesSpiff = $values_sp['TotalSales'];
		//if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
	
	if(empty($TotalSales))$TotalSales += $TotalSalesSpiff;
	
	if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
	   $TotalCommission += $values_sp['TotalItemSales'];
	}else{
		  if($arrySalesCommission[0]["amountType"]=='Percentage'){
		    $TotalCommission += $TotalSalesSpiff*$arrySalesCommission[0]["SpiffEmp"]/100;
		  }else{
		    $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];
		  }
		
	}
	
	}
	
	


} 
/*********************/

/***Spiff Only*******/	

if($arrySalesCommission[0]['CommType']=="Spiff" && empty($arrySalesCommission[0]['SpiffOn'])){   

	//$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);
 
if($arrySalesCommission[0]['SpiffType']=="one"){
	$oneTime =0;
		if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
		$oneTime = 1;
		}
		$arryTotalSalesSpiff=$objSale->GetInvPaymentOneTime($FromDate,$ToDate,$EmpID,$SuppID,$OrderID,$oneTime);	
	
	}else{
		$arryTotalSalesSpiff = $objSale->GetInvoiceSpiff($FromDate,$ToDate,$EmpID,$SuppID,$OrderID);	
		
	}
 
	foreach($arryTotalSalesSpiff as $key_sp=>$values_sp){
	
		$TotalSalesSpiff = $values_sp['TotalSales'];
		
		 $TotalSales += $TotalSalesSpiff;
		 
		 /*if($arrySalesCommission[0]["SpiffTarget"]>0 && $TotalSalesSpiff>=$arrySalesCommission[0]["SpiffTarget"]){
			      $TotalSales += $TotalSalesSpiff;

			      $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];	
		      }*/
		 
		 
	      if($arrySalesCommission[0]['spiffBasedOn']=="Product"){
	            $TotalCommission += $values_sp['TotalItemSales'];
	      }else{
		        if($arrySalesCommission[0]["amountType"]=='Percentage'){
		           $TotalCommission += ($TotalSales*$arrySalesCommission[0]["SpiffEmp"])/100;
		        }else{
		           $TotalCommission += $arrySalesCommission[0]["SpiffEmp"];
		        }
	      }
	  }
} 
/*********************/

//echo $FromDate.','.$ToDate.','.$TotalCommission.'<br>';			


						
		}
	}
?>
