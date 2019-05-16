<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	if( ValidateForSimpleBlank(frm.Question, "Security Question")
     // && ValidateForSelect(frm.ColumnName, "Answer Column")
){
				
				var Url = "isRecordExists.php?Question="+escape(document.getElementById("Question").value)+"&editID="+document.getElementById("QuestionID").value;
				SendExistRequest(Url, "Question", "Question");
				return false;	
			}else{
				return false;	
		}			
}
</script>

 <a href="<?= $ListUrl ?>" class="back">Back</a> 
		   <div class="had">Manage Security Question  <span> &raquo;
		<? 
		$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add  ");
		echo $MemberTitle.$ModuleName;
		?>
		</span>
		</div>
		<div class="message" align="center"><? if(!empty($_SESSION['mess_question'])) {echo $_SESSION['mess_question']; unset($_SESSION['mess_question']); }?>
		</div>

	<form name="form1" action="" method="post" onsubmit="return validateForm(this);">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		      <tr>
			    <td align="center" valign="top">
		    <table width="100%" border="0" cellpadding="0" cellspacing="0">
		      <tr>
			    <td align="center" valign="middle">
			    
				
			   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">			
				<tr>
			      <td align="center" valign="top">
				    <table width="100%" border="0" cellpadding="5" cellspacing="1">
						       
				       <tr>
					        <td width="45%"  align="right"   class="blackbold" width="45%">Security Question  :<span class="red">*</span> </td>
					        <td   align="left" >
					<input name="Question" type="text" class="textbox" id="Question" value="<?php if(!empty($arryeditQuestion[0]['Question']))echo stripslashes($arryeditQuestion[0]['Question']); ?>" size="80" maxlength="200"   onKeyPress="Javascript:return isAlphaKey(event);"/>            </td>
			      </tr>
			
					<!--tr>
						<td  align="right"   class="blackbold"> Answer Column  :<span class="red">*</span> </td>
						<td  valign="top" align="left">		  
						<select name="ColumnName" class="inputbox" id="ColumnName" style="width:200px;" >
						<option value="">---Select---</option>
				<?
if(!empty($OptionArray)){
foreach($OptionArray as $values){
	$sel = ($arryeditQuestion[0]['ColumnName']==$values['value'])?('selected'):('');
	echo '<option value="'.$values['value'].'" '.$sel.'>'.$values['label'].'</option>';

}
}
?>			 
						</select> 
						</td>
					</tr-->              
			             <tr>
				       <td align="right" valign="middle" class="blackbold">Status :</td>
					   <td align="left" class="blacknormal">
							<table width="151" border="0" cellpadding="0" cellspacing="0" class="blacknormal margin-left">
							<tr>
								<td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($QuestionStatus == "1") ? "checked" : "" ?> /></td>								
								<td width="48" align="left" valign="middle">Active</td>
						        <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($QuestionStatus == "0") ? "checked" : "" ?> value="0" /></td>
						        <td width="63" align="left" valign="middle">Inactive</td>
						    </tr>
							</table>
						  </td>
					  </tr>
							  </table>
					</td>
				</tr>
			                     </table>
					     </td>
				          </tr>
					    <tr>
					     <td  align="center">
					
					<div id="SubmitDiv" style="display:none1">
					
					<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
					      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
					
					<input type="hidden" name="QuestionID" id="QuestionID" value="<?=$_GET['edit']?>" />
					
					</div>
					
					     </td>
					   </tr>
		
				</table>
					</td>
				</tr>
		</table>
		</form>
