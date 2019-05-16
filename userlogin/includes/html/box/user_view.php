	




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1"   method="post">
  
  <? if (!empty($_SESSION['mess_user'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<? if($_GET["tab"]=="personal"){ ?>
<tr>
	 <td colspan="4" align="left" class="head">Personal Details</td>
</tr>
<tr>
	 <td colspan="4">&nbsp;</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> User Code : </td>
        <td   align="left"  width="30%">
		<strong><?=stripslashes($arryEmployee[0]['EmpCode'])?></strong>
	</td>
      
	     <td  align="right"  class="blackbold"  width="20%">Gender : </td>
	     <td   align="left" >
		<?=$arryEmployee[0]['Gender']?>		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" > First Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>           </td>
      
        <td  align="right"   class="blackbold"> Last Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryEmployee[0]['LastName']); ?>  </td>
      </tr>
	   
	   <tr>
        <td  align="right"   > Date of Birth :  </td>
        <td   align="left" >
		<? if($arryEmployee[0]['date_of_birth']>0) 
		   echo date($Config['DateFormat'], strtotime($arryEmployee[0]['date_of_birth']));
		   else echo NOT_SPECIFIED;
	   
	   ?>
	

        </td>
     
 <td  align="right"  class="blackbold"> Designation  : </td>
        <td   align="left" >
<?=(!empty($arryEmployee[0]['JobTitle']))?(stripslashes($arryEmployee[0]['JobTitle'])):(NOT_SPECIFIED)?>

	
</td>



      </tr>

<tr>
  <td  align="right"   > Joining Date : </td>
        <td   align="left" >
		<? if($arryEmployee[0]['JoiningDate']>0) 
		   echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate']));
		   else echo NOT_SPECIFIED;
	   
	   ?>

        </td>
</tr>



<tr>
	 <td colspan="4">&nbsp;</td>
</tr>
 
<? } ?>

<? if($_GET["tab"]=="role"){ ?>

<tr>
		 <td colspan="4" align="left" class="head">Role/Permissions</td>
	</tr>	

<tr>
        <td  align="right"   class="blackbold" width="20%"> Role  : </td>
        <td   align="left" >
	<?=$arryEmployee[0]['Role']?>

	<input type="hidden" name="Role"  id="Role" value="<?=$arryEmployee[0]['Role']?>">

	
			
			          </td>
      </tr>  
	  
 <tr>
        <td  align="right"   class="blackbold" > View User Info  : </td>
        <td   align="left" valign="bottom" >
	<input type="checkbox" name="vUserInfo" id="vUserInfo"  value="1" <?  if($arryEmployee[0]['vUserInfo']>0){echo "checked";}?> disabled>
			
	 </td>
      </tr> 
 <tr>
        <td  align="right"   class="blackbold" > View All Records  : </td>
        <td   align="left" valign="bottom">
	<input type="checkbox" name="vAllRecord" id="vAllRecord"  value="1" <?  if($arryEmployee[0]['vAllRecord']>0){echo "checked";}?> disabled>
		<?=ROLE_ALL_RECORD?>	
	 </td>
      </tr>  


   <tr>
					       <td align="right" valign="top"  class="blackbold"><div id="PermissionTitle"> Permissions Allowed :</div></td>
					       <td align="left">
						   <div id="PermissionValue" >
							
							  	<table width="100%" cellspacing=0 cellpadding=2 style="background-color:#EFEFEF"><tr>
								<td><strong>Module Name</strong></td>
								<td width="20%"><!--<input type="checkbox" name="ViewAll" id="ViewAll" onclick="javascript:SelectDeselect('ViewAll','ViewLabel');"  />--><strong>View</strong></td>
								<td width="20%"><!--<input type="checkbox" name="ModifyAll" id="ModifyAll" onclick="javascript:SelectDeselect('ModifyAll','ModifyLabel');"  />--><strong>Modify</strong></td>


<td width="20%"><!--<input type="checkbox" name="FullAll" id="FullAll" onclick="javascript:SelectDeselect('FullAll','FullLabel');"  />--><strong>Full</strong></td>


								</tr></table>
<? 
	$Line=0;
  	foreach($arryDepartment as $key=>$valuesDept){

		$arrayMainModules = $objConfig->getMainModulesUser($arryEmployee[0]['UserID'],0,$valuesDept['depID']);
		

		if(sizeof($arrayMainModules)>0){
			

			
			echo '<h2>'.$valuesDept['Department'].'</h2>';
			
			echo '<table width="100%" cellspacing=0 cellpadding=2>';
			foreach($arrayMainModules as $key=>$valuesMod){
				$Line++; 
				echo '<tr><td height="30">'.stripslashes($valuesMod['Module']).'</td> ';
				?>
<td width="20%">
<input type="checkbox" name="ViewLabel<?=$Line?>" id="ViewLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['ViewLabel']) && !empty($_GET['view'])) echo " checked";  ?> disabled/></td>				
		
			
<td width="20%">				
<input type="checkbox" name="ModifyLabel<?=$Line?>" id="ModifyLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['ModifyLabel']) && !empty($_GET['view'])) echo " checked";  ?> disabled/></td>


<td width="20%">				
<input type="checkbox" name="FullLabel<?=$Line?>" id="FullLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['FullLabel']) && !empty($_GET['view'])) echo " checked";  ?> disabled/></td>


											
				
				<?
				echo '</tr>';
				/*if ($Line % 2 == 0) {
					echo "</tr><tr>";
				}*/
		

			} //end arrayAllModules
			 
			//echo '</tr></table>';
			echo '</table>';

		  }  //end if arrayAllModules
	   
	 }  //end arryDepartment 
	   

  ?>
								
						   
						   
						   

	<input type="hidden" name="Line" id="Line" value="<?=$Line?>" />
	

						   
						   </div>
						   </td>
			          </tr> 

<? } ?>

<? if($_GET["tab"]=="contact"){
	
	
		/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		if($arryEmployee[0]['country_id']>0){
			$arryCountryName = $objRegion->GetCountryName($arryEmployee[0]['country_id']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($arryEmployee[0]['state_id'])) {
			$arryState = $objRegion->getStateName($arryEmployee[0]['state_id']);
			$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arryEmployee[0]['OtherState'])){
			 $StateName = stripslashes($arryEmployee[0]['OtherState']);
		}

		if(!empty($arryEmployee[0]['city_id'])) {
			$arryCity = $objRegion->getCityName($arryEmployee[0]['city_id']);
			$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arryEmployee[0]['OtherCity'])){
			 $CityName = stripslashes($arryEmployee[0]['OtherCity']);
		}

		/*******************************************/	
	
	
	
	?>
	
	<tr>
       		 <td colspan="4" align="left"   class="head">Contact Details</td>
        </tr>
   
	  
	    <tr>
        <td align="right"   class="blackbold" width="45%">Personal Email  : </td>
        <td  align="left" >
	<?=(!empty($arryEmployee[0]['PersonalEmail']))?($arryEmployee[0]['PersonalEmail']):(NOT_SPECIFIED)?>
		
		
		</td>
      </tr> 
	 
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Contact Address  :</td>
          <td  align="left" >
	<?=(!empty($arryEmployee[0]['Address']))?(nl2br(stripslashes($arryEmployee[0]['Address']))):(NOT_SPECIFIED)?>
		   
		   
		   </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
	<?=(!empty($CountryName))?($CountryName):(NOT_SPECIFIED)?>


		        </td>
      </tr>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">
	<?=(!empty($StateName))?($StateName):(NOT_SPECIFIED)?>
	  
	  </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold">City   :</td>
        <td  align="left"  >
	<?=(!empty($CityName))?($CityName):(NOT_SPECIFIED)?>

		</td>
      </tr> 
	    
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	<?=(!empty($arryEmployee[0]['ZipCode']))?($arryEmployee[0]['ZipCode']):(NOT_SPECIFIED)?>

				</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=(!empty($arryEmployee[0]['Mobile']))?($arryEmployee[0]['Mobile']):(NOT_SPECIFIED)?>

		</td>
      </tr>
		



<? } ?>

 



<? if($_GET["tab"]=="account"){ ?>
	
	<tr>
       		 <td colspan="4" align="left" class="head"><?=$SubHeading?></td>
        </tr>
		<tr>
       		 <td colspan="4" height="50">&nbsp;</td>
        </tr>
      <tr>
        <td  align="right"   class="blackbold" width="45%"> Email : </td>
        <td   align="left" ><?php echo $arryEmployee[0]['Email']; ?>		</td>
      </tr>
	  

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <?  echo ($arryEmployee[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>
	<tr>
       		 <td colspan="4" height="50">&nbsp;</td>
        </tr>
 <? } ?>	
	
	



</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="role"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>



