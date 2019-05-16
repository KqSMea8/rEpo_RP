<SCRIPT LANGUAGE=JAVASCRIPT>
function SetRuleValue(){
	var NumLine = parseInt($("#NumLine").val());
	for(var i=1;i<=NumLine;i++){
		var RuleOn = document.getElementById("RuleOn"+i).value;

		$("#RuleValue"+i).show();
		if(RuleOn=='J'){
			$("#RuleCalDiv"+i).show();
			$("#RuleValue"+i).hide();
			$("#RuleUnit"+i).hide();
		}else if(RuleOn=='P' || RuleOn=='E' ){
			$("#RuleUnit"+i).show();
			$("#RuleCalDiv"+i).hide();
		}else if(RuleOn=='H'){
			$("#RuleUnit"+i).val("Hrs");
			$("#RuleUnit"+i).hide();
			$("#RuleCalDiv"+i).hide();
		}else if(RuleOn=='D' || RuleOn=='C'){
			$("#RuleUnit"+i).val("Days");
			$("#RuleUnit"+i).hide();
			$("#RuleCalDiv"+i).hide();
		}else{
			$("#RuleUnit"+i).hide();
			$("#RuleCalDiv"+i).hide();
			$("#RuleValue"+i).val('');
		}
	}
}

function ValidateForm(frm){

		var NumLine = parseInt($("#NumLine").val());

		if( ValidateForSelect(frm.JobType, "Job Type")  
		&& ValidateForSimpleBlank(frm.Heading, "Rule Heading")
		//&& ValidateForSelect(frm.RuleOn, "Rule Column")
		//&& ValidateForSelect(frm.RuleOpp, "Rule Operator")
		//&& ValidateForSimpleBlank(frm.RuleValue, "Rule Value")
		){	
			


			for(var i=1;i<=NumLine;i++){
				/****************************/
				for(var j=i+1;j<=NumLine;j++){
					if(document.getElementById("RuleOn"+i).value != ''){
						if(document.getElementById("RuleOn"+i).value == document.getElementById("RuleOn"+j).value){
						alert("Duplicate Rule Column.");
						document.getElementById("RuleOn"+j).focus();
						return false;	
						}
					}
				}
				/****************************/
				if(document.getElementById("RuleOn"+i).value != ''){
					if(!ValidateForSelect(document.getElementById("RuleOpp"+i), "Rule Operator")){
						return false;
					}

					if(document.getElementById("RuleOn"+i).value == 'J'){
						if(!ValidateForSelect(document.getElementById("RuleValueCal"+i), "Rule Value")){
							return false;
						}
					}else{
						if(!ValidateForSimpleBlank(document.getElementById("RuleValue"+i), "Rule Value")){
							return false;
						}
					}			

				}
			}
			






				
			/**********************/
			var DataExist=0;
			DataExist = CheckExistingData("isRecordExists.php", "&LeaveRuleHeading="+escape(document.getElementById("Heading").value)+"&editID="+document.getElementById("RuleID").value, "Heading","Rule Heading");
			if(DataExist==1)return false;
			/**********************
			var DataExist=0;
			DataExist = CheckExistingData("isRecordExists.php", "&LeaveRuleColumn="+escape(document.getElementById("RuleOn").value)+"&RuleOpp="+escape(document.getElementById("RuleOpp").value)+"&RuleValue="+escape(document.getElementById("RuleValue").value)+"&editID="+escape(document.getElementById("RuleID").value), "RuleValue","Rule");
			if(DataExist==1)return false;
			/**********************/
			ShowHideLoader('1','S');
			return true;

			
		}else{
			return false;	
		}
		
}

</SCRIPT>
  <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$MainModuleName?> &raquo; <span>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_rule'])) {echo $_SESSION['mess_rule']; unset($_SESSION['mess_rule']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" >
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">

	<tr>
                      <td align="right"  class="blackbold">
					Job Type :<span class="red">*</span>
					  </td>
                      <td>

<select name="JobType" class="inputbox" id="JobType">
	  <option value="">--- Select ---</option>
	  <? for($i=0;$i<sizeof($arryJobType);$i++) {?>
	  <option value="<?=stripslashes($arryJobType[$i]['attribute_value'])?>" <?  if(stripslashes($arryJobType[$i]['attribute_value'])==stripslashes($arryCustomRule[0]['JobType'])){echo "selected";}?>>
	 <?=stripslashes($arryJobType[$i]['attribute_value'])?>
	  </option>
	  <? } ?>
</select>

					  </td>
                    </tr>



                    <tr>
                      <td width="25%"  align="right" valign="top"   class="blackbold">
					   Rule Heading :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="Heading" id="Heading" value="<?=stripslashes($arryCustomRule[0]['Heading'])?>" type="text" class="inputbox" maxlength="40" onkeypress="return isAlphaKey(event);"/>  
					    </td>
                    </tr>
                    
		<!--tr >
                      <td align="right" valign="top"  class="blackbold" > Description : </td>
                      <td align="left" valign="top">
<input  name="Detail" id="Detail" value="<?=stripslashes($arryCustomRule[0]['Detail'])?>" type="text" class="inputbox" maxlength="200" /> 

					  
					  </td>
                    </tr-->

	



		  <tr >
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
<input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> />&nbsp;Active
&nbsp;&nbsp;&nbsp;
<input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" />&nbsp;Inactive
                                                  </td>
                    </tr>




<tr >
<td align="right" valign="top"  class="blackbold" >Rule :
</td>
<td align="left" valign="top"   >


 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<tr>
	<td class="heading" width="30%">Column</td>
	<td class="heading" width="30%">Operator</td>
	<td class="heading">Value</td>
</tr>


<? 
$styleTxt ='style="width:140px;"';

for($Line=1;$Line<=$NumLine;$Line++){
echo '<tr class="itembg">';

if($_GET['edit']>0){
	$RuleOnArry = explode("#", $arryCustomRule[0]['RuleOn']);
	$RuleOppArry = explode("#", $arryCustomRule[0]['RuleOpp']);
	$RuleValueArry = explode("#", $arryCustomRule[0]['RuleValue']);
	$RuleUnitArry = explode("#", $arryCustomRule[0]['RuleUnit']);
}
$Count = $Line-1;

$RuleOnTd = '<td><select name="RuleOn[]" id="RuleOn'.$Line.'" class="textbox"  '.$styleTxt.' onchange="Javascript:SetRuleValue();"><option value="">--- Select ---</option>';
for ($i = 0; $i < sizeof($RuleOn); $i++) { 
	$sel=''; 
    	if(!empty($RuleOnArry[$Count])){
		$sel = ($RuleOn[$i]["col_value"] == $RuleOnArry[$Count]) ? ('selected') : ('');
	}
    $RuleOnTd .=  '<option value="' .$RuleOn[$i]["col_value"] . '" ' . $sel . '>' . $RuleOn[$i]["col_name"] . '</option>';
}
$RuleOnTd .=  '</select></td>';   
    

$RuleOppTd =  '<td><select name="RuleOpp[]" id="RuleOpp'.$Line.'" class="textbox" '.$styleTxt.'><option value="">--- Select ---</option>';
for ($i = 0; $i < sizeof($RuleOpp); $i++) {  
	$sel=''; 
    	if(!empty($RuleOppArry[$Count])){
   		 $sel = ($RuleOpp[$i]["col_value"] == $RuleOppArry[$Count]) ? ('selected') : ('');
	}
    $RuleOppTd .=  '<option value="' .$RuleOpp[$i]["col_value"] . '" ' . $sel . '>' . $RuleOpp[$i]["col_name"] . '</option>';
}
$RuleOppTd .= '</select></td>';  

$selDays =$selHrs ='';
if(!empty($RuleUnitArry[$Count])){
	$selDays = ($RuleUnitArry[$Count]=="Days") ? ('selected') : ('');
	$selHrs = ($RuleUnitArry[$Count]=="Hrs") ? ('selected') : ('');
}




$RuleValue=''; $RuleValueCal='';
if(!empty($RuleOnArry[$Count])){
	if($RuleOnArry[$Count]=='J'){
	 	$RuleValueCal = stripslashes($RuleValueArry[$Count]);
	}else{
		$RuleValue = stripslashes($RuleValueArry[$Count]);
	}
}

$RuleValueTd =  '<td>
<input  name="RuleValue[]" id="RuleValue'.$Line.'" value="'.$RuleValue.'" type="text" class="textbox" style="width:60px;" maxlength="5" onkeypress="return isNumberKey(event);"/> 
<select name="RuleUnit[]" id="RuleUnit'.$Line.'" class="textbox">
	<option value="Days" ' . $selDays . '>Days</option>
	<option value="Hrs" ' . $selHrs . '>Hrs</option>
</select>';



 $FieldName = 'RuleValueCal'.$Line;	
 ?>				
<script type="text/javascript">
$(function() {
	$('#<?=$FieldName?>').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-30?>:<?=date("Y")?>', 
		changeMonth: true,
		changeYear: true

		}
	);

	$('#<?=$FieldName?>').on("click", function () { 
			 $(this).val("");
		}
	);

});
</script>


<?
$RuleValueTd .=  '<div id="RuleCalDiv'.$Line.'"><input id="'.$FieldName.'" name="RuleValueCal[]" readonly="" class="datebox"  value="'.$RuleValueCal.'"  type="text" > </div>';

$RuleValueTd .=  '</td>';






echo $RuleOnTd.$RuleOppTd.$RuleValueTd;
echo '</tr>';
}
?>



<tr>
	<td class="heading" align="right">Leave Type</td>
	<td class="heading" colspan="2">Days</td>
</tr>

<?
if(!empty($arryCustomRule[0]['LeaveAllowed'])){
	$LeaveAllowedArry = explode("#", $arryCustomRule[0]['LeaveAllowed']);
	foreach($LeaveAllowedArry as $val){
		$innerArry = explode(":", $val);
		$arryFinalLeave[$innerArry[0]] = $innerArry[1];
	}
}


for($i=0;$i<sizeof($arryLeaveType);$i++) {					
	$LeaveType = stripslashes($arryLeaveType[$i]['attribute_value']);
	$LineDays = $i+1;
	$LvDays='';
	if(!empty($arryFinalLeave[$LeaveType])) $LvDays = $arryFinalLeave[$LeaveType];
?>
<tr class='itembg'>
  <td align="right" ><?=$LeaveType?> :</td>
  <td align="left"  colspan="2">
<input id="Days<?=$LineDays?>" name="Days[]"  class="textbox" size="3" value="<?=$LvDays?>"  type="text" maxlength="2" onkeypress="return isDecimalKey(event);"> 
<input id="LeaveType<?=$LineDays?>" name="LeaveType[]" value="<?=$LeaveType?>"  type="hidden" readonly>
   </td>
</tr>
<? } ?>




	</table>
</td>

</tr>




                 
                  </table>
		  
		  
		  </td>
	    </tr>











		<tr>
				<td align="center" valign="top"><br>
			<? if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="RuleID" id="RuleID" value="<?=$_GET['edit']?>">  

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
	
	<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>">   
		  
				  
				  
				  </td>
		  </tr>
	    </form>
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>
SetRuleValue();
</SCRIPT>
