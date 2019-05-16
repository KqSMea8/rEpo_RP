<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/leave.class.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objLeave=new leave();
$objEmployee=new employee();

/*************************/
$arryLeave=$objLeave->ListLeave($_GET);
$num=sizeof($arryLeave);

/*
$pagerLink=$objPager->getPager($arryLeave,$RecordsPerPage,$_GET['curP']);
(count($arryLeave)>0)?($arryLeave=$objPager->getPageRecords()):("");
/*************************/

$filename = "LeaveList_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee Name\tDepartment\tLeave Type\tFrom Date\tTo Date\tDays\tComment\tApplied On\tStatus";

	$data = '';
	foreach($arryLeave as $key=>$values){

		$FromDate = ($values["FromDate"]>0)?(date($Config['DateFormat'], strtotime($values["FromDate"]))):(""); 
		$ToDate = ($values["ToDate"]>0)?(date($Config['DateFormat'], strtotime($values["ToDate"]))):(""); 

		$ApplyDate = ($values["ApplyDate"]>0)?(date($Config['DateFormat'], strtotime($values["ApplyDate"]))):(""); 


		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values['Department'])."\t".stripslashes($values["LeaveType"])."\t".$FromDate."\t".$ToDate."\t".$values["Days"]."\t".stripslashes($values["Comment"])."\t".$ApplyDate."\t".$values["Status"]."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

