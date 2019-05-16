        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=CONTACT_US?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  valign="top">
			
	
		<? if(!empty($_SESSION['sess_contact'])){ ?>
	
	<div class="redtxt" align="center" style="height:250px;padding-top:100px;"><? echo $_SESSION['sess_contact']; unset($_SESSION['sess_contact']); ?></div>
	
	<? }else{ ?>		
			
			
			
			
			
<table width="100%" border="0" cellspacing="0" cellpadding="2">
 <tr>
<td align="center" valign="top"  >

<table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr>
                <td  class="generaltxt_inner" valign="top">
				
				<? echo stripslashes($arrySite[0]['WebContactContent']);?>
                </td>
              </tr>
            </table>
</td>
</tr>            
<tr>
<td align="center" valign="top"  >


<form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">		

<table width="99%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td valign="top"><table width="100%" border="0" align="right" cellpadding="5" cellspacing="1" class="generaltxt_inner" >
    
     
      <tr>
        <td width="22%"   align="right" valign="top"  ><?=YOUR_NAME?> : </td>
        <td colspan="2" align="left" valign="top"  ><input name="Name" type="text" class="txt-feild" id="Name"  maxlength="50" size="24" value="<?=$_SESSION['Name']?>" /> <span class="mandatory">*</span></td>
      </tr>
      <tr>
        <td  align="right" valign="top"  ><?=COMPANY_NAME?> : </td>
        <td colspan="2" align="left" valign="top" ><input name="CompanyName" type="text" class="txt-feild" id="CompanyName"   maxlength="70" size="24" value="<?=stripslashes($arryMemberSession[0]['CompanyName'])?>"/>
         </td>
      </tr>
      <tr>
        <td  align="right" valign="top"  ><?=ADDRESS?> : </td>
        <td colspan="2" align="left" valign="top" ><textarea name="Address" class="txt-feild" id="Address"  cols="30" rows="3"><?=stripslashes($arryMemberSession[0]['Address'])?></textarea></td>
      </tr>
      <tr>
        <td  align="right" valign="top"  ><?=EMAIL?> : </td>
        <td colspan="2" align="left" valign="top" ><input name="ContactEmail" type="text" class="txt-feild" id="ContactEmail"  maxlength="60" size="24" value="<?=stripslashes($arryMemberSession[0]['Email'])?>" />  <span class="mandatory">*</span></td>
      </tr>
      <tr>
        <td  align="right" valign="top"  ><?=COUNTRY?> : </td>
        <td colspan="2" align="left" valign="top" >
		<select name="Country" class="txt-feild" id="Country" style="width: 180px;" >
            <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
            <option value="<?=$arryCountry[$i]['name']?>" <?  if($arryCountry[$i]['country_id']==$arryMemberSession[0]['country_id']){echo "selected";}?>>
            <?=$arryCountry[$i]['name']?>
            </option>
            <? } ?>
          </select>        </td>
      </tr>
      <tr>
        <td  align="right" valign="top"  ><?=POSTAL_CODE?> : </td>
        <td colspan="2" align="left" valign="top" ><input name="PostCode" type="text" class="txt-feild" id="PostCode"   maxlength="20" size="24" value="<?=stripslashes($arryMemberSession[0]['PostCode'])?>"/> </td>
      </tr>
	  
 <tr>
        <td align="right" valign="top" ><?=SUBJECT?> :           </td>
        <td width="83%" align="left" valign="top"  ><input name="Subject" type="text" class="txt-feild" id="Subject" style="width:300px;" maxlength="250" value="<?=$Subject?>" /> <span class="mandatory">*</span>        </td>
      </tr>
      <tr>
        <td height="40" align="right" valign="top" ><?=COMMENTS?> :</td>
        <td ><textarea name="Message" class="txt-feild" id="Message" style="width:300px; height:150px;"></textarea><span class="mandatory">*</span>  <br><?=BETWEEN_10_2000?></td>
      </tr>	  
      <tr>
        <td height="40" align="right" valign="top" >&nbsp;</td>
        <td ><input  class="button" type="submit" name="Submit22" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>"/>
            <input  class="button" type="reset" name="Submit2" value="<?=RESET?>" alt="<?=RESET?>" title="<?=RESET?>"/>
            <input type="hidden" name="CompanyEmail" id="CompanyEmail" value="<?=stripslashes($arrayStore[0]['Email'])?>" />
            <input type="hidden" name="ContactPerson" id="ContactPerson" value="<? echo stripslashes($arrayStore[0]['FirstName']).' '.stripslashes($arrayStore[0]['LastName']);?>" />
            <input type="hidden" name="ContactCompany" id="ContactCompany" value="<?=stripslashes($arrayStore[0]['CompanyName'])?>" />
            <input type="hidden" name="RecieverID" id="RecieverID" value="<?=stripslashes($arrayStore[0]['MemberID'])?>" />
            <input type="hidden" name="SendEmail" id="SendEmail" value="1" />
            <input type="hidden" name="SenderID" id="SenderID" value="<?=$_SESSION['MemberID']?>" />
                  </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<? } ?>

</td>
</tr>			 
			 
			 
            </table>		
			
			
			</td>
          </tr>
         
		 
		 
		 
		 
		 
        </table>

