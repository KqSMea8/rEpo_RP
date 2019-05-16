<div class="had">Active Advance Summary</div>

<div id="ListingRecords">

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
	
<b><?=stripslashes($arryEmployeeDt[0]['UserName'])?> </b> [<?=stripslashes($arryEmployeeDt[0]['JobTitle']).' - '.stripslashes($arryEmployeeDt[0]['DepartmentName'])?>]
	
		
		</td>
 </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td  class="head1" >Principal Amount (<?=$Config['Currency']?>) </td>
        <td width="22%"  class="head1">Period (Months)</td>
       <td width="22%"  class="head1">Issue Date</td>
       <td width="22%"  class="head1" align="right">Amount to Deduct (<?=$Config['Currency']?>) </td>
    </tr>
   
    <?php 
  if(is_array($arryAdvance) && $num>0){
	$flag=true;
	$Line=0;
	$TotalAdvanceAmount=0;
	foreach($arryAdvance as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >

	<td>
	<? $AdvanceAmount = 0;
	if(!empty($values['Amount'])){
		echo (round($values['Amount'],2));
		$AdvanceAmount = $values['Amount'] / $values['ReturnPeriod'];
		$TotalAdvanceAmount += $AdvanceAmount;
	}else{
		echo '0';
	}
	?> </td>
	<td><?=$values['ReturnPeriod']?>  </td>
	 <td> <? if($values["IssueDate"]>0) echo date($Config['DateFormat'], strtotime($values["IssueDate"])); ?></td>
	 <td align="right">
	<?=(!empty($AdvanceAmount))?(round($AdvanceAmount,2)):("0")?> 
	 </td>
	
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager" align="right">
<?=(!empty($TotalAdvanceAmount))?("<b>Total Amount to Deduct: ".round($TotalAdvanceAmount,2)." ".$Config['Currency']."</b>"):(" ")?> 

  </td>
  </tr>
  </table>
  </div>
  

  
</form>

</td>
</tr>
</table>

</div>