<?php
$HideNavigation = 1;  $EditPage = 1;
 
include_once("includes/settings.php");
require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix."classes/card.class.php");
require_once($Prefix."classes/paypal.invoice.class.php");
$objSale = new sale();
$objCard = new card();
$objpaypalInvoice=new paypalInvoice();
 $rowstatus="";
 $ErrorMSG="";
 $Status=0; // 0 for error , 1 for nothing doing, 2 for done , 
 $paidstatus=0;
if(!empty($_POST['OrderId'])) {
$OrderID = (int)$_POST['OrderId']; 
$module = (int)$_POST['module']; 

$PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);
$module = $_GET['module'];
$paypalUsername=$PaymentProviderData[0]['paypalID'];
$PaypalToken=$PaymentProviderData[0]['PaypalToken'];


/*$arrySale = $objSale->GetSale($OrderID,'',$module);

$invoiceid=$arrySale[0]['paypalInvoiceId'];
$orderDetail=array();
$orderDetail=$arrySale[0];
$sendarray=array();
$sendarray['PayPalTransactionID']=$arrySale[0]['PayPalTransactionID'];*/
$refreshOrderID=$OrderID;
require($Prefix."admin/includes/html/box/savePaypalTransaction.php");
	$arrySale = $objSale->GetSale($OrderID,'',$module);

					$OrderStatus = $objSale->GetOrderStatusMsg($arrySale[0]['Status'],$arrySale[0]['Approved'],$arrySale[0]['PaymentTerm'],$arrySale[0]['OrderPaid']);
					 $rowstatus=$OrderStatus;
 					$paidstatus=$arrySale[0]['OrderPaid'];

		 if($processresponce['status']==2){
		 	  $ErrorMSG = "";
     		  $Status=2;				     		  
		 }else if($processresponce['status']==1){
			  $ErrorMSG = "";
     		  $Status=1;
		 }else{
		 	 $ErrorMSG = NOT_EXIST_DATA;
     		 $Status=0;
		 }
	 
} else {
    $ErrorMSG = NOT_EXIST_DATA;
     $Status=0;
}
 
 
$MsgArray['Status'] = $Status;
$MsgArray['MSG'] = $MSG;
$MsgArray['ErrorMSG'] = $ErrorMSG;
$MsgArray['rowstatus'] = $rowstatus;
$MsgArray['paidstatus'] = $paidstatus; 

echo json_encode($MsgArray);exit;

 
 
?>


