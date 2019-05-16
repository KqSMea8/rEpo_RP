<SCRIPT LANGUAGE=JAVASCRIPT>
function SetClose(){
	parent.jQuery.fancybox.close();
}

</SCRIPT>
<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;"><?=stripslashes($arryReseller[0]['FullName'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left">


<table width="100%" border="0" cellpadding="3" cellspacing="0" >

 <tr>
        <td  align="right"   class="blackbold" width="25%"> Company Name : </td>
        <td   align="left" >
<?=(!empty($arryReseller[0]['CompanyName']))?(stripslashes($arryReseller[0]['CompanyName'])):(NOT_SPECIFIED)?>

	</td>
      </tr>

	  	  
	 <tr>
        <td  align="right"   class="blackbold" >Account Email : </td>
        <td   align="left" ><?=$arryReseller[0]['Email']?>		</td>
      </tr>	  
	  
		  <tr>
        <td align="right"   class="blackbold" >Mobile :</td>
        <td  align="left"  >
	<?=(!empty($arryReseller[0]['Mobile']))?($arryReseller[0]['Mobile']):(NOT_SPECIFIED)?>
	</td>
      </tr>
		



<? 	
	
		if($arryReseller[0]['country_id']>0){
			$arryCountryName = $objRegion->GetCountryName($arryReseller[0]['country_id']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($arryReseller[0]['state_id'])) {
			$arryState = $objRegion->getStateName($arryReseller[0]['state_id']);
			$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arryReseller[0]['OtherState'])){
			 $StateName = stripslashes($arryReseller[0]['OtherState']);
		}

		if(!empty($arryReseller[0]['city_id'])) {
			$arryCity = $objRegion->getCityName($arryReseller[0]['city_id']);
			$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arryReseller[0]['OtherCity'])){
			 $CityName = stripslashes($arryReseller[0]['OtherCity']);
		}

		/*******************************************/	
	
	
	
	?>
	
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top"> Address  :</td>
          <td  align="left" >
		   <?
		   if(!empty($arryReseller[0]['Address'])) $Address =  stripslashes($arryReseller[0]['Address']).'<br>';		   
		   if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';		   
		   if(!empty($StateName)) $Address .= $StateName.', ';		   
		   if(!empty($CountryName)) $Address .= $CountryName;		   
		   if(!empty($arryReseller[0]['ZipCode'])) $Address .= ' - '. $arryReseller[0]['ZipCode'];	
		   
			echo (!empty($Address))?($Address):(NOT_SPECIFIED)

		   ?>
		   
		   
		 </td>
        </tr>
   


	

	


</table>		
	
	
	</td>
	
  </tr>
</table>
<? } ?>
