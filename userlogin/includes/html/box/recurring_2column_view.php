 <tr>
		<td  align="right" class="blackbold">Entry Type  :</td>
		<td   align="left">
                 <?php if($arryRecurr[0]['EntryType'] == "recurring"){echo "Recurring";}else{ echo "One Time";}?>		 
		</td>
                <?php if($arryRecurr[0]['EntryType'] == "recurring"){?>  
                <td  align="right"   class="blackbold">Entry Date :</td>
		<td   align="left"><?=$arryRecurr[0]['EntryDate'];?></td>
                 <?php }?> 
	</tr>	

  <?php if($arryRecurr[0]['EntryType'] == "recurring"){?>	
    
        <tr>
		<td  align="right" class="blackbold">Interval :</td>
		<td  align="left" class="blacknormal">
                    <?php
                    if(!empty($arryRecurr[0]['EntryInterval']))
                    {
                        $EntryInterval = $arryRecurr[0]['EntryInterval'];
                    }else{
                        $EntryInterval = "Monthly";
                    }
                    
                    ?>
                    
		 <?=ucfirst($EntryInterval);?>

		</td>
                <?php if($arryRecurr[0]['EntryInterval'] == "yearly"){ ?>  
                <td  align="right" class="blackbold">Every :</td>
		<td  align="left" class="blacknormal">
                    <?php
                        $monthNum  = $arryRecurr[0]['EntryMonth'];
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('F'); // March
                        
                        ?>
                        <?=$monthName;?>
                     
		 

		</td>
                <?php } else {?>
                 <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php }?>
	 
	
	</tr>	
        
        
    <tr>
		<td  align="right" class="blackbold">Entry From :</td>
		<td  align="left" class="blacknormal">
                <?php  echo date($Config['DateFormat'], strtotime($arryRecurr[0]['EntryFrom']));?>
                 </td>
 
		<td  align="right"   class="blackbold">Entry To :</td>
		<td  align="left" class="blacknormal">
                <?php  echo date($Config['DateFormat'], strtotime($arryRecurr[0]['EntryTo']));?>
                </td>
	</tr>	
	
	
	<tr>
		
	</tr>	
  <?php }?>  