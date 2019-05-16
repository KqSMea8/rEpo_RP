<SCRIPT LANGUAGE=JAVASCRIPT>

function SetShiftPart(){
	var UseShift = document.getElementById("UseShift").value;	
	if(UseShift=='1'){
		$("#workdurationtr").hide();
		$("#workhourtr").hide();
		$("#timetr").hide();
		$("#lunchtr").hide();
		$("#flextr").hide();
		$("#shortbreaktr").hide();
		$("#shortleavetr").hide();
     		$("#breakpaidtr").hide();
		$("#paycycletr").hide();
		$("#EarlyPunchRestricttr").hide();
	}else{
		$("#workdurationtr").show();
		$("#workhourtr").show();
		$("#timetr").show();
		$("#lunchtr").show();
		$("#flextr").show();
		$("#shortbreaktr").show();
		$("#shortleavetr").show();
		$("#breakpaidtr").show();
		$("#paycycletr").show();
		$("#EarlyPunchRestricttr").show();
	}
	
	

}

function SetReimbursement(){	 
	if(document.getElementById("ExpenseClaim").checked){
		$("#ReimTR").show();
		$("#ReimRateTR").show();
		$("#ReimGLTR").show();		
	}else{
		$("#ReimTR").hide();
		$("#ReimRateTR").hide();
		$("#ReimGLTR").hide();			
	}	

}



function SetWeekEndOff()
{
	var flag = false; var checkflag = '';
	if(document.getElementById("WeekEndOff0").checked){
		flag = true;
		checkflag = 1;
	}else{
		flag = false;
	}
	
	
	for(var i=1;i<=5;i++){
		document.getElementById("WeekEndOff"+i).disabled =  flag;
		if(checkflag==1)
			document.getElementById("WeekEndOff"+i).checked =  false;
	}

}


function ShowDuration()
{
	var WorkingHourStart = document.getElementById("WorkingHourStart").value;
	var WorkingHourEnd = document.getElementById("WorkingHourEnd").value;
	document.getElementById("WorkingDuration").innerHTML = "0";
	document.getElementById("WorkingDuration").value = "0";

	if(WorkingHourStart!='' && WorkingHourEnd!=''){

			var SendUrl = "&action=working_duration&WorkingHourStart="+WorkingHourStart+"&WorkingHourEnd="+WorkingHourEnd+"&r="+Math.random(); 

			$.ajax({
				type: "GET",
				url: "ajax.php",
				data: SendUrl,
				dataType : "JSON",
				success: function (responseText) {
					document.getElementById("WorkingDurationDiv").innerHTML=responseText["DurationHtml"];
					document.getElementById("WorkingDuration").value=responseText["Duration"];
				}
			});

	}

}



function ReplaceTime(field_id){
	var field_val = document.getElementById(field_id).value;
	field_val = parseInt(field_val.replace(":", "")); 

	return field_val; 
}


function ValidateForm(frm)
{
		
		var UseShift = document.getElementById("UseShift").value;	
		
		if(UseShift!='1'){
			if(!ValidateForSelect(frm.WorkingHourStart, "Working Hour Start")){
				return false;
			}
			if(!ValidateForSelect(frm.WorkingHourEnd, "Working Hour End")){
				return false;
			}

			if(document.getElementById("WorkingDuration").value < 1){
				alert("Working Hour End should be greater than Working Hour Start.");
				return false;
			}
		}


		if(!ValidateForSimpleBlank(frm.HalfDayHour, "Minimum Hours for Half Day")){
			return false;
		}
		if(!ValidateForSimpleBlank(frm.FullDayHour, "Minimum Hours for Full Day")){
			return false;
		}
		if(!ValidateForSelect(frm.WeekStart, "Week Start")){
			return false;
		}
		if(!ValidateForSelect(frm.WeekEnd, "Week End")){
			return false;
		}
		if(frm.WeekStart.value == frm.WeekEnd.value){
			alert("Week Start and  Week End should not be same.");
			return false;
		}


		if(UseShift!='1'){
			/**********
			if(!ValidateForSelect(frm.SL_Coming, "Short Leave for Late Coming")){
				return false;
			}
			/**********/
			var SL_Coming = ReplaceTime("SL_Coming");
			var WorkingHourStart = ReplaceTime("WorkingHourStart");
			var WorkingHourEnd = ReplaceTime("WorkingHourEnd");
			if(SL_Coming < WorkingHourStart){
				alert("Short Leave for Late Coming time should not be less than Working Hour Start time.");
				frm.SL_Coming.focus();
				return false;
			}else if(SL_Coming >= WorkingHourEnd){
				alert("Short Leave for Late Coming time should be less than Working Hour End time.");
				frm.SL_Coming.focus();
				return false;
			}
			/**********
			if(!ValidateForSelect(frm.SL_Leaving, "Short Leave for Early Leaving")){
				return false;
			}
			/**********/
			var SL_Leaving = ReplaceTime("SL_Leaving");
			if(SL_Leaving < WorkingHourStart){
				alert("Short Leave for Early Leaving time should not be less than Working Hour Start time.");
				frm.SL_Leaving.focus();
				return false;
			}else if(SL_Leaving >= WorkingHourEnd){
				alert("Short Leave for Early Leaving time should be less than Working Hour End time.");
				frm.SL_Leaving.focus();
				return false;
			}

			/**********/

		}



		if(!ValidateForSimpleBlank(frm.LableLeave, "Label for Leave in attendence sheet")){
			return false;
		}
		if(UseShift!='1'){
			if(!ValidateForSelect(frm.PayrollStart, "Payroll Start Date")){
				return false;
			}
			if(!ValidateForSelect(frm.PayCycle, "Pay Cycle")){
				return false;
			}
		}

		ShowHideLoader(1,'S');
		return true;
	
}

</SCRIPT>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_global'])) {echo $_SESSION['mess_global']; unset($_SESSION['mess_global']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >

          
               
                <tr>
                  <td align="center" valign="top" >
				  
<table width="100%" border="0" cellpadding="5" cellspacing="0"  class="borderall">
 <tr>
	 <td colspan="4" align="left" class="head">General</td>
</tr>
                 

 <tr>
	<td  width="20%"  align="right"   class="blackbold"> 
	Use Work Shift : </td>
<td  width="25%" align="left" valign="top">
<select name="UseShift" id="UseShift" class="textbox" style="width:80px;" onchange="Javascript:SetShiftPart();">
	<option value="0"  > No </option>
	<option value="1" <?=($arryGlobal[0]['UseShift']==1)?('selected'):('')?>> Yes </option>
</select>
 </td>

<td width="25%" ></td> 

<td></td>


</tr>





 <tr id="workhourtr">
                      <td align="right"  class="blackbold">
					Working Hour Start :<span class="red">*</span>
					  </td>
                      <td >
<script>
  $(function() {
	$('#WorkingHourStart').timepicker({ 
		'timeFormat': 'H:i',
		'step': '15'
		});
  });
</script>

<input name="WorkingHourStart" type="text" class="disabled" size="4" maxlength="5" id="WorkingHourStart" value="<?=$arryGlobal[0]['WorkingHourStart']?>"  autocomplete="off" onchange="Javascript:ShowDuration();"/>
		 
					  </td>
                  
                      <td  align="right"   class="blackbold" > 
						Working Hour End :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">

<script>
  $(function() {
	$('#WorkingHourEnd').timepicker({ 
		'timeFormat': 'H:i',
		'step': '15'
		});
  });
</script>

<input name="WorkingHourEnd" type="text" class="disabled" size="4" maxlength="5" id="WorkingHourEnd" value="<?=$arryGlobal[0]['WorkingHourEnd']?>"  autocomplete="off" onchange="Javascript:ShowDuration();"/>


					  </td>
                    </tr>

 <tr id="workdurationtr">
                      <td  align="right"   class="blackbold"> 
						Duration :

					  </td>
                      <td  align="left" valign="top" colspan="3">

						<div id="WorkingDurationDiv">0</div>
						<input type="hidden" name="WorkingDuration" id="WorkingDuration" value="0">
						<script>ShowDuration();</script>
					  </td>
                    </tr>
					
                    <tr>
                      <td  align="right"   class="blackbold"> 
						Minimum Hours for Half Day :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
<input name="HalfDayHour" type="text" class="textbox" size="4" maxlength="3" id="HalfDayHour" value="<?=$arryGlobal[0]['HalfDayHour']?>"  autocomplete="off" onkeypress="return isDecimalKey(event);"/>

					  </td>
             
                      <td  align="right"   class="blackbold"> 
						Minimum Hours for Full Day :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
<input name="FullDayHour" type="text" class="textbox" size="4" maxlength="3" id="FullDayHour" value="<?=$arryGlobal[0]['FullDayHour']?>"  autocomplete="off" onkeypress="return isDecimalKey(event);"/>

					  </td>
                    </tr>

<tr>
                      <td  align="right"   class="blackbold"> 
						Week Start :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
						<?  
						echo getWeekDay($arryGlobal[0]['WeekStart'],"WeekStart","textbox");
						?>
					  </td>
             
                      <td  align="right"   class="blackbold"> 
						Week End :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
						<?  
						echo getWeekDay($arryGlobal[0]['WeekEnd'],"WeekEnd","textbox");
						?>
						
					  </td>
                </tr>
				<tr>
                      <!--td  align="right"   class="blackbold" valign="top"> 
						Week End Off :

					  </td>
                      <td  align="left" valign="top" >
						<?
						if(!empty($arryGlobal[0]['WeekEndOff'])){
							$WeekEndOffArray = explode(",", $arryGlobal[0]['WeekEndOff']);
						}else{
							$WeekEndOffArray[] = '';
						}
						?>
					  <input type="checkbox" name="WeekEndOff[]" id="WeekEndOff0" value="0" <?=($arryGlobal[0]['WeekEndOff'] == 0)?('checked'):('')?> onclick="Javascript:SetWeekEndOff();"> All <br>
					  <input type="checkbox" name="WeekEndOff[]" id="WeekEndOff1" value="1" <?=(in_array(1,$WeekEndOffArray))?('checked'):('')?>> First <br>
					  <input type="checkbox" name="WeekEndOff[]" id="WeekEndOff2" value="2" <?=(in_array(2,$WeekEndOffArray))?('checked'):('')?>> Second <br>
					  <input type="checkbox" name="WeekEndOff[]" id="WeekEndOff3" value="3" <?=(in_array(3,$WeekEndOffArray))?('checked'):('')?>> Third <br>
					  <input type="checkbox" name="WeekEndOff[]" id="WeekEndOff4" value="4" <?=(in_array(4,$WeekEndOffArray))?('checked'):('')?>> Fourth <br>
					  <input type="checkbox" name="WeekEndOff[]" id="WeekEndOff5" value="5" <?=(in_array(5,$WeekEndOffArray))?('checked'):('')?>> Last <br>
						
					 <script>SetWeekEndOff();</script>

					  </td-->


<td  align="right"   class="blackbold" valign="top">Probation Time :</td>
<td  align="left" valign="top">
<input name="ProbationTime" id="ProbationTime"  type="checkbox" value="1" <?=($arryGlobal[0]['ProbationTime'] == 1)?('checked'):('')?> />
</td>

</tr>






 <tr id="timetr">
	 <td colspan="4" align="left" class="head">Time</td>
</tr>




<tr id="lunchtr">
<td  align="right"   class="blackbold" valign="top">Lunch Punch Allowed :</td>
<td  align="left" valign="top">
<input name="LunchPunch" id="LunchPunch"  type="checkbox" value="1" <?=($arryGlobal[0]['LunchPunch'] == 1)?('checked'):('')?> />
</td>

<td  align="right"   class="blackbold" valign="top">Lunch Time :</td>
<td  align="left" valign="top">
<?  $LunchTime = explode(":",$arryGlobal[0]['LunchTime']);?>
<select name="LunchTimeHour" id="LunchTimeHour" class="textbox">
	<?
	echo '<option value="0"> Hrs </option>';
	for($i=1;$i<=3;$i++){
		$sel = ($LunchTime[0]==$i)?('selected'):('');
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select>
:
<select name="LunchTimeMinute" id="LunchTimeMinute" class="textbox">
	<?
	echo '<option value="0"> Min </option>';
	for($i=5;$i<60;$i=$i+5){		
		$sel = ($LunchTime[1]==$i)?('selected'):('');
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select>

</td>
</tr>


<tr id="breakpaidtr">
<td  align="right"   class="blackbold" valign="top">Lunch Paid 	:</td>
<td  align="left" valign="top">
<input name="LunchPaid" id="LunchPaid"  type="checkbox" value="1" <?=($arryGlobal[0]['LunchPaid'] == 1)?('checked'):('')?> />
</td>
<td  align="right"   class="blackbold" valign="top">Short Break Paid :</td>
<td  align="left" valign="top">
<input name="ShortBreakPaid" id="ShortBreakPaid"  type="checkbox" value="1" <?=($arryGlobal[0]['ShortBreakPaid'] == 1)?('checked'):('')?> />

</td>
</tr>

<tr id="flextr">
<td  align="right"   class="blackbold" valign="top">Flex Time 	:</td>
<td  align="left" valign="top">
<input name="FlexTime" id="FlexTime"  type="checkbox" value="1" <?=($arryGlobal[0]['FlexTime'] == 1)?('checked'):('')?> />
</td>
<td  align="right"   class="blackbold" valign="top">Short Break Allowed :</td>
<td  align="left" valign="top">
<input name="ShortBreakPunch" id="ShortBreakPunch"  type="checkbox" value="1" <?=($arryGlobal[0]['ShortBreakPunch'] == 1)?('checked'):('')?> />
</td>


</td>
</tr>

<tr id="shortbreaktr">

<td  align="right"   class="blackbold" valign="top">Short Break Limit :</td>
<td  align="left" valign="top">
<input name="ShortBreakLimit" type="text" class="textbox" style="width:20px" maxlength="1" id="ShortBreakLimit" value="<?=$arryGlobal[0]['ShortBreakLimit']?>"  autocomplete="off" onkeypress="return isNumberKey(event);"/>
<td  align="right"   class="blackbold">Short Break Time :</td>
<td  align="left" valign="top">
<select name="ShortBreakTime" id="ShortBreakTime" class="textbox">
	<?
	echo '<option value="0"> Min </option>';
	for($i=5;$i<=60;$i=$i+5){		
		$sel = ($arryGlobal[0]['ShortBreakTime']==$i)?('selected'):('');
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select>

</td>
</tr>



 <tr>
	 <td colspan="4" align="left" class="head">Leave</td>
</tr>
	
			
<tr>
<td  align="right"   class="blackbold" valign="top">Leave Approval :</td>
<td  align="left" valign="top">

<label><input name="LeaveApprovalCheck" id="LeaveApprovalCheck1"  type="radio" value="1" <?=($arryGlobal[0]['LeaveApprovalCheck'] == 1)?('checked'):('')?> /> First  </label><br>

<label><input name="LeaveApprovalCheck" id="LeaveApprovalCheck2"  type="radio" value="2" <?=($arryGlobal[0]['LeaveApprovalCheck'] == 2)?('checked'):('')?> /> Second  </label><br>

<label><input name="LeaveApprovalCheck" id="LeaveApprovalCheck3"  type="radio" value="3" <?=($arryGlobal[0]['LeaveApprovalCheck'] == 3)?('checked'):('')?> /> Third  </label><br>


<label><input name="LeaveApprovalCheck" id="LeaveApprovalCheck"  type="radio" value="0" <?=($arryGlobal[0]['LeaveApprovalCheck'] == 0)?('checked'):('')?> /> None </label><br>
</td>
    </tr>



				<tr>

 <td  align="right"   class="blackbold" valign="top"> 
						Max Leave Per Month :

					  </td>
                      <td  align="left" valign="top">
<input name="MaxLeaveMonth" type="text" class="textbox" size="4" maxlength="2" id="MaxLeaveMonth" value="<?=$arryGlobal[0]['MaxLeaveMonth']?>"  autocomplete="off" onkeypress="return isNumberKey(event);"/>
						
					  </td>


                      <td  align="right"   class="blackbold" valign="top"> 
						Max Short Leave Per Month :

					  </td>
                      <td  align="left" valign="top" colspan="3">
<input name="MaxShortLeave" type="text" class="textbox" size="4" maxlength="2" id="MaxShortLeave" value="<?=$arryGlobal[0]['MaxShortLeave']?>"  autocomplete="off" onkeypress="return isNumberKey(event);"/>
		&nbsp;&nbsp;&nbsp;&nbsp;<br>				

						<input name="SL_Deduct" id="SL_Deduct"  type="checkbox" value="1" <?=($arryGlobal[0]['SL_Deduct'] == 1)?('checked'):('')?> /> <?=CONVERT_TO_HALF?>
					  </td>
                    </tr>

				<tr id="shortleavetr">
                      <td  align="right"   class="blackbold"> 
						Short Leave for Late Coming : 
					  </td>
                      <td  align="left" valign="top">
<script>
  $(function() {
	$('#SL_Coming').timepicker({ 
		'timeFormat': 'H:i',
		'step': '15'
		});

	$("#SL_Coming").on("click", function () { 
			 $(this).val("");
		}
	);



  });
</script>

<input name="SL_Coming" type="text" class="disabled" size="4" maxlength="5" id="SL_Coming" value="<?=$arryGlobal[0]['SL_Coming']?>"  autocomplete="off"/>					

					  </td>
                  
                      <td  align="right"   class="blackbold"> 
						Short Leave for Early Leaving : 
					  </td>
                      <td  align="left" valign="top">
<script>
  $(function() {
	$('#SL_Leaving').timepicker({ 
		'timeFormat': 'H:i',
		'step': '15'
		});

	$("#SL_Leaving").on("click", function () { 
			 $(this).val("");
		}
	);


  });
</script>

<input name="SL_Leaving" type="text" class="disabled" size="4" maxlength="5" id="SL_Leaving" value="<?=$arryGlobal[0]['SL_Leaving']?>"  autocomplete="off"/>							


					  </td>
                    </tr>


<tr>
                      <td  align="right"   class="blackbold"> 
						Label for Leave in attendence sheet :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						<input name="LableLeave" type="text" class="textbox" size="12" maxlength="10" id="LableLeave" value="<?=$arryGlobal[0]['LableLeave']?>"  autocomplete="off" />
					
					  </td>
                    </tr>
				 <tr style="display:none">
                      <td  align="right"   class="blackbold"> 
						Label for Half Day Leave in attendence sheet :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						<input name="LableHalfDay" type="text" class="textbox" size="12" maxlength="10" id="LableHalfDay" value="<?=$arryGlobal[0]['LableHalfDay']?>"  autocomplete="off" />
					
					  </td>
                    </tr>

<tr id="EarlyPunchRestricttr">
<td  align="right"   class="blackbold" valign="top">Early Punch Allowed:</td>
<td  align="left" valign="top">
<input name="EarlyPunchRestrict" id="EarlyPunchRestrict"  type="checkbox" value="1" <?=($arryGlobal[0]['EarlyPunchRestrict'] == 1)?('checked'):('')?> />
</td>
</tr>
		
<tr>
<td  align="right"   class="blackbold" valign="top">Weekend Count for Leave :</td>
<td  align="left" valign="top">
<input name="WeekendCount" id="WeekendCount"  type="checkbox" value="1" <?=($arryGlobal[0]['WeekendCount'] == 1)?('checked'):('')?> />
</td>

<td  align="right"   class="blackbold" valign="top">Leave Period :</td>
<td  align="left" valign="top">
<select name="LeavePeriod" id="LeavePeriod" class="inputbox" style="width:120px;">
	<option value="0"  >Calendar Year</option>
	<option value="1" <?=($arryGlobal[0]['LeavePeriod']==1)?('selected'):('')?>>Anniversary Year</option>
</select>
</td>

</tr>		

 <tr>
	 <td colspan="4" align="left" class="head">Payroll</td>
</tr>


	<tr>
	<td align="right"  class="blackbold" valign="top">Payment Method :</td>
	<td align="left" >

<select name="PayMethod" id="PayMethod" class="textbox" style="width:80px;" >
	<option value="H"  > Hourly </option>
	<option value="M" <?=($arryGlobal[0]['PayMethod']=='M')?('selected'):('')?>> Monthly </option>
</select>



	</td>
	</tr>


<tr id="paycycletr">


			<td  align="right"   class="blackbold"> 
				Payroll Start Date :<span class="red">*</span>
			</td>
			 <td  align="left" valign="top">

<script type="text/javascript">
$(function() {
	$('#PayrollStart').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-1?>:<?=date("Y")?>', 
		dateFormat: 'yy-mm-dd',
		maxDate: "-1D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="PayrollStart" name="PayrollStart" readonly="" class="datebox" value="<?=$arryGlobal[0]['PayrollStart']?>"  type="text" >  


				</td>

                      <td  align="right"   class="blackbold"> 
					Pay Cycle :<span class="red">*</span>
		      </td>
                      <td  align="left" valign="top">

<?
echo '<select name="PayCycle" id="PayCycle" class="textbox" ><option value="">--- Select ---</option>';
foreach($PayCycleArray as $opt){
	$selected = ($arryGlobal[0]['PayCycle'] == $opt)?('Selected'):('');
	echo '<option value="'.$opt.'" '.$selected.'>'.$opt.'</option>';
}
echo '</select>';
?>			  </td>

		





                    </tr>




					<tr style="display:none">
                      <td  align="right"   class="blackbold"> 
						Employee Salary Date :

					  </td>
                      <td  align="left" valign="top">
					<?
					echo '<select name="SalaryDate" id="SalaryDate" class="textbox" >
						  <option value="">--- Select ---</option>';
					for($i=1;$i<=31;$i++){
						$val = ($i<10)?('0'.$i):($i);
						$s_selected = ($arryGlobal[0]['SalaryDate'] == $i)?('Selected'):('');
						echo '<option value="'.$i.'" '.$s_selected.'> '.$val.' </option>';
					}
					echo '</select>';
					
					?>
						
					  </td>
                    </tr>

				<tr>
                      <td  align="right"   class="blackbold"> 
						Activate Overtime :
					  </td>
                      <td  align="left"  >
						<input name="Overtime" id="Overtime"  type="checkbox" value="1" <?=($arryGlobal[0]['Overtime'] == 1)?('checked'):('')?> />
					
					  </td>
                    
				 
<!--tr>
                      <td  align="right"   class="blackbold"> 
						Overtime After :

					  </td>
                      <td  align="left" valign="top">

<script>
  $(function() {
	$('#OvertimeFrom').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<input name="OvertimeFrom" type="text" class="disabled" size="4" maxlength="5"  id="OvertimeFrom" value="<?=$arryGlobal[0]['OvertimeFrom']?>"  autocomplete="off"/>
					  </td>
                    </tr-->

					
                      <td  align="right"   class="blackbold"> 
						Overtime Rate :

					  </td>
                      <td  align="left" valign="top">
<input name="OvertimeRate" type="text" class="textbox" size="4" maxlength="3" id="OvertimeRate" value="<?=$arryGlobal[0]['OvertimeRate']?>"  autocomplete="off" onkeypress="return isDecimalKey(event);"/>
					  </td>
                    </tr>


				<tr>
                      <td  align="right"   class="blackbold"> 
						Activate Advance :
					  </td>
                      <td  align="left" valign="top">
						<input name="Advance" id="Advance"  type="checkbox" value="1" <?=($arryGlobal[0]['Advance'] == 1)?('checked'):('')?> />
					
					  </td>
               
                      <td  align="right"   class="blackbold"> 
						Activate Loan :
					  </td>
                      <td  align="left" valign="top">
						<input name="Loan" id="Loan"  type="checkbox" value="1" <?=($arryGlobal[0]['Loan'] == 1)?('checked'):('')?> />
					
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold"> 
						Activate Bonus :
					  </td>
                      <td  align="left" valign="top">
						<input name="Bonus" id="Bonus"  type="checkbox" value="1" <?=($arryGlobal[0]['Bonus'] == 1)?('checked'):('')?> />
					
					  </td>
          
                      <td  align="right"   class="blackbold"> 
						Activate Reimbursement :
					  </td>
                      <td  align="left" valign="top">
						<input name="ExpenseClaim" id="ExpenseClaim"  type="checkbox" value="1" <?=($arryGlobal[0]['ExpenseClaim'] == 1)?('checked'):('')?> onchange="Javascript:SetReimbursement();" />
					
					  </td>
                    </tr>  


<tr id="ReimTR">
	 <td colspan="4" align="left" class="head">Reimbursement </td>
</tr>

<tr id="ReimRateTR">
                      <td  align="right"   class="blackbold"> 
						Reimbursement Rate :
					  </td>
                      <td  align="left" valign="top">
						<input  name="ReimRate" id="ReimRate" value="<?=stripslashes($arryGlobal[0]['ReimRate'])?>" type="text" class="textbox" size="6" maxlength="30" onkeypress="return isDecimalKey(event);"/> <b><?=$Config['Currency']?></b>   
					  </td>
          
                      <td  align="right"   class="blackbold"> 
						
					  </td>
                      <td  align="left" valign="top">
						 
					
					  </td>
                    </tr>  

<tr id="ReimGLTR">
		<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){ ?>

                      <td  align="right"   class="blackbold"> 
						Mileage Account :
					  </td>
                      <td  align="left" valign="top">
						  <select name="ReimMileageGL" class="inputbox" id="ReimMileageGL">
							<option value="">--- None ---</option>
							<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
							<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryGlobal[0]['ReimMileageGL']){echo "selected";}?>>
							<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
							<? } ?>
						</select> 
					  </td>
          
                      <td  align="right"   class="blackbold"> 
						Miscellaneous Account :
					  </td>
                      <td  align="left" valign="top">
						<select name="ReimMissGL" class="inputbox" id="ReimMissGL">
							<option value="">--- None ---</option>
							<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
							<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryGlobal[0]['ReimMissGL']){echo "selected";}?>>
							<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
							<? } ?>
						</select>  
					
					  </td>
                   
 			<? } ?>
  </tr>

		</table>
				

  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top">				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit " />
		  </tr>
	    </form>
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>
	SetShiftPart();
	SetReimbursement();
</SCRIPT>
