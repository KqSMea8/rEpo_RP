<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top" width="163">
		<? if (empty($_SESSION['UserName']) && empty($_SESSION['MemberID'])) {
			 	include('includes/html/box/left.php'); 
	 		}else{
				include('includes/html/box/left_member.php'); 
			}	 
	    ?></td>
        <td width="6"><img src="images/spacer.gif" width="6" height="1" /></td>
        <td align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
	<form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">		
          <tr>
            <td  >
				
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="8" height="26" background="images/bg-blue-left.jpg">&nbsp;</td>
                    <td bgcolor="#15507A" class="heading" ><?=SEND_EMAIL?></td>
                    <td width="6" background="images/bg-blue-right.jpg">&nbsp;</td>
                  </tr>
                </table></td>
          </tr>
        
	
  
		
		
<? if(sizeof($arryMember)>0){ ?>				 
<tr>
<td align="center" valign="top"  bgcolor="#FFFFFF" height="200" >
<table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  
    <td bgcolor="#ffffff" valign="top" >&nbsp;</td>
  </tr>
</table>
<Div id="FirstTableDiv">
<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td>
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="128" height="24" bgcolor="#999797" class="whit-txt" nowrap="nowrap"><?php echo strtoupper(stripslashes($arryMember[0]['CompanyName'])); ?> </td>
    <td width="677">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F7F8" class="outline" >
  <tr>
    <td height="6" ></td>
    </tr>
  <tr>
    <td  valign="top" bgcolor="#F9F7F8">
	<table width="100%" border="0" align="right" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" class="simpletxt" >
      <tr>
                <td   align="right" valign="top" bgcolor="#F9F7F8" > <?=TO?></td>
                 

                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8" >
				<a href="view-company.php?view=<?=$arryMember[0]['MemberID']?>&opt=<?=$_GET['opt']?>" target="_blank" class="verdan11" ><u>
				<?php echo stripslashes($arryMember[0]['Name']); ?> (<?php echo strtoupper(stripslashes($arryMember[0]['CompanyName'])).','.stripslashes($arryMember[0]['Country']); ?>)</u></a>
			
				
	<input type="hidden" name="CompanyEmail" id="CompanyEmail" value="<?=stripslashes($arryMember[0]['Email'])?>" />
	<input type="hidden" name="ContactPerson" id="ContactPerson" value="<?=stripslashes($arryMember[0]['Name'])?>" />
	<input type="hidden" name="ContactCompany" id="ContactCompany" value="<?=stripslashes($arryMember[0]['CompanyName'])?>" />	
	<input type="hidden" name="RecieverID" id="RecieverID" value="<?=stripslashes($arryMember[0]['MemberID'])?>" />
				
				
							</td>
              </tr>
              <tr>
                <td   align="right" valign="top" bgcolor="#F9F7F8"><?=SUBJECT?>
                  <span class="red12">*</span></td>
                  
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8" >
                  <input name="Subject" type="text" class="textbox" id="Subject" style="width:300px;" maxlength="250" value="<?=$Subject?>" />                </td>
              </tr>
			   <tr>
                <td height="40" align="right" valign="top" bgcolor="#F9F7F8"><?=COMMENTS?>
                    <span class="red12">*</span></td>
                <td colspan="2" bgcolor="#F9F7F8">
				<textarea name="Message" class="txt-feild" id="Message" style="width:300px; height:150px;"></textarea>
                    <span class="redtxt"><?=BETWEEN_10_500?></span></td>
              </tr>
               <tr>
                 <td   align="right"  bgcolor="#F9F7F8" ><?=WORD_VERIFICATION?>
                   <span class="red12">*</span></td>
                 <td width="21%" align="left"  bgcolor="#F9F7F8" >
				 <input name="verifyText" type="text" size="24" class="txt-feild" id="verifyText"  maxlength="15" /></td>
                 <td width="62%" align="left" valign="top" bgcolor="#F9F7F8" ><img src="random.php" width="120" height="30" />
                   <input name="verifyHidden" type="hidden" class="inputbox" id="verifyHidden" size="30" maxlength="15" value="<? echo $_SESSION['randomString'];?>" /></td>
               </tr>
			   <!--
               <tr>
                 <td   align="right" valign="top" bgcolor="#F9F7F8" ><?=ATTACHEMENT?></td>
                 <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8" >
                   <input name="Attachment" type="file" class="textbox" id="Attachment" size="10"  onkeypress="javascript: return alertUpload();" />
                 </td>
               </tr>
			   -->
			     <tr>
                 <td   align="right" valign="top" bgcolor="#F9F7F8" ></td>
                 <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8" >
                   <input type="checkbox" name="SentItem" id="SentItem" value="1" /> <?=SAVE_IN_SENT?>
                </td>
               </tr>
    </table></td>
    </tr>

</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"></td>
    <td width="536" height="5" bgcolor="#C7C5C5"></td>
    <td width="10"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="726" height="10"></td>
  </tr>
  
</table>
	
	
	</td>
  </tr>
</table>
</Div>
<table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td bgcolor="#ffffff" valign="top" align="center" ><Div id="MsgDiv_Contact" class="redtxt" align="center"></Div></td>
  </tr>
</table>
<Div id="MainTableDiv">
<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="150" height="24" bgcolor="#999797" class="whit-txt" nowrap="nowrap">
		<?=strtoupper(YOUR_INFORMATION)?> ( <a href="account-company.php"><?=EDIT?></a> ) </td>
        <td width="677">&nbsp;</td>
      </tr>
    </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td  valign="top" height="110"  align="center">
			
			
			<table width="100%" border="0" align="right" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" class="simpletxt" >
              
               <tr>
                <td width="17%"   align="right" valign="top" bgcolor="#F9F7F8" ><?=YOUR_NAME?>
                    <span class="red12"> *</span></td>
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8" ><input name="Name" type="text" class="txt-feild" id="Name"  maxlength="50" size="24" value="<?=stripslashes($arryMemberSession[0]['Name'])?>" /></td>
              </tr>
              <tr>
                <td  align="right" valign="top" bgcolor="#F9F7F8" ><?=COMPANY_NAME?>
                    <span class="red12">*</span></td>
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8"><input name="CompanyName" type="text" class="txt-feild" id="CompanyName"   maxlength="70" size="24" value="<?=stripslashes($arryMemberSession[0]['CompanyName'])?>"/></td>
              </tr>
              <tr>
                <td  align="right" valign="top" bgcolor="#F9F7F8" ><?=ADDRESS?></td>
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8"><textarea name="Address" class="txt-feild" id="Address"  style="width:140px; height:40px;"><?=stripslashes($arryMemberSession[0]['Address'])?></textarea>
                    <span class="redtxt"><?=BETWEEN_10_300?></span></td>
              </tr>
              <tr>
                <td  align="right" valign="top" bgcolor="#F9F7F8" ><?=EMAIL?>
                    <span class="red12">*</span></td>
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8"><input name="ContactEmail" type="text" class="txt-feild" id="ContactEmail"  maxlength="60" size="24" value="<?=stripslashes($_SESSION['Email'])?>" readonly/></td>
              </tr>
              <tr>
                <td  align="right" valign="top" bgcolor="#F9F7F8" ><?=COUNTRY?></td>
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8"><select name="Country" class="txt-feild" id="Country" style="width: 140px;" >
                    <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                    <option value="<?=$arryCountry[$i]['name']?>" <?  if($arryCountry[$i]['country_id']==$arryMemberSession[0]['country_id']){echo "selected";}?>>
                    <?=$arryCountry[$i]['name']?>
                    </option>
                    <? } ?>
                  </select>                </td>
              </tr>
              <tr>
                <td  align="right" valign="top" bgcolor="#F9F7F8" ><?=POSTAL_CODE?>
                    <span class="red12">*</span></td>
                <td colspan="2" align="left" valign="top" bgcolor="#F9F7F8"><input name="PostCode" type="text" class="txt-feild" id="PostCode"   maxlength="20" size="24" value="<?=stripslashes($arryMemberSession[0]['PostCode'])?>"/></td>
              </tr>
            </table></td>
                </tr>
            </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="10"></td>
            <td width="536" height="5" bgcolor="#C7C5C5"></td>
            <td width="10"></td>
          </tr>
        </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
          <tr>
            <td width="81" height="20">&nbsp;</td>
            <td width="668" align="right">
			<input type="hidden" name="SendEmail" id="SendEmail" value="1" />
			<input type="hidden" name="SenderID" id="SenderID" value="<?=$_SESSION['MemberID']?>" />
			
			<input type="hidden" name="Source" id="Source" value="<?=$Source?>" />
			<input type="hidden" name="Type" id="Type" value="<?=$Type?>" />
			<input type="hidden" name="InquiryQuotation" id="InquiryQuotation" value="<?=$InquiryQuotation?>" />
			
			
			
			
			
			<input  class="button" type="submit" name="Submit22" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>"/>
              <input  class="button" type="reset" name="Submit2" value="<?=RESET?>" alt="<?=RESET?>" title="<?=RESET?>"/></td>
          </tr>
          <tr>
            <td height="10" colspan="2"></td>
          </tr>
      </table></td>
  </tr>
</table>
<table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td bgcolor="#ffffff" valign="top" align="center" >&nbsp;</td>
  </tr>
</table>
</Div>
</td>
</tr>
<? }else{ ?>

 <tr>
       <td bgcolor="#F9F7F8"  height="130" valign="middle" align="center" class="border01 redtxt" ><?=NO_MEMBER_EXIST?></td>
   </tr>
<? } ?>
		  
          <tr>
            <td bgcolor="#CCCCCC" height="1"></td>
          </tr>
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr></form>
        </table></td>
		
				
  </tr>
    </table></td>
  </tr>
</table>
