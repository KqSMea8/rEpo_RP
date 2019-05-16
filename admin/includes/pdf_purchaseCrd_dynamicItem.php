<?php
 
       $width1='15%';
       $width2='42%';
       $width3='9%';
       $width4='13%';
       $width5='8%';
       $width6='13%';
       

	/***********/	
	$TotalBalanceArry=array();			
 	if($arryPurchase[0]['PostToGL'] == "1" && $arryPurchase[0]['Status']=='Part Applied'){   
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentCredit($arryPurchase[0]['CreditID'],"Purchase");  
	     	if(!empty($paidOrderAmnt)){ 	
		      $Balance =  $arryPurchase[0]['TotalAmount'] -$paidOrderAmnt; 
		       if($Balance>0) $TotalBalanceArry = array( '<span style="color:red">Balance:</span> ' => '<span style="color:red">'.$arryPurchase[0]['Currency'].' '.number_format($Balance,2).'</span>');	
	        }
	}
	/***********/


   if(empty($arryPurchase[0]['AccountID'])){
        $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
           <td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
           <td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty</td>
           <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>
           <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>
           <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>

       </tr></table>';
$subtotal = $TotalQtyReceived = 0;
            

       if (is_array($arryPurchaseItem) && $NumLine > 0) {
        $flag = true;
        $Line = 0;
        $subtotal = 0;
        $total_received = 0;
        foreach ($arryPurchaseItem as $key => $values) {
            //echo '<pre>';print_r($values);die;
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
            //. stripslashes($values["sku"]) . '</td>
                $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);
                $LineItem.="$new_sku<br />";
                $LineItem.='</td>
                <td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                <td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["qty"]) . '</td>
                <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['Currency'] . ' ' .number_format($values["price"], 2) .$priceBC. '</td>
                <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>
                <td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['Currency'] . ' ' .number_format($values["amount"], 2).$amountBC. '</td>
            </tr></table>';
            //echo $values["SerialNumbers"];
            $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
           /***code for new serial number***/
 
           if(!empty($salesInvSerialNo)){
            $sn=0;
            $i= 0;

            foreach($salesInvSerialNo as $val){
                //echo $val;
               if($sn==0){
                $LineItem .='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . ';vertical-align: top;">';
                $LineItem .='<td style="width:'.$width1.';"></td>';
                
                $LineItem .='<td style="width:'.$width2.';">';
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
                $LineItem .='<td style="width:'.$width3.';"></td>';
                $LineItem .='<td style="width:'.$width4.';"></td>';
                $LineItem .='<td style="width:'.$width5.';"></td>';
                $LineItem .='<td style="width:'.$width6.';"></td>';
                   
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
        }//foreach
        $subtotal1 = $subtotal;
 


        $taxAmnt = $arryPurchase[0]['taxAmnt'];
        $Freight = $arryPurchase[0]['Freight'];

	$Restocking_fee='0.00';
	$ReStockingAmnt='0.00';
   	if($arryPurchase[0]['Restocking'] == 1 && $arryPurchase[0]['Restocking_fee']>0) {
		$Restocking_fee = number_format($arryPurchase[0]['Restocking_fee'], 2);  
		$ReStockingAmnt=$arryPurchase[0]['Restocking_fee'];  
        }


        $TotalAmount = $arryPurchase[0]['TotalAmount'];
        //$TotalAmount = $subtotal + $taxAmnt + $Freight;



	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';$ReStockingBC='';
       /* if($arryPurchase[0]['Currency'] != $Config['Currency']){   
		  $subtotalBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $subtotal) ,2);
		  $subtotalBC = '<br><span style="color:red">('.$subtotalBC.' '.$Config['Currency'].')</span>';
		  $taxAmntBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $taxAmnt) ,2);
		  $taxAmntBC = '<br><span style="color:red">('.$taxAmntBC.' '.$Config['Currency'].')</span>';
		  $FreightBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $Freight) ,2);
		  $FreightBC = '<br><span style="color:red">('.$FreightBC.' '.$Config['Currency'].')</span>';

		 $ReStockingBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $ReStockingAmnt) ,2);
		 $ReStockingBC = '<br><span style="color:red">('.$ReStockingBC.' '.$Config['Currency'].')</span>';

		  $TotalAmountBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $TotalAmount) ,2);
		  $TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	
	}	
	/***************************/



        $TotalDataShowArry = array('Subtotal: ' => $arryPurchase[0]['Currency'] . ' ' .number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC,'Re-Stocking Fee: ' => '('.$Restocking_fee.')'.$ReStockingBC, $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $arryPurchase[0]['Currency'] . ' ' . number_format($TotalAmount,2).$TotalAmountBC);
    }//if condition
    //$LineItem.='</table>';


   
}else{  //Gl Credit Memo

	$TotalAmount = $arryPurchase[0]['TotalAmount'];
	/***************************/
	$TotalAmountBC='';
	/*if($arryPurchase[0]['Currency'] != $Config['Currency']){ 
		$TotalAmountBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $TotalAmount) ,2);
		$TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	}	
	/***************************/

	$TotalDataShowArry = array( 'Grand Total: ' => $arryPurchase[0]['Currency'].' '.number_format($TotalAmount,2).$TotalAmountBC);

}

	if(!empty($TotalBalanceArry)){
		$TotalDataShowArry = array_merge($TotalDataShowArry, $TotalBalanceArry);	
	}

?>
