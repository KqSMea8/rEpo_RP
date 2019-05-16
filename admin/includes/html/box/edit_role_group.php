<?php   

	require_once($Prefix."classes/role.class.php");
	$ModuleName = "Role";
	
	$RedirectURL = $ThisPageName;
	

	$EditUrl = "editRoleGroup.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
	$ActionUrl = $EditUrl;
 

	$objRole=new role();
	 
	//echo ini_get("max_input_vars");

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_group'] = GROUP_REMOVED;
		$objRole->RemoveRoleGroup($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_group'] = GROUP_STATUS;
		$objRole->changeRoleGroupStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
		 CleanPost();
		//echo '<pre>'; print_r($_POST);exit;
		if (!empty($_POST['GroupID'])) {
			$ImageId = $_POST['GroupID'];
			$objRole->UpdateRoleGroup($_POST);
			
			/* permission*/
			 $objRole->UpdateGroupRolePermissionNew($_POST);
			/* permission*/
			
			 
			$_SESSION['mess_group'] = GROUP_UPDATED;
			$RedirectURL = $EditUrl;
		} else {	
			$ImageId = $objRole->AddRoleGroup($_POST); 
			$_SESSION['mess_group'] = GROUP_ADDED;
		}
		$_POST['GroupID'] = $ImageId;
                 header("Location:".$RedirectURL);
		  exit;
		
	 }
		
	$GroupStatus = 1;
	if (!empty($_GET['edit'])) {
		$arryGroup = $objRole->getRoleGroup($_GET['edit'],'');
		if($arryGroup[0]['Status'] != ''){
			$GroupStatus = $arryGroup[0]['Status'];
		} 
	}else{
		$arryGroup[0]['group_name'] ='';
		$arryGroup[0]['description'] ='';
	}
	

			
				
					
		
?>

<script language="JavaScript1.2" type="text/javascript">
function SelectDeselect(AllCheck,InnerCheck)
{	
	var Checked = false;
	if(document.getElementById(AllCheck).checked){
		Checked = true;
	}
 	 
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById(InnerCheck+i).checked=Checked;
 
	}

}


function validate(frm){
		if( ValidateForSimpleBlank(frm.group_name, "Group Name")){
			var Url = "isRecordExists.php?group_name="+escape(document.getElementById("group_name").value)+"&editID="+escape(document.getElementById("GroupID").value);
			SendExistRequest(Url,"group_name","Group Name");			
		
			return false;
		}else{
			return false;	
		}
		
}


function SelectDeselectAll(AllCheck,InnerCheck)
{	
	var Checked = false;
	if(document.getElementById(AllCheck).checked){
		Checked = true;
	}
 	 
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById(InnerCheck+i).checked=Checked;

		if(AllCheck=='FullAll'){
			SetFullCheck(i);
		}
	}

	if(AllCheck=='FullAll'){
		if(document.getElementById("FullAll").checked){
			document.getElementById("AddAll").checked = true;
			document.getElementById("EditAll").checked = true;
			document.getElementById("DeleteAll").checked = true;
			document.getElementById("ApproveAll").checked = true;
			document.getElementById("ViewAll").checked = true;
			document.getElementById("ViewAllAll").checked = true;
			document.getElementById("AssignAll").checked = true;
		}else{
			document.getElementById("AddAll").checked = false;
			document.getElementById("EditAll").checked = false;
			document.getElementById("DeleteAll").checked = false;
			document.getElementById("ApproveAll").checked = false;
			document.getElementById("ViewAll").checked = false;
			document.getElementById("ViewAllAll").checked = false;
			document.getElementById("AssignAll").checked = false;
		}
	}

}


function SetFullCheck(Line){
	if(document.getElementById("FullLabel"+Line).checked){
		document.getElementById("AddLabel"+Line).checked = true;
		document.getElementById("EditLabel"+Line).checked = true;
		document.getElementById("DeleteLabel"+Line).checked = true;
		document.getElementById("ApproveLabel"+Line).checked = true;
		document.getElementById("ViewLabel"+Line).checked = true;
		document.getElementById("ViewAllLabel"+Line).checked = true;
		document.getElementById("AssignLabel"+Line).checked = true;
	}else{
		document.getElementById("AddLabel"+Line).checked = false;
		document.getElementById("EditLabel"+Line).checked = false;
		document.getElementById("DeleteLabel"+Line).checked = false;
		document.getElementById("ApproveLabel"+Line).checked = false;
		document.getElementById("ViewLabel"+Line).checked = false;
		document.getElementById("ViewAllLabel"+Line).checked = false;
		document.getElementById("AssignLabel"+Line).checked = false;
	}
}


</script>




<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">Role Group <span> &raquo; <? 	echo (!empty($_GET['edit']))?("Edit   Details") :("Add  ".$ModuleName); ?></span>


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
				<td align="center" class="message"><? echo $_SESSION['mess_group']; unset($_SESSION['mess_group']);  ?>
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
						<td align="right"  class="blackbold">Group Name :<span
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



					<? if(!empty($_GET["edit"])){ 
						include($MainPrefix."includes/html/box/role_group_edit.php");
					} ?>



 


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




<? if(!empty($_GET['edit'])){ ?>	

<SCRIPT LANGUAGE=JAVASCRIPT>
function SetPermHead(){
	 $("#PermissionsHad").css({"position":"fixed","width":"72%"}); 
}

$("#accordion").accordion({
	heightStyle: "content",
	duration: 'fast',
	active: true
});

$("#collapseAll").click(function(){
    $(".ui-accordion-content").hide();    
    $("#PermissionsHad").css({"position":"relative","width":"100%"}); 
	 
    
});


$("#expandAll").click(function(){
    $(".ui-accordion-content").show();
    $("#PermissionsHad").css({"position":"fixed","width":"72%"}); 
    

});
	//ShowPermission();

</SCRIPT>


<? } ?>





