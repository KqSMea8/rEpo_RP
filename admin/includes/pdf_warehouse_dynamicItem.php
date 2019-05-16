<?php 
$width7='';

if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
    $width1="11%";
    $width2="9%";
    $width3="40%";
    $width4="7%";
    $width5="12%";
    $width6="8%"; 
        //$width7="9%"; 
        //$width8="9%"; 
    $width9="12%"; 
        if($_GET['Wstatus']=='Packed'){
        $width1="5"+$width1.'%';//deswidth
        $width3="8"+"9"+$width3.'%';//deswidth
        $width4="12"+$width4.'%';
        }
}
else{
    $width1="12%";
    $width2="12%";
    $width3="40%";
    $width4="10%";
    $width5="12%";
    $width6="9%"; 
    //$width7="9%"; 
    //$width8="9%"; 
    $width9="12%"; 
    if($_GET['Wstatus']=='Packed'){
    $width1="10"+$width1.'%';//deswidth
    $width3="8"+$width3.'%';//deswidth
    $width4="14"+$width4.'%';
    }
}
//echo $_GET['Wstatus'];

$LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
<tr style=" background:' . $LineHeadbackColor . ';">
   <td  style="width:'.$width1.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
   if(empty($_GET['Wstatus'])){
   if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
    $LineItem.='<td  style="width:'.$width2.';border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
}}

$LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';
if(empty($_GET['Wstatus'])){
    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Invoiced</td>';
}
else{
    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Shipped</td>';
}
if(empty($_GET['Wstatus'])){
$LineItem.='<td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Price</td>';
$LineItem.='<td  style="width:'.$width6.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Dropship</td>';
}

                                /*<td style="width:'.$width7.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>
                                <td style="width:'.$width8.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Taxable</td>*/
                                if(empty($_GET['Wstatus'])){
                                $LineItem.='<td style="width:'.$width9.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>';
                            }
                          
                           $LineItem.='</tr></table>';
    //echo '<pre>'; print_r($arrySale);
    //echo '<pre>'; print_r($arrySaleItem);die;
                            if (is_array($arrySaleItem) && $NumLine > 0) {
                                $flag = true;
                                $Line = 0;
                                $subtotal = 0;
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

                                    $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr class="'.$oddeven.'">
                                    <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["sku"]) . '</td>';
                                     if(empty($_GET['Wstatus'])){
                                    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                                        $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["Condition"]) . '</td>';
                                    }
                                }
                                    $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["description"]) . '</td>';
                                   if(empty($_GET['Wstatus'])){
                                    $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty_shipped']) . '</td>';
                                    }
                                    else{
                                        $LineItem1.='<td style="width:'.$width4.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty_shipped']) . '</td>';
                                    }
                                    if(empty($_GET['Wstatus'])){
                                    $LineItem1.='<td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $CustomerCurrency.' '.number_format($values["price"], 2) . '</td>';
                                    
                              
                                    $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $DropshipCheck . '</td>';
                                    }
                                    
	 	/*		<td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>
        <td style="width:'.$width8.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['Taxable'] . '</td>*/
        if(empty($_GET['Wstatus'])){
        $LineItem1.='<td style="width:'.$width9.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $CustomerCurrency.' '.number_format($values["amount"], 2) . '</td>';
        }
  
    $LineItem1.='</tr></table></td></tr>';
    $subtotal += $values["amount"];
    $salesInvSerialNo=explode( ',', $values["SerialNumbers"] );
    if(!empty($salesInvSerialNo)){
        $sn=0;
        $i= 0;
                    //$LineItem .='<table style="width:98%;">';
        foreach($salesInvSerialNo as $val){
            if($sn==0){
             $LineItem1 .='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" ><tr>';
            // $LineItem1 .='<td style="width:'.$width1.';"></td>';
             if(empty($_GET['Wstatus'])){
             if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){ $LineItem1 .='<td style="width:10%;"></td>';
         }
     }
         $LineItem1 .='<td style="width:90%;">';
         $LineItem1 .= '<table style="width:99%;"><tr>';
     }
     $sn++;
     $i++;
     $LineItem1 .= '<td style="width:33%; text-align:center;">'.trim($val).' </td>';
     if($sn==3 || sizeof($salesInvSerialNo)==$i ){

      $LineItem1 .='</tr></table>';
      $LineItem1 .='</td>';


      if(empty($_GET['Wstatus'])){
      //$LineItem1 .='<td style="width:'.$width5.';"></td>';
      
      //$LineItem1 .='<td style="width:'.$width6.';"></td>';
      }
      //$LineItem1 .='<td style="width:'.$width7.';"></td>';
  if(empty($_GET['Wstatus'])){
     // $LineItem1 .='<td style="width:'.$width9.';"></td>';
       }
      $LineItem1 .='</tr>';
      $LineItem1 .='</table></td></tr>';
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

	//echo $LineItem1; die;

}
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
        $TotalAmount = $CustomerCurrency . ' ' . number_format($TotalAmount,2);
        // $nw=number_format($TotalAmount,2);
        //echo $nw;die;
    }//endif

$LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;">
<td style="width:100%; height:50px;  margin:0px;padding:0px;" colspan="2">
<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;">
<tbody><tr style="">
                                    <td style="width:'.$width1.';  text-align:left; font-size:12px; color:#000;"></td>';
                                    if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                                    $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:12px; color:#000;"></td>';
                                     }
                                    $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:12px; color:#000;"></td>';
                                    if(empty($_GET['Wstatus'])){
                                    $LineItem1.='<td style="width:'.$width5.';  text-align:left; font-size:12px; color:#000;"></td>';
                                        }
                                    $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:12px; color:#000;"></td>
                                    <td style="width:'.$width7.';  text-align:left; font-size:12px; color:#000;"></td>';
                                    if(empty($_GET['Wstatus'])){
                                    $LineItem1.='<td style="width:'.$width9.';  text-align:left; font-size:12px; color:#000;"></td>';
                                      }
                                    $LineItem1.='</tr></tbody></table></td>
                                    </tr>';
    //$LineItem.='</table>';
   if(empty($_GET['Wstatus'])){
    $TotalDataShowArry = array('Subtotal' => $CustomerCurrency.' '.number_format($subtotal,2), 'Tax' => $taxAmnt, 'Freight' => $Freight,  'Actual Freight' => $ShipFreight, 'Grand Total' => $TotalAmount);
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
                                <td style="width:70%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $SerialNumbers . '</td>
	 			</tr>';
        }//endforeach

        $SerialHead.='</table>';
    }//endif*/
    
?>
