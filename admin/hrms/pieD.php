<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/employee.class.php");

	$objEmployee=new employee();
	$Limit=12;
	for($i=0;$i<sizeof($arrySubDepartment);$i++) {
		$arryNumEmployee = $objEmployee->GetNumEmployee($arrySubDepartment[$i]['depID']);		
		$valuesBar[$arrySubDepartment[$i]['Department']] = $arryNumEmployee[0]['TotalEmployee'];
	}

	 
	arsort($valuesBar);
	
	$Count=0;
	foreach($valuesBar as $key=>$values){					
		$arryLegend[$Count] = $key;
		$arryValue[$Count] = $values;
		if($values>0){
			$Count++;
		}
		if($Count==$Limit) break;
	}


	$arryColor = array("#c3cc38","#b4cccc","#d6666c","#d9802c","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d8dc0d","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#0c65bw","#dddddd","#eeeeee"

);

	// class call with the width, height & data
	$pie = new PieGraph(160, 140, $arryValue);

	// colors for the data
	$pie->setColors($arryColor); 


	// legends for the data
	$pie->setLegends($arryLegend);

	// Display creation time of the graph
	//$pie->DisplayCreationTime();

	// Height of the pie 3d effect
	$pie->set3dHeight(12);

	// Display the graph
	$pie->display();
?>
