<?php

$deswidth='';
   $desbrk='44';
   
   //PR($_SESSION);die;
    //echo $ConditionDisplay;
    if($ConditionDisplay=='hide'){
        $deswidth='15';
    }
    if($DiscountDisplay=='hide'){
        $deswidth=$deswidth+'10';
        $desbrk='50';
    }

    if($_SESSION['TrackInventory'] ==1 && $_SESSION['SelectOneItem']!='1'){
        $width1="20%";
        $width2="21"+$deswidth.'%';//deswidth
        $width3="15%";
        $width4="9%";
        $width5="13%";
        $width6="10%"; 
        $width7="12%"; 
    }
    else{
        $width1="20%";
        $width2="36%"+$deswidth.'%';//deswidth;
        $width3="15%";
        $width4="9%";
        $width5="13%";
        $width6="10%"; 
        $width7="12%"; 

    }
if(((empty($_GET['PickingSheet'])))){
    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style="background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] ==1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
        $LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItem.='<td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';

    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>

    <td  style="width:'.$width5.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Unit Price</td>';

if($DiscountDisplay=='show'){
    $LineItem.='<td style="width:'.$width6.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Discount</td>';
}

    $LineItem.='<td style="width:'.$width7.'; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
</tr></table>';
}else{
    $LineItem = '<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
    <tr style="background:' . $LineHeadbackColor . ';">
       <td  style="width:'.$width1.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">SKU</td>';
       if($_SESSION['TrackInventory'] ==1 && $_SESSION['SelectOneItem']!='1'){
        $LineItem.='<td  style="width:'.$width3.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Condition</td>';
    }

    $LineItem.='<td  style="width:'.$width2.'; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Description</td>';

    $LineItem.='<td  style="width:'.$width4.'; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Ordered</td>

    <td  style="width:15%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Warehouse</td>


    <td style="width:14%; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Bin Location</td>

    
</tr></table>';
}

$arryCunt=0;
$subtotal = 0;
$total_received = 0;
(empty($Freight))?($Freight="0"):("");
(empty($TDiscount))?($TDiscount="0"):("");
(empty($taxAmnt))?($taxAmnt="0"):("");
(empty($TotalAmount))?($TotalAmount="0"):("");

//PR($arrySaleItem);
if (is_array($arrySaleItem) && $NumLine > 0) {
    $flag = true;
    $Line = 0;
    $d=0;
  
 
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

        if ($values["DropshipCheck"] == 1) {
            $DropshipCheck = 'Yes';
        } else {
            $DropshipCheck = 'No';
        }
        if (empty($values['Taxable'])){
            $values['Taxable'] = 'No';
        }

       $sku=$values["sku"];



        if (!empty($values["RateDescription"])){
            $Rate = stripslashes($values["RateDescription"]) . ' : ';
        }
        else{
            $Rate = '';
        }
        $TaxRate = $Rate . number_format($values["tax"], 2);

        $subtotal += $values["amount"];

        $description = stripslashes($values["description"]);
        if (!empty($values["DesComment"])){
            $description .= "<br>" . stripslashes($values["DesComment"]);
        }
        if(((empty($_GET['PickingSheet'])))){

            if (!empty($values["description"])) {
                $arryDesCount[$d] = $values["description"];
                //$description=$arryDesCount[$d];
                $d++;
            }

            $arryCunt++;
            $kitComval='';

	$mainSku = $values["sku"];

             /*****alias Item*****/
 
      $checkProduct=$objItem->checkItemSku($values["sku"]);

    //By Chetan 9sep// 
    if(empty($checkProduct))
    {
    $arryAlias = $objItem->checkItemAliasSku($values["sku"]);

      if(!empty($arryAlias))
      {
          $mainSku = $arryAlias[0]['sku'];      
      }
    } 
	
      
      /*****alias Item*****/


	/***************************/
	$amountBC='';$priceBC='';
	/*if($arrySale[0]['CustomerCurrency'] != $Config['Currency']){ 
		$amountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["amount"]) ,2);
		$amountBC = '<br><span style="color:red">('.$amountBC.' '.$Config['Currency'].')</span>';
		$priceBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $values["price"]) ,2);
		$priceBC = '<br><span style="color:red">('.$priceBC.' '.$Config['Currency'].')</span>';
	}*/	
	/***************************/



            $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr class="'.$oddeven.'">
            <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >'; 
                $skuvalWrap=wordwrap(stripslashes($values["sku"]), 18, "<br />", true);
         if($values["parent_item_id"]==0 && !empty($values["req_item"])){
          $kitComval='<br/>(kit)';
         }
         elseif($values["parent_item_id"]>0){
          $kitComval='<br/>(component)';
         }
                $LineItem1.=$skuvalWrap;
                $LineItem1.='</td>';
                if($_SESSION['TrackInventory'] ==1 && $_SESSION['SelectOneItem']!='1' && $ConditionDisplay=='show'){
                   $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['Condition']) . '</td>'; 
               }

               $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
               //$description = wordwrap($description, 44, "<br />", true);
               $LineItem1.=$description;
               $LineItem1.='</td>';

               $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>

               <td style="width:'.$width5.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >'. $arrySale[0]['CustomerCurrency'].' '. number_format($values["price"], 2) .$priceBC. '</td>';


               if($DiscountDisplay=='show'){
                $LineItem1.='<td style="width:'.$width6.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . number_format($values["discount"], 2) . '</td>';
              }

               $LineItem1.='<td style="width:'.$width7.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' .$arrySale[0]['CustomerCurrency'].' '. number_format($values["amount"], 2).$amountBC. '</td>
           </tr>';
           $LineItem1.='</table></td></tr>';
       //}else if((!empty($values["parent_item_id"]) && ($_GET['PickingSheet']=='PickingSheet'))){
       }else{



        if (!empty($values["description"])) {
            $arryDesCount[$d] = $values["description"];
                //$description=$arryDesCount[$d];
            $d++;
        }

      /*****alias Item*****/
      $checkProduct=$objItem->checkItemSku($values["sku"]);

    //By Chetan 9sep// 
    if(empty($checkProduct))
    {
    $arryAlias = $objItem->checkItemAliasSku($values["sku"]);
      if(count($arryAlias))
      {
          $mainSku = $arryAlias[0]['sku'];      
      }
    }else{

      $mainSku = $values["sku"];
      }
      /*****alias Item*****/
    //echo $mainSku;
      if (!empty($mainSku)) { 
            
            //$arryWbin[$sku]=$objItem->GetBinBySku($values['sku']);
           $arryWbinval=$objItem->GetBinBySku($mainSku);
            }
    
    
        $arryChildCount=$objSale->GetChildCount($values['item_id']);
     
    
        $arryCunt++;
        $kitComval='';
        if($values["parent_item_id"]==0 && !empty($values["req_item"])){
          $kitComval='<br/>(kit)';
         }
         elseif($values["parent_item_id"]>0){
          $kitComval='<br/>(component)';
         }
        $LineItem1.='<tr style="vertical-align:  top;  margin:0px;padding:0px;"><td colspan="2"  style="width:100%; '.$height.' margin:0px;padding:0px;"><table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;"><tr style="' . $even . '">
        <td style="width:'.$width1.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values["sku"]).'</td>';
        if($_SESSION['TrackInventory'] ==1 && $_SESSION['SelectOneItem']!='1'){
           $LineItem1.='<td style="width:'.$width3.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['Condition']) . '</td>'; 
       }

       $LineItem1.='<td style="width:'.$width2.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >';
       //$description = wordwrap($description, 44, "<br />", true);
       $LineItem1.=$description;
       $LineItem1.='</td>';

       $LineItem1.='<td style="width:'.$width4.';  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';" >' . stripslashes($values['qty']) . '</td>

       <td style="width:15%;  text-align:left; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';">';
       //if($arryChildCount[0]['count']==0){
       //PR($arryWbinval);
       $wcount=sizeof($arryWbinval);
       if (!empty($arryWbinval)) {
        $W=1;
       //$arryWbinval= array_unique($arryWbinval);
       //PR($arryWbinval);
       foreach ($arryWbinval as $vals) {
                                    
                                    //$LineItem1.=$vals['warehouse_code'];
                                    $warehouse_codeAray[$W]=$vals['warehouse_code'];
                                    //$binlocation_nameAray[$W][$vals['warehouse_code']]=$vals['binlocation_name'];
                                    
                                    //if($W!=$wcount){$LineItem1.=',';}
                                    //if($W==2){$LineItem1.='<br/>';}
                                     $W++;
                                 }
                                 //PR($warehouse_codeAray);
                                 $warehouse_codeAray=array_unique($warehouse_codeAray);

                                 foreach($warehouse_codeAray as $uqval){
                                    $LineItem1.=$uqval.'<br/>';
                                    //echo $uqval;
                                 }
                                 //PR($binlocation_nameAray);
                                 unset($warehouse_codeAray);
                                 
                             }
                             //}

       $LineItem1.='</td>


       <td style="width:14%;  text-align:right; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';">';
       //PR($arryWbinval);
       //if($arryChildCount[0]['count']==0){
       
       if (!empty($arryWbinval)) {
        $WN=1;
       foreach ($arryWbinval as $vals) {
        
                                    $LineItem1.=$vals['binlocation_name'];
                    if($WN!=$wcount){$LineItem1.=',';}
                    if($WN==2){$LineItem1.='<br/>';}
                                     $WN++;
                                 }
                             }
                             //}

       $LineItem1.='</td>

       
   </tr>';
$LineItem1.='</table></td></tr>';
} 

}
       //endforech

$taxAmnt = $arrySale[0]['taxAmnt'];
$Freight = $arrySale[0]['Freight'];

$TDiscount=$CustDisAmt='';
if(!empty($arrySale[0]['TDiscount'])){
	$TDiscount = number_format($arrySale[0]['TDiscount'], 2);
}
if(!empty($arrySale[0]['CustDisAmt'])){
	$CustDisAmt = number_format($arrySale[0]['CustDisAmt'], 2);
 }

$TotalAmount = $subtotal + $taxAmnt + $Freight;
        // echo $TotalAmount.'<br/>';
if ($arrySale[0]['MDType'] == 'Markup') {
    $TotalAmount = $TotalAmount + $CustDisAmt;
} else if ($arrySale[0]['MDType'] == 'Discount') {
    $TotalAmount = $TotalAmount - $CustDisAmt;
}
      
       $TotalAmount = $arrySale[0]['TotalAmount'];

//$TotalAmount = $arrySale[0]['CustomerCurrency'] . ' ' . number_format($arrySale[0]['TotalAmount'], 2);
        
    }//endif
    //die;
//PR($arryWbin);die;


    
	/***************************/
	$subtotalBC='';$taxAmntBC='';$FreightBC='';$TotalAmountBC='';
        /*if($arrySale[0]['CustomerCurrency'] != $Config['Currency']){   
		  //$subtotalBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $subtotal) ,2);
		 $subtotalBC = '<br><span style="color:red">('.$subtotalBC.' '.$Config['Currency'].')</span>';
		  $taxAmntBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $taxAmnt) ,2);
		  $taxAmntBC = '<br><span style="color:red">('.$taxAmntBC.' '.$Config['Currency'].')</span>';
		  $FreightBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $Freight) ,2);
		  $FreightBC = '<br><span style="color:red">('.$FreightBC.' '.$Config['Currency'].')</span>';
		  $TotalAmountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2);
		  $TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	
	}*/
	/***************************/



   /* if(empty($_GET['PickingSheet'])){
        $TotalDataShowArry = array('Subtotal: ' => $subtotal, 'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total:' => $TotalAmount);
    }*/

    if(empty($_GET['PickingSheet'])){
        $TotalDataShowArry = array('Subtotal: ' => $arrySale[0]['CustomerCurrency'].' '.number_format($subtotal,2).$subtotalBC , 'Freight: ' => number_format($Freight,2).$FreightBC, 'Add\'l Discount: '=>'('.$TDiscount.')', $TaxCaption.': ' => number_format($taxAmnt,2).$taxAmntBC, 'Grand Total:' => $arrySale[0]['CustomerCurrency'].' '.number_format($TotalAmount,2).$TotalAmountBC );
    }

    //die('ddd');
    //$TotalDataShowArry = array('Subtotal: ' => $subtotal,  'Freight: ' => $Freight, $TaxCaption.': ' => $taxAmnt, 'Grand Total: ' => $TotalAmount);
if(!empty($arryCardTransaction)){
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
