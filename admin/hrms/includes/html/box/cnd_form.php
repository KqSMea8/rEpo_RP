<script language="JavaScript1.2" type="text/javascript">
function validateCandidate(frm){
	if( ValidateForSelect(frm.Vacancy,"Job Vacancy")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		&& ValidatePhoneNumber(frm.Mobile,"Contact Number",10,20)
		&& ValidateForSelect(frm.ApplyDate,"Apply Date")
		&& ValidateForSelect(frm.ExperienceYear,"Total Years of Experience")
		&& ValidateForSelect(frm.ExperienceMonth,"Total Months of Experience")
		&& ValidateMandDecimalField(frm.Salary,"Current Salary")
		&& ValidateForSelect(frm.InterviewStatus ,"Interview Stage")
		){
					
				/**********************/
				DataExist = CheckExistingData("isRecordExists.php", "&Type=Candidate&Email="+escape(document.getElementById("Email").value), "Email","Email Address");
				if(DataExist==1)return false;
				/**********************/
				
				/*var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("CanID").value+"&Type=Candidate";
				SendExistRequest(Url,"Email", "Email Address");*/


				document.getElementById("prv_msg_div").style.display = 'block';
				document.getElementById("preview_div").style.display = 'none';

				return true;						
			}else{
				return false;	
		}			
}
</script>

<div id="prv_msg_div" style="display:none;margin-top:150px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<? 
if($numVacancy>0 || $_GET['edit']>0){ ?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCandidate(this);" enctype="multipart/form-data">
   <tr>
    <td  align="center" valign="top" >
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

  <tr>
        <td  align="right"   class="blackbold"> Job Vacancy  :<span class="red">*</span> </td>
        <td   align="left" >
		<? if($numVacancy>0){ ?> 
		<select name="Vacancy" class="inputbox" id="Vacancy">
          <option value="">--- Select ---</option>
          <? for($i=0;$i<$numVacancy;$i++) {?>
          <option value="<?=$arryVacancy[$i]['vacancyID']?>" <?  if($arryVacancy[$i]['vacancyID']==$arryCandidate[0]['Vacancy']){echo "selected";}?>>
          <?=stripslashes($arryVacancy[$i]['Name'])?> [<?=stripslashes($arryVacancy[$i]['DepartmentName'])?>]
          </option>
          <? } ?>
        </select>
		<? }else{
			 echo '<span class="red">No Vacancy.</span>'; 
			 if(!empty($arryCandidate[0]['VacancyName'])){
			 	echo '&nbsp;&nbsp;[Current Vacancy: '.stripslashes($arryCandidate[0]['VacancyName']).']';
			 }
		
		
		 } ?>

		</td>
      </tr>	
  
  


<tr>
        <td  align="right"   class="blackbold"> First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryCandidate[0]['FirstName']); ?>"  maxlength="50"  />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryCandidate[0]['LastName']); ?>"  maxlength="50" />            </td>
      </tr>
	 
	  
	  
 <tr>
        <td  align="right"   class="blackbold" width="45%"> Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryCandidate[0]['Email']; ?>"  maxlength="80" />
		</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Contact Number  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryCandidate[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>	

     
         

<tr>
        <td align="right"   class="blackbold">Apply Date  :<span class="red">*</span></td>
        <td  align="left" >		
<script type="text/javascript">
$(function() {
	$('#ApplyDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
				changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="ApplyDate" name="ApplyDate" readonly="" class="datebox" value="<?=$arryCandidate[0]['ApplyDate']?>"  type="text" >		</td>
      </tr>  
	  
	
	
<tr>
        <td align="right"   class="blackbold" >
		Total Experience  :<span class="red">*</span></td>
        <td height="30" align="left" >
		
	<select name="ExperienceYear" class="textbox" id="ExperienceYear" style="width:70px;">
		<option value="">--Select--</option>
		<option value="Fresher">Fresher</option>
		<? for($i=0;$i<=30;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryCandidate[0]['ExperienceYear']!=''  && $arryCandidate[0]['ExperienceYear'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
		<option value="30+" <? if($arryCandidate[0]['ExperienceYear'] == '30+') echo 'selected';?>> 30+ </option>	 
     </select> Years &nbsp;&nbsp; 	
		
	<select name="ExperienceMonth" class="textbox" id="ExperienceMonth" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=0;$i<=11;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryCandidate[0]['ExperienceMonth']!=''  && $arryCandidate[0]['ExperienceMonth'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select> Months	
		
		</td>
	  </tr>	
	  

	  
	  
	  <tr>
        <td align="right"   class="blackbold" >
		 Current Salary  :<span class="red">*</span></td>
        <td height="30" align="left" ><input name="Salary" type="text" class="textbox" size="10" id="Salary" value="<?php echo stripslashes($arryCandidate[0]['Salary']); ?>"  maxlength="15" onkeypress="return isDecimalKey(event);" />&nbsp;<?=$Config['Currency']?>&nbsp;&nbsp;
		
		<select name="SalaryFrequency" class="textbox" id="SalaryFrequency">
      <? for($i=0;$i<sizeof($arrySalaryFrequency);$i++) {?>
      <option value="<?=$arrySalaryFrequency[$i]['attribute_value']?>" <?  if($arrySalaryFrequency[$i]['attribute_value']==$arryCandidate[0]['SalaryFrequency']){echo "selected";}?>>
      <?=$arrySalaryFrequency[$i]['attribute_value']?>
      </option>
      <? } ?>
    </select>
		
		
		</td>
	  </tr>	  
		
      

	


	
<tr>
        <td  align="right"   class="blackbold" 
		>Interview Stage  :<span class="red">*</span> </td>
        <td   align="left"  >
          
		  <select name="InterviewStatus" class="inputbox" id="InterviewStatus">
		  	<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryInterviewStatus);$i++) {?>
					<option value="<?=$arryInterviewStatus[$i]['attribute_value']?>" <?  if($arryInterviewStatus[$i]['attribute_value']==$arryCandidate[0]['InterviewStatus']){echo "selected";}?>>
					<?=$arryInterviewStatus[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select>
		  
		  
		   </td>
      </tr>



	


</table>	
  




	
	  
	
	</td>
   </tr>

<? if($numVacancy>0){ ?> 
   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit "  />


	<input type="hidden" name="CanID" id="CanID" value="<?=$_GET['edit']?>" />


</div>

</td>
   </tr>
   <? } ?>
   </form>
</table>


<? }else{ ?>
<div class="message"><?=NO_VACANCY_TO_ADD_CAND?></div>
<? } ?>

</div>