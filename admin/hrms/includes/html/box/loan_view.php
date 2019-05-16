


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryLoan[0]['EmpID']?>"><?=stripslashes($arryLoan[0]['UserName'])?></a>   
					<br>[<?=stripslashes($arryLoan[0]['JobTitle']).' - '.stripslashes($arryLoan[0]['Department'])?>]

	</td>
</tr>

  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Loan Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=(!empty($arryLoan[0]['Amount']))?(round($arryLoan[0]['Amount'],2)):("0")?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>

     <tr>
		  <td  class="blackbold" valign="top"   align="right" >Interest Rate :</td>
		  <td  align="left"   class="blacknormal" valign="top">
		<?=$arryLoan[0]['Rate']?> %
		  </td>
		</tr>
	  
<tr>
		  <td  class="blackbold" valign="top"   align="right" >Net Payable Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?
$Interest = ($arryLoan[0]['Amount']*$arryLoan[0]['Rate'])/100;
$NetPayableAmount = $arryLoan[0]['Amount']+$Interest;
echo $NetPayableAmount = round($NetPayableAmount,2);

?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>



   <? if($arryLoan[0]['IssueDate']>0){ ?>
        <tr>
          <td align="right"   class="blackbold" valign="top">Issue Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryLoan[0]['IssueDate']));
		?>
		   </td>
        </tr>
	<? } ?>

       <? if($arryLoan[0]['ReturnDate']>0){ ?>
        <tr>
          <td align="right"   class="blackbold" valign="top">Return Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryLoan[0]['ReturnDate']));
		?>
		   </td>
        </tr>
	<? } ?>      
 
       <tr>
        <td align="right"   class="blackbold" >Period  :</td>
        <td  align="left"  >
	<?=(!empty($arryLoan[0]['ReturnPeriod']))?($arryLoan[0]['ReturnPeriod']." Month(s)"):(NOT_SPECIFIED)?>

		</td>
      </tr>
	
	<tr>
        <td  align="right"   class="blackbold" >Amount Returned : </td>
        <td   align="left"  >

	<?=(!empty($arryLoan[0]['AmountReturned']))?(round($arryLoan[0]['AmountReturned'],2)):("0")?> <?=$Config['Currency']?>
  
       </td>
      </tr>


	<tr>
		<td  align="right"   class="blackbold" >Amount Due : </td>
		<td   align="left"  >
		<?
		$Rate = ($arryLoan[0]['Amount'] * $arryLoan[0]['Rate']) / 100;
		$LoanAmount = ($arryLoan[0]['Amount'] + $Rate);

		$AmountDue = $LoanAmount - $arryLoan[0]['AmountReturned'];
		?>

		<B><?=($AmountDue>0)?(round($AmountDue,2)):("0")?></B> <?=$Config['Currency']?>
  
	   </td>
	  </tr>




 <tr>
        <td align="right"   class="blackbold" valign="top">Comment :</td>
        <td  align="left"  >
	<?=(!empty($arryLoan[0]['Comment']))?(nl2br(stripslashes($arryLoan[0]['Comment']))):(NOT_SPECIFIED)?>

		</td>
      </tr>

   <tr>
          <td align="right"   class="blackbold" valign="top">Apply Date  :</td>
          <td  align="left" >
		<? if($arryLoan[0]['ApplyDate']>0) echo date($Config['DateFormat'], strtotime($arryLoan[0]['ApplyDate'])); ?>
		   
		   
		   </td>
        </tr>

<tr>
        <td  align="right" class="blackbold" >Approved  : </td>
        <td   align="left" >
	<? 
		 if($arryLoan[0]['Approved'] == '1'){
			 $ApprovedCls = 'green'; $ApprovedStatus = 'Yes';
		 }else{
			 $ApprovedCls = 'red'; $ApprovedStatus = 'No';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$ApprovedStatus.'</span>';
		?>	

       </td>
</tr>

<tr>
        <td  align="right" class="blackbold" >Status  : </td>
        <td   align="left">

	<? 
		 if($arryLoan[0]['Returned'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($arryLoan[0]['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryLoan[0]['Status'].'</span>';
		?>

       </td>
      </tr>



	  <? if(!empty($arryLoanReturn[0]['ReturnAmount'])){ ?>


	<tr>
        <td  align="right" valign="top" class="heading">Payment History  : </td>
        <td   align="left" class="heading">
	<?	
			foreach($arryLoanReturn as $key=>$values){  
				echo round($values["ReturnAmount"],2).' '.$Config['Currency'].' on '.date($Config['DateFormat'], strtotime($values['ReturnDate'])).'<br><br>';
			}
	   
	   ?>       

       </td>
      </tr>
<? } ?>
	
</table>	
  



