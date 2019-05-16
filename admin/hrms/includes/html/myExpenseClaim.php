<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_claim'])) {echo '<div class="message" align="center">'.$_SESSION['mess_claim'].'</div>'; unset($_SESSION['mess_claim']); }?>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
		
	
<a href="applyExpenseClaim.php" class="add">Apply For Expense Claim</a>

	
	
		
		</td>
 </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
        <td width="14%"  class="head1" >Claim Amount (<?=$Config['Currency']?>) </td>
        <td class="head1">Expense Reason</td>
       <td width="12%"  class="head1">Expense Date</td>
       <td width="18%"  class="head1" >Sanctioned Amount (<?=$Config['Currency']?>) </td>
        <td width="10%" align="center" class="head1" >Status</td>
        <td width="8%" align="center" class="head1" >Approved</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryExpenseClaim) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryExpenseClaim as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >

 	<td><?=(!empty($values['ClaimAmount']))?(round($values['ClaimAmount'],2)):("0")?> </td>
	<td><?=stripslashes($values['ExpenseReason'])?>  </td>
	<td> <? if($values["ExpenseDate"]>0) echo date($Config['DateFormat'], strtotime($values["ExpenseDate"])); ?></td>
	<td><?=(!empty($values['SancAmount']))?(round($values['SancAmount'],2)):("0")?> </td>

	
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
	  
<a href="vExpenseClaim.php?view=<?=$values['ClaimID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>


</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="7" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryExpenseClaim)>0){?>
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
