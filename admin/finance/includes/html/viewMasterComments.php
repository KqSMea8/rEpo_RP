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


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" ><a href="editMasterComments.php"  class="add">Add <?=$ModuleName?></a></td>
 </tr>
</table>
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td width="10%" class="head1" >Assign To</td>
      <td class="head1" >Comments</td>
       <td width="10%" class="head1" >Added By</td>
       <td width="10%" class="head1" >Comment Date</td>
      <td width="10%" class="head1" >View Type</td>
      <td width="10%"  class="head1" align="center">Status</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryComments) && $num>0){ 
	$flag=true;
	$Line=0;
	foreach($arryComments as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><?=stripslashes($values["module_type"])?></td>
      <td ><?=stripslashes($values["comment"])?></td>
      <td ><?=(!empty($values['UserName'])) ? stripslashes($values["UserName"]) : stripslashes($values["commented_by"])?></td>
      <td ><?=date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values["comment_date"]))?></td>
      <td ><?=stripslashes($values["view_type"])?></td>
    <td align="center"><? 
if($values['status'] ==1){
 $status = 'Active';
}else{
 $status = 'InActive';
}
 
/*if($values['value_id'] ==18 || $values['value_id'] ==19){
echo "<span style='color:green;'>".$status."</span>";
}else{*/
echo '<a href="editMasterComments.php?active_id='.$values["MasterCommentID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
//}
?></td>
      <td  align="center"  >
 <?php /*if($values['value_id'] ==18 || $values['value_id'] ==19){
echo "<span style='color:red;'>Restricted</span>";
}else{*/?>
<a href="editMasterComments.php?edit=<?php echo $values['MasterCommentID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
<a href="editMasterComments.php?del_id=<?php echo $values['MasterCommentID'];?>&amp;curP=<?php echo $_GET['curP'];?> " onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  
<? //}?> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</div>	
</td>
</tr>
</table>
