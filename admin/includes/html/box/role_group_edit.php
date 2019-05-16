<?
unset($arryDepartment);
$arryDepartment = $objConfig->GetDeptSettingSecurity();
?>

<style>
#PermissionValueNew input{
vertical-align: text-bottom;
}
</style>
 
 <tr id="CollapseExpand">
        <td   align="right" valign="bottom" colspan="2">

<a href="javascript:void(0);" id="collapseAll" class="grey_bt">Collapse All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  id="expandAll" class="grey_bt">Expand All</a>

<input type="submit" name="SubmitSave" id="SubmitSave" value="Save" class="button">
	 </td>
      </tr> 
 
  <tr height="50" >
	<td align="right"></td>
        <td   align="left"   >

 <div id="PermissionsHad" style="width:100%; display: inline-block;  z-index:1;"><table width="100%" cellspacing=0 cellpadding=2 style="background-color:#EFEFEF"  ><tr >
								<td width="250px"></td>
								<td width="80px"><label><input type="checkbox" name="AddAll" id="AddAll" onclick="javascript:SelectDeselect('AddAll','AddLabel');" /><strong>&nbsp;Add</strong></label></td>
								<td width="80px"><label><input type="checkbox" name="EditAll" id="EditAll" onclick="javascript:SelectDeselect('EditAll','EditLabel');"  /><strong>&nbsp;Edit</strong></label></td>
								<td width="80px"><label><input type="checkbox" name="DeleteAll" id="DeleteAll" onclick="javascript:SelectDeselect('DeleteAll','DeleteLabel');"  /><strong>&nbsp;Delete</strong></label></td>
								<td width="80px"><label><input type="checkbox" name="ApproveAll" id="ApproveAll" onclick="javascript:SelectDeselect('ApproveAll','ApproveLabel');"  /><strong>&nbsp;Approve</strong></label></td>
								<td  width="80px"><label><input type="checkbox" name="ViewAll" id="ViewAll" onclick="javascript:SelectDeselect('ViewAll','ViewLabel');"  /><strong>&nbsp;View</strong></label></td>

<td  width="80px"><label><input type="checkbox" name="ViewAllAll" id="ViewAllAll" onclick="javascript:SelectDeselect('ViewAllAll','ViewAllLabel');"  /><strong>&nbsp;View All</strong></label></td>
		
<td  width="80px"><label><input type="checkbox" name="AssignAll" id="AssignAll" onclick="javascript:SelectDeselect('AssignAll','AssignLabel');"  /><strong>&nbsp;Assign</strong></label></td>						 

<td><label><input type="checkbox" name="FullAll" id="FullAll" onclick="javascript:SelectDeselectAll('FullAll','FullLabel');"  /><strong>&nbsp;Full</strong></label></td>


								</tr></table></div>


	 </td>
      </tr>

     <tr id="PermissionsVal">
					       <td align="right" valign="top"  class="blackbold"  width="10%"><div id="PermissionTitle"> Permissions :</div></td>
					       <td align="left">
						   <div id="PermissionValueNew" >
						   
							  	 
 <? 
								$Line=0;
								 
echo '<div id="accordion" >';
foreach($arryDepartment as $key=>$valuesDept){
	$arrayMainModules = $objRole->getMainModulesGroup($_GET['edit'],0,$valuesDept['depID']);
	 
	if(sizeof($arrayMainModules)>0){
		
		
		echo '<h2 onclick="Javascript:SetPermHead();">'.$valuesDept['Department'].'</h2>';
		
		echo '<table width="100%" cellspacing=0 cellpadding=0>';
		foreach($arrayMainModules as $key=>$valuesMod){
			    
			   $arrayMainModulesParent =$objRole->getParentModuleIDVal($_GET['edit'],$valuesMod['ModuleID']);
			 
			echo '<tr><td height="30"><b>'.stripslashes($valuesMod['Module']).'</b></td> ';	
			?>	
			<?php echo '</tr>'; ?>
			<?php 
		       foreach($arrayMainModulesParent as $keyhh=>$valuesModhh){
		      
		       	$Line++;

			   	   echo '<tr><td height="30" width="223px">&nbsp;&nbsp;&nbsp;&nbsp;'.stripslashes($valuesModhh['Module']).'</td> ';

			?>
<td width="80px"><?#=$Line?>
<input type="checkbox" class="checkbox1" name="AddLabel<?=$Line?>" id="AddLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['AddLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" class="checkbox2" name="EditLabel<?=$Line?>" id="EditLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['EditLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" class="checkbox3" name="DeleteLabel<?=$Line?>" id="DeleteLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['DeleteLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" class="checkbox4" name="ApproveLabel<?=$Line?>" id="ApproveLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['ApproveLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" class="checkbox5" name="ViewLabel<?=$Line?>" id="ViewLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['ViewLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>
<td width="80px">
<input type="checkbox" class="checkbox5" name="ViewAllLabel<?=$Line?>" id="ViewAllLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['ViewAllLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>									
 <td width="80px">
<input type="checkbox" class="checkbox6" name="AssignLabel<?=$Line?>" id="AssignLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['AssignLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>											
		
<td>			
<input type="checkbox" onclick="Javascript:SetFullCheck(<?=$Line?>);" class="checkbox7" name="FullLabel<?=$Line?>" id="FullLabel<?=$Line?>" value="<?=$valuesModhh['ModuleID']?>" <? if(!empty($valuesModhh['FullLabel']) && !empty($_GET['edit'])) echo " checked"; ?> /></td>	


	
			<?
	
		  
			echo '</tr>';
			 
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

