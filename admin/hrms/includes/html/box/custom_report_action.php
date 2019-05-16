<?
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/report.rule.class.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objTime=new time();
	$objEmployee=new employee();
	$objReport = new report();
	$objLeave=new leave();
	$objCommon=new common();
	/****************************/
	(empty($_GET['shiftID']))?($_GET['shiftID']=""):("");
	(empty($Payroll))?($Payroll=""):("");

function createDateRangeArray($strDateFrom,$strDateTo)
{
   

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom));
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; 
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

 function multiexplode ($delimiters,$string) {
    $ary = explode($delimiters[0],$string);
    array_shift($delimiters);
    if($delimiters != NULL) {
        foreach($ary as $key => $val) {
             $ary[$key] = multiexplode($delimiters, $val);
        }
    }
    return  $ary;
} 
	/****************************/


 

	if(!empty($_GET['CustomReport'])){
		$arryReport = $objReport->GetReportRule($_GET['CustomReport']);
		$delimiters = Array(",",":");
		$reportHeader = multiexplode($delimiters,$arryReport[0]['ReportRule']);

		$FromDate = $arryReport[0]['FromDate'];
		$ToDate = $arryReport[0]['ToDate'];

		foreach($arryReport as $key=>$values){
			$arrayHead[$values['reportID']]['FormDate'] = $FromDate;
			$arrayHead[$values['reportID']]['ToDate'] = $ToDate;
		}

	}


      $arrYDate = createDateRangeArray($FromDate, $ToDate);
 
	/****************************/
	$RedirectUrl ="viewAttendence.php?s=1";
	
    	$arryAttendence=$objReport->getAttendenceReport($_GET['dt'], $FromDate, $ToDate);
		$num=sizeof($arryAttendence);
		$ShowList = 1;
		
		

 	$arryCustomReport = $objReport->GetReportRule('');

 	$arrayList = array();


	/*********************/
	if($arryCurrentLocation[0]['UseShift']==1){
		$LunchPaidMain = 1;
		$ShortBreakPaidMain = 1;
	}else{
		$LunchPaidMain = $arryCurrentLocation[0]['LunchPaid'];
		$ShortBreakPaidMain = $arryCurrentLocation[0]['ShortBreakPaid'];
	}
	/*********************/
 
	foreach($arryAttendence as $key=>$values){
		$EmpIDArray[] = $values['EmpID'];
		$empID = $values['EmpID'];
		$attID = $values['attID'];
		$InTime = $values['InTime'];
		$OutTime = $values['OutTime'];
		$attDate = $values['attDate'];
		$Duration = 0;
		$BreakTime = 0;
		$OTHours = 0;
		/****************/
		$LunchPaid = $LunchPaidMain; 
		$ShortBreakPaid = $ShortBreakPaidMain;

		if(!empty($values['shiftName'])){
			$LunchPaid = $values['LunchPaid']; 
			$ShortBreakPaid = $values['ShortBreakPaid'];
		}
		$BreakType = '';unset($arryBreakTime);
		if($LunchPaid!=1) $BreakType .= "'Lunch',";
		if($ShortBreakPaid!=1) $BreakType .= "'Short Break',";
		$BreakType =rtrim($BreakType,",");
		if(!empty($BreakType)){
			$arryBreakTime=$objTime->getBreakTime($values['attID'],$BreakType);
			if(sizeof($arryBreakTime)>0){
				foreach($arryBreakTime as $keytime=>$valuestime){		
					$BreakTime += ConvertToSecond($valuestime['TimeDuration']);                              
				}
			}
		
		}
      
		/****************/
		$Duration = ConvertToSecond($values["TimeDuration"]) - $BreakTime;
		$DurationSecond = $Duration;
		if($DurationSecond<1) $DurationSecond='0';

		if($Duration>0){		 
			$OTHours = $Duration - ConvertToSecond($values["WorkingDuration"]);
			if($OTHours<1) $OTHours='0';

			$Duration = gmdate("H:i:s", $Duration);
		  	$dura = explode(":",$Duration);
			if($dura[2]>30){
			  	$minutes =  $dura[1]+1;
			}else{
				$minutes =  $dura[1];
			}                
			$Duration = $dura[0].":".$minutes;
		}else{
			$Duration='';
		}

		/****************/


		$arrayList[$empID]['EmpID'] =  $values['EmpID'];
		$arrayList[$empID]['JobTitle'] =  $values['JobTitle'];
		$arrayList[$empID]['EmpCode'] =  $values['EmpCode'];
		$arrayList[$empID]['Department'] =  $values['Department'];
		$arrayList[$empID]['EmpName'] =  $values['UserName'];
		$arrayList[$empID]['Exempt'] =  $values['Exempt'];
		$arrayList[$empID]['JoiningDate'] =  $values['JoiningDate'];
		$arrayList[$empID]['shiftName'] =  $values['shiftName'];
		$arrayList[$empID]['ShiftDuration'] =  $values['ShiftDuration'];
		$arrayList[$empID]['LunchPaid'] =  $values['LunchPaid'];
		$arrayList[$empID]['LunchTime'] =  $values['LunchTime'];
		$arrayList[$empID]['ShortBreakPaid'] =  $values['ShortBreakPaid'];
		$arrayList[$empID]['ShortBreakLimit'] =  $values['ShortBreakLimit'];
		$arrayList[$empID]['ShortBreakTime'] =  $values['ShortBreakTime'];

		$arrayList[$empID]['PayRate'] =  $values['PayRate'];
		$arrayList[$empID]['HourRate'] =  $values['HourRate'];
		$arrayList[$empID]['PayCycle'] =  $values['PayCycle'];
		$arrayList[$empID]['Overtime'] =  $values['Overtime'];
		if($values['Overtime']=='1'){
			$arrayList[$empID][$attDate]['OTHours'] = $OTHours;
			$arrayList[$empID]['OvertimePeriod'] =  $values['OvertimePeriod'];
			if($values['OvertimePeriod']=='W'){
				$arrayList[$empID]['OvertimeHourWeek'] =  $values['OvertimeHourWeek'];
			}
		}


                $arrayList[$empID]['InComment'] =  $values['InComment'];
		$arrayList[$empID]['OutComment'] =  $values['OutComment'];
		$arrayList[$empID]['attID'] =  $values['attID'];
		$arrayList[$empID][$attDate]['InTime'] = $InTime;
		$arrayList[$empID][$attDate]['OutTime'] = $OutTime;
		$arrayList[$empID][$attDate]['Duration'] = $Duration;
		$arrayList[$empID][$attDate]['DurationSecond'] = $DurationSecond;
		


          	$arryBreak=$objTime->getAttPunching($values['attID'],'','');

		foreach($arryBreak as $keytime=>$valuesBreak){
			if($valuesBreak['punchType']=='Lunch'){
				$arryBreakList[$empID][$attDate]['LO'] =$valuesBreak['InTime'];
				$arryBreakList[$empID][$attDate]['LI'] =$valuesBreak['OutTime'];
			}else{
				$arryBreakList[$empID][$attDate]['SO'][] =$valuesBreak['InTime'];
				$arryBreakList[$empID][$attDate]['SI'][] =$valuesBreak['OutTime'];
			}
		}



	}


if($_GET['d']==1){
	echo '<pre>'; print_r($arrayList);echo '</pre>';exit;
}



	/*********************/
	if(!empty($arryCurrentLocation[0]['PayrollStart'])){
		$PayrollStart = $arryCurrentLocation[0]['PayrollStart'];
	}else{
		$WeekEndNo = date('N', strtotime($arryCurrentLocation[0]['WeekEnd']));
		if($WeekEndNo==7 ) $WeekEndNo=0;
	}
	/******************/
	$WeekEndArry = GetWeekEndNum($arryCurrentLocation[0]['WeekStart'], $arryCurrentLocation[0]['WeekEnd']);

	$WeekEndMySqlArry = GetWeekEndNumMySql($arryCurrentLocation[0]['WeekStart'], $arryCurrentLocation[0]['WeekEnd']);
	$Config['WeekMysql'] = implode(",",$WeekEndMySqlArry);
	
	$ShortBreakSecond=$LunchTimeInSecond='';
	if($arryCurrentLocation[0]['LunchPaid']!=1){
		$LunchTimeInSecond = ConvertToSecond($arryCurrentLocation[0]['LunchTime']);
	}
	if($arryCurrentLocation[0]['ShortBreakPaid']!=1){ 
		$ShortBreakSecond = $arryCurrentLocation[0]['ShortBreakLimit']*$arryCurrentLocation[0]['ShortBreakTime']*60;
	}
	

	$GlobalWorkingHour = $objTime->GetTimeDifference($arryCurrentLocation[0]['WorkingHourStart'],$arryCurrentLocation[0]['WorkingHourEnd'],0);
	$wHourArray = explode(",",$GlobalWorkingHour);
	$wHour = (!empty($wHourArray[0]))?(int)$wHourArray[0]:''; 
	$wMinute = (!empty($wHourArray[1]))?(int)$wHourArray[1]:'';   

	if($wHour<10) $wHour = '0'.$wHour;
	if($wMinute<10) $wMinute = '0'.$wMinute;
	$GlobalWorkingHour = $wHour.':'.$wMinute;
	$GlobalWorkingInSecond= ConvertToSecond($GlobalWorkingHour) - $LunchTimeInSecond - $ShortBreakSecond;
	$GlobalWorkingHour = SecondToHrMin($GlobalWorkingInSecond);


	$GlobalPayCycle = $arryCurrentLocation[0]['PayCycle'];
	$GlobalOvertimeRate = $arryCurrentLocation[0]['OvertimeRate'];
	/************************/

	if($arryCurrentLocation[0]['UseShift']==1){ 
		$UseShift = $arryCurrentLocation[0]['UseShift'];
		$arryShift = $objCommon->getShift('','1');
		if(!empty($_GET['shiftID'])){
			$arryShiftDet = $objCommon->getShift($_GET['shiftID'],'');
			if(!empty($arryShiftDet[0]['PayrollStart'])){
				$PayrollStart = $arryShiftDet[0]['PayrollStart'];
				
			}
			$GlobalPayCycle = $arryShiftDet[0]['PayCycle'];
			unset($WeekEndArry);
			$WeekEndArry = GetWeekEndNum($arryShift[0]['WeekStart'], $arryShift[0]['WeekEnd']);
		}else{
			$_GET['CustomReport']='';
		}

		
	}
//if($_GET['d']==1){print_r($WeekEndArry);}
	/************************/
	$ShowDaily = ($GlobalPayCycle=="Daily")?('1'):('0');
	$ShowWeekly = ($GlobalPayCycle=="Weekly" || $GlobalPayCycle=="Bi-Weekly")?('1'):('0');
	$ShowSemiMonthly = ($GlobalPayCycle=="Semi-Monthly")?('1'):('0');
	$ShowMonthly = ($GlobalPayCycle=="Monthly")?('1'):('0');

	if(!empty($PayrollStart)){
		$WeekEndNo = date('N', strtotime($PayrollStart))-1; 
		if($WeekEndNo==7 ) $WeekEndNo=0;


		/****MonthEndDay*******/
		$PayrollStartArry = explode('-',$PayrollStart);
 		//$MonthEndDay = $PayrollStartArry[2]; //old
		$LastMonthDate = date('Y-m-d', mktime(0, 0, 0, $PayrollStartArry[1], $PayrollStartArry[2] -1, $PayrollStartArry[0]));
		$MonthArry = explode('-',$LastMonthDate);
		$MonthEndDay = $MonthArry[2];
		if($PayrollStartArry[2]=="01"){ //30 or 31
			$ct=0;
 
			foreach($arrYDate as $dt){
			 	$dtArray = explode('-',$dt);
				if($dtArray[2]=="01"){ 	
					if($ct==0) $LastIndexMonth = $ToDate;				
					else $LastIndexMonth = $arrYDate[$ct-1];
					break;
				}
				$ct++;
			}
			if(!empty($LastIndexMonth)){ 
				$LastMonthDate = date("Y-m-t", strtotime($LastIndexMonth));		
				$MonthArry = explode('-',$LastMonthDate);
				$MonthEndDay = $MonthArry[2];		 
			}
		}
 
		/****SemiDate*******/
		$SemiDate = date('Y-m-d', mktime(0, 0, 0, $PayrollStartArry[1], $PayrollStartArry[2] + 14, $PayrollStartArry[0]));
		$SemiMonthArry = explode('-',$SemiDate);
		$SemiMonthDay = $SemiMonthArry[2];
	}
	$PayMethod = $arryCurrentLocation[0]['PayMethod'];
	$NumDaysInWeek = 7-sizeof($WeekEndArry);


	/******Commission********/
	include_once("../includes/html/box/payroll_commission_data.php");
	/************************/
	
?>
