<?php
	require_once("../includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/lead.class.php");
	$objLead=new lead();
	
	$OrderTotal = 0;


	if((!empty($_GET['f']) && !empty($_GET['t'])) || !empty($_GET['y']) || !empty($_GET['fby'])){
		
		//$module = $_GET['module'];
		 $ModuleName = "Lead";

		if($_GET['fby']=="Year"){
			$BotTextHeight = 20;
			for($i=1;$i<=12;$i++) {
				$mon = $i; if($mon<10) $mon = '0'.$i;
				$from = $_GET['y'].'-'.$mon.'-01';
				$to = $_GET['y'].'-'.$mon.'-31';
				//$month = $_GET['m'];
				$MonthName = date("F",strtotime($from));
				$arryNumAdj = $objLead->GetNumLeadByYear($_GET['fby'],$_GET['m'],$_GET['y'],$from,$to,$_GET['w'],$_GET['lso'],$_GET['lst']);
				
				$valuesBar[$MonthName] = $arryNumAdj[0]['TotalLead'];
				$OrderTotal +=  $arryNumAdj[0]['TotalLead']; 

				$arryLegend[] = $MonthName;
				$arryValue[] = $arryNumAdj[0]['TotalLead'];


			}

       /* }else if($_GET['fby']=="Month"){
			
			$BotTextHeight = 20;
			if(!empty($_GET['y']) && !empty($_GET['m'])){
			 $d=cal_days_in_month(CAL_GREGORIAN,$_GET['m'],$_GET['y']);
			}else{
			 $d = 31;
			}
			
			for($i=1;$i<=$d;$i++) {
				$from = $_GET['y'].'-'.$_GET['m'].'-01';
				$dday = $i; if($dday<10) $dday = '0'.$i;
				$to = $_GET['y'].'-'.$_GET['m'].'-'.$dday;
				$from = 2014-03-01;
				$to = 2014-03-31;
				
				$arryNumAdj = $objItem->GetNumAdjByMonth($_GET['y'],$from,$to,$_GET['w'],$_GET['ast']);
				
				$valuesBar[$i] = $arryNumAdj[0]['TotalAdj'];
				$OrderTotal +=  $arryNumAdj[0]['TotalAdj']; 
			}*/
		}else{

			$_GET['f'] = DefaultDateFormat($_GET['f']);
			$_GET['t'] = DefaultDateFormat($_GET['t']);



			$BotTextHeight = 40;
			$FromYear = date("Y",strtotime($_GET['f']));
			$ToYear = date("Y",strtotime($_GET['t']));
			for($i=$FromYear;$i<=$ToYear;$i++) {
				$arryNumAdj = $objLead->GetNumLeadByYear('',$_GET['m'],$i,$_GET['f'],$_GET['t'],$_GET['w'],$_GET['lso'],$_GET['lst']);
			
				#$rand = rand(10,100);
				$valuesBar[$i] = $arryNumAdj[0]['TotalLead']+$rand;
				$OrderTotal +=  $arryNumAdj[0]['TotalLead']; 

				$arryLegend[] = $i;
				$arryValue[] = $arryNumAdj[0]['TotalLead'];


			}		
		}

	

	}else{
		exit;
	}



	
//echo '<pre>';		print_r($arryLegend);	print_r($arryValue);	exit;
 			

	
	$arryColor = array("#0c65bw","#b4cccc","#d6666c","#d8dc0d","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d9802c ","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#0c65bw","#dddddd","#eeeeee"
,"#aaaeee","#0000ff","#00aaaa","#aa00ee","#bbccdd","#fdfdfd","#f9f1f1","#a1a1f5","#f5a5f6"
);
	
	if(empty($ChartWidth)) $ChartWidth = 400;
	if(empty($ChartHeight)) $ChartHeight = 350;

	// class call with the width, height & data
	$pie = new PieGraph($ChartWidth, $ChartHeight, $arryValue);

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
