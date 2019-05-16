<SCRIPT LANGUAGE=JAVASCRIPT>


function ShowEmpList()
{
	if(!ValidateForSelect(document.getElementById("Department"), "Department")){
		return false;
	}else{
		ShowHideLoader(1,'F');
		location.href= 'assignLeave.php?d='+document.getElementById("Department").value;
	}
}

function ValidateForm(frm)
{

	if(document.getElementById("Department") != null){
		if(!ValidateForSelect(frm.Department, "Department")){
			return false;
		}
	}


	if( ValidateForSelect(frm.EmpID, "Employee") 
		&& ValidateForSelect(frm.LeaveType, "Leave Type")
		&& ValidateForSelect(frm.FromDate, "Leave From Date") 
		&& ValidateForSelect(frm.ToDate, "Leave To Date")
	){
		if(document.getElementById("LeaveType").value<=0){
			if(frm.FromDate.value<frm.CurrentDate.value){
				alert("Leave From Date should be greater than Current Date.");
				return false;
			}
		}
		
		
		if(frm.ToDate.value<frm.FromDate.value){
			alert("Leave To Date should be greater than From Date.");
			return false;
		}
		var numD = DateDiff(frm.FromDate.value,frm.ToDate.value);
		if(numD>60){
			alert("Leave Date Range should not exceed 60 days.");
			return false;
		}

		ShowHideLoader(1,'S');
		/*var Url = "isRecordExists.php?EntitlementEmpID="+escape(document.getElementById("EmpID").value)+"&LeaveType="+document.getElementById("LeaveType").value+"&editID="+document.getElementById("EntID").value;
	
		SendExistRequest(Url,"EmpID","Leave Entitlement");
		return false;*/
	}else{
		return false;	
	}
	
}
</SCRIPT>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<tr>
		  <td align="center">
		  
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
   
	<? if($_GET['edit']<=0){ ?>
   <tr style="display:none">
                      <td  align="right"   class="blackbold" width="45%"> 
					 Leave Period :
					  </td>
                      <td  align="left" valign="top">
<? if(!empty($LeaveStart) && !empty($LeaveEnd)){ 
	
	$YearStart = date("Y", strtotime($LeaveStart));
	$YearEnd = date("Y", strtotime($LeaveEnd));

	echo date($Config['DateFormat'], strtotime($LeaveStart))." - ".date($Config['DateFormat'], strtotime($LeaveEnd)); ?>

 	<input type="hidden" name="LeaveStart" id="LeaveStart" value="<?=$LeaveStart?>">   
 	<input type="hidden" name="LeaveEnd" id="LeaveEnd" value="<?=$LeaveEnd?>">   

<? }else{
	#$HideSibmit=1;
	#echo NOT_SPECIFIED;
}
	?>
					  </td>
                    </tr>  
	<? } ?>				



<? if($HideSibmit!=1){ ?>

					<?  if(empty($arryLeave[0]['EmpID'])){	?>
					<tr >
				<td  align="right"   class="blackbold" width="45%">Department :<span class="red">*</span></td>
				<td align="left">

				<select name="Department" class="inputbox" id="Department" onChange="Javascript:ShowEmpList();">
				  <option value="">--- Select ---</option>
				  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
				  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['d']){echo "selected";}?>>
				 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
				  </option>
				  <? } ?>
				</select>

				 	</td>
			  </tr>						
					<? 
						if(empty($_GET['d'])){ $HideSibmit = 1; $EmpDisplay = 'style="display:none"';}
					
					} ?>


                    <tr <?=$EmpDisplay?> >
                      <td  align="right" valign="top" class="blackbold" > 
					  Employee :<span class="red">*</span> </td>
                      <td   align="left" valign="top">					
				  	<?  if($_GET['edit'] >0 || $arryLeave[0]['EmpID']>0){	?>
					
					<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryLeave[0]['EmpID']?>" ><?=stripslashes($arryLeave[0]['UserName'])?></a> [<?=stripslashes($arryLeave[0]['JobTitle']).' - '.stripslashes($arryLeave[0]['Department'])?>]   
					
						<input type="hidden" name="EmpID" id="EmpID" value="<?=$arryLeave[0]['EmpID']?>">
					<? }else{ ?>                     
                       				
					<select name="EmpID" class="inputbox" id="EmpID" onChange="Javascript:GetLeaveBalance();">
						<? if($numEmp>0){ ?>
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryLeave[0]['EmpID']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?> [<?=stripslashes($arryEmployee[$i]['JobTitle'])?>]
							</option>
						<? } ?>
						<? }else{ ?>
							<option value=""><?=NO_EMPLOYEE?></option>
						<? } ?>
					</select>
					
					<? 
					}
					?>
				
					  </td>
                    </tr>

				<? if($HideSibmit != 1){ ?>	
					
			<tr >
				<td  align="right"   class="blackbold">Leave Type :<span class="red">*</span></td>
				<td align="left">

				<select name="LeaveType" class="inputbox" id="LeaveType" onChange="Javascript:GetLeaveBalance();">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryLeaveType);$i++) {?>
						<option value="<?=$arryLeaveType[$i]['attribute_value']?>" <?  if($arryLeaveType[$i]['attribute_value']==$arryLeave[0]['LeaveType']){echo "selected";}?>>
						<?=$arryLeaveType[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select> 	</td>
			  </tr>	
			  
			 
			<tr >
				<td  align="right"  width="45%" class="blackbold">Leave Balance :</td>
				<td align="left">
<div id="LeaveBalance"></div>
					</td>
			  </tr>	 
			 
			 
<tr>
                      <td width="45%" align="right"  class="blackbold">
					 From Date :<span class="red">*</span>
					  </td>
                      <td align="left">
<? if($arryLeave[0]['FromDate']>0) $FromDate = $arryLeave[0]['FromDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-1?>:<?=date("Y")+1?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" > 
		 
&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="FromDateHalf" value="1" <? if($arryLeave[0]['FromDateHalf']==1)echo 'checked'; ?>> Half Day


					  </td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold"> 
					To Date :<span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
<? 

if($arryLeave[0]['ToDate']>0) $ToDate = $arryLeave[0]['ToDate'];  ?>				

<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-1?>:<?=date("Y")+1?>', 
				changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" > 

&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ToDateHalf" value="1" <? if($arryLeave[0]['ToDateHalf']==1)echo 'checked'; ?>> Half Day

					  </td>
                    </tr>			  	
                  
			
	 <tr>
          <td align="right"   class="blackbold" valign="top">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryLeave[0]['Comment'])?></textarea>	
			
			</td>
        </tr>


<? if(!empty($arryLeave[0]['ApplyDate'])){?>				
			 
<tr>
                      <td align="right"  class="blackbold">
					 Applied On :
					  </td>
                      <td align="left">
<?=date($Config['DateFormat'], strtotime($arryLeave[0]["ApplyDate"]))?>
		 
					  </td>
                    </tr>
<? } ?>



<? if(empty($EmpDisplay)){ ?>
 <tr <?=$EmpDisplay?> >
				<td  align="right" <?=$HideStatus?> width="45%" class="blackbold">Status :<span class="red">*</span></td>
				<td align="left" <?=$HideStatus?>>

				<select name="Status" class="inputbox" id="Status">
					<? for($i=0;$i<sizeof($arryLeaveStatus);$i++) {?>
						<option value="<?=$arryLeaveStatus[$i]['attribute_value']?>" <?  if($arryLeaveStatus[$i]['attribute_value']==$arryLeave[0]['Status']){echo "selected";}?>>
						<?=$arryLeaveStatus[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select> 	</td>
			  </tr>	
<? } ?>




				<? } ?>	

			
		<? } ?>	
			
                   
                   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		<tr>
		  <td align="center" valign="top"><br>
			<? if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="LeaveID" id="LeaveID" value="<?=$_GET['edit']?>">  
	<input type="hidden" name="OldStatus" id="OldStatus" value="<?=$arryLeave[0]['Status']?>">  
	<input type="hidden" name="CurrentDate" id="CurrentDate" value="<?=date("Y-m-d")?>">  

	<? if($HideSibmit!=1){ ?>

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;<? } ?>		    </td>
		  </tr>
	    </form>
</TABLE>
<script>
GetLeaveBalance();
</script>
