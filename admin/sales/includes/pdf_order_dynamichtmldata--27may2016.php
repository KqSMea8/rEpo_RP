<?php 

        /**start code for dynamic pdf Html by sachin**/
        $companyInfoShow='<td style="width:50%; margin:0px; padding:0px;'.$cmpalign.';">
 			<h1  style="font-size:'.$CompanyHeadingFieldSize.'px;margin-top:0px; color:'.$CompanyColorHeading.';">'.$Config['SiteName'].'</h1>
                              
 			       <span style="font-size:'.$CompanyFieldSize.'px; display:block; color:'.$CompanyColor.';">'.stripslashes($arryCurrentLocation[0]['Address']).", ".stripslashes($arryCurrentLocation[0]['City']).",<br>".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country'])."-".stripslashes($arryCurrentLocation[0]['ZipCode']).'</span><br/><br/>
                               
                            </td>';
        $TitleShow='<td style="width:50%;font-size:'.$TitleFontSize.'px; font-weight:'.$TitleWeight.'; color:'.$TitleColor.';display:inline-block;  margin-top:0px; vertical-align:top;text-align:left" >'.$Title.'</td>';
        $informationdata='<table style="width:289px; cellpadding:0; cellspacing:0;">
	 	<tr>
	 		<td style="width:110px;border:none; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">Order Date</td>
	 		<td style="width:159px;border:1px solid #cacaca; padding:'.$informationpadding.'; border-bottom:none; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">'.$OrderDate.'</td>
	 	</tr>
	 	 <tr>
            <td style="border:none; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.'; color:'.$informationFieldColor.';">'.$ModuleIDTitle.' #</td>
            <td style="border:1px solid #cacaca; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; border-bottom:none; color:'.$informationFieldColor.';">'.$arrySale[0][$ModuleID].'</td>
          </tr>
          <tr>
            <td style="border:none; padding:'.$informationpadding.';font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">Customer</td>
            <td style="border:1px solid #cacaca; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; border-bottom:none; color:'.$informationFieldColor.';">'.$arrySale[0]['CustomerName'].'</td>
          </tr>
          <tr>
            <td style="border:none; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">Order Status</td>
            <td style="border:1px solid #cacaca; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">'.$arrySale[0]['Status'].'</td>
          </tr>
          <tr>
            <td style="border:none; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">Sales Person</td>
            <td style="border:1px solid #cacaca; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">'.$arrySale[0]['SalesPerson'].'</td>
          </tr>
          <tr>
            <td style="border:none; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">Approved</td>
            <td style="border:1px solid #cacaca; padding:'.$informationpadding.'; font-size:'.$informationFontSize.'px; color:'.$informationFieldColor.';">'.$Approved.'</td>
          </tr>
          
          <tr>
            <td></td>
            <td></td>
          </tr>
	 	</table>';
        $Cmpanyimg='<h4 style="text-align:'.$logoAlign.';"><img src="'.$SiteLogo.'" style="width:'.$logoSize.'px;"></h4>';
        $billShipppadding='6';
        $BillingAddress='<table>
                <tr>
                <td style="width:276px;font-size:'.$BillingFieldFontSize.'px; background:'.$BillingHeadbackColor.'; color:'.$BillingHeadColor.'; padding:5px 10px 5px 6px; font-weight:'.$BillingHeadingBold.';">Billing Address</td>
                </tr>  
                
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Company Name : '.$BillCustomerCompany.'</td>
                </tr>  
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Address : '.$Address.'</td>
                </tr>  
                
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">City : '.$Billcity.'</td>
                </tr>  
                 <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">State : '.$BillState.'</td>
                </tr>
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Country : '.$BillCountry.'</td>
                </tr> 
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Zip Code : '.$BillZipCode.'</td>
                </tr> 
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Email : '.$BillEmail.'</td>
                </tr> 
                
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Mobile : '.$BillMobile.'</td>
                </tr> 
                <tr>
                <td style="font-size:'.$BillingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$BillingFieldColor.'; padding-left:'.$billShipppadding.'px;">Landline : '.$BillLandline.'</td>
                </tr> 
                

      </table>';
        
        $ShippingAddress='<table>
                <tr>
                <td style="width:322px;font-size:'.$ShippingFieldFontSize.'px; background:'.$ShippingHeadbackColor.'; color:'.$ShippingHeadColor.'; padding:5px 10px 5px 6px; font-weight:'.$ShippingHeadingBold.';">Shipping Address</td>
                </tr>  
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Company Name : '.$ShippCustomerCompany.'</td>
                </tr>  
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Address : '.$ShippingAddress.'</td>
                </tr>  
                
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">City : '.$Shippcity.'</td>
                </tr>  
                 <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">State : '.$ShippState.'</td>
                </tr>
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Country : '.$ShippCountry.'</td>
                </tr> 
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Zip Code : '.$ShippZipCode.'</td>
                </tr> 
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Email : '.$ShippEmail.'</td>
                </tr> 
               
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Mobile : '.$ShippMobile.'</td>
                </tr> 
                <tr>
                <td style="font-size:'.$ShippingFieldFontSize.'px; line-height:22px; margin:8px 0 8px 10px; text-align:left; color:'.$ShippingFieldColor.'; padding-left:'.$billShipppadding.'px;">Landline : '.$ShippLandline.'</td>
                </tr> 

      </table>';
        
        
        $LineItem='<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
	 		<tr style=" background:'.$LineHeadbackColor.';">
	 			<td  style="width:12%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">SKU</td>
                                <td  style="width:9%;border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Condition</td>
                                <td  style="width:15%; border:1px solid #e3e3e3;color:#fff; text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Description</td>
                                <td  style="width:8%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Qty Ordered</td>
                                <td  style="width:6%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Qty Invoiced</td>
                                <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Unit Price</td>
                                <td  style="width:9%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Dropship</td>
                                <td  style="width:5%; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Cost</td>
                                <td style="width:9%; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Discount</td>
                                <td style="width:8%; border:1px solid #e3e3e3; color:#fff; text-align:left; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Taxable</td>
                                <td style="width:9%; border:1px solid #e3e3e3; color:#fff; text-align:right; font-size:'.$LineItemFontSize.'px; font-weight:'.$LineItemHeadingBold.'; color:'.$LineHeadColor.';">Amount</td>
	 		</tr>';	


                        if (is_array($arrySaleItem) && $NumLine> 0) {
                            $flag = true;
                            $Line = 0;
                            $subtotal=0;
                            $total_received = 0;
                            foreach ($arrySaleItem as $key => $values) {
                                $flag = !$flag;
                                $Line++;
                                
                                if( ($Line % 2) !='1') {$even='background:#ececec';}else{ $even='';}
                                
                                if($values["DropshipCheck"] == 1){
                            $DropshipCheck = 'Yes';
                                        }else{
                                            $DropshipCheck = 'No';
                                        }
                                        if(empty($values['Taxable'])) $values['Taxable']='No';


                                        if(!empty($values["RateDescription"]))
                                                $Rate = $values["RateDescription"].' : ';
                                        else $Rate = '';
                                        $TaxRate = $Rate.number_format($values["tax"],2);

                                        $subtotal += $values["amount"];

                                        $description = stripslashes($values["description"]);
			if(!empty($values["DesComment"]))  $description .= "\n<b>Comments: </b>".stripslashes($values["DesComment"]);
	 		$LineItem.='<tr style='.$even.'>
	 			<td style="width:12%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.stripslashes($values["sku"]).'</td>
                                <td style="width:9%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.stripslashes($values["Condition"]).'</td>
	 			<td style="width:15%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.$description.'</td>
                                <td style="width:8%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.stripslashes($values['qty']).'</td>
                                <td style="width:8%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.stripslashes($values['qty_invoiced']).'</td>
	 			<td style="width:10%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.number_format($values["price"],2).'</td>
                                <td style="width:9%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.$DropshipCheck.'</td>
	 			<td style="width:5%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.number_format($values["DropshipCost"],2).'</td>
	 			<td style="width:9%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.number_format($values["discount"],2).'</td>
                                <td style="width:8%; text-align:center; text-align:left; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.$values['Taxable'].'</td>
                                <td style="width:8%; text-align:center; text-align:right; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';" >'.number_format($values["amount"],2).'</td>
	 		</tr>';	
                         
                                 } 
                                 
                                    $taxAmnt = number_format($arrySale[0]['taxAmnt'],2);	
                                    $Freight = number_format($arrySale[0]['Freight'],2);
                                    $CustDisAmt = number_format($arrySale[0]['CustDisAmt'],2);
                                    //$subtotal = number_format($subtotal,2);

                                    $TotalAmount = $subtotal+$taxAmnt+$Freight;

                                    if($arrySale[0]['MDType']=='Markup'){
                                            $TotalAmount = $TotalAmount + $CustDisAmt;
                                    }else if($arrySale[0]['MDType']=='Discount'){
                                            $TotalAmount = $TotalAmount - $CustDisAmt;
                                    }

                                    //number_format($arrySale[0]['TotalAmount'],2)
                                     ///$TotalAmount = $arrySale[0]['CustomerCurrency'].' '.number_format($TotalAmount,2,'.',',');
                                     $TotalAmount = $arrySale[0]['CustomerCurrency'].' '.number_format($arrySale[0]['TotalAmount'],2);
                                 
                        }

	 		$LineItem.='</table>';
                        
                        
         $specialNotes='<table>
                                        <tr>
                                        <td style="width:335px;font-size:'.$specialHeadFontSize.'px; background:'.$specialHeadbackColor.'; color:'.$specialHeadcolor.'; font-weight:'.$specialHeadingBold.'; padding:5px 10px 5px 6px;">Special Notes and Instructions</td>
                                        </tr>  
                                        <tr>
                                        <td style="font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.'; line-height:22px;  text-align:left; padding-left:'.$billShipppadding.'px;">Delivery Date : '.$DeliveryDate.'</td>
                                        </tr>  
                                        <tr>
                                        <td style=" font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.'; line-height:22px;  text-align:left; padding-left:'.$billShipppadding.'px;"> Payment Term : '.$PaymentTerm.'</td>
                                        </tr>  
                                        <tr>
                                        <td style=" font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.'; line-height:22px;  text-align:left; padding-left:'.$billShipppadding.'px;">Payment Method : '.$PaymentMethod.'</td>
                                        </tr>  
                                        <tr>
                                        <td style=" font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.'; line-height:22px;  text-align:left; padding-left:'.$billShipppadding.'px;">Shipping Carrier : '.$ShippingMethod.'</td>
                                        </tr>  
                                         <tr>
                                        <td style=" font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.'; line-height:22px;  text-align:left; padding-left:'.$billShipppadding.'px;">Comments : '.$Comment.'</td>
                                        </tr>  

                                        </table>
                                      <p style="padding-left:'.$billShipppadding.'px; font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.';">Once signed, please Fax mail or e-mail it to the provided address.</p><br><br><br><br><br>';
         
         
         
         $TotalDataShow='<table style="width:100; border:none; cellpadding:0; cellspacing:0;margin:0px; padding:0px;" align="right">
                                  <tr>
                                    <td width="83" style="padding:5px 0px 5px 0px; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">Subtotal</td>
                                    <td width="82" style="border:1px solid #cacaca; border-bottom:none;  font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';"><span style="text-align:right;">'.$subtotal.'</span> </td>
                                  </tr>
                                  <tr align="right">
                                    <td style="padding:5px 10px; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">Tax</td>
                                    <td style="border:1px solid #cacaca; border-bottom:none; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';"><span style="text-align:right; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">'.$taxAmnt.'</span></td>
                                  </tr>
                                  <tr align="right">
                                    <td style="padding:5px 10px; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">Freight</td>
                                    <td style="border:1px solid #cacaca; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';"><span style="text-align:right; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">'.$Freight.'</span></td>
                                  </tr>

                                  <tr align="right">
                                    <td style="padding:5px 10px; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">GrandTotal</td>
                                    <td style="border:1px solid #cacaca; border-bottom:none;  font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.'; "><span style="text-align:right; font-size:'.$LineItemFontSize.'px; color:'.$LineItemFieldColor.';">'.$TotalAmount.'</span></td>
                                  </tr>
                                </table>';
        /**end code for dynamic pdf by sachin**/


?>
