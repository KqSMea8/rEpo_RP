<?php  
	require_once($Prefix."classes/role.class.php");
	$ModuleName = "Role";
	$objRole=new role();
	
	$arryGroup=$objRole->ListRoleGroup('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objRole->numRows();

	$pagerLink=$objPager->getPager($arryGroup,$RecordsPerPage,$_GET['curP']);
	(count($arryGroup)>0)?($arryGroup=$objPager->getPageRecords()):("");
?>

<div class="had"><?=$MainModuleName?></div>
<div class="message"><? if(!empty($_SESSION['mess_group'])) {echo $_SESSION['mess_group']; unset($_SESSION['mess_group']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

		<tr>
        <td>
		<a href="editRoleGroup.php" class="add">Add Group</a>
	  
 


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
    <td width="12%"  align="center" class="head1 head1_action" >Action</td>
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
	

	echo '<a class="'.$status.'" href="editRoleGroup.php?active_id='.$values["GroupID"].'&curP='.$_GET["curP"].'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		
	 ?></td>
    
    <td align="center"  class="head1_inner" >
	<!--a href="vGroup.php?view=<?=$values['GroupID']?>"  class="fancybox fancybox.iframe"><?=$view?></a-->
	<a href="editRoleGroup.php?edit=<?=$values['GroupID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

	<a href="editRoleGroup.php?del_id=<?=$values['GroupID']?>&curP=<?=$_GET['curP']?>" onClick="return confirmDialog(this, 'Group')"><?=$delete?></a>	</td>
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

