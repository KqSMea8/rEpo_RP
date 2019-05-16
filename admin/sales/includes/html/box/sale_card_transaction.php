<?

	(empty($OrderID))?($OrderID=""):(""); 


	$NumCardTransaction=0;

	if($OrderID>0 && $arrySale[0]['PaymentTerm']=='Credit Card'){
		if(!empty($SaleID)){ 
			$arryCardTransaction = $objSale->GetTransactionBySaleID($SaleID,$arrySale[0]['PaymentTerm']);
		}else{
			$arryCardTransaction = $objSale->GetSalesTransaction($OrderID,$arrySale[0]['PaymentTerm']);
		}
		$NumCardTransaction = sizeof($arryCardTransaction);
	} 


$TotalCharge = 0;
$TotalRefund = 0;

	if(!empty($NumCardTransaction)){
?>

<table width="100%" id="list_table" border="0" align="center" cellpadding="1" cellspacing="1" >  


<tr align="left" >
	<?if($OrderID>0){?><td  class="head1" width="12%">Payment For</td><?}?>	 
	<td  class="head1" width="12%">Transaction Date</td>
	<td class="head1" width="11%">Payment Provider</td>
	<td  class="head1" width="18%">Transaction ID</td>
  	<td  class="head1" width="8%">Transaction Type</td>
	<td  class="head1"  width="8%">Amount</td>	
	<td  class="head1" >Provider Fee</td>
	<td  class="head1" align="center" width="15%">Credit Card</td>
	<? if($Action=="VCard"){?><td  class="head1" width="5%">&nbsp;Action</td><?}?>	
</tr>

<?  
$NumTr=0;


foreach ($arryCardTransaction as $key => $values) { 
	$NumTr++;

	$ModuleTr = (!empty($values['Module']))?($values['Module']):("");

	$clsType = '';

 if($ModuleTr=='Invoice'){
	$PaymentFor = 'INV : '.$values['InvoiceID'];
	//if($arrySale[0]['InvoiceEntry'] == 1){
		if($values['TransactionType']=='Charge'){
			$TotalCharge += $values['TotalAmount'];
			$clsType = 'green';
		}else if($values['TransactionType']=='Void'){
			$TotalRefund += $values['TotalAmount'];
			$clsType = 'red';
		}
	//}	
}else{
	$PaymentFor = (!empty($values['SaleID']))?('SO : '.$values['SaleID']):("");
  
	if($values['TransactionType']=='Charge'){
		$TotalCharge += $values['TotalAmount'];
		$clsType = 'green';
	}else if($values['TransactionType']=='Void'){
		$TotalRefund += $values['TotalAmount'];
		$clsType = 'red';
	}
}




?>

<tr align="left"  <? if($NumTr==1) echo 'style="background-color:#CAFFCA"'; ?> >
	<?if($OrderID>0){?><td><?=$PaymentFor?></td> <?}?>

 


	<td>   <?    if ($values['TransactionDate'] > 0)
                                                echo date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values['TransactionDate']));
                               ?>
		</td>
	<td><?=$values['ProviderName']?></td> 
	<td><?=$values['TransactionID']?></td> 
	<td class="<?=$clsType?>"><?=$values['TransactionType']?></td> 
	<td><?=number_format($values['TotalAmount'],2)?> <?=$values['Currency']?></td> 
	<td><?=number_format($values['Fee'],2)?> <?=$values['Currency']?></td>

	<td align="center">
<? 
if(!empty($values["CardNumber"])){
	 	 
	$CardNumber = CreditCardNoX($values["CardNumber"],$values["CardType"]);
	$CreditCardDt = 'Card Type : '.$values["CardType"]
			.'<br>Card Number : '.$CardNumber
			.'<br>Card Name: '.$values["CardHolderName"];
	if(!empty($values["ExpiryMonth"]) && !empty($values["ExpiryYear"])){$CreditCardDt .= '<br>Expiry : '. $values["ExpiryMonth"].'-'. $values["ExpiryYear"];}


	echo '<img class="help" src="../icons/'.strtolower($values["CardType"]).'.png"  onMouseover="ddrivetip(\''.$CreditCardDt.'\', 220,\'\')"; onMouseout="hideddrivetip()"   ><br>'.$CardNumber; 
	 
}
?></td-->


        <? if($Action=="VCard"){
		$card_void='';
 
		if($values['TransactionType']=="Charge" && $values['TotalAmount']>0){
			if($values['RefundedAmount']>0){
				$card_void = '<span class="red">Refunded</span>';
			}else{
				$VoidCardUrl = $SelfPage."?OrderID=".$OrderID."&Action=VCard&curP=".$_GET["curP"]."&PID=".$values['ProviderID']."&ID=".base64_encode($values['ID']); 			
				$card_void = '<a href="'.$VoidCardUrl.'" class="red_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void</a>';
			}
		}		
		echo '<td>'.$card_void.'</td>';
	 }?> 
</tr>
<? } ?>
<tr>
	<td colspan="9" style="background-color:#ffffff;display:none">
</td>	
</tr>
<? if(!empty($InvoiceSpend) && $module=='Order'){ ?>
<tr>
	<td colspan="9" class="redmsg" style="background-color:#ffffff;">
 	<? echo 'Invoiced Amount : '.number_format($InvoiceSpend,2).' '.$arrySale[0]['CustomerCurrency']; ?>
	
 
</td>	
</tr>	
<? } ?>
</table>

		 
<? }



$CreditCardBalance = $TotalCharge - $TotalRefund;

 ?>
