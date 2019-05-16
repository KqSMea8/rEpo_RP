<script language="JavaScript1.2" type="text/javascript">
function validateCandidate(frm){
	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSelect(frm.Vacancy,"Job Vacancy")
		&& ValidateRadioButtons(frm.Gender, "Gender")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSelect(frm.date_of_birth,"Date of Birth")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		&& ValidatePhoneNumber(frm.Mobile,"Contact Number",10,20)
		&& ValidateForSimpleBlank(frm.Address,"Address")
		&& isZipCode(frm.ZipCode)
		&& ValidateOptionalUpload(frm.Image, "Image")
		&& ValidateOptionalDoc(frm.Resume,"Resume")
		&& ValidateForSelect(frm.ApplyDate,"Apply Date")
		&& ValidateForSelect(frm.ExperienceYear,"Total Years of Experience")
		&& ValidateForSelect(frm.ExperienceMonth,"Total Months of Experience")
		&& ValidateMandDecimalField(frm.Salary,"Current Salary")
		&& ValidateForSelect(frm.InterviewStatus ,"Interview Stage")
		){
					
				var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("CanID").value+"&Type=Candidate";
				SendExistRequest(Url,"Email", "Email Address");
				return false;						
			}else{
				return false;	
		}			
}
</script>

<? 
if($numVacancy>0 || $_GET['edit']>0){ ?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCandidate(this);" enctype="multipart/form-data">
   <tr>
    <td  align="center" valign="top" >
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="left"   class="head" colspan="2">Candidate Detail</td>
      
      </tr>
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
	     <td  align="right"  class="blackbold" >Gender :<span class="red">*</span> </td>
	     <td   align="left" >
		 
		 
          <input type="radio" name="Gender" id="Gender" value="Male" <?=($arryCandidate[0]['Gender']=="Male")?("checked"):("");?>/>
          Male&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Gender" id="Gender" value="Female"  <?=($arryCandidate[0]['Gender']=="Female")?("checked"):("");?>  />
          Female		 </td>
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
        <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#date_of_birth').datepicker(
		{
		showOn: "both",
		yearRange: '1930:<?=date("Y")?>', 
		dateFormat: 'yy-mm-dd',
		maxDate: "-1D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="date_of_birth" name="date_of_birth" readonly="" class="datebox" value="<?=$arryCandidate[0]['date_of_birth']?>"  type="text" >         </td>
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
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" class="textarea" id="Address" maxlength="250" ><?=stripslashes($arryCandidate[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?
	if(!empty($arryCandidate[0]['country_id'])){
		$CountrySelected = $arryCandidate[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCandidate[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCandidate[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryCandidate[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       	

	<tr>
    <td  align="right" height="30"   class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"   valign="top">
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

<? 
$MainDir = "upload/candidate/".$_SESSION['CmpID']."/";
if($arryCandidate[0]['Image'] !='' && file_exists($MainDir.$arryCandidate[0]['Image']) ){ ?>
				
	<div  id="ImageDiv"><a href="<?=$MainDir.$arryCandidate[0]['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=$arryCandidate[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=150&h=150&img='.$MainDir.$arryCandidate[0]['Image'].'" border=0 >';?></a>
	
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryCandidate[0]['Image']?>','ImageDiv')"><?=$delete?></a>	</div>
<?	} ?>
	
		</td>
  </tr>	  


<tr>
    <td height="30" align="right" valign="top"   class="blackbold" >  Resume   :</td>
    <td  align="left" valign="top" >
	
	<input name="Resume" type="file" class="inputbox" id="Resume" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	
	<? 
        $MainDir = "upload/resume_cand/".$_SESSION['CmpID']."/";
        if($arryCandidate[0]['Resume'] !='' && file_exists($MainDir.$arryCandidate[0]['Resume']) ){ ?><br><br>
	<div id="ResumeDiv">
	<?=stripslashes($arryCandidate[0]['Resume'])?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryCandidate[0]['Resume']?>" title="<?=$arryCandidate[0]['Resume']?>" class="download">Download</a>
&nbsp;
	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryCandidate[0]['Resume']?>','ResumeDiv')"><?=$delete?></a>
	<br><br>
	</div>
	
<?	} ?>		
	
	</td>
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
        <td align="right"   class="blackbold" >Skill  :</td>
        <td  align="left"  >
	 <input name="Skill" type="text" class="inputbox" id="Skill" value="<?=stripslashes($arryCandidate[0]['Skill'])?>" maxlength="50" />			</td>
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
        <td  align="left"   class="head" colspan="2">Interview Status</td>
      
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

<? if(sizeof($arryInterviewTest)>0){
	$TestTakenArray[]='';
	if(!empty($arryCandidate[0]['TestTaken'])){
		$TestTakenArray = explode(",",$arryCandidate[0]['TestTaken']);
	}
	?>
<tr>
        <td  align="right"   class="blackbold" valign="top" >Test Taken  : </td>
        <td   align="left"  >
          
		  <select name="TestTaken[]" class="textbox" id="TestTaken" style="width:197px; height:80px;" multiple>
				<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryInterviewTest);$i++) {?>
					<option value="<?=$arryInterviewTest[$i]['attribute_value']?>" <?  if(in_array($arryInterviewTest[$i]['attribute_value'],$TestTakenArray)){echo "selected";}?>>
					<?=stripslashes($arryInterviewTest[$i]['attribute_value'])?>
			</option>
				<? } ?>
		</select>
		  
		  
		   </td>
      </tr>
<? } ?>


<? for($i=1;$i<=3;$i++){ ?>
<tr>
        <td  align="right"   class="blackbold">Level-<?=$i?> Interview Taken By  : </td>
        <td   align="left">

<input name="EmpName<?=$i?>" id="EmpName<?=$i?>" type="text" class="disabled" style="width:250px;" value="<?=$arryCandidate[0]['EmpName'.$i]?>" readonly />
<input name="EmpID<?=$i?>" id="EmpID<?=$i?>" type="hidden" class="disabled" value="<?=$arryCandidate[0]['EmpID'.$i]?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="EmpList.php?id=<?=$i?>" ><?=$search?></a>	  
		  
		   </td>
      </tr>

<? } ?>


	 <tr>
        <td align="right"   class="blackbold" >Employee By  :</td>
        <td  align="left"  >


<?
	//For Edit Purpose
/**************************************/
	$return_arr = array();
$_GET['q']='a';
 $fetch = "SELECT e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  department d on e.Department=d.depID  WHERE e.UserName LIKE '%".$_GET['q']."%'  and e.locationID=".$_SESSION['locationID']." ORDER BY e.UserName Asc LIMIT 10"; 
$query=mysql_query($fetch);
$MainDir = "upload/employee/".$_SESSION['CmpID']."/";
while ($row = mysql_fetch_array($query)) {
	
    $row_array['id'] = $row['EmpID'];
    $row_array['name'] =$row['UserName'];
	$row_array['department'] =$row['emp_dep'];
	$row_array['designation'] = $row['JobTitle'];
	
	if($row['Image']==''){
$row_array['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
	}else{
	$row_array['url'] ="resizeimage.php?w=50&h=50&img=".$MainDir.$row['Image']."";
	}
    array_push($return_arr,$row_array);
}

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

//echo $json_response;	//For Edit Purpose
/**************************************/

?>


<script type="text/javascript" src="../multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="../multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="../multiSelect/token-input-facebook.css" type="text/css" />

 
	<input type="text" class="inputbox" id="demo-input-facebook-theme" name="EmpID" />
        
        <script type="text/javascript">
        $(document).ready(function() {
            $("#demo-input-facebook-theme").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				hintText: "Select Taken",
					tokenLimit: "10",
					prePopulate: <?=$json_response?>,
					
				
					propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>[" + item.designation + ", " + item.department + "]</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>[" + item.designation + ", " + item.department + "]</div></div></li>" },

				
            });
        });
        </script> 
	 
	 
	 
	 
	 
	 </td>
      </tr>  


</table>	
  




	
	  
	
	</td>
   </tr>

<? if($numVacancy>0){ ?> 
   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="CanID" id="CanID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryCandidate[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCandidate[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   <? } ?>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
<? }else{ ?>
<div class="message"><?=NO_VACANCY_TO_ADD_CAND?></div>
<? } ?>