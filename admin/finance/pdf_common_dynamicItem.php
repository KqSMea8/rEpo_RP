<?php

/* * **Line Item Data** */
if($ModDepName == 'Sales') {
  require_once("includes/pdf_salesorder_dynamicItem.php");  
  
} else if ($ModDepName == 'Purchase') {
    require_once("includes/pdf_po_dynamicItem.php");

} else if ($ModDepName == 'SalesInvoice') {
  require_once("includes/pdf_salesInv_dynamicItem.php"); 
     
} else if ($ModDepName == 'SalesInvoiceGl') {
  require_once("includes/pdf_salesInvGl_dynamicItem.php"); 
     
} else if ($ModDepName == 'PurchaseInvoice') {
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
        $width3="49"+$deswidth.'%';
        //$width4="9%";
        $width5="8%";
        //$width6="10%";
        $width7="5%";
        $width8="6%";
        $width9="9%";
        $width10="10%";
    }else{
        $width1="12%";
        $width2="12%";
        $width3="50"+$deswidth.'%';
        //$width4="11%";
        $width5="10%";
        //$width6="12%";
        $width7="10%";
        $width8="8%";
        $width9="11%";
        $width10="10%";
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


     <td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
 </tr></table>';
 //PR($arryPurchaseItem);
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
        $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style=' . $even . '>
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
        <td style="width:'.$width8.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>


        <td style="width:'.$width10.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
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
      require_once("includes/pdf_salesrma_dynamicItem.php"); 
 
} else if ($ModDepName == 'PurchaseRMA') {
	require_once("includes/pdf_porma_dynamicItem.php"); 

} else if ($ModDepName == 'SalesCreditMemo') {

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
    $width3="47"+$deswidth.'%';
    $width4="7%";
    $width5="9%"; //
    $width6="8%"; //
    $width7="8%"; //
    

}else{
    $width1="12%";
    $width2="9%";
    $width3="47"+$width2+$deswidth.'%';
    $width4="7%";
    $width5="9%"; //
    $width6="8%"; //
    $width7="8%"; //
}
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
         $LineItem .= '<td  style="width:'.$width7.'; border:1px solid #e3e3e3;color:#fff;text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>

     </tr></table>';
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
            if (empty($values['Taxable'])){
                $values['Taxable'] = 'No';
            }
            
            $LineItem1.='<tr style="width:100%;"><td colspan="2"  style="width:100%;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . '">
            <td style="width:'.$width1.'; text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
           
                $new_sku = wordwrap(stripslashes($values["sku"]), 10, "<br>", true);
                $LineItem1.="$new_sku";
                $LineItem1.='</td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
                    $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
                }
                $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>
                <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';

                //$LineItem.='<td style="width:10%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"], 2) . '</td>';
                $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>';
                //$LineItem.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>';
                $LineItem1.='<td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
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
        $subtotal = number_format($subtotal, 2);
        $taxAmnt = number_format($arrySale[0]['taxAmnt'], 2);
        $Freight = number_format($arrySale[0]['Freight'], 2);
        $TotalAmount = number_format($arrySale[0]['TotalAmount'], 2);



        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $BillCustomerCurrency . ' ' . $TotalAmount);
    }//if condition
    //$LineItem.='</table>';

    
}
} else if ($ModDepName == 'PurchaseCreditMemo') {

       $width1='15%';
       $width2='51%';
       $width3='8%';
       $width4='10%';
       $width5='8%';
       $width6='8%';
       

   if(empty($arryPurchase[0]['AccountID'])){
        $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
        <tr style=" background:' . $LineHeadbackColor . ';">
           <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>
           <td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>
           <td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Qty</td>
           <td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>
           <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>
           <td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>

       </tr></table>';
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
            $LineItem.='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr style="' . $even . '">
            <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
            //. stripslashes($values["sku"]) . '</td>
                $new_sku = wordwrap(stripslashes($values["sku"]), 5, "<br />", true);
                $LineItem.="$new_sku<br />";
                $LineItem.='</td>
                <td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>
                <td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["qty"]) . '</td>
                <td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>
                <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>
                <td style="width:'.$width6.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
            </tr></table>';
            //echo $values["SerialNumbers"];
            $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
           /***code for new serial number***/
           //PR($salesInvSerialNo);
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
        $subtotal = number_format($subtotal, 2);
        $taxAmnt1 = $arryPurchase[0]['taxAmnt'];
        $Freight1 = $arryPurchase[0]['Freight'];
        $taxAmnt = number_format($arryPurchase[0]['taxAmnt'], 2);
        $Freight = number_format($arryPurchase[0]['Freight'], 2);
        $Restocking_fee =  number_format($arryPurchase[0]['Restocking_fee'],2);
        $TotalAmount = number_format($arryPurchase[0]['TotalAmount'], 2);
        $TotalAmount = number_format(($subtotal1 + $taxAmnt1 + $Freight1), 2);
        $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight,'Re-Stocking Fee: ' => '('.$Restocking_fee.')', $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $Currency . ' ' . $TotalAmount);
    }//if condition
    //$LineItem.='</table>';


   
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
        //PR($arrySale);
        $subtotaln = number_format($subtotal, 2);
        $taxAmnt = number_format($arrySale[0]['wtaxAmnt'], 2);
        $Freight = number_format($arrySale[0]['FreightAmt'], 2);
        $TDiscount = number_format($arrySale[0]['TDiscount'], 2);
        

        if ($arrySale[0]['ReSt'] == 1) {
           $ReStockingVal = number_format($arrySale[0]['ReStocking'], 2);
        }



        $TotalAmountn = $subtotal + $arrySale[0]['wtaxAmnt'] + $arrySale[0]['FreightAmt'] - $arrySale[0]['ReStocking'];
        $TotalAmount = number_format($TotalAmountn, 2, '.', ',');
    }//endif


    
    
    //$TotalDataShowArry = array('Subtotal' => $subtotaln, 'Tax' => $taxAmnt, 'Freight' => $Freight  , 'Re-Stocking Fee: ' => $ReStockingVal , 'GrandTotal' => $arrySale[0]['CustomerCurrency'] . ' ' . $TotalAmount);

    $TotalDataShowArry = array('Subtotal: ' => $subtotaln, 'Freight: ' => $Freight ,'Add\'l Discount: '=>'('.$TDiscount.')', 'Re-Stocking Fee: ' => '('.$ReStockingVal.')' , 'Tax' => $taxAmnt,  'Grand Total: ' => $arrySale[0]['CustomerCurrency'] . ' ' . $TotalAmount);

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
    


    //$TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight , 'Re-Stocking Fee' => $RestockingVal , 'GrandTotal' => $CustomerCurrency . ' ' . $TotalAmount);

     $TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, 'Re-Stocking Fee: ' => '('.$RestockingVal.')', 'Tax' => $taxAmnt, 'Grand Total: ' => $arryPurchase[0]['Currency'] . ' ' . $TotalAmount);
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

    $width1="9%";
    $width2="10%";
    $width3="49%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="8%";
    $width8="9%";
    $width9="8%";
    $width10="8%";
    
}else{
    $width1="9%";
    $width2="10%";
    $width3="49%";
    $width4="8%";
    $width5="8%";
    $width6="8%";
    $width7="8%";
    $width8="9%";
    $width9="8%";
    $width10="8%";
    
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
   
   $LineItem.='<td style="width:'.$width10.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
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
                <td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"],2) . '</td>';
                /*$LineItem.='<td style="width:'.$width8.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["DropshipCost"],2) . '</td>
                <td style="width:'.$width9.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable']. '</td>';*/
                $LineItem .='<td style="width:'.$width10.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
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
        if($arryPurchase[0]['PrepaidFreight']=='1'){   
                $PrepaidAmountTxt = $PrepaidAmount;
        }

        $TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight Cost : ".$Freight.$PrepaidAmountTxt."\nGrand Total : ".$TotalAmount;




    }//endif
    


    $TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => $taxAmnt, 'Freight' => $Freight,'Prepaid Freight'=>$PrepaidAmountTxt,  'GrandTotal' => $VenCurrency . ' ' . $TotalAmount);

}
/* * **Line Item Data** */
?>
