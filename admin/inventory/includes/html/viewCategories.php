
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 <tr>
    <td  valign="top" >
		
	<? if($ParentID == 0){ 
				echo '<div class="had">&nbsp;Manage Categories</div>';
	}else{ ?>
			
		<div class="had">Manage Categories <?=$MainParentCategory?>  <strong><?=$ParentCategory?></strong></div>
			
	<?			
	} ?>		
		
		
		
	    </td>
  </tr>
	 <? if($ParentID > 0){  ?>
    <tr>

    <td align="right" height="30"><a href="viewCategories.php?curP=<?=$_GET['curP']?>&ParentID=<?=$BackParentID?>" class="Blue">Back</a></td>
  </tr>
<? } ?>
	
	<tr>
	  <td ><br>
	  <div class="message"><? if(!empty($_SESSION['mess_cat'])) {echo stripslashes($_SESSION['mess_cat']); unset($_SESSION['mess_cat']); }?></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="61%" height="32">&nbsp;</td>
    <td width="39%" align="right">
	<? if($LevelCategory>0){ ?>
	<a href="editCategory.php?ParentID=<?=$ParentID?>&curP=<?php echo $_GET['curP'];?>" class="Blue">Add <?=$cat_title?></a>
	<? } ?>
	</td>
  </tr>
 
</table>

<table <?=$table_bg?>>
        <tr align="left" >
          <td width="50%" height="20"  class="head1" >
              <?=$cat_title?>
            Name</td>
          <td  height="20" width="8%" class="head1" align="center">Status</td>
          <td width="38%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
        </tr>
        <?php 
  $pagerLink=$objPager->getPager($arryCategory,$RecordsPerPage,$_GET['curP']);
 (count($arryCategory)>0)?($arryCategory=$objPager->getPageRecords()):("");
  if(is_array($arryCategory) && $num>0){
  	$flag=true;
  	foreach($arryCategory as $key=>$values){
	$flag=!$flag;
		//$bgcolor=($flag)?(""):("#eeeeee");
	
	$arrySubCategory = $objCategory->GetSubCategoryByParent('',$values['CategoryID']);
	
  ?>
        <tr align="left"  bgcolor="<?=$bgcolor?>">
          <td height="26"  ><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td  >
	<? 

	if($LevelCategory<2){ 
		echo '<a href="viewCategories.php?ParentID='.$values[CategoryID].'" class="Blue"><b>'.stripslashes($values['Name']).'</b>&nbsp;</a><SPAN class="blacknormal">('.sizeof($arrySubCategory).')</SPAN>';
	}else{
		 echo stripslashes($values['Name']);
	 
	}
	 ?>                </td>
              </tr>
          </table></td>
          <td align="center" ><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editCategory.php?active_id='.$values["CategoryID"].'&ParentID='.$ParentID.'&curP='.$_GET["curP"].'" class="Blue">'.$status.'</a>';
		
	   
	 ?></td>
          <td height="26" align="right"  valign="top"><? if($ParentID == 0) { ?>
            <!-- <a href="editCategory.php?ParentID=<?php echo $values['CategoryID'];?>&curP=<?php echo $_GET['curP'];?>" class="Blue">Add SubCategory</a>-->
              <? } ?>
              <a href="editCategory.php?edit=<?php echo $values['CategoryID'];?>&ParentID=<?php echo $ParentID;?>&curP=<?php echo $_GET['curP'];?>" class="Blue"><?=$edit?></a>
			  <? if($LevelCategory>0){ ?>
			   <a href="editCategory.php?del_id=<?php echo $values['CategoryID'];?>&curP=<?php echo $_GET['curP'];?>&ParentID=<?php echo $ParentID;?>" onclick="return confDel('<?=$cat_title?>')" class="Blue" ><?=$delete?></a>
			  <? } ?> 
              <? if($values['NumSubcategory'] > 0 || $values['NumProducts']>0) { ?>
              <!--<a href="editCategory.php?delete_all=<?php echo $values['CategoryID'];?>&curP=<?php echo $_GET['curP'];?>&ParentID=<?php echo $ParentID;?>" onclick="return confirmDelete('<?=$DelMessage?>')" class="Blue" >Delete Completely</a>-->
              <? } ?>
            &nbsp;</td>
        </tr>
        <?php } // foreach end //?>
        <?php }else{?>
        <tr align="center" >
          <td height="20" colspan="4"  class="no_record">No <?=strtolower($cat_title)?> found. </td>
        </tr>
        <?php } ?>
		
		 <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCategory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
      </table></td>
	</tr>
	
	
</table>
