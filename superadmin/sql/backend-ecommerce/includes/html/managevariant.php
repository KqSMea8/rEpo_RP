<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	document.getElementById("ListingRecords").style.display = 'none';
	document.topForm.submit();
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_var'])) {echo $_SESSION['mess_var']; unset($_SESSION['mess_var']); }?></div>


<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">

<? //if($_GET['att']>0){ 
    
    
    ?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" ><a href="addvariant.php"  class="add">Add Variant</a></td>
 </tr>
</table>
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td class="head1" >Variant Name</td>
      <td class="head1">Input Type</td>
      <td class="head1" align="center">Values Required</td>
      <td class="head1">Action</td>
    </tr>
   
            <?php 

          if(is_array($GetVariantList) && $num>0){
                $flag=true;
                $Line=0;
                foreach($GetVariantList as $key=>$values){
                $flag=!$flag;
                #$bgcolor=($flag)?("#FDFBFB"):("");
                $Line++;
          ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><?=$values["variant_name"]?></td>
       <td>
        <?=$values["field_name"]?>
    </td>
     
    <td align="center"><? 
                    if($values['required'] ==1){
                     $status = 'Yes';
                    }else{
                     $status = 'No';
                    }
                       //if($values['editable']==0 ) {

                                  echo $status;
                             // }else{


                    //echo '<a href="editAttribute.php?active_id='.$values["value_id"].'&curP='.$_GET["curP"].'&att='.$_GET["att"].'" class="'.$status.'">'.$status.'</a>';
                //}
                ?>
    </td>
   
      <td  align="center" class="head1_inner">
          
          <?php  //if($values['editable']==0 ) {
              
              //echo '<span style="color:red;">Restricted</span>';
          //}else{
?>        <a href="viewvariant.php?editVId=<?php echo $values['id'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$view?></a>
          <a href="addvariant.php?editVId=<?php echo $values['id'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
          <a href="addvariant.php?del_vid=<?php echo $values['id'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   
      </td>
    
          <? //}?>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
<tr>  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($GetVariantList) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<? //} ?>

</div>	
</td>
</tr>
</table>
<? echo '<script>SetInnerWidth();</script>'; ?>
