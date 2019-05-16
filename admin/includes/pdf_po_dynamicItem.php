<?php


    $deswidth='';
   $desbrk='44';
   
   //PR($_SESSION);die;
    //echo $ConditionDisplay;
	if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){ 
		$deswidth='';
	}else{
	 	$deswidth='10';
	}
	
    /*if($DiscountDisplay=='hide'){
        $deswidth=$deswidth+'10';
        $desbrk='50';
    }*/



    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $width1="16%";
        $width2="10%";
        $width3="34"+$deswidth."%";
        $width4="8%";
        $width5="8%";
        $width6="12%"; 
        $width7="12%"; 
    }
    else{
        $width1="16%";
        $width2="10%";
        $width3="34"+$deswidth."%";
        $width4="8%";
        $width5="8%";
        $width6="12%"; 
        $width7="12%"; 

    }

    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){ 
        $LineItem.='<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';
    

    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>
    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Received</td>
    <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>


    <td style="width:'.$width7.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';

$TotalQtyReceived=0;
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
            //$even = 'background:#ececec';
	     $oddeven = 'oddrow';
        } else {
           // $even = '';
	    $oddeven = 'evenrow';
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


	/***************************/
	$amountBC='';$priceBC='';
	/*if($CurrencyInfo != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}	
	/***************************/


        $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr  class="'.$oddeven.'">
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
           $skuval=wordwrap(stripslashes($values["sku"]), 20, "<br />", true);
           $LineItem1.=$skuval;
           $LineItem1.='</td>';
           if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
             $LineItem1.=' <td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
         }

         $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //              $description 
         //$description = wordwrap($description, 38, "<br />", true);
         $LineItem1.=$description.'<br />'.stripslashes($values['DesComment']);
         $LineItem1.='</td>';

        

         $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>';
         if ($module != 'Quote') {
            $LineItem1.='<td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($total_received) . '</td>';
        } else {
            $LineItem1.='<td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . NOT_MENTIONED . '</td>';
        }
        $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $CurrencyInfo.' '. number_format($values["price"], 2) .$priceBC. '</td>';
            /*if ($arryPurchase[0]['OrderType'] == 'Dropship') {
                $LineItem.='<td style="width:11%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"], 2) . '</td>';
            } else {
                $LineItem.='<td style="width:11%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . NOT_MENTIONED . '</td>';
            }*/

            $LineItem1.=' <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $CurrencyInfo.' '.number_format($values["amount"], 2) .$amountBC. '</td>
        </tr>';
        $LineItem1.='</table></td></tr>';

        $subtotal += $values["amount"];
        $TotalQtyReceived += $total_received;
        }//foreach


 
        $Freight = $arryPurchase[0]['Freight'];
        //echo 
        $taxAmnt = $arryPurchase[0]['taxAmnt'];

        $TotalAmount = $arryPurchase[0]['TotalAmount'];
        
    }//not empty check array
    

	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';
        /*if($CurrencyInfo != $Config['Currency']){   
		  $subtotalBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $subtotal) ,2);
		  $subtotalBC = '<br><span style="color:red">('.$subtotalBC.' '.$Config['Currency'].')</span>';
		  $taxAmntBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $taxAmnt) ,2);
		  $taxAmntBC = '<br><span style="color:red">('.$taxAmntBC.' '.$Config['Currency'].')</span>';
		  $FreightBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $Freight) ,2);
		  $FreightBC = '<br><span style="color:red">('.$FreightBC.' '.$Config['Currency'].')</span>';
		  $TotalAmountBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $TotalAmount) ,2);
		  $TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	
	}	
	/***************************/




    if ($arryPurchase[0]['PrepaidFreight'] == 1) {
        $linePrepaidFreight = (!empty($arryPurchase[0]['PrepaidAmount'])) ? (stripslashes($arryPurchase[0]['PrepaidAmount'])) : (NOT_MENTIONED);
        $PrepaidFreightLabel = 'Prepaid Freight';
        //$TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $PrepaidFreightLabel => $linePrepaidFreight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
		$TotalDataShowArry = array('Subtotal: ' => $CurrencyInfo.' '.number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC, $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $CurrencyInfo.' '.number_format($TotalAmount,2).$TotalAmountBC);
    } else {
        $TotalDataShowArry = array('Subtotal: ' => $CurrencyInfo.' '.number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC, $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $CurrencyInfo.' '.number_format($TotalAmount,2).$TotalAmountBC);
    }

?>
