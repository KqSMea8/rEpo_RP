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
		
	
<a href="applyLoan.php" class="add">Apply For Loan</a>

	
	
		
		</td>
 </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td  class="head1" >Amount (<?=$Config['Currency']?>) </td>
        <td width="12%"  class="head1">Period (Months)</td>
      <td width="15%"  class="head1">Apply Date</td>
       <td width="15%"  class="head1">Issue Date</td>
       <td width="14%"  class="head1">Interest Rate %</td>
       <td width="15%"  class="head1" >Amount to Deduct (<?=$Config['Currency']?>) </td>
        <td width="6%" align="center" class="head1" >Status</td>
        <td width="6%" align="center" class="head1" >Approved</td>
      <td width="3%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryLoan) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryLoan as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >

 

	<td>
	<? $LoanAmount = 0;
	if(!empty($values['Amount'])){
		echo (number_format($values['Amount']));
		$Rate = ($values['Amount'] * $values['Rate']) / 100;
		$LoanAmount = ($values['Amount'] + $Rate) / $values['ReturnPeriod'];
		$TotalLoanAmount += $LoanAmount;
	}else{
		echo '0';
	}
	?> </td>
	<td><?=$values['ReturnPeriod']?>  </td>
	 <td> <? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
	 <td> <? if($values["IssueDate"]>0) echo date($Config['DateFormat'], strtotime($values["IssueDate"])); ?></td>
	 <td><?=$values['Rate']?></td>
	 <td>
	<?=(!empty($LoanAmount))?(number_format($LoanAmount)):("0")?> 
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
	  
<a href="vLoan.php?view=<?=$values['LoanID']?>&curP=<?=$_GET['curP']?>" class="fancybox fancybox.iframe"><?=$view?></a>


</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryLoan)>0){?>
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