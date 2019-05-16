 <div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_filing'])) {echo '<div class="message">'.$_SESSION['mess_filing'].'</div>'; unset($_SESSION['mess_filing']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Filing Status Heading</td> 
    <td width="10%" align="center" class="head1" >Status</td>
    <td width="10%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryFiling) && $num>0){
  	$flag=true;
  	foreach($arryFiling as $key=>$values){
	$flag=!$flag;
	
  ?>
  <tr align="left" >
	<td><?=stripslashes($values['filingStatus'])?></td>
	<td align="center">
      <? 
	 if($values['Status'] ==1){
		  $status = 'Active';
	 }else{
		  $status = 'InActive';
	 }	 
	//if($values["filingID"]>3){
	echo '<a href="editFiling.php?active_id='.$values["filingID"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	/*}else{
		echo '<span class="green">'.$status.'</span>';
	}*/
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="editFiling.php?edit=<?php echo $values['filingID'];?>"><?=$edit?></a>
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
   
