<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_shift'])) {echo '<div class="message">'.$_SESSION['mess_shift'].'</div>'; unset($_SESSION['mess_shift']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
<a href="editShift.php" class="add">Add Shift</a>
		
	  </td>
	  </tr>
	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Shift Name</td>
    <td width="12%" class="head1" > Working Hour Start </td>
    <td width="12%"class="head1" >Working Hour End</td>
     <td width="10%" class="head1" >Duration</td>
    <td width="14%" class="head1" > Short Leave for Late Coming </td>
    <td width="14%"class="head1" >Short Leave for Early Leaving</td>
    <td width="8%" align="center" class="head1" >Status</td>
    <td width="8%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryShift) && $num>0){
  	$flag=true;
  	foreach($arryShift as $key=>$values){
	$flag=!$flag;
	$Duration =  strtotime($values['WorkingHourEnd']) - strtotime($values['WorkingHourStart']);
	$FinalDuration = time_diff($Duration);
  ?>
  <tr align="left" >
    <td><?=stripslashes($values['shiftName'])?></td>
    <td><?=stripslashes($values['WorkingHourStart'])?></td>
    <td><?=stripslashes($values['WorkingHourEnd'])?></td>
    <td><?=$FinalDuration?></td>
	<td><?=stripslashes($values['SL_Coming'])?></td>
	<td><?=stripslashes($values['SL_Leaving'])?></td>

    <td align="center">
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }	 

		echo '<a href="editShift.php?active_id='.$values["shiftID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	   
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="vShift.php?view=<?php echo $values['shiftID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$view?></a>

	<a href="editShift.php?edit=<?php echo $values['shiftID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>
	<? if(!$objCommon->isShiftEmployeeExist($values['shiftID'])){ ?>
	<a href="editShift.php?del_id=<?php echo $values['shiftID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Shift')" ><?=$delete?></a>	
	<? } ?>
</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryShift)>0){?>
&nbsp;&nbsp;&nbsp; <?php  
}?></td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
<? } ?>
