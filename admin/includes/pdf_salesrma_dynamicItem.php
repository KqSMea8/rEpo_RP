<?php

(empty($Count))?($Count="0"):("");

 $rr=5;
    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

       $width1='11%';
       $width2='8%';
       $width3='30%';
       $width4='9%';
       $width5='6%';
       $width6='7%';
       //$width7='6%';
       //$width8='5%';
       $width9='5%';
       $width10='12%';
       //$width11='7%';
       //$width12='7%';
       $width13='12%'; 
   }
   else{
       $width1='12%';
    //$width2='9%';
       $width3='35%';
       $width4='11%';
       $width5='8%';
       $width6='7%';
       //$width7='6%';
       //$width8='5%';
       $width9='5%';
       $width10='12%';
       //$width11='7%';
     //$width12='8%';
       $width13='12%';

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
    <td  style="width:'.$width9.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty</td>
    <td  style="width:'.$width10.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
    /*
    <td style="width:'.$width11.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>
    <td style="width:'.$width12.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
    $LineItem .= '<td style="width:'.$width13.'; border:1px solid #e3e3e3; color:#fff; text-left:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table></div>';
//PR($arrySale);


  $subtotal =$TotalQtyReceived = $TotalQtyLeft= 0;


if (is_array($arrySaleItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
 
    $total_received = 0;
    foreach ($arrySaleItem as $key => $values) {
        $flag = !$flag;
        $Line++;

       
 	if (($Line % 2) != '1') {
            //$even = 'background:#ececec';
	     $oddeven = 'oddrow';
        } else {
           // $even = '';
	    $oddeven = 'evenrow';
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



	/***************************/
	$amountBC='';$priceBC='';
	/*if($BCustomerCurrency != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}*/	
	/***************************/




        $LineItem.='<div style="page-break-inside:avoid;"><table style="width:100%; clear:both; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr class="'.$oddeven.'">
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
                    <td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' .$BCustomerCurrency . ' ' . number_format($values["price"], 2) . $priceBC.'</td>';
                    /* <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_received . '</td>
                    <td style="width:'.$width8.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $totalRmaQty [0]['QtyRma'] . '</td>

                    <td style="width:'.$width11.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
                    <td style="width:'.$width12.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values ['Taxable'] . '</td>*/

                    $LineItem.= '<td style="width:'.$width13.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $BCustomerCurrency . ' ' . number_format($values["amount"], 2) . $amountBC.'</td>
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
 
           $taxAmnt = $arrySale[0]['taxAmnt'];
           
           $Freight = $arrySale[0]['Freight'];
           $TotalAmount = $arrySale[0]['TotalAmount'];
           $TDiscount = number_format($arrySale[0]['TDiscount'], 2);
	$ReStocking='0.00';
           if ($arrySale[0] ['ReSt'] == 1) {
		$ReStocking = number_format($arrySale[0]['ReStocking'], 2);             
        }


	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';
       /* if($BCustomerCurrency != $Config['Currency']){   
		  $subtotalBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $subtotal) ,2);
		  $subtotalBC = '<br><span style="color:red">('.$subtotalBC.' '.$Config['Currency'].')</span>';
		  $taxAmntBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $taxAmnt) ,2);
		  $taxAmntBC = '<br><span style="color:red">('.$taxAmntBC.' '.$Config['Currency'].')</span>';
		  $FreightBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $Freight) ,2);
		  $FreightBC = '<br><span style="color:red">('.$FreightBC.' '.$Config['Currency'].')</span>';
		  $TotalAmountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2);
		  $TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	
	}*/	
	/***************************/




        $TotalDataShowArry = array('Subtotal: ' => $BCustomerCurrency . ' ' .number_format($subtotal, 2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC ,'Add\'l Discount: '=>'('.$TDiscount.')', 'Re-Stocking Fee: ' => '('.$ReStocking.')' , $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC,  'Grand Total: ' => $BCustomerCurrency . ' ' . number_format($TotalAmount,2).$TotalAmountBC);


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

?>
