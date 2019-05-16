<?
 /*******Credit Card Process**********/
if(!empty($_GET['OrderID']) && !empty($_GET['Amnt']) && $_GET['Action']=='PCard'){ 
	$OrderID = base64_decode($_GET['OrderID']);			
	$Amnt = base64_decode($_GET['Amnt']);
	$Config['SalesInvoiceExtraCharge'] = $_GET['ExtraCharge'];		 
	$objCard->ProcessSaleCreditCard($OrderID,'',$Amnt);
	if(!empty($_SESSION['mess_Sale'])){
		$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']);			
	}
	$EditUrl = "editInvoice.php?edit=".$OrderID."&curP=".$_GET["curP"]; 		
	header("Location:".$EditUrl);
	exit;
}else if(!empty($_GET['OrderID']) && !empty($_GET['Amnt'])  && $_GET['Action']=='VCard'){
	$OrderID = base64_decode($_GET['OrderID']);			
	$Amnt = base64_decode($_GET['Amnt']);
	//$Config['SalesInvoiceExtraCharge'] = $_GET['ExtraCharge'];			 
	$objCard->VoidSaleCreditCard($OrderID,$Amnt);		
	if(!empty($_SESSION['mess_Sale'])){
		$_SESSION['mess_Invoice'] = $_SESSION['mess_Sale'];
		unset($_SESSION['mess_Sale']);			
	}
	$EditUrl = "editInvoice.php?edit=".$OrderID."&curP=".$_GET["curP"]; 	
	header("Location:".$EditUrl);
	exit;
}
/*************************************/
?>
