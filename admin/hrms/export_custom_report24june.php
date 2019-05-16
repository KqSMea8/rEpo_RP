<?php
include_once("../includes/settings.php");
include_once("includes/html/box/custom_report_action.php");


$file="CustomAttendanceReport_".date('d-m-Y').".xls";

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
	if($ShowWeekly==1) $weekColspan = 3; else $weekColspan = 2;
}
/******************/

$test ='<table width="100%" align="center" cellpadding="3" cellspacing="1">';
   
   $test .='<tr align="left"  >';		 

	for ($j = 0; $j < $numHead; $j++) {
		$test .='<td class="head1" nowrap >'.$reportHeader[$j][0].'</td>';		
	}
	$test .= '<td class="head1" nowrap >Pay Cycle</td>';
	$test .= '<td class="head1" nowrap >Hourly Rate</td>';

	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);
		$Day = date("d",$strtotimeVal);
		$test .= '<td class="head1">'.date("m/d/Y",$strtotimeVal).' </td>';

		$monthColspan = $weekColspan+1;
		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
			$test .= '<td class="head1 red" colspan="'.$monthColspan.'" align="center" nowrap><strong>Semi-Month End</strong></td>';
		}
		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
			$test .= '<td class="head1 red" colspan="'.$monthColspan.'"  align="center" nowrap><strong>Month End</strong></td>';
		}

		if($WeekEndNo==$DinNo){
			$test .= '<td class="head1 red" colspan="'.$weekColspan.'" align="center" nowrap><strong>Week '.$WeekNo.'</strong></td>';
			$WeekNo++;
		}
		

	}
	
	$WeekNo = 1;
   $test .='</tr>';

   $test .='<tr align="left" >';
 
	$numHeading=$numHead+2;
	$test .= '<td class="head1" colspan="'.$numHeading.'"> </td>';
			

	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);		
		$Day = date("d",$strtotimeVal);
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
					 if($ShowDaily==1){
					    $test .= '<td width="'.$tdwidth.'">'.$Config['Currency'].'</td>';
					 }
				
				$test .= '</tr>
			  </table>
			</td>';

		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
			$test .=  '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				$test .= '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
			}
			$test .=  '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}
		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
			$test .=  '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				$test .= '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
			}
			$test .=  '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}


		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);		
		if($WeekEndNo==$DinNo){
			$test .= '<td class="head1" nowrap align="center" ><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				$test .= '<td class="head1" nowrap align="center" ><strong>Total OT<strong></td>';
			}
			if($ShowWeekly==1){
				$test .= '<td class="head1" align="center" nowrap><strong>'.$Config['Currency'].'<strong></td>';
			}
		}




	}
 
 
    $test .='</tr>';


  $headNum = $numDate+ $numHead+1;
  if(sizeof($arrayList) >0){
	$flag=true;
	$Line=0; $TotalDuration = 0;
	foreach($arrayList as $key=>$values){

	$flag=!$flag;
	$Line++;
	$Duration = 0;
	$DurationSecondWeek = 0;
	$ApprovedHoursWeek = 0;
	$OTHoursWeek = 0;
	$SalaryWeek = 0;
	$SalaryBiWeekly=0;
	$DurationBiWeekly=0;
	$OTBiWeekly=0;
	$incolor = ''; $outcolor ='';
	$bgclass = (!$flag)?("oddbg"):("evenbg");

	if(!empty($values['shiftName']) && $arryCurrentLocation[0]['UseShift']==1){ 
		$EmpWorkingHour = substr($values['ShiftDuration'],0,5);
		$EmpPayCycle = $values['PayCycle'];
	}else{
		$EmpWorkingHour = $GlobalWorkingHour;
		$EmpPayCycle = $GlobalPayCycle;
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

	$test .= '<td nowrap>'.$EmpPayCycle.'</td>';	
	$test .= '<td nowrap>';
	$test .= $values['HourRate'];
	$test .= '</td>';

	$WeekNo=1;
	$SalaryMonthly=0;
	$DurationMonthly=0;
	$OTMonthly=0;
	for($dat2=0;$dat2<$numDate;$dat2++){

		$ApprovedLeave=0; $ApprovedHours=0;

		$strtotimeVal = strtotime($arrYDate[$dat2]);
		$DinNo = date("w",$strtotimeVal);	
		$Day = date("d",$strtotimeVal);

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



$DurationSecondShow='';
if(!empty($values[$arrYDate[$dat2]]['Intime'])){ 
	$DurationSecondShow= SecondToHrMin($values[$arrYDate[$dat2]]['DurationSecond']);

}else if(!in_array($DinNo, $WeekEndArry)){ //not a weekend	
	$ApprovedLeave=$objLeave->checkLeaveHoliday($values['EmpID'],$arrYDate[$dat2]);
	if($ApprovedLeave==1){
		$DurationSecondShow = $EmpWorkingHour;
		$ApprovedHours = ConvertToSecond($EmpWorkingHour); 
	}
}


$DurPerDay = $values[$arrYDate[$dat2]]['DurationSecond']+$ApprovedHours;

$SalaryPerDay = $values['HourRate']*(($DurPerDay)/3600);
$SalaryMonthly+=$SalaryPerDay;

$DurationMonthly += $DurPerDay;
if($Overtime==1){
	$OTPerDay = $values[$arrYDate[$dat2]]['OTHours'];
	if($OTPerDay<0) $OTPerDay=0;
	$OTMonthly += $OTPerDay;
}



if($arryReport[0]['DurationCheck'] == 'Yes'){
$test .='<td>'.$DurationSecondShow.'</td>';
}


if($ShowDaily==1){
	$test .= '<td>';
	if($PayMethod=='H' && $EmpPayCycle=="Daily"){
		$SalaryDaily=$values['HourRate']*(($values[$arrYDate[$dat2]]['DurationSecond']+$ApprovedHours)/3600);
		if($SalaryDaily>0)$test .= number_format($SalaryDaily,2);
	}			
	$test .= '</td>';
}





					
			$test .='</tr></table>';
			//}
		$test .='</td> ';   




		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){ 
			$test .= '<td align="center"><strong>'.SecondToHrMin($DurationMonthly).'</strong></td>';
			$test .= '<td align="center"><strong>'.SecondToHrMin($OTMonthly).'</strong></td>';
			$test .= '<td align="center">';
			if($PayMethod=='H' && $SalaryMonthly>0)$test .= '<strong>'.number_format($SalaryMonthly,2).'</strong>';
			$SalaryMonthly=0;
			$DurationMonthly=0;
			$OTMonthly=0;
			$test .= '</td>';
		}

		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){	
			$test .= '<td align="center"><strong>'.SecondToHrMin($DurationMonthly).'</strong></td>';
			$test .= '<td align="center"><strong>'.SecondToHrMin($OTMonthly).'</strong></td>';
			$test .= '<td align="center">';		
			if($PayMethod=='H' && $SalaryMonthly>0)$test .= '<strong>'.number_format($SalaryMonthly,2).'</strong>';
			$SalaryMonthly=0;
			$DurationMonthly=0;
			$OTMonthly=0;
			$test .= '</td>';
		} 







		$ApprovedHoursWeek += $ApprovedHours;
				
		if($WeekEndNo==$DinNo){

			$DurationSecondWeek += $values[$arrYDate[$dat2]]['DurationSecond'] + $ApprovedHoursWeek;
			$OTHoursWeek += $values[$arrYDate[$dat2]]['OTHours'];
		
			if($Overtime==1){
				if($values['OvertimePeriod']=='W'){
					$OTSecondWeek = $DurationSecondWeek - ($values['OvertimeHourWeek']*3600);
				}else{
					$OTSecondWeek = $OTHoursWeek;
				}
				if($OTSecondWeek<0) $OTSecondWeek=0;
			}

			$SalaryWeekly='';
			$DurWeekly=SecondToHrMin($DurationSecondWeek);
			$OTWeekly=SecondToHrMin($OTSecondWeek);

			if($PayMethod=='H'){
				$SalaryWeek=$values['HourRate']*(($DurationSecondWeek+$OTSecondWeek)/3600);
				
				if($EmpPayCycle=="Weekly"){					
					$SalaryWeekly = ($SalaryWeek>0)?(number_format($SalaryWeek,2)):('');
				}else if($EmpPayCycle=="Bi-Weekly"){
					$SalaryBiWeekly += $SalaryWeek;
					$DurationBiWeekly += $DurationSecondWeek;
					$OTBiWeekly += $OTSecondWeek;
					if($WeekNo%2==0){
						$SalaryWeekly = ($SalaryBiWeekly>0)?(number_format($SalaryBiWeekly,2)):('');
						$SalaryBiWeekly=0;

						$DurWeekly=SecondToHrMin($DurationBiWeekly);
						$DurationBiWeekly=0;

						$OTWeekly=SecondToHrMin($OTBiWeekly);
						$OTBiWeekly=0;
						
					}else{
						$DurWeekly='';
						$OTWeekly='';						
					}
				}else if($EmpPayCycle=="Semi-Monthly" || $EmpPayCycle=="Monthly"){
					$DurWeekly='';
					$OTWeekly='';	
				}
				
			}












			$test .= '<td class="head1" align="center">'.$DurWeekly.'</td>';
			if($Overtime==1){				
				 $test .= '<td class="head1" nowrap align="center">'.$OTWeekly.'</td>';			}			
			if($ShowWeekly==1){
				$test .= '<td class="head1" align="center">'.$SalaryWeekly.'</td>';
			}

			$DurationSecondWeek = 0;
			$OTHoursWeek = 0;
			$ApprovedHoursWeek = 0;
			$WeekNo++;
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

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;
?>
