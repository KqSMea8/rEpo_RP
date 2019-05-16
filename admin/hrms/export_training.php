<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/training.class.php");
include_once("includes/FieldArray.php");
$objTraining=new training();

/*************************/
$arryTraining=$objTraining->ListTraining($_GET);
$num=$objTraining->numRows();

$pagerLink=$objPager->getPager($arryTraining,$RecordsPerPage,$_GET['curP']);
(count($arryTraining)>0)?($arryTraining=$objPager->getPageRecords()):("");
/*************************/

$filename = "Training_".date('d-m-Y').".xls";
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

	$header = "Training ID\tCourse Name\tCompany\tCoordinator\tTraining Date\tStatus";
	$data = '';
	foreach($arryTraining as $key=>$values){

		$trainingDate =($values['trainingDate']>0)?(date($Config['DateFormat'], strtotime($values['trainingDate']))):(''); 
		$Status =($values['Status']>0)?('Active'):('InActive'); 

		$line = $values["trainingID"]."\t".stripslashes($values["CourseName"])."\t".stripslashes($values["Company"])."\t".stripslashes($values['CoordinatorName'])."\t".$trainingDate."\t".$Status;


		$data .= "\n".trim($line);
	}

	$data = str_replace("\r","",$data);

	print "$header\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

