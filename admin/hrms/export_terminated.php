<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objEmployee=new employee();

(empty($_GET['Year']))?($_GET['Year']=""):("");


/*************************/
$arryEmployee=$objEmployee->ListTerminated('',$_GET['Year'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objEmployee->numRows();

$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
/*************************/

$filename = "EmployeeExitReport_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tEmployee Name\tDepartment\tExit Type\tReason\tFull & Final\tJoining Date\tResignation Date";

	$data = '';
	foreach($arryEmployee as $key=>$values){

		$JoiningDate = ($values["JoiningDate"]>0)?(date($Config['DateFormat'], strtotime($values["JoiningDate"]))):(""); 
		$ExitDate = ($values["ExitDate"]>0)?(date($Config['DateFormat'], strtotime($values["ExitDate"]))):(""); 

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["Department"])."\t".stripslashes($values['ExitType'])."\t".stripslashes($values['ExitReason'])."\t".stripslashes($values["FullFinal"])."\t".$JoiningDate."\t".$ExitDate."\n";  

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

