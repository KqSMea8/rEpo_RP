<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	
  
    
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice ID # : </td>
        <td   align="left" width="30%"><a class="fancybox fancybox.iframe" href="vInvoice.php?view=<?=$arrySale[0]['OrderID']?>&pop=1" ><?=$arrySale[0]["InvoiceID"]?></a></td>
<td  align="right"   class="blackbold" > Customer : </td>
	<td   align="left" >

	<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
	</td>
       
      </tr>
	  
 
<tr>
	

	 <td  align="right"   class="blackbold"  width="20%">Invoice Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):("")?>
		</td>

	 <td  align="right"   class="blackbold" >Ship Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['ShippedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ShippedDate']))):("")?>
		</td>
</tr>

 	   

 
	 

<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	         <?=(!empty($arrySale[0]['PaymentTerm']))?(stripslashes($arrySale[0]['PaymentTerm'])):("")?>
			</td>
<td  align="right"   class="blackbold" > Sales Person : </td>
			<td   align="left" >
                            <?php if(!empty($arrySale[0]['SalesPerson'])){?>
                            <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a></td>
                            <?php } ?>
                           
			 
	</tr>

  

<? if(!empty($OrderSourceFlag)){ ?>
<tr>
	<td  align="right"   class="blackbold" > Order Source  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['OrderSource']))?(stripslashes($arrySale[0]['OrderSource'])):("")?>
	         
	</td>
</tr>
<? } ?>

 


<? if(!empty($arrySale[0]['ShippingMethod'])){ ?>

<tr>
			<td  align="right" class="blackbold">Shipping Carrier  : </td>
			<td  align="left"><?=stripslashes($arrySale[0]['ShippingMethod'])?>
		  </td>

		<td align="right" valign="top" class="blackbold">Shipping Method :</td>
		<td align="left" valign="top">
<?
if(!empty($arrySale[0]['ShippingMethodVal'])){	
	$arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'],$arrySale[0]['ShippingMethodVal']);
}
?>


<?=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):("")?>
		</td>

	</tr>
<? } ?>

 <tr>
<td  align="right" class="blackbold"  > Invoice Amount : </td>
			<td  align="left"> <? 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $arrySale[0]['TotalInvoiceAmount'].' '.$Currency; 
  ?>
</td>

<td  align="right"   class="blackbold"> SO/Reference Number # : </td>
			<td   align="left" ><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$arrySale[0]['SaleID']?>" ><?=stripslashes($arrySale[0]['SaleID'])?></a></td>

</tr>
 
<? if(!empty($AmountToCharge)){ ?>
<tr>
<td  align="right" class="blackbold" > Amount To Charge : </td>
			<td  align="left" class="redmsg"> 
 
<input name="AmountToCharge" maxlength="10" class="inputbox" style="width:100px;" onblur="Javascript:CheckAmountToCharge();" id="AmountToCharge" value="<?=$AmountToCharge?>" onKeyPress="Javascript:ClearAvail('msgdiv'); Javascript: return isDecimalKey(event);"  type="text">

 <? 
echo $Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
  ?>
<input type="hidden" name="AmountToChargeMax" id="AmountToChargeMax" value="<?=$AmountToCharge?>" readonly />

<input type="hidden" name="receivedAmnt" id="receivedAmnt" value="<?=$receivedAmnt?>" readonly />

</td>

</tr>

<tr> 
	<td height="20" colspan="4">
<div id="msgdiv" class="redmsg" align="center"></div>
</td>	
  </tr>
<? } ?>

</table>

 
