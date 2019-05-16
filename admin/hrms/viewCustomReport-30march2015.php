<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/report.rule.class.php");
	$objTime=new time();
	$objEmployee=new employee();
	$objReport = new report();


	/****************************/
	

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

		foreach($arryReport as $key=>$values){
		$arrayHead[$values['reportID']]['FormDate'] = $arryReport[0]['FromDate'];
		$arrayHead[$values['reportID']]['ToDate'] = $arryReport[0]['FromDate'];
		}

	}


      $arrYDate = createDateRangeArray($arryReport[0]['FromDate'],$arryReport[0]['ToDate']);

	/****************************/
	$RedirectUrl ="viewAttendence.php?s=1";
	
    	$arryAttendence=$objReport->getAttendenceReport($_GET['dt'], $arryReport[0]['FromDate'], $arryReport[0]['ToDate']);
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
		$empID = $values['EmpID'];
		$Intime = $values['InTime'];
		$OutTime = $values['OutTime'];
		$attDate = $values['attDate'];
		$Duration = 0;
	$BreakTime = 0;
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
			foreach($arryBreakTime as $keytime=>$valuestime){		
				$BreakTime += ConvertToSecond($valuestime['TimeDuration']);
			}
		
		}

		$Duration = ConvertToSecond($values["TimeDuration"]) - $BreakTime;
		if($Duration>0){$Duration = gmdate("H:i:s", $Duration);}
		/****************/


		$arrayList[$empID]['EmpID'] =  $values['EmpID'];
		$arrayList[$empID]['JobTitle'] =  $values['JobTitle'];
		$arrayList[$empID]['EmpCode'] =  $values['EmpCode'];
		$arrayList[$empID]['Department'] =  $values['Department'];
		$arrayList[$empID]['EmpName'] =  $values['UserName'];

                $arrayList[$empID]['InComment'] =  $values['InComment'];
		$arrayList[$empID]['OutComment'] =  $values['OutComment'];

		$arrayList[$empID]['punchType'] =  $values['punchType'];

		$arrayList[$empID][$attDate]['Intime'] = $Intime;
		$arrayList[$empID][$attDate]['OutTime'] = $OutTime;
		$arrayList[$empID][$attDate]['Duration'] = $Duration;	
		//$arrayDate[] = $attDate;


	}

	require_once("../includes/footer.php");
?>

