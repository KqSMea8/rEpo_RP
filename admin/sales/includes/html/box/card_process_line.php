<?
/****Credit Card Process for Line Item********/
if($_POST['PaymentTerm']=='Credit Card' && $_POST['TransactionAmount']>0 && $_POST['TotalAmount']>0 && $_POST['TotalAmount']!=$_POST['TransactionAmount'] && $_POST['ChargeRefund']=='1'){
	$TransactionDiff = $_POST['TotalAmount'] - $_POST['TransactionAmount'];
	$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($order_id,'Charge',$_POST['PaymentTerm']);
	$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];	
	if(!empty($ProviderID)){
		if($TransactionDiff>0){
			$objCard->ProcessSaleCreditCard($order_id,$ProviderID,$TransactionDiff);	
		}else{
			$TransactionDiff = -$TransactionDiff;
			$objCard->VoidSaleCreditCard($order_id,$TransactionDiff);	
		}						

		$RedirectURL = $EditUrl;
		if(!empty($_SESSION['mess_error_sale'])){
			$_SESSION['mess_Sale'] = $_SESSION['mess_error_sale'];
			unset($_SESSION['mess_error_sale']);
			header("Location:".$RedirectURL);
			exit;
		}

	}
}
/************************************************/
?>
