<div class="had">Active Loan Summary</div>

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
        <td width="18%"  class="head1">Period (Months)</td>
       <td width="18%"  class="head1">Issue Date</td>
       <td width="18%"  class="head1">Interest Rate %</td>
       <td width="18%"  class="head1" align="right">Amount to Deduct (<?=$Config['Currency']?>) </td>
    </tr>
   
    <?php 
  if(is_array($arryLoan) && $num>0){
	$flag=true;
	$Line=0;
	$TotalLoanAmount=0;
	foreach($arryLoan as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >

	<td>
	<? $LoanAmount = 0;
	if(!empty($values['Amount'])){
		echo (round($values['Amount'],2));
		$Rate = ($values['Amount'] * $values['Rate']) / 100;
		$LoanAmount = ($values['Amount'] + $Rate) / $values['ReturnPeriod'];
		$TotalLoanAmount += $LoanAmount;
	}else{
		echo '0';
	}
	?> </td>
	<td><?=$values['ReturnPeriod']?>  </td>
	 <td> <? if($values["IssueDate"]>0) echo date($Config['DateFormat'], strtotime($values["IssueDate"])); ?></td>
	 <td><?=$values['Rate']?>  </td>
	 <td align="right">
	<?=(!empty($LoanAmount))?(round($LoanAmount,2)):("0")?> 
	 </td>
	
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager" align="right">
<?=(!empty($TotalLoanAmount))?("<b>Total Amount to Deduct: ".round($TotalLoanAmount,2)." ".$Config['Currency']."</b>"):(" ")?> 

  </td>
  </tr>
  </table>
  </div>
  

  
</form>

</td>
</tr>
</table>

</div>