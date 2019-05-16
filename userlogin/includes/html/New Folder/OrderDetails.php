

<link href="<?=$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                              <tr>
                                <td bgcolor="#E2E2E2"><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#E4E4E4" class="log">
                                  <tr align="left" >
                                    <td height="18" colspan="4">&nbsp;</td>
                                  </tr>
                                  <tr align="left">
                                    <td height="18" colspan="4"><strong>Customer Billing Details </strong></td>
                                  </tr>
                                  <?php if (!empty($errMsg)) {?>
                                  <tr>
                                    <td height="25" colspan="4" align="center"  class="log"><?php echo $errMsg;?></td>
                                  </tr>
                                  <?php } ?>
                                  <tr>
                                    <td width="18%"   class="log"><strong>Billing Name : </strong></td>
                                    <td height="30" colspan="3" align="left"   class="log"><?php echo $arryOrder[0]['BillingName']; ?></td>
                                  </tr>
                                  <tr>
                                    <td width="18%"   class="log"><strong>Email  : </strong></td>
                                    <td height="30" align="left"  class="log" ><?php echo '<a href="mailto:'.$arryOrder[0]['Email'].'" class="orange_txt">'.$arryOrder[0]['Email'].'</a>'; ?> </td>
                                    <td height="30" align="left"  class="log"><span class="greytext"><strong>Phone : </strong></span></td>
                                    <td height="30" align="left"   class="log"><?php echo $arryOrder[0]['Phone']; ?></td>
                                  </tr>
                                  <tr>
                                    <td width="18%" valign="top"   class="log"><strong> Address:</strong></td>
                                    <td height="30" align="left"   class="log"><?php echo $arryOrder[0]['BillingAddress']; ?></td>
                                    <td height="30" align="left" valign="top"   class="log">&nbsp;</td>
                                    <td height="30" align="left" valign="top"   class="log">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="18%" valign="top"   class="log"><strong> City : </strong></td>
                                    <td height="30" align="left"   class="log"><?php echo $arryOrder[0]['BillingCity']; ?></td>
                                    <td height="30" align="left" valign="top"  class="log"><span class="greytext"><strong>State :</strong></span></td>
                                    <td height="30" align="left" valign="top"   class="log"><?php echo $arryOrder[0]['BillingState']; ?></td>
                                  </tr>
                                  <tr>
                                    <td width="18%"   class="log"><strong>Country : </strong></td>
                                    <td width="35%" height="30" align="left"   class="log"><?php echo $arryOrder[0]['BillingCountry']; ?></td>
                                    <td width="14%" align="left"  class="log"><strong>Zipcode </strong></td>
                                    <td width="33%" align="left"   class="log"><?php echo $arryOrder[0]['BillingZip']; ?></td>
                                  </tr>
                                  <tr>
                                    <td height="5" colspan="4"  class="log" ></td>
                                    </tr>
                                  <tr align="left">
                                    <td height="18" colspan="4" class="log"><strong>Customer Shipping Details </strong></td>
                                  </tr>
                                  <tr>
                                    <td height="25" colspan="4" align="center"  class="log"><?php echo $errMsg;?></td>
                                  </tr>
                                  <tr>
                                    <td   class="log"><strong>Shipping Name : </strong></td>
                                    <td height="30" colspan="3" align="left"   class="log"><?php echo $arryOrder[0]['ShippingName']; ?></td>
                                  </tr>

                                  <tr>
                                    <td valign="top"   class="log"><strong> Address :</strong></td>
                                    <td height="30" align="left"   class="log"><?php echo $arryOrder[0]['ShippingAddress']; ?></td>
                                    <td height="30" align="left" valign="top"  class="log">&nbsp;</td>
                                    <td height="30" align="left" valign="top"   class="log">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td valign="top"   class="log"><strong> City : </strong></td>
                                    <td height="30" align="left"   class="log"><?php echo $arryOrder[0]['ShippingCity']; ?></td>
                                    <td height="30" align="left" valign="top"  class="log"><span class="greytext"><strong>State :</strong></span></td>
                                    <td height="30" align="left" valign="top"   class="log"><?php echo $arryOrder[0]['ShippingState']; ?></td>
                                  </tr>
                                  <tr>
                                    <td   class="log"><strong>Country : </strong></td>
                                    <td height="30" align="left"   class="log"><?php echo $arryOrder[0]['ShippingCountry']; ?></td>
                                    <td align="left"  class="log"><strong>Zipcode </strong></td>
                                    <td align="left"   class="log"><?php echo $arryOrder[0]['ShippingZip']; ?></td>
                                  </tr>
                                  <tr>
                                    <td height="5" colspan="4"  class="log" ></td>
                                    </tr>
                                  
                                  <tr align="left">
                                    <td height="18" colspan="4" class="log"><strong>Order Products Details</strong></td>
                                  </tr>
                                  <tr>
                                    <td height="30" colspan="4"  class="log"><table width="100%"  border="0" cellpadding="6" cellspacing="1" bgcolor="#F3F3F3">
                                        <tr   class="whitetxt">
                                          <td width="35%" align="center"  class="redbgactive"><strong>Name</strong></td>
                                          <td width="34%" align="center"  class="redbgactive"><strong>Quantity</strong></td>
                                          <td width="15%" align="center"  class="redbgactive"><strong>Unit Price</strong></td>
                                          <td width="16%" align="center"  class="redbgactive"><strong>Amount</strong></td>
                                        </tr>
                                        <?php  
	if(is_array($arryProducts) && $numProducts>0){
		$flag=true;
		$TOTAL = 0;
		$Count = 0;
		
	for($i=0;$i<sizeof($arryProducts);$i++){
  	//foreach($arryProducts as $key=>$arryProducts[$i]){
		$flag=!$flag;
		$Count++;
		$j=$i+1;
		$SubTotal += ($arryProducts[$i]['Quantity']*$arryProducts[$i]['Price']); 
	$TotalQuantity += $arryProducts[$i]['Quantity'];
	/*getPaintingDetail($arryProducts[$i]['ProductID']);
	$arryArtists=$objArtist->getArtistDetail($arryProducts[$i]['artistID']);
	$arryCategory=$objCategory->getCategoryDetail($arryProducts[$i]['categoryID']);*/
	
		?>
                                        <tr >
                                          <td height="25" align="center"  class="grey_txt"><div align="center">
                                            <?php 	echo '<SPAN class="greytext">'.$arryProducts[$i]['ProductName'].'</SPAN>';	?>
                                          </div></td>
                                          <td height="25" align="center" valign="top"  class="grey_txt"><div align="center">
                                            <?=$arryProducts[$i]['Quantity']?>                                          
                                          </div></td>
                                          <td height="25" align="center" valign="top"  class="grey_txt"><div align="center"><span class="grey_txtsearch">$</span><? echo  number_format($arryProducts[$i]['Price'],2,'.','');?></div></td>
                                          <td height="25" align="center" valign="top"  class="grey_txt"><div align="center"><span class="grey_txtsearch">$</span><? echo  number_format($arryProducts[$i]['Quantity']*$arryProducts[$i]['Price'],2,'.','');?></div></td>
                                        </tr>
                                       

                                        <tr >
                                          <td height="10" colspan="4" align="left" ></td>
                                        </tr>
                                        <?php }  } 
	$Tax=$SubTotal*$arryOrder[0]['Tax']/100;
	$Ship=$SubTotal*$arryOrder[0]['Shipping']/100;
	 $Total = $SubTotal +$Tax+$Ship;
	
	?>
                                        <tr>
                                          <td align="right"  class="greytext">&nbsp;</td>
                                          <td height="30" align="right"  class="redlink">&nbsp;</td>
                                          <td height="30" colspan="2" align="right"  class="red_right">Sub Total   :  $<?php echo number_format($SubTotal,2,'.','');?></td>
                                          </tr>                                        
                                        <?php
	   
	    // foreach end //
		
		if($Total > 0){
		?>
                                        <tr align="center" bgcolor="#F3F3F3">
                                          <td height="20" colspan="4" align="right" >Tax : $<?php echo number_format($Tax,2,'.',''); ?></td>
                                        </tr>
                                        <tr align="center" bgcolor="#F3F3F3">
                                          <td height="20" colspan="4" align="right" >Shipping : $<?php echo number_format($Ship,2,'.',''); ?></td>
                                        </tr>
                                        <tr align="center" height="25">
                                          <td height="5"  align="right" valign="top"  class="red_right"><strong>Status : </strong>
										    <? if($arryOrder[0]['Status'] == 1) echo 'Delivered';?>
                                              <? if($arryOrder[0]['Status'] == 0) echo 'Pending';?>                                          </td>
                                          <td height="5" colspan="2" align="right" valign="top"  class="red_right"><strong>
                                            <?php echo '<b>Total Amount: </b>$ '.number_format($Total,2,'.',''); 
		 ?>
                                          </strong></td>
                                          <td height="5" align="left" valign="top"  class="greytext" >&nbsp;</td>
                                        </tr>
										 <tr align="center" height="25">
                                          <td height="5"  align="right" valign="top"  class="red_right"><strong>Payment Status : </strong>
										    <? if($arryOrder[0]['PaymentStatus'] == 1) echo 'Received';?>
                                              <? if($arryOrder[0]['PaymentStatus'] == 0) echo 'Not Received';?>                                          </td>
                                          <td height="5" colspan="2" align="right" valign="top"  class="red_right"><strong>
                                            <?php echo '<b>Total Amount: </b>$ '.number_format($Total,2,'.',''); 
		 ?>
                                          </strong></td>
                                          <td height="5" align="left" valign="top"  class="greytext" >&nbsp;</td>
                                        </tr>
                                        <?php
	   
	    }else{?>
                                        <tr align="center">
                                          <td height="20" colspan="4"  class="red_txt2">Order detail not found ! </td>
                                        </tr>
                                        <?php } ?>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td height="30" colspan="4" align="center"  class="rightheadingtxt"><input name="button2" type="button" class="search_bg" value="Close" onclick="window.close();" />                                    </td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td height="25" align="right">&nbsp;</td>
                              </tr>
                          </table></td>
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