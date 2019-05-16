<? $arryInvoice = $objPurchase->GetPurchaseInvoice('', $arryPurchase[0]["InvoiceID"] ,'Invoice'); ?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Invoice Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" ><B><?=stripslashes($arryInvoice[0]["InvoiceID"])?></B></td>
      </tr>
	 <tr>
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
 <?=($arryInvoice[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryInvoice[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
	  <tr>
        <td  align="right"   class="blackbold" >Item Received Date  : </td>
        <td   align="left" >
 <?=($arryInvoice[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryInvoice[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
      <tr>
        <td  align="right"   class="blackbold">Assigned To  : </td>
        <td   align="left">

<? if(!empty($arryInvoice[0]['AssignedEmp'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryInvoice[0]['AssignedEmpID']?>" ><?=stripslashes($arryInvoice[0]['AssignedEmp'])?></a>   
<? 
	}else{
		echo NOT_SPECIFIED;
	}
?>
		  
		   </td>
                  
      </tr>
	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arryInvoice[0]['InvoiceComment']))?(stripslashes($arryInvoice[0]['InvoiceComment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>
</table>
