<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/finance.account.class.php");
        
       (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                
         if (class_exists(BankAccount)) {
                      $objBankAccount=new BankAccount();
              } else {
                      echo "Class Not Found Error !! Bank Account Class Not Found !";
                      exit;
              }
/*************************/
$arryBankAccount=$objBankAccount->getBankAccount($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objBankAccount->numRows();       



$filename = "AccountList_".date('d-m-Y').".xls";
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

	$header = "Account Name\tAccount Type\tAccount Number\tAccountCode\tBalance\tStatus";

	$data = '';
	$Balance = 0;
	foreach($arryBankAccount as $key=>$values){
		 if($values['Status'] == "Yes"){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		 
		$ReceivedAmnt = $values['ReceivedAmnt'];
		$PaidAmnt = $values['PaidAmnt'];
		$Balance = $ReceivedAmnt-$PaidAmnt;

		$line = stripslashes($values["AccountName"])."\t".stripslashes($values["AccountType"])."\t".stripslashes($values["AccountNumber"])."\t".stripslashes($values["AccountCode"])."\t".stripslashes($Balance)."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

