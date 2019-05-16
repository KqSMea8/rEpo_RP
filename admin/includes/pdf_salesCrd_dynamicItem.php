<?php

$deswidth='';
   $desbrk='44';
   
   //PR($_SESSION);die;
    //echo $ConditionDisplay;
    if($ConditionDisplay=='hide'){
        $deswidth='9';
    }

    /*if($DiscountDisplay=='hide'){
        $deswidth=$deswidth+'9';
        $desbrk='50';
    }*/

   if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="12%";
    $width2="9%";
    $width3="40"+$deswidth.'%';
    $width4="7%";
    $width5="12%"; //
    $width6="8%"; //
    $width7="12%"; //
    

}else{
    $width1="12%";
    $width2="9%";
    $width3="40"+$width2+$deswidth.'%';
    $width4="7%";
    $width5="12%"; //
    $width6="8%"; //
    $width7="12%"; //
}


if(!empty($NumCardTransaction)){
                $NumTr=0;
                $TotalCharge = 0;
                $TotalRefund = 0;
               $widthTD='20%';   $widthTD2='10%'; $widthTD3='30%';
                $TransatonDataHead = '<table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" >
<tbody valign="top" style="vertical-align: top; display:table;">
    <tr valign="top" style=" background:' . $LineHeadbackColor . '; vertical-align: top;">
       <td style="width:'.$widthTD2.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Card Type</td>';
       $TransatonDataHead .= '<td style="width:'.$widthTD.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Card Number <br/> (Ending With)</td>';
       
        $TransatonDataHead .= '<td style="width:'.$widthTD.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Transaction Date &amp; Time</td>';
    
    $TransatonDataHead .= '<td style="width:'.$widthTD3.'; border:1px solid #e3e3e3; vertical-align: top;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Transaction ID</td>

    <td style="width:'.$widthTD.';  clear:both; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
        </tr></tbody></table>';
                foreach ($arryCardTransaction as $key => $values) {

                  $NumTr++;
 
                  if($values['Module']=='Invoice'){
                    $PaymentFor = 'INV : '.$values['InvoiceID'];
                    //if($arrySale[0]['InvoiceEntry'] == 1){
                      if($values['TransactionType']=='Charge'){
                        $TotalCharge += $values['TotalAmount'];
                      }else if($values['TransactionType']=='Void'){
                        $TotalRefund += $values['TotalAmount'];
                      }
                    //} 
                  } 
 
 
		$CreditCardNumber='';
		if(!empty($values["CardNumber"])){	
			$CreditCardNumber = CreditCardNoLast($values["CardNumber"],$values["CardType"]);
		}
 

                   if ($values['TransactionDate'] > 0){
                                                $TransactionDate=date($arryCompany[0]['DateFormat'].' '.$arryCompany[0]['TimeFormat'], strtotime($values['TransactionDate']));} 
                    $TransatonData.="Transaction Date :".$TransactionDate;

                    $TransatonDataVal.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table id="itemtable"  style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" ><tr style="' . $even . ';vertical-align: top;">
        <td valign="top" style="width:'.$widthTD2.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
        
         $TransatonDataVal.=$values['CardType'];

         $TransatonDataVal.='</td>';

            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $CreditCardNumber . '</td>';
            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $TransactionDate . '</td>';
            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD3.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['TransactionID'] . '</td>';
            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:right; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values['TotalAmount'],2).' '.$values['Currency'] . '</td></tr></table></td></tr>';
        

                }

            }


	/***********/	
	$TotalBalanceArry=array();			
 	if($arrySale[0]['PostToGL'] == "1" && $arrySale[0]['Status']=='Part Applied'){ 		 
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentCredit($arrySale[0]['CreditID'],"Sales");
	     	if(!empty($paidOrderAmnt)){ 	
		      $Balance =  $arrySale[0]['TotalAmount'] - $paidOrderAmnt; 
		       if($Balance>0) $TotalBalanceArry = array( '<span style="color:red">Balance:</span> ' => '<span style="color:red">'.$arrySale[0]['CustomerCurrency'].' '.number_format($Balance,2).'</span>');	
	        }
	}
	/***********/



if(empty($arrySale[0]['AccountID'])){
        $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
           if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
             $LineItem .= ' <td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
         }
         $LineItem .= ' <td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
         <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>
         <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>';

         //$LineItem .= '<td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Cost</td>';
         $LineItem .= '<td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>';
         //$LineItem .= '<td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>';
         $LineItem .= '<td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>

     </tr></table>';
     if (is_array($arrySaleItem) && $NumLine > 0) {
        $flag = true;
        $Line = 0;
        $subtotal = 0;
	$total_received = $TotalQtyReceived= $TotalQtyLeft =0;
        foreach ($arrySaleItem as $key => $values) {
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
 
	    if (!empty($values["DropshipCheck"])) {
                $DropshipCheck = 'Yes';
            } else {
                $DropshipCheck = 'No';
            }
            if (empty($values['Taxable'])){
                $values['Taxable'] = 'No';
            }


	/***************************/
	$amountBC='';$priceBC='';
	/*if($BillCustomerCurrency != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}	
	/***************************/


 	

            
            $LineItem1.='<tr style="width:100%;"><td colspan="2"  style="width:100%;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr class="'.$oddeven.'">
            <td style="width:'.$width1.'; text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
           
                $new_sku = wordwrap(stripslashes($values["sku"]), 10, "<br>", true);
                $LineItem1.="$new_sku";
                $LineItem1.='</td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
                    $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
                }
                $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>
                <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $BillCustomerCurrency . ' ' . number_format($values["price"], 2) .$priceBC. '</td>';

                //$LineItem.='<td style="width:10%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"], 2) . '</td>';
                $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>';
                //$LineItem.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>';
                $LineItem1.='<td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $BillCustomerCurrency . ' ' .number_format($values["amount"], 2).$amountBC . '</td>
            </tr></table></td></tr>';
            $salesInvSerialNo=explode(',', $values["SerialNumbers"]);
            /******Start serial code****/
            if(!empty($salesInvSerialNo)){
                    $sn=0;
                    $i= 0;
                    //$LineItem .='<table style="width:98%;">';
                    foreach($salesInvSerialNo as $val){
                        if($sn==0){
                           $LineItem1 .='<tr style="vertical-align:  top;"><td colspan="2"  style="width:100%;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr>';
                           $LineItem1 .='<td style="width:'.$width1.';"></td>';
                           if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){ $LineItem1 .='<td style="width:'.$width2.';"></td>';
                       }
                       $LineItem1 .='<td style="width:'.$width3.';">';
                       $LineItem1 .= '<table style="width:99%;"><tr>';
                   }
                   $sn++;
                   $i++;
                   $LineItem1 .= '<td style="width:33%; text-align:center;">'.trim($val).'</td>';
                   if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                      $LineItem1 .='</tr></table>';
                      $LineItem1 .='</td>';
                      $LineItem1 .='<td style="width:'.$width4.';"></td>';
                      $LineItem1 .='<td style="width:'.$width5.';"></td>';
                      //if($DiscountDisplay=='show'){
                      $LineItem1 .='<td style="width:'.$width6.';"></td>';
                  //}
                      $LineItem1 .='<td style="width:'.$width7.';"></td>';
                      $LineItem1 .='</tr>';
                      $LineItem1.='</table></td></tr>';
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
          /******End serial code****/
            $subtotal += $values["amount"];
            $TotalQtyReceived += $total_received;
            $TotalQtyLeft += ($ordered_qty - $total_received);
        }//foreach
 
        $taxAmnt =  $arrySale[0]['taxAmnt'];
        $Freight =  $arrySale[0]['Freight'];
        $TotalAmount = $arrySale[0]['TotalAmount'];
	$ReStocking='0.00';
	$ReStockingAmnt='0.00';
   	if($arrySale[0]['ReSt'] == 1 && $arrySale[0]['ReStocking']>0) {
		$ReStocking = number_format($arrySale[0]['ReStocking'], 2);  
		$ReStockingAmnt=$arrySale[0]['ReStocking'];
		  
        }
	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';$ReStockingBC='';
       /* if($BillCustomerCurrency != $Config['Currency']){   
		  $subtotalBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $subtotal) ,2);
		  $subtotalBC = '<br><span style="color:red">('.$subtotalBC.' '.$Config['Currency'].')</span>';
		  $taxAmntBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $taxAmnt) ,2);
		  $taxAmntBC = '<br><span style="color:red">('.$taxAmntBC.' '.$Config['Currency'].')</span>';
		  $FreightBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $Freight) ,2);
		  $FreightBC = '<br><span style="color:red">('.$FreightBC.' '.$Config['Currency'].')</span>';

		  $ReStockingBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $ReStockingAmnt) ,2);
		  $ReStockingBC = '<br><span style="color:red">('.$ReStockingBC.' '.$Config['Currency'].')</span>';


		  $TotalAmountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2);
		  $TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	
	}	
	/***************************/


        $TotalDataShowArry = array('Subtotal: ' => $BillCustomerCurrency . ' ' .number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC , 'Re-Stocking Fee: ' => '('.$ReStocking.')'.$ReStockingBC , $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $BillCustomerCurrency . ' ' . number_format($TotalAmount,2).$TotalAmountBC);
    }//if condition
    //$LineItem.='</table>';

    
  }else{  //Gl Credit Memo

	$TotalAmount = $arrySale[0]['TotalAmount'];
	/***************************/
	$TotalAmountBC='';
	/*if($BillCustomerCurrency != $Config['Currency']){  

	$TotalAmountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2);
	$TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';

	}	
	/***************************/

	$TotalDataShowArry = array( 'Grand Total: ' => $arrySale[0]['CustomerCurrency'].' '.number_format($TotalAmount,2).$TotalAmountBC);

}
	
	if(!empty($TotalBalanceArry)){
		$TotalDataShowArry = array_merge($TotalDataShowArry, $TotalBalanceArry);	
	}

 
?>
