<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/reseller.class.php");			
$objSale = new sale();
$objReseller=new reseller();


/*************************/
if(!empty($_GET['m']) && !empty($_GET['y'])){		
	$FromDate = $_GET['y']."-".$_GET['m']."-01";
	$NumDayMonth = date('t', strtotime($FromDate));
	$ToDate = $_GET['y']."-".$_GET['m']."-".$NumDayMonth;
}else if(!empty($_GET['y'])){
	$FromDate = $_GET['y']."-01-01";		
	$ToDate = $_GET['y']."-12-31";
}

if(!empty($_GET['sb'])){	
	$arryPayment=$objReseller->SalesCommReport($FromDate,$ToDate,$_GET['s']);
	$num=$objReseller->numRows();
}

/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
$arryReseller = $objReseller->GetResellerWithComm('',1);
for($i=0;$i<sizeof($arryReseller);$i++) {
	$RsID = $arryReseller[$i]['RsID'];
	$ResellerDataArry[$RsID]['FullName']=stripslashes($arryReseller[$i]['FullName']);
	$ResellerDataArry[$RsID]['CommOn']=stripslashes($arryReseller[$i]['CommOn']);
	$arrySalesCommReseller[$RsID] = $objReseller->GetSalesCommission($RsID);
}
/*************************/

$filename = "Reseller_SalesCommissionReport_".date('d-m-Y').".xls";
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

	$header = "Reseller Name\tCommission on Sales Amount [".$Config['Currency']."]\tSales Commission [".$Config['Currency']."]";

	$data = '';
	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	foreach($arryPayment as $key=>$values){
		$RsID = $values['RsID'];
		if($ResellerDataArry[$RsID]['CommOn']==1){
			include("../includes/html/box/commission_rscal_per.php");
		}else{
			include("../includes/html/box/commission_rscal.php");
		}
		$line = stripslashes($ResellerDataArry[$RsID]['FullName'])."\t".number_format($TotalSales,2,'.',',')."\t".number_format($TotalCommission,2,'.',',')."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

