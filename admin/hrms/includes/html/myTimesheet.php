<script language="JavaScript1.2" type="text/javascript">
	
	function SubmitWeek(frm){	
		if(document.getElementById("prv_msg_div")!=null){
				ShowHideLoader(1,'L');

		}
		document.form2.submit();
	}		
</script>



<div class="had">My Timesheet</div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">



  
 <tr>
	  <td  valign="top">
	
	<? if(sizeof($arryPeriod)>0){ ?>
	<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
	<tr>
		<td >
		
		  

	 <table  border="0" cellpadding="3" cellspacing="0" >
      <form action="" method="get" name="form2">
	    <tr >
		<td>Week : </td>
          <td>		  
			
	<select name="tmID" class="inputbox" id="tmID"  onChange="SubmitWeek(this);">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryPeriod);$i++) {?>
			<option value="<?=$arryPeriod[$i]['tmID']?>" <?  if($arryPeriod[$i]['tmID']==$_GET['tmID']){echo "selected";}?>>
			<?=$arryPeriod[$i]['FromDate']?> to <?=$arryPeriod[$i]['ToDate']?>
			</option>
		<? } ?>
	</select>
	
	  </td>
	
        </tr>
		</form>	
      </table>
	
		
		</td>
		
		
		
	</tr>	





	</table>  
	<? }else{ ?>
	<div align="center" style="padding:50px;"><?=NO_TIMESHEET_ADDED?></div>
	<? } ?>
	  
	  <div>
<a class="fancybox add" href="#timesheet_div" onclick="Javascript:ResetForm();" >Add Timesheet</a>
<br>
	  </div>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>
<br />
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td width="23%" class="head1" >Project</td>
       <td width="23%"  class="head1" >Activity</td>
	   <?
		$arryDate = explode("-",$FromDate);
		list($year, $month, $day) = $arryDate;
		for($i=1;$i<=7;$i++){
	    	$tomorrow  = mktime(0, 0, 0, $month , $day+$i-1, $year);
			echo '<td  width="7%" class="head1" align="center">'.date("D, d",$tomorrow).'</td>';
		}
	   ?>
    
      <td  class="head1" align="center" >Total</td>
    </tr>
   
    <?php 
  if(is_array($arryTimesheet) && $num>0){
	$flag=true;
	$Line=0;  $FinalHour=0;
	foreach($arryTimesheet as $key=>$values){
	$flag=!$flag;
	$Line++;
	 $Total=0; $Hour=0; $Minute=0;
  ?>
    <tr align="left"  >
      <td><?=stripslashes($values["Project"])?></td>
      <td><?=stripslashes($values["Activity"])?></td>
      <?
		for($i=1;$i<=7;$i++){
			echo '<td align="center">'.$values["Time".$i].'</td>';
			if(!empty($values["Time".$i])){
				$arryTime = explode(":",$values["Time".$i]);
				$Hour += $arryTime[0];
				$Minute += $arryTime[1];
				
				$arryHour[$i] += $arryTime[0];
				$arryMinute[$i] += $arryTime[1];
			}
			
		}
		
		if($Minute>=60){
			$rem = floor($Minute/60); $Minute = $Minute%60;
			$Hour += $rem;
		}
		if($Minute<10) $Minute = '0'.$Minute;
		$Total = $Hour.':'.$Minute;
		
		$FinalHour += $Hour; 
		$FinalMinute += $Minute;
		?>
      <td align="center"><strong><?=$Total?></strong></td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  
	<td  colspan="2" id="td_pager">
	<strong>Total</strong>
	</td>
	<?	
	for($i=1;$i<=7;$i++){ 
		$TotalTd=0;
		$HourTd = $arryHour[$i];
		$MinuteTd = $arryMinute[$i];
		
		if($MinuteTd>=60){
			$rem = floor($MinuteTd/60); $MinuteTd = $MinuteTd%60;
			$HourTd += $rem;
		}
		if($MinuteTd<10) $MinuteTd = '0'.$MinuteTd;
		if($HourTd>0 || $MinuteTd>0){
			$TotalTd = $HourTd.':'.$MinuteTd;
		}
		
		echo '<td align="center">'.$TotalTd.'</td>';
	}
	
	
	
	/******Calculating Final Duration **/
	if($FinalMinute>=60){
		$rem = floor($FinalMinute/60); $FinalMinute = $FinalMinute%60;
		$FinalHour += $rem;
	}
	if($FinalMinute<10) $FinalMinute = '0'.$FinalMinute;
	
	$FinalTotal = $FinalHour.':'.$FinalMinute;
	?>
	<td align="center"><strong><?=$FinalTotal?></strong></td>
  </tr>
  </table>
  <? } ?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</td>
</tr>
</table>

</div>


<?  include("includes/html/box/timesheet_form.php"); ?>