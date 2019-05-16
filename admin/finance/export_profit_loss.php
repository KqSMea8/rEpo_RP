<?php
	include_once("../includes/settings.php");
	include_once("includes/html/box/profit_loss_action.php");

	$fileName = 'ProfitAndLossReport';
	$ExportFile=$fileName."_".date("F_Y", strtotime($FromDate)).".xls";
	include_once("includes/html/box/profit_loss_data.php");
?>
