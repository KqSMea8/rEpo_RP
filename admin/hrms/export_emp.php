<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objEmployee=new employee();

/*************************/
//$arryEmployee=$objEmployee->ListEmployee($_GET);
$arryEmployee=$objEmployee->GetEmployeeDetail();
$num=$objEmployee->numRows();

$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
/*************************/

$filename = "EmployeeList_".date('d-m-Y').".xls";
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

	$header = "Emp Code\tName\tDesignation\tDateofbirth\tEmail\tPersonalEmail\tAddress\tState\tCity\tZip\tMobile\tLandline\tDepartment\tJoiningDate\tStatus";

	$data = '';

/*if($_GET['op']==1){
echo "<pre>";
print_r($arryEmployee);
exit;
}*/




	foreach($arryEmployee as $key=>$values){
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }

		$JoiningDate = ($values["JoiningDate"]>0)?(date($Config['DateFormat'], strtotime($values["JoiningDate"]))):(""); 
$date_of_birth = ($values["date_of_birth"]>0)?(date($Config['DateFormat'], strtotime($values["date_of_birth"]))):("");

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\t".stripslashes($values["JobTitle"])."\t".stripslashes($date_of_birth)."\t".stripslashes($values['Email'])."\t".stripslashes($values['PersonalEmail'])."\t".stripslashes($values['Address'])."\t".stripslashes($values['State'])."\t".stripslashes($values['City'])."\t".stripslashes($values['ZipCode'])."\t".stripslashes($values['Mobile'])."\t".stripslashes($values['LandlineNumber'])."\t".stripslashes($values["Department"])."\t".$JoiningDate."\t".$status."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

