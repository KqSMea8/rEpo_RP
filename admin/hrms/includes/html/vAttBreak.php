
<div class="had">Punching Breaks</div>

<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">
 
<? if(!empty($arryEmployee[0]['EmpID'])){ ?>
<tr>
	<td>

	<strong><?=$arryEmployee[0]["EmpCode"]?></strong>
	<? echo '<br>'.$arryEmployee[0]['UserName'].'<br>'.stripslashes($arryEmployee[0]['JobTitle']).' - '.stripslashes($arryEmployee[0]['Department']); ?>

	</td>
</tr>
<? } ?>


<? if(!empty($arryAttendence[0]['attDate'])){ ?>
<tr>
	<td>

	<strong><?=date($Config['DateFormat'].", l",strtotime($arryAttendence[0]["attDate"]))?></strong>


	</td>
</tr>
<? } ?>



<tr>
	  <td  valign="top">
       

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >



<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
      <tr align="left"  >
	<td class="head1" >Break Type</td>
	<td width="20%"  class="head1" >Out Time</td>
	<!--td width="20%"  class="head1">Out Time Comment</td-->
	<td  width="20%" class="head1" >In Time</td>
	<!--td width="20%" class="head1" >In Time Comment</td-->
	<td width="20%" class="head1" >Duration</td>
    </tr>
   
    <?php 

  if(is_array($arryBreak) && $num>0){
	$flag=true;
	$Line=0; $TotalDuration = 0;$BreakTime = 0;
	foreach($arryBreak as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	/*$Duration = 0;
	if(!empty($values["InTime"]) && !empty($values["OutTime"])){
		$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);
		
	}*/
	$incolor = ''; $outcolor ='';
	$bgclass = (!$flag)?("oddbg"):("evenbg");
	$Duration = getDurationFormat($values["TimeDuration"]);
	$BreakTime += ConvertToSecond($values['TimeDuration']);
  ?>

    <tr align="left" class="<?=$bgclass?>">
	<td><?=$values["punchType"]?> </td>
	<td><? if(!empty($values["InTime"])) echo date($Config['TimeFormat'],strtotime($values["InTime"])); ?></td>
	<!--td bgcolor="<?=$incolor?>"><?=stripslashes($values["InComment"])?></td-->
	 <td><? if(!empty($values["OutTime"])) echo date($Config['TimeFormat'],strtotime($values["OutTime"]));?></td>
	<!--td bgcolor="<?=$outcolor?>"><?=stripslashes($values["OutComment"])?></td-->
	<td>
<?=$Duration?>

</td>
    </tr>
	

    <?php 
	  
  } // foreach end //?>
  

 <tr >  <td  colspan="7" align="left" id="td_pager">
 
 <? if($BreakTime>0){ ?>
	<div align="right"><strong> Total Duration : <?=time_diff($BreakTime)?>&nbsp;&nbsp;&nbsp;&nbsp;  </strong></div>
<? } ?>
 
</td>
  </tr>



    <?php }else{?>
    <tr >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  

  </table>

  </div>
  

</form>

</td>
</tr>
</table>

</div>

