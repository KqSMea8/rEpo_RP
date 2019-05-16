<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/employee.class.php");		
$objSale = new sale();
$objEmployee=new employee();


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
	$arryPayment=$objSale->SalesCommissionReport($FromDate,$ToDate,$_GET['s'],$_GET['sp']);
	$num=$objSale->numRows();
 
}

 
/*************************/

$filename = "SalesCommissionReport_".date('d-m-Y').".xls";
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

	$header = "Sales Person\tCommission on Sales Amount [".$Config['Currency']."]\tSales Commission [".$Config['Currency']."]";

	$data = '';
	$EmpDivision = 5;
	foreach($arryPayment as $key=>$values){		 

		if($_GET['sp']=='1') {
			$SuppID = $values['SalesPersonID'];			 
		}else {
			$EmpID = $values['SalesPersonID'];
			 
		}
 

		if($values['CommOn']==1){
			include("../includes/html/box/commission_cal_per.php");
		}else if($values['CommOn']==2){
			include("../includes/html/box/commission_cal_margin.php");
		}else{
			include("../includes/html/box/commission_cal.php");
		}
		//modified by nisha 
		$TotalSales = number_format($TotalSales,2,'.',',');
		$TotalSales =  '"' . str_replace('"', '""', $TotalSales) . '" ';
		$TotalCommission = number_format($TotalCommission,2,'.',',');
		$TotalCommission =  '"' . str_replace('"', '""', $TotalCommission) . '" ';
		$line = stripslashes($values["SalesPerson"])."\t".$TotalSales."\t".$TotalCommission."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

