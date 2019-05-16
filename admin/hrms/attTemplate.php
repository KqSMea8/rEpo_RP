<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/employee.class.php");
$objEmployee=new employee();

/*************************/
$_GET['Status']=1;
$arryEmployee=$objEmployee->GetEmployeeList($_GET);
$num=$objEmployee->numRows();
/*************************/

$filename = "AttendanceTemplate_".date('d-m-Y').".xls";
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







	$header = "Employee Code\tEmployee Name";
	for($i=1;$i<=31;$i++){
		$header .= "\t".$i."\t";
	}
	$header .= "\n\t";
	$flag=true;
	for($i=1;$i<=62;$i++){
		$InOut = ($flag)?("IN"):("OUT");
                $flag=!$flag;
		
		$header .= "\t".$InOut;
	}

	$data = '';
	foreach($arryEmployee as $key=>$values){
		

		$JoiningDate = ($values["JoiningDate"]>0)?(date($Config['DateFormat'], strtotime($values["JoiningDate"]))):(""); 

		$line = $values["EmpCode"]."\t".stripslashes($values["UserName"])."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 
	

}else{
	echo "No record found.";
}
exit;
?>

