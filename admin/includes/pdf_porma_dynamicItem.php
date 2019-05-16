<?php
 
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
       $width1='10%';
       $width2='9%';
       $width3='31%';
       $width4='9%';
       $width5='7%';
       $width6='8%';
       //$width7='5%';
       //$width8='8%';
       $width9='6%';
       $width10='10%';
       //$width11='8%';
       $width12='10%';

   }
   else{
       $width1='10%';
       //$width2='9%';
       $width3='31%';
       $width4='7%';
       $width5='7%';
       $width6='7%';
       //$width7='6%';
       //$width8='9%';
       $width9='8%';
       $width10='10%';
       //$width11='9%';
       $width12='10%';

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
    $LineItem .= '<td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty</td>
    <td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
    /*<td style="width:'.$width11.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
    $LineItem .= '<td style="width:'.$width12.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';
$TotalQtyReceived = $subtotal = $total_received = $TotalQtyLeft= 0;
(empty($ordered_qty))?($ordered_qty=""):("");  

if (is_array($arryPurchaseItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;

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

        $qty_ordered = $objPurchase->GetQtyOrderded($values["ref_id"]);
        $total_invoiced = $objPurchase->GetQtyInvoiced($values["ref_id"]);

        $total_returned = $objPurchase->GetQtyReturned($values["ref_id"]);

        $total_rma = $objPurchase->GetQtyRma($values["ref_id"]);

//            echo $qty_ordered.'--'.$total_invoiced.'---'.$total_returned.'----'.$total_rma;die('trt');

        $comment = (!empty($values["PurchaseComment"])) ? ("\r\n" . "" . stripslashes($values["PurchaseComment"])) : ("");
        if ($arryPurchase[0]['tax_auths'] == 'Yes' && $values['Taxable'] == 'Yes') {
            $TaxShowHide = 'inline';
        } else {
            $TaxShowHide = 'none';
        }

        if (empty($values['Taxable'])) {
            $values['Taxable'] = 'No';
        }


	/***************************/
	$amountBC='';$priceBC='';
	/*if($arryPurchase[0]['Currency'] != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}	
	/***************************/




        $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr class="'.$oddeven.'">
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
                
		 $Type = $objPurchase->GetRmaType($values["Type"]);
		//$LineItem.=stripslashes($values["Type"]);
		$LineItem.=stripslashes($Type);
                $LineItem.='</td>
                <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Action"]) . '</td>
                <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Reason"]) . '</td>';
               /* <td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_invoiced . '</td>
               <td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($total_rma) . '</td>*/
               $LineItem .= '<td style="width:'.$width9.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["qty"]) . '</td>
               <td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['Currency'].' '.number_format($values["price"], 2) .$priceBC. '</td>';
               /* <td style="width:'.$width11.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
               $LineItem .= '<td style="width:'.$width12.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['Currency'].' '. number_format($values["amount"], 2) .$amountBC. '</td>
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

                //$LineItem .= '<td valign="top" style="width:99%;">'.$val.'</td>';
            }
            $sn++;
            $i++;
            $LineItem .= '<td style="width:33%; text-align:center;">'.trim($val).'</td>';
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

       
	$Restocking_fee =  number_format($arryPurchase[0]['Restocking_fee'],2);
        $Freight = $arryPurchase[0]['Freight'];
        $taxAmnt = $arryPurchase[0]['taxAmnt'];
        $TotalAmount = $arryPurchase[0]['TotalAmount'];

	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';
        /*if($arryPurchase[0]['Currency'] != $Config['Currency']){   
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

    }//end if condition
    
  
    $TotalDataShowArry = array('Subtotal: ' => $arryPurchase[0]['Currency'].' '.number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2). $FreightBC, 'Re-Stocking Fee: ' => '('.$Restocking_fee.')', $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $arryPurchase[0]['Currency'].' '. number_format($TotalAmount,2).$TotalAmountBC );

    if($Restocking_fee<=0){
	unset($TotalDataShowArry['Re-Stocking Fee: ']);
   }

?>
