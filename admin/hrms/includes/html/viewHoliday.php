
<div class="had">Manage <?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_holiday'])) {echo $_SESSION['mess_holiday']; unset($_SESSION['mess_holiday']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td>
<!--a href="uploadHoliday.php" class="add" >Upload Holiday Sheet</a-->	<a href="editHoliday.php" class="add">Add <?=$ModuleName?></a>
	<a class="grey_bt fancybox" href="#holiday_div" >Holiday List</a>

	  </td>
	  </tr>
<tr>
 <td  valign="top">

<div id="ListingRecords">



 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td class="head1" >Holiday Name</td>
       <td width="30%"  class="head1" > Date</td>
	<td width="10%"  class="head1" align="center">Recurring</td>
     <td width="10%"  class="head1" align="center">Status</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryHoliday) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryHoliday as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left">
      <td ><?=stripslashes($values["heading"])?></td>
      <td > <? if($values["holidayDate"]>0) echo date("l, ".$Config['DateFormat'], strtotime($values["holidayDate"])); 

	if($values["holidayDate"]>0 &&  $values["holidayDateTo"]>0) echo ' - '. date("l, ".$Config['DateFormat'], strtotime($values["holidayDateTo"]));

?></td>
    
 <td align="center">
<?=($values['Recurring']==1)?"Yes":""?> 
 </td >
    <td align="center"><? 
if($values['Status'] ==1){
 $status = 'Active';
}else{
 $status = 'InActive';
}
 

echo '<a href="editHoliday.php?active_id='.$values["holidayID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
?></td>
      <td  align="center"  class="head1_inner"><a href="editHoliday.php?edit=<?php echo $values['holidayID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
<a href="editHoliday.php?del_id=<?php echo $values['holidayID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="5" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<?  include("includes/html/box/holiday_list.php"); ?>
</div>	
</td>
</tr>
</table>
