<?
unset($arryDepartment);
$arryDepartment = $objConfig->GetDeptSettingSecurity();
?> 
<style>
#PermissionValueNew input{
vertical-align: text-bottom;
}
</style>

<tr>
		 <td colspan="2" align="left" class="head">Role/Permissions</td>
	</tr>

	 <tr>
        <td  align="right"   class="blackbold" > Pin Punching  :</td>
        <td   align="left" >
	<input type="checkbox" name="PinPunch" id="PinPunch" value="1" <?php if($arryEmployee[0]['PinPunch'] == "1"){echo "checked";} ?>> 
           </td>
      </tr>

	<? if(sizeof($arryRoleGroup)>0){?>
	<tr>
		 <td colspan="2" align="left"  >&nbsp;</td>
	</tr>
	<tr>
		<td  align="right"  class="blackbold" width="12%"> Role Group : </td>
		<td   align="left" >
	
	<select name="GroupID" class="inputbox" id="GroupID" onchange="Javascript:ShowPermissionGroupRole();">
		<option value="">--- None ---</option>
		<? foreach($arryRoleGroup as $roleG){?>
		 <option value="<?=$roleG['GroupID'];?>" <? if($roleG['GroupID']==$arryEmployee[0]['GroupID']){echo "selected";}?>> <?=stripslashes($roleG['group_name'])?> </option>

		<? }?>
	</select>

		    </td>
	 </tr>
	<? } ?>



 <tr id="CollapseExpand">
        <td   align="right" valign="bottom" colspan="2">

<a href="javascript:void(0);" id="collapseAll" class="grey_bt">Collapse All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  id="expandAll" class="grey_bt">Expand All</a>


<input type="submit" name="SubmitSave" id="SubmitSave" value="Save" class="button">

	 </td>
      </tr> 
 
  <tr height="40" >
	<td align="right"></td>
        <td   align="left"   >

 <div id="PermissionsHad" style="width:100%; display: inline-block;  z-index:1;"><table width="100%" cellspacing=0 cellpadding=2 style="background-color:#EFEFEF"  ><tr >
								<td width="240px"></td>
								<td width="80px"><label><input type="checkbox" name="AddAll" id="AddAll" onclick="javascript:SelectDeselect('AddAll','AddLabel');" /><strong>&nbsp;Add</strong></label></td>
								<td width="80px"><label><input type="checkbox" name="EditAll" id="EditAll" onclick="javascript:SelectDeselect('EditAll','EditLabel');"  /><strong>&nbsp;Edit</strong></label></td>
								<td width="80px"><label><input type="checkbox" name="DeleteAll" id="DeleteAll" onclick="javascript:SelectDeselect('DeleteAll','DeleteLabel');"  /><strong>&nbsp;Delete</strong></label></td>
								<td width="80px"><label><input type="checkbox" name="ApproveAll" id="ApproveAll" onclick="javascript:SelectDeselect('ApproveAll','ApproveLabel');"  /><strong>&nbsp;Approve</strong></label></td>
								<td  width="80px"><label><input type="checkbox" name="ViewAll" id="ViewAll" onclick="javascript:SelectDeselect('ViewAll','ViewLabel');"  /><strong>&nbsp;View</strong></label></td>
								<td  width="80px"><label><input type="checkbox" name="ViewAllAll" id="ViewAllAll" onclick="javascript:SelectDeselect('ViewAllAll','ViewAllLabel');"  /><strong>&nbsp;View All</strong></label></td>
								
								<td  width="80px"><label><input type="checkbox" name="AssignAll" id="AssignAll" onclick="javascript:SelectDeselect('AssignAll','AssignLabel');"  /><strong>&nbsp;Assign</strong></label></td>
 
								<td ><label><input type="checkbox" name="FullAll" id="FullAll" onclick="javascript:SelectDeselectAll('FullAll','FullLabel');"  /><strong>&nbsp;Full</strong></label></td>


								</tr></table></div>


	 </td>
      </tr>  
	 


     <tr id="PermissionsVal">
					       <td align="right" valign="top"  class="blackbold"  width="12%"><div id="PermissionTitle">Allow Permissions :</div></td>
					       <td align="left">
						   <div id="PermissionValueNew" >
						   
							  	
 <? 
								$Line=0;
echo '<div id="accordion" >';
foreach($arryDepartment as $key=>$valuesDept){		
	$arrayMainModules = $objConfig->getMainModulesUserNew($arryEmployee[0]['UserID'],0,$valuesDept['depID']);
		
	if(sizeof($arrayMainModules)>0){
		
		
		echo '<h2 onclick="Javascript:SetPermHead();">'.$valuesDept['Department'].'</h2>';
		
		echo '<table width="100%" cellspacing=0 cellpadding=0>';
		foreach($arrayMainModules as $key=>$valuesMod){			    
			$arrayMainModulesParent =$objConfig->getParentModuleIDVal($arryEmployee[0]['UserID'],$valuesMod['ModuleID']);
			echo '<tr><td height="30"><b>'.stripslashes($valuesMod['Module']).'</b></td> ';	
			?>
	
			<?php echo '</tr>'; ?>
			<?php 
		       foreach($arrayMainModulesParent as $keyhh=>$valuesModhh){
		      
		       	$Line++;
		       	 	//echo '<pre>';print_r($valuesModhh);exit;
			   	   echo '<tr><td height="30" width="214px">&nbsp;&nbsp;&nbsp;&nbsp;'.stripslashes($valuesModhh['Module']).'</td> ';

			?>
<td width="80px"> 
<input type="checkbox" name="AddLabel<?=$Line?>" id="AddLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['AddLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" name="EditLabel<?=$Line?>" id="EditLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['EditLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" name="DeleteLabel<?=$Line?>" id="DeleteLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['DeleteLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" name="ApproveLabel<?=$Line?>" id="ApproveLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['ApproveLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" name="ViewLabel<?=$Line?>" id="ViewLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['ViewLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>								

<td width="80px">
<input type="checkbox" name="ViewAllLabel<?=$Line?>" id="ViewAllLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['ViewAllLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>												

<td width="80px">
<input type="checkbox" name="AssignLabel<?=$Line?>" id="AssignLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['AssignLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
		
<td>			
<input type="checkbox" onclick="Javascript:SetFullCheck(<?=$Line?>);" name="FullLabel<?=$Line?>" id="FullLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['FullLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>	


	
			<?
	
		  
			echo '</tr>';
			/*if ($Line % 2 == 0) {
				echo "</tr><tr>";
			}*/
		    }

		} //end arrayAllModules
		 
	
		echo '</table>';

	  }  //end if arrayAllModules
   
 }  //end arryDepartment 
echo '</div>';   
							
 ?>
								
						   
						   
						   

	<input type="hidden" name="Line" id="Line" value="<?=$Line?>" />
	

						   
						   </div>
						   </td>
			          </tr> 



<? if(sizeof($arryRoleGroup)>0){?>
<script language="javascript1.2" type="text/javascript">
ShowPermissionGroupRole();
</script>
<? } ?>



<SCRIPT LANGUAGE=JAVASCRIPT>


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

SetPageWithRight();
</SCRIPT>


