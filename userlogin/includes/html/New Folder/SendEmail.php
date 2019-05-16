<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">


function ValidateForm(frm)
{
	var i=0;
	var flag=0;
	var ids = '';

	
	if(frm.NumMembers.value > 0){


		if(frm.NumMembers.value > 1){
				for(i=1; i<=frm.NumMembers.value; i++)
				{
					if(document.getElementById("Email"+i).checked==true)
					{
					
						flag=1;
						break;
					}
					else 
					{
						flag=0;
					}
				}
		}else{
		
		if(document.getElementById("Email1").checked==true) flag=1;
			else flag=0;
				
		}
		
		
		if(flag==0){
			alert('Please Check atleast one member.'); 
			return false;
		}else{

			if(  isValidCC(frm.ccTo)
				&& ValidateForBlank(frm.Subject, "Subject")
			){
			
				if (typeof ew_UpdateTextArea == 'function'){
					ew_UpdateTextArea();
				}
				
				if (!ew_ValidateForm(frm,"Message","Message")){
					return false;
				}
			
			
			if(frm.NumMembers.value > 1){
				for(i=1; i<=frm.NumMembers.value; i++)
				{
					if(document.getElementById("Email"+i).checked==true)
					{
						ids +=  document.getElementById("Email"+i).value +',' ;
					}
				}
			}else{
				ids +=  document.getElementById("Email1").value;
			}


				document.getElementById("LoadingDiv").style.display = 'inline';
				document.getElementById("ListingDiv").style.display = 'none';
				
				document.form1.action='SendEmail.php?ids='+ids+'&opt='+document.getElementById("MemberType").value;
				document.form1.submit();

			}else{
				return false;	
			}
		}
	}else{
		alert("Sorry, You can't send Email as there is no member found in the database.");
		return false;	
	}

}

function SelectAllEmails()
{	
	for(i=1; i<=document.form1.NumMembers.value; i++){
		document.getElementById("Email"+i).checked=true;
	}

}

function SelectNoneEmails()
{
	for(i=1; i<=document.form1.NumMembers.value; i++){
		document.getElementById("Email"+i).checked=false;
	}
}


</script>
<div class="had">Send Email To <?=$_GET['opt']?>s</div>
<br>
<Div class="message" id="LoadingDiv" style="display:none;text-align:center;padding-top:120px; padding-bottom:120px;"><img src="../images/load.gif"> Sending Email.....</Div>	
<Div id="ListingDiv">
 <TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 class="borderall">
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
	   
		
		 <tr>
          <td  align="center" valign="top">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
			<? if(!empty($_SESSION['Emails'])) { ?>
				<tr><td align="center" valign="middle" >
					<table width="85%" border="0" cellpadding="8" cellspacing="0" >
						<tr><td align="left" valign="middle"  class="message">
						<div class="message" style="text-align:left;padding-top:30px;" align="left">
	<? echo $_SESSION['msg_mail']; unset($_SESSION['msg_mail']); ?>					
						</div>
						
						</td></tr>
						<tr><td align="left" valign="middle"  class="blackbold" >
						<? echo $_SESSION['Emails']; unset($_SESSION['Emails']); ?>
						</td></tr>
						
				
				</table>
				</td></tr>
			<? } else { ?>
                <tr>
                  <td align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="1" >
                       <form name="form1" method="post" action="#" onSubmit="javascript:return ValidateForm(this);">
                        
						
	 <?  if(sizeof($arrayMember)>0) {	?>			 
	 
	 <tr>
	    <td align="left" valign="top"  >&nbsp;</td>
		  <td align="left" valign="top"  >&nbsp;</td>
	    </tr>		  			 
				 
				<? } ?> 					
						
						
						
						
						<tr>
                          <td width="20%" align="right" valign="top"  class="blackbold"  style="padding-top:8px;"  >
						   Send Email To <span class="red">*</span>&nbsp;</td>
                          <td  align="left"  valign="top">
<?  if(sizeof($arrayMember)>18) { $DivStyle = 'style="height:170px;overflow:auto "';} ?>	

	<Div <?=$DivStyle?>>	  
<table width="97%"  border="0">
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
                       
                          <td align="left"  valign="top" >
						  
	 <input type="checkbox" name="Email[]" id="Email<?=$Line?>" value="<?=$arrayMember[$i]['MemberID'];?>">&nbsp;<a href="mailto:<?=$arrayMember[$i]['Email'];?>" class="normaltext-link"><?=stripslashes($arrayMember[$i]['UserName']);?></a>							</td>
						 <?
						  $flag++;
						  } 
						  ?>
                        </tr>
						
                        <? }  else { ?>
                        <tr align="center">
                          <td  class="message">No <?=$_GET['opt']?>s have subscribed.</td>
                        </tr>
                        <? } ?>
</table>
<input type="hidden" name="NumMembers" id="NumMembers" value="<? echo sizeof($arrayMember);?>">
</Div>	
<?  if(sizeof($arrayMember)>1) {	?>
 <table width="100%"  border="0">
  <tr>
    <td align="right"><a href="javascript:SelectAllEmails();" class="normaltext-link">Select All</a> <span class="blackbold"> | </span> <a href="javascript:SelectNoneEmails();" class="normaltext-link"> Select None</a>&nbsp;</td>
  </tr>
</table>	
<? } ?>						  </td>
                        </tr>
						
						<tr>
						  <td  align="right" valign="top"   class="blackbold">&nbsp;</td>
						  <td align="left" >&nbsp;</td>
					     </tr>
						<tr>
                          <td width="14%" height="40" align="right" valign="top"   class="blackbold"> Enter Email &nbsp;</td>
                          <td width="86%" align="left" ><textarea name="ccTo" type="text" class="inputbox" id="ccTo" style="width:99%; height:100px;"/></textarea><br>
                          <span class="blackbold" > Separate the entries with commas or <a href="Javascript: OpenNewPopUp('../getEmails.php','500','600','Yes')"><strong>Import other email addresses</strong></a>.</td>
                        </tr>
						
						<tr>
						  <td  valign="middle"   class="blackbold">&nbsp;</td>
						  <td align="left" >&nbsp;</td>
					     </tr>
						<tr>
                          <td width="14%" height="36" align="right" valign="middle"   class="blackbold"> Subject <span class="red">*</span>&nbsp;</td>
                          <td width="86%" align="left" ><input name="Subject" type="text" class="inputbox" id="Subject" value="" size="70"/></td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"  class="blackbold">&nbsp;</td>
                          <td align="left" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"  class="blackbold">Message/Newsletter <span class="red">*</span>&nbsp;</td>
                          <td align="left" >


<textarea name="Message" id="Message" cols="35" rows="4"></textarea>
<script type="text/javascript">

var editorName = 'Message';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 480, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>						  </td>
                        </tr>
                        <tr>
                          <td align="center" height="40" valign="middle" >&nbsp;</td>
                          <td align="left" valign="middle" >
                            <input name="Submit" type="submit" class="Button" value="Send">
							
                          <input type="hidden" name="MemberType" id="MemberType" value="<? echo $_GET['opt'];?>" />
                          <input type="hidden" name="AdminEmail" id="AdminEmail" value="<? echo $Config['AdminEmail'];?>" />						  </td>
                        </tr>
                      </form>
                  </table></td>
                </tr>
				
				<? } ?>
				
				
            </table>		  
		  
		  </td>
        </tr>
      </table></TD>
  </TR>

</TABLE>
</div>