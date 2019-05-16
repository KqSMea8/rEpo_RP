

<div id="emergency_form_div" style="display:none; width:350px;min-height:230px;">
<div class="had2">Emergency Detail</div>
<div id="record_pop" align="center">

<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_emergency(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>
                      <td width="45%" align="right"  class="blackbold">
					Relative Name :<span class="red">*</span>
					  </td>
                      <td align="left">
						<input name="Name" type="text" class="inputbox" id="Name" maxlength="30" onkeypress="return isCharKey(event);"/>
					  </td>
                    </tr>
					
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Relation  :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						<input name="Relation" type="text" class="inputbox" id="Relation" maxlength="30" onkeypress="return isCharKey(event);"/>  
					  </td>
                    </tr>	
					
					
				
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Address :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">

					<textarea name="Address" class="textarea" id="Address"  maxlength="200" onkeypress="return isAlphaKey(event);"></textarea>  


					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Mobile  :
					  </td>
                      <td  align="left" valign="top">
					<input name="Mobile" type="text" class="inputbox" id="Mobile" maxlength="20" onkeypress="return isNumberKey(event);" />  
	
					  </td>
                    </tr>	
							  	
                 <tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Home Phone  :
					  </td>
                      <td  align="left" valign="top">
					<input name="HomePhone" type="text" class="inputbox" id="HomePhone" maxlength="20" onkeypress="return isNumberKey(event);" />  
	
					  </td>
                    </tr>	
					

					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Work Phone  :
					  </td>
                      <td  align="left" valign="top">
					<input name="WorkPhone" type="text" class="inputbox" id="WorkPhone" maxlength="20" onkeypress="return isNumberKey(event);" />  
	
					  </td>
                    </tr>	
			
					 <tr>
						  <td align="right"   class="blackbold" valign="top"></td>
						  <td  align="left" >
							 <input name="s" type="submit" class="button" value="Submit"/>
							<input type="hidden" name="EmpID" id="EmpID" value="<?=$EmpID?>" />
							<input type="hidden" name="contactID" id="contactID" value="" />
							</td>
						</tr>
                 
                   
                  </table>
<div id="ajaxValueDiv"></div>
</form>

</div>

</div>

<script language="JavaScript1.2" type="text/javascript">

function EmergencyDetail(contactID){
		$(".message").hide();
		var EmpID = document.getElementById("EmpID").value;

		document.getElementById("contactID").value = contactID;
		document.getElementById("ajaxValueDiv").innerHTML = '';
		document.getElementById("Name").value = '';
		document.getElementById("Relation").value = '';
		document.getElementById("Address").value = '';
		
		if(contactID>0){
			document.getElementById("record_pop").style.display = 'none';
			var SendUrl = "ajax.php?action=emergency_contact&contactID="+contactID+"&EmpID="+EmpID+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function EmergencyDetailRecieve(){
				if (httpObj.readyState == 4) {
					document.getElementById("ajaxValueDiv").innerHTML = httpObj.responseText;
					document.getElementById("Name").value =  document.getElementById("ajaxName").value;
					document.getElementById("Relation").value =  document.getElementById("ajaxRelation").value;
					document.getElementById("Address").value =  document.getElementById("ajaxAddress").value;
					document.getElementById("Mobile").value =  document.getElementById("ajaxMobile").value;					
					document.getElementById("HomePhone").value =  document.getElementById("ajaxHomePhone").value;
					document.getElementById("WorkPhone").value =  document.getElementById("ajaxWorkPhone").value;

					document.getElementById("record_pop").style.display = 'block';
				}

			};

			httpObj.send(null);
		}

}
</script>	
