<?
	$arryJobTitle = $objCommon->GetAttributeValue('JobTitle','');
	$arryJobType = $objCommon->GetAttributeValue('JobType','');

?>
<div id="join_form_div" style="display:none;">



<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formJoin" action="" method="post"  enctype="multipart/form-data" onSubmit="return validateJoin(this);">
		<tr>
		  <td >
		   <div class="had2">Join Candidate</div>
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>
                      <td width="45%" align="right"  class="blackbold">
					 Candidate :
					  </td>
                      <td align="left" >
						<div id="CandidateDt"></div>
					  </td>
                    </tr>
					
					<tr>
                      <td  align="right"   class="blackbold"> 
						Date :
					  </td>
                      <td  align="left" >
					  <?=date($Config['DateFormat'], strtotime($Config['TodayDate']))?>
					  </td>
                    </tr>
					
					<tr>
                      <td  align="right"   class="blackbold"> 
						Joining Date :<span class="red">*</span>
					  </td>
                      <td  align="left" >
						
<script type="text/javascript">
$(function() {
	$('#JoiningDate').datepicker(
		{
		showOn: "both", 
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+2?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value=""  type="text" >					
						
					  </td>
                    </tr>	
					<tr>
                      <td  align="right"   class="blackbold" > 
						Department :<span class="red">*</span>
					  </td>
                      <td  align="left" >
<select name="Department" class="inputbox" id="Department">
  <option value="">--- Select ---</option>
  <? 
$Department = (!empty($arryEmployee[0]['Department']))?($arryEmployee[0]['Department']):('');
for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$Department){echo "selected";}?>>
  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
  </option>
  <? } ?>
</select>
					  </td>
                    </tr>	
                  <tr>
                      <td  align="right"   class="blackbold" > 
						Designation :<span class="red">*</span>
					  </td>
                      <td  align="left" >
		<select name="JobTitle" class="inputbox" id="JobTitle">
          <option value="">--- Select ---</option>
          <?
$JobTitle = (!empty($arryEmployee[0]['JobTitle']))?($arryEmployee[0]['JobTitle']):('');
 for($i=0;$i<sizeof($arryJobTitle);$i++) {?>
          <option value="<?=$arryJobTitle[$i]['attribute_value']?>" <?  if($arryJobTitle[$i]['attribute_value']==$JobTitle){echo "selected";}?>>
          <?=$arryJobTitle[$i]['attribute_value']?>
          </option>
          <? } ?>
        </select>
					  </td>
                    </tr>	
				   <tr>
                      <td  align="right"   class="blackbold" > 
						Job Type :<span class="red">*</span>
					  </td>
                      <td  align="left" >
						 <select name="JobType" class="inputbox" id="JobType">
		<option value="">--- Select ---</option>
		<? 
$JobType = (!empty($arryEmployee[0]['JobType']))?($arryEmployee[0]['JobType']):('');
for($i=0;$i<sizeof($arryJobType);$i++) {?>
			<option value="<?=$arryJobType[$i]['attribute_value']?>" <?  if($arryJobType[$i]['attribute_value']==$JobType){echo "selected";}?>>
			<?=$arryJobType[$i]['attribute_value']?>
			</option>
		<? } ?>
	</select>
					  </td>
                    </tr>	 
				   
				   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		
		<tr>
				<td align="center" >
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Send " />
	<input type="hidden" name="JoinCanID" id="JoinCanID" value="" />
	<input type="hidden" name="TodayDate" id="TodayDate" value="<?=$Config['TodayDate']?>" />
	
	
				  </td>
		  </tr>
		
	    </form>
</TABLE>
</div>

<script language="JavaScript1.2" type="text/javascript">
function SetJoinForm(CanID,UserName,Email,JoiningDate){
	var CandidateDt = 	UserName + '&nbsp;&nbsp;&nbsp;[<a href="mailto:'+Email+'">'+Email+'</a>]' ;
	document.getElementById("JoiningDate").value = JoiningDate;
	document.getElementById("JoinCanID").value = CanID;
	document.getElementById("CandidateDt").innerHTML = CandidateDt;
}

function validateJoin(frm){
	if(ValidateForSelect(frm.JoiningDate, "Joining Date")
		&& ValidateForSelect(frm.Department, "Department")
		&& ValidateForSelect(frm.JobTitle, "Designation")
		&& ValidateForSelect(frm.JobType, "Job Type")
		){

				$.fancybox.close();
				ShowHideLoader('1','P');

				return true;						
		}else{
				return false;	
		}			
}

</script>
