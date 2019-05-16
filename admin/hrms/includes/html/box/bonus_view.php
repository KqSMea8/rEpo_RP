


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryBonus[0]['EmpID']?>"><?=stripslashes($arryBonus[0]['UserName'])?></a>   
					<br>[<?=stripslashes($arryBonus[0]['JobTitle']).' - '.stripslashes($arryBonus[0]['Department'])?>]

	</td>
</tr>


<tr>
	  <td  class="blackbold" valign="top"   align="right" >Year :</td>
	  <td  align="left"   class="blacknormal" valign="top">
	  <?=$arryBonus[0]['Year']?>
	  </td>
	</tr>
	<tr>
	  <td  class="blackbold" valign="top"   align="right" >Month :</td>
	  <td  align="left"   class="blacknormal" valign="top">
	  <?=date('F', strtotime($arryBonus[0]['Year'].'-'.$arryBonus[0]['Month'].'-01'))?>
	  </td>
	</tr>


  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=(!empty($arryBonus[0]['Amount']))?(round($arryBonus[0]['Amount'],2)):("0")?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>

	  
   <? if($arryBonus[0]['IssueDate']>0){ ?>
        <tr>
          <td align="right"   class="blackbold" valign="top">Issue Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryBonus[0]['IssueDate']));
		?>
		   </td>
        </tr>
	<? } ?>


 <tr>
        <td align="right"   class="blackbold" valign="top">Comment :</td>
        <td  align="left"  >
	<?=(!empty($arryBonus[0]['Comment']))?(nl2br(stripslashes($arryBonus[0]['Comment']))):(NOT_SPECIFIED)?>

		</td>
      </tr>

 

<tr>
        <td  align="right" class="blackbold" >Approved  : </td>
        <td   align="left" >
	<? 
		 if($arryBonus[0]['Approved'] == '1'){
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
		 if($arryBonus[0]['Paid'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($arryBonus[0]['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryBonus[0]['Status'].'</span>';
		?>

       </td>
      </tr>
  
	
</table>	
  



