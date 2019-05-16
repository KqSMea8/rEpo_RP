  <form action="payment_product.php"  method="post" name="Confirmform" id="Confirmform">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" >
              <?=CONFIRM_YOUR_DETAILS?>
            </div></td>
          </tr>
          <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td  ><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
                   
                      
                      
                      <tr>
                        <td align="center" valign="top"   >
						
						
						
						
                            <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" >&nbsp;</td>
                              </tr>
                            </table>
                            <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
										<td class="redtxt"><? echo strtoupper(SH0PPING_BASKET); ?></td>
							  </tr>
							  <tr>
										<td class="skytxt" style="text-align:right"><a href="cart.php">Edit Cart</a></td>
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
                                    <td colspan="2" align="center" valign="top"><table width="100%"  border="0" cellpadding="6" cellspacing="1">
                                        <tr  class="cart_title">
                                          <td width="43%" height="20"  ><?=PRODUCT_NAME?></td>
                                          <td width="19%" height="20" ><?=PRICE?>                                          </td>
                                          <td width="24%" height="20"><?=QUANTITY?></td>
                                          <td width="14%" height="20" align="right"><?=AMOUNT?>                                          </td>
                                        </tr>
                                        <?php  
	if(is_array($arryCart)){
	$Count = 0;
	$SubTotal = 0;
  		foreach($arryCart as $key=>$values){
			$Count++;
			$SubTotal += $values['Quantity']*$values['Price']; 
	$ProductIDs .= $values['ProductID'].",";
	$TotalQuantity += $values['Quantity'];
		?>
                                        <tr valign="top"  class="generaltxt_inner">
                                          <td width="43%" height="18" valign="middle"  ><?php echo $values['Name'];?></td>
                                          <td width="19%" height="18" valign="middle" ><?php echo $Config['Currency'].' '.$values['Price'];?></td>
                                          <td width="24%" height="18" valign="middle" ><?php echo $values['Quantity']; ?></td>
                                          <td width="14%" height="18" valign="middle" align="right"  ><?php echo $Config['Currency'].' '.number_format($values['Quantity']*$values['Price'],2,'.',''); 
							
							  ?></td>
                                        </tr>
                                        <?php }  } 
	$Tax = ($SubTotal * $arrayConfig[0]['Tax'])/100;
	$Shipping = ($SubTotal * $arrayConfig[0]['Shipping'])/100;
	$VatAmount = ($SubTotal * $_SESSION['VatPercentage'])/100;
	
	$Total = $SubTotal + $Tax  + $Shipping + $VatAmount;
	
	$_SESSION['ProductIDs'] = rtrim($ProductIDs,",");
	$_SESSION['TotalQuantity'] = rtrim($TotalQuantity,",");
	
	//////////////////////////////////////////////////////
	
	$_SESSION['Tax']=number_format($Tax,2,'.','');
	$_SESSION['Shipping']=number_format($Shipping,2,'.','');
	$_SESSION['SubTotal']=number_format($SubTotal,2,'.','');
	$_SESSION['Total']=number_format($Total,2,'.','');
	
	?>
                                        <input type="hidden" name="numCart" id="numCart" value="<?php echo $numCart; ?>" />
                                        <input type="hidden" name="MemberID2" id="MemberID2" value="<?php echo $MemberID; ?>" />
                                    </table></td>
                                  </tr>
                                  <tr  class="cart_title">
                                    <td colspan="5" height="1" style="padding:0px; margin:0px;"></td>
                                  </tr>
                                  <tr>
                                    <td height="15" colspan="2" align="right" class="generaltxt_inner"><div align="right"><strong>
                                        <?=SUB_TOTAL?>
                                    </strong> : <?php echo $Config['Currency'].' '.number_format($SubTotal,2,'.','');?></div></td>
                                  </tr>
                                  <? if($Tax>0){?>
                                  <tr>
                                    <td height="15" colspan="2" align="right" class="generaltxt_inner"><div align="right"><strong>
                                        <?=TAX?>
                                    </strong> : <?php echo $Config['Currency'].' '.number_format($Tax,2,'.','');?></div></td>
                                  </tr>
                                  <? } 
					  
					  if($Shipping>0){ ?>
                                  <tr>
                                    <td height="15" colspan="2" align="right" class="generaltxt_inner"><div align="right"><strong>
                                        <?=SHIPPING_CHARGES?>
                                    </strong> : <?php echo $Config['Currency'].' '.number_format($Shipping,2,'.','');?></div></td>
                                  </tr>
                                  <? }
								  
								   if($VatAmount>0){
								   ?>
								   <tr>
                                    <td height="15" colspan="2" align="right" class="generaltxt_inner"><div align="right"><strong>
                                        VAT (<?=$_SESSION['VatPercentage']?> %)
                                    </strong> : <?php echo $Config['Currency'].' '.number_format($VatAmount,2,'.','');?></div></td>
                                  </tr>
								  <? } ?>
                                  <tr>
                                    <td height="15" colspan="2" align="right" class="generaltxt_inner"><div align="right"><strong>
                                    <?=TOTAL?>
                                      : <?php echo $Config['Currency'].' '.number_format($Total,2,'.','');?></strong></div></td>
                                  </tr>
                                  <tr>
                                    <td width="212" align="right" valign="top">&nbsp;</td>
                                    <td width="578" align="right" valign="top">&nbsp;</td>
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
                            <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
                              <tr>
                                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
                                     <tr>
										<td class="redtxt"><? echo strtoupper(PERSONAL_INFORMATION); ?></td>
									</tr>
                                      <tr>
                                        <td  valign="top"  ><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="generaltxt_inner"  >
                                          <tr>
                                            <td align="left" valign="top"   ><?=NAME?>
                                              : </td>
                                            <td align="left" >&nbsp;<? echo stripslashes($_POST['Name']); ?>
                                                <input name="Name" type="hidden" id="Name" value="<? echo stripslashes($_POST['Name']); ?>" /></td>
                                          </tr>
                                          <tr>
                                            <td align="left" valign="top"   ><?=EMAIL?>
                                              : </td>
                                            <td align="left" >&nbsp;
                                                <?=$_POST['Email']?>
                                            <input name="Email" type="hidden" id="Email" value="<? echo stripslashes($_POST['Email']); ?>" /></td>
                                          </tr>
                                          <tr>
                                            <td width="20%" align="left" valign="top"   ><?=PHONE?>
                                              : </td>
                                            <td width="80%" align="left">&nbsp;<? echo $_POST['Phone']; ?>
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
                          <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
                              <tr>
                                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
                                        <tr>
											<td class="redtxt"><? echo strtoupper(BILLING_DETAILS); ?></td>
										</tr>
                                      <tr>
                                        <td  valign="top" height="110" ><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="generaltxt_inner"  >
                                            <tr>
                                              <td width="21%" align="left" ><?=ADDRESS?>
                                                : </td>
                                              <td  align="left" valign="top"  ><?=stripslashes($_POST['Address'])?>
                                                  
                                                  <input name="Address" type="hidden" id="Address" value="<? echo stripslashes($_POST['Address']); ?>" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left"  valign="top"><?=COUNTRY?>
                                                : </td>
                                              <td width="79%" align="left"   ><?=$BCountry[0]['name']?>
                                                  
                                                  <input name="country_id" type="hidden" id="country_id" value="<? echo $_POST['country_id']; ?>" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left" ><?=STATE?>
                                                : </td>
                                              <td width="79%" align="left"  ><?=$BState[0]['name']?>
                                                
                                                  <input name="main_state_id" type="hidden" id="main_state_id" value="<? echo $_POST['main_state_id']; ?>" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left" ><?=CITY?>
                                                : </td>
                                              <td width="79%" align="left"   id="city_td" ><?=$BCity[0]['name']?>
                                                 
                                                  <input name="main_city_id" type="hidden" id="main_city_id" value="<? echo $_POST['main_city_id']; ?>" />
                                              </td>
                                            </tr>
                                            <tr>
                                              <td align="left"  valign="top"><?=POSTAL_CODE?>
                                                : </td>
                                              <td height="30" align="left"  ><?=$_POST['PostCode']?>
                                                 
                                                  <input name="PostCode" type="hidden" id="PostCode" value="<? echo $_POST['PostCode']; ?>" />
                                              </td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                    </table>
                                </td>
                              </tr>
                          </table>
                          <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" align="center" >&nbsp;</td>
                              </tr>
                          </table>
                          <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
                              <tr>
                                <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
                                     <tr>
										<td class="redtxt"><? echo strtoupper(SHIPPING_DETAILS); ?></td>
									</tr>
                                      <tr>
                                        <td  valign="top" height="110" ><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="generaltxt_inner"  >
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
                                    </table>
                                </td>
                              </tr>
                          </table>
                          <table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" align="center" >&nbsp;</td>
                              </tr>
                          </table>
							
						  <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td  valign="top" align="left" height="50" >
	  <input name="agree" id="agree" type="checkbox" value="checkbox"  />
          <a href="storePolicy.php" target="_blank">I agree to the except Terms & Conditions</a></td>
                            </tr>
                          </table>
						  <? 
						 
						  
						  if($arrayStore[0]['CreditCard']=='Yes') { ?>	
							
                          <table width="95%" cellpadding="20"  border="0" align="center" height="100"  class="outline"  >
                            <!--
							<tr>
                              <td width="52%" align="right"><input name="image2" type="image" style="margin-right:7px;" onclick="Javascript: PaymentSubmitForm(1);" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckoutsm.gif" alt="Paypal Checkout" align="center" /></td>
                              <td width="48%" align="left"><input type="image" name="Google Checkout2" alt="Fast checkout through Google" onclick="Javascript: PaymentSubmitForm(2);" 
src="http://checkout.google.com/buttons/checkout.gif?merchant_id=809948875536783&amp;w=180&amp;h=46&amp;style=white&amp;variant=text&amp;loc=en_US" height="46" width="180"/>
                              </td>
                            </tr>
							-->
                            <tr>
                              <td  align="center">
							  <input name="image355" type="image" onclick="Javascript: PaymentSubmitForm(3);" src="<?=$Config['Url']?>images/mygate.jpg" alt="MyGate Checkout" style="display:none">
							
							  <img src="<?=$Config['Url']?>images/mygate.jpg" alt="MyGate Checkout" onclick="Javascript: PaymentSubmitForm(3);"  style="cursor:pointer" />
							  
							  </td>
                            </tr>
							  <tr>
                              <td style="text-align:center" class="generaltxt_inner" >
							<?=CLICK_ON_MY_GATE_IMAGE?>
							  
							  </td>
                            </tr>
							
                          </table>
						<? } else{ 
						
							$successUrl = 'confirm.php?Process=1&BidID='.$_SESSION['BidForPurchased'];
					
						?>
						
                          <table width="89%" border="0" cellspacing="0" cellpadding="7" align="center">
                              <tr>
                                <td valign="top" align="center" class="redtxt" ><?=CREDIT_CARD_NOT_ORDER_MSG?></td>
                              </tr>
                              <tr>
                                <td valign="top" align="center"   ><input name="Submit23" type="button" class="button"  id="Submit23" value="<?=CONFIRM?>" onclick="Javascript: PaymentSubmitForm(4);"  /></td>
                              </tr>
                          </table>
						  
					 <? } ?>  
						  
						  
						  
                          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td  valign="top" align="center" ><span class="verdan11" style="display:none">
                                  <input name="Submit1" type="submit" class="button"  id="Submit1" value="<?=CONFIRM?>" />
                                  </span>
								  
                           <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_POST['MemberID']; ?>" />
                              <input type="hidden" name="StoreID" id="StoreID" value="<? echo $_POST['StoreID']; ?>" />
							  <input type="hidden" name="BidID" id="BidID" value="<? echo $_SESSION['BidForPurchased']; ?>" />
                              <input type="hidden" name="Tax" id="Tax"  value="<?=$_POST['Tax']?>" />
                              <input type="hidden" name="Shipping" id="Shipping" value="<?=$_POST['Shipping']?>" />
                              <input name="ProductIDs" type="hidden" id="ProductIDs" value="<?=$_POST['ProductIDs']?>" />
                              <input name="SubTotal" type="hidden" id="SubTotal" value="<?=$_POST['SubTotal']?>" />
                              <input name="Total" type="hidden" id="Total" value="<?=$_POST['Total']?>" />
							   <input name="VatAmount" type="hidden" id="VatAmount" value="<?=$VatAmount?>" />
                            
							  <input type="hidden" name="TotalQuantity" id="TotalQuantity" value="<?=$_POST['TotalQuantity']?>" />
                                    <input name="Submit" type="button" class="button"  id="Submit" value="<?=CANCEL?>" onclick="location.href='confirm.php?DelCart=1&BidID=<?=$_SESSION['BidForPurchased']?>'" />
									
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
            </table></td>
          </tr>
      </table></td>
  </tr>
</table>
  </form>