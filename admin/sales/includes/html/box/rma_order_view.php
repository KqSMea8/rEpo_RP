<?
 if(!empty($arrySale[0]['InvoiceID'])){
	$arryInvoice = $objrmasale->GetInvoice('',$arrySale[0]['InvoiceID'],'Invoice');
	
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">  Invoice Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left"  width="30%"><B><?=stripslashes($arrySale[0]['InvoiceID'])?></B></td>

        <td  align="right"   class="blackbold" width="20%"> Customer : </td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arryInvoice[0]['CustCode']?>" ><?=stripslashes($arryInvoice[0]["CustomerName"])?></a>
</td>
  </tr>

  <tr>
        <td  align="right"   class="blackbold" > Sales Person : </td>
        <td   align="left" >
<? if(!empty($arryInvoice[0]['SalesPerson'])){ 

	if($arryInvoice[0]['SalesPersonType']=='1') {?>
	<a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID=<?=$arryInvoice[0]['SalesPersonID']?>" ><?=stripslashes($arryInvoice[0]['SalesPerson'])?></a>
 <? } else { ?>
	<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryInvoice[0]['SalesPersonID']?>" ><?=stripslashes($arryInvoice[0]['SalesPerson'])?></a>
<? } }else{ echo NOT_ASSIGNED;}?>

</td>
 
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
 <?=($arryInvoice[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arryInvoice[0]['InvoiceDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	  


	<tr>

     
</table>
<? } ?>
