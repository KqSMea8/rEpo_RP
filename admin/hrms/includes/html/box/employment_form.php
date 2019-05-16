

<div id="empl_form_div" style="display:none; width:400px;min-height:230px;">
<div class="had2">Employment Detail</div>
<div id="record_pop" align="center">

<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_employment(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>
                      <td width="30%" align="right"  class="blackbold">
					Employer Name :<span class="red">*</span>
					  </td>
                      <td align="left">
						<input name="EmployerName" type="text" class="inputbox" id="EmployerName" maxlength="50" onkeypress="return isAlphaKey(event);"/>
					  </td>
                    </tr>
					
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Designation  :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						<input name="Designation" type="text" class="inputbox" id="Designation" maxlength="30" onkeypress="return isAlphaKey(event);"/>  
					  </td>
                    </tr>	
					
					
				
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Duration :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">

<script>
$(function() {
$( "#FromDate" ).datepicker({ 
		showOn: "both",
	yearRange: '1950:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});
}
);

$(function() {
$( "#ToDate" ).datepicker({ 
		showOn: "both",
	yearRange: '1950:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});
}
);
</script>
<input id="FromDate" name="FromDate" readonly="" class="datebox" value=""  type="text" > &nbsp;&nbsp;To&nbsp;
<input id="ToDate" name="ToDate" readonly="" class="datebox" value=""  type="text" >


					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Job Profile  :
					  </td>
                      <td  align="left" valign="top">
						<textarea name="JobProfile" type="text" class="textarea" id="JobProfile" maxlength="200" onkeypress="return isAlphaKey(event);"></textarea>	
					  </td>
                    </tr>	
							  	
                  
			
					 <tr>
						  <td align="right"   class="blackbold" valign="top"></td>
						  <td  align="left" >
							 <input name="s" type="submit" class="button" value="Submit"/>
							<input type="hidden" name="EmpID" id="EmpID" value="<?=$EmpID?>" />
							<input type="hidden" name="employmentID" id="employmentID" value="" />
							</td>
						</tr>
                 
                   
                  </table>
<div id="ajaxValueDiv"></div>
</form>

</div>

</div>

<script language="JavaScript1.2" type="text/javascript">

function EmplDetail(employmentID){
		$(".message").hide();
		var EmpID = document.getElementById("EmpID").value;
		document.getElementById("employmentID").value = employmentID;
		document.getElementById("ajaxValueDiv").innerHTML = '';
		document.getElementById("EmployerName").value = '';
		document.getElementById("Designation").value = '';
		document.getElementById("FromDate").value = '';
		document.getElementById("ToDate").value = '';
		document.getElementById("JobProfile").value = '';
		
		if(employmentID>0){
			document.getElementById("record_pop").style.display = 'none';
			var SendUrl = "ajax.php?action=employment_detail&employmentID="+employmentID+"&EmpID="+EmpID+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function EmplDetailRecieve(){
				if (httpObj.readyState == 4) {
					document.getElementById("ajaxValueDiv").innerHTML = httpObj.responseText;
					document.getElementById("EmployerName").value =  document.getElementById("ajaxEmployerName").value;
					document.getElementById("Designation").value =  document.getElementById("ajaxDesignation").value;
					document.getElementById("FromDate").value =  document.getElementById("ajaxFromDate").value;
					document.getElementById("ToDate").value =  document.getElementById("ajaxToDate").value;
					document.getElementById("JobProfile").value =  document.getElementById("ajaxJobProfile").value;
					document.getElementById("record_pop").style.display = 'block';
				}

			};

			httpObj.send(null);
		}

}
</script>	