<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();
	$objEmployee=new employee();
	
	$OrderTotal = 0;
	$FYear = date("Y") - 10;
	$_GET["t"] = date("Y-m-d"); 
	$_GET["f"] = date("01-01-".$FYear);

	$_GET['module']="Order";
	(empty($_GET['s']))?($_GET['s']=""):(""); 
	(empty($_GET['st']))?($_GET['st']=""):(""); 


	if(!empty($_GET["f"]) && !empty($_GET["t"])){	
		$FromYear = date("Y",strtotime($_GET['f']));
		$ToYear = date("Y",strtotime($_GET['t']));
	
		$module = $_GET['module'];
		$ModuleName = "Purchase ".$_GET['module'];

		for($i=$FromYear;$i<=$ToYear;$i++) {
			$arryNumOrder = $objPurchase->GetNumPOByYear($i,$_GET['f'],$_GET['t'],$_GET['s'],$_GET['st']);
			
			$valuesBar[$i] = $arryNumOrder[0]['TotalOrder'];
			$OrderTotal +=  $arryNumOrder[0]['TotalOrder']; 

			$arryLegend[] = $i;
			$arryValue[] = $arryNumOrder[0]['TotalOrder'];

		}

	}else{
		exit;
	}


	


	$arryColor = array("#0c65bw","#b4cccc","#d6666c","#d8dc0d","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d9802c ","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#0c65bw","#dddddd","#eeeeee"

);

	// class call with the width, height & data
	$pie = new PieGraph(200, 180, $arryValue);

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
