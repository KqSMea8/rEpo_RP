<div id="timesheet_div" style="display:none;">
<TABLE WIDTH=350   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formTime" action="" method="post"  enctype="multipart/form-data" onSubmit="return validateTimesheet(this);">
		<tr>
		  <td >
		  <div class="had2">Add Timesheet</div>
		  <div id="date_pop">
		   
<script type="text/javascript">
$(function() {
	$('#tmDate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="tmDate" name="tmDate" readonly="" class="disabled" size="10" value="<?=$_GET['tmDate']?>"  type="text" >	 <input name="search" type="button" class="search_button" value="Go" onclick="ValidateTimeDate();"  />	
		</div>
		  </td>
	    </tr>
		<tr>
		  <td height="300" valign="top" align="center" >
		   <div id="record_pop">
		   </div>
		  </td>
		  </tr>
		  
		  <tr>
				<td align="center" valign="top">
					<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Save " style="display:none" />
						<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>" >
				  </td>
		  </tr>
	    </form>
</TABLE>


</div>

<script language="JavaScript1.2" type="text/javascript">

	function ResetForm(){	
		document.getElementById("record_pop").innerHTML = '';
		document.getElementById("date_pop").style.display = 'inline';
		document.getElementById("SubmitButton").style.display = 'none';
	}

	function ValidateTimeDate(){	
		if(document.getElementById("tmDate").value==""){
			alert("Please Select Date.");
		}else{
			
			document.getElementById("record_pop").innerHTML = '<img src="images/loading.gif">';
			var SendUrl = "ajax.php?action=timesheet_form&tmDate="+document.getElementById("tmDate").value+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function TimesheetRecieve(){
				if (httpObj.readyState == 4) {
					document.getElementById("record_pop").innerHTML = httpObj.responseText;
					document.getElementById("date_pop").style.display = 'none';
					document.getElementById("SubmitButton").style.display = 'inline';
				}

			};

			httpObj.send(null);
			
		}
	}
	
	
	
function validateTimesheet(frm){
	
	var flag = 0; var TimeVal =''; var HourMinuteUrl='';
	if( ValidateForSimpleBlank(document.getElementById("Project"), "Project Name")
		&& ValidateForSimpleBlank(document.getElementById("Activity"), "Activity")
		){
				HourMinuteUrl += '&Project='+escape(document.getElementById("Project").value)+'&Activity='+escape(document.getElementById("Activity").value)+'&tmDate='+escape(document.getElementById("tmDate").value)+'&FromDate='+escape(document.getElementById("FromDate").value)+'&ToDate='+escape(document.getElementById("ToDate").value)+'&EmpID='+escape(document.getElementById("EmpID").value);
				
				for(i=1;i<=7;i++){
					if(!ValidateOptNumField2(document.getElementById("TimeHour"+i),"Hour",1,23)){
						return false;
					}
					if(!ValidateOptNumField2(document.getElementById("TimeMinute"+i),"Minute",1,59)){
						return false;
					}

					TimeVal = '';
					if(document.getElementById("TimeHour"+i).value!=''){
						if(flag!=1) flag=1;
						TimeVal = document.getElementById("TimeHour"+i).value;
					}
					
					if(document.getElementById("TimeMinute"+i).value!=''){
						if(flag!=1) flag=1;
						if(TimeVal=='') TimeVal = '0';
						TimeVal += ':'+document.getElementById("TimeMinute"+i).value;
					}else if(TimeVal!=''){
						TimeVal += ':00';
					}
					
					if(TimeVal!=''){
						HourMinuteUrl += '&Time'+i+'='+TimeVal;
					}

					
				}
				
				if(flag!=1){
					alert('Please Fill Time.');
					return false;
				}			
				
				
				document.getElementById("record_pop").innerHTML = '<img src="images/loading.gif">';
				document.getElementById("SubmitButton").style.display = 'none';
				var SendUrl = "ajax.php?action=timesheet_add"+HourMinuteUrl+"&r="+Math.random(); 
				
				httpObj.open("GET", SendUrl, true);
				httpObj.onreadystatechange = function TimesheetSendRecieve(){
					if (httpObj.readyState == 4) {
						if(httpObj.responseText==1) {
							document.getElementById("record_pop").innerHTML = "<div class=greenmsg><br><br><br><br>Timesheet has been saved successfully.</div>";
						}else if(httpObj.responseText==0) {
							document.getElementById("record_pop").innerHTML = "<div class=redmsg><br><br><br><br>Error: Timesheet has not been saved.</div>";
						}else{
							alert("Error: "+httpObj.responseText);
						}
						
						document.getElementById("date_pop").style.display = 'none';
						return false;
					}
	
				};
	
				httpObj.send(null);				
				
				return false;						
			}else{
				return false;	
		}		
}	
	
	
	
	
</script>