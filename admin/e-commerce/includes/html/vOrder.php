<div class="vorder"> 
    <a href="<?= $ListUrl ?>" class="back">Back</a>
<?php 
	if($Config['Junk']==0){
		/*********************/
		/*********************/
	   	$NextID = $objOrder->NextPrevRow($_GET['view'],1);
		$PrevID = $objOrder->NextPrevRow($_GET['view'],2);
		
		$NextPrevUrl = "vOrder.php?curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}
?>
    <a class="fancybox fancybox.iframe" href="orderInvoice.php?invoice=<?=$arryOrderIfo['OrderID']?>&cid=<?=$arryOrderIfo['Cid']?>" style="float: right;"><input type="button" value="Print" name="exp" class="print_button"></a>
    <div class="message">
             <? if (!empty($_SESSION['mess_order'])) { echo stripslashes($_SESSION['mess_order']);unset($_SESSION['mess_order']); } ?>
           </div>
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
                               <?php if($arryOrderIfo['OrderType']=='Amazon' ){?>
                              <tr>
                                <td width="40%">Amazon Order ID</td>
                                <td width="40%">
                                  <?= $arryOrderIfo['AmazonOrderId'] ?>
                                </td>
                              </tr>
                              <?php }else if($arryOrderIfo['OrderType']=='Ebay' ){?>
                              <tr>
                                <td width="40%">Ebay Order ID</td>
                                <td width="40%">
                                  <?= $arryOrderIfo['AmazonOrderId'] ?>
                                </td>
                              </tr>
                              <?php }?>
                              <tr>
                                <td width="40%"><strong>Currency</strong></td>
                                <td width="40%"><strong>
                                  <?= $arryOrderIfo['Currency'] ?>
                                  </strong></td>
                              </tr>
                              <tr>
                                <td class="dashed-border">Created At</td>
                                <td class="dashed-border"><?= date($Config['DateFormat'].' '.$Config['TimeFormat'],strtotime($arryOrderIfo['OrderDate']));?></td>
                              </tr>
                              <tr>
                                <td class="dashed-border">Payment Status</td>
                                <td class="dashed-border"><strong>
                                  <?php if($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay'){
                                  	echo "Paid";
                                  }else{
	                                  if ($arryOrderIfo['PaymentStatus'] == "1")  
	                                  {?>
	                                  Received
	                                  <?php } else { ?>
	                                  Pending
	                                  <?php } 
                                  }?>
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
					 if(empty($arryOrderIfo['OrderStatus'])) $arryOrderIfo['OrderStatus']='Unshipped';
					  echo $arryOrderIfo['OrderStatus'];
				 ?>
                                  </strong> </td>
                              </tr>
                              <?php  if($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay'){?>
                              	<tr>
                                <td style="width:150px;">Set Order Status</td>
                                <td>
                                <?php if($arryOrderIfo['OrderStatus'] == 'Unshipped') {?>
                                <a href="#cancelOrder" class="fancybox search_button" style="color:#fff;" >Cancel Order</a>
                                <a href="#confirmShipment" class="fancybox search_button" style="color:#fff;">Confirm Shipment</a>
                                <?php }else{?>
                                 <a href="#refundOrder" class="fancybox search_button" style="color:#fff;">Refund Order</a>
                                 <a href="#confirmShipment" class="fancybox search_button" style="color:#fff;">Edit Shipment</a>
                                 <?php }?>
                                </td>
                              </tr>
                             <?php }else if($ModifyLabel == 1){ ?>
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
                          Email: <a href="mailto:<?= ($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay') ? $arryOrderIfo['AmazonEmail'] : $arryOrderIfo['Email'] ?>">
                          <?= ($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay') ? $arryOrderIfo['AmazonEmail'] : $arryOrderIfo['Email'] ?>
                          </a><br>
                          Phone:
                          <?= $arryOrderIfo['Phone'] ?>
                          <br>
                          &nbsp; </div>
                           <div id="BillAddInput" style="display:none;"> <?= stripslashes($arryOrderIfo['BillingName']) ?>
                          <br>
                          
                         <input type="text" style="margin-top: 5px;" class="inputbox" name="BillingAddress" id="BillingAddress" value="<?= stripslashes($arryOrderIfo['BillingAddress']) ?>"  /> 
                          <br>
			<?
			(!isset($CountrySelected))?($CountrySelected=""):("");
			?>
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
                        <div id="ShippAddHTML">  <?php echo stripslashes($arryOrderIfo['ShippingName']);
                        if( !($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay') ){ ?>
                          <i>(
                          <?= stripslashes($arryOrderIfo['ShippingAddressType']) ?>
                          )</i>
                          <?php }?>
                          <br>
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
                        <td style="text-align:center;">

<?

if(!empty($orderdata['AmazonSku'])){
	$ProductSku = $orderdata['AmazonSku'];
}else if(!empty($orderdata['ProductSku'])){
	$ProductSku = $orderdata['ProductSku'];
}else{
	$ProductSku = $orderdata['ProductID'];
} 
	echo $ProductSku;

?>


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
                        <td style="text-align:center;"><?= display_price_symbol($orderdata['Price'],'') //display_price_symbol($orderdata['Price'],$CurrencySymbol) ?>
                          <br>
                          <i>(not taxable)</i></td>
                        <td style="text-align:center;"><?= $orderdata['Quantity'] ?></td>
                        <td style="text-align:left;"><?= display_price_symbol($orderdata['Quantity'] * $orderdata['Price'],'') ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <!-- order amounts-->
                      <tr>
                        <td  colspan="4" style="text-align: right;">Subtotal amount :</td>
                        <td  style="text-align: left;"><?= display_price_symbol($arryOrderIfo['SubTotalPrice'],'') ?></td>
                      </tr>
                      <?php if($arryOrderIfo['DiscountAmount'] > 0){?>
                       <tr>
                        <td colspan="4"  style="text-align: right;"> Discount : </td>
                        <td  style="text-align: left;">-<?= display_price_symbol($arryOrderIfo['DiscountAmount']) ?></td>		
                      </tr>
                      <?php }?>
                       <?php if($arryOrderIfo['PromoDiscountAmount'] > 0){?>
                       <tr>
                        <td colspan="4" style="text-align: right;"> Coupon Discount : </td>
                        <td style="text-align: left;">-<?= display_price_symbol($arryOrderIfo['PromoDiscountAmount']) ?></td>		
                      </tr>
                      <?php }?>
                      <?php if($arryOrderIfo['GroupDiscount'] > 0){?>
                       <tr>
                        <td colspan="4" style="text-align: right;"> Group Discount : </td>
                        <td style="text-align: left;">-<?= display_price_symbol($arryOrderIfo['GroupDiscount']) ?></td>		
                      </tr>
                      <?php }?>
                      <tr>
                        <td colspan="4" style="text-align: right;"> Shipping amount 
                          (
                          <?= $arryOrderIfo['ShippingMethod'] ?>
                          ) : </td>
                        <td style="text-align: left;"><?= display_price_symbol($arryOrderIfo['Shipping'],'') ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="text-align: right;"> Tax : </td>
                        <td style="text-align: left;"><?= display_price_symbol($arryOrderIfo['Tax'],'') ?></td>		
                      </tr>
                      
                      <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total amount :</strong></td>
                        <td style="text-align: left;"><strong>
                          <?= display_price_symbol($arryOrderIfo['TotalPrice'],'') ?>
                          </strong></td>
                      </tr>
                    </tfoot>
                  </table>
                  <!-- end of order amounts -->
                  <br>
                  <?php if(!($arryOrderIfo['OrderType']=='Amazon' && $arryOrderIfo['OrderStatus']=='Unshipped')){ ?>
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
                  <?php }?>
                  <!-- end of shipping information -->
                  
                  <!-- payment information -->
                  <div class="admin-form-header">Payment Information</div>
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="shipinginfo">
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
                          <?php  if($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay'){
                          		echo "Paid";
                          }else{
                                        if($arryOrderIfo['PaymentStatus'] == "1") { echo "Received";}
                                        else if($arryOrderIfo['PaymentStatus'] == "2") { echo "Refunded";}
                                        else if($arryOrderIfo['PaymentStatus'] == "3") { echo "Canceled";}
                                        else if($arryOrderIfo['PaymentStatus'] == "5") { echo "Failed";}
                                        else{echo "Pending"; }
                          }
                                        ?>
                          </b></td>
                      </tr>
                     <?php if($ModifyLabel == 1 && ($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay')){ ?>
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
                      <?php if($arryOrderIfo['OrderType']=='Amazon' || $arryOrderIfo['OrderType']=='Ebay'){ ?>
                      <tr>
                        <td class="formItemCaption">Fees</td>
                        <td class="formItemControl"><b><?=$arryOrderIfo['Fee']?></b></td>
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


<div style="display:none">
	<div id="cancelOrder">
		<form name="form2" action=""  method="post" onSubmit="return validateOrderStatus(this);" >
		<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
		<input name="AmazonAccountID" type="hidden" value="<?=$arryOrderIfo['AmazonAccountID']?>" />
		<input name="AmazonOrderId" type="hidden" value="<?=$arryOrderIfo['AmazonOrderId']?>" />
		<input name="OrderID" type="hidden" value="<?=$arryOrderIfo['OrderID']?>" />
			<tr>
				 <td colspan="4" align="left" class="head">Cancel Order</td>
			</tr>
		     
		    <tr>
		        <td  align="left"   class="blackbold" width="20%">Select Reason:<span class="red">*</span> </td>
		        <td   align="left" width="40%">
					<select class=" inputbox select" title="cancelReason" name="cancelReason" id="cancelReason">
							<option value="CustomerReturn">Customer Return</option>
							<option value="NoInventory">No Inventory</option>
							<option value="ShippingAddressUndeliverable">Shipping Address Undeliverable</option>
							<option value="CustomerExchange">Customer Exchange</option>
							<option value="BuyerCanceled">Buyer Canceled</option>
							<option value="GeneralAdjustment">General Adjustment</option>
							<option value="CarrierCreditDecision">Carrier Credit Decision</option>
							<option value="RiskAssessmentInformationNotValid">Risk Assessment Information Not Valid</option>
							<option value="CarrierCoverageFailure">Carrier Coverage Failure</option>
							<option value="MerchandiseNotReceived">Merchandise Not Received</option>
					</select>            
				</td>
		    </tr>
		       
		        <td   align="center" width="40%" colspan="2">
		        	<br/>
					<input name="cancelOrder" type="submit" class="button" id="cancelOrder" value="Submit" /> 
				</td>
		    </tr>
		</table>
		</form>
	</div>
</div>

<div style="display:none">
	<div id="refundOrder">
		<form name="form2" action=""  method="post" onSubmit="return validateOrderStatus(this);" >
		<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
			<input name="AmazonAccountID" type="hidden" value="<?=$arryOrderIfo['AmazonAccountID']?>" />
			<input name="AmazonOrderId" type="hidden" value="<?=$arryOrderIfo['AmazonOrderId']?>" />
			<input name="OrderItemID" type="hidden" value="<? if(isset($arryOrderProduct[0]['OrderItemID'])) echo $arryOrderProduct[0]['OrderItemID']; ?>" />
			<input name="SubTotalPrice" type="hidden" value="<?=$arryOrderIfo['SubTotalPrice']?>" />
			<input name="Shipping" type="hidden" value="<?=$arryOrderIfo['Shipping']?>" />
			<input name="Tax" type="hidden" value="<?=$arryOrderIfo['Tax']?>" />
			<input name="Currency" type="hidden" value="<?=$arryOrderIfo['Currency']?>" />
			<tr>
				 <td colspan="4" align="left" class="head">Refund Order</td>
			</tr>
		     
		    <tr>
		        <td  align="left"   class="blackbold" width="20%">Select Reason:<span class="red">*</span> </td>
		        <td   align="left" width="40%">
					<select class=" inputbox select" title="refundReason" name="refundReason" id="refundReason">
							<option value="CustomerReturn">Customer Return</option>
							<option value="GeneralAdjustment">General Adjustment</option>
							<option value="CouldNotShip">Could Not Ship</option>
							<option value="DifferentItem">Different Item</option>
							<option value="Abandoned">Abandoned</option>
							<option value="CustomerCancel">Customer Cancel</option>
							<option value="PriceError">Price Error</option>
							<option value="ProductOutofStock">Product Out of Stock</option>
							<option value="CustomerAddressIncorrect">Customer Address Incorrect</option>
							<option value="Exchange">Exchange</option>
							<option value="Other">Other</option>
							<option value="CarrierCreditDecision">Carrier Credit Decision</option>
							<option value="RiskAssessmentInformationNotValid">Risk Assessment Information Not Valid</option>
							<option value="CarrierCoverageFailure">Carrier Coverage Failure</option>
							<option value="TransactionRecord">Transaction Record</option>
					</select>            
				</td>
		    </tr>
		       
		        <td   align="center" width="40%" colspan="2">
		        	<br/>
					<input name="refundOrder" type="submit" class="button" id="cancelOrder" value="Submit" /> 
				</td>
		    </tr>
		</table>
		</form>
	</div>
</div>

<div style="display:none">
	<div id="confirmShipment">
		<?php if(!empty($arryOrderIfo['TrackMsg'])){
			$tData = explode('#', $arryOrderIfo['TrackMsg']);
			if(is_array($tData)){
				foreach($tData as $tValue){
					if(!empty($tValue)){
						$tname = explode(':', $tValue);
						$Service = ($tname[0]=='Service') ? $tname[1] : $Service;
						$MerchantFulfillmentID = ($tname[0]=='MerchantFulfillmentID') ? $tname[1] : $MerchantFulfillmentID;
						$MerchantOrderItemId = ($tname[0]=='MerchantOrderItemId') ? $tname[1] : $MerchantOrderItemId;
					}
				}
			}
		}?>
		<form name="form3" action=""  method="post" onSubmit="return validateOrderStatus(this);" >
		<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
		<input name="AmazonAccountID" type="hidden" value="<?=$arryOrderIfo['AmazonAccountID']?>" />
			<input name="MerchantFulfillmentID" type="hidden" value="<? if(isset($MerchantFulfillmentID)) echo $MerchantFulfillmentID;?>" />
			<input name="OrderDetailId" type="hidden" value="<?=$arryOrderProduct[0]['OrderDetailId']?>" />
			<input name="MerchantOrderItemId" type="hidden" value="<? if(isset($MerchantOrderItemId)) echo $MerchantOrderItemId;?>" />
			<input name="Shipping" type="hidden" value="<?=$arryOrderProduct[0]['Quantity']?>" />
		
			<tr>
				 <td colspan="4" align="left" class="head">Confirm Shipment</td>
			</tr>
			
			<tr>
				 <td align="left"   class="blackbold" width="20%">Ship Date:<span class="red">*</span></td>
				 <td   align="left" width="40%">
				 <input id="ShipDate" name="ShipDate" class="datebox" readonly=""  value="<?=($arryOrderIfo['ShipDate']>0) ? date('Y-m-d', strtotime($arryOrderIfo['ShipDate'])):''?>" type="text">
				 </td>
			</tr>
		     
		    <tr>
		        <td  align="left"   class="blackbold" width="20%">Shipping Method:<span class="red">*</span> </td>
		        <td   align="left" width="40%">
 
					<select class=" inputbox select" title="CarrierList" name="ShippingMethod" id="ShippingMethod">
							<option value="">-- Please select --</option>
							 <?php 

if(!isset($editData['market_id'])) $editData['market_id']='';
	foreach($arrayShippingMethods as $arrayShippingMethod){

		if(!isset($arrayShippingMethod['id'])) $arrayShippingMethod['id']='';

					        ?>
							<option <?php if($editData['market_id']==$arrayShippingMethod['id']){echo "selected";} ?> value="<?=$arrayShippingMethod['id']?>"><?=$arrayShippingMethod['CarrierName']?></option>					
							<?php }?>		
					</select>            
				</td>
		    </tr>
		    
		    <tr>
				 <td align="left"   class="blackbold" width="20%">Shipping service</td>
				 <td   align="left" width="40%">
				 <input id="TrackMsg" name="TrackMsg" class="inputbox" value="<?=$Service?>">
				 </td>
			</tr>
		    
		    <tr>
				 <td align="left"   class="blackbold" width="20%">Tracking ID:<span class="red">*</span></td>
				 <td   align="left" width="40%"> <input type="text" name="TrackNumber" value="" id="TrackNumber" Class="inputbox" /></td>
			</tr>
		       
		        <td   align="center" width="40%" colspan="2">
		        	<br/>
					<input name="confirmShipment" type="submit" class="button" id="confirmShipment" value="Submit" /> 
				</td>
		    </tr>
		</table>
		</form>
	</div>
</div>

<style>
<!--
.shipinginfo tr td{
width: 50%;
}
-->
</style>

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

$(document).ready(function() {
	$(".fancybox").fancybox();

	$('#ShipDate').datepicker(
			{
			showOn: "both",
			dateFormat: 'yy-mm-dd', 
			yearRange: '2015:2025', 
			changeMonth: true,
			changeYear: true
	
			}
		);
	});
</script>

