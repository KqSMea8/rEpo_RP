<? 
unset($arryDepartment);
$arryDepartment = $objConfig->GetDeptSettingSecurity();

$arryRoleGroup = $objConfig->getEmployeeRoleID($EmpID); 

$GreenImg = '<img src="'.$MainPrefix.'images/check.png" border="0">';
$RedImg = '<img src="'.$MainPrefix.'images/delete.gif" border="0">';
?>
<tr>
		 <td colspan="2" align="left" class="head">Role/Permissions</td>
	</tr>	

 <tr>
        <td  align="right"   class="blackbold" > Pin Punching  :</td>
        <td   align="left" > 
	 <?php if($arryEmployee[0]['PinPunch'] == "1")echo "<span class=greenmsg>Yes</span>";else echo "<span class=red>No</span>"; ?>
           </td>
      </tr>

<? if(!empty($arryRoleGroup[0]['group_name'])){?>
	<tr>
		<td  align="right"  class="blackbold" width="15%"> Role Group : </td>
		<td   align="left" >
	<?=stripslashes($arryRoleGroup[0]['group_name'])?>
		    </td>
	 </tr>
<? }else{ ?>



  <tr height="40" >
	<td align="right"></td>
        <td   align="left"   >

<div id="PermissionsHad" style="width:70%; position:fixed; display: inline-block;  z-index:1;">
							  	<table width="100%" cellspacing=0 cellpadding=2 style="background-color:#EFEFEF"><tr>
								<td width="220px"></td>
								<td width="80px"><strong>Add</strong></td>
								<td width="80px"><strong>Edit</strong></td>
								<td width="80px"><strong>Delete</strong></td>
								<td width="80px"><strong>Approve</strong></td>
								<td width="80px"> <strong>View</strong></td>

<td width="80px"> <strong>View All</strong></td>
								 <td width="80px"> <strong>Assign</strong></td>
								<td > <strong>Full</strong></td>


								</tr></table></div>


	 </td>
      </tr>


     <tr >
					       <td align="right" valign="top"  class="blackbold" width="15%"><div id="PermissionTitle"> Permissions Allowed :</div></td>
					       <td align="left">
						   <div id="PermissionValue" >
							



<? 
	$Line=0;
  	foreach($arryDepartment as $key=>$valuesDept){
		$arrayMainModules = $objConfig->getMainModulesUserNew($arryEmployee[0]['UserID'],0,$valuesDept['depID']);
		  
		if(sizeof($arrayMainModules)>0){
			

			
			echo '<h2>'.$valuesDept['Department'].'</h2>';
			
			echo '<table width="100%" cellspacing=0 cellpadding=2>';
			foreach($arrayMainModules as $key=>$valuesMod){
				$arrayMainModulesParent =$objConfig->getParentModuleIDVal($arryEmployee[0]['UserID'],$valuesMod['ModuleID']);
				
				echo '<tr><td height="30"><strong>'.stripslashes($valuesMod['Module']).'</strong></td> ';
				
             foreach($arrayMainModulesParent as $keyhh=>$valuesModhh){
		       
		       	$Line++;
			   	   echo '<tr><td height="30" width="214px">&nbsp;&nbsp;&nbsp;&nbsp;'.stripslashes($valuesModhh['Module']).'</td> ';

			?>
<td width="80px">
 <?=(!empty($valuesModhh['AddLabel']))?($GreenImg):($RedImg)?> 
</td>
<td width="80px">
 <?=(!empty($valuesModhh['EditLabel']))?($GreenImg):($RedImg)?> 
</td>
<td width="80px">
 <?=(!empty($valuesModhh['DeleteLabel']))?($GreenImg):($RedImg)?> 
 </td>
<td width="80px">
 <?=(!empty($valuesModhh['ApproveLabel']))?($GreenImg):($RedImg)?> 
 </td>
<td width="80px">
 <?=(!empty($valuesModhh['ViewLabel']))?($GreenImg):($RedImg)?> 
</td>	
<td width="80px">
 <?=(!empty($valuesModhh['ViewAllLabel']))?($GreenImg):($RedImg)?> 
</td>
<td width="80px">
 <?=(!empty($valuesModhh['AssignLabel']))?($GreenImg):($RedImg)?> 
</td>	
<td>			
 <?=(!empty($valuesModhh['FullLabel']))?($GreenImg):($RedImg)?>  
</td>	


											
				
				<?
				echo '</tr>';
				
             }

			} //end arrayAllModules
			 
			
			echo '</table>';

		  }  //end if arrayAllModules
	   
	 }  //end arryDepartment 
	   

  ?>
								
						   
						   
						   

	<input type="hidden" name="Line" id="Line" value="<?=$Line?>" />
	

						   
						   </div>
						   </td>
			          </tr> 

		<? } ?>

<SCRIPT LANGUAGE=JAVASCRIPT>
SetPageWithRight();
</SCRIPT>
