<?php





(!isset($_SESSION['TrackInventory']))?($_SESSION['TrackInventory']=""):("");
(!isset($_SESSION['SelectOneItem']))?($_SESSION['SelectOneItem']=""):("");

/* * **Line Item Data** */

   
     $deswidth='';
   $desbrk='44';
   
   //PR($_SESSION);die;
    //echo $ConditionDisplay;
    if($ConditionDisplay=='hide'){
        $deswidth='8';
    }

    if($DiscountDisplay=='hide'){
        $deswidth=$deswidth+'8';
        $desbrk='50';
    }

   if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){

    $width1="11"+$deswidth.'%';
    $width2="10%";
    $width3="40%";
    $width4="10%";
    $width5="7%"; //
    $width6="12%"; //
    $width7="8%"; //
    $width8="10%";
    $width9="12%"; //

}else{
    $width1="15"+$deswidth.'%';
    $width2="12%";
    $width3="36%";
    $width4="10%";
    $width5="8%";
    $width6="11%";
    $width7="7%";
    $width8="10%";
    $width9="11%";

}

	

$LineItem = '<table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" >
<tbody valign="top" style="vertical-align: top; display:table;">
    <tr valign="top" style=" background:' . $LineHeadbackColor . '; vertical-align: top;">
       <td style="width:'.$width1.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
        $LineItem .= '<td style="width:'.$width2.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }
    $LineItem .= '<td style="width:'.$width3.'; border:1px solid #e3e3e3; vertical-align: top;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>

    <td style="width:'.$width5.';  clear:both; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Invoiced</td>
    <td style="width:'.$width6.'; clear:both; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';

  if($DiscountDisplay=='show'){
    $LineItem .= '<td style="width:'.$width7.'; vertical-align: top; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>';
     }

    $LineItem .= '<td  style="width:'.$width9.'; border:1px solid #e3e3e3; color:#fff; vertical-align: top; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
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
            //$even = 'background:#ececec';
	     $oddeven = 'oddrow';
        } else {
           // $even = '';
	    $oddeven = 'evenrow';
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
        $kitComval='';

	/***************************/
	$amountBC='';$priceBC='';
	/*if($arrySale[0]['CustomerCurrency'] != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}*/	
	/***************************/



        $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table id="itemtable"  style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" ><tr  class="'.$oddeven.'">
        <td valign="top" style="width:'.$width1.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
        $skuvalWrap=wordwrap(stripslashes($values["sku"]), 12, "<br />", true);
         if($values["parent_item_id"]==0 && !empty($values["req_item"])){
          $kitComval='<br/>(kit)';
         }
         elseif($values["parent_item_id"]>0){
          $kitComval='<br/>(component)';
         }
         $LineItem1.=$skuvalWrap;

         $LineItem1.='</td>';

        if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
            $LineItem1 .= '<td valign="top" style="width:'.$width2.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
        }

	$salesInvSerialNo=array();

	if(!empty($values["SerialNumbers"])){
		$salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
	      //$salesInvSerialNo=wordwrap($values["SerialNumbers"], 14, "<br />", true);padding-top:28px;
	}
	 

        $LineItem1 .= '<td valign="top" style="width:'.$width3.'; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >
        ';

                //stripslashes($values["description"]) . '-<br />'.$salesInvSerialNo.
        $LineItem1 .=stripslashes($values["description"]);
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
                
                
                $LineItem1 .='</td>
                <td valign="top" style="width:'.$width5.'; vertical-align: top; text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty_invoiced']) . '</td>
                <td valign="top"style=" width:'.$width6.'; vertical-align: top;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arrySale[0]['CustomerCurrency'].' '.number_format($values["price"], 2) .$priceBC. '</td>';

 if($DiscountDisplay=='show'){
                $LineItem1 .='<td valign="top" style="width:'.$width7.'; vertical-align: top;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>';
            }
               $LineItem1 .= '<td valign="top" style="width:'.$width9.'; vertical-align: top; text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $arrySale[0]['CustomerCurrency'].' '. number_format($values["amount"], 2) .$amountBC. '</td>
            </tr></table></td></tr>';
            
            /***code for new serial number***/
            if(!empty($salesInvSerialNo)){
                $salesInvSerialNoarray[$ss]=$salesInvSerialNo;
                $ss++;
            }
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
                    		   
		    $arrySerialChunk = array_chunk($salesInvSerialNo,10);
 
	 
		    // New Code By PK
		    // $LineItem1 .= '<tr><td colspan="2"><table style="width:100%;"><tr>';

 
                    //foreach($salesInvSerialNo as $val){
		foreach($arrySerialChunk as $val){
			 $sn++;

			for($vll=0;$vll<10;$vll++){ 
				(empty($val[$vll]))?($val[$vll]=''):(""); 
			}

			$LineItem1 .= '<tr><td colspan="2"><table style="width:100%;">
					<tr>
					<td style="width:20%; text-align:center;">'.$val[0].'</td>
					<td style="width:20%; text-align:center;">'.$val[1].'</td>
					<td style="width:20%; text-align:center;">'.$val[2].'</td>
					<td style="width:20%; text-align:center;">'.$val[3].'</td>
					<td style="width:20%; text-align:center;">'.$val[4].'</td>
					</tr>					
					</table></td></tr>

					<tr><td colspan="2"><table style="width:100%;">
					<tr>
					<td style="width:20%; text-align:center;">'.$val[5].'</td>
					<td style="width:20%; text-align:center;">'.$val[6].'</td>
					<td style="width:20%; text-align:center;">'.$val[7].'</td>
					<td style="width:20%; text-align:center;">'.$val[8].'</td>
					<td style="width:20%; text-align:center;">'.$val[9].'</td>
					</tr>					
					</table></td></tr>
				';
					
 			 

			/*
			// New Code By PK
			$sn++;
			$LineItem1 .= '<td style="width:33%; text-align:center;">'.trim($val).'</td>';
			#if($sn==20) break;

			if($sn%3==0) $LineItem1 .= '</tr></table></td></tr>      <tr><td colspan="2"><table style="width:100%;"><tr>';
			/******************/
		
			

			

			 
			/* // Old Code By Sachin
                        if($sn==0){
                           $LineItem1 .='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr>';
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
                      $LineItem1 .='<td style="width:'.$width5.';"></td>';
                      $LineItem1 .='<td style="width:'.$width6.';"></td>';
                      if($DiscountDisplay=='show'){
                      $LineItem1 .='<td style="width:'.$width7.';"></td>';
                  }
                      $LineItem1 .='<td style="width:'.$width9.';"></td>';
                      $LineItem1 .='</tr>';
                      $LineItem1.='</table></td></tr>';
                      
                      $sn=0;
                  }*/

		 
                     
              }
                    
		/*
		// New Code By PK
		 $rem = $sn%3;
		 if($rem==1) $LineItem1 .= '<td>&nbsp;</td><td>&nbsp;</td>';
		 else  if($rem==2) $LineItem1 .= '<td>&nbsp;</td>';

		$LineItem1 .= '</tr></table></td></tr> ';
		*/
		 

 		$LineItem1 .= ' <tr class="oddrow"><td colspan="2">&nbsp;</td></tr>';


	

          }
      }
      /***code for new serial number***/




      $subtotal += $values["amount"];
        }//foreach


        $taxAmnt = $arrySale[0]['taxAmnt'];
        $Freight = $arrySale[0]['Freight'];
        $TDiscount = number_format($arrySale[0]['TDiscount'], 2);
        $ShipFreight = $arrySale[0]['ShipFreight']; 
        $CustDisAmt = $arrySale[0]['CustDisAmt'];
        $TDiscount = $arrySale[0]['TDiscount'];
	$FreightDiscount = $arrySale[0]['FreightDiscount'];
        $TotalAmount = $subtotal + $taxAmnt + $Freight + $ShipFreight -$TDiscount-$FreightDiscount;

        if ($arrySale[0]['MDType'] == 'Markup') {
            $TotalAmount = $TotalAmount + $CustDisAmt;
        } else if ($arrySale[0]['MDType'] == 'Discount') {
            $TotalAmount = $TotalAmount - $CustDisAmt;
        }
		
 
 
		
 
        // $nw=number_format($TotalAmount,2);
        //echo $nw;die;
    }//endif



/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';
	/*if($arrySale[0]['CustomerCurrency'] != $Config['Currency']){ 
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

    
    //$TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight,  'Actual Freight' => $ShipFreight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
	/*$TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);*/
    $TotalDataShowArry = array('Subtotal: ' => $arrySale[0]['CustomerCurrency'].' '.number_format($subtotal,2).$subtotalBC,  'Freight: ' => number_format($Freight,2).$FreightBC,'Add\'l Discount: '=>'('.$TDiscount.')', 'Freight Discount: '=>'('.$FreightDiscount.')'  ,$TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total: ' => $arrySale[0]['CustomerCurrency'].' '.number_format($TotalAmount,2). $TotalAmountBC);


	/***********/		
	$TotalBalanceArry=array();			
 	if($arrySale[0]['PostToGL'] == "1" && $arrySale[0]['InvoicePaid']=='Part Paid'){ 
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentInvoice($arrySale[0]['InvoiceID'],"Sales");
	   	if(!empty($paidOrderAmnt)){ 	
		      $Balance =  $arrySale[0]['TotalInvoiceAmount'] - $paidOrderAmnt; 
		       if($Balance>0) $TotalBalanceArry = array( '<span style="color:red">Balance:</span> ' => '<span style="color:red">'.$arrySale[0]['CustomerCurrency'].' '.number_format($Balance,2).'</span>');	
	        }
	}
	/***********/


	if(!empty($TotalBalanceArry)){
		$TotalDataShowArry = array_merge($TotalDataShowArry, $TotalBalanceArry);	
	}
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

/* * **Line Item Data** */


if(!empty($numCardTr)){
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
                    if($arrySale[0]['InvoiceEntry'] == 1){
                      if($values['TransactionType']=='Charge'){
                        $TotalCharge += $values['TotalAmount'];
                      }else if($values['TransactionType']=='Void'){
                        $TotalRefund += $values['TotalAmount'];
                      }
                    } 
                  }else{
                    $PaymentFor = ''.$values['SaleID'];
                    if($values['TransactionType']=='Charge'){
                      $TotalCharge += $values['TotalAmount'];
                    }else if($values['TransactionType']=='Void'){
                      $TotalRefund += $values['TotalAmount'];
                    }
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
?>
