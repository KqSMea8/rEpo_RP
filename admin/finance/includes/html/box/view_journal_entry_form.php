<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	<td align="left" class="head" colspan="4">General</td>
	</tr>	
	
<? 
$BankTransfer = $arryJournal[0]['BankTransfer']; 
if(!empty($BankTransfer)){ 
	$HideForBT = 'Style="display:none;"';	
	$ShowForBT = '';
	$BTLabel = 'Bank Transfer';
}else{
	$HideForBT = '';
	$ShowForBT = 'Style="display:none;"';
	$BTLabel = 'Journal Entry';
}
?>
	 <tr >
		<td  align="right"   class="blackbold" valign="top">Journal Type :</td>
		<td  align="left" valign="top"  >
		 <strong><?=$BTLabel?></strong> 
		</td>
	</tr>
	 	
	<tr>
		<td  align="right"   class="blackbold" width="20%">Journal Date  : </td>
		<td   align="left" width="30%">

		 <? if($arryJournal[0]['JournalDate']>0) 
			echo date($Config['DateFormat'], strtotime($arryJournal[0]['JournalDate']));
			?>
		</td>
	 
		<td  align="right" class="blackbold" width="20%">Journal No  : </td>
		<td   align="left"><b><?=$arryJournal[0]['JournalNo'];?></b></td>
	</tr>	  	
       <tr >
		<td  align="right" class="blackbold" <?=$HideForBT?>>Entry Type  :</td>
		<td   align="left" <?=$HideForBT?>>
		<?php if($arryJournal[0]['JournalType'] == "one_time"){echo "One Time";}else{echo "Recurring";}?>
		</td>
                
                <td  align="right" valign="top"  class="blackbold"> Memo  : </td>
	<td   align="left">
	
	 <?=(!empty($arryJournal[0]['JournalMemo']))?(stripslashes($arryJournal[0]['JournalMemo'])):(NOT_SPECIFIED)?>
	</td>
	</tr>	
<?php if($arryJournal[0]['JournalType'] == "recurring"){ ?>
        
      <tr>
		<td  align="right" class="blackbold">Interval :</td>
		<td  align="left" class="blacknormal">
                  <?php
                    if(!empty($arryJournal[0]['JournalInterval']))
                    {
                        $JournalInterval = $arryJournal[0]['JournalInterval'];
                    }else{
                        $JournalInterval = "Monthly";
                    }
                    
                    ?>
                    <?php if($JournalInterval == "semi_monthly"){ $JournalInterval = "Semi Monthly";  }?>
                    
                    <?=ucfirst($JournalInterval);?>
                </td>
                <?php if($arryJournal[0]['JournalType'] == "recurring" && $arryJournal[0]['JournalInterval'] != 'biweekly' && $arryJournal[0]['JournalInterval'] != 'semi_monthly'){?>   
		<td  align="right"  class="blackbold">Entry Date :</td>
		<td  align="left"><?=$arryJournal[0]['JournalStartDate']?></td>
                <?php }?>
	 
	
	</tr>	
        <?php if($arryJournal[0]['JournalInterval'] == "yearly"){ ?>
        <tr>
		<td  align="right" class="blackbold">Every :</td>
		<td  align="left" class="blacknormal">
                        <?php
                        $monthNum  = $arryJournal[0]['JournalMonth'];
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('F'); // March
                        
                        ?>
                        <?=$monthName;?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
	</tr>
        <?php }?>
        
         <?php if($arryJournal[0]['JournalInterval'] == "biweekly"){ ?>
        <tr>
		<td  align="right" class="blackbold">Every :</td>
		<td  align="left" class="blacknormal">
                       <?=$arryJournal[0]['EntryWeekly'];?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
	</tr>
        <?php }?>
        
    <tr>
		<td  align="right" class="blackbold">Entry From :</td>
		<td  align="left" class="blacknormal">
		 <? if($arryJournal[0]['JournalDateFrom']>0) 
			echo date($Config['DateFormat'], strtotime($arryJournal[0]['JournalDateFrom']));
			?>

		</td>
 
		<td  align="right"   class="blackbold">Entry To :</td>
		<td  align="left" class="blacknormal">
		  <? if($arryJournal[0]['JournalDateTo']>0) 
			echo date($Config['DateFormat'], strtotime($arryJournal[0]['JournalDateTo']));
		else echo "Infinite";


			?>


</td>
	</tr>	
	
	
	 	
	<?php }


if(empty($BankTransfer)){
?>
	
	 
	  <tr>

<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<? 
$HideRate = '';
if($arryJournal[0]['Currency']==$Config['Currency']){
	$HideRate = 'style="display:none;"';
}
 echo $arryJournal[0]['Currency'];
?>



</td>
<td  align="right"   class="blackbold" id="ConversionRateLabel" <?=$HideRate?>> Conversion Rate  : </td>
	<td   align="left" <?=$HideRate?>>
<?=$arryJournal[0]['ConversionRate']?>






</td>
 
      </tr>
<? } ?>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	

</table>	
  </td>
 </tr>


	 

	<tr>
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Details
 


</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/view_journal_record_row.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>

<tr>
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Attachment</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/view_journal_attachment.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>
  

</table>


