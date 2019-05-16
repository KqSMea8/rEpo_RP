<?
if(!empty($SuppCode)){
$_GET['SuppCode'] = $SuppCode;
$arryPaymentInvoice = $objBankAccount->ListPaidPaymentInvoice($_GET);
$num = $objBankAccount->numRows();
//pr($arryPaymentInvoice);
?>




<table <?=$table_bg?>>
   	<td width="12%" class="head1" >Payment Date</td>
	<td width="12%" class="head1" >GL Posting Date</td>
	<td width="12%"   class="head1" >Invoice /GL #</td>
	<td width="12%"  class="head1" >PO/Reference #</td>
	<td   class="head1">Amount (<?= $Config['Currency'] ?>)</td>
	<td width="12%"  class="head1">Payment Term</td>
	<td width="15%" class="head1">Payment Account</td>
	<td width="12%"  align="center" class="head1">Payment Status</td>
   
    <?php 
 
  if(is_array($arryPaymentInvoice) && $num>0){
  	$flag=true;$Flag='';
	$Line=0;
  	foreach($arryPaymentInvoice as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
      <tr align="left">

<td height="20">
    <?
    if ($values['PaymentDate'] > 0)
        echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
    ?>

</td>

<td>
<?
if ($values['PostToGLDate'] > 0)
echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
?>

</td>

<td> 


<?php  
$GlFlag = 0;
$AmountPay = $values['CreditAmnt'];
if(!empty($values['GLID']) && empty($values['InvoiceID']) && empty($values['CreditID']) ){
	echo $values['ReferenceNo'];
	$GlFlag = 1;
	$AmountPay = $values['DebitAmnt'];
}else if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { ?>
	<a href="vOtherExpense.php?pop=1&amp;Flag=<?= $Flag; ?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox fancybig fancybox.iframe"><?= $values["InvoiceID"]; ?></a>
<?php } else { ?>
	<a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?= $values['OrderID'] ?>" class="fancybox fancybig fancybox.iframe"><?= $values["InvoiceID"]; ?></a>
<?php } ?>


                                        </td>  
                                        <td >

                                                <?php if ($values['InvoiceEntry'] == '1') { ?>
                                                <a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" class="fancybox fancybig fancybox.iframe"><?= $values['PurchaseID'] ?></a> 
                                                <?php } else if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == "3") { ?>
                                                <a href="vOtherExpense.php?pop=1&amp;Flag=<?= $Flag; ?>&amp;view=<?= $values['ExpenseID'] ?>" class="fancybox fancybig fancybox.iframe">
                                                <?php if ($values['InvoiceEntry'] == "3") { ?>Spiff<?php } else { ?><?= $values['PurchaseID'] ?><?php } ?>
                                                <? //=$values['PurchaseID'] ?>
                                                </a>
            <?php } else { ?>
                                                <a href="../purchasing/vPO.php?module=Order&amp;pop=1&amp;po=<?= $values['PurchaseID'] ?>" class="fancybox fancybig fancybox.iframe"><?= $values['PurchaseID'] ?></a>
            <?php } ?>




                                        </td>
        


                                       
                                        <td><strong><?= number_format($AmountPay,2); ?></strong></td>



 <td><?
echo $values['PaymentMethod'];
if($values['PaymentMethod']=='Check' & !empty($values['PaymentCheckNo'])){
	echo ' - '.$values['PaymentCheckNo'];
}
?></td>
                                        <td><?=$values['PaymentAccount']?></td>
                               

                                        <td align="center">
                                            <?
					    if($GlFlag=="1"){
						   $StatusCls = 'green';
                                                   $InvoicePaid = "Paid";
                                            }else if ($values['PaymentType'] == 'Other Expense') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                if ($values['InvoicePaid'] == 1) {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }
                                            }

					  
                                            echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
                                            ?>
                                            <br>


                                        </td>

	</tr>

    <?php } // foreach end //?>
   <tr align="center" >
      <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?> </td>
    </tr>
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	
  </table>

<? } ?>

