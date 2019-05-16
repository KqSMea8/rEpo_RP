<div id="request_salary_slip" style="display:none; width:350px; height:225px;">
<div class="had2">&nbsp;Request for Salary Slip</div>
<div id="record_pop" class="redmsg" align="center" style="padding-top:30px;"></div>
<div id="record_list">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formReq" action="" method="post"  enctype="multipart/form-data" onSubmit="return validateReq(this);">
		<tr>
		  <td >
		   
		  <table width="100%" border="0" cellpadding="0" cellspacing="1" class="borderall" align="center">
					<tr>
                      <td  width="25%" align="right"   class="blackbold"> 
						From Date :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-2?>:<?=date("Y")?>', 
		maxDate: "-1D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly="" class="datebox"  value=""  type="text" >					
						
					  </td>
                    </tr>	

<tr>
                      <td  align="right"   class="blackbold"> 
						To Date :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						
<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-2?>:<?=date("Y")?>', 
		maxDate: "-1D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="ToDate" name="ToDate" readonly="" class="datebox" value=""  type="text" >					
						
					  </td>
                    </tr>	


					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Message :
					  </td>
                      <td  align="left" valign="top">
						 <textarea name="Message" type="text" class="textarea" id="Message" maxlength="200"></textarea>	
					  </td>
                    </tr>	
                  
				   
				   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		
		<tr>
				<td align="center" >
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Send " />
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>" />
	
	<input type="hidden" name="TodayDate" id="TodayDate" value="<?=$Config['TodayDate']?>" />
	
	
				  </td>
		  </tr>
		
	    </form>
</TABLE>
</div>

</div>

<script language="JavaScript1.2" type="text/javascript">

function ResetForm(){	
	document.getElementById("record_pop").innerHTML = '';
	document.getElementById("record_list").style.display = 'block';
	document.getElementById("record_pop").style.display = 'none';
}

function validateReq(frm){
	if( ValidateForSelect(frm.FromDate, "From Date")
		&& ValidateForSelect(frm.ToDate, "To Date")
		){
				if(frm.FromDate.value >= frm.ToDate.value){
					alert("To Date should be greater than From Date.");
					return false;
				}



				$("#record_pop").html('<img src="../images/ajaxloader.gif">');
				$("#record_pop").show();
				$("#record_list").hide();

				var SendUrl = "&action=request_salary_slip&FromDate="+document.getElementById("FromDate").value+"&ToDate="+document.getElementById("ToDate").value+"&Message="+escape(document.getElementById("Message").value)+"&EmpID="+escape(document.getElementById("EmpID").value)+"&r="+Math.random(); 

				$.ajax({
					type: "GET",
					url: "ajax.php",
					data: SendUrl,
					success: function (responseText) {
						$("#record_pop").html(responseText);
						return false;
						
					}
				});


				return false;						
		}else{
				return false;	
		}			
}

</script>
