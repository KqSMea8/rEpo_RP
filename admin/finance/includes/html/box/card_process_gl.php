<?
/**********Credit Card Start*******************/
if($_POST['PaymentTerm']=='Credit Card' && $_POST['TransactionAmount']>0 && $_POST['Amount']>0 && $_POST['Amount']!=$_POST['TransactionAmount'] && $_POST['ChargeRefund']=='1'){
	$TransactionDiff = $_POST['Amount'] - $_POST['TransactionAmount'];
	
	$arrySalesCardTransaction = $objCard->GetLastSalesTransaction($OrderID,'Charge',$_POST['PaymentTerm']);
	$ProviderID = $arrySalesCardTransaction[0]['ProviderID'];	
	if(!empty($ProviderID)){
		if($TransactionDiff>0){
			$objCard->ProcessSaleCreditCard($OrderID,$ProviderID,$TransactionDiff);	
		}else{
			$TransactionDiff = -$TransactionDiff;
			$objCard->VoidSaleCreditCard($OrderID,$TransactionDiff);	
		}						

		$RedirectURL = $EditUrl; 
		if(!empty($_SESSION['mess_Sale'])){
			$_SESSION['mess_Invoice'] .= '<br>'.$_SESSION['mess_Sale'];
			unset($_SESSION['mess_Sale']);
			header("Location:".$RedirectURL);
			exit;
		}

		

	}
}
/**********Credit Card End*******************/
?>
