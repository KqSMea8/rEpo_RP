<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/crm.class.php");
	$objLead=new lead();
	$objCommon=new common();

	$arryAttribute = $objCommon->GetCrmAttribute('Priority','');
	for($i=0;$i<sizeof($arryAttribute);$i++) {		
		$arryNumVal = $objLead->GetNumTicket($arryAttribute[$i]['attribute_value']);		
		$arryLegend[$i] = $arryAttribute[$i]['attribute_value'];
		$arryValue[$i] = $arryNumVal[0]['TotalTicket'];
	}



	// class call with the width, height & data
	$pie = new PieGraph(230, 200, $arryValue);

	// colors for the data
	//$pie->setColors(array("#e4c625","#c3cc38","#d6666c","#d9802c","#5c806b")); //option1
	//$pie->setColors(array("#9bb752","#e4c625","#de5958","#519e9a","#945f88")); //option2
	$pie->setColors(array("#d8dc0d","#5c806b","#425457","#2d1f3f","#0c465b")); //option3

	// legends for the data
	$pie->setLegends($arryLegend);

	// Display creation time of the graph
	//$pie->DisplayCreationTime();

	// Height of the pie 3d effect
	$pie->set3dHeight(20);

	// Display the graph
	$pie->display();
?>
