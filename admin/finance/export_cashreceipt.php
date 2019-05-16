<?php  	
include_once("../includes/settings.php");
require_once($Prefix . "classes/finance.account.class.php");
$objBankAccount = new BankAccount();

/*************************/
$arryCash=$objBankAccount->ListCashReceipt($_GET);
$num=$objBankAccount->numRows();
/*************************/

$filename = "CashReceipt_".date('d-m-Y').".xls";
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

	$header = "Cash Receipt No#\tCash Receipt Date\tGL Posting Date\tPosted By\tTotal Amount [".$Config['Currency']."]";

	$data = '';
	 foreach($arryCash as $key => $values) { 
		
		$PaymentDate = ($values["PaymentDate"] > 0)?(date($Config['DateFormat'], strtotime($values["PaymentDate"]))):('');
		$PostToGLDate = ($values["PostToGLDate"] > 0)?(date($Config['DateFormat'], strtotime($values["PostToGLDate"]))):('');
 

		
		$line = $values["ReceiptID"]."\t".$PaymentDate."\t".$PostToGLDate."\t".$values["PostedBy"]."\t".number_format($values['TotalAmount'],2)."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

