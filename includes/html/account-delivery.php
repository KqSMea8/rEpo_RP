<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=DELIVERY_FEE?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=DELIVERY_FEE?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  <? if(!empty($_SESSION['mess_delivery'])) { ?>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  		<?
			  		echo $_SESSION['mess_delivery'];
					unset($_SESSION['mess_delivery']); 
					?>
			  </td>
       </tr>
	  <? } ?>
	  
      <tr>
        <td height="32" class="generaltxt_inner">
		  <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" onSubmit="return validate(this);" >
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
      <td  align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" width="50%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="40%" height="50" align="left" valign="middle" ><?=DELIVERY_OPTIONS?>                     </td>
              <td  height="30" align="left" valign="middle">
			  <select name="DeliveryOption" class="txt-feild" id="DeliveryOption" style="width: 180px;" onchange="Javascript: ShowDeliveryOptions();" >
			  	<option value="0" >None</option>
                <? for($i=1;$i<=$Config['NumDeliveryOption'];$i++) {?>
                <option value="<?=$i?>" <?  if($i==sizeof($arryDelivery)){echo "selected";}?>>
                <?=$i?>
                </option>
                <? } ?>
              </select></td>
            </tr>
            
            
			
          </table></td>
          <td class="smalltxt" height="30"><?=$VatMsg?>&nbsp;</td>
        </tr>
      </table>
	  
	  <? for($i=1;$i<=$Config['NumDeliveryOption'];$i++) { 
	  	$Counter = $i-1;
	  ?>
	  
	    <Div id="DeliveryOptionDiv<?=$i?>" <? if(sizeof($arryDelivery)<$i) echo 'style="display:none"';?> >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	<tr>
      <td height="15" colspan="2"></td>
    </tr>
		  <tr>
            <td  width="50%" height="40" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="40%" height="30" align="left" valign="middle" >
				  <input type="checkbox" name="DeliveryStatus<?=$i?>" id="DeliveryStatus<?=$i?>"  value="1" 
				  <? if($arryDelivery[$Counter]['Status']==1) echo 'checked';?> />
				  <?=DELIVERY_OPTION?> <?=$i?> <span class="bluestar">*</span></td>
                  <td  height="30" align="left" valign="middle">
		 <input name="DeliveryName<?=$i?>" type="text" class="txtfield" id="DeliveryName<?=$i?>" value="<?=stripslashes($arryDelivery[$Counter]['Name'])?>"  maxlength="200" size="30" />
				  </td>
                </tr>
            </table></td>
            <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="40%" height="30" align="left" valign="middle" >
				<?=DELIVERY_FEE?> <?=$i?> <span class="bluestar">*</span> </td>
                <td  height="30" align="left" valign="middle" class="generaltxt_inner"><input name="DeliveryFee<?=$i?>" type="text" class="txtfield" id="DeliveryFee<?=$i?>" value="<?=stripslashes($arryDelivery[$Counter]['Price'])?>"  maxlength="6" size="23" /> (<?=$StoreCurrency?>)
                  </td>
              </tr>
            </table></td>
          </tr>
	
        </table>
		</Div>
		<? } ?>
		
		
		</td>
    </tr>
	
    <tr>
            <td height="30" colspan="2" align="left" valign="middle" >&nbsp;</td>
      </tr>
	  
          <tr>
            <td height="30" colspan="2" align="left" valign="middle" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="40%" align="left"><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" /></td>
                <td width="80%" align="left">&nbsp;&nbsp;
                    <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
                    <input type="hidden" name="UpdateDelivery" id="UpdateDelivery" value="1" />
					 <input type="hidden" name="NumDeliveryOption" id="NumDeliveryOption" value="<?=$NumDeliveryOption?>" />
					
                </td>
              </tr>
            </table></td>
            </tr>
        </table>
		</form>
          </td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
