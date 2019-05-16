<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Transfer From :</td>
	<td   align="left"><?=$arryTransfer[0]['TransferFrom'];?></td>
	</tr>	
	<tr>
	<td  align="right"   class="blackbold"> Transfer To  :</td>
	<td   align="left" ><?=$arryTransfer[0]['TransferTo'];?></td>
	</tr>	  
	<tr>
		<td  align="right"  class="blackbold"> Transfer Amount  :</td>
		<td   align="left" ><?=number_format($arryTransfer[0]['TransferAmount'],'2','.','');?>&nbsp;<?=$arryTransfer[0]['Currency'];?></td>
	</tr>	
	<tr>
		<td  align="right"   class="blackbold"> Transfer Date  :</td>
		 
		<td   align="left" ><?=date($Config['DateFormat'], strtotime($arryTransfer[0]['TransferDate']));?>	</td>
	</tr>	
	
	<tr>
		<td align="right" class="blackbold">Ref :</td>
		<td  align="left">
                  <?=(!empty($arryTransfer[0]['ReferenceNo']))?(stripslashes($arryTransfer[0]['ReferenceNo'])):(NOT_SPECIFIED)?>
	</td>
		 
		</td>
	</tr>	
	  
	 
</table>	
  </td>
 </tr>

</table>
