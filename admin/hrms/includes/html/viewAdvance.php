<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_dec'])) {echo '<div class="message" align="center">'.$_SESSION['mess_dec'].'</div>'; unset($_SESSION['mess_dec']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
		
	
<a href="editAdvance.php" class="add">Add Advance</a>

<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_advance.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<? if($_GET['sc']!='') {?>
  <a href="viewAdvance.php" class="grey_bt">View All</a>
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
       <td width="12%"  class="head1" >Amount (<?=$Config['Currency']?>) </td>
       <td width="12%"  class="head1">Apply Date</td>
       <td width="20%"  class="head1" >Amount Returned (<?=$Config['Currency']?>) </td>
        <td width="9%" align="center" class="head1" >Status</td>
        <td width="6%" align="center" class="head1" >Approved</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAdvance) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryAdvance as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpCode"]?></a>
	  <br><?=stripslashes($values['UserName'])?> - <?=stripslashes($values["Department"])?>
	  
	  
	  
	  </td>
 

	<td><?=(!empty($values['Amount']))?(round($values['Amount'],2)):("0")?> </td>
	 <td> <? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
	 <td>
	<?=(!empty($values['AmountReturned']))?(round($values['AmountReturned'],2)):("0")?> 
	 </td>
	 <td align="center">	 
		<? 
		 if($values['Returned'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($values['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		?>	 
	 </td>

	 <td align="center">	 
		<? 
		 if($values['Approved'] == '1'){
			 $ApprovedCls = 'green'; $ApprovedStatus = 'Yes';
		 }else{
			 $ApprovedCls = 'red'; $ApprovedStatus = 'No';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$ApprovedStatus.'</span>';
		?>	 
	 </td>

      <td  align="center" class="head1_inner">
	  
<a href="vAdvance.php?view=<?=$values['AdvID']?>&curP=<?=$_GET['curP']?>" class="fancybox fancybox.iframe" ><?=$view?></a>

<? if(empty($values['Approved'])){?> 
<a href="editAdvance.php?edit=<?=$values['AdvID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
<? } ?>

<a href="editAdvance.php?del_id=<?=$values['AdvID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  

<? if($values['Returned'] != '1' && $values['Approved'] == '1'){?>
<br><a href="editAdvance.php?edit=<?=$values['AdvID']?>&curP=<?=$_GET['curP']?>" >Return</a>
<? } ?>

</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryAdvance)>0){?>
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
