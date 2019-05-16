 <div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_period'])) {echo '<div class="message">'.$_SESSION['mess_period'].'</div>'; unset($_SESSION['mess_period']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Period Name</td> 
    <td width="10%" align="center" class="head1" >Status</td>
    <td width="10%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryPayPeriod) && $num>0){
  	$flag=true;
  	foreach($arryPayPeriod as $key=>$values){
	$flag=!$flag;
	
  ?>
  <tr align="left" >
	<td><?=stripslashes($values['periodName'])?></td>
	<td align="center">
      <? 
	 if($values['Status'] ==1){
		  $status = 'Active';
	 }else{
		  $status = 'InActive';
	 }	 
	//if($values["periodID"]>3){
	echo '<a href="editPayPeriod.php?active_id='.$values["periodID"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	/*}else{
		echo '<span class="green">'.$status.'</span>';
	}*/
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="editPayPeriod.php?edit=<?php echo $values['periodID'];?>"><?=$edit?></a>
</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="4" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="4" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
</table>
</div>

</form>
</td>
	</tr>
</table>
   
