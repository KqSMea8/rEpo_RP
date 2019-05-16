<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	 
	<tr>
		<td  align="right" class="blackbold" width="20%">Payment Method : </td>
		<td   align="left" width="20%"> <?=$arryOtherIncome[0]['PaymentMethod'];?></td>
	
		<td  align="right" class="blackbold" width="20%">Type of Income : </td>
		<td  align="left" width="30%"> 
                            <?php

            $accountName = $objBankAccount->getBankAccountNameByID($arryOtherIncome[0]["IncomeTypeID"]);

            ?>
            <?=$accountName;?>
                </td>
	</tr>  
       <?php if($arryOtherIncome[0]['PaymentMethod'] == "Check") {?> 
        <tr>
            <td align="right"   class="blackbold">Bank Name :</td>
            <td align="left"><?=$arryOtherIncome[0]['CheckBankName'];?></td>
            
            <td align="right"   class="blackbold">Check Format : </td>
            <td align="left"><?=$arryOtherIncome[0]['CheckFormat'];?></td>
            
            
        </tr>
        <?php }?>
        
	<tr>
		<td  align="right"   class="blackbold">Payment Date  : </td>
		 
		<td align="left"><?=date($Config['DateFormat'], strtotime($arryOtherIncome[0]['PaymentDate']));	?></td>
	
	<td  align="right"   class="blackbold"  width="45%"> Paid To A/C : </td>
	<td   align="left" ><?=$arryOtherIncome[0]['AccountName'];?></td>
	</tr>	
	<?php if($arryOtherIncome[0]['Flag'] != 1) {?>
	 <tr>
        <td align="right"   class="blackbold"> Amount : </td>
        <td align="left"><?=number_format($arryOtherIncome[0]['Amount'],2,'.','');?>&nbsp;<?=$arryOtherIncome[0]['Currency'];?></td>
     </tr>
	 
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Tax Rate : </td>
	<td   align="left" >
	 <?=$arryTax[0]['TaxName'];?> : <?=$arryTax[0]['TaxRate'];?>
	</td>
	</tr>	
        <?php }?>
	 <tr>
        <td align="right"   class="blackbold">Amount : </td>
        <td align="left"><?=number_format($arryOtherIncome[0]['TotalAmount'],2,'.','');?>&nbsp;<?=$arryOtherIncome[0]['Currency'];?></td>
    
	<td  align="right" class="blackbold"  width="45%"> Received From : </td>
	<td   align="left"><?=(!empty($arryOtherIncome[0]['Customer']))?(stripslashes($arryOtherIncome[0]['Customer'])):(NOT_SPECIFIED)?></td>
	</tr>	
        
        <tr>
            <td align="right"   class="blackbold">Entry Type :</td>
            <td align="left"><?=$arryOtherIncome[0]['EntryType'];?></td>
            <?php if($arryOtherIncome[0]['EntryType'] == "GL Account"){?>
            <td align="right"   class="blackbold">GL Code : </td>
            <td align="left"><?=$arryOtherIncome[0]['GLCode'];?></td>
            <?php } else {?>
             <td align="right"   class="blackbold">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <?php }?>
            
        </tr>
        
	 
  
   <tr>
        <td  align="right"   class="blackbold">Reference No#  : </td>
        <td   align="left"><?=(!empty($arryOtherIncome[0]['ReferenceNo']))?(stripslashes($arryOtherIncome[0]['ReferenceNo'])):(NOT_SPECIFIED)?></td>
    
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><?=(!empty($arryOtherIncome[0]['Comment']))?(stripslashes($arryOtherIncome[0]['Comment'])):(NOT_SPECIFIED)?></td>
	</tr>
	 
</table>	
  </td>
 </tr>

</table>

