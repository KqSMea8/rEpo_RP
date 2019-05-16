<div style="float:right"><a class="fancybox" href="#holiday_div">Holiday List</a>&nbsp;&nbsp;</div>
<div class="had">Manage <?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_holiday'])) {echo $_SESSION['mess_holiday']; unset($_SESSION['mess_holiday']); }?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" ><a href="editHoliday.php" class="add">Add <?=$ModuleName?></a></td>
 </tr>
</table>
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td class="head1" >Holiday Name</td>
       <td width="20%"  class="head1" > Date</td>
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
    <tr align="left" >
      <td ><?=$values["heading"]?></td>
      <td > <? if($values["holidayDate"]>0) echo date($Config['DateFormat'], strtotime($values["holidayDate"])); ?></td>
    
    <td align="center"><? 
if($values['Status'] ==1){
 $status = 'Active';
}else{
 $status = 'InActive';
}
 

echo '<a href="editHoliday.php?active_id='.$values["holidayID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
?></td>
      <td  align="center"  ><a href="editHoliday.php?edit=<?php echo $values['holidayID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
<a href="editHoliday.php?del_id=<?php echo $values['holidayID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<?  //include("includes/html/box/holiday_list.php"); ?>
</div>	
</td>
</tr>
</table>

