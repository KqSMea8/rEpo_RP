<?php 
/**************************************************/
$ThisPageName = 'viewReportRule.php';$EditPage = 1; 
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/report.rule.class.php");

$_GET['type']='hrms';

include_once("includes/FieldArray.php");
$RedirectURL = "viewReportRule.php";
$objReport = new report();

function multiexplode ($delimiters,$string) {
    $ary = explode($delimiters[0],$string);
    array_shift($delimiters);
    if($delimiters != NULL) {
        foreach($ary as $key => $val) {
             $ary[$key] = multiexplode($delimiters, $val);
        }
    }
    return  $ary;
}


 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_report'] = REPORT_REMOVED;
		$objReport->RemoveReport($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_report'] = REPORT_STATUS_CHANGED;
		$objReport->changeReportStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}



	if($_POST){
		CleanPost();
	 foreach($_POST['columnTo'] as $formvalue){
	 $reportColumn .= $formvalue.',';
		$valArry = explode(":", $formvalue);
		$title = $valArry[0];
		$val = $valArry[1];
		
	}

            $reportColumn = rtrim($reportColumn, ",");
	    $_POST['ReportRule'] = $reportColumn;
 
	if(!empty($_POST['reportID'])){
           $objReport->UpdateReportRule($_POST);
            $_SESSION['mess_report'] = REPORT_UPDATED;
	}else{

	   
	    $objReport->AddReportRule($_POST);
            $_SESSION['mess_report'] = REPORT_ADDED;

	}
	    
	    header('location:'.$RedirectURL);    
	    exit;
	    
	}

if(!empty($_GET['edit'])){
$arrayReport = $objReport->GetReportRule($_GET['edit']);

$delimiters = Array(",",":");

$res = multiexplode($delimiters,$arrayReport[0]['ReportRule']);

$ReportRule = explode(",",$arrayReport[0]['ReportRule']);

$arrayRep = in_array($ReportRule,$column);

#echo $arrayRep;
//if(in_array($ReportRule,$column)){


}

if ($arrayReport[0]['Status'] != '') {
    $ReportStatus = $arrayReport[0]['Status'];
} else {
    $ReportStatus = 1;
}


if ($arrayReport[0]['BreakCheck'] != '') {
    $BreakStatus = $arrayReport[0]['BreakCheck'];
} else {
    $BreakStatus = "NO";
}

if ($arrayReport[0]['DurationCheck'] != '') {
    $DurationStatus = $arrayReport[0]['DurationCheck'];
} else {
    $DurationStatus = "NO";
}

if ($arrayReport[0]['DurationFormat'] != '') {
    $ReportDurationFormat = $arrayReport[0]['DurationFormat'];
} else {
    $ReportDurationFormat = 0;
}


$PunchCheck = $arrayReport[0]['PunchCheck'];


require_once("../includes/footer.php"); 
?>

