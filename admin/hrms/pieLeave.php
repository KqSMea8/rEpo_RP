<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");

	$arryLegend = array("Entitlements","Pending Approval" ,"Approved/Taken" ,"Leave Balance");
	$arryValue = array($_GET["e"],$_GET["p"],$_GET["a"],$_GET["b"]);
	
//echo '<pre>';print_r($arryValue);exit;
	
	$arryColor =  array("#d9802c","#e4c625","#5c806b","#c3cc38"); //option1
	
	// class call with the width, height & data
	$pie = new PieGraph(400, 350, $arryValue);

	// colors for the data
	$pie->setColors($arryColor); 


	// legends for the data
	$pie->setLegends($arryLegend);

	// Display creation time of the graph
	//$pie->DisplayCreationTime();

	// Height of the pie 3d effect
	$pie->set3dHeight(20);

	// Display the graph
	$pie->display();
?>
