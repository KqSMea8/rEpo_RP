	




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

<!-----------------------------  Code By Ravi For Chat 11-05-15 ----------------------->
	  	<? if($_GET["tab"]=="chat"){	  

	  		$chatpermission=$serailchatpermission=$chatrole=array();
	  		$chatuid=$_GET['view'];	    
	  		$serailchatpermission=$objchat->getPermissionByUser($_GET['view']);	  			
	  	 	if(!empty($serailchatpermission[0]->permission)){	  	 	
	  	 		$chatpermission=unserialize($serailchatpermission[0]->permission);	  	 	
	  	 	}	  	 
	  		$chatroles=$objchat->getchatrole($chatuid);	  		
		  	 if(!empty($chatroles)){
		  	 	foreach($chatroles as $chatro){
		  	 		$chatrole[]=$chatro->rolename;
	
		  	 	}
	  	 	}
	  	?>
			<tr>
				<td colspan="2" align="left" class="head">Chat Permission <input
					type="hidden" value="<?php echo $arryEmployee[0]['Email']; ?>"
					name="Email"></td>
			</tr>
			<tr>
				<td align="" class="blackbold">Internal Chat :</td>
				<td align="" class="blackbold"><?php echo (in_array("internal",$chatpermission)) ? "YES":'NO';?></td>				
			</tr>
			<tr>
				<td align="" class="blackbold">External Chat :</td>
				<td align="" class="blackbold"><?php echo (in_array("external",$chatpermission)) ? "YES":'NO';?></td>				
			
			</tr>
			<tr>
				<td colspan="2" align="left" class="head">Chat Role</td>
			</tr>
			<tr>
				<td align="" class="blackbold">Roles :</td>
				<td align="" class="blackbold"><ul class="chat-role"><li><label>Sales :</label>  <?php echo (in_array("Sales",$chatrole)) ? "YES":'NO';?></li>
				<li><label>Support :</label>  <?php echo (in_array("Support",$chatrole)) ? "YES":'NO';?></li></ul></td>				
			</tr>		
			<style>
.chat-role label {
    float: left;
    width: 48px;
}</style>
			<?php }?>
	<!------------------------ End Code------------------------->
  

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
	   

<? if($arryEmployee[0]['ExistingEmployee']=="1"){ ?>

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
<?}?>


<tr>
	 <td colspan="4">&nbsp;</td>
</tr>
 
<? } ?>


 <? if($_GET["tab"]=="role"){ 
 	include($MainPrefix."includes/html/box/role_view.php");
 } ?>




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
    <? if(!empty($StateName)){ ?>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">
	<?=$StateName?>
	  
	  </td>
	</tr>
<? } ?>
	    
     
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



