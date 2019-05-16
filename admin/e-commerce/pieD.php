<?php 
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/orders.class.php");
	$objOrder = new orders();
	
		$PriceTotal = 0;
		$today = date("d");
		$maxDays=date('t');
        $currentYear = date("Y");
        $currentMonth = date("m");
        global $Config;
//$Config['DisplayLabel'] = 'Sales in '.$Config['Currency'];

		for($i=1;$i<=$today;$i++) {
			$datestring = $currentYear.'-'.$currentMonth.'-'.$i;
			$totalOrderAmnt = $objOrder->getOrderAmountByDate($datestring);
 
			 
			$PriceTotal +=  $totalOrderAmnt; 

			$arryLegend[] = $i;

			 
			$arryValue[] = $totalOrderAmnt;
			 
						


		}
	

//echo '<pre>';print_r($arryValue);exit;
        
     

	$arryColor = array("#0c65bw","#b4cccc","#d6666c","#d8dc0d","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d9802c ","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#0c65bw","#dddddd","#eeeeee","#00e600","#00ffcc","#ff1aff",'#ffb3b3','#ccccff','#392613','#33331a','#003300','#80002a'

);

	// class call with the width, height & data
	//$pie = new PieGraph(200, 180, $arryValue); close by abbas
	$pie = new PieGraph(450, 180, $arryValue);

	// colors for the data
	$pie->setColors($arryColor); 


	// legends for the data
	$pie->setLegends($arryLegend);

	// Display creation time of the graph
	//$pie->DisplayCreationTime();

	// Height of the pie 3d effect
	$pie->set3dHeight(8);

	// Display the graph
	$pie->display();	

?>
