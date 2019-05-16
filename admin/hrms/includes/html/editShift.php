
<SCRIPT LANGUAGE=JAVASCRIPT>
function ReplaceTime(field_id){
	var field_val = document.getElementById(field_id).value;
	field_val = parseInt(field_val.replace(":", "")); 

	return field_val; 
}

function validate(frm){
		if( ValidateForSimpleBlank(frm.shiftName, "Shift Name")
		&& ValidateForSelect(frm.WorkingHourStart, "Working Hour Start") 
		&& ValidateForSelect(frm.WorkingHourEnd, "Working Hour End")
		){
			if(document.getElementById("WorkingDuration").value < 1){
				alert("Working Hour End should be greater than Working Hour Start.");
				return false;
			}



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
		if(!ValidateForSelect(frm.PayrollStart, "Payroll Start Date")){
				return false;
		}
		if(!ValidateForSelect(frm.PayCycle, "Pay Cycle")){
			return false;
		}



			var Url = "isRecordExists.php?shiftName="+escape(document.getElementById("shiftName").value)+"&editID="+document.getElementById("shiftID").value;
			SendExistRequest(Url,"shiftName","Shift Name");
			
			return false;
			
		}else{
			return false;	
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

</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>


<div class="had"><?=$MainModuleName?> <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
	

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="0"  class="borderall">


 <tr>
	 <td colspan="4" align="left" class="head">General</td>
</tr>
                    <tr>
                      <td align="right" width="20%" valign="top"   class="blackbold">
					   Shift Name :<span class="red">*</span> </td>
                      <td align="left" width="25%"  valign="top">
					<input  name="shiftName" id="shiftName" value="<?=stripslashes($arryShift[0]['shiftName'])?>" type="text" class="inputbox" maxlength="30" />  
					    </td>
                  
                      <td width="25%" align="right"  class="blackbold">
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

<input name="WorkingHourStart" type="text" class="disabled" size="4" maxlength="5" id="WorkingHourStart" value="<?=$arryShift[0]['WorkingHourStart']?>"  autocomplete="off" onchange="Javascript:ShowDuration();"/>
		 
					  </td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold"> 
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

<input name="WorkingHourEnd" type="text" class="disabled" size="4" maxlength="5" id="WorkingHourEnd" value="<?=$arryShift[0]['WorkingHourEnd']?>"  autocomplete="off" onchange="Javascript:ShowDuration();"/>


					  </td>
                   
                      <td  align="right" valign="top"  class="blackbold"> 
						Duration :

					  </td>
                      <td  align="left" valign="top">

						<div id="WorkingDurationDiv">0</div>
						<input type="hidden" name="WorkingDuration" id="WorkingDuration" value="0">
						<script>ShowDuration();</script>
					  </td>
                    </tr>
					
					
                  	
					<!--tr >
                      <td align="right" valign="top"  class="blackbold" > Detail : </td>
                      <td align="left" valign="top">

<textarea name="detail" id="detail" class="textarea" maxlength="250"><?=htmlentities(stripslashes($arryShift[0]['detail']))?></textarea>
	
					  
					  </td>
                    </tr-->

	<tr>
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

<input name="SL_Coming" type="text" class="disabled" size="4" maxlength="5" id="SL_Coming" value="<?=$arryShift[0]['SL_Coming']?>"  autocomplete="off"/>					

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

<input name="SL_Leaving" type="text" class="disabled" size="4" maxlength="5" id="SL_Leaving" value="<?=$arryShift[0]['SL_Leaving']?>"  autocomplete="off"/>							


					  </td>
                    </tr>



<tr>
                      <td  align="right"   class="blackbold"> 
						Week Start :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
						<?  
						echo getWeekDay($arryShift[0]['WeekStart'],"WeekStart","textbox");
						?>
					  </td>
             
                      <td  align="right"   class="blackbold"> 
						Week End :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
						<?  
						echo getWeekDay($arryShift[0]['WeekEnd'],"WeekEnd","textbox");
						?>
						
					  </td>
                </tr>

<tr>
<td  align="right"   class="blackbold" valign="top">Weekend Count for Leave :</td>
<td  align="left" valign="top">
<input name="WeekendCount" id="WeekendCount"  type="checkbox" value="1" <?=($arryShift[0]['WeekendCount'] == 1)?('checked'):('')?> />
</td>
</tr>	


 <tr id="timetr">
	 <td colspan="4" align="left" class="head">Time</td>
</tr>




<tr id="lunchtr">
<td  align="right"   class="blackbold" valign="top">Lunch Punch Allowed :</td>
<td  align="left" valign="top">
<input name="LunchPunch" id="LunchPunch"  type="checkbox" value="1" <?=($arryShift[0]['LunchPunch'] == 1)?('checked'):('')?> />
</td>

<td  align="right"   class="blackbold" valign="top">Lunch Time :</td>
<td  align="left" valign="top">
<?  $LunchTime = explode(":",$arryShift[0]['LunchTime']);?>
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
<input name="LunchPaid" id="LunchPaid"  type="checkbox" value="1" <?=($arryShift[0]['LunchPaid'] == 1)?('checked'):('')?> />
</td>
<td  align="right"   class="blackbold" valign="top">Short Break Paid :</td>
<td  align="left" valign="top">
<input name="ShortBreakPaid" id="ShortBreakPaid"  type="checkbox" value="1" <?=($arryShift[0]['ShortBreakPaid'] == 1)?('checked'):('')?> />

</td>
</tr>

<tr id="flextr">
<td  align="right"   class="blackbold" valign="top">Flex Time 	:</td>
<td  align="left" valign="top">
<input name="FlexTime" id="FlexTime"  type="checkbox" value="1" <?=($arryShift[0]['FlexTime'] == 1)?('checked'):('')?> />
</td>
<td  align="right"   class="blackbold" valign="top">Short Break Allowed :</td>
<td  align="left" valign="top">
<input name="ShortBreakPunch" id="ShortBreakPunch"  type="checkbox" value="1" <?=($arryShift[0]['ShortBreakPunch'] == 1)?('checked'):('')?> />
</td>


</td>
</tr>

<tr id="shortbreaktr">

<td  align="right"   class="blackbold" valign="top">Short Break Limit :</td>
<td  align="left" valign="top">
<input name="ShortBreakLimit" type="text" class="textbox" style="width:20px" maxlength="1" id="ShortBreakLimit" value="<?=$arryShift[0]['ShortBreakLimit']?>"  autocomplete="off" onkeypress="return isNumberKey(event);"/>
<td  align="right"   class="blackbold">Short Break Time :</td>
<td  align="left" valign="top">
<select name="ShortBreakTime" id="ShortBreakTime" class="textbox">
	<?
	echo '<option value="0"> Min </option>';
	for($i=5;$i<=60;$i=$i+5){		
		$sel = ($arryShift[0]['ShortBreakTime']==$i)?('selected'):('');
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select>

</td>
</tr>


<tr id="EarlyPunchRestricttr">
<td  align="right"   class="blackbold" valign="top">Early Punch Restrict:</td>
<td  align="left" valign="top">
<input name="EarlyPunchRestrict" id="EarlyPunchRestrict"  type="checkbox" value="1" <?=($arryShift[0]['EarlyPunchRestrict'] == 1)?('checked'):('')?> />
</td>
<td  align="right"   class="blackbold" valign="top">Early Break Restrict:</td>
<td  align="left" valign="top">
<input name="EarlyBreakRestrict" id="EarlyBreakRestrict"  type="checkbox" value="1" <?=($arryShift[0]['EarlyBreakRestrict'] == 1)?('checked'):('')?> />
</td>

</tr>

<tr id="EarlyPunchRestricttr2">
<td  align="right"   class="blackbold" valign="top">Early Lunch In Restrict :</td>
<td  align="left" valign="top">
<input name="EarlyLunchRestrict" id="EarlyLunchRestrict"  type="checkbox" value="1" <?=($arryShift[0]['EarlyLunchRestrict'] == 1)?('checked'):('')?> />
</td>

</tr>


 <tr>
	<td  align="right"  valign="top" class="blackbold"> 
	Overtime Period : </td>
<td align="left" valign="top">
<select name="OvertimePeriod" id="OvertimePeriod" class="textbox" >
	<option value="D"  > Daily </option>
	<option value="W" <?=($arryShift[0]['OvertimePeriod']=='W')?('selected'):('')?>> Weekly </option>
</select>
 </td>

	<td  align="right"  valign="top" class="blackbold"> 
	Overtime Eligibility in a Week : </td>
<td align="left" valign="top">
<input name="OvertimeHourWeek" type="text" class="textbox" size="2" maxlength="3" id="OvertimeHourWeek" value="<?=$arryShift[0]['OvertimeHourWeek']?>"  autocomplete="off" onkeypress="return isNumberKey(event);"/>
 Hours
 </td>

</tr>




 <tr>
	 <td colspan="4" align="left" class="head">Payroll</td>
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
<input id="PayrollStart" name="PayrollStart" readonly="" class="datebox" value="<?=$arryShift[0]['PayrollStart']?>"  type="text" >  


				</td>

                      <td  align="right"   class="blackbold"> 
					Pay Cycle :<span class="red">*</span>
		      </td>
                      <td  align="left" valign="top">

<?
echo '<select name="PayCycle" id="PayCycle" class="textbox" ><option value="">--- Select ---</option>';
foreach($PayCycleArray as $opt){
	$selected = ($arryShift[0]['PayCycle'] == $opt)?('Selected'):('');
	echo '<option value="'.$opt.'" '.$selected.'>'.$opt.'</option>';
}
echo '</select>';
?>			  </td>

		





                    </tr>



<tr>


 
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" valign="top"  >

 <? 
		  	 $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryShift[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryShift[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive




                                          </td>
                    </tr>


                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="shiftID" id="shiftID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>
