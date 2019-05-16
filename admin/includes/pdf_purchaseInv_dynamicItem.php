<?php
 

	/***********/	

	$TotalBalanceArry=array();			
	if($arryPurchase[0]['PostToGL'] == "1" && $arryPurchase[0]['InvoicePaid']=='2'){ 
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentInvoice($arryPurchase[0]['InvoiceID'],"Purchase");
	   	if(!empty($paidOrderAmnt)){ 	
		      $Balance =  $arryPurchase[0]['TotalAmount'] - $paidOrderAmnt; 
		       if($Balance>0) $TotalBalanceArry = array( '<span style="color:red">Balance:</span> ' => '<span style="color:red">'.$arryPurchase[0]['Currency'].' '.number_format($Balance,2).'</span>');	
		}
	}
	/***********/


if($arryPurchase[0]['InvoiceEntry']==0 || $arryPurchase[0]['InvoiceEntry']==1){ //Line Item
       $deswidth='';
     $desbrk='44';
   
   //PR($_SESSION);die;
    //echo $ConditionDisplay;
    if($ConditionDisplay=='hide'){
        $deswidth='12';
    }
    


    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

        $width1="12%";
        $width2="12%";
        $width3="39"+$deswidth.'%';
        //$width4="9%";
        $width5="8%";
        //$width6="10%";
        $width7="5%";
        $width8="12%";
        $width9="9%";
        $width10="12%";
    }else{
        $width1="12%";
        $width2="12%";
        $width3="39"+$deswidth.'%';
        //$width4="11%";
        $width5="8%";
        //$width6="12%";
        $width7="5%";
        $width8="12%";
        $width9="11%";
        $width10="12%";
   }


 
    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style=" background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';

       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
         $LineItem .= '<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';

     }

     $LineItem .= '<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';
    /* $LineItem .= '<td style="width:'.$width4.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Comment</td>';*/
     $LineItem .= '<td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>';
    /* $LineItem .= '<td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Total Qty Received</td>';*/
     $LineItem .= '<td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty</td>
     <td  style="width:'.$width8.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>


     <td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
 </tr></table>';
 //PR($arryPurchaseItem);
 if (is_array($arryPurchaseItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $subtotal = $TotalQtyReceived=$TotalQtyLeft=0;
    $total_received = 0;
    $DropshipCost = '';
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
       //PR($qty_ordered);die('ggg');
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

	/***************************/
	$amountBC='';$priceBC='';
	/*if($arryPurchase[0]['Currency'] != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arryPurchase[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}	
	/***************************/


        $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr class="'.$oddeven.'">
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            $skuvalWrap=wordwrap(stripslashes($values["sku"]), 10, "-<br />", true);
            $LineItem1.=$skuvalWrap;
            $LineItem1.='</td>';
            if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){ 
                $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
        }
        $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
        $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
                 //stripslashes($values["description"])
        $LineItem1 .=stripslashes($values["description"]).'-<br />';


        $LineItem1 .='</td>';
       /*$LineItem .= ' <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $DropshipCost . '</td>';*/
        $LineItem1 .= '<td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values["qty"] . '</td>';
        /*$LineItem .= '<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $total_received . '</td>';*/
        $LineItem1 .= '<td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values["qty_received"] . '</td>
        <td style="width:'.$width8.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['Currency'] . ' ' .number_format($values["price"], 2) .$priceBC. '</td>


        <td style="width:'.$width10.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arryPurchase[0]['Currency'] . ' ' .number_format($values["amount"], 2) .$amountBC . '</td>
    </tr></table></td></tr>';

    /***code for new serial number***/
    /********* Added By sanjiv *****/
    if($_GET['dwntype']=='excel'){
    	$LineItem1 .='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table>';
    	foreach($salesInvSerialNo as $val){
    		$LineItem1 .='<tr><td></td><td></td><td>'.trim($val).'</td></tr>';
    	}
    	$LineItem1.='</table></td></tr>';
    }else{
        /********* Added By sanjiv *****/
        if(!empty($salesInvSerialNo)){
            $sn=0;
            $i= 0;

            foreach($salesInvSerialNo as $val){
                if($sn==0){
                    $LineItem1 .='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px; margin-bottom:20px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . ';vertical-align: top;">';
                    $LineItem1 .='<td style="width:'.$width1.';"></td>';
                    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){ 
                        $LineItem1 .='<td style="width:'.$width2.';"></td>';}
                    $LineItem1 .='<td style="width:'.$width3.';">';
                    $LineItem1 .='<table style="width:99%;">';
                    $LineItem1 .= '<tr style="">';
                }
                $sn++;
                $i++;
                $LineItem1 .= '<td valign="top" style="width:33%;">'.$val.'</td>';
                if($sn==3 || sizeof($salesInvSerialNo)==$i ){

                  $LineItem1 .= '</tr>';
                  $LineItem1 .='</table>';
                  $LineItem1 .='</td>';
                  $LineItem1 .='<td style="width:'.$width5.';"></td>';
                  //$LineItem .='<td style="width:'.$width6.';"></td>';
                  $LineItem1 .='<td style="width:'.$width7.';"></td>';
                  $LineItem1 .='<td style="width:'.$width9.';"></td>';
                  $LineItem1 .='</tr>';
                  $LineItem1.='</table></td></tr>';
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

 
        $taxAmnt =  $arryPurchase[0]['taxAmnt'];
        $Freight =  $arryPurchase[0]['Freight'];
        $TotalAmount =  $arryPurchase[0]['TotalAmount'];
 
    }//endif
    

	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';
       /* if($arryPurchase[0]['Currency'] != $Config['Currency']){   
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
        $TotalDataShowArry = array('Subtotal: ' => $arryPurchase[0]['Currency'] . ' ' .number_format($subtotal,2).$subtotalBC, 'Freight: ' => number_format($Freight,2).$FreightBC, $PrepaidFreightLabel => number_format($linePrepaidFreight,2), $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $arryPurchase[0]['Currency'] . ' ' .number_format($TotalAmount,2).$TotalAmountBC);
    } else {
        $TotalDataShowArry = array('Subtotal: ' => $arryPurchase[0]['Currency'] . ' ' .number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC, $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $arryPurchase[0]['Currency'] . ' ' .number_format($TotalAmount,2).$TotalAmountBC);
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

 }else{	//GL INvoice



	
/******************** pdf_purchaseInv_dynamicItem.php***************/
if($arryOtherExpense[0]['GlEntryType']=="Multiple"){
$LineItem = ' <table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;"><tbody><tr style=" background:' . $LineHeadbackColor . '; vertical-align: top;">
        
        <td valign="top" style="width:45%; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">
           GL Account
        </td>
                <td valign="top" style="width:25%; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
                <td valign="top" style="width:30%; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Notes</td>
                
            </tr></tbody></table>';

	 $Line = 0;
	foreach ($arryMultiAccount as $key => $values) {
			
		 $Line++;	
		if (($Line % 2) != '1') {
		     $oddeven = 'oddrow';
		} else {
		    $oddeven = 'evenrow';
		}

		$LineItem .= '<table style="width:100%;">
					<tbody><tr class="'.$oddeven.'">
				    <td style="width:45%;text-align:left;">'.$values['AccountName']. ' ['.$values['AccountNumber'].']'.'</td>
					<td style="width:25%;text-align:left;">'.number_format($values['Amount'],2).'</td>
					<td style="width:30%;text-align:left;">'.stripslashes($values['Notes']).'</td>
		 
					</tr>					
					</tbody>
			</table>';



	}



}

/*************************************************************/





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
