<?php
	include_once("../includes/settings.php");
	include_once("includes/html/box/balance_sheet_action.php");

	$fileName = 'BalanceSheetReport';
	$ExportFile=$fileName."_".date("F_Y", strtotime($FromDate)).".xls";
	include_once("includes/html/box/balance_sheet_data.php");
?>
