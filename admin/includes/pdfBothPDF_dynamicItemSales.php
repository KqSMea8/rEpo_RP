<?php

/* * **Line Item Data** */
 

(empty($LineItemSales1))?($LineItemSales1=""):("");


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
        $width2="36"+$deswidth.'%';//deswidth;
        $width3="15%";
        $width4="15%";
        $width5="10%";
        $width6="10%"; 
        $width7="9%"; 
    }

   $LineItemSales = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style="background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
        $LineItemSales.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItemSales.='<td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';

    $LineItemSales.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>

    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>';


    $LineItemSales.='<td style="width:'.$width6.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>';


    $LineItemSales.='<td style="width:'.$width7.'; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';




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

            if ($values["DropshipCheck"] == 1) {
                $DropshipCheck = 'Yes';
            } else {
                $DropshipCheck = 'No';
            }
            if (empty($values['Taxable']))
                $values['Taxable'] = 'No';


            if (!empty($values["RateDescription"]))
                $Rate = stripslashes($values["RateDescription"]) . ' : ';
            else
                $Rate = '';
            $TaxRate = $Rate . number_format($values["tax"], 2);

            $subtotal += $values["amount"];

            $description = stripslashes($values["description"]);
            if (!empty($values["DesComment"]))
                $description .= "Comments:" . stripslashes($values["DesComment"]);
          
			
			
			$LineItemSales1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr style="' . $even . '">
            <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >'; 
                $skuvalWrap=wordwrap(stripslashes($values["sku"]), 18, "<br />", true);
                $LineItemSales1.=$skuvalWrap;
                $LineItemSales1.='</td>';
                if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
                   $LineItemSales1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['Condition']) . '</td>'; 
               }

               $LineItemSales1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
               //$description = wordwrap($description, 44, "<br />", true);
               $LineItemSales1.=$description;
               $LineItemSales1.='</td>';

               $LineItemSales1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>

               <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["price"], 2) . '</td>';


               
                $LineItemSales1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>';
           

               $LineItemSales1.='<td style="width:'.$width7.';  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["amount"], 2) . '</td>
           </tr>';
           $LineItemSales1.='</table></td></tr>';
        }//endforech

        $taxAmnt = $arrySale[0]['taxAmnt'];
        $Freight = $arrySale[0]['Freight'];
        $CustDisAmt = $arrySale[0]['CustDisAmt'];
        //$subtotal = number_format($subtotal,2);

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

    //$LineItemSales.='</table>';
//    if($_GET['t']==1){
//        echo $LineItem;die('test');
//    }
//echo $LineItemSales;die('ee');
    $TotalDataShowArry = array('Subtotal' => $subtotal, 'Tax' => number_format($taxAmnt,2), 'Freight' => number_format($Freight,2), 'GrandTotal' => $TotalAmount);

/* * **Line Item Data** */

if(sizeof($arryCardTransaction)>0){
                $NumTr=0;
                $TotalCharge = 0;
                $TotalRefund = 0;
                $widthTD='20%';
                $TransatonDataHead = '<table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" >
<tbody valign="top" style="vertical-align: top; display:table;">
    <tr valign="top" style=" background:' . $LineHeadbackColor . '; vertical-align: top;">
       <td style="width:'.$widthTD.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Card Type</td>';
       $TransatonDataHead .= '<td style="width:'.$widthTD.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Card Number <br/> (Ending With)</td>';
       
        $TransatonDataHead .= '<td style="width:'.$widthTD.'; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Transaction Date &amp; Time</td>';
    
    $TransatonDataHead .= '<td style="width:'.$widthTD.'; border:1px solid #e3e3e3; vertical-align: top;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Transaction ID</td>

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
                   if ($values['TransactionDate'] > 0){
                                                $TransactionDate=date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values['TransactionDate']));} 
                    $TransatonData.="Transaction Date :".$TransactionDate;

                    $TransatonDataVal.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table id="itemtable"  style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;" ><tr style="' . $even . ';vertical-align: top;">
        <td valign="top" style="width:'.$widthTD.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
        
         $TransatonDataVal.=$CardType;

         $TransatonDataVal.='</td>';

            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $CreditCardNumber . '</td>';
            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $TransactionDate . '</td>';
            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:left; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . $values['TransactionID'] . '</td>';
            $TransatonDataVal .= '<td valign="top" style="width:'.$widthTD.';  text-align:right; vertical-align: top; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values['TotalAmount'],2).' '.$values['Currency'] . '</td></tr></table></td></tr>';
        

                }

            }
?>
