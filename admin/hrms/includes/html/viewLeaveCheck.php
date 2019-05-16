
 <div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_check'])) {echo '<div class="message">'.$_SESSION['mess_check'].'</div>'; unset($_SESSION['mess_check']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
<a href="editLeaveCheck.php" class="add">Add Check</a>
		
	  </td>
	  </tr>
	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Check Title</td>
    <td width="25%"class="head1"> Value </td>    
    <!--td width="20%" align="center" class="head1" >Status</td-->
    <td width="10%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryLeaveCheck) && $num>0){
  	$flag=true;
  	foreach($arryLeaveCheck as $key=>$values){
	$flag=!$flag;
	
  ?>
  <tr align="left" >
	<td><?=stripslashes($values['Heading'])?></td>
	<td><?=$values['Value']?></td>
	<!--td align="center">
      <? 
	 if($values['Status'] ==1){
		  $status = 'Active';
	 }else{
		  $status = 'InActive';
	 }	 

	echo '<a href="editLeaveCheck.php?active_id='.$values["checkID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	   
	 ?>    </td-->
    <td  align="center" class="head1_inner" >
	<a href="editLeaveCheck.php?edit=<?php echo $values['checkID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

	<a href="editLeaveCheck.php?del_id=<?php echo $values['checkID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Check')" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
