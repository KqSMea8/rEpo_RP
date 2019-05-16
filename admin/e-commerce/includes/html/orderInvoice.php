<div style="float: right; padding: 15px;"><input type="button" onclick="Javascript:window.print();" value="Print" name="exp" class="print_button"></div>
<table width="100%" cellpadding="10" cellspacing="2" border="0" bgcolor="black">
    <tr>
        <td bgcolor="white" height="100">
            <table width="100%" cellpadding="0" cellspacing="" border="0" bgcolor="white">
                    <tr>
                        <td bgcolor="white" colspan='2' align="left" border="0">
                            <?
                            if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){
                            $SiteLogo = $Prefix.'resizeimage.php?w=120&h=120&bg=f1f1f1&img=upload/company/'.$arryCompany[0]['Image'];
                            }else{
                            $SiteLogo = $Prefix.'images/logo.png';
                            }
                            ?>
                           <img src="<?=$SiteLogo?>" border="0" alt="<?=$arryCompanyDetail[0]['CompanyName']?>" title="<?=$arryCompanyDetail[0]['CompanyName']?>"/>
                        </td>
                    </tr>
                
              
                <tr valign="top">
                    <td bgcolor="white" style="font-size:13px; width: 430px;">
                      <p>   
                          <span style="font-size:16px;"><?= $arryCompanyDetail[0]['CompanyName'];?></span>
                            <br>
                            <?= $arryCompanyDetail[0]['Address'];?><br>
                            <?= $arryCompanyDetail[0]['City'];?>,  <?= $arryCompanyDetail[0]['State'];?>  <?= $arryCompanyDetail[0]['ZipCode'];?><br>
                            <?= $arryCompanyDetail[0]['Country'];?>
                        </p><br>
                        <p>
                            
                            Phone - <?= $arryCompanyDetail[0]['Mobile'];?>, Fax - <?= $arryCompanyDetail[0]['Fax'];?><br>
                           <?//php if(!empty($arryCompanyDetail[0]['Mobile'])){?>
                            <!--Landline Number: <?//= $arryCompanyDetail[0]['LandlineNumber'];?><br>-->
                             <?//php }?>
                             
                            <?= $arryCompanyDetail[0]['Email'];?><br>
                            <?= $arryCompanyDetail[0]["Website"];?>

                        </p>
                      
                    </td>
                    <td style="font-size:16px;">
                         
                        <div class="had"><b>Order ID#</b> <?= $arryOrderIfo['OrderID'] ?></div>

 <?php if($arryOrderIfo['OrderType']=='Amazon' ){?>
                            <div class="had"><b> Amazon Order ID: </b>                           
                                  <?= $arryOrderIfo['AmazonOrderId'] ?></div>
                                
                             
                              <?php }else if($arryOrderIfo['OrderType']=='Ebay' ){?>
                            
                                 <div class="had"><b>Ebay Order ID: </b>                               
                                  <?= $arryOrderIfo['AmazonOrderId'] ?></div>
                                
                              
                              <?php }?>


                         <div class="had"><b> Order Date:</b> <?=$arryOrderIfo['OrderDate'] ?></div>
                       
                    </td>
                </tr>
                
        
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:0px;">
            <table width="100%" cellpadding="5" cellspacing="0" border="0" bgcolor="white">
                         <tr valign="top">
                    <td bgcolor="white" style="font-size:13px; width: 430px;">
                        <p>
                            <b>Billing Information</b><br>
                            <? if ($arryOrderIfo["PaymentGatewayID"] != "paypalec") { ?>
                                <?= stripslashes($arryOrderIfo['BillingName']) ?><br>
                                <?= trim($arryOrderIfo["BillingCompany"]) != "" ? ($arryOrderIfo["BillingCompany"] . "<br>") : "" ?>
                                <?= stripslashes($arryOrderIfo['BillingAddress']) ?><br>
                                <?= stripslashes($arryOrderIfo['BillingCity']) ?>, <?= stripslashes($arryOrderIfo['BillingState']) ?>  <?= $arryOrderIfo['BillingZip'] ?><br>
                               <?= stripslashes($arryOrderIfo['BillingCountry']) ?><br>
                                Email: <a href="mailto:<?= $arryOrderIfo['Email'] ?>"><?= $arryOrderIfo['Email'] ?></a><br>
                                Phone: <?= $arryOrderIfo['Phone'] ?>
                                <?
                                
                               } else {
                                echo "PayPal Express Order - BIlling Information at PayPal";
                            }
                            ?>

                        </p>
                      
                    </td>
                    <td style="font-size:13px;">
                         <p>
                            <b>Shipping Information</b><br>
                            <? if (empty($arryOrderIfo["shipping_digital"])) { ?>
                                There no shipping information available<br>
                                Digital Download
                            <? } else { ?>
                                <?= stripslashes($arryOrderIfo['ShippingName']) ?><i>(
                                    <?= stripslashes($arryOrderIfo['ShippingAddressType']) ?>
                                    )</i><br>
                                 <?= trim($arryOrderIfo["ShippingCompany"]) != "" ? ($arryOrderIfo["ShippingCompany"] . "<br>") : "" ?>
                                 <?= ($arryOrderIfo['ShippingAddress']) ?><br>
                                <?= stripslashes($arryOrderIfo['ShippingCity']) ?>, <?= stripslashes($arryOrderIfo['ShippingState']) ?> <?= $arryOrderIfo['ShippingZip'] ?><br>
                                 <?= stripslashes($arryOrderIfo['ShippingCountry']) ?>
                            <? } ?>
                         </p>
                    </td>
                </tr>
                
            </table>  
        </td>
    </tr>
    <tr>
        <td bgcolor="white" height="100">
            <table width="100%" cellpadding="5" cellspacing="0" border="0" bgcolor="white">
                <tr>
                    <td width="15%" style="font-size:13px;"><b>Product ID</b></td>
                    <td width="40%" style="font-size:13px;"><b>Product Name</b></td>
                    <td width="25%" style="font-size:13px;"><b>Unit Price</b></td>
                    <td width="10%" style="font-size:13px;"><b>Quantity</b></td>
                    <td width="10%" style="font-size:13px; text-align: center;"><b>Total</b></td>
                </tr>
                     <?php 
                      /********Connecting to main database*********/
                $Config['DbName'] = $_SESSION['CmpDatabase'];
                $objConfig->dbName = $Config['DbName'];
                $objConfig->connect();
                /*******************************************/ 
                     
                     foreach ($arryOrderProduct as $orderdata) { ?>   
                    <tr valign="top">
                        <td background="images/bg1.gif" style="font-size:13px;">
 
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
                        </td>
                        <td background="images/bg1.gif" style="font-size:13px;">
                            <?= $orderdata['ProductName'] ?>
                          </strong> 
                        <?php if ($orderdata['Weight'] != '0.00') { ?> 
                                                            <br> Weight(lbs): <?= $orderdata['Weight'] ?>
                                                       <?php } ?>   
		    <?php 
                    //By karishma 9 oct//
                    
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
		     
		   
		    <?php }//End//?>
                          <br>
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
                        <td background="images/bg1.gif" style="font-size:13px;">
                            <?= display_price_symbol($orderdata['Price'],$arryOrderIfo['CurrencySymbol']) ?>
                          <br>
                          <i>(not taxable)</i>
                        </td>
                        <td background="images/bg1.gif" style="font-size:13px;text-align: center;">
                            <?= $orderdata['Quantity'] ?>
                        </td>
                        <td background="images/bg1.gif" style="font-size:13px;text-align: right;">
                            <?= display_price_symbol($orderdata['Quantity'] * $orderdata['Price'],$arryOrderIfo['CurrencySymbol']) ?>
                    </tr>
                            <? } ?>
                       
                <tr>
                    <td background="images/bg1.gif" colspan="4"  style="font-size:13px; text-align: right;">Subtotal Amount :</td>
                    <td background="images/bg1.gif" style="font-size:13px;text-align: right;"><?= display_price_symbol($arryOrderIfo['SubTotalPrice'],$arryOrderIfo['CurrencySymbol']) ?></td>
                </tr>
                 <?php if($arryOrderIfo['DiscountAmount'] > 0){?>
                    <tr>
                     <td colspan="4" style="font-size:13px;text-align: right;"> Discount : </td>
                     <td style="font-size:13px;text-align: right;">-<?= display_price_symbol($arryOrderIfo['DiscountAmount'],$arryOrderIfo['CurrencySymbol']) ?></td>		
                   </tr>
                   <?php }?>
                    <?php if($arryOrderIfo['PromoDiscountAmount'] > 0){?>
                    <tr>
                     <td colspan="4"  style="font-size:13px;text-align: right;"> Coupon Discount : </td>
                     <td style="font-size:13px;text-align: right;">-<?= display_price_symbol($arryOrderIfo['PromoDiscountAmount'],$arryOrderIfo['CurrencySymbol']) ?></td>		
                   </tr>
                <?php }?>
                <tr>
                    <td colspan="4" style="font-size:13px;text-align: right;">
                        Shipping amount (<?= $arryOrderIfo['ShippingMethod'] ?>) :   
                    </td>
                    <td style="font-size:13px;text-align: right;"><?= display_price_symbol($arryOrderIfo['Shipping'],$arryOrderIfo['CurrencySymbol']) ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right" style="font-size:13px;">Tax Amount :</td>
                    <td style="font-size:13px;" align="right"><?= display_price_symbol($arryOrderIfo['Tax'],$arryOrderIfo['CurrencySymbol']) ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="font-size:13px;text-align: right;"><b>Total Amount :</b></td>
                    <td style="font-size:13px;text-align: right;"><b> <?= display_price_symbol($arryOrderIfo['TotalPrice'],$arryOrderIfo['CurrencySymbol']) ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="white" valign="top" style="font-size:13px;">
            <b>Payment & Shipping Information</b><br>
                    Payment Method  :   <?= $arryOrderIfo['PaymentGateway'] ?><br>
                    <?php if(!empty($arryOrderIfo['ShippingMethod'])){?>
                     Shipping Method : Custom Shipping (<?= $arryOrderIfo['ShippingMethod'] ?>)<br>
                    <?php }else{?>
                      Shipping Method : Free Shipping<br>
                     <?php }?>
                    Completed at : <?= $arryOrderIfo["OrderComplatedDate"] ?>
                	

        </td>
    </tr>
</table>
