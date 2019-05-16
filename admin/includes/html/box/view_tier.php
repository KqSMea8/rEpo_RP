<?
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();

	$arryTier=$objCommon->getTier('','');
	$num=$objCommon->numRows();
?>

 <div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_tier'])) {echo '<div class="message">'.$_SESSION['mess_tier'].'</div>'; unset($_SESSION['mess_tier']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
<a href="editTier.php" class="add">Add Tier</a>
		
	  </td>
	  </tr>
	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Tier Name</td>
    <td width="30%" class="head1"> Commission Tier (<?=$Config['Currency']?>)</td>
    <td width="15%"class="head1"> Percentage </td>    
    <td width="10%" align="center" class="head1" >Status</td>
    <td width="10%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryTier) && $num>0){
  	$flag=true;
  	foreach($arryTier as $key=>$values){
	$flag=!$flag;
	
  ?>
  <tr align="left" >
	<td><?=stripslashes($values['tierName'])?></td>
	<td><?=$values['RangeFrom'].' - '.$values['RangeTo']?></td>
	<td><?=$values['Percentage']." %"?></td>
	<td align="center">
      <? 
	 if($values['Status'] ==1){
		  $status = 'Active';
	 }else{
		  $status = 'InActive';
	 }	 

	echo '<a href="editTier.php?active_id='.$values["tierID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	   
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="editTier.php?edit=<?php echo $values['tierID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

	<a href="editTier.php?del_id=<?php echo $values['tierID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Tier')" ><?=$delete?></a>	</td>
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
