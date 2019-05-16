  <form action="payment_product.php"  method="post" name="Confirmform" id="Confirmform">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="heading">
              <?=CONFIRM_YOUR_DETAILS?>
           </td>
          </tr>
		<? 
		
		
		if($ShipRate>0){ 
		
		
		?>
		
          <tr>
            <td height="313" align="center" valign="top">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td  ><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
                   
                      
                      
                      <tr>
                        <td align="center" valign="top"   >
						
						
						
						
                            <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" >&nbsp;</td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
										<td class="generaltxt" align="left"><strong><?=SH0PPING_BASKET?></strong></td>
							  </tr>
							  <tr>
										<td class="skytxt" style="text-align:right"><a href="cart.php">Edit Shopping Basket</a></td>
							  </tr>
							  <tr>
                                <td  valign="top" ><table width="100%" border="0" cellpadding="3" cellspacing="0">
                                  <tr>
                                    <td align="center" class="redtxt" colspan="2">
									<? if(!empty($_SESSION['MsgCart'])) {echo $_SESSION['MsgCart']; unset($_SESSION['MsgCart']); 
				 }?>
                                    </td>
                                  </tr>
                                  <?php   if($numCart>0){	?>
                                  <tr>
                                    <td colspan="2" align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                                      <tr  class="itembg">
                                      
                                        <td align="left"  >&nbsp;</td>
                                        <td align="left"  style="padding-left:15px;" >Item</td>
                                        <td align="left" width="16%" style="padding-left:15px;">Size</td>
                                        <td align="left" width="11%" style="padding-left:15px;"><?=PRICE?>
                                        </td>
                                        <td align="left" width="11%" style="padding-left:15px;"><?=QUANTITY?></td>
                                        <td align="left" width="11%" style="padding-left:15px;"><?=AMOUNT?>
                                        </td>
                                      </tr>
                                      <?php  
	if(sizeof($arryCart)>0){
	$Count = 0;
	$SubTotal = 0;
	$VatAmount = 0;
	$ProductIDs ='';
	
  		foreach($arryCart as $key=>$values){
			$Count++;
			$SubTotal += $values['Quantity']*$values['Price']; 
	$ProductIDs .= $values['ProductID'].",";
	$TotalQuantity += $values['Quantity'];
	$VatAmount += $values['Quantity']*$values['Tax'];
	
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'];
			
			
			
		
		
		
		
			
	   if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=73&h=73'; 
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'">';
		} 			
			
		$ImagePathLink = '<a href="'.$PrdLink.'">'.$ImagePath.'</a>';	
		  
		?>
                                      <tr valign="top"  >
                                     
                                        <td width="9%" align="left" valign="middle" class="pronamebg"><?=$ImagePathLink?></td>
                                        <td width="38%" align="left" valign="middle" class="pronamebg"><a href="<?=$PrdLink?>"><strong>
                                          <?=ucfirst(stripslashes($values['Name']))?>
                                          </strong></a>
                                            <?
							if(!empty($values['ProductNumber']))
							 echo '<br>Product Code: '.stripslashes($values['ProductNumber']);

							?>
                                            <input type="hidden" name="ProductID<?=$Count?>" id="ProductID<?=$Count?>" value="<?php echo $values['ProductID']; ?>" />
                                        </td>
                                        <td  valign="middle" class="pronamebg" align="left">
										<?=$values['Size']?>&nbsp;
                                        </td>
                                        <td  valign="middle" class="pronamebg" align="left"><?=display_price($values['Price'],'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?></td>
                                        <td  valign="middle" class="pronamebg" align="left"><?php echo $values['Quantity']; ?>
                                          
                                        </td>
                                        <td  valign="middle"  class="pronamebg" align="left"><?=display_price($values['Quantity']*$values['Price'],'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td  colspan="7" height="10"></td>
                                      </tr>
                                      <?php }  } 
	
	?>
                                      <input type="hidden" name="numCart" id="numCart" value="<?php echo $numCart; ?>" />
                                      <input type="hidden" name="MemberID2" id="MemberID2" value="<?php echo $MemberID; ?>" />
                                    </table></td>
                                  </tr>
                                  <tr  class="cart_title">
                                    <td colspan="5" height="1" style="padding:0px; margin:0px;"></td>
                                  </tr>
								  
								    <tr >
                                    <td colspan="5" align="right" >
									
<table  border="0" cellpadding="0" cellspacing="0" align="right" class="generaltxt_inner">
  <tr>
    <td align="right" height="22"><strong>Sub Total</strong>:&nbsp;</td>
    <td  align="right"><?=display_price($SubTotal,'',$_SESSION['TaxType'],$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?></td>
  </tr>
  
<? if($DiscountPercentage>0){
    $DiscountAmount = ($SubTotal*$DiscountPercentage)/100;
  ?>
  <tr>
 	 <td align="right" height="35"><strong>Discount (<?=$DiscountPercentage?>%)</strong>:&nbsp;</td>
	<td align="right"> - <?=display_price($DiscountAmount,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?></td>
  </tr> 
  
 
 <? } 
 
 
//$Tax = ($SubTotal * $arrayConfig[0]['Tax'])/100;
	//$Shipping = ($SubTotal * $arrayConfig[0]['Shipping'])/100;
	//$Total = $SubTotal + $Tax  + $Shipping;
	
	//$VatAmount = ($SubTotal * $_SESSION['VatPercentage'])/100;
	//$VatAmount = number_format($VatAmount,2,'.','');

	$Total = $SubTotal + $Tax  + $VatAmount + $Shipping - $DiscountAmount;
	
	
	$ProductIDs = rtrim($ProductIDs,",");
	$_SESSION['TotalQuantity'] = rtrim($TotalQuantity,",");
	
	//////////////////////////////////////////////////////
	
	$_SESSION['VatAmount']=number_format($VatAmount,2,'.','');
	$_SESSION['Shipping']=number_format($Shipping,2,'.','');
	$_SESSION['SubTotal']=number_format($SubTotal,2,'.','');
	$_SESSION['Total']=number_format($Total,2,'.','');
	$_SESSION['ProductIDs'] = $ProductIDs; 
 
 
 ?>  
  
  
   <? if($VatAmount>0){?>
		  <tr>
		 	 <td align="right" height="22"><strong>Tax</strong>:&nbsp;</td>
			 <td  align="right"><?=display_price($VatAmount,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?> </td>
		  </tr>
 <? } ?>
 
 <? if($Shipping>0){ ?>
  <tr>
   <td align="right" height="22"><strong>Shipping Amount</strong>:&nbsp;</td>
	<td align="right" ><?=display_price($Shipping,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?> </td>
  </tr>
  <? }
  
   if($VatAmount>0){
   ?>
   <!--<tr>
	   <td align="right" height="22"><strong>VAT <?=$_SESSION['VatPercentage']?> %)</strong>:&nbsp;</td>
<td  align="right" ><?=display_price($VatAmount,'',$_SESSION['TaxType'],$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?> </td>
  </tr>-->
  <? } ?>
  <tr>
 	 <td align="right" height="22"><strong>Total</strong>:&nbsp;</td>
	<td align="right"><?=display_price($Total,'',$_SESSION['TaxType'],$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?></td>
  </tr> 
 
 
 
</table>

									
									
									</td>
                                  </tr>
								  
                                  <tr>
                                    <td height="15" colspan="2" align="right" class="generaltxt_inner">
									 </td>
                                  </tr>
                                  
                                  
                                  <?php }else if(empty($_SESSION['MsgCart'])) {?>
                                  <tr>
                                    <td colspan="2" align="center" height="50" class="redtxt"><?=CART_EMPTY?></td>
                                  </tr>
                                  <?php } ?>
                                </table></td>
                              </tr>
                            </table>
                            <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" >&nbsp;</td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                              <tr>
                                <td><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                     <tr>
										<td class="generaltxt" align="left"><strong><?=PERSONAL_INFORMATION?></strong></td>
									</tr>
                                      <tr>
                                        <td  valign="top" class="outline" ><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="generaltxt_inner"  >
                                          <tr>
                                            <td align="left" valign="top"   ><?=NAME?>
                                              : </td>
                                            <td align="left" ><? echo stripslashes($_POST['Name']); ?>
                                                <input name="Name" type="hidden" id="Name" value="<? echo stripslashes($_POST['Name']); ?>" /></td>
                                          </tr>
                                          <tr>
                                            <td align="left" valign="top"   ><?=EMAIL?>
                                              : </td>
                                            <td align="left" ><?=$_POST['Email']?>
                                            <input name="Email" type="hidden" id="Email" value="<? echo stripslashes($_POST['Email']); ?>" /></td>
                                          </tr>
                                          <tr>
                                            <td width="13%" align="left" valign="top"   ><?=PHONE?>
                                              : </td>
                                            <td width="87%" align="left"><? echo $_POST['Phone']; ?>
                                            <input name="Phone" type="hidden" id="Phone" value="<? echo stripslashes($_POST['Phone']); ?>" /></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    </table>
                                </td>
                              </tr>
                            </table>
                          <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" >&nbsp;</td>
                              </tr>
                          </table>
                          <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                              <tr>
                                <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                        <tr>
											<td class="generaltxt" align="left"><strong><?=BILLING_DETAILS?></strong></td>
										</tr>
                                      <tr>
                                        <td  valign="top" height="110" class="outline"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="generaltxt_inner"  >
                                            <tr>
                                              <td width="21%" align="left" ><?=ADDRESS?>
                                                : </td>
                                              <td  align="left" valign="top"  ><?=stripslashes($_POST['Address'])?>
                                                  
                                                  <input name="Address" type="hidden" id="Address" value="<? echo stripslashes($_POST['Address']); ?>" />                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left"  valign="top"><?=COUNTRY?>
                                                : </td>
                                              <td width="79%" align="left"   ><?=$BCountry[0]['name']?>
                                                  
                                                  <input name="country_id" type="hidden" id="country_id" value="<? echo $_POST['country_id']; ?>" />                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left" ><?=STATE?>
                                                : </td>
                                              <td width="79%" align="left"  ><?=$BState[0]['name']?>
                                                
                                                  <input name="main_state_id" type="hidden" id="main_state_id" value="<? echo $_POST['main_state_id']; ?>" />                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left" ><?=CITY?>
                                                : </td>
                                              <td width="79%" align="left"   id="city_td" ><?=$BCity[0]['name']?>
                                                 
                                                  <input name="main_city_id" type="hidden" id="main_city_id" value="<? echo $_POST['main_city_id']; ?>" />                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left"  valign="top"><?=POSTAL_CODE?>
                                                : </td>
                                              <td  align="left"  ><?=$_POST['PostCode']?>
                                                 
                                                  <input name="PostCode" type="hidden" id="PostCode" value="<? echo $_POST['PostCode']; ?>" />                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left"  valign="top">&nbsp;</td>
                                              <td  align="left"  >&nbsp;</td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                    </table>
                                </td>
								<td><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                  <tr>
                                    <td class="generaltxt" align="left"><strong>
                                      <?=SHIPPING_DETAILS?>
                                    </strong></td>
                                  </tr>
                                  <tr>
                                    <td  valign="top" height="110" class="outline"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="generaltxt_inner"  >
                                        <tr>
                                          <td align="left" ><?=NAME?>
                                            :</td>
                                          <td colspan="3"  align="left" valign="top"    ><?=$_POST['shipName']?>
                                              <input name="shipName" type="hidden" id="shipName" value="<? echo $_POST['shipName']; ?>" /></td>
                                        </tr>
                                        <tr>
                                          <td width="17%" align="left" ><?=ADDRESS?>
                                            : </td>
                                          <td colspan="3"  align="left" valign="top"><?=$_POST['shipAddress']?>
                                              <input name="shipAddress" type="hidden" id="shipAddress" value="<? echo $_POST['shipAddress']; ?>" /></td>
                                        </tr>
                                        <tr>
                                          <td align="left"  valign="top"><?=COUNTRY?>
                                            : </td>
                                          <td width="69%" colspan="3" align="left"><?=$SCountry[0]['name']?>
                                              <input name="shipcountry_id" type="hidden" id="shipcountry_id" value="<? echo $_POST['shipcountry_id']; ?>" /></td>
                                        </tr>
                                        <tr>
                                          <td align="left" ><?=STATE?>
                                            : </td>
                                          <td width="69%" colspan="3" align="left"  ><?=$SState[0]['name']?>
                                              <input name="Ship_state_id" type="hidden" id="Ship_state_id" value="<? echo $_POST['Ship_state_id']; ?>" /></td>
                                        </tr>
                                        <tr>
                                          <td align="left" ><?=CITY?>
                                            : </td>
                                          <td width="69%" colspan="3" align="left" ><?=$SCity[0]['name']?>
                                              <input name="Ship_city_id" type="hidden" id="Ship_city_id" value="<? echo $_POST['Ship_city_id']; ?>" /></td>
                                        </tr>
                                        <tr>
                                          <td align="left"  valign="top"><?=POSTAL_CODE?>
                                            : </td>
                                          <td colspan="3" align="left"  ><?=$_POST['shipPostCode']?>
                                              <input name="shipPostCode" type="hidden" id="shipPostCode" value="<? echo $_POST['shipPostCode']; ?>" /></td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table></td>
                              </tr>
                          </table>
						  
       <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
                           <tr>
                                <td   align="left" height="35" ><?=$ShipHtml?></td>
                              </tr>
	  <tr>
                                <td   align="left" height="35" >

								<strong>Enter Voucher Code:</strong> <input type="text" name="Voucher" id="Voucher"  class="txtfield_normal"  maxlength="30" style="width:120px;" value="<?=$_POST['Voucher']?>" /> <input type="button" name="VoucherSubmit" value="Get Discount" class="butt" onclick="Javascript: VoucherSubmitForm(2);" /> </td>

                              </tr>						  
							    <tr>
                                <td  valign="top" align="left"  class="redbig"><?=$VoucherError?></td>
                              </tr>   
							  <tr>
                                <td  valign="top" align="left" height="15"></td>
                              </tr>
                          </table>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                                <td  valign="top" align="left" height="15"></td>
                              </tr>
							<tr>
                              <td  valign="top" align="left" height="50" class="txt" >
	  <input name="agree" id="agree" type="checkbox" value="checkbox"  />
          I agree to accept the <a href="terms_conditions.php" target="_blank">Terms & Conditions.</a></td>
                            </tr>
                          </table>
						   
					
							
                          <table  cellpadding="5"  border="0" align="center"    >
                           
							<tr>
							
							<?  if($arrayConfig[0]['PaypalPayment'] == 1){ ?>
                              <td width="50%" align="center" valign="top">							  
						 <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckoutsm.gif" alt="<?=stripslashes($arrayPaymentGateways[1]['name'])?>" title="<?=stripslashes($arrayPaymentGateways[1]['name'])?>" onclick="Javascript: PaymentSubmitForm(2);"  style="cursor:pointer; " />	  
							  </td>
							<? } 
							if($arrayConfig[0]['EftPayment'] == 1){  
							?>
							  <td width="50%" align="center" valign="top">							  
						 <input type="button" name="eft" class="checkout" alt="<?=stripslashes($arrayPaymentGateways[2]['name'])?>" title="<?=stripslashes($arrayPaymentGateways[2]['name'])?>" value="<?=stripslashes($arrayPaymentGateways[2]['name'])?>" onclick="Javascript: PaymentSubmitForm(3);"  style="cursor:pointer; " />	  
							  </td>
							<? } ?>
							 <!-- 
							 <td width="48%" align="left"><input type="image" name="Google Checkout2" alt="Fast checkout through Google" onclick="Javascript: PaymentSubmitForm(2);" 
							src="http://checkout.google.com/buttons/checkout.gif?merchant_id=809948875536783&amp;w=180&amp;h=46&amp;style=white&amp;variant=text&amp;loc=en_US" height="46" width="180"/>
							 </td>	-->
                            </tr>
							
							<? if($arrayConfig[0]['PaypalPayment']!= 1 && $arrayConfig[0]['EftPayment']!=1){ ?>
							<tr>
								<td align="center" class="redbig">
								We don't have any payment method activated now. Please try again later.</td>
							</tr>
							<? } ?>
                          </table>
						
						
						
						
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td   align="center" valign="bottom" ><span class="verdan11" style="display:none">
                                  <input name="Submit1" type="submit" class="button"  id="Submit1" value="<?=CONFIRM?>" />
                                  </span>
								  
					
			   <input type="hidden" name="ShippingMethod" id="ShippingMethod" value="<?=$_POST['ShippingMethod']?>" />
					 <input type="hidden" name="DeliveryMethod" id="DeliveryMethod" value="<?=$DeliveryMethodName?>" />
					 <input type="hidden" name="Shipping" id="Shipping" value="<?=$Shipping?>" />
							
						<input type="hidden" name="CompanyName" id="CompanyName" value="<? echo $_GET['HeaderTitle']; ?>" />	  
                           <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_POST['MemberID']; ?>" />
                              <input type="hidden" name="StoreID" id="StoreID" value="<? echo $_POST['StoreID']; ?>" />
                              <input type="hidden" name="BidID" id="BidID" value="<? echo $_SESSION['BidForPurchased']; ?>" />
                              <input type="hidden" name="Tax" id="Tax"  value="<?=$_POST['Tax']?>" />
                             
                              <input name="ProductIDs" type="hidden" id="ProductIDs" value="<?=$ProductIDs?>" />
                              <input name="SubTotal" type="hidden" id="SubTotal" value="<?=$_POST['SubTotal']?>" />
                              <input name="Total" type="hidden" id="Total" value="<? echo number_format($SubTotal,2,'.',''); ?>" />
							   <input name="VatAmount" type="hidden" id="VatAmount" value="<?=$VatAmount?>" />
                             <input name="VatPercentage" type="hidden" id="VatPercentage" value="<?=$_SESSION['VatPercentage']?>" />
							  <input name="currency_id" type="hidden" id="currency_id" value="<?=$_SESSION['currency_id']?>" /> 
							  <input type="hidden" name="TotalQuantity" id="TotalQuantity" value="<?=$_POST['TotalQuantity']?>" />
                              <input name="VatType" type="hidden" id="VatType" value="<?=TAX?>" />  
							  
							 <input name="DiscountVoucher" type="hidden" id="DiscountVoucher" value="<?=$DiscountVoucher?>" />  
							  <input name="DiscountAmount" type="hidden" id="DiscountAmount" value="<?=$DiscountAmount?>" />
							    
							  
							       
								                                    </td>
                              </tr>
                          </table>
                          <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" align="center" >&nbsp;</td>
                              </tr>
                        </table></td>
                      </tr>
                    
                    
                  
                  </table></td>
                </tr>
            </table>
			
			</td>
          </tr>
		  <? } else{ ?>
		   <tr>
            <td height="200" align="center"  class="redtxt">
			<!--
			We do not deliver the product to Postal Code : <?=$_POST['shipPostCode']?>
			-->
			Please go back and select the shipping method.
			<br><br>
			Please <a href="checkout.php">click here</a> to go back.
			</td>
          </tr>
		  <? } ?>
      </table>
  </form>