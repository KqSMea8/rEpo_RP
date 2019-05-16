<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=EDIT_ACCOUNT?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=EDIT_ACCOUNT?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  
	 <? if(!empty($_SESSION['mess_account_update'])) { ?>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  		<?
			  		echo $_SESSION['mess_account_update'];
					unset($_SESSION['mess_account_update']); 
					?>
			  </td>
       </tr>
	  <? } ?> 
	  
	  
<tr>
				<td>
				
				
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 
  <tr>
	 <td >
	<?=USER_NAME?>:	</td>
	<td class="generaltxt_inner">
	<?=$arryMember[0]['UserName']?>	</td>
  </tr>
  <tr>
	 <td  nowrap="nowrap" >
	<?=EMAIL?>:	</td>
	<td class="generaltxt_inner">
	<?=$arryMember[0]['Email']?>	</td>
  </tr>
   <tr>
    <td width="13%" >
		<?=MEMBERSHIP?>:	</td>
	<td width="87%" class="generaltxt_inner">
		<?=$arryMember[0]['Membership']?>	</td>
  </tr>
  <!--
   <tr>
     <td ><?=EMAIL_CREDITS?>:</td>
     <td class="generaltxt_inner"><?=$arryMember[0]['MaxEmail']?></td>
   </tr>
   
   <tr>
     <td ><?=SMS_CREDITS?>:</td>
     <td class="generaltxt_inner"><?=$arryMember[0]['MaxSms']?></td>
   </tr>-->
</table>

				
				</td>
			</tr>
		 <tr>
              <td height="12"></td>
            </tr>	
			  
	  
	  
	     <tr>
            <td class="graybox"><?=PERSONAL_INFORMATION?> </td>
          </tr>
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" onSubmit="return validate(this);" >
           
            <tr>
              <td  align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="35%"  height="30" align="left" valign="middle" ><?=FIRST_NAME?>
                              <span class="bluestar">*</span></td>
                          <td  height="30" align="left" valign="middle"><input name="FirstName" type="text" class="txtfield_normal"id="FirstName" value="<? echo stripslashes($arryMember[0]['FirstName']); ?>"  maxlength="50" size="30" /></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=LAST_NAME?>
                              <span class="bluestar">*</span></td>
                          <td height="30" align="left" valign="middle"><input name="LastName" type="text" class="txtfield_normal" size="30"id="LastName" value="<? echo stripslashes($arryMember[0]['LastName']); ?>"  maxlength="50" /></td>
                        </tr>
						
    <tr>
                          <td   height="30" align="left" valign="top" ><?=ADDRESS?>
                              <span class="bluestar">*</span></td>
                          <td  height="30" align="left" valign="middle" ><textarea name="Address" rows="3"   class="txtfield_normal" id="Address"><? echo $arryMember[0]['Address'];?></textarea></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=POSTAL_CODE?>
                              <span class="bluestar">*</span></td>
                          <td height="30" align="left" valign="middle"><span >
                            <input name="PostCode" type="text" class="txtfield_normal" size="30" id="PostCode" value="<? echo $arryMember[0]['PostCode']; ?>" maxlength="10" />
                          </span></td>
                        </tr>
  
  
                    </table></td>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td  height="30"  width="35%" align="left" valign="middle"  nowrap="nowrap"><?=LANDLINE_NUMBER?>
    &nbsp;&nbsp;&nbsp;</td>
                  <td  height="30" align="left" valign="middle"><input name="LandlineNumber" type="text" class="txtfield_normal" id="LandlineNumber" value="<? echo $arryMember[0]['LandlineNumber']; ?>"  maxlength="30" size="30"></td>
  </tr>						
						
						<tr>
                          <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=MOBILE_NUMBER?>
                              <span class="bluestar">*</span>&nbsp;&nbsp;&nbsp;</td>
                          <td  height="30" align="left" valign="middle">
						  
<? 
	if($arryMember[0]['isd_code'] != ''){
		$IsdSelected = $arryMember[0]['isd_code']; 
	}else{
		$IsdSelected = 1;
	}
	?>
	<!--
   <select name="isd_code" class="txtfield_normal" id="isd_code" style="width: 72px;"  >
   			<option value="">ISD Code</option>
                        <? for($i=0;$i<sizeof($arryIsd);$i++) {
						  if($arryIsd[$i]['isd_code']>0){
						?>
                        <option value="<?=$arryIsd[$i]['isd_code']?>" <?  if($arryIsd[$i]['isd_code']==$IsdSelected){echo "selected";}?>>
                        <?=$arryIsd[$i]['isd_code']?>
                        </option>
				
                        <? }} ?>
  </select>	-->							  
						  
						  
						  <input name="Phone" type="text" class="txtfield_normal"id="Phone" value="<? echo $arryMember[0]['Phone']; ?>"  maxlength="30"  size="30"/></td></tr>
						
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=FAX?></td>
                          <td height="30" align="left" valign="middle"><input name="Fax" type="text" class="txtfield_normal" size="30"id="Fax" value="<? echo $arryMember[0]['Fax']; ?>"  maxlength="30"/></td>
                        </tr>
                       <tr>
                          <td  height="30"  align="left" valign="middle" ><?=COUNTRY?></td>
                          <td  height="30" align="left" valign="middle">
	<? 
	if($arryMember[0]['country_id'] != ''){
		$CountrySelected = $arryMember[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
                              <select name="country_id" class="txtfield_normal" id="country_id"  onchange="Javascript: StateListSend();" >
                                <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                                <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
                                <?=$arryCountry[$i]['name']?>
                                </option>
                                <? } ?>
                              </select>
                          </td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=STATE?></td>
                          <td height="30" align="left" valign="middle" id="state_td" ><img src="images/loading.gif" /></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=CITY?></td>
                          <td height="30" align="left" valign="middle" id="city_td"><img src="images/loading.gif" /></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            
	 	
          
    		
			
           <tr>
            <td class="graybox"><?=COMPANY_INFORMATION?> </td>
          </tr>
            <tr>
              <td height="84" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="50%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="35%" height="30" align="left" valign="middle" ><?=COMPANY_NAME?>
                              <span class="bluestar">*</span></td>
                          <td  height="30" align="left" valign="middle"><input name="CompanyName" type="text" class="txtfield_normal" size="30" id="CompanyName" value="<? echo stripslashes($arryMember[0]['CompanyName']); ?>"  maxlength="50" /></td>
                        </tr>
			
		            <tr >
              <td height="30" align="left" valign="top" ><?=COMPANY_TAG_LINE?></td>
              <td height="30" align="left" valign="top" class="generaltxt_inner"><textarea name="TagLine" type="text" class="txtfield_normal"  id="TagLine" rows="3" ><? echo stripslashes($arryMember[0]['TagLine']); ?></textarea></td>
            </tr>					


		<tr>
              <td height="30" align="left" valign="middle" ><?=CONTACT_PERSON?></td>
              <td height="30" align="left" valign="middle"><input name="ContactPerson" type="text" class="txtfield_normal" size="30" id="ContactPerson" value="<? echo stripslashes($arryMember[0]['ContactPerson']); ?>"  maxlength="50" /></td>
            </tr>
            <tr>
              <td height="30" align="left" valign="middle" ><?=CONTACT_NUMBER?></td>
              <td height="30" align="left" valign="middle"><input name="ContactNumber" type="text" class="txtfield_normal" size="30" id="ContactNumber" value="<? echo stripslashes($arryMember[0]['ContactNumber']); ?>"  maxlength="30" /></td>
            </tr>				
                       
					   
		<tr>
		  <td height="30" align="left" valign="top" ><?=COMPANY_LOGO?></td>
		  <td height="30" align="left" valign="top"><input name="Image" type="file" class="txtfield_normal" id="Image" style="width:188px;" onkeypress="javascript: return false;" onkeydown="javascript: return false;"  oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
		  </td>
		</tr>
		
		<tr>
		  <td height="30" align="left" valign="top" >Banner</td>
		  <td height="30" align="left" valign="top"><input name="Banner" type="file" class="txtfield_normal" id="Banner" style="width:188px;" onkeypress="javascript: return false;" onkeydown="javascript: return false;"  oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
		  </td>
		</tr>						
						 <tr>
              <td height="30"  align="left" valign="middle" ><?=ALTERNATE_EMAIL?></td>
              <td height="30" align="left" valign="middle" class="generaltxt_inner"><input name="AlternateEmail" type="text" class="txtfield_normal" size="30" id="AlternateEmail" value="<? echo stripslashes($arryMember[0]['AlternateEmail']); ?>"  maxlength="70" /></td>
            </tr>  
					  
						  

                    </table></td>
                    <td valign="top" width="50%" align="center">
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                     
					 <tr>
                        <td width="35%" height="2" align="left" valign="middle" ></td>
                        <td  align="left" valign="middle">
			
							</td>
                      </tr>
					 
					 <? if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){  ?>
					  <tr>
                        <td height="30" align="left" valign="middle" >Cuurent Logo:</td>
                        <td  height="30" align="left" valign="middle">
			
		<? echo '<a href="upload/company/'.$arryMember[0]['Image'].'"  rel="lightbox"><img src="resizeimage.php?img=upload/company/'.$arryMember[0]['Image'].'&w=100&h=100" border=0></a>'; ?>
	</td>
                      </tr>
						<? } ?>
						 <tr>
                        <td height="10" align="left" valign="middle" ></td>
                        <td  align="left" valign="middle">
			
							</td>
                      </tr>
						 <? if($arryMember[0]['Banner'] !='' && file_exists('upload/company/'.$arryMember[0]['Banner']) ){  ?>
					  <tr>
                        <td height="30" align="left" valign="middle" >Cuurent Banner:</td>
                        <td  height="30" align="left" valign="middle">
			
		<? echo '<a href="upload/company/'.$arryMember[0]['Banner'].'"  rel="lightbox"><img src="resizeimage.php?img=upload/company/'.$arryMember[0]['Banner'].'&w=200&h=200" border=0></a>'; ?>
	</td>
                      </tr>
						<? } ?>
                    </table>
                      </td>
                  </tr>
              </table></td>
            </tr>
           


		
		
			<tr>
              <td height="8" ></td>
            </tr>
			 <tr>
            <td height="25" class="generaltxt_inner" valign="bottom">
<input name="EmailSubscribe" id="EmailSubscribe" type="checkbox" value="1" <?  if($arryMember[0]['EmailSubscribe'] == 1) { echo 'checked';}?>/><strong><?=SUBSCRIBE_EMAIL?></strong>
                
				</td>
          </tr>
		  <!--
		   <tr>
            <td height="25" class="generaltxt_inner" valign="bottom">
<input name="SmsSubscribe" id="SmsSubscribe" type="checkbox" value="1" <?  if($arryMember[0]['SmsSubscribe'] == 1) { echo 'checked';}?>/><strong><?=SUBSCRIBE_SMS?></strong>
                
				</td>
          </tr>
		  -->
		  
            <tr>
              <td height="79" align="left" valign="middle"><table  border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td align="left"><input name="SubmitButton" id="SubmitButton" type="submit" value="Update" class="button"></td>
					<td>&nbsp;</td>
                    <td align="left"><input type="reset" name="Reset" value="Reset" class="button" />
                       
			<input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
   			<input type="hidden" name="UpdateCompany" id="UpdateCompany" value="1" />
			<input type="hidden" name="main_state_id" id="main_state_id"  value="<? echo $arryMember[0]['state_id']; ?>" />
			<input type="hidden" name="main_city_id" id="main_city_id"  value="<? echo $arryMember[0]['city_id']; ?>" /></td>
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
