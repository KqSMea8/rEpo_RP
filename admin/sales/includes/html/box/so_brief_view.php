
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information
	 
</td>
</tr>

 
 <tr>
        <td  align="right"   class="blackbold" >  Sales <?=$module?> Number # :  </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]["SaleID"])?></B></td>	

	<td  align="right"   class="blackbold" > Customer : </td>
	<td   align="left" >
	<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
	</td>

 </tr>
 
 <tr>
         
        <td  align="right"   class="blackbold" width="20%">Order Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED)?>
		</td>
	
		 <td  align="right"  class="blackbold" >Order Status  : </td>
        <td   align="left">
		  

<?=$objSale->GetOrderStatusMsg($arrySale[0]['Status'],$arrySale[0]['Approved'],$arrySale[0]['PaymentTerm'],$arrySale[0]['OrderPaid'])?>

 
          </td>

		
      </tr>
	  
	 
 
	<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	         <?=(!empty($arrySale[0]['PaymentTerm']))?(stripslashes($arrySale[0]['PaymentTerm'])):(NOT_SPECIFIED)?>
			</td>

		<? if($arrySale[0]['OrderPaid']>0 && $module=='Order') { ?>
	 <td  align="right"   class="blackbold" >Payment Status  : </td>
        <td   align="left" >
		<? echo $objSale->GetCreditStatusMsg($arrySale[0]['Status'],$arrySale[0]['OrderPaid']); ?>

	</td>
	<? } ?>

		
 
	</tr>
  
 	
<tr>

<td  align="right" class="blackbold"  > Total Order Amount : </td>
			<td  align="left"> <? 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $arrySale[0]['TotalAmount'].' '.$Currency; 
  ?>
</td>
<? if(!empty($AmountToCharge)){ ?>
<td  align="right" class="blackbold"  > Amount To Charge : </td>
			<td  align="left" class="redmsg	"> <? 
 
echo number_format($AmountToCharge,2).' '.$Currency; 
  ?>
 
</td>
<? } ?>
</tr>

    
</table>
 
