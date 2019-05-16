<?php  	
$HideNavigation=1;
include_once("../includes/settings.php");
include_once("../includes/permission.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();


/*************************/
$arrySale=$objSale->ListCreditNote($_GET);
$num=$objSale->numRows();

/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
/*************************/

$filename = "Customer_Credit_Memo_".date('d-m-Y').".xls";
if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Posted Date\tCredit Memo ID#\tInvoice ID#\tCustomer\tAmount\tCurrency\tStatus\tApproved";

	$data = '';
	foreach($arrySale as $key=>$values){
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 //$ClosedDate = ($values['ClosedDate']>0)?(date($Config['DateFormat'], strtotime($values['ClosedDate']))):("");
		 $Approved = ($values['Approved']==1)?("Yes"):("No");

		$Status = $objSale->GetCreditStatusMsg($values['Status'],$values['OrderPaid']);
		$Status = strip_tags($Status);

		$line = $PostedDate."\t".$values["CreditID"]."\t".$values["InvoiceID"]."\t".stripslashes($values["CustomerName"])."\t".$values['TotalAmount']."\t".$values['CustomerCurrency']."\t".$Status."\t".$Approved."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

