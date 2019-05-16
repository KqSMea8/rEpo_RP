<?
	$arryHoliday=$objLeave->getHoliday('','1');
	$numHoliday=sizeof($arryHoliday);

?>
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
<div id="holiday_div" style="display:none;width:550px;border:none;background:none" title="Holiday List" >
<table <?=$table_bg?> >

<? if($numHoliday>0){ ?>
    <tr align="left"  >
       <td class="head1" >Holiday Name</td>
       <td class="head1" width="340">Holiday Date</td>

<?	foreach($arryHoliday as $key=>$values){	?>
<tr bgcolor="<?=$bgcolor?>">
	<td align="left"  height="30"><?=$values["heading"]?></td>
	<td align="left" ><? if($values["holidayDate"]>0) echo date("l, ".$Config['DateFormat'], strtotime($values["holidayDate"])); 

	if($values["holidayDate"]>0 &&  $values["holidayDateTo"]>0) echo ' - '. date("l, ".$Config['DateFormat'], strtotime($values["holidayDateTo"]));
?></td>
</tr>
<? } }else{ ?>
<tr>
	<td align="center" height="100" class="redmsg" bgcolor="#fff">
		<?=NO_HOLIDAY?>
	  </td>
</tr>
<? } ?>
</TABLE>
</div>

