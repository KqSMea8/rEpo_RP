 <div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_cat'])) {echo $_SESSION['mess_cat']; unset($_SESSION['mess_cat']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td>
	<a href="editEmpCategory.php"  class="add">Add <?=$ModuleName?></a>
	


		</td>
      </tr>
<tr>
 <td  valign="top">

<div id="ListingRecords">




 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td class="head1" >Category</td>
      <td width="10%"  class="head1" align="center">Status</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCategory) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryCategory as $key=>$values){
	$flag=!$flag;
	 
	$Line++;
  ?>
    <tr align="left"  >
      <td ><?=stripslashes($values["catName"])?></td>
     
    <td align="center"><? 
if($values['Status'] ==1){
 $status = 'Active';
}else{
 $status = 'InActive';
}
 

echo '<a href="editEmpCategory.php?active_id='.$values["catID"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
?></td>
      <td  align="center"  class="head1_inner" ><a href="editEmpCategory.php?edit=<?php echo $values['catID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
<? if($values['catID']>4){?>
<a href="editEmpCategory.php?del_id=<?php echo $values['catID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
<? } ?>

  </td>
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



</div>	
</td>
</tr>
</table>






