<div class="vorder"> 
    <a href="<?= $ListUrl ?>" class="back">Back</a>
    <a class="fancybox fancybox.iframe" href="orderInvoice.php?invoice=<?=$arryOrderIfo['OrderID']?>&cid=<?=$arryOrderIfo['Cid']?>" style="float: right;"><input type="button" value="Print" name="exp" class="print_button"></a>
  <div class="had">Order Details</div>
  <table width=100% border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
      <td align="center" valign="top">
          <form name="orderViewForm" action="" method="post">
          <table width="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" valign="middle" >
                  <div class="admin-tab-sheet-wrap">
                  <div class="admin-form-header first"> Order Status </div>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr valign="top">
                        <td width="100%" style="padding:0 0 20px 20px;"><table width="100%" cellspacing="0" cellpadding="5" border="0">
                            <tbody>
                              <tr>
                                <td width="40%"><strong>Order ID</strong></td>
                                <td width="40%"><strong>
                                  <?= $arryOrderIfo['OrderID'] ?>
                                  </strong></td>
                              </tr>
                              <tr>
                                <td class="dashed-border">Created At</td>
                                <td class="dashed-border"><?= $arryOrderIfo['OrderDate'] ?></td>
                              </tr>
                              <tr>
                                <td class="dashed-border">Payment Status</td>
                                <td class="dashed-border"><strong>
                                  <?php if ($arryOrderIfo['PaymentStatus'] == "1") { ?>
                                  Received
                                  <?php } else { ?>
                                  Pending
                                  <?php } ?>
                                  </strong> </td>
                              </tr>
                              <tr>
                                <td class="dashed-border"> Order Status </td>
                                <td style="font-size:1.1em;" class="dashed-border"><strong>
                                  <?php 
										/*if ($arryOrderIfo['OrderStatus'] == "Completed") {
										  echo "Completed";
										  } else if ($arryOrderIfo['OrderStatus'] == "Cancelled") {
										  echo "Cancelled";
										  } else {
										  echo "Process";
										  }*/
										  echo $arryOrderIfo['OrderStatus'];
									 ?>
                                  </strong> </td>
                              </tr>
                              <?php if($ModifyLabel == 1){ ?>
                              <tr>
                                <td style="width:150px;">Set Order Status</td>
                                <td><select class="short" name="OrderStatus">
                                    <option value="">Do not change</option>
                                    <option value="Process">Process</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Failed">Failed</option>
                                    
                                  </select>
                                </td>
                              </tr>
                              <tr valign="top">
                                <td colspan="2" cladss="formItemCaption"><input type="checkbox" value="Yes" name="send_notification_email" id="send_notification_email" checked="">
                                  <label for="send_notification_email">Send notification to user when order completed?</label>
                                </td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="admin-form-header">Billing &amp; Shipping Data</div>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr valign="top">
                        <td width="40%" style="padding:10px 0px 0px 22px;"><strong>Billing Address</strong>&nbsp;&nbsp;<input type="checkbox" id="changebillAdd"  name="changebillAdd" value="1" onclick="javascript:showhide('changebillAdd','BillAddHTML','BillAddInput');"/>Change Billing Address<br>
                         <div id="BillAddHTML"> <?= stripslashes($arryOrderIfo['BillingName']) ?>
                          <br>
                          <?= stripslashes($arryOrderIfo['BillingAddress']) ?>
                          <br>
                          <?= stripslashes($arryOrderIfo['BillingCity']) ?>
                          ,
                          <?= stripslashes($arryOrderIfo['BillingState']) ?>
                          ,
                          <?= $arryOrderIfo['BillingZip'] ?>
                          <br>
                          <?= stripslashes($arryOrderIfo['BillingCountry']) ?>
                          <br>
                          Email: <a href="mailto:<?= $arryOrderIfo['Email'] ?>">
                          <?= $arryOrderIfo['Email'] ?>
                          </a><br>
                          Phone:
                          <?= $arryOrderIfo['Phone'] ?>
                          <br>
                          &nbsp; </div>
                           <div id="BillAddInput" style="display:none;"> <?= stripslashes($arryOrderIfo['BillingName']) ?>
                          <br>
                          
                         <input type="text" style="margin-top: 5px;" class="inputbox" name="BillingAddress" id="BillingAddress" value="<?= stripslashes($arryOrderIfo['BillingAddress']) ?>"  /> 
                          <br>
                          <!--<select name="BillingCountry" class="inputbox" id="country_id"  onChange="Javascript: StateList();">
                            <? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                <option value="<?= $arryCountry[$i]['country_id'] ?>" <? if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                echo "selected";
                            } ?>>
                                <?= $arryCountry[$i]['name'] ?>
                                </option>
                                <? } ?>
                		</select>
                		  
                        
                          <br>
                          <div class="sel-wrap-friont" id="state_td">
                     		
                      	  </div>
                      	<div id="city_td" class="sel-wrap-friont"></div>
                          -->
                          
                           <input type="text" style="margin-top: 5px;" class="inputbox" name="BillingCity" id="BillingCity" value="<?= stripslashes($arryOrderIfo['BillingCity']) ?>"  /> 
                          ,
                           <input type="text" style="margin-top: 5px;" class="inputbox" name="BillingState" id="BillingState" value="<?= stripslashes($arryOrderIfo['BillingState']) ?>"  />
                          ,
                           <input type="text" style="margin-top: 5px;" class="inputbox" name="BillingZip" id="BillingZip" value="<?= stripslashes($arryOrderIfo['BillingZip']) ?>"  /> 
                          <br>
                           <input type="text" style="margin-top: 5px;" class="inputbox" name="BillingCountry" id="BillingCountry" value="<?= stripslashes($arryOrderIfo['BillingCountry']) ?>"  />  
                          <br>
                         
                          Email: <a href="mailto:<?= $arryOrderIfo['Email'] ?>">
                          <?= $arryOrderIfo['Email'] ?>
                          </a><br>
                          Phone:
                          <?= $arryOrderIfo['Phone'] ?>
                          <br>
                          &nbsp; </div>
                          </td>
                        <td width="40%" style="padding:10px 0px 0px 15px;"><strong>Shipping Address</strong>&nbsp;&nbsp;<input type="checkbox" id="changeshipAdd" name="changeshipAdd" value="1" onclick="javascript:showhide('changeshipAdd','ShippAddHTML','ShipAddInput');" />Change Shipping Address<br>
                        <div id="ShippAddHTML">  <?= stripslashes($arryOrderIfo['ShippingName']) ?>
                          <i>(
                          <?= stripslashes($arryOrderIfo['ShippingAddressType']) ?>
                          )</i><br>
                          <?= ($arryOrderIfo['ShippingAddress']) ?>
                          <br>
                          <?= stripslashes($arryOrderIfo['ShippingCity']) ?>
                          ,
                          <?= stripslashes($arryOrderIfo['ShippingState']) ?>
                          ,
                          <?= $arryOrderIfo['ShippingZip'] ?>
                          <br>
                          <?= stripslashes($arryOrderIfo['ShippingCountry']) ?>
                          <br>
                          &nbsp; </div>
                          <div id="ShipAddInput" style="display:none;"> <?= stripslashes($arryOrderIfo['ShippingName']) ?>
                          <br>
                          
                         <input type="text" style="margin-top: 5px;" class="inputbox" name="ShippingAddress" id="ShippingAddress" value="<?= stripslashes($arryOrderIfo['ShippingAddress']) ?>" /> 
                          <br>
                         
                         <input type="text" style="margin-top: 5px;" class="inputbox" name="ShippingCity" id="ShippingCity" value="<?= stripslashes($arryOrderIfo['ShippingCity']) ?>" />  
                          ,
                         <input type="text" style="margin-top: 5px;" class="inputbox" name="ShippingState" id="ShippingState" value="<?= stripslashes($arryOrderIfo['ShippingState']) ?>" /> 
                          ,
                          <input type="text" style="margin-top: 5px;" class="inputbox" name="ShippingZip" id="ShippingZip" value="<?= stripslashes($arryOrderIfo['ShippingZip']) ?>" /> 
                          <br>
                         	<input type="text" style="margin-top: 5px;" class="inputbox" name="ShippingCountry" id="ShippingCountry" value="<?= stripslashes($arryOrderIfo['ShippingCountry']) ?>" />  
                          <br>
                         
                          </div>
                          
                          </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- end billing and shipping -->
                  <!-- order content start-->
                  <div class="admin-form-header">Products Ordered</div>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="admin-list-table">
                    <thead>
                      <tr>
                        <th width="10%">Product ID</th>
                        <th width="40%">Name</th>
                        <th width="15%" class="text-align-right">Price</th>
                        <th width="25%" class="text-align-right">Quantity</th>
                        <th width="10%" style="text-align:left;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php                       
                    
                       $CurrencySymbol=$arryOrderIfo['Currency'];
                       if(!empty($arryOrderIfo['CurrencySymbol'])) $CurrencySymbol=$arryOrderIfo['CurrencySymbol'];
                        
                        
                      foreach ($arryOrderProduct as $orderdata) { ?>
                      <tr valign="top">
                        <td style="text-align:center;"><?= $orderdata['ProductSku'] ?>
                         <?php if($orderdata['UploadedFile']!='' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/ecom/upload/ordersfile/' . $orderdata['UploadedFile'])){ ?>
                                
                                <br>
                                <a href="/ecom/upload/ordersfile/<?php echo $orderdata['UploadedFile']; ?> " target="_blank">View</a>
                                <?php }?>
                        </td>
                        <td style="text-align:center;"><strong>
                          <?= $orderdata['ProductName'] ?>
                          </strong>  
                          <?php if ($orderdata['Weight'] != '0.00') { ?> 
                                                            <br> Weight(lbs): <?= $orderdata['Weight'] ?>
                                                       <?php } ?>
                                                        <?php 
		    //By karishma 6 oct//
		    if($orderdata['Variant_ID']!=''){
			$objVariant = new varient();
			$Variant_IDArray= explode(',',$orderdata['Variant_ID']);
			$Variant_val_IdArray= json_decode($orderdata['Variant_val_Id'], true);
			
			echo ' <br> '.Configure.':';
			
			foreach($Variant_IDArray as $key=>$val){
			$variants = $objVariant->GetVariantDispaly($val);
			if (is_array($Variant_val_IdArray[$val])) {

                            $vals = implode(',', $Variant_val_IdArray[$val]);
                        } else {

                            $vals = $Variant_val_IdArray[$val];
                        }
			
			echo $variants[0]['variant_name'].'('.$vals.')<br>';
			
			}
			
		    ?>
		     
		   
		    <?php }//End//?><br>
                          <?php if(!empty($orderdata['OptionsAttribute'])){?>
                          Options:<br>
                          <?php
                                                                                     	
                          	$optionArr= json_decode($orderdata['OptionsAttribute']);
                                                
                                                foreach($optionArr as $val){
                                                	echo $val;
                                                	echo '<br>';
                                                }
												
                                            
                                                        ?>
                          <?php }?>
                        </td>
                        <td style="text-align:center;"><?= display_price_symbol($orderdata['Price'],$CurrencySymbol) ?>
                          <br>
                          <i>(not taxable)</i></td>
                        <td style="text-align:center;"><?= $orderdata['Quantity'] ?></td>
                        <td style="text-align:left;"><?= display_price_symbol($orderdata['Quantity'] * $orderdata['Price'],$CurrencySymbol) ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <!-- order amounts-->
                      <tr>
                        <td  colspan="4" style="text-align: right;">Subtotal amount :</td>
                        <td  style="text-align: right;"><?= display_price_symbol($arryOrderIfo['SubTotalPrice'],$CurrencySymbol) ?></td>
                      </tr>
                      <?php if($arryOrderIfo['DiscountAmount'] > 0){?>
                       <tr>
                        <td colspan="4"  style="text-align: right;"> Discount : </td>
                        <td  style="text-align: right;">-<?= display_price_symbol($arryOrderIfo['DiscountAmount'],$CurrencySymbol) ?></td>		
                      </tr>
                      <?php }?>
                       <?php if($arryOrderIfo['PromoDiscountAmount'] > 0){?>
                       <tr>
                        <td colspan="4" style="text-align: right;"> Coupon Discount : </td>
                        <td style="text-align: right;">-<?= display_price_symbol($arryOrderIfo['PromoDiscountAmount'],$CurrencySymbol) ?></td>		
                      </tr>
                      <?php }?>
                      <?php if($arryOrderIfo['GroupDiscount'] > 0){?>
                       <tr>
                        <td colspan="4" style="text-align: right;"> Group Discount : </td>
                        <td style="text-align: right;">-<?= display_price_symbol($arryOrderIfo['GroupDiscount'],$CurrencySymbol) ?></td>		
                      </tr>
                      <?php }?>
                      <tr>
                        <td colspan="4" style="text-align: right;"> Shipping amount 
                          (
                          <?= $arryOrderIfo['ShippingMethod'] ?>
                          ) : </td>
                        <td style="text-align: right;"><?= display_price_symbol($arryOrderIfo['Shipping'],$CurrencySymbol) ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="text-align: right;"> Tax : </td>
                        <td style="text-align: right;"><?= display_price_symbol($arryOrderIfo['Tax'],$CurrencySymbol) ?></td>		
                      </tr>
                      
                      <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total amount :</strong></td>
                        <td style="text-align: right;"><strong>
                          <?= display_price_symbol($arryOrderIfo['TotalPrice'],$CurrencySymbol) ?>
                          </strong></td>
                      </tr>
                    </tfoot>
                  </table>
                  <!-- end of order amounts -->
                  <br>
                  <!-- shipping information-->
                  <div class="admin-form-header">Shipping Information</div>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="shipinginfo">
                    <tbody>
                      <tr valign="top">
                        <td class="formItemCaption">Shipping Service</td>
                        <td class="formItemControl"><b>Custom Shipping (
                          <?= $arryOrderIfo['ShippingMethod'] ?>
                          )</b></td>
                      </tr>
                      <tr valign="top">
                        <td class="formItemCaption">Total Products Weight (
                          <?= $arryOrderIfo['WeightUnit'] ?>
                          )</td>
                        <td class="formItemControl"><b>
                          <?= $arryOrderIfo['Weight'] ?>
                          </b></td>
                      </tr>
                      <tr>
                        <td class="formItemCaption">Current Shipping Status</td>
                        <td class="formItemControl"><b>
                          <?php
                                    if ($arryOrderIfo['ShippingStatus'] == "Dispatched") {
                                        echo "Dispatched";
                                    } else if ($arryOrderIfo['ShippingStatus'] == "Delivered") {
                                        echo "Delivered";
                                    } else if ($arryOrderIfo['ShippingStatus'] == "Returned") {
                                        echo "Returned";
                                    } else {
                                        echo "Pending";
                                    }
                                    ?>
                          </b> </td>
                      </tr>
                    <?php if($ModifyLabel == 1){ ?>
                      <tr>
                        <td class="formItemCaption">Set Shipping Status</td>
                        <td class="formItemControl"><select class="short" name="ShippingStatus">
                            <option value="">Do not change</option>
                            <?php foreach ($arryShippingStatus as $shipping) { ?>
                            <option value="<?= $shipping['DelhiveryStatus'] ?>">
                            <?= $shipping['DelhiveryStatus'] ?>
                            </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                     <?php }?>
                    </tbody>
                  </table>
                  <!-- end of shipping information -->
                  <!-- payment information -->
                  <div class="admin-form-header">Payment Information</div>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr>
                        <td class="formItemCaption">Payment Method</td>
                        <td class="formItemControl"><b>
                          <?= $arryOrderIfo['PaymentGateway'] ?>
                          </b> </td>
                      </tr>
                      <tr>
                        <td class="formItemCaption">Current Payment Status</td>
                        <td class="formItemControl"><b>
                          <?php 
                                        if($arryOrderIfo['PaymentStatus'] == "1") { echo "Received";}
                                        else if($arryOrderIfo['PaymentStatus'] == "2") { echo "Refunded";}
                                        else if($arryOrderIfo['PaymentStatus'] == "3") { echo "Canceled";}
                                        else if($arryOrderIfo['PaymentStatus'] == "5") { echo "Failed";}
                                        else{echo "Pending"; }
                                        ?>
                          </b></td>
                      </tr>
                     <?php if($ModifyLabel == 1){ ?>
                      <tr>
                        <td class="formItemCaption">Set Payment Status</td>
                        <td class="formItemControl"><select class="short" name="PaymentStatus">
                            <option value="">Do not change</option>
                            <option value="4">Pending</option>
                            <option value="1">Received</option>
                            <option value="2">Refunded</option>
                            <option value="3">Canceled</option>
                            <option value="5">Failed</option>
                          </select>
                        </td>
                      </tr>
                      <?php }?>
                      <!-- payment transactions-->
                    </tbody>
                  </table>
                </div></td>
            </tr>
           <?php if($ModifyLabel == 1){ ?>
            <tr>
              <td align="center" colspan="2" class="savebtn"><input type="hidden" name="oid" id="oid" value="<?=$_GET['view'];?>">
                <input type="submit" name="SaveChanges" id="saveOrderdata" class="button" value="Save Changes">
                &nbsp;
              </td>
            </tr>
            <?php }?>
          </table>
        </form>
      </td>
    </tr>
  </table>
</div>

<script type="text/javascript">
function showhide(fieldname,htmldiv,inputdiv){
	var check = $('#'+fieldname+':checked').val();
	if(check==1){
		$('#'+inputdiv).show();
		$('#'+htmldiv).hide();
	}else{
		$('#'+inputdiv).hide();
		$('#'+htmldiv).show();
	}

}
</script>
