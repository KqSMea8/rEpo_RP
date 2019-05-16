
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryExpenseClaim[0]['EmpID']?>"><?=stripslashes($arryExpenseClaim[0]['UserName'])?></a>   
					<br>[<?=stripslashes($arryExpenseClaim[0]['JobTitle']).' - '.stripslashes($arryExpenseClaim[0]['Department'])?>]

	</td>
</tr>

 <tr>
	  <td  class="blackbold" valign="top"   align="right" >Expense Reason :</td>
	  <td  align="left"   class="blacknormal" valign="top">
	<?=stripslashes($arryExpenseClaim[0]['ExpenseReason'])?>
	  </td>
	</tr>

  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Claim Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=(!empty($arryExpenseClaim[0]['ClaimAmount']))?(round($arryExpenseClaim[0]['ClaimAmount'],2)):("0")?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>

        <tr>
          <td align="right"   class="blackbold" valign="top">Expense Date  :</td>
          <td  align="left" >
	<?=($arryExpenseClaim[0]['ExpenseDate']>0)?(date($Config['DateFormat'], strtotime($arryExpenseClaim[0]['ExpenseDate']))):(NOT_SPECIFIED)?>

	
		   </td>
        </tr>
  
  <tr>
          <td align="right"   class="blackbold" valign="top">Apply Date  :</td>
          <td  align="left" >
		<? if($arryExpenseClaim[0]['ApplyDate']>0) echo date($Config['DateFormat'], strtotime($arryExpenseClaim[0]['ApplyDate'])); ?>
	   
		   </td>
        </tr>	
  
<tr>
                    <td  class="blackbold" valign="top"   align="right"> Attached Bill :</td>
                    <td  align="left"   class="blacknormal" valign="top">			
					
			 <? 
			  $document = stripslashes($arryExpenseClaim[0]['document']);
                          $MainDir = "upload/document/".$_SESSION['CmpID']."/";
			 if($document !='' && file_exists($MainDir.$document) ){ ?>			
			
<div  id="DocDiv" >	
	<?=$document?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$document?>" class="download">Download</a> 
</div>			
		 <? }else{ echo NOT_UPLOADED;}?>	
					
					 
                  				</td>
                  </tr>



   <? if($arryExpenseClaim[0]['IssueDate']>0){ ?>
  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Sanctioned Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=(!empty($arryExpenseClaim[0]['SancAmount']))?(round($arryExpenseClaim[0]['SancAmount'],2)):("0")?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>      
		
		<tr>
          <td align="right"   class="blackbold" valign="top">Sanctioned Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryExpenseClaim[0]['IssueDate']));
		?>
		   </td>
        </tr>
	<? } ?>

  

 <tr>
        <td align="right"   class="blackbold" valign="top">Comment :</td>
        <td  align="left"  >
	<?=(!empty($arryExpenseClaim[0]['Comment']))?(nl2br(stripslashes($arryExpenseClaim[0]['Comment']))):(NOT_SPECIFIED)?>

		</td>
      </tr>

 

<tr>
        <td  align="right" class="blackbold" >Approved  : </td>
        <td   align="left" >
	<? 
		 if($arryExpenseClaim[0]['Approved'] == '1'){
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
		 if($arryExpenseClaim[0]['Returned'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($arryExpenseClaim[0]['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryExpenseClaim[0]['Status'].'</span>';
		?>

       </td>
      </tr>

</table>	
  



