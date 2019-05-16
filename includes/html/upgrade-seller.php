<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=UPGRADE_TO_SELLER?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=UPGRADE_TO_SELLER?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" onSubmit="return validate(this);" >
           
            <tr>
              <td height="84" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20%" height="30" align="left" valign="middle" ><?=FIRST_NAME?>
                              <span class="bluestar">*</span></td>
                          <td width="30%" height="30" align="left" valign="middle"><input name="FirstName" type="text" class="txtfield"id="FirstName" value="<? echo stripslashes($arryMember[0]['FirstName']); ?>"  maxlength="50" size="30" /></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=LAST_NAME?>
                              <span class="bluestar">*</span></td>
                          <td height="30" align="left" valign="middle"><input name="LastName" type="text" class="txtfield" size="30"id="LastName" value="<? echo stripslashes($arryMember[0]['LastName']); ?>"  maxlength="50" /></td>
                        </tr>
                    </table></td>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td  height="30" align="left" valign="middle"  nowrap="nowrap"><?=CONTACT_NUMBER?>
                              <span class="bluestar">*</span>&nbsp;&nbsp;&nbsp;</td>
                          <td  height="30" align="left" valign="middle"><input name="Phone" type="text" class="txtfield"id="Phone" value="<? echo $arryMember[0]['Phone']; ?>"  maxlength="30" size="30" /></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=FAX?></td>
                          <td height="30" align="left" valign="middle"><input name="Fax" type="text" class="txtfield" size="30"id="Fax" value="<? echo $arryMember[0]['Fax']; ?>"  maxlength="30"/></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            
            <tr>
              <td height="1" bgcolor="#d6d6d6" style="padding:0px; margin:0px;"></td>
            </tr>
            <tr>
              <td height="84" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20%" height="30" align="left" valign="middle" ><?=COMPANY_NAME?>
                              <span class="bluestar">*</span></td>
                          <td width="30%" height="30" align="left" valign="middle"><input name="CompanyName" type="text" class="txtfield" size="30" id="CompanyName" value="<? echo stripslashes($arryMember[0]['CompanyName']); ?>"  maxlength="50" /></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=COMPANY_LOGO?></td>
                          <td height="30" align="left" valign="middle"><input name="Image" type="file" class="txtfield" id="Image" size="16"  onkeypress="javascript: return false;" onkeydown="javascript: return false;"  oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
						  
 <? if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){  
		echo '<br><a href="#" onclick="OpenNewPopUp(\'showimage.php?img=upload/company/'.$arryMember[0]['Image'].'\', 150, 100, \'yes\' );" class="greentxt">'.VIEW_LOGO.'</a>';
	}
 ?>
						  
						  </td>
                        </tr>
                    </table></td>
                    <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td  height="30" width="38%" align="left" valign="middle" ><?=WEBSITE?>
                              <span class="bluestar">*</span></td>
                          <td  height="30" align="left" valign="middle"><span class="blacktxt">
                            <input name="Website" type="text" class="txtfield" id="Website" value="<? echo stripslashes($arryMember[0]['Website']); ?>" size="30" maxlength="100" />
                          </span></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" >&nbsp;</td>
                          <td height="30" align="left" valign="middle" class="generaltxt_inner">(for e.g. http://webo.co.za)</td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
           
            <tr>
              <td height="1" bgcolor="#d6d6d6" style="padding:0px; margin:0px;"></td>
            </tr>
            <tr>
              <td height="114" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20%" height="30" align="left" valign="middle" ><?=ADDRESS?>
                              <span class="bluestar">*</span></td>
                          <td width="30%" height="30" align="left" valign="middle"><span >
                            <input name="Address" type="text" class="txtfield" size="30" id="Address" value="<? echo $arryMember[0]['Address']; ?>" maxlength="100" />
                          </span></td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="middle" ><?=POSTAL_CODE?>
                              <span class="bluestar">*</span></td>
                          <td height="30" align="left" valign="middle"><span >
                            <input name="PostCode" type="text" class="txtfield" size="30" id="PostCode" value="<? echo $arryMember[0]['PostCode']; ?>" maxlength="10" />
                          </span></td>
                        </tr>
                    </table></td>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td  height="30" width="38%" align="left" valign="middle" ><?=COUNTRY?></td>
                          <td  height="30" align="left" valign="middle"><? 
	if($arryMember[0]['country_id'] != ''){
		$CountrySelected = $arryMember[0]['country_id']; 
	}else{
		$CountrySelected = 207;
	}
	?>
                              <select name="country_id" class="txt-feild" id="country_id" style="width: 180px;" onchange="Javascript: StateListSend();" >
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
              <td height="79" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20%" align="left"><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31"></td>
                    <td width="80%" align="left"><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetRegister" />
                       
			<input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
   			<input type="hidden" name="UpgradeSeller" id="UpgradeSeller" value="1" />
			<input type="hidden" name="main_state_id" id="main_state_id"  value="<? echo $arryMember[0]['state_id']; ?>" />
			<input type="hidden" name="main_city_id" id="main_city_id"  value="<? echo $arryMember[0]['city_id']; ?>" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="32" align="left" valign="top" class="generaltxt_inner"><span >Note:</span>
                  <?=MANDATORY_REGISTRATION?>
              </td>
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
