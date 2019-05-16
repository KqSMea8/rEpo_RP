<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	   <tr>
        <td  align="left" valign="middle" class="heading">Contact Us</td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> Contact Us</td>
      </tr>
      
	  
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="txt" id="ContentTD">
		<?
	if($arrayContents[0]['PageContent'] != ''){
	 	echo  stripslashes($arrayContents[0]['PageContent']); 
	}
	?>
	

			
        </td>
      </tr>
	   <tr>
        <td height="25">&nbsp;</td>
      </tr>
	  <tr>
        <td ><Div id="MsgDiv_Contact" class="redtxt" ></Div></td>
      </tr>
	   <tr>
        <td height="35">&nbsp;</td>
      </tr>  
	  
 <tr>
        <td  id="ContactFormTD">
		
	
		<table width="90%" border="0" align="left" cellpadding="0" cellspacing="0">
         <form name="ContactForm" action=""  method="post" onSubmit="return validateContact(this);">
		 
          <tr>
            <td width="21%" height="30" align="left" valign="middle" >First Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="FirstName" id="FirstName" maxlength="30" type="text"  class="txtfield_normal" />
            </span></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Last Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="LastName" id="LastName" maxlength="30" type="text"  class="txtfield_normal" />
            </span></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Contact Number <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
			
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
  </select>		-->
			
              <input name="ContactNumber" id="ContactNumber" maxlength="30" type="text"  class="txtfield_normal" />           </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Email Address <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="ContactEmail" id="ContactEmail" maxlength="70" type="text"  class="txtfield_normal" />            </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >City <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="City" id="City" maxlength="30" type="text"  class="txtfield_normal" />
            </span></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Country <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <select name="Country" class="txtfield_normal" id="Country"  >
              <option value="">---- Select Country---- </option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['name']?>">
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>			  
			  
            </span></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top" >Your Comments</td>
            <td height="30" align="left" valign="middle" ><textarea name="comments"  id="comments"  rows="5"  class="txtfield" style="width:300px;resize: none;"></textarea></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >&nbsp;</td>
            <td height="50" align="left" valign="middle" ><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right"><input name="SubmitButton" id="SubmitButton" type="submit" value="Submit" class="button" /></td>
                <td>&nbsp;</td>
                <td align="right"><input type="reset" name="Reset"  value="Reset" class="button" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="35" colspan="2" valign="bottom">&nbsp;</td>
          </tr>
        
		  </form>
        </table></td>
      </tr>	  
	  
    </table>