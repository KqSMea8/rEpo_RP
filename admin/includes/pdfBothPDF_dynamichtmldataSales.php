<?php
$TitleShowSales = '<td style="width:55%;font-size:' . $TitleFontSize . 'px; font-weight:' . $TitleWeight . '; color:' . $TitleColor . ';display:inline-block;  margin-top:0px;padding-top:32px; vertical-align:top;text-align:'.$infoNewAlign.'; margin-left: '.$infoNewMargin.'px;" ><table style="width:100%; cellpadding:0; cellspacing:0; margin-left: '.$infoNewMargin.'px;     text-align: '.$infoNewAlign.';">';
if (!empty($Infodata)) {
    foreach ($Infodata as $key => $val) {
        $TitleShowSales .='<tr>
	 		<td style="width:90px;border:none; display:inline-block; text-align:left; padding:' . $informationpaddingbl . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">' . $key . '</td>
	 		<td style="width:140px; padding:' . $informationpadding . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">' . $val . '</td>
	 	</tr>';
    }

} else {
   /* $informationdata.='<tr>
	 		<td style="width:90px;border:none; padding:' . $informationpadding . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">Infomation</td>
	 		<td style="width:140px;border:1px solid #cacaca; padding:' . $informationpadding . '; font-size:' . $informationFontSize . 'px; color:' . $informationFieldColor . ';">Demo</td>
	 	</tr>';*/
}
$TitleShowSales.='<tr>
                                   <td></td>
                                   <td></td>
                                   </tr>
                                   
                            </table>';
$TitleShowSales .='</td>';

$billShipppadding = '6';
$AddressHead1Sales = (!empty($AddressHead1)) ? ($AddressHead1) : ('Address1');
$AddressASales = '<table>
                <tr>
                <td style="width:300px;font-size:' . $BillingFieldFontSize . 'px; background:' . $BillingHeadbackColor . '; color:' . $BillingHeadColor . '; padding:5px 10px 5px 6px; font-weight:' . $BillingHeadingBold . ';">' . $AddressHead1 . '</td>
                </tr>';
if (!empty($Address1)) {
    foreach ($Address1 as $key => $value) {
        if($key==''){
            $AddressASales.='<tr>
                <td style="font-size:' . $BillingFieldFontSize . 'px;display:none; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $BillingFieldColor . '; padding-left:' . $billShipppadding . 'px;">' . $key . ' &nbsp; ' . $value . '</td>
                </tr>';
        }else{
           $AddressASales.='<tr>
                <td style="font-size:' . $BillingFieldFontSize . 'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $BillingFieldColor . '; padding-left:' . $billShipppadding . 'px;">' . $key . ' : ' . $value . '</td>
                </tr>'; 
        }
        
    }
} else {
    $AddressASales.='<tr>
                <td style="font-size:' . $BillingFieldFontSize . 'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $BillingFieldColor . '; padding-left:' . $billShipppadding . 'px;">Test Address1</td>
                </tr>';
}
$AddressASales.='</table>';
$AddressHead2Sales = (!empty($AddressHead2)) ? ($AddressHead2) : ('Address2');
$AddressBSales = '<table>
                <tr>
                <td style="width:320px;font-size:' . $ShippingFieldFontSize . 'px; background:' . $ShippingHeadbackColor . '; color:' . $ShippingHeadColor . '; padding:5px 10px 5px 6px; font-weight:' . $ShippingHeadingBold . ';">' . $AddressHead2 . '</td>
                </tr>';
if (!empty($Address2)) {
    foreach ($Address2 as $key => $value) {
        $AddressBSales.='<tr>
                <td style="font-size:' . $ShippingFieldFontSize . 'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $ShippingFieldColor . '; padding-left:' . $billShipppadding . 'px;">' . $key . ' : ' . $value . '</td>
                </tr>';
    }
} else {
    $AddressBSales.='<tr>
                    <td style="font-size:' . $ShippingFieldFontSize . 'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:' . $ShippingFieldColor . '; padding-left:' . $billShipppadding . 'px;">Test Address2</td>
                    </tr>';
}
$AddressBSales.='</table>';
/* * **Line Item Data** */
require_once("includes/pdfBothPDF_dynamicItemSales.php");
/* * **Line Item Data** */

$specialNotesSales = '<table>
                                        <tr>
                                        <td style="width:335px;font-size:' . $specialHeadFontSize . 'px; background:' . $specialHeadbackColor . '; color:' . $specialHeadcolor . '; font-weight:' . $specialHeadingBold . '; padding:5px 10px 5px 6px;">Special Notes and Instructions</td>
                                        </tr>';
if (!empty($specialNotesArry)) {
    foreach ($specialNotesArry as $key => $value) {
        $specialNotesSales.='<tr>
                                        <td style="font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . '; line-height:22px;  text-align:left; padding-left:' . $billShipppadding . 'px;">' . $key . ' : ' . $value . '</td>
                                        </tr>';
    }
}

$specialNotesSales.='</table>
                                      <p style="padding-left:' . $billShipppadding . 'px; font-size:' . $specialFieldFontSize . 'px; color:' . $specialFieldColor . ';">Once signed, please Fax mail or e-mail it to the provided address.</p><br><br><br><br><br>';



$TotalDataShowSales = '<table style="width:100; border:none; cellpadding:0; cellspacing:0;margin:0px; padding:0px;" align="right">';
if (!empty($TotalDataShowArry)) {
    foreach ($TotalDataShowArry as $key => $value)
        $TotalDataShowSales.='<tr>
                                    <td width="83" style="padding:5px 0px 5px 0px; font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';">' . $key . '</td>
                                    <td width="82" style="border:1px solid #cacaca; border-bottom:none;  font-size:' . $LineItemFontSize . 'px; color:' . $LineItemFieldColor . ';"><span style="text-align:right;">' . $value . '</span> </td>
                                  </tr>';
}
$TotalDataShowSales.='</table>';

/* * end code for dynamic pdf by sachin* */
?>