<div class="right_box">

<table width="100%"  border="0" cellpadding="0" cellspacing="0">


<form name="form1"   method="post">
  
  <? if (!empty($_SESSION['mess_employee'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="background:#fff">


  

<tr>
	 <td colspan="2" align="left" class="head">Personal Details</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold"> Employee Code : </td>
        <td   align="left" >
		<strong><?=stripslashes($arryEmployee[0]['EmpCode'])?></strong>
	</td>
      </tr>
<tr>
	     <td  align="right"  class="blackbold" >Gender : </td>
	     <td   align="left" >
		<?=$arryEmployee[0]['Gender']?>		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" width="45%"> First Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>           </td>
      </tr>

	   <tr>
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
      </tr>

  <tr>
        <td  align="right"   class="blackbold"> Nationality  : </td>
        <td   align="left" >

	<?=(!empty($arryEmployee[0]['Nationality']))?($arryEmployee[0]['Nationality']):(NOT_SPECIFIED)?>


		</td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Marital Status  : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['MaritalStatus']))?($arryEmployee[0]['MaritalStatus']):(NOT_SPECIFIED)?>
             </td>
      </tr>

<? if($arryCurrentLocation[0]['country_id']!=106){?>
<tr>
        <td align="right"   class="blackbold">Social Security Number  : </td>
        <td  align="left" >
	<?=(!empty($arryEmployee[0]['SSN']))?(stripslashes($arryEmployee[0]['SSN'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 
<? } ?>

<tr>
        <td  align="right"   class="blackbold"> Blood Group  : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['BloodGroup']))?($arryEmployee[0]['BloodGroup']):(NOT_SPECIFIED)?>
             </td>
      </tr>
 


<? if($_GET["tab"]=="role"){ ?>

<tr>
		 <td colspan="2" align="left" class="head">Role/Permissions</td>
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

<? 

		/******************************************/
        $Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
			

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

		/******************************************/	
	
	?>
	
	<tr>
       		 <td colspan="2" align="left"   class="head">Contact Details</td>
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
		<? if(!empty($arryEmployee[0]['LandlineNumber'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" > <?=stripslashes($arryEmployee[0]['LandlineNumber'])?>	
		
			</td>
      </tr>
	  <? } ?>

<? if($_GET["tab"]=="contact"){ ?>
<tr>
       		 <td colspan="2" align="left"   class="head">Address Proof</td>
        </tr>

<tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Address Proof 1 :</td>
    <td  align="left" valign="top">		
	<? 
        $MainDir = $Prefix."admin/hrms/upload/add_proof/".$_GET['cmp']."/";
        if($arryEmployee[0]['AddressProof1'] !='' && file_exists($MainDir.$arryEmployee[0]['AddressProof1']) ){ ?>
	<div id="AddressProof1Div">
	<?=$arryEmployee[0]['AddressProof1']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['AddressProof1']?>" class="download">Download</a> 

	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>	

<tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Address Proof 2 :</td>
    <td  align="left" valign="top" >
	
	<? 
        $MainDir = $Prefix."admin/hrms/upload/add_proof/".$_GET['cmp']."/";
        if($arryEmployee[0]['AddressProof2'] !='' && file_exists($MainDir.$arryEmployee[0]['AddressProof2']) ){ ?>
	<div id="AddressProof2Div">
	<?=$arryEmployee[0]['AddressProof2']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['AddressProof2']?>" class="download">Download</a> 

	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>	




<? } ?>
<? if($_GET["tab"]=="employment"){ 
	$arryEmployment = $objEmployee->GetEmployment($_GET['view']);
?>

<tr>
		 <td colspan="2" align="left"   class="head">Employment Details</td>
	</tr>	
	
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" style="margin-top:10px;">
<table <?=$table_bg?> >
   
    <?php 
	
  if(sizeof($arryEmployment)>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployment as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td>
	  <?
	  	if($values["FromDate"]>0) $Duration =  date($Config['DateFormat'], strtotime($values["FromDate"])); 
	
	  if($values["ToDate"]>0) $Duration .= ' To '.date($Config['DateFormat'], strtotime($values["ToDate"]));
	  
	  
	  	echo '<h3>'.$Line.'.'.stripslashes($values["EmployerName"]).'</h3>
			Designation: '.stripslashes($values["Designation"]).'
			<br><br>Duration: '. $Duration.'
			<br><br>Job Profile: '.nl2br(stripslashes($values["JobProfile"])).'
		';
	  
	  ?>
	  
	  
	  </td>
  
      </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
		 
		 
		 </td>
	</tr>	
	
	
<? } ?>
<? if($_GET["tab"]=="family"){ 
	$arryFamily = $objEmployee->GetFamily($_GET['view']);
?>

<tr>
		 <td colspan="2" align="left"   class="head">Family Details</td>
	</tr>	
	
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" style="margin-top:10px;">
<table <?=$table_bg?> >
   
    <?php 
	
  if(sizeof($arryFamily)>0){
  	$flag=true;
	$Line=0;
  	foreach($arryFamily as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td>
	  <?
	  
	  	echo '<h3>'.$Line.'.'.stripslashes($values["Name"]).'</h3>
			Relation: '.stripslashes($values["Relation"]).'
			<br><br>Age: '. stripslashes($values["Age"]) .'
			<br><br>Dependent: '.stripslashes($values["Dependent"]).'
		';
	  
	  ?>
	  
	  
	  </td>
  
      </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
		 
		 
		 </td>
	</tr>	
	
	
<? } ?>




<? if($_GET["tab"]=="emergency"){ 
	$arryEmergency = $objEmployee->GetEmergency($_GET['view']);
?>

<tr>
		 <td colspan="2" align="left"   class="head">Emergency Contacts</td>
	</tr>	
	
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" style="margin-top:10px;">
<table <?=$table_bg?> >
   
    <?php 
	
  if(sizeof($arryEmergency)>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmergency as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td>
	  <?
	  
	  	echo '<h3>'.$Line.'.'.stripslashes($values["Name"]).'</h3>
			<B>Relation:</B> '.stripslashes($values["Relation"]).'
			<br><B>Address:</B> '. nl2br(stripslashes($values["Address"])).'
		';
	  if(!empty($values["Mobile"])) echo '<br><B>Mobile:</B> '.stripslashes($values["Mobile"]);
	  if(!empty($values["HomePhone"])) echo '<br><B>Home Phone:</B> '.stripslashes($values["HomePhone"]);
	  if(!empty($values["WorkPhone"])) echo '<br><B>Work Phone:</B> '.stripslashes($values["WorkPhone"]);



	  ?>
	  
	  
	  </td>
  
      </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
		 
		 
		 </td>
	</tr>	
	
	
<? } ?>




<? if($_GET["tab"]=="exit"){ ?> 
 <tr>
       		 <td colspan="2" align="left" class="head">Employee Exit</td>
        </tr>
  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
		
		
		<tr>
        <td align="right"   class="blackbold" width="45%">Joining Date  :</td>
        <td  align="left" >		
		<? if($arryEmployee[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); ?>

	</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" > Exit Type  : </td>
        <td   align="left" >

	<?=(!empty($arryEmployee[0]['ExitType']))?(stripslashes($arryEmployee[0]['ExitType'])):(NOT_SPECIFIED)?>

           </td>
      </tr>

	 <tr>
        <td align="right"   class="blackbold" >Reason  :</td>
        <td  align="left"  >
	<?=(!empty($arryEmployee[0]['ExitReason']))?(stripslashes($arryEmployee[0]['ExitReason'])):(NOT_SPECIFIED)?>
		</td>
      </tr> 

     <tr>
        <td align="right"   class="blackbold" >Resignation Date  :</td>
        <td  align="left">
		<? if($arryEmployee[0]['ExitDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['ExitDate'])); 
			else echo NOT_SPECIFIED;
	 
	 ?>
			</td>
      </tr>
	  

<tr>
        <td align="right"   class="blackbold" >Last Working Date  :</td>
        <td  align="left">
<? if($arryEmployee[0]['LastWorking']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['LastWorking']));
	else echo NOT_SPECIFIED;
?>

					</td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" > Full & Final  : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['FullFinal']))?(stripslashes($arryEmployee[0]['FullFinal'])):(NOT_SPECIFIED)?>
           </td>
      </tr>

	   <tr>
          <td align="right"   class="blackbold" valign="top">Description  :</td>
         <td  align="left" >
	<?=(!empty($arryEmployee[0]['ExitDesc']))?(nl2br(stripslashes($arryEmployee[0]['ExitDesc']))):(NOT_SPECIFIED)?>

		  </td>
        </tr>

<tr>
        <td  align="right"   class="blackbold" > Assets/Files Clearence  : </td>
        <td   align="left" >
	<?=($arryEmployee[0]['ExitClearence']=='1')?('Yes'):('No')?>
           </td>
      </tr>

    
	  
	  
	   <tr>
       		 <td colspan="2" >&nbsp;</td>
        </tr>	
<? } ?>	


<? if($_GET["tab"]=="education"){ ?>

	<tr>
       		 <td colspan="2" align="left"   class="head">Education Details</td>
        </tr>	
	
		 <tr>
          <td align="right"   class="blackbold" >Under Graduate  :</td>
          <td height="30" align="left" >
		  <?
	 if($arryEmployee[0]['UnderGraduate']=="Other"){
			$UnderGraduate = stripslashes($arryEmployee[0]['OtherUnderGraduate']);
	 }else{
			$UnderGraduate = stripslashes($arryEmployee[0]['UnderGraduate']);
	 }
	 	 echo (!empty($UnderGraduate))?(stripslashes($UnderGraduate)):(NOT_SPECIFIED);

	 ?>	  
			
		  
		  </td>
  </tr> 
	  
	 <tr>
          <td align="right"   class="blackbold"  width="45%"> Graduation  :</td>
          <td height="30" align="left" >
	<?
	 if($arryEmployee[0]['Graduation']=="Other"){
			$Graduation = stripslashes($arryEmployee[0]['OtherGraduation']);
	 }else{
			$Graduation = stripslashes($arryEmployee[0]['Graduation']);
	 }
	 	 echo (!empty($Graduation))?(stripslashes($Graduation)):(NOT_SPECIFIED);

	 ?>	  
		  
		  </td>
  </tr>  
	  
	 <tr>
          <td align="right"   class="blackbold" >Post Graduation  :</td>
          <td height="30" align="left" >
		  <?
	 if($arryEmployee[0]['PostGraduation']=="Other"){
			$PostGraduation = stripslashes($arryEmployee[0]['OtherPostGraduation']);
	 }else{
			$PostGraduation = stripslashes($arryEmployee[0]['PostGraduation']);
	 }
	 echo (!empty($PostGraduation))?(stripslashes($PostGraduation)):(NOT_SPECIFIED);
	 ?>	  
			
		  
		  </td>
  </tr>  
	  
	
	
	    	
     <tr>
       <td height="30" align="right"  class="blackbold" > Doctorate/Phd  : </td>
       <td  align="left"  >

 <?
	 if($arryEmployee[0]['Doctorate']=="Other"){
			$Doctorate= stripslashes($arryEmployee[0]['OtherDoctorate']);
	 }else{
			$Doctorate= stripslashes($arryEmployee[0]['Doctorate']);
	 }
	 echo (!empty($Doctorate))?(stripslashes($Doctorate)):(NOT_SPECIFIED);
	 ?>	  

	   </td>
     </tr>
	 
	 	 <tr>
          <td align="right"   class="blackbold" >Professional Course  :</td>
          <td height="30" align="left" >
		  <?
	 if($arryEmployee[0]['ProfessionalCourse']=="Other"){
			$ProfessionalCourse= stripslashes($arryEmployee[0]['OtherProfessionalCourse']);
	 }else{
			$ProfessionalCourse= stripslashes($arryEmployee[0]['ProfessionalCourse']);
	 }
	 	 echo (!empty($ProfessionalCourse))?(stripslashes($ProfessionalCourse)):(NOT_SPECIFIED);

	 ?>	  
			
		  
		  </td>
  </tr> 
	 
	 
	<tr>
        <td align="right"   class="blackbold" valign="top">
		Certification Course  :</td>
    <td height="30" align="left" valign="top" >

	<?=(!empty($arryEmployee[0]['Certification']))?(stripslashes($arryEmployee[0]['Certification'])):(NOT_SPECIFIED)?>
	</td>
  </tr>	
  
<tr>
        <td colspan="2">
		<? include("includes/html/box/education_doc.php"); ?>
	</td>
  </tr>	 



 
 <? } ?>
 
  

  
	<tr>
       		 <td colspan="2" align="left" class="head" >Job Details</td>
        </tr>
	
      <tr>
        <td  align="right"   class="blackbold" width="45%">
    Employee Code :</td>
        <td   align="left" ><B><?=stripslashes($arryEmployee[0]['EmpCode'])?></B>	</td>
      </tr>

	  
<tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		
		<? if($arryEmployee[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); ?>

	</td>
      </tr>
 <? if($arryEmployee[0]['ExpiryDate'] > 0){?>
     <tr>
        <td align="right"   class="blackbold">Termination Date  :</td>
        <td  align="left">
		<?  echo date($Config['DateFormat'], strtotime($arryEmployee[0]['ExpiryDate'])); ?>
						</td>
      </tr>
<? } ?>	  
	  
	  
	   <tr>
        <td  align="right"   class="blackbold"> Category  : </td>
        <td   align="left" >
		<?=$arryEmployee[0]['catName']?>
		</td>
      </tr>
	  
<!--tr>
        <td  align="right"   class="blackbold"> Division  : </td>
        <td   align="left" >

<?=stripslashes($arryEmployee[0]['DivisionName'])?>

</td>
      </tr-->

	     <tr>
        <td  align="right"   class="blackbold"> Department  : </td>
        <td   align="left" >
<?=stripslashes($arryEmployee[0]['DepartmentName'])?>
<?  if($arryEmployee[0]['DeptHead']>0){echo "&nbsp;&nbsp;<b>[Departmental Head]</b>";}?>
</td>
      </tr>
	   
	<tr>
        <td  align="right"   class="blackbold"> Designation   : </td>
        <td   align="left" >
			<?=stripslashes($arryEmployee[0]['JobTitle'])?>
		
		</td>
      </tr>
	
<tr >
    <td  align="right"   class="blackbold">Job Type :</td>
    <td align="left">
			<?=stripslashes($arryEmployee[0]['JobType'])?>
		</td>
  </tr>
<? if(!empty($arryEmployee[0]['shiftName'])){?>
<tr>
    <td  align="right"   class="blackbold">Work Shift :</td>
    <td align="left">
			<?=stripslashes($arryEmployee[0]['shiftName'])?> [<?=$arryEmployee[0]['WorkingHourStart']?> - <?=$arryEmployee[0]['WorkingHourEnd']?>]
		</td>
  </tr>
 <? } ?> 
<tr>
        <td align="right"   class="blackbold" >
		Total Experience  :</td>
        <td  align="left" >
		
	<?=$arryEmployee[0]['ExperienceYear']?> Years &nbsp;&nbsp; 	
		<?=$arryEmployee[0]['ExperienceMonth']?> Months	
		
		</td>
	  </tr>	
	  
	 <tr>
        <td align="right"   class="blackbold" >Skill  :</td>
        <td  align="left"  >
		<?=(!empty($arryEmployee[0]['Skill']))?(stripslashes($arryEmployee[0]['Skill'])):(NOT_SPECIFIED)?>
			</td>
      </tr>  
	  
			
			    
		










 
  <? if($_GET["tab"]=="bank"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Bank Details</td>
        </tr>
		
	 <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
        <td   align="left" >
	<?=stripslashes($arryEmployee[0]['BankName'])?>
            </td>
      </tr>	
	 <tr>
        <td  align="right"   class="blackbold"> Account Name  : </td>
        <td   align="left" >
            <?=stripslashes($arryEmployee[0]['AccountName'])?>
			 </td>
      </tr>	  
	  <tr>
        <td  align="right"   class="blackbold"> Account Number  : </td>
        <td   align="left" >
     <?=stripslashes($arryEmployee[0]['AccountNumber'])?>
			 </td>
      </tr>	
	   <tr>
        <td  align="right"   class="blackbold"> Routing Number  :</td>
        <td   align="left" >
        <?=stripslashes($arryEmployee[0]['IFSCCode'])?>
			 </td>
      </tr>	
	  
	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
  <? } ?>
 
 <? if($_GET["tab"]=="supervisor"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Supervisor</td>
        </tr>
		
	 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold" width="45%"> Supervisor : </td>
        <td   align="left" >
		<? if($arryEmployee[0]['Supervisor']>0){ ?>
			<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryEmployee[0]['Supervisor']?>" ><?=$arrySupervisor[0]['UserName']?> (<?=$arrySupervisor[0]['Department']?>)</a>	 
		  <? } else echo NOT_SPECIFIED;?>
            </td>
      </tr>	
	  
	  <tr>
        <td  align="right"   class="blackbold"> Reporting Method : </td>
        <td   align="left" >

	<?=(!empty($arryEmployee[0]['ReportingMethod']))?(stripslashes($arryEmployee[0]['ReportingMethod'])):(NOT_SPECIFIED)?>

			 </td>
      </tr>	
	  
	   <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>
		
  <? } ?>
  <? if($_GET["tab"]=="id"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">ID Proof</td>
        </tr>
		
	 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold" width="45%"> ID Type : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['ImmigrationType']))?(stripslashes($arryEmployee[0]['ImmigrationType'])):(NOT_SPECIFIED)?>
		   
		   </td>
      </tr>	
	  
	  <tr>
        <td  align="right"   class="blackbold"> Number  : </td>
        <td   align="left" >
	<?=(!empty($arryEmployee[0]['ImmigrationNo']))?(stripslashes($arryEmployee[0]['ImmigrationNo'])):(NOT_SPECIFIED)?>

          
			 </td>
      </tr>	
	  
	    <tr>
        <td  align="right"   class="blackbold"> Expiry Date : </td>
        <td   align="left" >
 		<? if($arryEmployee[0]['ImmigrationExp']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['ImmigrationExp']));
		else echo  NOT_SPECIFIED;
			
		?>

			
			
			
			 </td>
      </tr>	

<tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Attached ID Proof  :</td>
    <td  align="left" valign="top" >
	
	<? 
        $MainDir = $Prefix."admin/hrms/upload/ids/".$_GET['cmp']."/";
        if($arryEmployee[0]['IdProof'] !='' && file_exists($MainDir.$arryEmployee[0]['IdProof']) ){ ?>
	<div id="IdProofDiv">
	<?=$arryEmployee[0]['IdProof']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['IdProof']?>" class="download">Download</a> 

	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>

	   <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>
		
  <? } ?>
<? if($_GET["tab"]=="resume"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Resume</td>
        </tr>
	 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
	<tr>
    <td height="30" align="right" valign="top"   class="blackbold" width="46%"> Resume   :</td>
    <td  align="left" valign="top" >
	
	
	<? 
       // $MainDir = "upload/resume/".$_GET['cmp']."/";
        $MainDir = $Prefix."admin/hrms/upload/resume/".$_GET['cmp']."/";
        if($arryEmployee[0]['Resume'] !='' && file_exists($MainDir.$arryEmployee[0]['Resume']) ){ ?>
	<div id="ResumeDiv">
	<?=stripslashes($arryEmployee[0]['Resume'])?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arryEmployee[0]['Resume']?>" title="<?=$arryEmployee[0]['Resume']?>" class="download">Download</a>
	&nbsp;
	<!--<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['Resume']?>','ResumeDiv')"><?=$delete?></a>-->
	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>	
  
   <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	
		
 <? } ?>
	  



	
	<tr>
       		 <td colspan="2" align="left" class="head">Login Details</td>
        </tr>
		<tr>
       		 <td colspan="2" height="50">&nbsp;</td>
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
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>

	
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



