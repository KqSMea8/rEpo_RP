<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_Reim'])) {echo '<div class="message" align="center">'.$_SESSION['mess_Reim'].'</div>'; unset($_SESSION['mess_Reim']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
		
	
<a href="editReimbursement.php" class="add">Add <?=$ModuleName?></a>

<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_reimbursement.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<? if($_GET['sc']!='') {?>
  <a href="viewReimbursement.php" class="grey_bt">View All</a>
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
        <td width="14%"  class="head1">Expense Reason</td>
       <td width="12%"  class="head1">Apply Date</td>
       <td width="18%"  class="head1" >Approved Amount (<?=$Config['Currency']?>) </td>
       <td width="15%"  class="head1" >Total Amount (<?=$Config['Currency']?>) </td>
        <td width="9%" align="center" class="head1" >Payment Status</td>
        <td width="6%" align="center" class="head1" >Approved</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryReimbursement) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryReimbursement as $key=>$values){
	$flag=!$flag;
	$Line++;
	//echo "<pre>";print_r($values);
  ?>
    <tr align="left" >
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpCode"]?></a>
	  <br><?=stripslashes($values['UserName'])?> - <?=stripslashes($values["Department"])?>  
	  </td>
	<?php /*?><td><?=(!empty($values['TotalAmount']))?(round($values['ClaimAmount'],2)):("0")?> </td><?php */?>
	<td><?=stripslashes($values['ExReason'])?>  </td>
	<td><?=($values['ApplyDate']>0)?(date($Config['DateFormat'], strtotime($values['ApplyDate']))):(NOT_SPECIFIED)?>
	</td>
	<td><?=(!empty($values['SancAmount']))?(round($values['SancAmount'],2)):("0")?> </td>
    <td><?=(!empty($values['TotalAmount']))?($values['TotalAmount']):("0")?> </td>
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
	  
<a class="fancybox fancybox.iframe" href="vReimbursement.php?view=<?=$values['ReimID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>

<? if($values['Returned'] != '1' && $values['Approved'] != '2'){?>
<a href="editReimbursement.php?edit=<?=$values['ReimID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
<? } ?>

<a href="editReimbursement.php?del_id=<?=$values['ReimID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  


</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryReimbursement)>0){?>
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
