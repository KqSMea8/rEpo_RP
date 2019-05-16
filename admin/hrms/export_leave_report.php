<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/leave.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/hrms.class.php");
include_once("includes/FieldArray.php");
$objLeave=new leave();
$objEmployee=new employee();
$objCommon=new common();
/*************************/

if(!empty($_GET['s'])){
	$Show=1;
	if($_GET['emp']>0){
		$arryLeave = $objCommon->GetAttributeByValue($_GET['ltype'],'LeaveType');
		$num=sizeof($arryLeave);
		$arryEmployee = $objEmployee->GetEmployeeBrief($_GET['emp']);
		$arryLeave = $objCommon->GetAttributeByValue($_GET['ltype'],'LeaveType');
		$filename = "LeaveReportFor_".$arryEmployee[0]["UserName"]."_".date('d-m-Y').".xls";
	}else{
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$num=$objEmployee->numRows();
		$filename = "LeaveReport_".date('d-m-Y').".xls";
	}
}


/*************************/
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


	if($_GET['emp']>0){
		$header = "Leave Type\tEntitlements (Days)\tPending Approval (Days)\tApproved/Taken (Days)\tLeave Balance (Days)";

		$data = '';

		$Line=0;
		$TotalEntitle=0; $TotalPending=0; $TotalApproved=0; $TotalBalance=0;
		foreach($arryLeave as $key=>$values){

			$Line++;
			
			$EntitleDays = $objLeave->getLeaveEntitle($_GET['emp'],$values["attribute_value"]);
			$PendingLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Pending'",$values["attribute_value"]);
			$ApprovedLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Approved','Taken'",$values["attribute_value"]);
			$Balance = 0;
			//if($EntitleDays>0){
				$Balance = $EntitleDays - $ApprovedLeave;
				//if($Balance<=0) $Balance = 0;
			//}


			$line = $values["attribute_value"]."\t".$EntitleDays."\t".$PendingLeave."\t".$ApprovedLeave."\t".$Balance."\n";

			$TotalEntitle += $EntitleDays;
			$TotalPending += $PendingLeave;
			$TotalApproved += $ApprovedLeave;
			$TotalBalance += $Balance;


			$data .= trim($line)."\n";
		}
		/*******************/
		$line = "Total :\t".$TotalEntitle."\t".$TotalPending."\t".$TotalApproved."\t".$TotalBalance."\n";
		$data .= trim($line)."\n";
		/*******************/

		$data = str_replace("\r","",$data);


	/*****************************/
	/*****************************/

	}else{ // Export Leave report for all employees

		$header = "Emp Code\tEmployee Name\tDesignation\tDepartment\tEntitlements (Days)\tPending Approval (Days)\tApproved/Taken (Days)\tLeave Balance (Days)";

		$data = '';
		$Line=0;
		foreach($arryEmployee as $key=>$values){

			$Line++;
			
			$EntitleDays = $objLeave->getLeaveEntitle($values['EmpID'],'');
			$PendingLeave = $objLeave->getLeaveByStatus($values['EmpID'],"'Pending'",'');
			$ApprovedLeave = $objLeave->getLeaveByStatus($values['EmpID'],"'Approved','Taken'",'');
			$Balance = 0;
			//if($EntitleDays>0){
				$Balance = $EntitleDays - $ApprovedLeave;
				//if($Balance<=0) $Balance = 0;
			//}

			$line = $values["EmpCode"]."\t".$values["UserName"]."\t".stripslashes($values['JobTitle'])."\t".stripslashes($values["Department"])."\t".$EntitleDays."\t".$PendingLeave."\t".$ApprovedLeave."\t".$Balance."\n";


			$data .= trim($line)."\n";
		}

		$data = str_replace("\r","",$data);

	}

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

