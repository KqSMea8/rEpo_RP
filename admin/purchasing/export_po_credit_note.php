<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/purchase.class.php");
$objPurchase = new purchase();


/*************************/
$arryPurchase=$objPurchase->ListCreditNote($_GET);
$num=$objPurchase->numRows();

/*$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");
/*************************/

$filename = "Purchase_Credit_Note_".date('d-m-Y').".xls";
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

	$header = "Posted Date\tCredit Note ID\tExpiry Date\tVendor\tAmount\tCurrency\tStatus\tApproved";

	$data = '';
	foreach($arryPurchase as $key=>$values){
		 $PostedDate = ($values['PostedDate']>0)?(date($Config['DateFormat'], strtotime($values['PostedDate']))):("");
		 $ClosedDate = ($values['ClosedDate']>0)?(date($Config['DateFormat'], strtotime($values['ClosedDate']))):("");
		 $Approved = ($values['Approved']==1)?("Yes"):("No");

		$line = $PostedDate."\t".$values["CreditID"]."\t".$ClosedDate."\t".stripslashes($values["SuppCompany"])."\t".$values['TotalAmount']."\t".$values['Currency']."\t".stripslashes($values["Status"])."\t".$Approved."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

