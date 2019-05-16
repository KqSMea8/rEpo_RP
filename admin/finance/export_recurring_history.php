<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
$objCustomer = new Customer();	 
 
if(!empty($_GET['Parent'])){   	 
	$arrySale=$objCustomer->ListRecurringHistory($_GET);
	$num=sizeof($arrySale);	 	
}


$fileName = 'TransactionSummary_'.$arrySale[0]['InvoiceID'];

$ExportFile=$fileName."_".date('d-m-Y').".xls";

include_once("includes/html/box/recurring_history_data.php");
?>
