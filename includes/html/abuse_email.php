
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=COMPLAIN_EMAIL?></td>
      </tr>
       <tr>
        <td  align="left" valign="middle" class="heading"><?=COMPLAIN_EMAIL?></td>
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
           <td height="30" align="left" valign="middle" class="generaltxt_inner" colspan="2">
		   Please enter your name, email address, select a complaint reason and post your comments.

		   </td>
      
         </tr>
		   <tr>
		      <td height="30" colspan="2" ></td>
		      </tr>
		  <tr>
            <td height="30" align="left" valign="middle" class="generaltxt_inner">Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle">
              <input name="Name" id="Name" maxlength="30" type="text" value=""  class="txtfield_contact" size="50"/>            </td>
          </tr>
		  <tr>
		      <td height="10" colspan="2" ></td>
		      </tr>
         <tr>
            <td width="22%" height="30" align="left" valign="middle" class="generaltxt_inner">Email Address <span class="bluestar">*</span></td>
            <td  height="30" align="left" valign="middle" >
              <input name="Email" id="Email" maxlength="70" type="text" value="<?=$MemberEmail?>" class="txtfield_contact" size="50"/>            </td>
          </tr>
		    <tr>
		      <td height="10" colspan="2" ></td>
		      </tr>
		    <tr>
            <td height="30" align="left" valign="middle" class="generaltxt_inner">Complaint Reason <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
			
			<select id="ComplaintReason" class="txtfield_contact" name="ComplaintReason" style="width:280px;">
				<option value=""> --- select one ---</option> 
				<option value="I did not sign up for this list">I did not sign up for this list</option> 
				<option value="I am receiving too many emails">I am receiving too many emails</option>
				 <option value="The content or language was offensive">The content or language was offensive</option>
				 
			  </select>
			  
                         </td>
          </tr>
		   <tr>
		      <td height="10" colspan="2" ></td>
		      </tr>
		  
          <tr>
            <td height="30" align="left" valign="top" class="generaltxt_inner">Comments  <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="top" class="generaltxt_inner"><textarea name="Comments"  id="Comments"  rows="10"  class="txtfield_contact" style="width:280;resize: none;"></textarea>
			<br>[Not more than 500 characters]<br><br>			</td>
          </tr>
       
		  <tr>
            <td >&nbsp;</td>
            <td height="30" align="left" >
              <input name="image" type="image" value=" " src="images/submit_contact.jpg" width="72" height="24"  /></td>
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
