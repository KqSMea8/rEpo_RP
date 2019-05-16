<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">

	<tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=SEND_BULK_EMAIL?></td>
      </tr>


    
      <tr>
        <td  align="left" valign="middle" class="heading"><?=SEND_BULK_EMAIL?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32"  ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <? if(!empty($_SESSION['Emails'])) { ?>
          <tr>
            <td align="center" valign="middle" >
			
			<table width="95%" border="0" cellpadding="8" cellspacing="0" 
			 class="graybox_forgot">
                <tr>
                  <td align="left" valign="middle"  class="redtxt"> <? echo $_SESSION['msg_mail']; unset($_SESSION['msg_mail']); ?> </td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="txt"   ><? echo $_SESSION['Emails']; unset($_SESSION['Emails']); ?> </td>
                </tr>
				
            </table>
			
			</td>
          </tr>
		   <tr>
                  <td align="center" valign="middle" height="45" class="skytxt" ><a href="SendEmail.php?opt=<?=$_GET['opt']?>"><?=SEND_BULK_EMAIL?></a> </td>
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
                  <td align="center" valign="middle" height="45" class="skytxt" ><a href="buyCredits.php?tp=email"><?=EMAIL_CREDITS_BUY?></a> </td>
                </tr>			
				
				
				
  <? } else { ?>
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF">
			
	
<Div id="ListingDiv">			
			
			<table width="100%" border="0" cellpadding="4" cellspacing="1" class="generaltxt_inner">
                <form action="#" method="post" name="form1" id="form1" onsubmit="javascript:return ValidateForm(this);">
                  <tr>
     <td colspan="2"  height="35"><?=EMAIL_CREDITS?>: <?=$arryMemberDetail[0]['MaxEmail']?>      </td>
     </tr>
  
	  <?  if(sizeof($arrayMember)>0) {	?>			 
	  <tr>
	    <td align="left" valign="top" colspan="2"  >&nbsp;</td>
	    </tr>
	  <tr>
				<td align="left" valign="top" colspan="2" height="30"  ><strong>Enter a salutation or leave blank: </strong></td>
			  </tr> 
			  
			  <tr>
                  
                    <td align="left" valign="top" colspan="2" ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner">
  <tr>
    <td valign="top"><input name="DearName" type="text" class="txtfield" id="DearName" style="width:80px;"/> eg. Dear, Hi, Hello etc</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="NameOption" value="FirstName">&nbsp;Select to use the First Name eg. Dear Alan (Salutation followed by First Name)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td><input type="radio" name="NameOption" value="Both">&nbsp;Select to use the First and Surname eg. Dear Alan Mackenzie</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td><input type="radio" name="NameOption" value="LastName">&nbsp;Select to use the Surname only eg. Dear Mr Mackenzie (If Surname record is Mr Mackenzie)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td><input type="radio" name="NameOption" value="">&nbsp;None</td>
  </tr>
</table></td>
                  </tr>  
	 <tr>
	    <td align="left" valign="top" colspan="2"  >&nbsp;</td>
	    </tr>		  			 
				 
				<? } ?> 
				 
				  <tr>
                    <td height="43" align="right"  ><strong>Member's Type</strong>&nbsp;</td>
                    <td align="left" ><select name="MemberType" id="MemberType" class="txtfield" onchange="Javascript:ChangeType();">
                        <option value="Seller" <? if($_GET['opt'] == 'Seller') echo 'selected';?>> Seller </option>
                        <option value="Buyer" <? if($_GET['opt'] == 'Buyer') echo 'selected';?>> Buyer </option>
                      </select>                    </td>
                  </tr>
                  <tr>
                    <td width="14%" align="right" valign="top" style="padding-top:8px;"   nowrap="nowrap"> <strong>Send Email To</strong> <span class="bluestar">*</span></td>
                    <td width="86%" align="left"  valign="top">
					
					<?  if(sizeof($arrayMember)>18) { $DivStyle = 'style="height:170px;overflow:auto "';} ?>
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
                              <td align="left"  valign="top" class="greentxt"><input type="checkbox" name="Email[]" id="Email<?=$Line?>" value="<?=$arrayMember[$i]['MemberID'];?>" />
                                  <?=stripslashes($arrayMember[$i]['UserName'])?>                              </td>
                              <?
						  $flag++;
						  } 
						  ?>
                            </tr>
                            <? }  else { ?>
                            <tr align="center">
                              <td  class="redtxt">  No <?=$_GET['opt']?>s have subscribed.  </td>
                            </tr>
                            <? } ?>
                          </table>
                          <input type="hidden" name="NumMembers" id="NumMembers" value="<? echo sizeof($arrayMember);?>" />
                        </div>
                      <?  if(sizeof($arrayMember)>1) {	?>
                        <table width="100%"  border="0">
                          <tr>
                            <td align="right" class="skytxt"><a href="javascript:SelectAllEmails();" ><?=SELECT_ALL?></a> <span > | </span> <a href="javascript:SelectNoneEmails();"><?=SELECT_NONE?></a>&nbsp;</td>
                          </tr>
                        </table>
                      <? } ?>                    </td>
                  </tr>
	  <?  if(sizeof($arrayMember)>0) {	 ?>
                 
    	            
				 
				 
				  <tr>
                    <td width="14%"  align="right" valign="top"  ><strong>Enter Email</strong> &nbsp;</td>
                    <td width="86%" align="left" ><textarea name="ccTo" type="text" class="txtfield" id="ccTo" style="width:100%; height:100px;"/></textarea><br />Separate the entries with commas or <a href="Javascript: OpenNewPopUp('uploadExcel.php','500','600','Yes')">Import an Excel (.xls) file</a></td>
                  </tr>
				  
				   <tr>
                    <td  align="right" valign="top"  >&nbsp;</td>
                    <td align="left" valign="top" ></td>
                  </tr>
				  
				 
			    
				  
                  <tr>
                    <td width="14%" height="36" align="right" valign="middle" nowrap="nowrap"  > <strong>Subject</strong> <span class="bluestar">*</span></td>
                    <td width="86%" align="left" ><input name="Subject" type="text" class="txtfield" id="Subject" style="width:400px;"/></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top"  ><strong>Message</strong> <span class="bluestar">*</span></td>
                    <td align="left" ><textarea name="Message" id="Message" cols="35" rows="4" ></textarea>
                        <script type="text/javascript">

var editorName = 'Message';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 300, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
          </script>                    </td>
                  </tr>
                  <tr>
                    <td align="center" height="40" valign="middle" >&nbsp;</td>
                    <td align="left" valign="middle" ><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" />
                        <input type="hidden" name="AdminEmail" id="AdminEmail" value="<? echo $Config['AdminEmail'];?>" />
                        <input type="hidden" name="SellerMessage" id="SellerMessage" value="<? echo $SellerMessage;?>" />
						
						<input type="hidden" name="StoreID" id="StoreID" value="<? echo $_SESSION['MemberID'];?>" />
						 <input type="hidden" name="MaxEmail" id="MaxEmail" value="<?=$arryMemberDetail[0]['MaxEmail']?>" />
						 <input type="hidden" name="CompanyName" id="CompanyName" value="<? echo $_SESSION['CompanyName'];?>" />						                    </td>
                  </tr>
				  <? } ?>
                </form>
            </table>
			</div>
			<Div class="redtxt" id="LoadingDiv" style="display:none;text-align:center; ">
			<br><br><br><br><br><br><img src="images/load.gif"> Sending Email.....</Div>
			</td>
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
