 <tr>
		<td  align="right" class="blackbold">Entry Type  :</td>
		<td   align="left">
                 <?php if($arryRecurr[0]['EntryType'] == "recurring"){echo "Recurring";}else{ echo "One Time";}?>		 
		</td>
	</tr>	

  <?php if($arryRecurr[0]['EntryType'] == "recurring"){?>	
    <tr>
		<td  align="right" class="blackbold">Entry From :</td>
		<td  align="left" class="blacknormal">
                <?php  echo date($Config['DateFormat'], strtotime($arryRecurr[0]['EntryFrom']));?>
                 </td>
	</tr>	

    <tr>
		<td  align="right"   class="blackbold">Entry To :</td>
		<td  align="left" class="blacknormal">
                <?php  echo date($Config['DateFormat'], strtotime($arryRecurr[0]['EntryTo']));?>
                </td>
	</tr>	
	
	
	<tr>
		<td  align="right"   class="blackbold">Entry Date :</td>
		<td   align="left"><?=$arryRecurr[0]['EntryDate'];?></td>
	</tr>	
  <?php }?>  