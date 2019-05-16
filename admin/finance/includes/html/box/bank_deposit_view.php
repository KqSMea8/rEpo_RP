<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	

	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Account Name :</td>
	<td   align="left"><?=$arryDeposit[0]['AccountName'];?></td>
	</tr>	
	
	 <tr>
        <td align="right"   class="blackbold"> Amount : </td>
        <td align="left"><?=number_format($arryDeposit[0]['Amount'],2,'.',',');?>&nbsp;<?=$arryDeposit[0]['Currency']?></td>
     </tr>
	
	<tr>
		<td  align="right"   class="blackbold"> Date  :</td>
		<td   align="left" ><?=date($Config['DateFormat'], strtotime($arryDeposit[0]['DepositDate']));	?></td>
	</tr>	
	
	<tr>
	<td  align="right"   class="blackbold"  width="45%"> Received From : </td>
	<td  align="left"><?=(!empty($arryDeposit[0]['Customer']))?(stripslashes(ucwords($arryDeposit[0]['Customer']))):(NOT_SPECIFIED)?></td>
	</tr>	
	 <tr>
        <td  align="right" class="blackbold">Payment Method :</td>
        <td   align="left"><?=$arryDeposit[0]['PaymentMethod'];?></td>
  </tr>  
  
   <tr>
        <td  align="right"   class="blackbold">Reference No#  : </td>
        <td   align="left"><?=(!empty($arryDeposit[0]['ReferenceNo']))?(stripslashes($arryDeposit[0]['ReferenceNo'])):(NOT_SPECIFIED)?>	</td>
    </tr>
	 <tr>
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><?=(!empty($arryDeposit[0]['Comment']))?(stripslashes($arryDeposit[0]['Comment'])):(NOT_SPECIFIED)?></td>
	</tr>
	 
</table>	
  </td>
 </tr>
</table>

