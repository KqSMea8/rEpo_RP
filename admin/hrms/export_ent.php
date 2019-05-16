<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/leave.class.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objLeave=new leave();
$objEmployee=new employee();

/*************************/
$arryEntitlement=$objLeave->ListEntitlement($_GET);
$num=sizeof($arryEntitlement);
/*************************/

$filename = "EntitlementList_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee Name\tDepartment\tJob Type\tLeave Type\tDays";
	//$header = "Emp Code\tEmployee Name\tDepartment\tJob Type\tLeave Type\tValid From\tValid To\tDays";

	$data = '';
	foreach($arryEntitlement as $key=>$values){

		$LeaveStart = ($values["LeaveStart"]>0)?(date($Config['DateFormat'], strtotime($values["LeaveStart"]))):(""); 
		$LeaveEnd = ($values["LeaveEnd"]>0)?(date($Config['DateFormat'], strtotime($values["LeaveEnd"]))):(""); 

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values['Department'])."\t".stripslashes($values["JobType"])."\t".stripslashes($values["LeaveType"])."\t".$values["Days"]."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

