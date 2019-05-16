<?

if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Invoice Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left"  width="30%"><B><?=stripslashes($arrySale[0]['InvoiceID'])?></B></td>

        <td  align="right"   class="blackbold" width="20%"> Customer : </td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
</td>
  </tr>

  <tr>
        <td  align="right"   class="blackbold" > Sales Person : </td>
        <td   align="left" >
<? if(!empty($arrySale[0]['SalesPerson'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a>
<? }else{ echo NOT_ASSIGNED;}?>

</td>
 
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	  


</table>
