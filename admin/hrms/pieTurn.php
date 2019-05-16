<?php
	require_once("../includes/settings.php");
	require_once($Prefix."classes/employee.class.php");
	require($Prefix."classes/pi.class.php");
	$objEmployee=new employee();
	
	$EmpTotal = 0;
	

	if(!empty($_GET["Year"])){
		$Limit=15;		
		for($i=0;$i<sizeof($arrySubDepartment);$i++) {
			$arryNumEmployee = $objEmployee->GetEmpByYear($arrySubDepartment[$i]['depID'],$_GET["Year"]);
			//$rand = rand(10,100);
			$valuesBar[$arrySubDepartment[$i]['Department']] = $arryNumEmployee[0]['TotalEmployee']+$rand;
			$EmpTotal +=  $arryNumEmployee[0]['TotalEmployee']; 
		}
		
		arsort($valuesBar);
	}else if(!empty($_GET["FromYear"]) && !empty($_GET["ToYear"])){
		$Limit=25;
		$FromYear = $_GET['FromYear'];
		$ToYear = $_GET['ToYear'];

		for($i=$FromYear;$i<=$ToYear;$i++) {
			$arryNumEmployee = $objEmployee->GetEmpByYear('',$i);
			#$rand = rand(10,100);
			$valuesBar[$i] = $arryNumEmployee[0]['TotalEmployee']+$rand;
			$EmpTotal +=  $arryNumEmployee[0]['TotalEmployee']; 
		}

	}

		
	
	
	$Count=0;
	foreach($valuesBar as $key=>$values){					
		$arryLegend[$Count] = $key;
		$arryValue[$Count] = $values;
		//if($values>0){
			$Count++;
		//}
		if($Count==$Limit) break;
	}
//echo '<pre>';	print_r($valuesBar);exit;
	$arryColor = array("#0c65bw","#b4cccc","#d6666c","#d9802c","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d8dc0d","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#c3cc38","#dddddd","#eeeeee");


	
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
