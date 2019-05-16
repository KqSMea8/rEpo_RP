<script language="JavaScript1.2" type="text/javascript">

	
	function report(id){	     
          location.href = "viewCustomReport.php?CustomReport=" + id ;
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
	<form action="" method="get" name="topForm" >
	<tr>
		<td  colspan="2"  valign="top">
		 
	 <table border="0" cellpadding="3" cellspacing="0" >
	<tr>
		<td width="70" align="right">Report: </td>
		<td >
		<select class="inputbox" name="CustomReport" id="CustomReport" onchange="return  report(this.value);"><option value="">Select Report</option>
<? foreach($arryCustomReport as $report){

$sel = ($report['reportID'] == $_GET['CustomReport'])?("selected"):("");

echo '<option value="'.$report['reportID'].'" '.$sel.'>'.$report['title'].'</option>';
}?>


</select>

		</td>
	
	
		
		</tr>
	 </table>

	</td>
		</tr>
		</form>
		


	</table>  
	  

<div id="print_export" style="clear:both">


 <? if($num>0){ ?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_custom_att.php?<?=$QueryString?>';" />	

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
		$weekColspan = 2;
	}
	/******************/

	
	for ($j = 0; $j < $numHead; $j++) {
		echo '<td class="head1" nowrap >'.$reportHeader[$j][0].'</td>';		
	}
	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);
		echo '<td class="head1">'.date("m/d/Y",$strtotimeVal).' </td>';
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
	echo '<td class="head1" colspan="'.$numHead.'"> </td>';
			

	for($dat=0;$dat<$numDate;$dat++){
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
				
				echo '</tr>
			  </table>
			</td>';


		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);		
		if($WeekEndNo==$DinNo){
			echo '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
			if($Overtime==1){
				echo '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
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
	$OTHoursWeek = 0;
	$incolor = ''; $outcolor ='';
	$bgclass = (!$flag)?("oddbg"):("evenbg");

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





	   for($dat2=0;$dat2<$numDate;$dat2++){

?> 
		<td> 


		<? if(!empty($values[$arrYDate[$dat2]]['Intime'])){ ?>

<table style="margin:0"  width="100%"   cellpadding="0" cellspacing="1" id="myTable" >
<tr align="left" class="<?=$bgclass?>">
<td width="<?=$tdwidth?>" ><?=$values[$arrYDate[$dat2]]['Intime']?></td>
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
<? if($arryReport[0]['DurationCheck'] == 'Yes' ){?>
<td width="<?=$tdwidth?>" ><?=$values[$arrYDate[$dat2]]['Duration']?></td>
<? } ?>

		</tr>
		</table>
		<?}?>

		</td>       
		
	<?


		/**************************/
		$strtotimeVal = strtotime($arrYDate[$dat2]);
		$DinNo = date("w",$strtotimeVal);		
		if($WeekEndNo==$DinNo){
			$DurationSecondWeek += $values[$arrYDate[$dat2]]['DurationSecond'];
			$OTHoursWeek += $values[$arrYDate[$dat2]]['OTHours'];
			echo '<td class="head1" align="center">'.SecondToHrMin($DurationSecondWeek).'</td>';
			if($Overtime==1){
				if($values['OvertimePeriod']=='W'){
					$OTSecondWeek = $DurationSecondWeek - ($values['OvertimeHourWeek']*3600);
				}else{
					$OTSecondWeek = $OTHoursWeek;
				}
				if($OTSecondWeek<0) $OTSecondWeek=0;
				echo '<td class="head1" nowrap align="center">'.SecondToHrMin($OTSecondWeek).'</td>';
			}

			$DurationSecondWeek = 0;
			$OTHoursWeek = 0;
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


