<?php
	include_once("../includes/settings.php");
	include_once("includes/html/box/trial_balance_action.php");

	$fileName = 'TrialBalanceReport';
	$ExportFile=$fileName."_".date("F_Y", strtotime($FromDate)).".xls";
	include_once("includes/html/box/trial_balance_data.php");
?>
