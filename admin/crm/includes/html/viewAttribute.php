<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	document.getElementById("ListingRecords").style.display = 'none';
	document.topForm.submit();
}

</script>
<div class="had">Manage <?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_att'])) {echo $_SESSION['mess_att']; unset($_SESSION['mess_att']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">

<? if($_GET['att']>0){ ?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" ><a href="editAttribute.php?att=<?=$_GET['att']?>"  class="add">Add <?=$ModuleName?></a></td>
 </tr>
</table>
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td class="head1" ><?=$ModuleName?></td>
      <td width="10%"  class="head1" align="center">Status</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAtt) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryAtt as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><?=$values["attribute_value"]?></td>
     
    <td align="center"><? 
if($values['Status'] ==1){
 $status = 'Active';
}else{
 $status = 'InActive';
}
 

echo '<a href="editAttribute.php?active_id='.$values["value_id"].'&curP='.$_GET["curP"].'&att='.$_GET["att"].'" class="'.$status.'">'.$status.'</a>';
?></td>
      <td  align="center"  >
	<?php if(!($values["attribute_value"]=='Zoom Meeting' || $values["attribute_value"]=='Zoom Webinar')) { ?>
<a href="editAttribute.php?edit=<?php echo $values['value_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&att=<?=$_GET['att']?>" ><?=$edit?></a>
 
<a href="editAttribute.php?del_id=<?php echo $values['value_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&att=<?=$_GET['att']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
  <?php }?>       
 </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="3" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="3" >Total Record(s) : &nbsp;<?php echo $num;?>  </td>
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
