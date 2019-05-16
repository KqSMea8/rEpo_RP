<?php  	
include_once("../includes/settings.php"); 
include_once("includes/html/box/account_history.php");
 
$fileName = "AccountHistory";
$ExportFile=$fileName."_".date('d-m-Y').".xls";
include_once("includes/html/box/account_history_data.php");

?>


