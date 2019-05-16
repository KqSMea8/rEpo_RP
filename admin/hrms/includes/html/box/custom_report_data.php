<?

 $EmpWorkingInSecond='';

$numHead = sizeof($reportHeader);
$numDate = sizeof($arrYDate);

$Config['DurationFormat'] = $arryReport[0]['DurationFormat'];


$width = 100;
if($arryReport[0]['PunchCheck'] == 'Yes'){
	$width = $width + 150;
}
if($arryReport[0]['BreakCheck'] == 'Yes'){
	$width = $width + 350;
}

if($ShowDaily==1 && $CommissionFlag==1){
	$width = $width + 50;
} 

 

$tdwidth = 90;
$WeekNo = 1;
$weekColspan = 1;

if($ShowWeekly==1 && $Payroll==1){
	$weekColspan = 2;
}

if($arryCurrentLocation[0]['Overtime']==1){
	$Overtime = 1;	
	$weekColspan++;	
}else{
	$GlobalOvertimeRate = $OvertimeRate;
}

if($ShowWeekly==1 && $CommissionFlag==1){
	$weekColspan++;	
}


$monthColspan = $weekColspan;


/******************/

/****************** START FIRST ROW ******************/
/*****************************************************/
$content ='<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable" >
		<tr align="left" class="RowFirst">';
	for ($j = 0; $j < $numHead; $j++) {
		
		if($reportHeader[$j][1] == "UserName"){
			$left=159*$j + 24;
			$ColFirstCls = 'ColFirst';			
			$ColStyle= 'left:'.$left.'px;';		
		}else{
			$ColFirstCls = '';	
			$ColStyle= '';		
		}
			
		$content .='<td class="head1 '.$ColFirstCls.'" style="min-width:150px;max-width:150px;'.$ColStyle.'">'.$reportHeader[$j][0].'</td>';		
	}
	$content .= '<td class="head1" nowrap >Exempt</td>';
	if($Payroll==1){
		$content .= '<td class="head1" nowrap >Pay Cycle</td>';
		$content .= '<td class="head1" nowrap >Hourly Rate</td>';
		$monthColspan=$monthColspan+1;
	}
	if($CommissionFlag==1){		
		$monthColspan=$monthColspan+1;
	}

	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);
		$Day = date("d",$strtotimeVal);
		$content .= '<td class="head1">'.date("m/d/Y",$strtotimeVal).' </td>';


		
		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
			$content .= '<td class="head1 red" colspan="'.$monthColspan.'" align="center" nowrap><strong>Semi-Month End</strong></td>';
		}
		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
			$content .= '<td class="head1 red" colspan="'.$monthColspan.'"  align="center" nowrap><strong>Month End</strong></td>';
		}


		if($WeekEndNo==$DinNo){
			$content .= '<td class="head1 red" colspan="'.$weekColspan.'" align="center" nowrap><strong>Week '.$WeekNo.'</strong></td>';
			$WeekNo++;
		}
		

	}
	
$WeekNo = 1;
$content .='</tr>';


/****************** START SECOND ROW *****************/
/*****************************************************/

$numHeading=$numHead+1;
if($Payroll==1){
	$numHeading=$numHeading+2;
}

$content .='<tr align="left" >'; 
$content .= '<td class="head1" colspan="'.$numHeading.'"> </td>';
			
for($dat=0;$dat<$numDate;$dat++){
	$strtotimeVal = strtotime($arrYDate[$dat]);		
	$Day = date("d",$strtotimeVal);
	$content .= '<td class="head1">
			 <table style="margin:0" width="'.$width.'" cellpadding="0" cellspacing="1"   >
				<tr align="left" >';
					if($arryReport[0]['PunchCheck'] == 'Yes'){
						$content .= '<td width="'.$tdwidth.'" >IN</td>
						<td width="'.$tdwidth.'" >OUT</td>
						';
					}
					 if($arryReport[0]['BreakCheck'] == 'Yes'){
						$content .= '<td  width="'.$tdwidth.'">LO</td>
						<td width="'.$tdwidth.'">LI</td>
						<td width="'.$tdwidth.'" >SO</td>
						<td  width="'.$tdwidth.'">SI</td>';
						$content .= '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
						$content .= '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
					 }				
					 if($arryReport[0]['DurationCheck'] == 'Yes'){				
						$content .= '<td width="'.$tdwidth.'">Dur.</td>';
					 }
					 if($ShowDaily==1 && $Payroll==1){

					    if($CommissionFlag==1) $content .= '<td width="'.$tdwidth.'">Comm.</td>';

					    $content .= '<td width="'.$tdwidth.'">'.$Config['Currency'].'</td>';
					 }
				
				$content .= '</tr>
			  </table>
			</td>';

	if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
		$content .= '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
		if($Overtime==1){
			$content .= '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
		}
		if($CommissionFlag==1){
			$content .= '<td class="head1" align="center"  nowrap><strong>Comm.<strong></td>';
		}
		if($Payroll==1){
			$content .= '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}
	}
	if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
		$content .= '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
		if($Overtime==1){
			$content .= '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
		}
		if($CommissionFlag==1){
			$content .= '<td class="head1" align="center"  nowrap><strong>Comm.<strong></td>';
		}
		if($Payroll==1){
			$content .= '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}
	}


	$strtotimeVal = strtotime($arrYDate[$dat]);
	$DinNo = date("w",$strtotimeVal);		
	if($WeekEndNo==$DinNo){
		$content .= '<td class="head1" nowrap align="center" ><strong>Total Dur.<strong></td>';
		if($Overtime==1){
			$content .= '<td class="head1" nowrap align="center" ><strong>Total OT<strong></td>';
		}
		if($ShowWeekly==1 && $CommissionFlag==1){
			$content .= '<td class="head1" nowrap align="center" ><strong>Comm.<strong></td>';
		}
		if($ShowWeekly==1 && $Payroll==1){
			$content .= '<td class="head1" align="center" nowrap><strong>'.$Config['Currency'].'<strong></td>';
		}
	}

}
  
$content .='</tr>';


/****************** START THIRD ROW *****************/
/****************************************************/


$tdwidth = 45;
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
	$CommWeek = 0;
	$CommBiWeekly=0;
	$DurationBiWeekly=0;
	$OTBiWeekly=0;
	$OTSecondWeek=0;
	$LunchTimeInSecond=0;
	$ShortBreakSecond=0;
	$incolor = ''; $outcolor ='';
	$bgclass = (!empty($flag))?("oddbg"):("evenbg");

	$OvertimeRate = $GlobalOvertimeRate; //fixed for global, not shiftwise

	if(!empty($values['shiftName']) && $arryCurrentLocation[0]['UseShift']==1){ 
		$EmpPayCycle = $values['PayCycle'];

		$EmpWorkingHour = substr($values['ShiftDuration'],0,5);
		if($values['LunchPaid']!=1){
			$LunchTimeInSecond = ConvertToSecond($values['LunchTime']);
		}
		if($values['ShortBreakPaid']!=1){ 
			$ShortBreakSecond = $values['ShortBreakLimit']*$values['ShortBreakTime']*60;
		}
		$EmpWorkingInSecond = ConvertToSecond($EmpWorkingHour) - $LunchTimeInSecond - $ShortBreakSecond;
		$EmpWorkingHour = SecondToHrMin($EmpWorkingInSecond);

		
	}else{
		$EmpPayCycle = $GlobalPayCycle;
		$EmpWorkingHour = $GlobalWorkingHour;
		
	}

	$AllowedSecondsInWeek = $NumDaysInWeek*$EmpWorkingInSecond;

    	$content .='<tr align="left" class="'.$bgclass.'">';        

	for ($i = 0; $i < $numHead; $i++) {
		if($reportHeader[$i][1] == "UserName"){
			if(!empty($ExportFile)){
				$content .='<td ><strong>'.$values['EmpName'].'</strong></td>';
			}else{
				$left=159*$i + 24;		
				$ColStyle= 'left:'.$left.'px;';	

				$content .='<td  class="ColFirst" ><a class="fancybox fancybox.iframe" href="empInfo.php?view='.$values['EmpID'].'" style="'.$ColStyle.'"><strong>'.$values['EmpName'].'</strong></a></td>';
			}
		}else if($reportHeader[$i][1] == "EmpCode"){
			if(!empty($ExportFile)){
				$content .='<td ><strong>'.$values['EmpCode'].'</strong></td>';
			}else{
				$content .='<td  ><a class="fancybox fancybox.iframe" href="empInfo.php?view='.$values['EmpID'].'" ><strong>'.$values['EmpCode'].'</strong></a></td>';
			}
		}else{
			$content .='<td >'.$values[$reportHeader[$i][1]].'</td>';             
		}
	}
	$content .= '<td nowrap>';
	$content .= ($values['Exempt']==1)?("Yes"):("No");
	$content .= '</td>';	
	if($Payroll==1){
		$content .= '<td nowrap>'.$EmpPayCycle.'</td>';	
		$content .= '<td nowrap>'.$values['HourRate'].'</td>';
	}

	$WeekNo=1;
	$SalaryMonthly=0;
	$DurationMonthly=0;
 	$CommMonthly=0;

	$OTMonthly=0;
	for($dat2=0;$dat2<$numDate;$dat2++){

		$ApprovedLeave=0; 
		$ApprovedHours=0;

		$strtotimeVal = strtotime($arrYDate[$dat2]);
		$DinNo = date("w",$strtotimeVal);	
		$Day = date("d",$strtotimeVal);

		$content .='<td>';
			//if(!empty($values[$arrYDate[$dat2]]['InTime'])){
		$content .= '<table width="100%" align="center" cellpadding="0" cellspacing="1" id="punchTable" >
			<tr align="left">';

		if($arryReport[0]['PunchCheck'] == 'Yes'){

			$InTimeVal = (!empty($values[$arrYDate[$dat2]]['InTime']))?($values[$arrYDate[$dat2]]['InTime']):('');
			$OutTimeVal = (!empty($values[$arrYDate[$dat2]]['OutTime']))?($values[$arrYDate[$dat2]]['OutTime']):('');

			$content .= '<td width="'.$tdwidth.'" height="20">'.$InTimeVal.'</td>
			<td width="'.$tdwidth.'">'.$OutTimeVal.'</td>';
		}
 	
					
		if($arryReport[0]['BreakCheck'] == 'Yes'){						
			$content .='<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["LO"].'</td>						
			<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["LI"].'</td>
			<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][0].'</td> 
			<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][0].'</td>';

			$content .='<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][1].'</td> 
			<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][1].'</td>';

			$content .='<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][2].'</td> 
			<td width="'.$tdwidth.'" >'.$arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][2].'</td>';
		} 


$pp='';
$DurationSecondShow='';
 
$DurationSecondActual = (!empty($values[$arrYDate[$dat2]]['DurationSecond']))?($values[$arrYDate[$dat2]]['DurationSecond']):(0);

if(!empty($values[$arrYDate[$dat2]]['InTime'])){ 
	$ApprovedHours=0; $CheckLeave=0;
	$EmpWorkingHourInSecond = ConvertToSecond($EmpWorkingHour);
	if($DurationSecondActual<$EmpWorkingHourInSecond){ 
		if($values['Exempt']==1){
			$DurationSecondActual = $EmpWorkingHourInSecond;
		}else if(!empty($values[$arrYDate[$dat2]]['OutTime'])){ 
			$CheckLeave=1;
		}
	} 

	$DurationSecondShowTemp = SecondToHrMinMain($DurationSecondActual);

	$DurationSecondShow = SecondToHrMin($DurationSecondActual);

	if($DurationSecondActual>0){
		$DurationSecondActual = ConvertToSecond($DurationSecondShowTemp);
	}
}else{
	$CheckLeave=1;
}



if($CheckLeave==1 && !in_array($DinNo, $WeekEndArry) && $arrYDate[$dat2]>=$values['JoiningDate']){ //not a weekend	
	$ApprovedLeave=$objLeave->checkLeaveHoliday($values['EmpID'],$arrYDate[$dat2]);	
	if($ApprovedLeave==1){
		$DurationSecondShow = $EmpWorkingHour;
		$ApprovedHours = ConvertToSecond($EmpWorkingHour); 
		$DurationSecondActual = 0;		 
	}
}



$DurPerDay = $DurationSecondActual+$ApprovedHours;
 
$OTPerDay = (!empty($values[$arrYDate[$dat2]]['OTHours']))?($values[$arrYDate[$dat2]]['OTHours']):(0);


//$SalaryPerDay = $values['HourRate']*(($DurPerDay)/3600);

$SalaryPerDay=($values['HourRate']*(($DurPerDay-$OTPerDay)/3600)) + ($values['HourRate']*$OvertimeRate*($OTPerDay/3600));
$SalaryMonthly+=$SalaryPerDay;

$DurationMonthly += $DurPerDay;

if($Overtime==1 && $values['Overtime']==1){	
	if($OTPerDay<0) $OTPerDay=0;
	$OTMonthly += $OTPerDay;
}


 /************/
$CommDaily=$CommPerDay=0;
if($CommissionFlag==1){
	$CommPerDay = (!empty($values[$arrYDate[$dat2]]['Commission']))?($values[$arrYDate[$dat2]]['Commission']):(0);
	$CommMonthly += $CommPerDay;
	$CommWeek += $CommPerDay;	
}
/************/



if($arryReport[0]['DurationCheck'] == 'Yes'){	
	$content .='<td width="'.$tdwidth.'" height="15">'.$DurationSecondShow.'</td>';
}


if($ShowDaily==1 && $Payroll==1){

	 /************/
	 if($CommissionFlag==1){
		$content .= '<td width="'.$tdwidth.'">';
		if($PayMethod=='H' && $EmpPayCycle=="Daily"){
			$CommDaily= $CommPerDay;
			if($CommDaily>0)$content .= number_format($CommDaily,2);
		}
		$content .= '</td>';
	 }
	 /************/

	$content .= '<td width="'.$tdwidth.'">';
	if($PayMethod=='H' && $EmpPayCycle=="Daily"){
		$SalaryDaily=$SalaryPerDay + $CommDaily;
		if($SalaryDaily>0)$content .= number_format($SalaryDaily,2);
	}			
	$content .= '</td>';
}

					
	$content .='</tr></table>';
	//}
	$content .='</td> ';   

	if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){ 
		$content .= '<td align="center"><strong>'.SecondToHrMin($DurationMonthly).'</strong></td>';
		if($Overtime==1){$content .= '<td align="center"><strong>'.SecondToHrMin($OTMonthly).'</strong></td>';}

		if($CommissionFlag==1){
			$SalaryMonthly += $CommMonthly;
			$CommMonthlyH = ($CommMonthly>0)?(number_format($CommMonthly,2)):('');
			$content .= '<td align="center"><strong>'.$CommMonthlyH.'</strong></td>';
		}

		if($Payroll==1){
			$content .= '<td align="center">';
			if($PayMethod=='H' && $SalaryMonthly>0)$content .= '<strong>'.number_format($SalaryMonthly,2).'</strong>';
			$content .= '</td>';	
		}
		$SalaryMonthly=0;
		$DurationMonthly=0;
		$OTMonthly=0;

		$CommMonthly=0;
		
	}

	if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){	
		$content .= '<td align="center"><strong>'.SecondToHrMin($DurationMonthly).'</strong></td>';
		if($Overtime==1){$content .= '<td align="center"><strong>'.SecondToHrMin($OTMonthly).'</strong></td>';}

		if($CommissionFlag==1){
			$SalaryMonthly += $CommMonthly;
			$CommMonthlyH = ($CommMonthly>0)?(number_format($CommMonthly,2)):('');
			$content .= '<td align="center"><strong>'.$CommMonthlyH.'</strong></td>';
		}

		if($Payroll==1){
			$content .= '<td align="center">';		
			if($PayMethod=='H' && $SalaryMonthly>0)$content .= '<strong>'.number_format($SalaryMonthly,2).'</strong>';
			$content .= '</td>';
		}
		$SalaryMonthly=0;
		$DurationMonthly=0;
		$OTMonthly=0;

		$CommMonthly=0;
	} 

	$ApprovedHoursWeek += $ApprovedHours;
				
	if($WeekEndNo==$DinNo){

		$DurationSecondWeek += $DurationSecondActual + $ApprovedHoursWeek;

		$OTHoursValWeek = (!empty($values[$arrYDate[$dat2]]['OTHours']))?($values[$arrYDate[$dat2]]['OTHours']):(0);
		$OTHoursWeek += $OTHoursValWeek;
	
		if($Overtime==1  && $values['Overtime']==1){
			
			if($values['OvertimePeriod']=='W'){				
				$OTSecondWeek = $DurationSecondWeek - ($values['OvertimeHourWeek']*3600);
				 
			}else{
				$OTSecondWeek = $OTHoursWeek;
			}
			if($OTSecondWeek<0) $OTSecondWeek=0;
			//echo $OTSecondWeek.'#';
		}

		 

		$CommWeekly='';
		 
		$SalaryWeekly='';
		$DurWeekly=SecondToHrMin($DurationSecondWeek);
		$OTWeekly=SecondToHrMin($OTSecondWeek);

		

		if($PayMethod=='H'){
			//$DurationSecondWeek.'#'.$AllowedSecondsInWeek;
			if($Overtime==1  && $values['Overtime']==1 && $OTSecondWeek>0){
				$SalaryWeek=($values['HourRate']*(($DurationSecondWeek-$OTSecondWeek)/3600)) + ($values['HourRate']*$OvertimeRate*($OTSecondWeek/3600));
			}else{
				if($DurationSecondWeek>$AllowedSecondsInWeek){
					$SalaryWeek= $values['HourRate']*($AllowedSecondsInWeek/3600);
				}else{
					$SalaryWeek= $values['HourRate']*($DurationSecondWeek/3600);
				}
			}
		
			


			if($EmpPayCycle=="Weekly"){	
				$SalaryWeek += $CommWeek;				
				$SalaryWeekly = ($SalaryWeek>0)?(number_format($SalaryWeek,2)):('');
	
				$CommWeekly = ($CommWeek>0)?(number_format($CommWeek,2)):('');
				$CommWeek=0;

			}else if($EmpPayCycle=="Bi-Weekly"){
				$SalaryWeek += $CommWeek;
				$SalaryBiWeekly += $SalaryWeek;
				$DurationBiWeekly += $DurationSecondWeek;
				//$OTBiWeekly += $OTSecondWeek;

				$CommBiWeekly += $CommWeek;
				$CommWeek=0;

				if($WeekNo%2==0){ 
					$SalaryWeekly = ($SalaryBiWeekly>0)?(number_format($SalaryBiWeekly,2)):('');
					$SalaryBiWeekly=0;


					$CommWeekly = ($CommBiWeekly>0)?(number_format($CommBiWeekly,2)):('');					
					$CommBiWeekly=0;


					$DurWeekly=SecondToHrMin($DurationBiWeekly);

					

					if($OTSecondWeek>0){				 

						$OTBiWeekly = $DurationBiWeekly - ($values['OvertimeHourWeek']*2*3600);
					 	if($OTBiWeekly<0) $OTBiWeekly=0; 
					}

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


		$content .= '<td class="head1" align="center">'.$DurWeekly.'</td>';
		if($Overtime==1){				
			 $content .= '<td class="head1" nowrap align="center">'.$OTWeekly.'</td>';		}
		if($ShowWeekly==1 && $CommissionFlag==1){			
			$content .= '<td class="head1" align="center">'.$CommWeekly.'</td>';
		}			
		if($ShowWeekly==1 && $Payroll==1){			
			$content .= '<td class="head1" align="center">'.$SalaryWeekly.'</td>';
		}

		$DurationSecondWeek = 0;		
		$OTHoursWeek = 0;
		$ApprovedHoursWeek = 0;
		 
		$WeekNo++;
	}else{ 
		$DurationSecondWeek += $DurationSecondActual;	

		$OTHoursVal = (!empty($values[$arrYDate[$dat2]]['OTHours']))?($values[$arrYDate[$dat2]]['OTHours']):(0);
	
		$OTHoursWeek += $OTHoursVal;	
		
	}
	/**************************/

      }
	
   $content .= '</tr>';
	

} 

}else{
	$content .='<tr >
<td  colspan="'.$headNum.'" class="no_record">'.NO_RECORD.'</td>
</tr>';
} 
  
 
 
$content .='</td>
  	</tr>
  </table>';

if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

//echo $content; exit;
?>
