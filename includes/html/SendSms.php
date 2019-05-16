<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">

	<tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=SEND_SMS?></td>
      </tr>

   
      <tr>
        <td  align="left" valign="middle" class="heading"><?=SEND_SMS?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32"  ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <? if(!empty($_SESSION['Numbers'])) { ?>
          <tr>
            <td align="center" valign="middle"><table width="95%" border="0" cellpadding="8" cellspacing="0" class="graybox_forgot">
                <tr>
                  <td align="left" valign="middle" class="redtxt"> <? echo $_SESSION['msg_number']; unset($_SESSION['msg_number']); ?> </td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="txt" ><? echo $_SESSION['Numbers']; unset($_SESSION['Numbers']); ?> </td>
                </tr>
            </table></td>
          </tr>
		    <tr>
                  <td align="center" valign="middle" height="45" class="skytxt" ><a href="SendSms.php?opt=<?=$_GET['opt']?>"><?=SEND_SMS?></a> </td>
                </tr>
				
		<? }else if(!empty($_SESSION['LimitCrossed'])) { ?>
          <tr>
            <td align="center" valign="middle" >
			
			<table width="95%" border="0" cellpadding="8" cellspacing="0" 
			 class="graybox_forgot">
                <tr>
                  <td align="left" valign="middle"  class="redtxt"> <? echo $_SESSION['LimitCrossed']; unset($_SESSION['LimitCrossed']); ?> </td>
                </tr>
				
            </table>
			
			</td>
          </tr>		
			  <tr>
                  <td align="center" valign="middle" height="45" class="skytxt" ><a href="buyCredits.php?tp=sms"><?=SMS_CREDITS_BUY?></a> </td>
                </tr>
			
			
				
          <? } else { ?>
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="generaltxt_inner">
                <form action="#" method="post" name="form1" id="form1" onsubmit="javascript:return ValidateForm(this);">
       <tr>
     <td colspan="2"  height="35">&nbsp;&nbsp;&nbsp;&nbsp;<?=SMS_CREDITS?>: <?=$arryMemberDetail[0]['MaxSms']?>      </td>
     </tr>
				 
				  <tr>
                    <td height="43" align="right"  >Member's Type&nbsp;</td>
                    <td align="left" ><select name="MemberType" id="MemberType" class="txtfield" onchange="Javascript:ChangeType();">
                        <option value="Seller" <? if($_GET['opt'] == 'Seller') echo 'selected';?>> Seller </option>
                        <option value="Buyer" <? if($_GET['opt'] == 'Buyer') echo 'selected';?>> Buyer </option>
                      </select>                    </td>
                  </tr>
                  <tr>
                    <td width="14%" align="right" valign="top" style="padding-top:8px;"  nowrap="nowrap"> Send SMS To <span class="bluestar">*</span></td>
                    <td width="86%" align="left" valign="top"><?  if(sizeof($arrayMember)>18) { $DivStyle = 'style="height:170px;overflow:auto "';} ?>
                        <div <?=$DivStyle?>>
                          <table width="100%"  border="0" class="outline">
                            <tr>
                              <?   
				  		$flag = 0;
					   if(sizeof($arrayMember)>0) {					   
					  for($i=0;$i<sizeof($arrayMember);$i++) { 
					  
					  	if ($flag % 3 == 0) {
							echo "</tr><tr>";
						}
						
						$Line = $flag+1;
					   ?>
                              <td align="left" valign="top"  class="greentxt"><input type="checkbox" name="Numbers[]" id="Numbers<?=$Line?>" value="<?=$arrayMember[$i]['MemberID'];?>" /><?=stripslashes($arrayMember[$i]['UserName']);?>                              </td>
                              <?
						  $flag++;
						  } 
						  ?>
                            </tr>
                            <? }  else { ?>
                            <tr align="center">
                              <td class="redtxt"> No <?=$_GET['opt']?>s have subscribed.                                </td>
                            </tr>
                            <? } ?>
                          </table>
                          <input type="hidden" name="NumMembers" id="NumMembers" value="<? echo sizeof($arrayMember);?>" />
                        </div>
                      <?  if(sizeof($arrayMember)>1) {	?>
                        <table width="100%"  border="0">
                          <tr>
                            <td align="right" class="skytxt"><a href="javascript:SelectAllEmails();"  ><?=SELECT_ALL?></a> <span class="blackbold"> | </span> <a href="javascript:SelectNoneEmails();"  ><?=SELECT_NONE?></a>&nbsp;</td>
                          </tr>
                        </table>
                      <? } ?>                    </td>
                  </tr>
				  <?  if(sizeof($arrayMember)>0) {		?>
                  <tr>
                    <td width="14%" height="40" align="right" valign="top" nowrap="nowrap" > Enter Number &nbsp;</td>
                    <td width="86%" align="left">
					<textarea name="ccTo" type="text" class="txtfield" id="ccTo" style="width:100%; height:100px;"/></textarea>
					
                       <div > <?=SMS_COMMA?>
					   
					  or <a href="Javascript: OpenNewPopUp('uploadSms.php','500','600','Yes')">Import an Excel (.xls) file</a> 
					   </div></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" >&nbsp;</td>
                    <td align="left" >&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" >Message <span class="bluestar">*</span></td>
                    <td align="left" ><textarea name="Message" id="Message" class="txtfield" cols="49" rows="6" onKeyDown="return taCount(this,'NumLimitSpan')" onKeyUp="return taCount(this,'NumLimitSpan')" ></textarea> 
					<br><Span id="NumLimitSpan" class="greentxt_link">100</Span> Characters remaining. 
					<!-- <a href="Javascript:ClearBox('Message','NumLimitSpan','5');" class="skytxt">Clear</a><br>-->					</td>
                  </tr>
                 
                  <tr>
                    <td align="center" height="80" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle"><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" />
                      <input type="hidden" name="SellerMessage" id="SellerMessage" value="<? echo $SellerMessage;?>" />
					  
					  <input type="hidden" name="StoreID" id="StoreID" value="<? echo $_SESSION['MemberID'];?>" />
					   <input type="hidden" name="MaxSms" id="MaxSms" value="<?=$arryMemberDetail[0]['MaxSms']?>" />					  </td>
                  </tr>
				  <? } ?>
                </form>
            </table></td>
          </tr>
          <? } ?>
        </table></td>
      </tr>
    </table></td>
       <td align="right"  valign="top"><? require_once("includes/html/box/right.php"); ?>    </td>

  </tr>
</table>
</td>
  </tr>
</table>
