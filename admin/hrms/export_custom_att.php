<?php
include_once("../includes/settings.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/report.rule.class.php");
	require_once($Prefix."classes/leave.class.php");
	$objTime=new time();
	$objEmployee=new employee();
	$objReport = new report();
	$objLeave=new leave();

	/****************************/
	
$file="CustomAttendenceList_".date('d-m-Y').".xls";
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
		//$num=sizeof($arryAttendence);
		//$ShowList = 1;
		
		

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
		$attID = $values['attID'];
		$Intime = $values['InTime'];
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
			foreach($arryBreakTime as $keytime=>$valuestime){		
				$BreakTime += ConvertToSecond($valuestime['TimeDuration']);                              
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
		$arrayList[$empID]['shiftName'] =  $values['shiftName'];
		$arrayList[$empID]['ShiftDuration'] =  $values['ShiftDuration'];

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
		$arrayList[$empID][$attDate]['Intime'] = $Intime;
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
	$WeekEndNo = date('N', strtotime($arryCurrentLocation[0]['WeekEnd']));
	if($WeekEndNo==7 ) $WeekEndNo=0;	
/******************/
$WeekEndArry = GetWeekEndNum($arryCurrentLocation[0]['WeekStart'], $arryCurrentLocation[0]['WeekEnd']);

$WeekEndMySqlArry = GetWeekEndNumMySql($arryCurrentLocation[0]['WeekStart'], $arryCurrentLocation[0]['WeekEnd']);
$Config['WeekMysql'] = implode(",",$WeekEndMySqlArry);


$GlobalWorkingHour = $objTime->GetTimeDifference($arryCurrentLocation[0]['WorkingHourStart'],$arryCurrentLocation[0]['WorkingHourEnd'],0);
$wHourArray = explode(",",$GlobalWorkingHour);
$GlobalWorkingHour = (int)$wHourArray[0].':'.(int)$wHourArray[1];


$numHead = sizeof($reportHeader);
$numDate = sizeof($arrYDate);
if($arryReport[0]['BreakCheck'] == 'Yes'){
	$width = 600;
}else{ 
	$width =250;
} 
$tdwidth = 90;
$WeekNo = 1;

if($arryCurrentLocation[0]['Overtime']==1){
	$Overtime = 1;
	$weekColspan = 2;
}
/******************/

$test ='<table width="100%" align="center" cellpadding="3" cellspacing="1">';
   
   $test .='<tr align="left"  >';		 

	for ($j = 0; $j < $numHead; $j++) {
		$test .='<td class="head1" nowrap >'.$reportHeader[$j][0].'</td>';		
	}
	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);
		$test .= '<td class="head1">'.date("m/d/Y",$strtotimeVal).' </td>';
		if($WeekEndNo==$DinNo){
			$test .= '<td class="head1 red" colspan="'.$weekColspan.'" align="center" nowrap><strong>Week '.$WeekNo.'</strong></td>';
			$WeekNo++;
		}

	}
	
	$WeekNo = 1;
   $test .='</tr>';

   $test .='<tr align="left" >';
 

	$test .= '<td class="head1" colspan="'.$numHead.'"> </td>';
			

	for($dat=0;$dat<$numDate;$dat++){
		$test .= '<td class="head1">
			 <table style="margin:0" width="'.$width.'" cellpadding="0" cellspacing="1"  id="myTable" >
				<tr align="left" class="'.$bgclass.'">
					<td width="'.$tdwidth.'" >IN</td>
					<td width="'.$tdwidth.'" >OUT</td>
					';
					 if($arryReport[0]['BreakCheck'] == 'Yes'){
						$test .= '<td  width="'.$tdwidth.'">LO</td>
						<td width="'.$tdwidth.'">LI</td>
						<td width="'.$tdwidth.'" >SO</td>
						<td  width="'.$tdwidth.'">SI</td>';
						$test .= '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
						$test .= '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
					 }				
					    if($arryReport[0]['DurationCheck'] == 'Yes'){				
						$test .= '<td width="'.$tdwidth.'">Dur.</td>';
					    }
				
				$test .= '</tr>
			  </table>
			</td>';

		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);		
		if($WeekEndNo==$DinNo){
			$test .= '<td class="head1" nowrap align="center" ><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				$test .= '<td class="head1" nowrap align="center" ><strong>Total OT<strong></td>';
			}
			
		}




	}
 
 
    $test .='</tr>';


  $headNum = $numDate+ $numHead+1;
  if(sizeof($arrayList) >0){
	
	foreach($arrayList as $key=>$values){

	$Duration = 0;
	$DurationSecondWeek = 0;
	$ApprovedHoursWeek = 0;
	$OTHoursWeek = 0;

	if(!empty($values['shiftName']) && $arryCurrentLocation[0]['UseShift']==1){ 
		$EmpWorkingHour = substr($values['ShiftDuration'],0,5);
	}else{
		$EmpWorkingHour = $GlobalWorkingHour;
	}



    	$test .='<tr align="left">';        

	for ($i = 0; $i < $numHead; $i++) {
		if($reportHeader[$i][1] == "UserName"){
			$test .='<td><strong>'.$values['EmpName'].'</strong></td>';
		}else if($reportHeader[$i][1] == "EmpCode"){
			$test .='<td><strong>'.$values['EmpCode'].'</strong> </td>';
		}else{
			$test .='<td>'.$values[$reportHeader[$i][1]].'</td>';             
		}
	}

		



	 for($dat2=0;$dat2<count($arrYDate);$dat2++){

		$ApprovedLeave=0; $ApprovedHours=0;

		$strtotimeVal = strtotime($arrYDate[$dat2]);
		$DinNo = date("w",$strtotimeVal);	
	

			$test .='<td>';
			//if(!empty($values[$arrYDate[$dat2]]['Intime'])){
				$test .= '<table width="100%" align="center" cellpadding="0" cellspacing="1" id="myTable">
		
					<tr align="left">
						<td>'.$values[$arrYDate[$dat2]]['Intime'].'</td>
						<td>'.$values[$arrYDate[$dat2]]['OutTime'].'</td>
 	
					';
if($arryReport[0]['BreakCheck'] == 'Yes'){						
$test .='<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["LO"].'</td>						
<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["LI"].'</td>
<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][0].'</td> 
<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][0].'</td>';

$test .='<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][1].'</td> 
<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][1].'</td>';

$test .='<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][2].'</td> 
<td>'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][2].'</td>';
} 
if($arryReport[0]['DurationCheck'] == 'Yes'){
$test .='<td>';

if(!empty($values[$arrYDate[$dat2]]['Intime'])){ 
	$test .= SecondToHrMin($values[$arrYDate[$dat2]]['DurationSecond']);

}else if(!in_array($DinNo, $WeekEndArry)){ //not a weekend	
	$ApprovedLeave=$objLeave->checkLeaveHoliday($values['EmpID'],$arrYDate[$dat2]);
	if($ApprovedLeave==1){
		$test .= $EmpWorkingHour;
		$ApprovedHours = ConvertToSecond($EmpWorkingHour);  
	}
}

$test .='</td>';
}
					
			$test .='</tr></table>';
			//}
		$test .='</td> ';   



		$ApprovedHoursWeek += $ApprovedHours;
	/**************************/
		//$strtotimeVal = strtotime($arrYDate[$dat2]);
		//$DinNo = date("w",$strtotimeVal);		
		if($WeekEndNo==$DinNo){
			$DurationSecondWeek += $values[$arrYDate[$dat2]]['DurationSecond'] + $ApprovedHoursWeek;
			$OTHoursWeek += $values[$arrYDate[$dat2]]['OTHours'];
			$test .= '<td class="head1" align="center">'.SecondToHrMin($DurationSecondWeek).'</td>';
			if($Overtime==1){
				if($values['OvertimePeriod']=='W'){
					$OTSecondWeek = $DurationSecondWeek - ($values['OvertimeHourWeek']*3600);
				}else{
					$OTSecondWeek = $OTHoursWeek;
				}
				if($OTSecondWeek<0) $OTSecondWeek=0;
				$test .= '<td class="head1" nowrap align="center">'.SecondToHrMin($OTSecondWeek).'</td>';
			}

			$DurationSecondWeek = 0;
			$OTHoursWeek = 0;
			$ApprovedHoursWeek = 0;
		}else{ 
			$DurationSecondWeek += $values[$arrYDate[$dat2]]['DurationSecond'];
			$OTHoursWeek += $values[$arrYDate[$dat2]]['OTHours'];
			
		}
		/**************************/













   
	 }
	
   $test .= '</tr>';
	

  } 
  
     }else{
    $test .='<tr >
      <td  colspan="'.$headNum.'" class="no_record">'.NO_RECORD.'</td>
    </tr>';
     } 
  
 
 
$test .='</td>
  </tr>
  </table>';

//echo $test; exit;

#$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;
?>
