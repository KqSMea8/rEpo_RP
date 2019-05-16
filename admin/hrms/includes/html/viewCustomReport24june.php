<script language="JavaScript1.2" type="text/javascript">	
function ShowReport(){	 
	if(document.getElementById("CustomReport").value==""){
		alert("Please Select Custom Report.");
		document.getElementById("CustomReport").focus();
		return false;
	}

	var redUrl = "viewCustomReport.php?CustomReport="+document.getElementById("CustomReport").value;
	if(document.getElementById("shiftID") != null){
		if(document.getElementById("shiftID").value==""){
			alert("Please Select Work Shift.");
			document.getElementById("shiftID").focus();
			return false;
		}

		redUrl += "&shiftID="+document.getElementById("shiftID").value;
	}   
	location.href = redUrl;
	LoaderSearch();
}	
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message"><? if(!empty($_SESSION['mess_att'])) {echo $_SESSION['mess_att']; unset($_SESSION['mess_att']); }?></div>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">




 <tr>
	  <td  valign="top">

	  
	<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
	<form action="" method="get" name="topForm" onSubmit="return  ShowReport();">
	<tr>
		<td  colspan="2"  valign="top">
		 
	 <table border="0" cellpadding="3" cellspacing="0" >
	<tr>
		<td width="70" align="right">Report : </td>
		<td >
<select class="inputbox" name="CustomReport" id="CustomReport" ><option value="">Select Report</option>
<? foreach($arryCustomReport as $report){

$sel = ($report['reportID'] == $_GET['CustomReport'])?("selected"):("");

echo '<option value="'.$report['reportID'].'" '.$sel.'>'.$report['title'].'</option>';
}?>
</select>

		</td>
	
<? if(sizeof($arryShift)>0){?>

    <td  align="right"  width="70">Work Shift :</td>
    <td align="left">
	<select name="shiftID" class="inputbox" id="shiftID">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryShift);$i++) {?>
			<option value="<?=$arryShift[$i]['shiftID']?>" <?  if($arryShift[$i]['shiftID']==$_GET['shiftID']){echo "selected";}?>>
			<?=stripslashes($arryShift[$i]['shiftName'])?>
			</option>
		<? } ?>
	</select> 	</td>
	
<? } ?>


  <td align="left"><input name="s2" type="submit" class="search_button" value="Go"  /></td>
	
		
		</tr>
	 </table>

	</td>
		</tr>
		</form>
		


	</table>  
	  

<div id="print_export" style="clear:both">


 <? if($num>0 && $_GET['CustomReport']>0){ ?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_custom_report.php?<?=$QueryString?>';" />	

<? } ?>

</div>  
 <div class="cb"></div>

<br>
<? if(!empty($_GET['CustomReport'])){ ?>
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>

 <? if($num>0){ ?>
 <br>
<form action="" method="get" name="reportForm" >
 <div class="cb"></div>

<? } ?>



<script language="javascript" src="<?=$Prefix?>includes/jquery.doubleScroll.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.double-scroll').doubleScroll();
});
</script>


<div class="double-scroll" style="width:1080px;min-height:400px;">

<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
   <tr align="left"  >
	<? 
	/******************/
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

	
	for ($j = 0; $j < $numHead; $j++) {
		echo '<td class="head1" nowrap >'.$reportHeader[$j][0].'</td>';		
	}
	echo '<td class="head1" nowrap >Pay Cycle</td>';
	echo '<td class="head1" nowrap >Hourly Rate</td>';
		
	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);
		$Day = date("d",$strtotimeVal);
		echo '<td class="head1">'.date("m/d/Y",$strtotimeVal).'</td>';
		
		$monthColspan = $weekColspan+1;
		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
			echo '<td class="head1 red" colspan="'.$monthColspan.'" align="center" nowrap><strong>Semi-Month End</strong></td>';
		}
		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
			echo '<td class="head1 red" colspan="'.$monthColspan.'"  align="center" nowrap><strong>Month End</strong></td>';
		}

		if($WeekEndNo==$DinNo){
			echo '<td class="head1 red" colspan="'.$weekColspan.'" align="center" nowrap><strong>Week '.$WeekNo.'</strong></td>';
			$WeekNo++;
		}
		

	}
	
	$WeekNo = 1;
	?>
	</tr>

    <tr align="left" >

	<?	
	$numHeading=$numHead+2;
	echo '<td class="head1" colspan="'.$numHeading.'"> </td>';
			

	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);		
		$Day = date("d",$strtotimeVal);
		echo '<td class="head1">
			 <table style="margin:0" width="'.$width.'" cellpadding="0" cellspacing="1"    >
				<tr align="left" class="'.$bgclass.'">
					<td width="'.$tdwidth.'" >IN</td>
					<td width="'.$tdwidth.'" >OUT</td>
					';
					 if($arryReport[0]['BreakCheck'] == 'Yes'){
						echo '<td  width="'.$tdwidth.'">LO</td>
						<td width="'.$tdwidth.'">LI</td>
						<td width="'.$tdwidth.'" >SO</td>
						<td  width="'.$tdwidth.'">SI</td>';
						echo '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
						echo '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
					 }				
					 if($arryReport[0]['DurationCheck'] == 'Yes'){				
						echo '<td width="'.$tdwidth.'">Dur.</td>';
					 }
					 if($ShowDaily==1){
					    echo '<td width="'.$tdwidth.'">'.$Config['Currency'].'</td>';
					 }
						
					
				
				echo '</tr>
			  </table>
			</td>';



		

		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
			echo '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				echo '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
			}
			echo '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}
		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
			echo '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				echo '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
			}
			echo '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}

		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);		
		if($WeekEndNo==$DinNo){
			echo '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				echo '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
			}
			if($ShowWeekly==1){
			echo '<td class="head1" align="center" nowrap><strong>'.$Config['Currency'].'<strong></td>';
			}
		}



	}
		
 

?>

    </tr>
   
    <?php
	$tdwidth = 45;
	$headNum =  $numDate+ $numHead+1;
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
	
  ?>

    <tr align="left" class="<?=$bgclass?>">
        

<? 

for ($i = 0; $i < $numHead; $i++) {
	if($reportHeader[$i][1] == "UserName" ){?>
		<td nowrap>
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values['EmpName']?></strong></a>


		</td>

	<?}elseif($reportHeader[$i][1] == "EmpCode"){?>
		<td nowrap>
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values['EmpCode']?></strong></a> 
		</td>
	<? }else{?>
		<td nowrap>
		<? if(!empty($values[$reportHeader[$i][1]])){ echo $values[$reportHeader[$i][1]]; }?>
		</td>	
	<? }

 }

?>

<td nowrap><?=$EmpPayCycle?> </td>	
<td nowrap> <?=$values['HourRate']?></td>

<?

$WeekNo=1;
$SalaryMonthly=0;
$DurationMonthly=0;
$OTMonthly=0;
for($dat2=0;$dat2<$numDate;$dat2++){
	$ApprovedLeave=0; $ApprovedHours=0;

	$strtotimeVal = strtotime($arrYDate[$dat2]);
	$DinNo = date("w",$strtotimeVal);	
	
	$Day = date("d",$strtotimeVal);

	
?> 
		<td> 

		

<table style="margin:0"  width="100%"   cellpadding="0" cellspacing="1" id="myTable" >
<tr align="left" class="<?=$bgclass?>">

<? //if(!empty($values[$arrYDate[$dat2]]['Intime'])){ ?>

<td width="<?=$tdwidth?>" hieght="30"><?=$values[$arrYDate[$dat2]]['Intime']?>&nbsp;</td>
<td width="<?=$tdwidth?>" ><?=$values[$arrYDate[$dat2]]['OutTime']?></td>

 					
	<? if($arryReport[0]['BreakCheck'] == 'Yes'){?>
<td width="<?=$tdwidth?>" > <? echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["LO"];?></td>	
<td width="<?=$tdwidth?>" ><? echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["LI"]; ?></td>
<td width="<?=$tdwidth?>" ><?  echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][0]; ?></td> 			
<td width="<?=$tdwidth?>" > <? echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][0];?></td>

<td width="<?=$tdwidth?>" ><?  echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][1]; ?></td> 		
<td width="<?=$tdwidth?>" > <? echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][1];?></td>

<td width="<?=$tdwidth?>" ><?  echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SO"][2]; ?></td> 			
<td width="<?=$tdwidth?>" > <? echo $arryBreakList[$values['EmpID']][$arrYDate[$dat2]]["SI"][2];?></td>	
	<? }?>	
	


			
<? 
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


if($arryReport[0]['DurationCheck'] == 'Yes' ){?>
	<td width="<?=$tdwidth?>" >
	<? echo $DurationSecondShow; ?>
	</td>
<? } ?>


	<? if($ShowDaily==1){ ?>
	<td width="<?=$tdwidth?>" >
	<? 
	if($PayMethod=='H' && $EmpPayCycle=="Daily"){		
		if($SalaryPerDay>0)echo number_format($SalaryPerDay,2);
	}
	?>		
	</td>
	<?}?>


	


 <? //} ?>

		</tr>
		</table>
		

		</td> 

		<? 

		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){ 
			echo '<td align="center"><strong>'.SecondToHrMin($DurationMonthly).'</strong></td>';
			echo '<td align="center"><strong>'.SecondToHrMin($OTMonthly).'</strong></td>';
			echo '<td align="center">';
			if($PayMethod=='H' && $SalaryMonthly>0)echo '<strong>'.number_format($SalaryMonthly,2).'</strong>';
			$SalaryMonthly=0;
			$DurationMonthly=0;
			$OTMonthly=0;
			echo '</td>';
		}

		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){	
			echo '<td align="center"><strong>'.SecondToHrMin($DurationMonthly).'</strong></td>';
			echo '<td align="center"><strong>'.SecondToHrMin($OTMonthly).'</strong></td>';
			echo '<td align="center">';		
			if($PayMethod=='H' && $SalaryMonthly>0)echo '<strong>'.number_format($SalaryMonthly,2).'</strong>';
			$SalaryMonthly=0;
			$DurationMonthly=0;
			$OTMonthly=0;
			echo '</td>';
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












			echo '<td class="head1" align="center">'.$DurWeekly.'</td>';
			if($Overtime==1){				
				 echo '<td class="head1" nowrap align="center">'.$OTWeekly.'</td>';			}			
			if($ShowWeekly==1){
				echo '<td class="head1" align="center">'.$SalaryWeekly.'</td>';
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



?>
    </tr>
	

    <?php 
	  $NewEmpID = $values['EmpID'];
  } // foreach end //?>
  
    <?php }else{?>
    <tr >
      <td  colspan="<?=$headNum?>" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 
  </tr>
  </table>
  <? } ?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?=$_GET['curP']?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">


</form>

<? } ?>

</td>
</tr>
</table>
</div>

</div>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>


