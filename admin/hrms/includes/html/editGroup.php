
<script language="JavaScript1.2" type="text/javascript">
function validate(frm){
		if( ValidateForSimpleBlank(frm.group_name, "Group Name")){
			var Url = "isRecordExists.php?group_name="+escape(document.getElementById("group_name").value)+"&editID="+document.getElementById("GroupID").value;
			SendExistRequest(Url,"group_name","Group Name");			
		
			return false;
		}else{
			return false;	
		}
		
}
</script>

<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function() {
    $('#ViewAll').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

    
    $('#ModifyAll').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox2').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox2').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

    
    $('#FullAll').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox3').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox3').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});

</script>


<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">Role Group <span> &raquo; <? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["parent_type"])." Details") :("Add  ".$ModuleName); ?></span>


</div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
<? if (!empty($errMsg)) {?>
	<tr>
		<td height="2" align="center" class="red"><?php echo $errMsg;?></td>
	</tr>
	<? } ?>

	<tr>
		<td align="left" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<form name="form1" action="<?=$ActionUrl?>" method="post"
				onSubmit="return validate(this);" enctype="multipart/form-data"><? if (!empty($_SESSION['mess_group'])) {?>
			<tr>
				<td align="center" class="message"><? if(!empty($_SESSION['mess_group'])) {echo $_SESSION['mess_group']; unset($_SESSION['mess_group']); }?>
				</td>
			</tr>
			<? } ?>

			<tr>
				<td align="center" valign="top">


				<table width="100%" border="0" cellpadding="5" cellspacing="0"
					class="borderall">


					<tr>
						<td colspan="2" align="left" class="head">Group</td>

					</tr>
					<tr>
						<td align="right" width="40%" class="blackbold">Group Name :<span
							class="red">*</span></td>
						<td align="left"><input name="group_name" type="text"
							class="inputbox" id="group_name"
							value="<?php echo stripslashes($arryGroup[0]['group_name']); ?>"
							maxlength="50" /></td>
					</tr>



					<tr>

						<td align="right" class="blackbold">Status :</td>
						<td align="left" class="blacknormal"><input name="Status"
							type="radio" value="1" <?=($GroupStatus==1)?"checked":""?> />Active
						&nbsp;&nbsp;&nbsp;&nbsp;<input name="Status" type="radio"
						<?=($GroupStatus==0)?"checked":""?> value="0" />Inactive</td>

					</tr>

					<tr>

						<td align="right" class="blackbold" valign="top">Description :</td>
						<td align="left"><Textarea name="description" id="description"
							class="textarea" maxlength="250"><? echo stripslashes($arryGroup[0]['description']); ?></Textarea></td>
					</tr>



					<? if(!empty($_GET["edit"])){ ?>

					<tr>
						<td align="right" valign="bottom" colspan="2"><a
							href="javascript:void(0);" id="collapseAll">Collapse All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
							href="javascript:void(0);" id="expandAll">Expand All</a></td>
					</tr>

					<tr>
						<td align="right" valign="top" class="blackbold">
						<div id="PermissionTitle">Allow Permissions :</div>
						</td>
						<td align="left">
						<div id="PermissionValueNew">

						<table width="100%" cellspacing=0 cellpadding=2
							style="background-color: #EFEFEF">
							<tr>
								<td><strong>Module Name</strong></td>
								<td width="20%"><input type="checkbox" name="ViewAll"
									id="ViewAll" /><strong>View</strong></td>
								<td width="20%"><input type="checkbox" name="ModifyAll"
									id="ModifyAll" /><strong>Modify</strong></td>

								<td width="20%"><input type="checkbox" name="FullAll"
									id="FullAll" /><strong>Full</strong></td>


							</tr>
						</table>
						<?

						$Line=0;
						$arryDepartment = $objConfigure->GetDepartment();
						echo '<div id="accordion" >';
						foreach($arryDepartment as $key=>$valuesDept){
							$arrayMainModules = $objRole->getMainModulesGroup($_GET['edit'],0,$valuesDept['depID']);
							if(sizeof($arrayMainModules)>0){


								echo '<h2>'.$valuesDept['Department'].'</h2>';

								echo '<table width="100%" cellspacing=0 cellpadding=0>';
								foreach($arrayMainModules as $key=>$valuesMod){
									$Line++;
									echo '<tr><td height="30">'.stripslashes($valuesMod['Module']).'</td> ';
									?>
						<td width="22%"><input type="checkbox" name="ViewLabel<?=$Line?>"
							id="ViewLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>"
							class="checkbox1"
							<? if(!empty($valuesMod['ViewLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>


						<td width="22%"><input type="checkbox"
							name="ModifyLabel<?=$Line?>" id="ModifyLabel<?=$Line?>"
							class="checkbox2" value="<?=$valuesMod['ModuleID']?>"
							<? if(!empty($valuesMod['ModifyLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>

						<td width="17%"><input type="checkbox" name="FullLabel<?=$Line?>"
							id="FullLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>"
							class="checkbox3"
							<? if(!empty($valuesMod['FullLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>



							<?
							echo '</tr>';
							/*if ($Line % 2 == 0) {
							 echo "</tr><tr>";
							 }*/


								} //end arrayAllModules
									

								echo '</table>';

							}  //end if arrayAllModules

						}  //end arryDepartment
						echo '</div>';
							
						?> <input type="hidden" name="Line" id="Line" value="<?=$Line?>" />



						</div>
						</td>
					</tr>

					<? } ?>



					</td>
					</tr>


				</table>

				</td>
			</tr>



			<tr>
				<td align="center"><br />
				<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
				<input name="Submit" type="submit" class="button" id="SubmitButton"
					value=" <?=$ButtonTitle?> " /></div>
				<input type="hidden" name="GroupID" id="GroupID"
					value="<?=$_GET['edit']?>" /></td>
			</tr>
			</form>
		</table>


		</td>
	</tr>

</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
<? if(!empty($_GET['edit'])){ ?>	
	$("#accordion").accordion({
		heightStyle: "content",
		duration: 'fast',
		active: true
	});

	$("#collapseAll").click(function(){
	    $(".ui-accordion-content").hide()
	});


	$("#expandAll").click(function(){
	    $(".ui-accordion-content").show()
	});
	ShowPermission();
<? } ?>
</SCRIPT>


