<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	ShowHideLoader(1,'F');
	//document.getElementById("ListingRecords").style.display = 'none';
	document.topForm.submit();
}

</script>

<div class="had">Manage Education</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_ed'])) {echo $_SESSION['mess_ed']; unset($_SESSION['mess_ed']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

 <tr>
<td >
 <form name="topForm" action="viewEducation.php" method="get">	
 	<?  if(sizeof($arryAttribute)>0){ ?>	
<select name="ed" class="inputbox" id="ed" onChange="Javascript:ShowList();" style="width:250px;">
        <option value="">--- Select Attribute ---</option>
        <? for($i=0;$i<sizeof($arryAttribute);$i++) {?>
        <option value="<?=$arryAttribute[$i]['attribute_id']?>" <?  if($arryAttribute[$i]['attribute_id']==$_GET['ed']){echo "selected";}?>>
        <?=stripslashes($arryAttribute[$i]['attribute'])?>
        </option>
        <? } ?>
      </select>
      <? } ?> 
 </form>
</td>
</tr>


	<tr>
	  <td>
<? if($_GET['ed']>0){ ?> <a href="editEducation.php?ed=<?=$_GET['ed']?>" class="add">Add Attribute</a><? } ?>
	  </td>
	  </tr>

<tr>
 <td  valign="top">

<div id="ListingRecords">

<? if($_GET['ed']>0){ ?>
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td class="head1" >Attribute Value</td>
      <td width="10%"  class="head1" align="center">Status</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAtt) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryAtt as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >
      <td ><?=stripslashes($values["attribute_value"])?></td>
     
    <td align="center"><? 
if($values['Status'] ==1){
 $status = 'Active';
}else{
 $status = 'InActive';
}
 

echo '<a href="editEducation.php?active_id='.$values["value_id"].'&curP='.$_GET["curP"].'&ed='.$_GET["ed"].'" class="'.$status.'">'.$status.'</a>';
?></td>
      <td  align="center" class="head1_inner" ><a href="editEducation.php?edit=<?php echo $values['value_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&ed=<?=$_GET['ed']?>" ><?=$edit?></a>
 
<a href="editEducation.php?del_id=<?php echo $values['value_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&ed=<?=$_GET['ed']?>" onclick="return confirmDialog(this, 'Attribute')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="3" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="3" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<? } ?>

</div>	
</td>
</tr>
</table>
