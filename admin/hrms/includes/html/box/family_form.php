

<div id="family_form_div" style="display:none; width:350px;min-height:230px;">
<div class="had2">Family Detail</div>
<div id="record_pop" align="center">

<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_family(this);" enctype="multipart/form-data">
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
						Age :
					  </td>
                      <td  align="left" valign="top">

					<input name="Age" type="text" class="textbox" id="Age" size="10" maxlength="10" onkeypress="return isAlphaKey(event);"/>  


					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Dependent  :
					  </td>
                      <td  align="left" valign="top">
		<input type="radio" name="Dependent"  id="Dependent1" value="Yes" checked />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Dependent" id="Dependent2" value="No"  />
          No
					  </td>
                    </tr>	
							  	
                  
			
					 <tr>
						  <td align="right"   class="blackbold" valign="top"></td>
						  <td  align="left" >
							 <input name="s" type="submit" class="button" value="Submit"/>
							<input type="hidden" name="EmpID" id="EmpID" value="<?=$EmpID?>" />
							<input type="hidden" name="familyID" id="familyID" value="" />
							</td>
						</tr>
                 
                   
                  </table>
<div id="ajaxValueDiv"></div>
</form>

</div>

</div>

<script language="JavaScript1.2" type="text/javascript">

function FamilyDetail(familyID){
		$(".message").hide();
		var EmpID = document.getElementById("EmpID").value;
		document.getElementById("familyID").value = familyID;
		document.getElementById("ajaxValueDiv").innerHTML = '';
		document.getElementById("Name").value = '';
		document.getElementById("Relation").value = '';
		document.getElementById("Age").value = '';
		
		if(familyID>0){
			document.getElementById("record_pop").style.display = 'none';
			var SendUrl = "ajax.php?action=family_detail&familyID="+familyID+"&EmpID="+EmpID+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function FamilyDetailRecieve(){
				if (httpObj.readyState == 4) {
					document.getElementById("ajaxValueDiv").innerHTML = httpObj.responseText;
					document.getElementById("Name").value =  document.getElementById("ajaxName").value;
					document.getElementById("Relation").value =  document.getElementById("ajaxRelation").value;
					document.getElementById("Age").value =  document.getElementById("ajaxAge").value;
					if(document.getElementById("ajaxDependent").value=="Yes"){
						document.getElementById("Dependent1").checked =  true;
					}else{
						document.getElementById("Dependent2").checked =  true;
					}
					document.getElementById("record_pop").style.display = 'block';
				}

			};

			httpObj.send(null);
		}

}
</script>	