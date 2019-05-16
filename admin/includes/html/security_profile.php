<? require_once("includes/html/box/security_level.php");  ?>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	 var NumLine  = document.getElementById("NumLine").value;
	 var selects = document.getElementsByTagName('select');
	 var values = [];
	
	
	    for(i=0;i<selects.length;i++) {
	        var select = selects[i];
	        if(values.indexOf(select.value)>-1) {
	            alert('Please do not select duplicate question!'); 
                select.focus();
	            return false;
	        }
	        else 
	            values.push(select.value);
	    }

	for(i=1;i<=NumLine;i++){
 		if(!ValidateForSimpleBlank(document.getElementById("Answer"+i),"Answer")){
			return false;
		}	
	}
	
	ShowHideLoader(1,'P');
	return true;
}

</script>


 

<div class="had_big">Modify Secure Access Profile</div>
<div class="message"><? if(!empty($_SESSION['mess_question'])) {
echo $_SESSION['mess_question']; unset($_SESSION['mess_question']);

echo '<br><a href="security1.php">Click here to go to security authentication page.</a>';

 }?></div>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" method="post" onSubmit="return validateForm(this);">
	<tr>
		<td align="center" height="50" >&nbsp;</td>
			</tr>


	<tr>
		<td align="center" valign="top">
		
		<table width="80%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
<tr>
				<td colspan="2" align="left" class="head">Setup Security Questions & Answers </td>
			</tr>
	<tr>
				<td colspan="2" align="left"  > &nbsp;</td>
			</tr>
		
		<?php
		$NumLine=0;
		for($i=1;$i<=$MaxQuestion;$i++){
		$NumLine++;
		?>
			<tr>

                <td width="50%" align="right" valign="middle">
                <?php if($i==1){ $SelectedQuestion = $arryQuestion['0']['QuestionID'];}elseif($i == 2){ $SelectedQuestion = $arryQuestion['1']['QuestionID'];}elseif($i == 3){ $SelectedQuestion = $arryQuestion['2']['QuestionID'];}elseif($i == 4){ $SelectedQuestion = $arryQuestion['3']['QuestionID'];}elseif($i == "5"){ $SelectedQuestion = $arryQuestion['4']['QuestionID'];}else{ exit; } ?>


			<select name="QuestionUser[]" class="textbox" style="width:350px;" id="Question<?=$NumLine?>">
			
			<?php 
			for($j=0;$j<sizeof($arryQuestion);$j++){?>
				
			<option value="<?=$arryQuestion[$j]['QuestionID']?>"
	
			<?php if($arryQuestion[$j]['QuestionID'] == $SelectedQuestion){echo "selected='selected'";}?>><?php echo $arryQuestion[$j]['Question'];?>
		
			</option>
			
			<?php } ?>
			</select>
			</td>
                
                <td >
<input name="Answer[]" id="Answer<?=$NumLine?>"  class="inputbox" value=""  type="text" >  
</td>


                
           </tr>
		<?php } ?>
		
			
      
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


