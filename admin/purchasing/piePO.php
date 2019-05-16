<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();
	
	$OrderTotal = 0;


	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){
		
		$module = $_GET['module'];
		$ModuleName = "Purchase ".$_GET['module'];

		if($_GET['fby']=="Year"){
			
			for($i=1;$i<=12;$i++) {
				$mon = $i; if($mon<10) $mon = '0'.$i;
				$from = $_GET['y'].'-'.$mon.'-01';
				$to = $_GET['y'].'-'.$mon.'-31';
				$MonthName = date("F",strtotime($from));
				$arryNumOrder = $objPurchase->GetNumPOByYear($_GET['y'],$from,$to,$_GET['s'],$_GET['st']);
				$valuesBar[$MonthName] = $arryNumOrder[0]['TotalOrder'];
				$OrderTotal +=  $arryNumOrder[0]['TotalOrder']; 


				$arryLegend[] = $MonthName;
				$arryValue[] = $arryNumOrder[0]['TotalOrder'];
			}
		}else{
			
			$FromYear = date("Y",strtotime($_GET['f']));
			$ToYear = date("Y",strtotime($_GET['t']));
			for($i=$FromYear;$i<=$ToYear;$i++) {
				$arryNumOrder = $objPurchase->GetNumPOByYear($i,$_GET['f'],$_GET['t'],$_GET['s'],$_GET['st']);
				#$rand = rand(10,100);
				$valuesBar[$i] = $arryNumOrder[0]['TotalOrder']+$rand;
				$OrderTotal +=  $arryNumOrder[0]['TotalOrder']; 

				$arryLegend[] = $i;
				$arryValue[] = $arryNumOrder[0]['TotalOrder'];

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
