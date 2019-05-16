<?
	$ModuleName = "Notification";	
	$ListUrl = "viewNotification.php?curP=".$_GET['curP'];

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_alert'] = NOTIFICATION_REMOVED;
		$objConfigure->RemoveNotification($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}
	$arryNotification=$objConfigure->GetNotification('','');
	$num = sizeof($arryNotification);

	$pagerLink=$objPager->getPager($arryNotification,$RecordsPerPage,$_GET['curP']);
	(count($arryNotification)>0)?($arryNotification=$objPager->getPageRecords()):("");
?>

<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$ModuleName?></div>
<? if(!empty($_SESSION['mess_alert'])) {echo '<div class="message" align="center">'.$_SESSION['mess_alert'].'</div>'; unset($_SESSION['mess_alert']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
		
	
<? if($num>0){?>
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<? if($_GET['sc']!='') {?>
  <a href="viewNotification.php" class="grey_bt">View All</a>
<? }?>
	
	
		
		</td>
 </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td class="head1">Message</td>
       <td width="22%"  align="center" class="head1">Notification Date</td>
       <td width="5%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 

  if(is_array($arryNotification) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryNotification as $key=>$values){
		$flag=!$flag;
		$Line++;
		$Message = stripslashes($values['Message']);

		if($values['Read']==0)$objConfigure->ReadNotification($values['notifyID']);
  ?>
    <tr align="left" >
	<td><?=$Message?></td>
	<td align="center"> <? if($values["notifyDate"]>0) echo date($Config['DateFormat'].', h:i a', strtotime($values["notifyDate"])); ?></td>
    <td  align="center" class="head1_inner">
     <a href="viewNotification.php?del_id=<?=$values['notifyID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
    </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryNotification)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
  </td>
  </tr>
  </table>
  </div>
  
 
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</td>
</tr>
</table>

</div>
<? } ?>