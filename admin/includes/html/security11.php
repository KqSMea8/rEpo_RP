
<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine  = document.getElementById("NumLine").value;
	var QuestionLabel = '';
	
	for(i=1;i<=NumLine;i++){
		QuestionLabel = ' :: ' +document.getElementById("QuestionLabel"+i).innerHTML;
 		if(!ValidateForSimpleBlank(document.getElementById("Answer"+i), QuestionLabel)){
			return false;
		}	
	}
	ShowHideLoader(1,'P');
}

</script>


 

<div class="had">Security Authentication Step 1 of <?=$NumSecurity?></div>
<div class="message"><? if(!empty($_SESSION['mess_question'])) {echo $_SESSION['mess_question']; unset($_SESSION['mess_question']); }?></div>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" method="post" onSubmit="return validateForm(this);">
	<tr>
		<td align="center" valign="top">
		
		<table width="80%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
	<tr>
				<td colspan="2" align="left"  > &nbsp;</td>
			</tr>
		
		<? 
		$NumLine=0;
		foreach($arryQuestion as $key=>$values){ 
		$NumLine++;

		?>	 
		<tr>
			<td width="45%" align="right" height="35"  class="blackbold"> <span  id="QuestionLabel<?=$NumLine?>"><?=stripslashes($values['Question'])?></span> : 

<input name="QuestionID<?=$NumLine?>" type="hidden"  value="<?=$values['QuestionID']?>"  readonly>
</td>
			


			 
			<td align="left" valign="middle">
 


<? if($values['ColumnName']=='date_of_birth#h_employee'){ ?>

<script>
$(function() {
$( "#Answer<?=$NumLine?>" ).datepicker({ 
	showOn: "both",
	yearRange: '1930:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	maxDate: "-1D", 
	changeMonth: true,
	changeYear: true
	});
});
</script>
<input name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" readonly="" class="datebox" value=""  type="text" >  

<? }else if($values['ColumnName']=='ImmigrationExp#h_employee'){ ?>

  <script>
$(function() {
$( "#Answer<?=$NumLine?>" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
	dateFormat: 'dd-mm-yy', 
	changeMonth: true,
	changeYear: true
	});

 });
</script>

<input name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" readonly="" class="datebox" value=""  type="text" >  
		

<? }else if($values['ColumnName']=='MaritalStatus#h_employee'){ ?>

<select name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" class="inputbox"   >
		<option value="">--- Select ---</option>
      <option value="Single" <?  if($arryEmployee[0]['MaritalStatus']=="Single"){echo "selected";}?>> Single </option>
      <option value="Married" <?  if($arryEmployee[0]['MaritalStatus']=="Married"){echo "selected";}?>> Married </option>
      <option value="Other" <?  if($arryEmployee[0]['MaritalStatus']=="Other"){echo "selected";}?>> Other </option>
    </select>


<? }else if($values['ColumnName']=='Nationality#h_employee'){ ?>

 	<select name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" class="inputbox"   >
			<option value="">--- Select ---</option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['name']?>" <?  if($arryCountry[$i]['name']==$arryEmployee[0]['Nationality']){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>


<? }else if($values['ColumnName']=='BloodGroup#h_employee'){ ?>

	<select name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" class="inputbox"   >
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryBloodGroup);$i++) {?>
				<option value="<?=$arryBloodGroup[$i]['attribute_value']?>" <?  if($arryBloodGroup[$i]['attribute_value']==$arryEmployee[0]['BloodGroup']){echo "selected";}?>>
				<?=$arryBloodGroup[$i]['attribute_value']?>
				</option>
				<? } ?>         
            </select>


<? }else if($values['ColumnName']=='UnderGraduate#h_employee'){ ?>

	<select name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" class="inputbox"   >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryUnderGraduate);$i++) {?>
			<option value="<?=$arryUnderGraduate[$i]['attribute_value']?>" <?  if($arryUnderGraduate[$i]['attribute_value']==$arryEmployee[0]['UnderGraduate']){echo "selected";}?>>
			<?=$arryUnderGraduate[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['UnderGraduate']=="Other"){echo "selected";}?>>Other</option>
	</select> 
<? }else if($values['ColumnName']=='ImmigrationType#h_employee'){ ?>
	<select name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" class="inputbox"   >
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryImmigrationType);$i++) {?>
				<option value="<?=$arryImmigrationType[$i]['attribute_value']?>" <?  if($arryImmigrationType[$i]['attribute_value']==$arryEmployee[0]['ImmigrationType']){echo "selected";}?>>
				<?=$arryImmigrationType[$i]['attribute_value']?>
				</option>
				<? } ?>         
            </select>

<? }else if($values['ColumnName']=='Gender#h_employee'){ ?>

	<select name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" class="textbox"   >
		<option value="">--- Select ---</option>
		<option value="Male"  > Male </option>
		<option value="Female"  > Female </option>
	</select>
<? }else{ ?>
<input name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" type="text" class="inputbox"   value="" maxlength="200"/>
<? } ?>




</td>
		</tr>

		<? } ?>

      
		<tr>
				<td colspan="2" align="left"  > &nbsp;</td>
			</tr>		
		   
		</table>
	  </td>
	</tr>
	  <tr>
			<td colspan=2 align="center">
			    <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
			     <input name="NumLine" type="hidden" id="NumLine" value="<?=$NumLine?>" />
			</td>
		   </tr>
  </form>
</table>


