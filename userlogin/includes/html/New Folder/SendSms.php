
<script language="JavaScript1.2" type="text/javascript">

function ChangeType()
{
	location.href = 'SendSms.php?opt='+document.getElementById("MemberType").value ;
}

function ValidateForm(frm)
{
	var i=0;
	var flag=0;
	var ids = '';

	
	if(frm.NumMembers.value > 0){


		if(frm.NumMembers.value > 1){
				for(i=1; i<=frm.NumMembers.value; i++)
				{
					if(document.getElementById("Numbers"+i).checked==true)
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
		
		if(document.getElementById("Numbers1").checked==true) flag=1;
			else flag=0;
				
		}
		
		
		if(flag==0){
			alert('Please Check atleast one Number.'); 
			return false;
		}else{

			if(  isValidPhoneNumber(frm.ccTo,"Numbers")
				&& ValidateForTextareaMand(frm.Message, "Message",2,200)
			){
			
			
			
			if(frm.NumMembers.value > 1){
				for(i=1; i<=frm.NumMembers.value; i++)
				{
					if(document.getElementById("Numbers"+i).checked==true)
					{
						ids +=  document.getElementById("Numbers"+i).value +',' ;
					}
				}
			}else{
				ids +=  document.getElementById("Numbers1").value;
			}

				document.form1.action='SendSms.php?ids='+ids+'&opt='+document.getElementById("MemberType").value;
				document.form1.submit();

			}else{
				return false;	
			}
		}
	}else{
		alert("Sorry, You can't send SMS as there is no member found in the database.");
		return false;	
	}

}

function SelectAllEmails()
{	
	for(i=1; i<=document.form1.NumMembers.value; i++){
		document.getElementById("Numbers"+i).checked=true;
	}

}

function SelectNoneEmails()
{
	for(i=1; i<=document.form1.NumMembers.value; i++){
		document.getElementById("Numbers"+i).checked=false;
	}
}


</script>

<script language = "Javascript">

maxL=100;
var bName = navigator.appName;
function taLimit(taObj) {
	if (taObj.value.length==maxL) return false;
	return true;
}

function taCount(taObj,Cnt) { 
	objCnt=createObject(Cnt);
	objVal=taObj.value;
	if (objVal.length>maxL){
		objVal=objVal.substring(0,maxL);
		taObj.value = objVal;
	}

	if (objCnt) {
		if(bName == "Netscape"){	
			objCnt.textContent=maxL-objVal.length;
		}
		else{
			objCnt.innerText=maxL-objVal.length;
		}
		
	}

	return true;
}
function createObject(objId) {
	if (document.getElementById) return document.getElementById(objId);
	else if (document.layers) return eval("document." + objId);
	else if (document.all) return eval("document.all." + objId);
	else return eval("document." + objId);
}
</script>
<div class="had">Send Bulk SMS</div>
<br>

 <TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 class="borderall">
	<TR>
	  <TD  align="center" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
	   
		
		 <tr>
          <td  align="center" valign="top">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
			<? if(!empty($_SESSION['Numbers'])) { ?>
				<tr><td align="center" valign="middle" >
					<table width="85%" border="0" cellpadding="8" cellspacing="0" >
						<tr><td align="left" valign="middle"  class="message">
						<div class="message" style="text-align:left;padding-top:30px;" align="left">
	<? echo $_SESSION['msg_number']; unset($_SESSION['msg_number']); ?>					
						</div>
						
						</td></tr>
						<tr><td align="left" valign="middle"  class="blackbold" >
						<? echo $_SESSION['Numbers']; unset($_SESSION['Numbers']); ?>
						</td></tr>
						
				
				</table>
				</td></tr>
			<? } else { ?>
                <tr>
                  <td align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="1" >
                       <form name="form1" method="post" action="#" onSubmit="javascript:return ValidateForm(this);">
                        <tr>
                          <td height="43" align="right"   class="blackbold">Member's Type&nbsp; </td>
                          <td align="left"  ><span class="blacknormal">
                            <select name="MemberType" id="MemberType" class="inputbox" onchange="Javascript:ChangeType();">
                              <option value="Seller" <? if($_GET['opt'] == 'Seller') echo 'selected';?>> Seller </option>
                              <option value="Buyer" <? if($_GET['opt'] == 'Buyer') echo 'selected';?>> Buyer </option>
                            </select>
                          </span></td>
                        </tr>
                        <tr>
                          <td width="14%" align="right" valign="top"  class="blackbold"  style="padding-top:8px;">
						   Send SMS To <span class="red">*</span>&nbsp;</td>
                          <td width="86%" align="left"  valign="top">
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
						  
	 <input type="checkbox" name="Numbers[]" id="Numbers<?=$Line?>" value="<?=$arrayMember[$i]['MemberID'];?>">&nbsp;<a href="mailto:<?=$arrayMember[$i]['Email'];?>" class="normaltext-link"><?=stripslashes($arrayMember[$i]['UserName']);?></a>	(<?=$arrayMember[$i]['isd_code']?><?=$arrayMember[$i]['Phone']?>)						</td>
						 <?
						  $flag++;
						  } 
						  ?>
                        </tr>
						
                        <? }  else { ?>
                        <tr align="center">
                          <td  class="message">No <?=$_GET['opt']?>s have subscribed. </td>
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
                          <td width="14%" height="40" align="right" valign="top"   class="blackbold"> Enter Number&nbsp;</td>
                          <td width="86%" align="left"  valign="top" >
						  <textarea name="ccTo" type="text" class="inputbox" id="ccTo" style="width:98%; height:100px;"/></textarea>
						<div class="blacknromal" > (Please separate the entries with commas, include the international dialing code & do not use spaces.<br> For instance: 27811234567,27819876543)  or <a href="Javascript: OpenNewPopUp('../uploadSms.php','500','600','Yes')">Import an Excel (.xls) file </div></td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"  class="blackbold">&nbsp;</td>
                          <td align="left" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"  class="blackbold">Message <span class="red">*</span>&nbsp;</td>
                          <td align="left" >


<textarea name="Message" id="Message" class="inputbox" cols="37" rows="4" onKeyDown="return taCount(this,'NumLimitSpan')" onKeyUp="return taCount(this,'NumLimitSpan')"></textarea><br><u><Span id="NumLimitSpan" class="blackbold">100</Span></u> Characters remaining. 						  </td>
                        </tr>
                        <tr>
                          <td align="center" height="40" valign="middle" >&nbsp;</td>
                          <td align="left" valign="middle" >
                            <input name="Submit" type="submit" class="Button" value="Send">                          </td>
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