<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/candidate.class.php");
include_once("includes/FieldArray.php");
$objCandidate=new candidate();

/*************************/
$arryVacancy=$objCandidate->GetVacancy('','');
$num=$objCandidate->numRows();

/*
$pagerLink=$objPager->getPager($arryVacancy,$RecordsPerPage,$_GET['curP']);
(count($arryVacancy)>0)?($arryVacancy=$objPager->getPageRecords()):("");
*/
/*************************/

$filename = "VacancyReport_".date('d-m-Y').".xls";
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



	$header = "Vacancy Name\tJob Title\tPosted Date\tNo of Position\tNo of Applicant\tShortlisted\tOffered\tHired";

	$data = '';
	foreach($arryVacancy as $key=>$values){
		$PostedDate = ($values["PostedDate"]>0)?(date($Config['DateFormat'], strtotime($values["PostedDate"]))):('');

		$NumApplicant = $objCandidate->GetNumCandidate('',$values['vacancyID']);
		$NumShortlisted = $objCandidate->GetNumCandidate('Shortlisted',$values['vacancyID']);
		$NumOffered = $objCandidate->GetNumCandidate('Offered',$values['vacancyID']);

		$line = stripslashes($values["Name"])."\t".stripslashes($values["JobTitle"])."\t".$PostedDate."\t".$values["NumPosition"]."\t".$NumApplicant."\t".$NumShortlisted."\t".$NumOffered."\t".$values['Hired']."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

