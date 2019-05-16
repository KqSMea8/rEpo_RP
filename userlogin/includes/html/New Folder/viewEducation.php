<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	document.getElementById("ListingRecords").style.display = 'none';
	document.topForm.submit();
}

</script>
<div class="had">Manage Education</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_ed'])) {echo $_SESSION['mess_ed']; unset($_SESSION['mess_ed']); }?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

 <tr>
<td height="30">
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
 <td  valign="top">

<div id="ListingRecords">

<? if($_GET['ed']>0){ ?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" height="30"><a href="editEducation.php?ed=<?=$_GET['ed']?>" >Add Attribute</a></td>
 </tr>
</table>
 
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
 

echo '<a href="editEducation.php.php?active_id='.$values["value_id"].'&curP='.$_GET["curP"].'&ed='.$_GET["ed"].'" class="edit">'.$status.'</a>';
?></td>
      <td  align="center"  ><a href="editEducation.php?edit=<?php echo $values['value_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&ed=<?=$_GET['ed']?>" ><?=$edit?></a>
 
<a href="editEducation.php?del_id=<?php echo $values['value_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&ed=<?=$_GET['ed']?>" onclick="return confDel('Attribute')"  ><?=$delete?></a>   </td>
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