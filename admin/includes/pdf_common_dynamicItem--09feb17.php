<?php

/* * **Line Item Data** */
if ($ModDepName == 'Sales') {
    $deswidth='';
   $desbrk='44';
   
   //PR($_SESSION);die;
    //echo $ConditionDisplay;
    if($ConditionDisplay=='hide'){
        $deswidth='15';
    }
    if($DiscountDisplay=='hide'){
        $deswidth=$deswidth+'10';
        $desbrk='50';
    }

    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $width1="20%";
        $width2="21"+$deswidth.'%';//deswidth
        $width3="15%";
        $width4="15%";
        $width5="10%";
        $width6="10%"; 
        $width7="9%"; 
    }
    else{
        $width1="20%";
        $width2="36%"+$deswidth.'%';//deswidth;
        $width3="15%";
        $width4="15%";
        $width5="10%";
        $width6="10%"; 
        $width7="9%"; 
    }
if(((empty($_GET['PickingSheet'])))){
    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style="background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
        $LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItem.='<td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';

    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>

    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>';

if($DiscountDisplay=='show'){
    $LineItem.='<td style="width:'.$width6.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>';
}

    $LineItem.='<td style="width:'.$width7.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';
}else{
    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style="background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItem.='<td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';

    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>

    <td  style="width:15%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Warehouse</td>


    <td style="width:14%; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Bin Location</td>

    
</tr></table>';
}

$arryCunt=0;
//PR($arrySaleItem);
if (is_array($arrySaleItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $d=0;
    $subtotal = 0;
    $total_received = 0;
    foreach ($arrySaleItem as $key => $values) {
        $flag = !$flag;
        $Line++;

        if (($Line % 2) != '1') {
            $even = 'background:#ececec';
        } else {
            $even = '';
        }

        if ($values["DropshipCheck"] == 1) {
            $DropshipCheck = 'Yes';
        } else {
            $DropshipCheck = 'No';
        }
        if (empty($values['Taxable'])){
            $values['Taxable'] = 'No';
        }

       $sku=$values["sku"];



        if (!empty($values["RateDescription"])){
            $Rate = stripslashes($values["RateDescription"]) . ' : ';
        }
        else{
            $Rate = '';
        }
        $TaxRate = $Rate . number_format($values["tax"], 2);

        $subtotal += $values["amount"];

        $description = stripslashes($values["description"]);
        if (!empty($values["DesComment"])){
            $description .= "Comments:" . stripslashes($values["DesComment"]);
        }
        if(((empty($_GET['PickingSheet'])))){

            if (!empty($values["description"])) {
                $arryDesCount[$d] = $values["description"];
                //$description=$arryDesCount[$d];
                $d++;
            }

            $arryCunt++;
            $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr style="' . $even . '">
            <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >'; 
                $skuvalWrap=wordwrap(stripslashes($values["sku"]), 18, "<br />", true);
                $LineItem1.=$skuvalWrap;
                $LineItem1.='</td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
                   $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['Condition']) . '</td>'; 
               }

               $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
               //$description = wordwrap($description, 44, "<br />", true);
               $LineItem1.=$description;
               $LineItem1.='</td>';

               $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>

               <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';


               if($DiscountDisplay=='show'){
                $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>';
           }

               $LineItem1.='<td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
           </tr>';
           $LineItem1.='</table></td></tr>';
       //}else if((!empty($values["parent_item_id"]) && ($_GET['PickingSheet']=='PickingSheet'))){
       }else{



        if (!empty($values["description"])) {
            $arryDesCount[$d] = $values["description"];
                //$description=$arryDesCount[$d];
            $d++;
        }
      if (!empty($values["sku"])) { 
            
            //$arryWbin[$sku]=$objItem->GetBinBySku($values['sku']);
            $arryWbinval=$objItem->GetBinBySku($values['sku']);
            }
    
    
        $arryChildCount=$objSale->GetChildCount($values['item_id']);
     
    
        $arryCunt++;
        $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr style="' . $even . '">
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["sku"]) . '</td>';
        if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
           $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['Condition']) . '</td>'; 
       }

       $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
       //$description = wordwrap($description, 44, "<br />", true);
       $LineItem1.=$description;
       $LineItem1.='</td>';

       $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>

       <td style="width:15%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';">';
       if($arryChildCount[0]['count']==0){
       foreach ($arryWbinval as $vals) {
                                    $LineItem1.=$vals['warehouse_name'];
                    
                                 }
                             }

       $LineItem1.='</td>


       <td style="width:14%;  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';">';
       if($arryChildCount[0]['count']==0){
       foreach ($arryWbinval as $vals) {
                                    $LineItem1.=$vals['binlocation_name'];
                    
                                 }
                             }

       $LineItem1.='</td>

       
   </tr>';
$LineItem1.='</table></td></tr>';
} 

}
       //endforech

$taxAmnt = number_format($arrySale[0]['taxAmnt'], 2);
$Freight = number_format($arrySale[0]['Freight'], 2);
$CustDisAmt = number_format($arrySale[0]['CustDisAmt'], 2);
$subtotal = number_format($subtotal,2);

$TotalAmount = $subtotal + $taxAmnt + $Freight;
        // echo $TotalAmount.'<br/>';
if ($arrySale[0]['MDType'] == 'Markup') {
    $TotalAmount = $TotalAmount + $CustDisAmt;
} else if ($arrySale[0]['MDType'] == 'Discount') {
    $TotalAmount = $TotalAmount - $CustDisAmt;
}
        //echo $TotalAmount;die;
        //number_format($arrySale[0]['TotalAmount'],2)$TotalAmount = number_format($TotalAmount,2,'.',',');
$TotalAmount = $arrySale[0]['CustomerCurrency'] . ' ' . number_format($arrySale[0]['TotalAmount'], 2);
        //$TotalAmount = $arrySale[0]['CustomerCurrency'] . ' ' . number_format($TotalAmount, 2, '.', ',');
    }//endif
    //die;
//PR($arryWbin);die;


    
//    if($_GET['t']==1){
//        echo $LineItem;die('test');
//    }


    if(empty($_GET['PickingSheet'])){
        $TotalDataShowArry = array('Subtotal: ' => $subtotal, 'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total:' => $TotalAmount);
    }
    //$TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
} else if ($ModDepName == 'Purchase') {

    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $width1="16%";
        $width2="10%";
        $width3="34%";
        $width4="12%";
        $width5="10%";
        $width6="8%"; 
        $width7="10%"; 
    }
    else{
        $width1="20%";
        $width2="10%";
        $width3="36%";
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
    $d=0;
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
        //if (!empty($values["DesComment"])){}
            //$description .= "<br><b>Comments: </b>" . stripslashes($values["DesComment"]);
         //$description .= "<br><b>Comments: </b>" . stripslashes($values["DesComment"]);

            //echo   $ordered_qty;die;           

        if (!empty($description)) {
            $arryDesCount[$d] = $description;
                //$description=$arryDesCount[$d];
            $d++;
        }
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
         $description = wordwrap($description, 38, "<br />", true);
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
        //echo 
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);

        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'], 2);
        $TotalAmount = $CurrencyInfo . ' ' . $TotalAmount;
    }//not empty check array
    
    if ($arryPurchase[0]['PrepaidFreight'] == 1) {
        $linePrepaidFreight = (!empty($arryPurchase[0]['PrepaidAmount'])) ? (stripslashes($arryPurchase[0]['PrepaidAmount'])) : (NOT_MENTIONED);
        $PrepaidFreightLabel = 'Prepaid Freight';
        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $PrepaidFreightLabel => $linePrepaidFreight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
    } else {
        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
    }
} else if ($ModDepName == 'SalesInvoice') {

   if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="11%";
    $width2="8%";
    $width3="52%";
    $width4="10%";
    $width5="8%"; //
    $width6="6%"; //
    $width7="8%"; //
    $width8="10%";
    $width9="7%"; //

}else{
    $width1="13%";
    $width2="11%";
    $width3="55%";
    $width4="10%";
    $width5="8%";
    $width6="8%";
    $width7="9%";
    $width8="10%";
    $width9="7%";

}

$LineItem = '<table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" >
<tbody valign="top" style="vertical-align: top; display:table;">
    <tr valign="top" style=" background:' . $LineHeadbackColor . '; vertical-align: top;">
       <td style="width:'.$width1.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem .= '<td style="width:'.$width2.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .= '<td style="width:'.$width3.'; border:1px solid #e3e3e3; vertical-align: top;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>

    <td style="width:'.$width5.';  clear:both; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Invoiced</td>
    <td style="width:'.$width6.'; clear:both; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>


    <td style="width:'.$width7.'; vertical-align: top; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>

    <td  style="width:'.$width9.'; border:1px solid #e3e3e3; color:#fff; vertical-align: top; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></tbody></table>';
    //echo '<pre>'; print_r($arrySale);
    //echo '<pre>'; print_r($arrySaleItem);die;
if (is_array($arrySaleItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = 0;
    $ss=0;
    $total_received = 0;
    foreach ($arrySaleItem as $key => $values) {
        $flag = !$flag;
        $Line++;

        if (($Line % 2) != '1') {
            $even = 'background:#ececec';
        } else {
            $even = '';
        }


        $total_received = $objSale->GetQtyInvoiced($values["id"]);
        $ordered_qty = $values["qty"];
        $sku = stripslashes($values["sku"]);

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

        if (empty($values['Taxable']))
            $values['Taxable'] = 'No';

        $LineItem.='<table id="itemtable"  style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" ><tr style="' . $even . ';vertical-align: top;">
        <td valign="top" style="width:'.$width1.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["sku"]) . '</td>';

        if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
            $LineItem .= '<td valign="top" style="width:'.$width2.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
        }
        $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
      //$salesInvSerialNo=wordwrap($values["SerialNumbers"], 14, "<br />", true);padding-top:28px;
        $LineItem .= '<td valign="top" style="width:'.$width3.'; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >
        ';

                //stripslashes($values["description"]) . '-<br />'.$salesInvSerialNo.
        $LineItem .=stripslashes($values["description"]);
                /*
                if(!empty($salesInvSerialNo)){
                    $sn=0;
                    $i= 0;
                    $LineItem .='<table style="width:99%;">';
                foreach($salesInvSerialNo as $val){
                    if($sn==0){
                    $LineItem .= '<tr style="">';
                    }
                  $sn++;
                  $i++;
                    $LineItem .= '<td valign="top" style="width:33%;">'.$val.'</td>';
                    if($sn==3 || sizeof($salesInvSerialNo)==$i ){
                      
                      $LineItem .= '</tr>';
                      $sn=0;
                    }
                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
                    }
                    $LineItem .='</table>';
                    
                }*/
                
                
                $LineItem .='</td>
                <td valign="top" style="width:'.$width5.'; vertical-align: top; text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty_invoiced']) . '</td>
                <td valign="top"style=" width:'.$width6.'; vertical-align: top;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>


                <td valign="top" style="width:'.$width7.'; vertical-align: top;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
                <td valign="top" style="width:'.$width9.'; vertical-align: top; text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
            </tr></table>';
            
            /***code for new serial number***/
            if(!empty($salesInvSerialNo)){
                $salesInvSerialNoarray[$ss]=$salesInvSerialNo;
                $ss++;
            }
            /********* Added By sanjiv *****/
            if($_GET['dwntype']=='excel'){
            	$LineItem .='<table>';
            	foreach($salesInvSerialNo as $val){
            		$LineItem .='<tr><td></td><td></td><td>'.trim($val).'</td></tr>';
            	}
            	$LineItem.='</table>';
            }else{
                /********* Added By sanjiv *****/
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
                   $LineItem .= '<td style="width:33%; text-align:center;">'.trim($val).'</td>';
                   if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                      $LineItem .='</tr></table>';
                      $LineItem .='</td>';
                      $LineItem .='<td style="width:'.$width5.';"></td>';
                      $LineItem .='<td style="width:'.$width6.';"></td>';
                      $LineItem .='<td style="width:'.$width7.';"></td>';
                      $LineItem .='<td style="width:'.$width9.';"></td>';
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
      }
      /***code for new serial number***/




      $subtotal += $values["amount"];
        }//foreach


        $taxAmnt = $arrySale[0]['taxAmnt'];
        $Freight = $arrySale[0]['Freight'];
        $ShipFreight = $arrySale[0]['ShipFreight']; 
        $CustDisAmt = $arrySale[0]['CustDisAmt'];
        $TDiscount = $arrySale[0]['TDiscount'];
        $TotalAmount = $subtotal + $taxAmnt + $Freight + $ShipFreight -$TDiscount;

        if ($arrySale[0]['MDType'] == 'Markup') {
            $TotalAmount = $TotalAmount + $CustDisAmt;
        } else if ($arrySale[0]['MDType'] == 'Discount') {
            $TotalAmount = $TotalAmount - $CustDisAmt;
        }
        $TotalAmount = $CustomerCurrency . ' ' . $TotalAmount;
        // $nw=number_format($TotalAmount,2);
        //echo $nw;die;
    }//endif


    
    $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight,  'Actual Freight' => $ShipFreight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
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
                                <td style="width:70%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                                $SerialNumbersnew=wordwrap($SerialNumbers, 70, "<br />", true);
                                $SerialHead.=$SerialNumbersnew;
                                 


                                 $SerialHead.='</td>
	 			</tr>';
        }//endforeach

        $SerialHead.='</table>';
    }//endif*/
    /*     * *code for serial number*** */
} else if ($ModDepName == 'PurchaseInvoice') {

    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

        $width1="12%";
        $width2="12%";
        $width3="24%";
        $width4="9%";
        $width5="10%";
        $width6="10%";
        $width7="9%";
        $width8="6%";
        $width9="9%";
        $width10="10%";
    }else{
        $width1="12%";
        $width2="12%";
        $width3="26%";
        $width4="11%";
        $width5="11%";
        $width6="12%";
        $width7="10%";
        $width8="8%";
        $width9="11%";
        $width10="10%";
    }

    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';

       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
         $LineItem .= '<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';

     }

     $LineItem .= '<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
     <td style="width:'.$width4.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Comment</td>
     <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>
     <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total Qty Received</td>
     <td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty Received</td>
     <td  style="width:'.$width8.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>


     <td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
 </tr></table>';
 if (is_array($arryPurchaseItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = 0;
    $total_received = 0;
    $DropshipCost = '';
    foreach ($arryPurchaseItem as $key => $values) {
        $flag = !$flag;
        $Line++;

        if (($Line % 2) != '1') {
            $even = 'background:#ececec';
        } else {
            $even = '';
        }

        $qty_ordered = $objPurchase->GetQtyOrderded($values["ref_id"]);
        $total_received = $objPurchase->GetQtyReceived($values["ref_id"]);
        $sku = stripslashes($values["sku"]);

        if (!empty($values["RateDescription"]))
            $Rate = $values["RateDescription"] . ' : ';
        else
            $Rate = '';
        $TaxRate = $Rate . number_format($values["tax"], 2);

        if (empty($values['Taxable']))
            $values['Taxable'] = 'No';

        if (!empty($values["SerialNumbers"])) {
            $arrySlNo[$sku] = $values["SerialNumbers"];
        }
        if ($arryPurchase[0]['OrderType'] == 'Dropship') {
            $DropshipCost = number_format($values["DropshipCost"], 2);
        }
        $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style=' . $even . '>
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            $skuvalWrap=wordwrap(stripslashes($values["sku"]), 10, "-<br />", true);
            $LineItem.=$skuvalWrap;
            $LineItem.='</td>';
            if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
        }
        $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
        $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                 //stripslashes($values["description"])
        $LineItem .=stripslashes($values["description"]).'-<br />';


        $LineItem .='</td>
        <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $DropshipCost . '</td>
        <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $qty_ordered . '</td>
        <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_received . '</td>
        <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values["qty_received"] . '</td>
        <td style="width:'.$width8.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>


        <td style="width:'.$width10.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
    </tr></table>';

    /***code for new serial number***/
    /********* Added By sanjiv *****/
    if($_GET['dwntype']=='excel'){
    	$LineItem .='<table>';
    	foreach($salesInvSerialNo as $val){
    		$LineItem .='<tr><td></td><td></td><td>'.trim($val).'</td></tr>';
    	}
    	$LineItem.='</table>';
    }else{
        /********* Added By sanjiv *****/
        if(!empty($salesInvSerialNo)){
            $sn=0;
            $i= 0;

            foreach($salesInvSerialNo as $val){
                if($sn==0){
                    $LineItem .='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . ';vertical-align: top;">';
                    $LineItem .='<td style="width:'.$width1.';"></td>';
                    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem .='<td style="width:'.$width2.';"></td>';}
                    $LineItem .='<td style="width:'.$width3.';">';
                    $LineItem .='<table style="width:99%;">';
                    $LineItem .= '<tr style="">';
                }
                $sn++;
                $i++;
                $LineItem .= '<td valign="top" style="width:33%;">'.$val.'</td>';
                if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                  $LineItem .= '</tr>';
                  $LineItem .='</table>';
                  $LineItem .='</td>';
                  $LineItem .='<td style="width:'.$width5.';"></td>';
                  $LineItem .='<td style="width:'.$width6.';"></td>';
                  $LineItem .='<td style="width:'.$width7.';"></td>';
                  $LineItem .='<td style="width:'.$width9.';"></td>';
                  $LineItem .='</tr>';
                  $LineItem.='</table>';
                  $sn=0;
              }
                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
          }


      }
  }
  /***code for new serial number***/
  $subtotal += $values["amount"];
  $TotalQtyReceived += $total_received;
  $TotalQtyLeft += ($ordered_qty - $total_received);
        }//endforeach

        $subtotal = number_format($subtotal, 2);
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'], 2);
        $TotalAmount = $arryPurchase[0]['Currency'] . ' ' . $TotalAmount;
    }//endif
    
    if ($arryPurchase[0]['PrepaidFreight'] == 1) {
        $linePrepaidFreight = (!empty($arryPurchase[0]['PrepaidAmount'])) ? (stripslashes($arryPurchase[0]['PrepaidAmount'])) : (NOT_MENTIONED);
        $PrepaidFreightLabel = 'Prepaid Freight';
        $TotalDataShowArry = array('Subtotal: ' => $subtotal, 'Freight: ' => $Freight, $PrepaidFreightLabel => $linePrepaidFreight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
    } else {
        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
    }
//    $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);

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
} else if ($ModDepName == 'SalesRMA') {
    $rr=5;
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

       $width1='11%';
       $width2='8%';
       $width3='41%';
       $width4='6%';
       $width5='6%';
       $width6='7%';
       //$width7='6%';
       //$width8='5%';
       $width9='8%';
       $width10='5%';
       //$width11='7%';
       //$width12='7%';
       $width13='8%';
   }
   else{
       $width1='12%';
    //$width2='9%';
       $width3='43%';
       $width4='8%';
       $width5='8%';
       $width6='7%';
       //$width7='6%';
       //$width8='5%';
       $width9='8%';
       $width10='6%';
       //$width11='7%';
     //$width12='8%';
       $width13='8%';
   }

   $LineItem = '<div style="page-break-inside:avoid;"><table style="width:100%; clear:both; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
   <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';

       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

        $LineItem .= '<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .= '<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>

    <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Type</td>
    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Action</td>
    <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Reason</td>';
    /*<td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty Invoiced</td>
    <td  style="width:'.$width8.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total RMA Qty</td>*/
    $LineItem .='
    <td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty RMA</td>
    <td  style="width:'.$width10.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
    /*
    <td style="width:'.$width11.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>
    <td style="width:'.$width12.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
    $LineItem .= '<td style="width:'.$width13.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table></div>';
if (is_array($arrySaleItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = 0;
    $total_received = 0;
    foreach ($arrySaleItem as $key => $values) {
        $flag = !$flag;
        $Line++;

        if (($Line % 2) != '1') {
            $even = 'background:#ececec';
        } else {
            $even = '';
        }
        $total_received = $objrmasale->GetQtyInvoicedRma($values["ref_id"]);
        $ordered_qty = $values["qty"];
        $qty_invoiced = $values["qty_invoiced"];
        $qty_returned = $values["qty_returned"];

        $totalRmaQty = $objrmasale->GetQtyRma($values["ref_id"]);

        if (!empty($values["RateDescription"]))
            $Rate = $values["RateDescription"] . ' : ';
        else
            $Rate = '';
        $TaxRate = $Rate . number_format($values["tax"], 2);


        if ($arrySaleItem[$Count]["DropshipCheck"] == 1) {
            $DropshipCheck = 'Yes';
        } else {
            $DropshipCheck = 'No';
            $ds = 1;
        }
        $sku = stripslashes($values["sku"]);
        if (!empty($values["SerialNumbers"])) {
            $arrySlNo[$sku] = $values["SerialNumbers"];
        }

        $Type = $objrmasale->RmaTypeValue($values["Type"]);

        $LineItem.='<div style="page-break-inside:avoid;"><table style="width:100%; clear:both; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=' . $even . '>
            <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                $new_sku = wordwrap(stripslashes($values["sku"]), 10, "<br />", true);
                $LineItem.="$new_sku<br />";
                $LineItem.='</td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

                    $LineItem.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
                }
                $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>

                <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //$Type 
                    $new_Type = wordwrap($Type, 7, "<br />", true);
                    $LineItem.="$new_Type<br />";
                    $LineItem.= '</td>
                    <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Action"]) . '</td>
                    <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Reason"]) . '</td>
                    
                    <td style="width:'.$width9.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values ["qty"] . '</td>
                    <td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';
                    /* <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_received . '</td>
                    <td style="width:'.$width8.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $totalRmaQty [0]['QtyRma'] . '</td>

                    <td style="width:'.$width11.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
                    <td style="width:'.$width12.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values ['Taxable'] . '</td>*/

                    $LineItem.= '<td style="width:'.$width13.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
                </tr></table></div>';
                $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
                /***code for new serial number***/
                
                if(!empty($salesInvSerialNo)){
                    $sn=0;
                    $i= 0;

                    foreach($salesInvSerialNo as $val){
                     if($sn==0){

                        $LineItem .='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . ';">';
                        $LineItem .='<td style="width:'.$width1.';"></td>';
                        if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

                           $LineItem .='<td style="width:'.$width2.';"></td>';
                       }
                       $LineItem .='<td style="width:'.$width3.';">';
                       $LineItem .='<table style="width:99%;">';
                       $LineItem .= '<tr style="width:99%;">';
                   }
                   $sn++;
                   $i++;

                   $LineItem .= '<td style="width:33%;font-size:10px;">'.trim($val).'</td>';

                   if($sn==3 || sizeof($salesInvSerialNo)==$i ){
                       $LineItem .= '</tr>';
                       $LineItem .='</table>';
                       $LineItem .='</td>';
                       $LineItem .='<td style="width:'.$width4.';"></td>';
                       $LineItem .='<td style="width:'.$width5.';"></td>';
                       $LineItem .='<td style="width:'.$width6.';"></td>';
                           //$LineItem .='<td style="width:'.$width7.';"></td>';
                           //$LineItem .='<td style="width:'.$width8.';"></td>';
                       $LineItem .='<td style="width:'.$width9.';"></td>';
                       $LineItem .='<td style="width:'.$width10.';"></td>';
                           //$LineItem .='<td style="width:'.$width11.';"></td>';
            //$LineItem .='<td style="width:'.$width12.';"></td>';
                       $LineItem .='<td style="width:'.$width13.';"></td>';
                       $LineItem .='</tr>';
                       $LineItem.='</table>';
                       $sn=0;
                   }


                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
               }


           }

           /***code for new serial number***/

           $subtotal += $values["amount"];
           $TotalQtyReceived += $total_received;
           $TotalQtyLeft += ($ordered_qty - $total_received);
               }//end main foreach
           }//end if
           $subtotal = number_format($subtotal, 2);
           $taxAmnt = number_format($arrySale[0]['taxAmnt'], 2);
           
           $Freight = number_format($arrySale[0]['Freight'], 2);
           $TotalAmount = number_format($arrySale[0]['TotalAmount'], 2);

           if ($arrySale[0] ['ReSt'] == 1) {
		$ReStocking = number_format($arrySale[0]['ReStocking'], 2);             
        }

        $TotalDataShowArry = array('Subtotal: ' => $subtotal, 'Freight: ' => $Freight , 'Re-Stocking Fee: ' => $ReStocking , $TaxCaption.': ' => $taxAmnt,  'Grand Total: ' => $BCustomerCurrency . ' ' . $TotalAmount);


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
            if (($Line % 2 ) != '1') {
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
} else if ($ModDepName == 'PurchaseRMA') {

    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
       $width1='8%';
       $width2='9%';
       $width3='41%';
       $width4='7%';
       $width5='7%';
       $width6='6%';
       //$width7='5%';
       //$width8='8%';
       $width9='8%';
       $width10='7%';
       //$width11='8%';
       $width12='8%';

   }
   else{
       $width1='9%';
       //$width2='9%';
       $width3='47%';
       $width4='7%';
       $width5='7%';
       $width6='7%';
       //$width7='6%';
       //$width8='9%';
       $width9='8%';
       $width10='7%';
       //$width11='9%';
       $width12='9%';

   }


   $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
   <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem .= '<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .= '<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>

    <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Type</td>
    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Action</td>
    <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Reason</td>';
    /*<td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total Qty Invoiced</td>
    <td  style="width:'.$width8.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total Qty RMA</td>*/
    $LineItem .= '<td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty RMA</td>
    <td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
    /*<td style="width:'.$width11.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
    $LineItem .= '<td style="width:'.$width12.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';

if (is_array($arryPurchaseItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = 0;
    $total_received = 0;
    foreach ($arryPurchaseItem as $key => $values) {
        $flag = !$flag;
        $Line++;

        if (($Line % 2) != '1') {
            $even = 'background:#ececec';
        } else {
            $even = '';
        }

        $qty_ordered = $objPurchase->GetQtyOrderded($values["ref_id"]);
        $total_invoiced = $objPurchase->GetQtyInvoiced($values["ref_id"]);

        $total_returned = $objPurchase->GetQtyReturned($values["ref_id"]);

        $total_rma = $objPurchase->GetQtyRma($values["ref_id"]);

//            echo $qty_ordered.'--'.$total_invoiced.'---'.$total_returned.'----'.$total_rma;die('trt');

        $comment = (!empty($values["PurchaseComment"])) ? ("\r\n" . "<b>Comment: </b>" . stripslashes($values["PurchaseComment"])) : ("");
        if ($arryPurchase[0]['tax_auths'] == 'Yes' && $values['Taxable'] == 'Yes') {
            $TaxShowHide = 'inline';
        } else {
            $TaxShowHide = 'none';
        }

        if (empty($values['Taxable'])) {
            $values['Taxable'] = 'No';
        }
        $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style=' . $even . '>
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);

            $LineItem.="$new_sku<br />";
            $LineItem.='</td>';
            if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                $LineItem.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
            }


            $LineItem.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>

            <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //stripslashes($values["Type"])
            //$new_type = wordwrap(stripslashes($values["Type"]), 5, "<br />", true);
                $LineItem.=stripslashes($values["Type"]);
                $LineItem.='</td>
                <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Action"]) . '</td>
                <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Reason"]) . '</td>';
               /* <td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_invoiced . '</td>
               <td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($total_rma) . '</td>*/
               $LineItem .= '<td style="width:'.$width9.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["qty"]) . '</td>
               <td style="width:'.$width10.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';
               /* <td style="width:'.$width11.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
               $LineItem .= '<td style="width:'.$width12.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
           </tr></table>';

           $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
           /***code for new serial number***/
           
           if(!empty($salesInvSerialNo)){
            $sn=0;
            $i= 0;

            foreach($salesInvSerialNo as $val){
               if($sn==0){
                $LineItem .='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . ';vertical-align: top;">';
                $LineItem .='<td style="width:'.$width1.';"></td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem .='<td style="width:'.$width2.';"></td>';}
                $LineItem .='<td style="width:'.$width3.';">';
                $LineItem .='<table style="width:99%;">';
                $LineItem .= '<tr style="">';

                $LineItem .= '<td valign="top" style="width:99%;">'.$val.'</td>';
            }
            $sn++;
            $i++;
            if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                $LineItem .= '</tr>';
                $LineItem .='</table>';
                $LineItem .='</td>';
                $LineItem .='<td style="width:'.$width4.';"></td>';
                $LineItem .='<td style="width:'.$width5.';"></td>';
                $LineItem .='<td style="width:'.$width6.';"></td>';
                    //$LineItem .='<td style="width:'.$width7.';"></td>';
                    //$LineItem .='<td style="width:'.$width8.';"></td>';
                $LineItem .='<td style="width:'.$width9.';"></td>';
                $LineItem .='<td style="width:'.$width10.';"></td>';
                    //$LineItem .='<td style="width:'.$width11.';"></td>';

                $LineItem .='<td style="width:'.$width12.';"></td>';
                $LineItem .='</tr>';
                $LineItem.='</table>';

                $sn=0;
            }
                    //echo "full length".sizeof($salesInvSerialNo);
                    //echo "i length".$i;
        }


    }

    /***code for new serial number***/


    $subtotal += $values["amount"];
    $TotalQtyReceived += $total_received;
    $TotalQtyLeft += ($ordered_qty - $total_received);
        }//end foreach loop

        $subtotal = number_format($subtotal, 2);
	$Restocking_fee =  number_format($arryPurchase[0]['Restocking_fee'],2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);
        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'], 2);



    }//end if condition
    
    $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, 'Re-Stocking Fee: ' => $Restocking_fee, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $arryPurchase[0]['Currency'] . ' ' . $TotalAmount);
} else if ($ModDepName == 'SalesCreditMemo') {
    if(empty($arrySale[0]['AccountID'])){
        $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:15%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
           if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
             $LineItem .= ' <td  style="width:9%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
         }
         $LineItem .= ' <td  style="width:17%; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
         <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>
         <td  style="width:12%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>

         <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Cost</td>
         <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>
         <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>
         <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>

     </tr>';
     if (is_array($arrySaleItem) && $NumLine > 0) {
        $flag = true;
        $Line = 0;
        $subtotal = 0;

        foreach ($arrySaleItem as $key => $values) {
            //echo '<pre>';print_r($values);die;
            $flag = !$flag;
            $Line++;
            $ordered_qty = $values["qty"];
            $sku = stripslashes($values["sku"]);
            if (!empty($values["RateDescription"]))
                $Rate = $values["RateDescription"] . ' : ';
            else
                $Rate = '';
            $TaxRate = $Rate . number_format($values["tax"], 2);



            if (!empty($values["SerialNumbers"])) {
                $arrySlNo[$sku] = $values["SerialNumbers"];
            }
            if ($arrySaleItem[$Count]["DropshipCheck"] == 1) {
                $DropshipCheck = 'Yes';
            } else {
                $DropshipCheck = 'No';
            }
            if (empty($values['Taxable']))
                $values['Taxable'] = 'No';
            //echo $ordered_qty.'tr'.$TaxRate;
            $LineItem.='<tr style="' . $even . '">
            <td style="width:15%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //. stripslashes($values["sku"]) . '</td>
                $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);
                $LineItem.="$new_sku<br />";
                $LineItem.='</td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                    $LineItem.='<td style="width:9%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
                }
                $LineItem.='<td style="width:17%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                <td style="width:10%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>
                <td style="width:12%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>

                <td style="width:10%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"], 2) . '</td>
                <td style="width:10%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
                <td style="width:10%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>
                <td style="width:10%;  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
            </tr>';
            $subtotal += $values["amount"];
            $TotalQtyReceived += $total_received;
            $TotalQtyLeft += ($ordered_qty - $total_received);
        }//foreach
        $subtotal = number_format($subtotal, 2);
        $taxAmnt = number_format($arrySale[0]['taxAmnt'], 2);
        $Freight = number_format($arrySale[0]['Freight'], 2);
        $TotalAmount = number_format($arrySale[0]['TotalAmount'], 2);



        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $BillCustomerCurrency . ' ' . $TotalAmount);
    }//if condition
    $LineItem.='</table>';

    /*     * *code for serial number*** */
    if (sizeof($arrySlNo) > 0) {
        $Line = 0;
        $SerialHead = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:32%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
           <td  style="width:70%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Serial Number</td>

       </tr>';

       foreach ($arrySlNo as $key => $values) {
        $Line++;
        if (($Line % 2 ) != '1') {
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
    }//endif
    /*     * *code for serial number*** */
}
} else if ($ModDepName == 'PurchaseCreditMemo') {
    if(empty($arryPurchase[0]['AccountID'])){
        $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:15%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
           <td  style="width:22%; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
           <td  style="width:15%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty</td>
           <td  style="width:20%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>
           <td  style="width:15%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>
           <td  style="width:15%; border:1px solid #e3e3e3;color:#fff;text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>

       </tr>';
       if (is_array($arryPurchaseItem) && $NumLine > 0) {
        $flag = true;
        $Line = 0;
        $subtotal = 0;
        $total_received = 0;
        foreach ($arryPurchaseItem as $key => $values) {
            //echo '<pre>';print_r($values);die;
            $flag = !$flag;
            $Line++;
            $total_received = $objPurchase->GetQtyReceived($values["id"]);
            $sku = stripslashes($values["sku"]);
            if (!empty($values["SerialNumbers"])) {
                $arrySlNo[$sku] = $values["SerialNumbers"];
            }
            $ordered_qty = $values["qty"];
            //echo $ordered_qty;die;
            if (!empty($values["RateDescription"]))
                $Rate = $values["RateDescription"] . ' : ';
            else
                $Rate = '';
            $TaxRate = $Rate . number_format($values["tax"], 2);


            if (empty($values['Taxable']))
                $values['Taxable'] = 'No';
            $LineItem.='<tr style="' . $even . '">
            <td style="width:15%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //. stripslashes($values["sku"]) . '</td>
                $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);
                $LineItem.="$new_sku<br />";
                $LineItem.='</td>
                <td style="width:22%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                <td style="width:15%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["qty"]) . '</td>
                <td style="width:20%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>
                <td style="width:15%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>
                <td style="width:15%;  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
            </tr>';
            $subtotal += $values["amount"];
            $TotalQtyReceived += $total_received;
        }//foreach
        $subtotal1 = $subtotal;
        $subtotal = number_format($subtotal, 2);
        $taxAmnt1 = $arryPurchase[0]['taxAmnt'];
        $Freight1 = $arryPurchase[0]['Freight'];
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'], 2);
        $TotalAmount = number_format(($subtotal1 + $taxAmnt1 + $Freight1), 2);
        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $Currency . ' ' . $TotalAmount);
    }//if condition
    $LineItem.='</table>';


    /*     * *code for serial number*** */
    if (sizeof($arrySlNo) > 0) {
        $Line = 0;
        $SerialHead = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:32%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
           <td  style="width:70%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Serial Number</td>

       </tr>';

       foreach ($arrySlNo as $key => $values) {
        $Line++;
        if (($Line % 2 ) != '1') {
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
    }//endif
    /*     * *code for serial number*** */
}
}




else if ($ModDepName == 'WhouseCustomerRMA') {

 if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="10%";
    $width2="10%";
    $width3="42%";
    $width4="10%";
        //$width5="10%";
    $width6="10%";
    $width7="9%";
        //$width8="10%";
        //$width9="10%";
    $width10="9%";
}else{
    $width1="13%";
        //$width2="10%";
    $width3="45%";
    $width4="11%";
        //$width5="10%";
    $width6="11%";
    $width7="10%";
        //$width8="10%";
        //$width9="10%";
    $width10="10%";
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
                                $LineItem .='<td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
                            </tr></table>';
                            if (is_array($arrySaleItem) && $NumLine > 0) {
                                $flag = true;
                                $Line = 0;
                                $subtotal = 0;
                                $d=0;
                                $ss=0;
                                $total_received = 0;
                                $Dropship = '';
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
                                        $LineItem.='<td style="width:'.$width6.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($qty_returned) . '</td>
                                        <td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';
        /*<td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
        <td style="width:'.$width9.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
        $LineItem.='<td style="width:'.$width10.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
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

        $subtotaln = number_format($subtotal, 2);
        $taxAmnt = number_format($arrySale[0]['wtaxAmnt'], 2);
        $Freight = number_format($arrySale[0]['FreightAmt'], 2);
        

        if ($arrySale[0]['ReSt'] == 1) {
           $ReStockingVal = number_format($arrySale[0]['ReStocking'], 2);
        }



        $TotalAmountn = $subtotal + $arrySale[0]['wtaxAmnt'] + $arrySale[0]['FreightAmt'] - $arrySale[0]['ReStocking'];
        $TotalAmount = number_format($TotalAmountn, 2, '.', ',');
    }//endif


    
    
    $TotalDataShowArry = array('Subtotal' => $subtotaln, 'Tax' => $taxAmnt, 'Freight' => $Freight  , 'Re-Stocking Fee: ' => $ReStockingVal , 'GrandTotal' => $arrySale[0]['CustomerCurrency'] . ' ' . $TotalAmount);

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
    require_once("includes/pdf_warehouse_dynamicItem.php");
}


else if ($ModDepName == 'WhouseVendorRMA') {

 if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="9%";
    $width2="10%";
    $width3="35%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="8%";
    //$width8="9%";
    //$width9="8%";
    $width10="8%";
    //$width11="8%";
    $width12="8%";
}else{
    $width1="9%";
    $width2="10%";
    $width3="35%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="8%";
    //$width8="9%";
    //$width9="8%";
    $width10="8%";
    //$width11="8%";
    $width12="8%";
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
   $LineItem.='<td style="width:'.$width12.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
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
            $new_description = wordwrap(stripslashes($values["description"]), 10, "<br />", true);
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
                $LineItem .='<td style="width:'.$width10.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';
                /*<td style="width:'.$width11.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
                $LineItem .='<td style="width:'.$width12.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
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
                  $LineItem .='<td style="width:'.$width12.';"></td>';
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

        $subtotal = number_format($subtotal, 2);
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $TotalAmount = number_format($arryPurchase[0]['TotalReceiptAmount'], 2);
        if ($arryRMA[0]['Restocking'] == 1) {
            $RestockingVal = number_format($arryPurchase[0]['Restocking_fee'], 2);
        }
    }//endif
    


    $TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight , 'Re-Stocking Fee' => $RestockingVal , 'GrandTotal' => $CustomerCurrency . ' ' . $TotalAmount);
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
/* * **Line Item Data** */
?>
