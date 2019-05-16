           <!-- <tr>
             <td align="left" class="head" colspan="2">Transaction </td> 
         </tr> -->  
	<tr>  
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
	<tbody>
	<tr>
	<td class="head1" width="10%">Transaction ID</td>
        <td class="head1" width="10%">Type</td>
	<td class="head1" width="12%">Date</td>
	<td class="head1" width="12%">Sku</td>
        <td class="head1">Description</td>
<td class="head1" width="10%">Total Price</td>
        <td class="head1" width="10%">Unit Price</td>
        <td class="head1" width="10%">Currency</td>
        <td class="head1" width="5%">Qty</td>
       
       
 
	</tr>
        
	<?php
if(!empty($_GET['edit'])){
$Config['ItemID'] = $_GET['edit'];
}

$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryTrans=$objItem->GetTransactionForSku($ItemSku);
$Config['GetNumRecords'] = 1;
        $arryCount=$objItem->GetTransactionForSku($ItemSku);	
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	

	 if (is_array($arryTrans) && $num > 0) {
                        $flag = true;
                        $Line = 0;
	foreach ($arryTrans as $transaction) {
	?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
            <td>
                <?php if($transaction['TransactionType'] == "SO Invoice"){
$column = "ConversionRate,CustomerCurrency";
$arryInv = $objItem->GetTransactionDetailByID($transaction['TransactionOrderID'],$column,'OrderID','Invoice','s_order');

$TransactionUnitPrice = $transaction['TransactionUnitPrice'];
if(!empty($arryInv[0]['Currency'])){
	if($arryInv[0]['Currency']!=$Config['Currency']){				
		$TransactionUnitPrice = GetConvertedAmount($arryInv[0]['ConversionRate'], $transaction['TransactionUnitPrice']);	 		
	} 
}


?>
                <a href="../finance/vInvoice.php?pop=1&amp;view=<?= $transaction['TransactionOrderID'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $transaction['TransactionInvoiceID']; ?></a>
               
                <?php } elseif($transaction['TransactionType'] == "PO Invoice"){
$column = "ConversionRate,Currency";
$arryPoInv = $objItem->GetTransactionDetailByID($transaction['TransactionOrderID'],$column,'OrderID','Invoice','p_order');
$column2 = "OrderID,freight_cost";
$arryPoInvItem = $objItem->GetTransactionItemByID($transaction['TransactionOrderID'],$column2,$transaction['TransactionSku'],'p_order_item');


$totalUnitCost = $transaction['TransactionUnitPrice'] + $arryPoInvItem[0]['freight_cost'];

if($arryPoInv[0]['Currency']!=$Config['Currency']){				
				$TransactionUnitPrice = GetConvertedAmount($arryPoInv[0]['ConversionRate'], $totalUnitCost);	 		
			}else{
$TransactionUnitPrice = $totalUnitCost;
}



?>
                <a href="../finance/vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?= $transaction['TransactionOrderID'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $transaction['TransactionInvoiceID']; ?></a>
                
                <?php } elseif($transaction['TransactionType'] == "Assemble"){
$TransactionUnitPrice = $transaction['TransactionUnitPrice'];?>
                 <a href="vAssemble.php?view=<?= $transaction['TransactionOrderID'] ?>&amp;pop=1" class="fancybox vSalesPayWidth fancybox.iframe"><?= $transaction['TransactionInvoiceID']; ?></a>
                <?php } elseif($transaction['TransactionType'] == "Adjustment"){ 
$TransactionUnitPrice = $transaction['TransactionUnitPrice'];?>
                 
                <a href="vAdjustment.php?view=<?= $transaction['TransactionOrderID'] ?>&amp;pop=1" class="fancybox vSalesPayWidth fancybox.iframe"><?=$transaction['TransactionInvoiceID']; ?></a>
                <?php }elseif($transaction['TransactionType'] == "PO Receipt"){ 
$column = "ConversionRate,Currency";

$arryRecInv = $objItem->GetTransactionDetailByID($transaction['TransactionOrderID'],$column,'OrderID','Receipt','p_order');
$column2 = "OrderID,freight_cost";
$arryRecInvItem = $objItem->GetTransactionItemByID($transaction['TransactionOrderID'],$column2,$transaction['TransactionSku'],'p_order_item');
//$totalUnitCost = $transaction['TransactionUnitPrice'] + $arryRecInvItem[0]['freight_cost'];
$totalUnitCost = $transaction['TransactionUnitPrice'] ;

if($transaction['TransactionCurrency']!=$Config['Currency']){
		$ConversionRate=$arryRecInv[0]['ConversionRate']; //from db
		if(empty($ConversionRate)){
			$ConversionRate = 1;		
		}
		
	}else{
		$ConversionRate = 1;
	}

$TransactionUnitPrice = GetConvertedAmount($ConversionRate, $totalUnitCost);	 

//if($arryRecInv[0]['Currency']!=$Config['Currency']){	
//if($_GET['test']==1)
//echo "<pre>";
//echo $Config['Currency'];	exit;		
				 //$TransactionUnitPrice = GetConvertedAmount($ConversionRate, $totalUnitCost);	 		
			//}else{
//$TransactionUnitPrice = $totalUnitCost;
//}


?>
                 
                <a href="../warehouse/vPoReceipt.php?view=<?= $transaction['TransactionOrderID'] ?>&amp;pop=1" class="fancybox vSalesPayWidth fancybox.iframe"><?=$transaction['TransactionInvoiceID']; ?></a>
                <?php }elseif($transaction['TransactionType'] == "Merge Item"){ 
$TransactionUnitPrice = $transaction['TransactionUnitPrice'];?>
                 
                <a href="vMergeItem.php?view=<?= $transaction['TransactionOrderID'] ?>&amp;pop=1" class="fancybox vSalesPayWidth fancybox.iframe"><?=$transaction['TransactionInvoiceID']; ?></a>
                <?php }?>
            </td>
            <td><?= $transaction['TransactionType']; ?></td>
            <td><?= $transaction['TransactionDate']; ?></td>
            <td><?= $transaction['TransactionSku']; ?></td>
            <td><?= $transaction['TransactionDescription']; ?></td>
						<td><? echo number_format((($transaction['TransactionUnitPrice']*$transaction['TransactionQty'])+$transaction['freight_cost']), 2,'.','');  ?></td>
            <td><?=number_format(($TransactionUnitPrice+($transaction['freight_cost']/$transaction['TransactionQty'])), 2,'.','');?></td>
            <td><?= $transaction['TransactionCurrency']; ?></td>
            <td><?= $transaction['TransactionQty']; ?></td>
            

	</tr>
	<?php
	}
	} else {
	?>
	<tr >
	<td class="no_record" colspan="9"><?=NO_RECORD;?></td>

	</tr>
	<?php } ?>
 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTrans) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
	</tbody>
	</table>
	</td>
	</tr>
