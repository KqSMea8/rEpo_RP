


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryAdvance[0]['EmpID']?>"><?=stripslashes($arryAdvance[0]['UserName'])?></a>   
					<br>[<?=stripslashes($arryAdvance[0]['JobTitle']).' - '.stripslashes($arryAdvance[0]['Department'])?>]

	</td>
</tr>

  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=(!empty($arryAdvance[0]['Amount']))?(round($arryAdvance[0]['Amount'],2)):("0")?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>

   
	  <? if($arryAdvance[0]['IssueDate']>0){ ?>
        <tr>
          <td align="right"   class="blackbold" valign="top">Issue Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryAdvance[0]['IssueDate']));
		?>
		   </td>
        </tr>
	<? } ?>
         
 <tr>
	  <td  class="blackbold" valign="top" align="right" >Return Type :</td>
	  <td  align="left"   class="blacknormal" valign="top">
		 <?  echo ($arryAdvance[0]['ReturnType'] == 1)?(RETURN_ONE):(RETURN_INSTALLMENT); ?>
					  
		  </td>
		</tr>

     <? if($arryAdvance[0]['ReturnType'] == 1){ ?>
	    
	    <tr>
        <td align="right"   class="blackbold" >Return Date  :</td>
        <td  align="left"  >
		<? if($arryAdvance[0]['ReturnDate']>0) echo date($Config['DateFormat'], strtotime($arryAdvance[0]['ReturnDate'])); ?>

				</td>
      </tr>
	  <? }else{ ?>
       <tr>
        <td align="right"   class="blackbold" >Return Period  :</td>
        <td  align="left"  >
	<?=(!empty($arryAdvance[0]['ReturnPeriod']))?($arryAdvance[0]['ReturnPeriod']." Month(s)"):(NOT_SPECIFIED)?>

		</td>
      </tr>
	  <? } ?>
<tr>
        <td  align="right"   class="blackbold" >Amount Returned : </td>
        <td   align="left"  >

	<?=(!empty($arryAdvance[0]['AmountReturned']))?(round($arryAdvance[0]['AmountReturned'],2)):("0")?> <?=$Config['Currency']?>
  
       </td>
      </tr>

	<tr>
							<td  align="right"   class="blackbold" >Amount Due : </td>
							<td   align="left"  >
							<?
							$AmountDue = $arryAdvance[0]['Amount'] - $arryAdvance[0]['AmountReturned'];
							?>

							<B><?=($AmountDue>0)?(round($AmountDue,2)):("0")?></B> <?=$Config['Currency']?>
					  
						   </td>
						  </tr>




 <tr>
        <td align="right"   class="blackbold" valign="top">Comment :</td>
        <td  align="left"  >
	<?=(!empty($arryAdvance[0]['Comment']))?(nl2br(stripslashes($arryAdvance[0]['Comment']))):(NOT_SPECIFIED)?>

		</td>
      </tr>

   <tr>
          <td align="right"   class="blackbold" valign="top">Apply Date  :</td>
          <td  align="left" >
		<? if($arryAdvance[0]['ApplyDate']>0) echo date($Config['DateFormat'], strtotime($arryAdvance[0]['ApplyDate'])); ?>
		   
		   
		   </td>
        </tr>

<tr>
        <td  align="right" class="blackbold" >Approved  : </td>
        <td   align="left" >
	<? 
		 if($arryAdvance[0]['Approved'] == '1'){
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
		 if($arryAdvance[0]['Returned'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($arryAdvance[0]['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryAdvance[0]['Status'].'</span>';
		?>

       </td>
      </tr>



	  <? if(!empty($arryAdvanceReturn[0]['ReturnAmount'])){ ?>


	<tr>
        <td  align="right" valign="top" class="heading">Payment History  : </td>
        <td   align="left" class="heading">
	<?	
			foreach($arryAdvanceReturn as $key=>$values){  
				echo round($values["ReturnAmount"],2).' '.$Config['Currency'].' on '.date($Config['DateFormat'], strtotime($values['ReturnDate'])).'<br><br>';
			}
	   
	   ?>       

       </td>
      </tr>
<? } ?>
	
</table>	
  



