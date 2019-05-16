<?php 
 
if(!empty($SpiffOrderID) || !empty($SpiffSaleID)){
	$arrySpiffEntry = $objSale->GetSpiffEntry($SpiffOrderID,$SpiffSaleID);  
	$SpiffNumLine = sizeof($arrySpiffEntry);
}	

if(!empty($SpiffNumLine)){

?> 

 <table width="100%"   class="borderall"  cellpadding="0" cellspacing="1">
	<thead>
		<tr >		
			<td align="left"  class="head1" width="30%">Vendor Code </td>
			<td align="left"  class="head1" width="40%">Vendor Name </td>
			<td align="left" class="head1">Spiff Amount</td>
		</tr>
	</thead>
<tbody>
	<? 	
	for($Line=1;$Line<=$SpiffNumLine;$Line++) { 
		$Count=$Line-1;	
	if($arrySpiffEntry[$Count]['Amount']>0) { 
		$Amount =  number_format($arrySpiffEntry[$Count]['Amount'],2); 
	}else{
		$Amount =  '0.00';
	}	
	?>
     <tr class='itembg' align="left">
		<td >
<a class="fancybox fancybox.iframe" href="../vendorInfo.php?view=<?=$arrySpiffEntry[$Count]['SuppCode']?>" ><?=$arrySpiffEntry[$Count]['SuppCode']?></a>

</td> 
		<td ><?=$arrySpiffEntry[$Count]['VendorName']?></td> 
		<td ><?=$Amount?></td> 
    </tr>
	<?php } ?>
 
</tbody>

</table>

<? } ?>






