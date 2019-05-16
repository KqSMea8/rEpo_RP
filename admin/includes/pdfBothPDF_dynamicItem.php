<?php

(empty($height))?($height=""):("");
(empty($LineItem1))?($LineItem1=""):("");
(empty($TotalQtyReceived))?($TotalQtyReceived=""):("");
 

/* * **Line Item Data** */
$deswidth='';
 if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $width1="16%";
        $width2="10%";
        $width3="34"+$deswidth."%";
        $width4="12%";
        $width5="10%";
        $width6="8%"; 
        $width7="10%"; 
    }
    else{
        $width1="20%";
        $width2="10%";
        $width3="36"+$deswidth."%";
        $width4="12%";
        $width5="12%";
        $width6="10%"; 
        $width7="10%"; 
    }

    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ 
        $LineItem.='<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>

    <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>
    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Received</td>
    <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>


    <td style="width:'.$width7.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';


    if (is_array($arryPurchaseItem) && $NumLine > 0) {
        $flag = true;
        $Line = 0;
        $subtotal = 0;
        $total_received = 0;
        $PrepaidFreightLabel = '';
        foreach ($arryPurchaseItem as $key => $values) {
            $flag = !$flag;
            $Line++;

            if (($Line % 2) != '1') {
                $even = 'background:#ececec';
            } else {
                $even = '';
            }

            $total_received = $objPurchase->GetQtyReceived($values["id"]);
            $ordered_qty = $values["qty"];

            if (empty($values['Taxable']))
                $values['Taxable'] = 'No';

            if (!empty($values["RateDescription"]))
                $Rate = $values["RateDescription"] . ' : ';
            else
                $Rate = '';
            $TaxRate = $Rate . number_format($values["tax"], 2);

            $description = stripslashes($values["description"]);
            if (!empty($values["DesComment"]))
                $description .= "\n<b>Comments: </b>" . stripslashes($values["DesComment"]);
            //echo   $ordered_qty;die;           

            $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr style=' . $even . '>
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
           $skuval=wordwrap(stripslashes($values["sku"]), 20, "<br />", true);
           $LineItem1.=$skuval;
           $LineItem1.='</td>';
           if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
             $LineItem1.=' <td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
         }

         $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //              $description 
         //$description = wordwrap($description, 38, "<br />", true);
         $LineItem1.=$description;
         $LineItem1.='</td>';

         $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>';
         if ($module != 'Quote') {
            $LineItem1.='<td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($total_received) . '</td>';
        } else {
            $LineItem1.='<td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . NOT_MENTIONED . '</td>';
        }
        $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';
            /*if ($arryPurchase[0]['OrderType'] == 'Dropship') {
                $LineItem.='<td style="width:11%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"], 2) . '</td>';
            } else {
                $LineItem.='<td style="width:11%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . NOT_MENTIONED . '</td>';
            }*/

            $LineItem1.=' <td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
        </tr>';
        $LineItem1.='</table></td></tr>';

            $subtotal += $values["amount"];
            $TotalQtyReceived += $total_received;
        }//foreach


        $subtotal = number_format($subtotal, 2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);

        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'], 2);
        $TotalAmount = $CurrencyInfo . ' ' . $TotalAmount;
    }//not empty check array
    //$LineItem.='</table>';
    if ($arryPurchase[0]['PrepaidFreight'] == 1) {
        $linePrepaidFreight = (!empty($arryPurchase[0]['PrepaidAmount'])) ? (stripslashes($arryPurchase[0]['PrepaidAmount'])) : (NOT_MENTIONED);
        $PrepaidFreightLabel = 'Prepaid Freight';
        $TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight, $PrepaidFreightLabel => $linePrepaidFreight, 'GrandTotal' => $TotalAmount);
    } else {
        $TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight, 'GrandTotal' => $TotalAmount);
    }
 
/* * **Line Item Data** */
?>
