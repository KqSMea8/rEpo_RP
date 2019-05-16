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
	  

<br>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>

 <? if($num>0){ ?>
 <br>
<form action="" method="get" name="reportForm" >
 <div class="cb"></div>

<!--input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Delete" onclick="javascript: return ValidateMultiple('attendance record','delete','NumField','attID');"-->
<? } ?>



<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
    <tr align="left"  >
<? if(!empty($_GET['CustomReport'])){

for ($j = 0; $j <= sizeof($reportHeader); $j++) {
echo '<td class="head1" >'.$reportHeader[$j][0].'</td>';
}
  }else{

$num =8;
?>

	<td class="head1" >Employee</td>
	<td width="20%" class="head1" >Date</td>
	<td width="8%"  class="head1" >In Time</td>
	<td width="10%"  class="head1">In Time Comment</td>
	<td  width="10%" class="head1" >Out Time</td>
	<td width="10%" class="head1" >Out Time Comment</td>
	<td width="12%" class="head1" >Duration</td>
	<td width="4%" align="center" class="head1" >Breaks</td>
<? }?>
      <!--td width="4%"  align="center" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','attID','<?=sizeof($arryAttendence)?>');" />
	  </td-->
    </tr>
   
    <?php 
  if(is_array($arryAttendence) && $num>0){
	$flag=true;
	$Line=0; $TotalDuration = 0;
	foreach($arryAttendence as $key=>$values){
	$flag=!$flag;
	$Line++;
	$Duration = 0;
	if(!empty($values["InTime"]) && !empty($values["OutTime"])){
		$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);
		
	}

	$incolor = ''; $outcolor ='';
	/*
	if(!empty($values["InComment"])) $incolor = '#ffff11';
	if(!empty($values["OutComment"])) $outcolor = '#ffff11';
*/
		$bgclass = (!$flag)?("oddbg"):("evenbg");

  ?>


		<? if($NewEmpID != $values['EmpID'] && empty($_GET['CustomReport'])){ ?>
		 <tr class="evenbg">
		  <td  colspan="9" >
		 
		  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values["EmpCode"]?></strong></a> 
		<? echo '<br><strong>'.$values['UserName'].'<br>'.stripslashes($values['JobTitle']).' - '.stripslashes($values['Department']).'</strong>'; ?>
	
		  </td>
		</tr>
		<? } ?>

    <tr align="left" class="<?=$bgclass?>">
        

<? if(!empty($_GET['CustomReport'])){
$num = Count($reportHeader);

for ($i = 0; $i <= sizeof($reportHeader); $i++) {

	if($reportHeader[$i][1] == "UserName"){?>


		<td  >

		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values['UserName']?></strong></a> 


		</td>

	<?}elseif($reportHeader[$i][1] == "attDate"){
		echo '<td>'.$values[$reportHeader[$i][1]].'</td>';
	}elseif($reportHeader[$i][1] == "InTime"){?>
		<td>
		<? if(!empty($values[$reportHeader[$i][1]])){ echo $values[$reportHeader[$i][1]]; }?>
		</td>
	<? }elseif($reportHeader[$i][1] == "OutTime"){?>
		<td>
		<? if(!empty($values[$reportHeader[$i][1]])) { echo $values[$reportHeader[$i][1]]; }?>
		</td>
	<? }elseif($reportHeader[$i][1] == "breaks"){
		$arryBreak=$objTime->getAttPunching($values['attID'],'','');?>
<td ><table ><tr> 



 <td><? foreach($arryBreak as $key=>$values){?><b><?=$values["punchType"]?></b> - <? if(!empty($values["InTime"])) echo $values["InTime"]; ?> <strong>|</strong> <? if(!empty($values["OutTime"])) echo $values["OutTime"];?><br><? }?> </td></tr></table></td>
	     <? // echo '<td><a class="fancybox fancybig fancybox.iframe" href="vAttBreak.php?att='.$values['attID'].'&emp='.$values['EmpID'].'" >'.$view.'</a></td>';
	 }elseif($reportHeader[$i][1] == "Duration"){

		echo '<td>'.$Duration.'</td>';
	}else{
		echo '<td>'.$values[$reportHeader[$i][1]].'</td>';
	}
}
  }else{?>  
 <td>
	   </td> 
      <td><?=date($Config['DateFormat'].", l",strtotime($values["attDate"]))?></td>
       <td><? if(!empty($values["InTime"])) echo date($Config['TimeFormat'],strtotime($values["InTime"])); ?></td>

      <td bgcolor="<?=$incolor?>"><?=stripslashes($values["InComment"])?></td>
        <td><? if(!empty($values["OutTime"])) echo date($Config['TimeFormat'],strtotime($values["OutTime"]));?></td>
      <td bgcolor="<?=$outcolor?>"><?=stripslashes($values["OutComment"])?></td>
      <td><?=($Duration!=0)?($Duration):('')?></td>
	<td align="center"><a class="fancybox fancybig fancybox.iframe" href="vAttBreak.php?att=<?=$values['attID']?>&emp=<?=$values['EmpID']?>" ><?=$view?></a></td>
     
<? }?>
    </tr>
	

    <?php 
	  $NewEmpID = $values['EmpID'];
  } // foreach end //?>
  
    <?php }else{?>
    <tr >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="12" align="left" id="td_pager">
 
 <? if($_GET['emp']>0 && $TotalDuration>0){ ?>
	<div align="right"><strong> Total Duration : <?=time_diff_total($TotalDuration)?>&nbsp;&nbsp;&nbsp;&nbsp;  </strong></div>
<? }else{ ?>
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAttendence)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
<? } ?>
 
</td>
  </tr>
  </table>
  <? } ?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?=$_GET['curP']?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">


</form>

</td>
</tr>
</table>

</div>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>

<? //include("includes/html/box/att_detail.php"); ?>
