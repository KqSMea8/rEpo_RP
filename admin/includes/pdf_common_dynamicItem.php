<?php
(empty($description))?($description=""):("");
(empty($height))?($height=""):("");
(empty($even))?($even=""):("");
(empty($TotalQtyReceived))?($TotalQtyReceived=""):("");
(empty($ordered_qty))?($ordered_qty=""):("");
(empty($TotalQtyLeft))?($TotalQtyLeft=""):("");
(empty($total_returned))?($total_returned=""):("");

(empty($discount))?($discount=""):("");
(empty($discount))?($discount=""):("");
/* * **Line Item Data** */
if($ModDepName == 'Sales') {
  require_once($PrefixTemp."includes/pdf_salesorder_dynamicItem.php");  
  
} else if ($ModDepName == 'Purchase') {
    require_once($PrefixTemp."includes/pdf_po_dynamicItem.php");

} else if ($ModDepName == 'SalesInvoice') {
  require_once($PrefixTemp."includes/pdf_salesInv_dynamicItem.php"); 
     
} else if ($ModDepName == 'SalesInvoiceGl') {
  require_once($PrefixTemp."includes/pdf_salesInvGl_dynamicItem.php"); 
     
} else if ($ModDepName == 'PurchaseInvoice') {
      require_once($PrefixTemp."includes/pdf_purchaseInv_dynamicItem.php"); 
} else if ($ModDepName == 'SalesRMA') {
      require_once($PrefixTemp."includes/pdf_salesrma_dynamicItem.php"); 
 
} else if ($ModDepName == 'PurchaseRMA') {
	require_once($PrefixTemp."includes/pdf_porma_dynamicItem.php"); 

} else if ($ModDepName == 'SalesCreditMemo') {
	require_once($PrefixTemp."includes/pdf_salesCrd_dynamicItem.php"); 

} else if ($ModDepName == 'PurchaseCreditMemo') {
	require_once($PrefixTemp."includes/pdf_purchaseCrd_dynamicItem.php"); 

}else if ($ModDepName == 'WhouseCustomerRMA') {

 if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="10%";
    $width2="10%";
    $width3="38%";
    $width4="10%";
        //$width5="10%";
    $width6="10%";
    $width7="11%";
        //$width8="10%";
        //$width9="10%";
    $width10="11%";
}else{
    $width1="13%";
        //$width2="10%";
    $width3="43%";
    $width4="11%";
        //$width5="10%";
    $width6="11%";
    $width7="11%";
        //$width8="10%";
        //$width9="10%";
    $width10="11%";
}



$LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
<tr style=" background:' . $LineHeadbackColor . ';">
    <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem .='<td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .='<td  style="width:'.$width3.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';


    $LineItem .='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty RMA</td>';
    /*<td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Original Qty Returned</td>*/
    $LineItem .='<td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty Return</td>
    <td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
                                /*<td style="width:'.$width8.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>
                                <td style="width:'.$width9.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
                                $LineItem .='<td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
                            </tr></table>';


			$flag = true;
			$Line = 0;
			$subtotal = 0;
			$d=0;
			$ss=0;
			$total_received = 0;
			$Dropship = '';

                            if (is_array($arrySaleItem) && $NumLine > 0) {
                                
                                foreach ($arrySaleItem as $key => $values) {
                                    $flag = !$flag;
                                    $Line++;

            //$total_received = $objSale->GetQtyReceived($values["id"]);
            //$total_returned = $warehouserma->GetQtyReturnedware($values["ref_id"]);

                                    $valReceipt = $warehouserma->GetSumQtyReceipt($values['OrderID'], $values['item_id']);
                                    $sku = stripslashes($values["sku"]);
                                    $ordered_qty = $values["qty"];
                                    $qty_invoiced = $total_returned;
                                    $qty_returned = $values["qty_receipt"];

                                    if (!empty($values["RateDescription"]))
                                        $Rate = $values["RateDescription"] . ' : ';
                                    else
                                        $Rate = '';
                                    $TaxRate = $Rate . number_format($values["tax"], 2);


                                    if ($values["DropshipCheck"] == 1) {
                                        $DropshipCheck = 'Yes';
                                    } else {
                                        $DropshipCheck = 'No';
                                        $ds = 1;
                                    }

                                    if (!empty($values["SerialNumbers"])) {
                                        $arrySlNo[$sku] = $values["SerialNumbers"];
                                    }

                                    if (!empty(stripslashes($values["description"]))) {
                                        $arryDesCount[$d] = stripslashes($values["description"]);
                //$description=$arryDesCount[$d];
                                        $d++;
                                    }

                                    $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . '">
                                    <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                                        $new_sku = wordwrap($sku, 8, "<br />", true);
            //stripslashes($values["sku"])
                                        $LineItem.=$new_sku;
                                        $LineItem.='</td>';
                                        if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                                            $LineItem.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
                                        }

                                        $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //stripslashes($values["description"])
                                        $new_description = wordwrap(stripslashes($values["description"]), 30, "<br />", true);
            //stripslashes($values["sku"])
                                        $LineItem.=$new_description;
                                        $LineItem.='</td>';

                                        $LineItem.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values["qty"] . '</td>';                   
                                        /* <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($valReceipt) . '</td>*/
                                        $LineItem.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($qty_returned) . '</td>
                                        <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arrySale[0]['CustomerCurrency'] . ' ' .number_format($values["price"], 2) . '</td>';
        /*<td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
        <td style="width:'.$width9.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
        $LineItem.='<td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arrySale[0]['CustomerCurrency'] . ' ' .number_format($values["amount"], 2) . '</td>
    </tr>';
    $LineItem.='</table>';
    $subtotal += $values["amount"];
    $TotalQtyReceived += $total_received;
    $TotalQtyLeft += ($ordered_qty - $total_received);

    /***code for new serial number***/
    $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
    if(!empty($salesInvSerialNo)){
        $salesInvSerialNoarray[$ss]=$salesInvSerialNo;
        $ss++;
    }
    if(!empty($salesInvSerialNo)){
        $sn=0;
        $i= 0;
                    //$LineItem .='<table style="width:98%;">';
        foreach($salesInvSerialNo as $val){
            if($sn==0){
               $LineItem .='<table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . ';">';
               $LineItem .='<td style="width:'.$width1.';"></td>';
               if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem .='<td style="width:'.$width2.';"></td>';
           }
           $LineItem .='<td style="width:'.$width3.';">';
           $LineItem .= '<table style="width:99%;"><tr style="width:99%;">';
       }
       $sn++;
       $i++;
       $LineItem .= '<td style="width:33%;">'.$val.'</td>';
       if($sn==3 || sizeof($salesInvSerialNo)==$i ){

          $LineItem .= '</tr></table>';
          $LineItem .='</td>';
          $LineItem .='<td style="width:'.$width4.';"></td>';
                  //$LineItem .='<td style="width:'.$width5.';"></td>';
          $LineItem .='<td style="width:'.$width6.';"></td>';
          $LineItem .='<td style="width:'.$width7.';"></td>';
                  //$LineItem .='<td style="width:'.$width8.';"></td>';
                  //$LineItem .='<td style="width:'.$width9.';"></td>';
          $LineItem .='<td style="width:'.$width10.';"></td>';
          $LineItem .='</tr>';
          $LineItem .='</table>';
                      //if($i%5==1){
                        //break;
                        //$LineItem .= '<tr><td colspan="3"></td></tr>';
                      //}
          $sn=0;
      }
                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
  }
                    //$LineItem .='</table>';

}

/***code for new serial number***/




        }//endforeach
        //PR($arrySale);
        $subtotaln = number_format($subtotal, 2);
        $taxAmnt = number_format($arrySale[0]['wtaxAmnt'], 2);
        $Freight = number_format($arrySale[0]['FreightAmt'], 2);
        $TDiscount = number_format($arrySale[0]['TDiscount'], 2);
        
	$ReStockingVal ='';
        if ($arrySale[0]['ReSt'] == 1 && $arrySale[0]['ReStocking']>0) {
           $ReStockingVal = '('. number_format($arrySale[0]['ReStocking'], 2) .')';
        }



        $TotalAmountn = $subtotal + $arrySale[0]['wtaxAmnt'] + $arrySale[0]['FreightAmt'] - $arrySale[0]['ReStocking'];
        $TotalAmount = number_format($TotalAmountn, 2, '.', ',');
    }//endif


    
    
    //$TotalDataShowArry = array('Subtotal' => $subtotaln, 'Tax' => $taxAmnt, 'Freight' => $Freight  , 'Re-Stocking Fee: ' => $ReStockingVal , 'GrandTotal' => $arrySale[0]['CustomerCurrency'] . ' ' . $TotalAmount);

    $TotalDataShowArry = array('Subtotal: ' => $arrySale[0]['CustomerCurrency'] . ' ' .$subtotaln, 'Freight: ' => $Freight ,'Add\'l Discount: '=>'('.$TDiscount.')', 'Re-Stocking Fee: ' => $ReStockingVal , 'Tax' => $taxAmnt,  'Grand Total: ' => $arrySale[0]['CustomerCurrency'] . ' ' . $TotalAmount);

    /*     * *code for serial number*** 
    if (sizeof($arrySlNo) > 0) {
        $Line = 0;
        $SerialHead = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
            <tr style=" background:' . $LineHeadbackColor . ';">
                <td  style="width:32%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
                                <td  style="width:70%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Serial Number</td>
                                
            </tr>';

        foreach ($arrySlNo as $key => $values) {
            $Line++;
            if (($Line % 2) != '1') {
                $even = 'background:#ececec';
            } else {
                $even = '';
            }
            $Count = $Line - 1;
            $SerialNumbers = preg_replace('/\s+/', ' ', $values);
            $SerialHead.='<tr style=' . $even . '>
                <td style="width:32%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $key . '</td>
                                <td style="width:70%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $SerialNumbers . '</td>
                </tr>';
        }//endforeach

        $SerialHead.='</table>';
    }//endif*/
    /*     * *code for serial number*** */
}
else if ($ModDepName == 'WhouseBatchMgt') {
    require_once($PrefixTemp."includes/pdf_warehouse_dynamicItem.php");
}


else if ($ModDepName == 'WhouseVendorRMA') {

 if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="9%";
    $width2="10%";
    $width3="30%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="8%";
    //$width8="9%";
    //$width9="8%";
    $width10="14%";
    //$width11="8%";
    $width12="14%";
}else{
    $width1="9%";
    $width2="10%";
    $width3="30%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="8%";
    //$width8="9%";
    //$width9="8%";
    $width10="14%";
    //$width11="8%";
    $width12="14%";
}


$LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
<tr style=" background:' . $LineHeadbackColor . ';">
    <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem .='<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
    <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Type</td>
    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Action</td>
    <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Reason</td>
    <td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty RMA</td>';
   /* <td  style="width:'.$width8.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total Qty Returned</td>
   <td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty Returned</td>*/
   $LineItem.='<td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
   /* <td style="width:'.$width11.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
   $LineItem.='<td style="width:'.$width12.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';

if (is_array($arryPurchaseItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = 0;
    $total_received = 0;
    foreach ($arryPurchaseItem as $key => $values) {
        $flag = !$flag;
        $Line++;
        $ordered_qty = $values["qty"];
        $qty_invoiced = $values["qty_invoiced"];
        $qty_returned = $values["qty_receipt"];

        $sku = stripslashes($values["sku"]);
        if (!empty($values["SerialNumbers"])) {
                //echo 'newtest';
            $arrySlNo[$sku] = $values["SerialNumbers"];
        }

        $Type = $objWarehouse->WHRmaTypeValue($values["Type"]);
        $ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($values["OrderID"], $values["item_id"]);


        $Action = $values["Action"];
        $Reason = $values["Reason"];

        if (!empty($values["RateDescription"]))
            $Rate = $values["RateDescription"] . ' : ';
        else
            $Rate = '';
        $TaxRate = $Rate . number_format($values["tax"], 2);


        if ($values["DropshipCheck"] == 1) {
            $DropshipCheck = 'Yes';
        } else {
            $DropshipCheck = 'No';
            $ds = 1;
        }
        $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . '">
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);
            //stripslashes($values["sku"])
            $LineItem.=$new_sku;
            $LineItem.='</td>';
            if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                $LineItem.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
            }
            $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //stripslashes($values["description"])
            //$new_description = wordwrap(stripslashes($values["description"]), 10, "<br />", true);
            $new_description = stripslashes($values["description"]);
            //stripslashes($values["sku"])
            $LineItem.=$new_description;
            $LineItem.='</td>
            <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //$Type
                $new_Type = wordwrap($Type, 6, "<br />", true);
            //stripslashes($values["sku"])
                $LineItem.=$new_Type;
                $LineItem.='</td><td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $Action . '</td>
                <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $Reason . '</td>
                <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($ordered_qty) . '</td>';
                /*<td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($ValReciept) . '</td>
                <td style="width:'.$width9.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($qty_returned) . '</td>*/
                $LineItem .='<td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['SuppCurrency'] . ' ' . number_format($values["price"], 2) . '</td>';
                /*<td style="width:'.$width11.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
                $LineItem .='<td style="width:'.$width12.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['SuppCurrency'] . ' ' . number_format($values["amount"], 2) . '</td>
            </tr>';
            $LineItem.='</table>';

            $subtotal += $values["amount"];
            $TotalQtyReceived += $total_received;
            $TotalQtyLeft += ($ordered_qty - $total_received);


            $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
            if(!empty($salesInvSerialNo)){
                $sn=0;
                $i= 0;
                    //$LineItem .='<table style="width:98%;">';
                foreach($salesInvSerialNo as $val){
                    if($sn==0){
                       $LineItem .='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr>';
                       $LineItem .='<td style="width:15%;"></td>';
                       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem .='<td style="width:'.$width2.';"></td>';
                   }
                   $LineItem .='<td style="width:70%;">';
                   $LineItem .= '<table style="width:99%;"><tr>';
               }
               $sn++;
               $i++;
               $LineItem .= '<td style="width:33%; text-align:center;">'.trim($val).' </td>';
               if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                  $LineItem .='</tr></table>';
                  $LineItem .='</td>';
                
                  $LineItem .='<td style="width:15%;"></td>';
                  $LineItem .='</tr>';
                  $LineItem.='</table>';

 
                      //if($i%5==1){
                        //break;
                        //$LineItem .= '<tr><td colspan="3"></td></tr>';
                      //}
                  $sn=0;
              }
                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
          }
                    //$LineItem .='</table>';

      }
}//endforeach

//echo $LineItem; die;

        $subtotal = number_format($subtotal, 2);
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $TotalAmount = number_format($arryPurchase[0]['TotalReceiptAmount'], 2);
	 $RestockingVal='';
        if (!empty($arryRMA[0]['Restocking']) && $arryPurchase[0]['Restocking_fee']>0) {
            $RestockingVal = '('.number_format($arryPurchase[0]['Restocking_fee'],2).')';
        }
    }//endif
    


    //$TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight , 'Re-Stocking Fee' => $RestockingVal , 'GrandTotal' => $CustomerCurrency . ' ' . $TotalAmount);

     $TotalDataShowArry = array('Subtotal: ' => $arryPurchase[0]['SuppCurrency'] . ' ' .$subtotal,  'Freight: ' => $Freight, 'Re-Stocking Fee: ' => $RestockingVal, 'Tax' => $taxAmnt, 'Grand Total: ' => $arryPurchase[0]['SuppCurrency'] . ' ' . $TotalAmount);
    /*     * *code for serial number*** 
    if (sizeof($arrySlNo) > 0) {
        $Line = 0;
        $SerialHead = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
            <tr style=" background:' . $LineHeadbackColor . ';">
                <td  style="width:32%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
                                <td  style="width:70%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Serial Number</td>
                                
            </tr>';

        foreach ($arrySlNo as $key => $values) {
            $Line++;
            if (($Line % 2) != '1') {
                $even = 'background:#ececec';
            } else {
                $even = '';
            }
            $Count = $Line - 1;
            $SerialNumbers = preg_replace('/\s+/', ' ', $values);
            $SerialHead.='<tr style=' . $even . '>
                <td style="width:32%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $key . '</td>
                                <td style="width:70%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $SerialNumbers . '</td>
                </tr>';
        }//endforeach

        $SerialHead.='</table>';
    }//endif*/
    /*     * *code for serial number*** */
}

else if ($ModDepName == 'WhousePOReceipt') {



    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="10%";
    $width2="10%";
    $width3="42%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="11%";
    $width8="9%";
    $width9="9%";
    $width10="11%";
    
}else{
    $width1="10%";
    $width2="10%";
    $width3="42%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="11%";
    $width8="9%";
    $width9="9%";
    $width10="11%";
    
}


$LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
<tr style=" background:' . $LineHeadbackColor . ';">
    <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem .='<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
    <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>';
    /*'<td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total Qty Received</td>';*/
    $LineItem .='<td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty Received</td>
    <td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
   /*$LineItem .='<td  style="width:'.$width8.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Dropship Cost</td>
   <td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>';*/
   
   $LineItem.='<td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';

if (is_array($arryPurchaseItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = 0;
    $total_received = 0;
 
    foreach ($arryPurchaseItem as $key => $values) {
        $flag = !$flag;
        $Line++;
        $qty_ordered = $objPurchase->GetQtyOrderded($values["ref_id"]);   
            $total_received = $objPurchase->GetQtyReceived($values["ref_id"]);    
                        $sku = stripslashes($values["sku"]);
                        
            if(!empty($values["RateDescription"]))
                $Rate = $values["RateDescription"].' : ';
            else $Rate = '';
            $TaxRate = $Rate.number_format($values["tax"],2);

        if(empty($values['Taxable'])) $values['Taxable']='No';
                
                if(!empty($values["SerialNumbers"])){
                           $arrySlNo[$sku] = $values["SerialNumbers"];
                        }



        $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . '">
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);
            //stripslashes($values["sku"])
            $LineItem.=$new_sku;
            $LineItem.='</td>';
            if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                $LineItem.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
            }
            $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //stripslashes($values["description"])
            $new_description = wordwrap(stripslashes($values["description"]), 40, "<br />", true);
            //stripslashes($values["sku"])
            $LineItem.=$new_description;
            $LineItem.='</td>
            <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //$Type
                //$new_Type = wordwrap($Type, 6, "<br />", true);
            //stripslashes($values["sku"])
                $LineItem.=$qty_ordered.'</td>';
               /* $LineItem.='</td><td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_received . '</td>';*/
                $LineItem.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values["qty_received"] . '</td>
                <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $VenCurrency . ' ' .number_format($values["price"],2) . '</td>';
                /*$LineItem.='<td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"],2) . '</td>
                <td style="width:'.$width9.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable']. '</td>';*/
                $LineItem .='<td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $VenCurrency . ' '. number_format($values["amount"], 2) . '</td>
            </tr>';
            $LineItem.='</table>';

            $subtotal += $values["amount"];
            $TotalQtyReceived += $total_received;
            $TotalQtyLeft += ($ordered_qty - $total_received);




            $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
            if(!empty($salesInvSerialNo)){
                $sn=0;
                $i= 0;
                    //$LineItem .='<table style="width:98%;">';
                foreach($salesInvSerialNo as $val){
                    if($sn==0){
                       $LineItem .='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr>';
                       $LineItem .='<td style="width:'.$width1.';"></td>';
                       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem .='<td style="width:'.$width2.';"></td>';
                   }
                   $LineItem .='<td style="width:'.$width3.';">';
                   $LineItem .= '<table style="width:99%;"><tr>';
               }
               $sn++;
               $i++;
               $LineItem .= '<td style="width:33%; text-align:center;">'.trim($val).' </td>';
               if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                  $LineItem .='</tr></table>';
                  $LineItem .='</td>';
                  $LineItem .='<td style="width:'.$width4.';"></td>';
                  $LineItem .='<td style="width:'.$width5.';"></td>';
                  $LineItem .='<td style="width:'.$width6.';"></td>';
                  $LineItem .='<td style="width:'.$width7.';"></td>';
                  $LineItem .='<td style="width:'.$width10.';"></td>';
                  
                  $LineItem .='</tr>';
                  $LineItem.='</table>';
                      //if($i%5==1){
                        //break;
                        //$LineItem .= '<tr><td colspan="3"></td></tr>';
                      //}
                  $sn=0;
              }
                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
          }
                    //$LineItem .='</table>';

      }
}//endforeach

      

        $subtotal = number_format($subtotal,2);
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);    
        $Freight = number_format($arryPurchase[0]['Freight'],2);
        $PrepaidAmount = number_format($arryPurchase[0]['PrepaidAmount'],2); 
        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);
	 $PrepaidAmountTxt = '';
        if($arryPurchase[0]['PrepaidFreight']=='1'){   
                $PrepaidAmountTxt = $PrepaidAmount;
        }

        $TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight Cost : ".$Freight.$PrepaidAmountTxt."\nGrand Total : ".$TotalAmount;




    }//endif
    


    $TotalDataShowArry = array('Subtotal' => $VenCurrency . ' ' .$subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight,'Prepaid Freight'=>$PrepaidAmountTxt,  'GrandTotal' => $VenCurrency . ' ' . $TotalAmount);

}

else if($ModDepName == 'Quote') {
    $rr=5;
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        
        $width1='11%';
        $width2='8%';
        $width3='43%';
        $width4='6%';
        $width5='12%';
        $width6='8%';
      
        $width9='8%';
        $width10='5%';
       
        $width13='12%';
    }
    else{
        $width1='12%';
     
        $width3='43%';
        $width4='6%';
        $width5='12%';
        $width6='7%';
       
        $width9='8%';
        $width10='6%';
        
        $width13='12%';
   }
    
    $LineItem = '<div style="page-break-inside:avoid;"><table style="width:100%; clear:both; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
   <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
    
  
    $LineItem .= '<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
        
    <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty </td>
    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price </td>
    <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount </td>';

    $LineItem .='
    <td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable </td>';
    

    $LineItem .= '<td style="width:'.$width13.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table></div>';
   
 $Line = 0;
        $subtotal = 0;
        $total_received = 0;

    if (is_array($arryQuoteItem) && $NumLine > 0) {
        $flag = true;
       
        foreach ($arryQuoteItem as $key => $values) {
            $flag = !$flag;
            $Line++;
            
            if (($Line % 2) != '1') {
                $even = 'background:#ececec';
            } else {
                $even = '';
            }
            $ordered_qty = $values["qty"];
            $qty_invoiced = $values["qty_invoiced"];
            $qty_returned = $values["qty_returned"];
            
           
            
            if (!empty($values["RateDescription"]))
                $Rate = $values["RateDescription"] . ' : ';
                else
                    $Rate = '';
                    $TaxRate = $Rate . number_format($values["tax"], 2);
                    
                    
                    
                    $sku = stripslashes($values["sku"]);
                    
                    
                                        
                    $LineItem.='<div style="page-break-inside:avoid;"><table style="width:100%; clear:both; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=' . $even . '>
            <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                    $new_sku = wordwrap(stripslashes($values["sku"]), 10, "<br />", true);
                    $LineItem.="$new_sku<br />";
                    $LineItem.='</td>';
                    
                    $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                        
                <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                    //$Type
                    $new_Type = wordwrap(stripslashes($values['qty']), 7, "<br />", true);
                    $LineItem.="$new_Type<br />";
                    $LineItem.= '</td>
                    
                    <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryQuote[0]['CustomerCurrency']." ".stripslashes($values["price"]) . '</td>
                        
                    <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values ["discount"] . '</td>
                    <td style="width:'.$width9.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values["Taxable"] . '</td>';
               
                    
                    $LineItem.= '<td style="width:'.$width13.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryQuote[0]['CustomerCurrency']."  ".number_format($values["amount"], 2) . '</td>
                </tr></table></div>';
                    
                    
                    
                    if(!empty($values["DesComment"]))  $description .= "\n<b>Comments: </b>".stripslashes($values["DesComment"]);
                    $subtotal += $values["amount"];
                    
                    $discount += $values["discount"];
                    $TotalQtyReceived += $total_received;
                   
                    $TotalQtyLeft += ($ordered_qty - $total_received);
        }//end main foreach
    }//end if
    $CustDisAmt = $arryQuote[0]['CustomerCurrency']." ".number_format($arryQuote[0]['CustDisAmt'],2);
    $subtotal = $arryQuote[0]['CustomerCurrency']." ".number_format($subtotal,2);
    $Freight = (!empty($arryQuote[0]['9acf9a']))?($arryQuote[0]['9acf9a']):(" ");
    $Freight .= number_format($arryQuote[0]['Freight'],2);
    $taxAmnt =  number_format($arryQuote[0]['taxAmnt'],2,'.','');
    $TotalAmount = $arryQuote[0]['CustomerCurrency']." ".number_format($arryQuote[0]['TotalAmount'],2);
    
   

    //$TDiscount = number_format($arrySale[0]['TDiscount'], 2);
    
    if (!empty($arrySale[0] ['ReSt'])) {
        $ReStocking = number_format($arrySale[0]['ReStocking'], 2);
    }
    
    $TotalDataShowArry = array('Subtotal: ' => $subtotal, 'tax: ' => $taxAmnt, 'Freight: ' => $Freight ,  'Grand Total: ' => $TotalAmount);
    
    }
/* * **Line Item Data** */
?>
