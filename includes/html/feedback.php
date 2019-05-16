<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	   <tr>
        <td  align="left" valign="middle" class="heading">Feedback</td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> Feedback</td>
      </tr>
      
	  
      
	   <tr>
        <td height="25">&nbsp;</td>
      </tr>
	  <tr>
        <td ><Div id="MsgDiv_Contact" class="redtxt" style="text-align:center;" ></Div></td>
      </tr>
	   <tr>
        <td height="35">&nbsp;</td>
      </tr>  
	  
 <tr>
        <td  id="ContactFormTD">
		
	
		<table width="90%" border="0" align="left" cellpadding="5" cellspacing="0" >
         <form name="ContactForm" action=""  method="post" onSubmit="return validateFeedback(this);">
		 
          <tr>
            <td width="18%" height="30" align="left" valign="middle" >Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="Name" id="Name" maxlength="30" type="text"  class="txtfield_normal" />
           </td>
          </tr>
         
          <tr style="display:none">
            <td height="30" align="left" valign="middle" >Contact Number <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
			
              <input name="ContactNumber" id="ContactNumber" maxlength="30" type="text"  class="txtfield_normal" />           </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Email Address <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="ContactEmail" id="ContactEmail" maxlength="70" type="text"  class="txtfield_normal" />            </td>
          </tr>
           <tr style="display:none">
            <td height="30" align="left" valign="middle" >City <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="City" id="City" maxlength="30" type="text"  class="txtfield_normal" />
            </span></td>
          </tr>
           <tr style="display:none">
            <td height="30" align="left" valign="middle" >Country <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <select name="Country" class="txtfield_normal" id="Country">
              <option value="">---- Select Country---- </option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['name']?>">
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>			  
			  
           </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top" >Feedback <span class="bluestar">*</span></td>
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