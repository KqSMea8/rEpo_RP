<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_request'])) {echo '<div class="message" align="center">'.$_SESSION['mess_request'].'</div>'; unset($_SESSION['mess_request']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
		
	
<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_request.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<? if($_GET['sc']!='') {?>
  <a href="viewRequest.php" class="grey_bt">View All</a>
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
       <td class="head1" >Employee</td>
       <td width="22%"  class="head1" >Subject </td>
       <td width="34%"  class="head1">Message</td>
       <td width="12%"  align="center" class="head1">Request Date</td>
       <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 

	$moveTo = '<img src="'.$Config['Url'].'admin/images/move.png" border="0"  onMouseover="ddrivetip(\'<center>'.MOVE_TO_ANNOUNCEMENT.'</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';




  if(is_array($arryRequest) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryRequest as $key=>$values){
	$flag=!$flag;
	$Line++;
	
$mLength = strlen(stripslashes($values['Message']));
if($mLength > 100)
{
 $Message = substr(stripslashes($values['Message']),0,100)."...";
}else{
 $Message = stripslashes($values['Message']);
}

$sLength = strlen(stripslashes($values['Subject']));

if($sLength > 50)
{
 $Subject = substr(stripslashes($values['Subject']),0,50)."...";
}else{
 $Subject = stripslashes($values['Subject']);
}

  ?>
    <tr align="left" >
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpCode"]?></a>
	  <br><?=stripslashes($values['UserName'])?> - <?=stripslashes($values["Department"])?>
	  </td>
	<td><?php echo stripslashes($Subject)?> </td>
	<td><?php echo $Message;?></td>
	<td align="center"> <? if($values["RequestDate"]>0) echo date($Config['DateFormat'], strtotime($values["RequestDate"])); ?></td>
    <td  align="center" class="head1_inner">
      <a class="fancybox fancybox.iframe" href="vRequest.php?view=<?=$values['RequestID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
     <a href="viewRequest.php?del_id=<?=$values['RequestID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
	 
		<? if($values['Moved']!=1){?>
		<a href="editRequest.php?req_id=<?=$values['RequestID']?>" ><?=$moveTo?></a> 
		<? } ?>

    </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryRequest)>0){?>
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