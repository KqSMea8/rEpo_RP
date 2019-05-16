<?php
	require_once("includes/settings.php");
	require($Prefix."classes/pi.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objSale = new sale();
	$objEmployee = new employee();

	$ModuleName = "Sales Commission Report";
	if(empty($_GET['y']))$_GET['y'] = date("Y");
	$Config['DisplayLabel'] = 'Currency: '.$Config['Currency']; 
	if($_SESSION['AdminType'] == "admin"){
		$EmpID = $_GET["empId"];
	}else{
		$EmpID = $_SESSION["AdminID"];
	}

if(!empty($_GET['salesPerson'])) {
    $salesPerson = $_GET['salesPerson'];
 }
if(!empty($_GET['SuppID'])) {
    $SuppID = $_GET['SuppID'];
 }

if($EmpID>0 || $SuppID>0){
		 $EmpDivision = 5;
		$SumCommission = 0;
		$arryEmp = $objEmployee->GetEmployeeBrief($EmpID,$SuppID);
		for($i=1;$i<=12;$i++) {
			$mon = $i; if($mon<10) $mon = '0'.$i;
			$FromDate = $_GET['y'].'-'.$mon.'-01';
			$ToDate = $_GET['y'].'-'.$mon.'-31';
			$MonthName = date("F",strtotime($FromDate));
			if($arryEmp[0]['CommOn']==1){
				include("includes/html/box/commission_cal_per.php");
			}else if($arryEmp[0]['CommOn']==2){
				include("includes/html/box/commission_cal_margin.php");
			}else{
				include("includes/html/box/commission_cal.php");
			}
			if($TotalCommission<=0) $TotalCommission='0';	
						
			$valuesBar[$MonthName] = $TotalCommission;
			
			$arryLegend[] = $MonthName;
			$arryValue[] = $TotalCommission;
		
		}

	}else{
		exit;
	}
	
	
	$arryColor = array("#0c65bw","#b4cccc","#d6666c","#d8dc0d","#5c806b", "#9bb752","#e4c625","#de5958","#519e9a","#945f88","#d9802c ","#5c806b","#425457","#2d1f3f","#0c465b" 
,"#333333","#ff0000","#000fff","#6c6c6c","#0c65bw","#dddddd","#eeeeee"

);
	
	// class call with the width, height & data
	$pie = new PieGraph(230, 200, $arryValue);

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
