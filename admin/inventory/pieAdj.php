<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/item.class.php");
	$objItem = new items();
	
	$OrderTotal = 0;


	
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){
		
		$module = "Adjustment";
		$ModuleName = "Adjustment ";

		if($_GET['fby']=="Year"){
			$BotTextHeight = 20;
			for($i=1;$i<=12;$i++) {
				$mon = $i; if($mon<10) $mon = '0'.$i;
				$from = $_GET['y'].'-'.$mon.'-01';
				$to = $_GET['y'].'-'.$mon.'-31';
				$MonthName = date("F",strtotime($from));
				$arryNumAdj = $objItem->GetNumAdjByYear($_GET['fby'],$_GET['m'],$_GET['y'],$from,$to,$_GET['w'],$_GET['ast']);
				$valuesBar[$MonthName] = $arryNumAdj[0]['TotalAdj'];
				$OrderTotal +=  $arryNumAdj[0]['TotalAdj'];


				$arryLegend[] = $MonthName;
				$arryValue[] = $arryNumAdj[0]['TotalAdj']; 
			}
		}else{
			$BotTextHeight = 40;
			$FromYear = date("Y",strtotime($_GET['f']));
			$ToYear = date("Y",strtotime($_GET['t']));
			for($i=$FromYear;$i<=$ToYear;$i++) {
				$arryNumAdj = $objItem->GetNumAdjByYear('',$_GET['m'],$i,$_GET['f'],$_GET['t'],$_GET['w'],$_GET['ast']);
				#$rand = rand(10,100);
				$valuesBar[$i] = $arryNumAdj[0]['TotalAdj']+$rand;
				$OrderTotal +=  $arryNumAdj[0]['TotalAdj']; 


				$arryLegend[] = $i;
				$arryValue[] = $arryNumAdj[0]['TotalAdj'];
			}		
		}

		



	}else{
		exit;
	}

	
	//echo '<pre>';		print_r($arryLegend);	print_r($arryValue);	exit;
 			

	
	$arryColor = array("#0c65bw","#b4cccc","#d6666c","#d8dc0d","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d9802c ","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#0c65bw","#dddddd","#eeeeee"

);
	
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
