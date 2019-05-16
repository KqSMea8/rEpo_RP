
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=REPORT_OFFENSIVE_CONTENT?></td>
      </tr>
       <tr>
        <td  align="left" valign="middle" class="heading"><?=REPORT_OFFENSIVE_CONTENT?></td>
      </tr>
	  
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td  class="generaltxt_inner" id="ContentTD">
		<?
		/*
	if($arrayContents[0]['PageContent'] != ''){
	 	echo  stripslashes($arrayContents[0]['PageContent']); 
	}*/
	?>
	

			
        </td>
      </tr>
	  <tr>
        <td ><Div id="MsgDiv_Content" class="blacktxt" align="center"></Div></td>
      </tr>  
	  
 <tr>
        <td class="generaltxt_inner" id="ReportFormTD">
		
	
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
         <form name="ContactForm" action=""  method="post" onSubmit="return validateReport(this);">
		 
          <tr>
            <td width="28%" height="30" align="left" valign="middle" class="generaltxt_inner">Name <span class="bluestar">*</span></td>
            <td width="72%" height="30" align="left" valign="middle">
              <input name="Name" id="Name" maxlength="30" type="text" value="<?=$_SESSION['Name']?>"  class="txtfield_contact" size="50"/>            </td>
          </tr>
         <tr>
            <td height="30" align="left" valign="middle" class="generaltxt_inner">Email Address <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="ContactEmail" id="ContactEmail" maxlength="70" type="text" value="<?=$_SESSION['Email']?>" class="txtfield_contact" size="50"/>            </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" class="generaltxt_inner">Contact Number <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <? 
	if($arryMember[0]['isd_code'] != ''){
		$IsdSelected = $arryMember[0]['isd_code']; 
	}else{
		$IsdSelected = 27;
	}
	?>
   <select name="isd_code" class="txtfield" id="isd_code" style="width: 72px;"  >
   			<option value="">ISD Code</option>
                        <? for($i=0;$i<sizeof($arryIsd);$i++) {
						  if($arryIsd[$i]['isd_code']>0){
						?>
                        <option value="<?=$arryIsd[$i]['isd_code']?>" <?  if($arryIsd[$i]['isd_code']==$IsdSelected){echo "selected";}?>>
                        <?=$arryIsd[$i]['isd_code']?>
                        </option>
				
                        <? }} ?>
  </select>	 <input name="ContactNumber" id="ContactNumber" maxlength="30" type="text"  class="txtfield_contact" size="37"/>            </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" class="generaltxt_inner">Store / Website <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="Website" id="Website" maxlength="150" type="text"  class="txtfield_contact" size="50" value="<?=$Website?>"/>            </td>
          </tr>
          
          <tr>
            <td  align="left" valign="top">&nbsp;</td>
            <td height="50" align="left" valign="top" class="generaltxt_inner"><?=COPY_URL_OFFENSIVE?></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top" class="generaltxt_inner">Offensive Content  <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="top" class="generaltxt_inner"><textarea name="Content"  id="Content"  rows="10"  class="txtfield_contact" style="width:280;resize: none;"></textarea>
			<br>[Not more than 500 characters]<br><br>			</td>
          </tr>
       
		   <tr>
            <td height="30" align="left" valign="middle" class="generaltxt_inner">Why is the content
offensive? <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="WhyOffensive" id="WhyOffensive" maxlength="150" type="text"  class="txtfield_contact" size="50"/>            </td>
          </tr>
		  
		  
          <tr>
            <td height="35" colspan="2"  valign="bottom">
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" width="49%"><input type="image" src="images/submit_contact.jpg" width="72" height="24" value=" "  /></td>
	<td width="2%">&nbsp;</td>
    <td  align="left"><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"  /></td>
  </tr>
</table>			</td>
          </tr>
          <tr>
            <td height="55" colspan="2" align="left" valign="middle" class="generaltxt_inner"><span class="bluestar">*</span> Required.</td>
          </tr>
		  </form>
        </table></td>
      </tr>	  
	  
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
