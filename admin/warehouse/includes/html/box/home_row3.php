
<div class="rows clearfix">
       
	


          <div class="second_col" style="display:none3;<?=$WidthRow2?>">
            <div class="block listing">
              <h3>Picking</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/				
				$_GET['Status'] = '';
				$_GET['Limit'] = '10';
$_GET['module'] = 'Order';

				//$arryShipment=$objShipment->ListShipment($_GET);


if($Config['batchmgmt']==1){
	$arryShipment=$objSale->ListSale($_GET); //updated by bhoodev 29feb//

}else{
$arryShipment=$objSale->ListSaleOrdersOnly($_GET); //updated by bhoodev 29feb//

}




				/********************/
				
				if(sizeof($arryShipment)>0){ 
$OrderType = '';
					 foreach($arryShipment as $key=>$values){

if($values["OrderType"] != '') $OrderType = $values["OrderType"]; else $OrderType = 'Standard'; 
			  $OrderSt = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
$TotalGenerateInvoice = $objSale->GetQtyInvoicedCheck($values['OrderID']);
	$ShipOrderInv = $objSale->GetShipOrderStatus($values['SaleID'],'Shipment');
	$TotalInvoice = $objSale->CountInvoices($values['SaleID']);

if ($values['Status'] == 'Open' && $values['Approved'] == 1 &&  $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty']  && $OrderType == 'Standard' && $TotalGenerateInvoice[0]['QtyShip'] != $TotalGenerateInvoice[0]['Qty'] && $OrderSt != 'Credit Hold' ){
				?>
				<tr>
                  <td width="15%"><a target="_blank" href="../sales/vSalesQuoteOrder.php?view=<?=$values['OrderID']?>&Module=Order"><?=$values['SaleID']?></a></td>
				  <td width="30%">
					 <?   if ($values['OrderDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['OrderDate']));
                                            ?></td>
				  
				  <td width="15%"><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $values['CustCode'] ?>" ><?= stripslashes($values["CustomerName"]) ?></td>
					
					<td width="15%"><?=stripslashes($values['TotalAmount'])?></td>
					<td width="19%"><?=stripslashes($values['CustomerCurrency'])?></td>
					     <td align="center">
				
				<span class="<?=$cls?>">



<? 

if($Config['batchmgmt']!=1){
                                                echo '<br><a  class="button" href="../finance/generateInvoice.php?so=' . $values['SaleID'] . '&invoice=' . $values['OrderID'] . '" target="_blank">Picking</a>';
}else{

 echo '<br><a class="fancybox fancybox.iframe button" style="color:white;" href="../sales/batchinvoice.php?so=' . $values['SaleID'] . '&edit=' . $values['OrderID'] . '" >Picking</a>';


}
?>

</span>
					 
					</td>
						
					
                </tr>  
			
				<? } }
				
				
				
				?>
	<tr>
                           <td colspan="2">
                           <a href="../sales/viewSalesQuoteOrder.php?module=Order">More...</a>
                           </td>
                           </tr>				
					
				<?}else{ ?>
				 <tr>
                  <td align="center" height="60"><div class="red" align="center"><?=NO_RECORD?></div></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>	  
</div>
