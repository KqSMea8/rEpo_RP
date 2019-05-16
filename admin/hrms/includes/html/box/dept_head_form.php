<div id="dept_head_form" style="display:none;width:350px; height:200px">
<div class="had">Departmental Head</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formHead" action="" method="post"  enctype="multipart/form-data" onSubmit="return validateThis(this);">
		<tr>
		  <td align="center" height="20" >
		   <div id="msg_pop" class="redmsg"></div>
		  </td>
		  </tr>
		<tr>
		  <td valign="top" align="center" >

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
	<td valign="top" align="right" width="40%" >Department : </td> <td valign="top" align="left" id="DepartmentTd"></td>
</tr>
<tr>
	<td valign="top" align="right" >Employee : </td> 
	<td valign="top" align="left" > <div id="record_pop"></div>&nbsp;</td>
</tr>
<tr>
	<td valign="top" align="right" > </td> 
	<td valign="top" align="left" > 
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Save " style="display:none" />
	<input type="hidden" name="depID" id="depID" value="" >
	<input type="hidden" name="OldEmpID" id="OldEmpID" value="" >
	<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" >
</td>
</tr>
</TABLE>


		  
		  </td>
		  </tr>
		
	    </form>
</TABLE>


</div>

<script language="JavaScript1.2" type="text/javascript">

	function GetDeptHeadForm(depID,Department,EmpID){	
		document.getElementById("depID").value = depID;
		document.getElementById("OldEmpID").value = EmpID;
		document.getElementById("DepartmentTd").innerHTML = Department;
		document.getElementById("record_pop").innerHTML = '';
		document.getElementById("msg_pop").innerHTML = '<img src="images/loading.gif">';
		document.getElementById("SubmitButton").style.display = 'none';

		var SendUrl = 'ajax.php?action=emp_list&Department='+depID+'&Status='+EmpStatus+'&OldEmpID='+EmpID+'&r='+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function HeadFormRecieve(){
				if (httpObj.readyState == 4) {
					document.getElementById("record_pop").innerHTML = httpObj.responseText;
					document.getElementById("msg_pop").style.display = 'none';
					
					if(document.getElementById("EmpID") != null){
						document.getElementById("SubmitButton").style.display = 'inline';
					}
					
				}

			};

			httpObj.send(null);

	}

	function validateThis(frm){	

		if(document.getElementById("EmpID") != null){
			document.getElementById("OldEmpID").value = document.getElementById("EmpID").value;
		}

		if(document.getElementById("OldEmpID").value==""){
			alert("Please Select Employee.");
			return false;
		}else{
			document.getElementById("msg_pop").innerHTML = 'Saving......';
			document.getElementById("msg_pop").style.display = 'inline';
		}
	}
	
	
</script>