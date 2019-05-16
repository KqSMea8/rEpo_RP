<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=PAYMENT_INFORMATION?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=PAYMENT_INFORMATION?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  <? if(!empty($_SESSION['mess_payment'])) { ?>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  		<?
			  		echo $_SESSION['mess_payment'];
					unset($_SESSION['mess_payment']); 
					?>
			  </td>
       </tr>
	  <? } ?>
	  
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" onSubmit="return validate(this);" >
           
            
			
		 <tr>
              <td height="15"></td>
            </tr>	
			 
 	<tr>
        <td  class="generaltxt_inner" height="30"> <strong><?=CURRENCY_ACCEPTED?></strong>:&nbsp;&nbsp; 
		
  <? 
	if($arryMember[0]['currency_id'] != ''){
		$CurrencySelected = $arryMember[0]['currency_id']; 
	}else{
		$CurrencySelected = 9;
	}
	?>
           <select name="currency_id" class="txt-feild" id="currency_id"  >
             <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
               <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>><?=$arryCurrency[$i]['name']?></option>
             <? } ?>
         </select>		
		<br><br><?=CURRENCY_MSG?>
		
		</td>
     </tr>	
 	<tr>
            <td class="generaltxt_inner" height="60">
			<strong><?=PAYMENT_TYPE?></strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<? for($i=0;$i<sizeof($arrayPaymentGateways);$i++){
				$Line = $i+1;
				$fieldname = $arrayPaymentGateways[$i]['fieldname'];
				if($Line==4) { 
					$Line=3; 
				}
			?>
		<input type="checkbox" name="<?=$arrayPaymentGateways[$i]['fieldname']?>" id="<?=$arrayPaymentGateways[$i]['fieldname']?>" onclick="Javascript:ShowPayDiv('<?=$Line?>','<?=$fieldname?>');" value="1"  <? if($arryMember[0][$arrayPaymentGateways[$i]['fieldname']] == '1') echo 'checked';?>><?=$arrayPaymentGateways[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;		
			<? } ?>
			</td>
          </tr> 
		
			
<tr>
              <td align="center" valign="top"  >
			  <Div id="PaymentDiv1" <? if($arryMember[0]['MyGatePayment'] != 1) echo 'style="display:none"';?>>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
            <td class="graybox" colspan="2"><?=$arrayPaymentGateways[0]['name']?> </td>
          </tr>   
					<tr>
				  <td colspan=2 class="generaltxt_inner" height=60><?=MY_GATE_MEANING?></td>
				  </tr>
					    <tr>
                          <td width="20%" height="30" align="left" valign="middle" ><?=MYGATE_MODE?><span class="bluestar">*</span> 
                              </td>
                          <td  height="30" align="left" valign="middle">
						  <select name="MyGate_Mode" id="MyGate_Mode" class="txt-feild" style="width: 180px;">
                            <option value="0" <? if($arryMember[0]['MyGate_Mode'] == '0') echo 'selected';?>> Test Mode </option>
                            <option value="1" <? if($arryMember[0]['MyGate_Mode'] == '1') echo 'selected';?>> Live Mode </option>
                          </select>
						  </td>
                        </tr>
				
						<tr>
                          <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=MYGATE_MERCHANT_ID?><span class="bluestar">*</span>       </td>
                          <td  height="30" align="left" valign="middle"><input name="MyGate_MerchantID" type="text" class="txtfield" id="MyGate_MerchantID" value="<? echo $arryMember[0]['MyGate_MerchantID']; ?>"  maxlength="50" size="30" /></td>
                        </tr>
						
                      
						 <tr>
                          <td w height="30" align="left" valign="middle" ><?=MYGATE_APPLICATION_ID?><span class="bluestar">*</span>
                              </td>
                          <td height="30" align="left" valign="middle"><input name="MyGate_ApplicationID" type="text" class="txtfield" id="MyGate_ApplicationID" value="<? echo stripslashes($arryMember[0]['MyGate_ApplicationID']); ?>"  maxlength="50" size="30" /></td>
                        </tr>
						
						  <tr>
				  <td colspan=2  height=20></td>
				  </tr>
				
                    </table>
			  </Div>
			  
			  
	<Div id="PaymentDiv2" <? if($arryMember[0]['PaypalPayment'] != 1) echo 'style="display:none"';?>>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
            <td class="graybox" colspan="2"><?=$arrayPaymentGateways[1]['name']?> </td>
          </tr>  
				
					<tr>
				  <td colspan=2 class="generaltxt_inner" height=40><?=PAYPAL_MEANING?></td>
				  </tr>
						<tr>
                          <td  width="20%"  align="left" valign="top"  nowrap="nowrap"><?=PAYPAL_ID?><span class="bluestar">*</span>       </td>
                          <td align="left" valign="top"><input name="PaypalID" type="text" class="txtfield" id="PaypalID" value="<? echo stripslashes($arryMember[0]['PaypalID']); ?>"  maxlength="80" size="30" /></td>
                        </tr>
				<tr>
				  <td colspan=2  height=20></td>
				  </tr>
				
                    </table>
			  </Div>		  
			  
	 <Div id="PaymentDiv3" <? if($arryMember[0]['EftPayment'] != 1) echo 'style="display:none"';?>>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
            <td class="graybox" colspan="2"><?=$arrayPaymentGateways[2]['name']?> / <?=$arrayPaymentGateways[3]['name']?></td>
          </tr>  
		 
		 <tr>
           <td colspan="2" class="generaltxt_inner" height="60" ><?=EFT_DIRECT_PAYMENT_MEANING?></td>
         </tr>
         <tr>
           <td  height="30" width="20%"  align="left" valign="middle"  nowrap="nowrap"><?=ACCOUNT_HOLDER?>
               <span class="bluestar">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountHolder" type="text" class="txtfield" id="AccountHolder" value="<? echo stripslashes($arryMember[0]['AccountHolder']); ?>"  maxlength="50" size="30" /></td>
         </tr>
         <tr>
           <td  height="30"  align="left" valign="middle"  nowrap="nowrap"><?=ACCOUNT_NUMBER?>
               <span class="bluestar">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountNumber" type="text" class="txtfield" id="AccountNumber" value="<? echo stripslashes($arryMember[0]['AccountNumber']); ?>"  maxlength="40" size="30" /></td>
         </tr>
         <tr>
           <td  height="30" align="left" valign="middle" ><?=BANK_NAME?>
               <span class="bluestar">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BankName" type="text" class="txtfield" id="BankName" value="<? echo stripslashes($arryMember[0]['BankName']); ?>"  maxlength="40" size="30" /></td>
         </tr>
		  <tr>
           <td  height="30" align="left" valign="middle" ><?=BRANCH_CODE?>
               <span class="bluestar">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BranchCode" type="text" class="txtfield" id="BranchCode" value="<? echo stripslashes($arryMember[0]['BranchCode']); ?>"  maxlength="30" size="30" /></td>
         </tr>
		  <tr>
           <td  height="30" align="left" valign="middle" ><?=SWIFT_NUMBER?>
                </td>
           <td height="30" align="left" valign="middle"><input name="SwiftNumber" type="text" class="txtfield" id="SwiftNumber" value="<? echo stripslashes($arryMember[0]['SwiftNumber']); ?>"  maxlength="30" size="30" /></td>
         </tr>
		   <tr>
            <td height="20"></td>
          </tr>  
       </table>
	 </Div>		  			  
			  
			  
		<Div id="ShippingDiv"
	<? if($arryMember[0]['MyGatePayment'] == 1 ||  $arryMember[0]['PaypalPayment'] == 1 || $arryMember[0]['EftPayment'] == 1 ||  $arryMember[0]['DepositPayment'] == 1) echo 'style="display:inline"'; else echo 'style="display:none"';?>	
		
		>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" >
			    <tr>
            <td class="graybox" colspan="2"><?=SHIPPING_CHARGES?> </td>
          </tr>  
			   <tr>
					  <td  height="40" width="20%" align="left" valign="middle"  nowrap="nowrap"><?=SHIPPING_CHARGES?> (%)      </td>
					  <td   align="left" valign="middle"><input name="Shipping" type="text" class="txtfield" id="Shipping" value="<? echo $arryMember[0]['Shipping']; ?>"  maxlength="3" size="30" /></td>
					</tr>
		  </table>
		  
		</Div>  
			  
			  
			  
			  </td>
            </tr>	           
           
           
            
           
            <tr>
              <td height="79" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20%" align="left"><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31"></td>
                    <td width="80%" align="left">
					<input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
						<input type="hidden" name="UpdatePayment" id="UpdatePayment" value="1" />
				
   			</td>
                  </tr>
              </table></td>
            </tr>
           
          </form>
        </table>        </td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
