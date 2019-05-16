 <script>
$(function() {
	$( "#holiday_div" ).dialog({
		autoOpen: false,  width: 550
	});
	$( "#opener" ).click(function() {
		$( "#holiday_div" ).dialog( "open" );
	});
});
</script>
<div id="holiday_div" style="display:none;width:700px;border:none;background:none" title="Work Shift" >
<div class="had2">Work Shift</div>
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Shift Name</td>
    <td width="15%" class="head1" > Working Hour Start </td>
    <td width="15%"class="head1" >Working Hour End</td>
     <td width="15%" class="head1" >Duration</td>
    <td width="15%" class="head1" > Short Leave for Late Coming </td>
    <td width="15%"class="head1" >Short Leave for Early Leaving</td>
  </tr>
  <?php 
  if(is_array($arryShift) && $numShift>0){
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
  </tr>
  <?php } // foreach end //?>
   
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager"></td>
  </tr>
</table>
</div>

