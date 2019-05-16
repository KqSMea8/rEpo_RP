
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


 

<div class="had_big">Security Authentication Step 1 of <?=$NumSecurity?></div>
<div class="message"><? if(!empty($_SESSION['mess_question'])) {echo $_SESSION['mess_question']; unset($_SESSION['mess_question']); }?></div>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" method="post" onSubmit="return validateForm(this);">
	<tr>
		<td align="center" height="50" >&nbsp;</td>
			</tr>

	<tr>
		<td align="center" >
		
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
 
<input name="Answer<?=$NumLine?>" id="Answer<?=$NumLine?>" type="text" class="inputbox"   value="" maxlength="200"/>


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


