
<div class="had">Call Setting</div>
<div class="message"><? if(!empty($_SESSION['mess_call'])) {echo $_SESSION['mess_call']; unset($_SESSION['mess_call']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 <? if($num<$Config['NumLocation']){?>
	 <tr>
	<!--	<td align="right" ><a href="editLocation.php" class="add">Add Location</a></td> -->
	  </tr>
	  <? } ?>
	  
	<tr>
	  <td valign="top">
	  
	
	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
	
  
	<tr align="left"  >
		<td width="25%"class="head1" >Name</td>
		<td width="20%" class="head1" >Number of User</td>
		<td width="20%"  class="head1" >Server Name</td>
		<td width="20%"  class="head1" >Created Date</td>
		<td width="15%"  align="center" class="head1" >Action</td>
	</tr>
 
  <?php 
  $pagerLink=$objPager->getPager($callSetting,$RecordsPerPage,$_GET['curP']);
 (count($callSetting)>0)?($callSetting=$objPager->getPageRecords()):("");
  if(is_array($callSetting) && $num>0){
  	$flag=true;
  	foreach($callSetting as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td><?=stripslashes($values->group_name)?></td>
	<td>10</td>
	<td>Elastix</td>
	<td><?php echo $values->create_date; ?></td>
    <td  align="center" class="head1_inner">
	<a href="viewcallsetting.php?del_id=<?php echo $values->group_id;?>" onClick="return confDel('Group')" ><?=$delete?></a>	
	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="8" class="no_record">No result</td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="8" >Total Location : &nbsp;<?php echo $num;?>
  <!--
  <?php if(count($arryLocation)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;}?>
-->
</td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
