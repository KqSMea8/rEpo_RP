<script language="JavaScript1.2" type="text/javascript">
function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}

function validateVacancy(frm){

	if(document.getElementById("EmpID") != null){
		document.getElementById("HiringManager").value = document.getElementById("EmpID").value;
	}


	if( ValidateForSelect(frm.JobTitle, "Job Title")
		&& ValidateForSimpleBlank(frm.Name, "Vacancy Name")
		&& ValidateForSelect(frm.Department,"Department")
		&& ValidateForSelect(frm.HiringManager, "Hiring Manager")
		&& ValidateMandNumField2(frm.NumPosition,"Number of Position",1,100)
		&& ValidateForSelect(frm.MinExp, "Minimum Experience")
		&& ValidateForSelect(frm.MaxExp, "Maximum Experience")
		&& ValidateForSelect(frm.MinAge, "Minimum Age")
		&& ValidateForSelect(frm.MaxAge, "Maximum Age")
		){
					
				if(parseInt(frm.MaxExp.value) < parseInt(frm.MinExp.value)){
					alert("Maximum Experience should be greater than Minimum Experience.");
					return false;
				}
					
				if(parseInt(frm.MaxAge.value) < parseInt(frm.MinAge.value)){
					alert("Maximum Age should be greater than Minimum Age.");
					return false;
				}
				
				if(parseInt(frm.MaxSalary.value) < parseInt(frm.MinSalary.value)){
					alert("Maximum Salary should be greater than Minimum Salary.");
					return false;
				}
					
					
				if(document.getElementById("Status") != null){
					if(!ValidateForSelect(frm.Status, "Status")){
						return false;
					}
				
				}	
					
					
				var Url = "isRecordExists.php?VacancyName="+escape(document.getElementById("Name").value)+"&editID="+document.getElementById("vacancyID").value;
				SendExistRequest(Url,"Name", "Vacancy Name");
				return false;						
			}else{
				return false;	
		}			
}
</script>

<a href="<?=$RedirectURL?>"  class="back">Back</a>

<div class="had">
<?=$MainModuleName?>   <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>



<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateVacancy(this);" enctype="multipart/form-data">
  
  	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
   <tr>
    <td  align="center" valign="top" >
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
        <td  width="45%" align="right"   class="blackbold"> Job Title  :<span class="red">*</span> </td>
        <td   align="left" >
		
		<select name="JobTitle" class="inputbox" id="JobTitle">
          <option value="">--- Select ---</option>
          <? for($i=0;$i<sizeof($arryJobTitle);$i++) {?>
          <option value="<?=$arryJobTitle[$i]['attribute_value']?>" <?  if($arryJobTitle[$i]['attribute_value']==$arryVacancy[0]['JobTitle']){echo "selected";}?>>
          <?=$arryJobTitle[$i]['attribute_value']?>
          </option>
          <? } ?>
        </select>		</td>
      </tr>	

<tr>
        <td  align="right"   class="blackbold"> Vacancy Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="Name" type="text" class="inputbox" id="Name" value="<?php echo stripslashes($arryVacancy[0]['Name']); ?>"  maxlength="40" />            </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" valign="top"> Department  :<span class="red">*</span> </td>
        <td   align="left" >

<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','');">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryVacancy[0]['Department']){echo "selected";}?>>
 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
  </option>
  <? } ?>
</select></td>
      </tr>

	   <tr>
        <td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Hiring Manager  :<span class="red">*</span></div> </td>
        <td  align="left" >
		<div id="EmpValue"></div> <input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryVacancy[0]['HiringManager']?>" /><input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
						
		</td>
      </tr>
	 
	 <tr>
          <td align="right"  class="blackbold" valign="top">Description  :</td>
          <td  align="left" >
            <textarea name="Description" class="textarea" id="Description"  maxlength="250"><?=stripslashes($arryVacancy[0]['Description'])?></textarea>			          </td>
        </tr>



	 <tr>
          <td align="right"   class="blackbold"> Qualification  :</td>
          <td align="left" >
		<select name="Qualification" class="inputbox" id="Qualification"  onchange="Javascript:ShowOther('Qualification');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryQualification);$i++) {?>
			<option value="<?=$arryQualification[$i]['attribute_value']?>" <?  if($arryQualification[$i]['attribute_value']==$arryVacancy[0]['Qualification']){echo "selected";}?>>
			<?=$arryQualification[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryVacancy[0]['Qualification']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="QualificationSpan">&nbsp;&nbsp;<input  name="OtherQualification" id="OtherQualification" value="<?=stripslashes($arryVacancy[0]['OtherQualification'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('Qualification');</script>
		  
		  
		  </td>
  </tr> 


	   <tr>
       <td align="right" class="blackbold">Skill :</td>
       <td  align="left"><input name="Skill" type="text" class="inputbox" id="Skill" value="<?php echo stripslashes($arryVacancy[0]['Skill']); ?>"  maxlength="40" /></td>
     </tr>
     <tr>
        <td align="right" class="blackbold">Number of Position  :<span class="red">*</span></td>
        <td  align="left">
	 <input name="NumPosition" type="text" class="textbox" id="NumPosition" value="<?=stripslashes($arryVacancy[0]['NumPosition'])?>"   size="3"  maxlength="3" onkeypress="return isNumberKey(event);" />			</td>
      </tr>	

        <tr>
          <td align="right"  class="blackbold">Experience :<span class="red">*</span> </td>
          <td  align="left" >
		  
	<select name="MinExp" class="textbox" id="MinExp">
		<option value="">--- Min ---</option>
		<? for($i=0;$i<=30;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryVacancy[0]['MinExp']!=''  && $arryVacancy[0]['MinExp'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>  &nbsp;&nbsp;To&nbsp;&nbsp;	  
		  
	<select name="MaxExp" class="textbox" id="MaxExp">
	<option value="">--- Max ---</option>
		<? for($i=0;$i<=30;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryVacancy[0]['MaxExp']!=''  && $arryVacancy[0]['MaxExp'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>		  </td>
        </tr>
        <tr>
          <td align="right"  class="blackbold">Age :<span class="red">*</span> </td>
          <td  align="left" >
		  
		<select name="MinAge" class="textbox" id="MinAge">
		<option value="">--- Min ---</option>
		<? for($i=21;$i<=60;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryVacancy[0]['MinAge']!=''  && $arryVacancy[0]['MinAge'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>   &nbsp;&nbsp;To&nbsp;&nbsp;	  
		  
	<select name="MaxAge" class="textbox" id="MaxAge">
	<option value="">--- Max ---</option>
		<? for($i=21;$i<=60;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryVacancy[0]['MaxAge']!=''  && $arryVacancy[0]['MaxAge'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>		  </td>
        </tr>
        <tr>
         <td align="right"  class="blackbold">Salary (<?=$Config['Currency']?>) : </td>
          <td  align="left" >
		  <select name="MinSalary" class="textbox" id="MinSalary" >
		<option value="">--- Min ---</option>
		<option value="0.5" <? if($arryVacancy[0]['MinSalary'] == '0.5') echo 'selected';?>> 0.5 </option>	 
		<? for($i=1;$i<=50;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryVacancy[0]['MinSalary'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select>	
	 &nbsp;&nbsp;To&nbsp;&nbsp;
	<select name="MaxSalary" class="textbox" id="MaxSalary" >
		<option value="">--- Max ---</option>
		<? for($i=2;$i<=50;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryVacancy[0]['MaxSalary'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
		<option value="50+" <? if($arryVacancy[0]['MaxSalary'] == '50+') echo 'selected';?>> 50+ </option>	 
     </select>	
	
		  <?=IN_LAKH_ANNUM?>		  </td>
        </tr>
        
         
	<tr>
         <td align="right"  class="blackbold">Exceptional Approval : </td>
          <td  align="left" >
		  <input type="checkbox" name="Exceptional" value="1" <? if($arryVacancy[0]['Exceptional'] == 1) echo 'checked';?>/>		  </td>
        </tr>
      <? if($arryVacancy[0]['PostedDate']>0){  ?>
  <tr>
        <td  align="right"   > Posted Date :  </td>
        <td   align="left" >
		<? 
		   echo date($Config['DateFormat'], strtotime($arryVacancy[0]['PostedDate']));
	   ?>

        </td>
      </tr>
	  <? } ?>



<? if($_SESSION['AdminType'] == "admin"){ ?>	
<tr>
        <td  align="right"   class="blackbold" 
		>Status  :<span class="red">*</span> </td>
        <td   align="left"  >
          <select name="Status" class="textbox" id="Status">
		  			<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryVacancyStatus);$i++) {?>
						<option value="<?=$arryVacancyStatus[$i]['attribute_value']?>" <?  if($arryVacancyStatus[$i]['attribute_value']==$arryVacancy[0]['Status']){echo "selected";}?>>
						<?=$arryVacancyStatus[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select>		   </td>
      </tr>
<? }else{ ?>
<input type="hidden" name="Status" id="Status" value="<?=$arryVacancy[0]['Status']?>" />

<? } ?>
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="vacancyID" id="vacancyID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="OldStatus" id="OldStatus" value="<?=$arryVacancy[0]['Status']?>" />



<input type="hidden" name="HiringManager" id="HiringManager" value="<?=$arryVacancy[0]['HiringManager']?>" />


</div>

</td>
   </tr>
   </form>
</table>
<script language="javascript">
EmpListSend('','');
</script>


