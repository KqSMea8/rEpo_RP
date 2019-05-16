<?php

 
//$TitleShow = '<td style="width:50%;font-size:' . $TitleFontSize . 'px; font-weight:' . $TitleWeight . '; color:' . $TitleColor . ';display:inline-block;  margin-top:0px; vertical-align:top;text-align:left" >' . $Title . '</td>';
$TitleShow = '<td style="width:45%;font-size:' . $TitleFontSize . 'px; font-weight:' . $TitleWeight . '; color:' . $TitleColor . ';display:inline-block;  margin-top:0px;padding-top:32px; vertical-align:top;text-align:'.$infoNewAlign.'; margin-left: '.$infoNewMargin.'px;" ><table style="width:100%; cellpadding:0; cellspacing:0; margin-left: '.$infoNewMargin.'px;     text-align: '.$infoNewAlign.';">';
if (!empty($Infodata)) {
    foreach ($Infodata as $key => $val) {
        $TitleShow .='<tr>
	 		<td style="width:110px;border:none; display:inline-block; text-align:left; padding:' . $informationpaddingbl . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">' . $key . '</td>
	 		<td style="width:150px; padding:' . $informationpadding . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">' . $val . '</td>
	 	</tr>';
    }

} else {
   /* $informationdata.='<tr>
	 		<td style="width:90px;border:none; padding:' . $informationpadding . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">Infomation</td>
	 		<td style="width:140px;border:1px solid #cacaca; padding:' . $informationpadding . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">Demo</td>
	 	</tr>';*/
}
$TitleShow.='<tr>
                                   <td></td>
                                   <td></td>
                                   </tr>
                                   
                            </table>';
$TitleShow .='</td>';

$billShipppadding = '6';
//$AddressHead1 = (!empty($AddressHead1)) ? ($AddressHead1) : ('Address1');
if (!empty($Address1)) {
$AddressA = '<table style="border-collapse: collapse;">
                <tr>
                <td style="width:300px;font-size:' . $BillingFieldFontSize . 'px; background:' . $BillingHeadbackColor . '; color:' . $BillingHeadColor . '; padding:5px 10px 5px 6px; font-weight:' . $BillingHeadingBold . ';">' . $AddressHead1 . '</td>
                </tr>';

    foreach ($Address1 as $key => $value) {
        $AddressA.='<tr>
                <td style="font-size:' . $BillingFieldFontSize . 'px; line-height:18px; margin:8px 0 8px 10px; text-align:left; color:' . $BillingFieldColor . '; padding-left:' . $billShipppadding . 'px;">' . $key . '  ' . $value . '</td>
                </tr>';
    }
    $AddressA.='</table>';
} 
//else {
//    $AddressA.='<tr>
//                <td style="font-size:' . $BillingFieldFontSize . 'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $BillingFieldColor . '; padding-left:' . $billShipppadding . 'px;">Test Address1</td>
//                </tr>';
//}

//$AddressHead2 = (!empty($AddressHead2)) ? ($AddressHead2) : ('Address2');
if (!empty($Address2)) {
$AddressB = '<table style="border-collapse: collapse;">
                <tr>
                <td style="width:320px;font-size:' . $ShippingFieldFontSize . 'px; background:' . $ShippingHeadbackColor . '; color:' . $ShippingHeadColor . '; padding:5px 10px 5px 6px; font-weight:' . $ShippingHeadingBold . ';">' . $AddressHead2 . '</td>
                </tr>';

    foreach ($Address2 as $key => $value) {
        $AddressB.='<tr>
                <td style="font-size:' . $ShippingFieldFontSize . 'px; line-height:18px; margin:8px 0 8px 10px; text-align:left; color:' . $ShippingFieldColor . '; padding-left:' . $billShipppadding . 'px;">' . $key . '   ' . $value . '</td>
                </tr>';
    }
    $AddressB.='</table>';
} 
//else {
//    $AddressB.='<tr>
//                    <td style="font-size:' . $ShippingFieldFontSize . 'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $ShippingFieldColor . '; padding-left:' . $billShipppadding . 'px;">Test Address2</td>
//                    </tr>';
//}

/* * **Line Item Data** */
//require_once("includes/pdf_common_dynamicItem.php");
/* * **Line Item Data** */

$specialNotes = '<table>
                                        <tr>
                                        <td style="width:335px;font-size:' . $specialHeadFontSize . 'px; background:' . $specialHeadbackColor . '; color:' . $specialHeadcolor . '; font-weight:' . $specialHeadingBold . '; padding:5px 10px 5px 6px;">Special Notes and Instructions</td>
                                        </tr>';
if (!empty($specialNotesArry)) {
    foreach ($specialNotesArry as $key => $value) {
        $specialNotes.='<tr>
                                        <td style="width:335px; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . '; line-height:18px;  text-align:left; padding-left:' . $billShipppadding . 'px;">' . $key . ' : ' . $value . '</td>
                                        </tr>';
    }
}

$specialNotes.='</table>
                                      <p style="padding-left:' . $billShipppadding . 'px; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">'.$SpecialSigned.'</p><br><br><br><br><br>';


if (!empty($TotalDataShowArry)) {
$TotalDataShow = '<table style="width:100; border:none; cellpadding:0; cellspacing:0; padding:0px;" align="right">';

    foreach ($TotalDataShowArry as $key => $value){
      $LineItemFieldColor1=$LineItemFieldColor;
       if(trim($key)=='Re-Stocking Fee:' || trim($key)=='Add\'l Discount:' || trim($key) == 'Freight Discount:'){$LineItemFieldColor1='#e51f31';}
        $TotalDataShow.='<tr>
                                    <td width="83" style="padding:5px 0px 5px 0px; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor1 . ';">' . $key . '</td>
                                    <td width="82" style="border:1px solid #cacaca;   font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor1 . ';"><span style="text-align:right;">' . $value . '</span> </td>
                                  </tr>';
                                }
    $TotalDataShow.='</table>';
}
if (!empty($PaydataArry)) {
 $PayDataShow = ' <table border="0" width="" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;">';
 
$PayDataShow.=' <tr style=" background:#004269;">';

 foreach ($PaydataArry as $key => $value){
   $PayDataShow.='<td style="width:33.4%;border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:12px; font-weight:normal; color:#fff;">'.$key.'</td>';
   }
    $PayDataShow.='</tr><tr>';
 foreach ($PaydataArry as $key => $value){
   $PayDataShow.='<td style="width:33.4%;text-align:left; font-size:12px; font-weight:normal;"> '.$value.'</td>';
 }
   
   $PayDataShow.='</tr>';
   $PayDataShow.=' </table>';
}

/* * end code for dynamic pdf by sachin* */
?>
