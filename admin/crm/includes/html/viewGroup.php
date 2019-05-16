

<div class="had"><?=$MainModuleName?></div>
<div class="message"><? if(!empty($_SESSION['mess_Group'])) {echo $_SESSION['mess_Group']; unset($_SESSION['mess_Group']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

		<tr>
        <td>
		<a href="editGroup.php" class="add">Add Group</a>
	  
<? if($_GET['key']!='') {?> <a href="viewGroup.php" class="grey_bt">View All</a><? }?>


		</td>
      </tr>
	
	<tr>
	  <td  valign="top">
  
	

	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td width="15%"  class="head1" >Group Name</td>
     <td  class="head1" >Description</td>
   
   <td width="12%" align="center" class="head1" >Status</td>
    <td width="12%"  align="center" class="head1" >Action</td>
  </tr>

  <?php 
  
 (count($arryGroup)>0)?($arryGroup=$objPager->getPageRecords()):("");
  if(is_array($arryGroup) && $num>0){
  	$flag=true;
  	foreach($arryGroup as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" valign="middle" >
    <td><?=stripslashes($values['group_name'])?></td>
    <td><?=stripslashes($values['description'])?></td>

 <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
			
		 }else{
			  $status = 'InActive';
			    
		 }
	
	 

	echo '<a class="'.$status.'" href="editGroup.php?active_id='.$values["GroupID"].'&curP='.$_GET["curP"].'" >'.$status.'</a>';
		
	 ?></td>
    
    <td align="center"  >
	<!--a href="vGroup.php?view=<?=$values['GroupID']?>"  class="fancybox fancybox.iframe"><?=$view?></a-->
	<a href="editGroup.php?edit=<?=$values['GroupID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

	<a href="editGroup.php?del_id=<?=$values['GroupID']?>&curP=<?=$_GET['curP']?>" onClick="return confirmDialog(this, 'Group')"><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="5" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryGroup)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
