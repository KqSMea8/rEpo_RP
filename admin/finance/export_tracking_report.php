<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/warehousing.class.php"); 	
$objCommon = new common();       

if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}

/***************/
$arryData=$objCommon->TrackingReport($_GET);
$num=$objCommon->numRows();	
/***************/

$fileName = 'TrackingReport';

$ExportFile = $fileName."_".date('d-m-Y').".xls";

include_once("includes/html/box/tracking_report_data.php");
?>
