<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/candidate.class.php");
include_once("includes/FieldArray.php");
$objCandidate=new candidate();

$module = $_GET['module'];
if($module=="Manage") $module='';
/*************************/
$arryCandidate=$objCandidate->ListCandidate($_GET);
$num=$objCandidate->numRows();
/*
$pagerLink=$objPager->getPager($arryCandidate,$RecordsPerPage,$_GET['curP']);
(count($arryCandidate)>0)?($arryCandidate=$objPager->getPageRecords()):("");
/*************************/

$filename = $module."Candidates_".date('d-m-Y').".xls";
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

	$header = "Candidate Name\tEmail\tContact Number\tVacancy";

	if($module=="Offered"){
		$header .= "\tJoining Date";
	}else{
		$header .= "\tInterview Status";
	}

	$data = '';
	foreach($arryCandidate as $key=>$values){
		

		$line = stripslashes($values["UserName"])."\t".stripslashes($values['Email'])."\t".stripslashes($values["Mobile"])."\t".$values["Vacancy"];

		if($module=="Offered"){
			$line .= "\t".date($Config['DateFormat'], strtotime($values['JoiningDate']));
		}else{
			$line .= "\t".$values['InterviewStatus'];
		}


		$data .= "\n".trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

