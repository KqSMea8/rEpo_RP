<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/candidate.class.php");
include_once("includes/FieldArray.php");
$objCandidate=new candidate();

/*************************/
$arryVacancy=$objCandidate->ListVacancy($_GET);
$num=$objCandidate->numRows();


$filename = "VacancyList_".date('d-m-Y').".xls";
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

	$SalaryTitle = 'Salary ('.$Config['Currency'].') '.IN_LAKH_ANNUM;

	$header = "Job Title\tVacancy Name\tDepartment\tHiring Manager\tQualification\tSkill\tNumber of Position\tHired\tExperience\tAge\t".$SalaryTitle."\tExceptional Approval\tPosted Date\tStatus";

	$data = '';
	foreach($arryVacancy as $key=>$values){


		$Description = str_replace('"', '""', strip_tags(stripslashes($values["Description"])));
		$Description = str_replace("\n"," ",$Description);
		$Description = str_replace("\t","",$Description);

		$Experience = $values['MinExp'].' To '.$values['MaxExp'];  
		$Age = $values['MinAge'].' To '.$values['MaxAge'];  
		$Salary = $values['MinSalary'].' To '.$values['MaxSalary'];  
		$Exceptional = ($values['Exceptional'] == 1)?('Yes'):('No');
		$PostedDate = date($Config['DateFormat'], strtotime($values['PostedDate']));

		$Qualification = ($values['Qualification']=="Other")?(stripslashes($values['OtherQualification'])):(stripslashes($values['Qualification']));


		$line = stripslashes($values["JobTitle"])."\t".stripslashes($values["Name"])."\t".stripslashes($values["DepartmentName"])."\t".stripslashes($values["UserName"])."\t".$Qualification."\t".stripslashes($values["Skill"])."\t".$values["NumPosition"]."\t".$values['Hired']."\t".$Experience."\t".$Age."\t".$Salary."\t".$Exceptional."\t".$PostedDate."\t".$values['Status']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

