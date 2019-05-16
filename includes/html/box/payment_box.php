<? 
	$arrayPaymentGateways = $objConfig->GetPaymentGateways();

?>
<br><br><br>
	 <?  if($arrayConfig[0]['PaypalPayment']=='1') { ?>	

 <table width="80%" cellpadding="5"  border="0" align="center"  class="outline"  >
                           
							<tr>
							
						
							
							
							
							<?  if($arrayConfig[0]['PaypalPayment']=='1') { ?>	
                              <td align="center" >							  
						 <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckoutsm.gif" alt="Paypal Checkout" onclick="Javascript: PaymentSubmitForm(2);"  style="cursor:pointer; padding:30px;" />	  
						 
							  </td>
							  <? } ?>
							 <!-- 
							 <td width="48%" align="left"><input type="image" name="Google Checkout2" alt="Fast checkout through Google" onclick="Javascript: PaymentSubmitForm(2);" 
							src="http://checkout.google.com/buttons/checkout.gif?merchant_id=809948875536783&amp;w=180&amp;h=46&amp;style=white&amp;variant=text&amp;loc=en_US" height="46" width="180"/>
							 </td>	-->
                            </tr>
                          </table>
	<? } ?>					  
	 <?  

	 if($arrayConfig[0]['EftPayment']=='1' || $arrayConfig[0]['DepositPayment']=='1') { 
	 
	 ?>	
						  
						  <table width="80%" border="0" cellspacing="0" cellpadding="5" align="center"  class="outline" >
                             <tr>
                                <td   colspan="2" ></td>
                              </tr>
						  
							   <tr>
							   
							  <?  if($arrayConfig[0]['EftPayment']=='1') { ?>	
                                <td valign="top" align="center"   >
								<!--
								<input name="Submit235" type="button" class="button"  id="Submit23" value="<?=$arrayPaymentGateways[2]['name']?>" alt="<?=$arrayPaymentGateways[2]['name']?>" onclick="Javascript: PaymentSubmitForm(3);"  />-->
								
						 <img src="images/eft.png" alt="<?=$arrayPaymentGateways[2]['name']?>" onclick="Javascript: PaymentSubmitForm(3);"  style="cursor:pointer;" />	  
								
								</td>
							   <? } ?>
							  
							   <?  if($arrayConfig[0]['DepositPayment']=='1') { ?>	
                                <td valign="top" align="center"   >
								
								<!--
								<input name="Submit237" type="button" class="button"  id="Submit23" value="<?=$arrayPaymentGateways[3]['name']?>" alt="<?=$arrayPaymentGateways[3]['name']?>" onclick="Javascript: PaymentSubmitForm(4);"  />-->

						 <img src="images/direct_deposit.png" alt="<?=$arrayPaymentGateways[3]['name']?>" onclick="Javascript: PaymentSubmitForm(4);" style="cursor:pointer;" />	  

								
								</td>
							   <? } ?>
							   
							    </tr>
								 <tr>
                                <td   colspan="2" ></td>
                              </tr>
							  <tr>
							  <td colspan="2">
<table width="60%" border="0" align="center" cellpadding="3" cellspacing="1"  class="graybox_forgot" style="display:none"  >
                             <tr>
                               <td colspan="2" align="left" valign="bottom" >
							  <strong> <?=strtoupper($arrayPaymentGateways[2]['name'])?> / <?=strtoupper($arrayPaymentGateways[3]['name'])?> DETAILS </strong>
							   
							   </td>
                             </tr>
                             <tr>
                               <td align="left" width="37%" nowrap="nowrap"><?=ACCOUNT_HOLDER?> :</td>
                               <td  align="left" valign="top"    ><?=$arrayConfig[0]['AccountHolder']?></td>
                             </tr>
                             <tr>
                               <td width="17%" align="left"  nowrap="nowrap"><?=ACCOUNT_NUMBER?> :
                                  </td>
                               <td align="left" valign="top"><?=$arrayConfig[0]['AccountNumber']?></td>
                             </tr>
                             <tr>
                               <td align="left"  valign="top"><?=BANK_NAME?> : </td>
                               <td  align="left"><?=$arrayConfig[0]['BankName']?></td>
                             </tr>
                             <tr>
                               <td align="left" ><?=BRANCH_CODE?> : </td>
                               <td   align="left"  ><?=$arrayConfig[0]['BranchCode']?></td>
                             </tr>
                             <tr>
                               <td align="left" ><?=SWIFT_NUMBER?> : </td>
                               <td  align="left" ><?=$arrayConfig[0]['SwiftNumber']?></td>
                             </tr>
                           </table>									  
							  </td>
							  </tr>
							  
                          </table>
				   
						  
						  
    <? }  ?>