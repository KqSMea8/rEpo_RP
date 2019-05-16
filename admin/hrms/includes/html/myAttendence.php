<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(){	
		if(document.getElementById("dt").value==""){
			alert("Please Select Date.");
			return false;
		}
		ShowHideLoader(1,'F');
		
	}
	
	function ValidateSearch2(){

		if(document.getElementById("y").value==""){
			alert("Please Select Year.");
			document.getElementById("y").focus();
			return false;
		}
		if(document.getElementById("m").value==""){
			alert("Please Select Month.");
			document.getElementById("m").focus();
			return false;
		}
		ShowHideLoader(1,'F');

	}	



$(document).ready(function() {
		$(".add").fancybox({
			'width'         : 500
		 });

});


</script>


		


<div class="had">My Attendance</div>
<div class="message"><? if(!empty($_SESSION['mess_att'])) {echo $_SESSION['mess_att']; unset($_SESSION['mess_att']); }?></div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">

 <tr>
	  <td>
<!--a class="fancybox add" href="#punch_form_div" >Punch In/Out</a-->
		<a class="add fancybox fancybox.iframe" href="punching.php" >Punch In/Out</a>
	  </td>
 </tr>

  
 <tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td  class="head1" >Date</td>
  	<td width="8%" class="head1" >Shift Name</td>
	<td width="15%" class="head1" >Shift Hrs</td>
       <td width="10%"  class="head1" >In Time</td>
     <td width="13%"  class="head1">In Time Comment</td>
    <td  width="10%" class="head1" >Out Time</td>
     <td width="13%"  class="head1" >Out Time Comment</td>
      <td width="15%"  class="head1" >Duration</td>
    <td width="4%" align="center" class="head1" >Breaks</td>
    </tr>
   
    <?php 
$Config['NewTimeFormat'] = str_replace(":s","",$Config['TimeFormat']);

  if(is_array($arryAttendence) && $num>0){
	$flag=true;
	$Line=0; $TotalDuration = 0;
	foreach($arryAttendence as $key=>$values){
	$flag=!$flag;
	$Line++;
	$Duration = 0;
	$BreakTime = 0;
	$incolor = ''; $outcolor ='';	
	$bgclass = (!$flag)?("oddbg"):("evenbg");

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
	/*if(!empty($values["InTime"]) && !empty($values["OutTime"])){
		$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
		$TotalDuration += $Duration;
		$Duration = time_diff($Duration);
		
	}*/

	$ShiftHrs = '';
	if(!empty($values["WorkingHourStart"]) && !empty($values["WorkingHourEnd"])){
		$ShiftHrs = date($Config['NewTimeFormat'],strtotime($values["WorkingHourStart"])).' - '.date($Config['NewTimeFormat'],strtotime($values["WorkingHourEnd"]));
	}

	$Duration = ConvertToSecond($values["TimeDuration"]) - $BreakTime;
	if($Duration>0){$TotalDuration += $Duration; $Duration = time_diff($Duration);}
	
	

  ?>
    <tr align="left" >
	<td><?=date($Config['DateFormat'],strtotime($values["attDate"]))?></td>
	<td><?=stripslashes($values["shiftName"])?></td>
	<td><?=$ShiftHrs?></td>
	<td><? if(!empty($values["InTime"])) echo date($Config['TimeFormat'],strtotime($values["InTime"])); ?></td>
	<td><?=stripslashes($values["InComment"])?></td>
	<td><? if(!empty($values["OutTime"])) echo date($Config['TimeFormat'],strtotime($values["OutTime"]));?></td>
	<td><?=stripslashes($values["OutComment"])?></td>
	<td><?=($Duration>0)?($Duration):('')?></td>
	<td align="center"><a class="fancybox fancybig fancybox.iframe" href="vAttBreak.php?att=<?=$values['attID']?>&emp=<?=$values['EmpID']?>" ><?=$view?></a></td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="10" align="right" id="td_pager">
<? if(!empty($_GET['y']) && !empty($_GET['m']) && $TotalDuration>0 ){?>
<strong> Total Duration : <?=TotalTimeDiff($TotalDuration)?>  </strong>

<? } ?>
 
&nbsp;&nbsp;&nbsp;&nbsp;</td>
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


<?  #include("includes/html/box/punch_form.php"); ?>
