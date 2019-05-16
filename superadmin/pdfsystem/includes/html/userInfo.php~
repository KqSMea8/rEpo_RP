<SCRIPT LANGUAGE=JAVASCRIPT>
function SetClose(){
	parent.jQuery.fancybox.close();
}

</SCRIPT>
<? if(!empty($ErrorMsg)){
	echo '<div class="redmsg" align="center">'.$ErrorMsg.'</div>';
 }else{ ?>
	<div class="had" style="margin-bottom:5px;"><?=stripslashes($arryEmployee[0]['UserName'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" >

 <tr>
        <td  align="right"   class="blackbold"> User Code : </td>
        <td   align="left" >
		<strong><?=stripslashes($arryEmployee[0]['EmpCode'])?></strong>
	</td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" width="25%"> Designation   : </td>
        <td   align="left" >
			<?=stripslashes($arryEmployee[0]['JobTitle'])?>		</td>
      </tr>

	
	  	  
	 <tr>
        <td  align="right"   class="blackbold" >Account Email : </td>
        <td   align="left" ><?=$arryEmployee[0]['Email']?>		</td>
      </tr>	  
	<? if(!empty($arryEmployee[0]['PersonalEmail'])){ ?>	  
	 <tr>
        <td align="right"   class="blackbold" >Personal Email : </td>
        <td  align="left" ><?=$arryEmployee[0]['PersonalEmail']?></td>
      </tr> 
	  <? } ?>	  
		  <tr>
        <td align="right"   class="blackbold" >Mobile :</td>
        <td  align="left"  >
	<?=(!empty($arryEmployee[0]['Mobile']))?($arryEmployee[0]['Mobile']):(NOT_SPECIFIED)?>
	</td>
      </tr>
		
	<!--	
	   <tr>
        <td  align="right"   > Date of Birth :  </td>
        <td   align="left" >
		<? if($arryEmployee[0]['date_of_birth']>0) echo date("j M, Y", strtotime($arryEmployee[0]['date_of_birth']));
			else echo NOT_SPECIFIED;
		?>        </td>
      </tr>
<? if($arryEmployee[0]['JoiningDate']>0) { ?>

	   <tr>
        <td  align="right"   > Joining Date :  </td>
        <td   align="left" >
		<? if($arryEmployee[0]['JoiningDate']>0) echo date("j M, Y", strtotime($arryEmployee[0]['JoiningDate'])); ?>        </td>
      </tr>
	  <? } ?>

	-->
<? 	
	
		/********Connecting to main database*********
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************
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
	
	
	  
        <!--tr>
          <td align="right"   class="blackbold" valign="top">Contact Address  :</td>
          <td  align="left" >
		   <?
		   if(!empty($arryEmployee[0]['Address'])) $Address =  stripslashes($arryEmployee[0]['Address']).'<br>';		   
		   if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';		   
		   if(!empty($StateName)) $Address .= $StateName.', ';		   
		   if(!empty($CountryName)) $Address .= $CountryName;		   
		   if(!empty($arryEmployee[0]['ZipCode'])) $Address .= ' - '. $arryEmployee[0]['ZipCode'];	
		   
			echo (!empty($Address))?($Address):(NOT_SPECIFIED)

		   ?>
		   
		   
		 </td>
        </tr-->
   


	

	


</table>		
	
	
	</td>
	 <td align="right" width="20%" valign="top">
	  <?  $MainDir = "../admin/hrms/upload/employee/".$CmpID."/";

         if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ 
		$ImageExist = 1;
	?>
		<? echo '<img src="resizeimage.php?w=200&h=200&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 >';?>
		<?	}else{ ?>
	  <img src="../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryEmployee[0]['UserName']?>" />

		<? } ?>
	 
	 </td>
  </tr>
</table>
<? } ?>
