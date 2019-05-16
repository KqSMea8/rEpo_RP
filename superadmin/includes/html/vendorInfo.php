<SCRIPT LANGUAGE=JAVASCRIPT>
function SetClose(){
	parent.jQuery.fancybox.close();
}

</SCRIPT>
<? if(!empty($ErrorMsg)){
	echo '<div class="redmsg" align="center">'.$ErrorMsg.'</div>';
 }else{ ?>
<div class="had" style="margin-bottom:5px;"><?=stripslashes($arrySupplier[0]['VendorName'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left">


<table width="100%" border="0" cellpadding="3" cellspacing="0" >

	  
<tr>
  <td  align="right"   class="blackbold" width="25%"> Vendor  Code  :</td>
  <td   align="left" ><?=$arrySupplier[0]['SuppCode']?>  </td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Vendor Type  : </td>
        <td   align="left" ><?php echo stripslashes($arrySupplier[0]['SuppType']); ?>
	</td>
</tr>

<? if($arryCurrentLocation[0]['country_id']!=106 && $arrySupplier[0]['SuppType']=='Individual'){?>
<tr>
        <td align="right"   class="blackbold">Social Security Number  : </td>
        <td  align="left" >
	<?  
	    if(!empty($arrySupplier[0]['SSN'])){
		 $SSNLength = strlen($arrySupplier[0]['SSN']);
		if($SSNLength>5){
			echo 'xxx-xx-'.substr($arrySupplier[0]['SSN'],7,$SSNLength);
		}else{
			echo $arrySupplier[0]['SSN'];
		}
	    }else{	
		echo NOT_SPECIFIED;
	    }

	?>
		
		</td>
      </tr> 
<? } ?>

<tr>
        <td  align="right"   class="blackbold"> Company  Name : </td>
        <td   align="left" >	
        <?=(!empty($arrySupplier[0]['CompanyName']))?($arrySupplier[0]['CompanyName']):(NOT_SPECIFIED)?>
        </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" > Vendor Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arrySupplier[0]['UserName']); ?>           </td>
      </tr>

	  
  
	 <tr>
        <td  align="right"   class="blackbold" >Email : </td>
        <td   align="left" ><?=$arrySupplier[0]['Email']?>		</td>
      </tr>	  

  
		  <tr>
        <td align="right"   class="blackbold" >Mobile :</td>
        <td  align="left"  >
	<?/*=(!empty($arrySupplier[0]['Mobile']))?($arrySupplier[0]['Mobile']):(NOT_SPECIFIED)*/?>

 <?  print preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $arrySupplier[0]['Mobile']). "\n";?>
	</td>
      </tr>
		
		<? if(!empty($arrySupplier[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline :</td>
        <td   align="left" > <?/*=stripslashes($arrySupplier[0]['Landline'])*/?>	<?  //print preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $arrySupplier[0]['Landline']). "\n";?>	

<?  

if($arryCurrentLocation[0]['country_id']==2){
print preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $arrySupplier[0]['Landline']). "\n";
}else if($arryCurrentLocation[0]['country_id']==1){

print preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $arrySupplier[0]['Landline']);


//preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $arrySupplier[0]['Landline']). "\n";

}else{

print preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $arrySupplier[0]['Landline']);

}

?>


	</td>
      </tr>
	  <? } ?>  
	  	 <tr>
        <td align="right" class="blackbold" >Fax : </td>
        <td  align="left" ><?=(!empty($arrySupplier[0]['Fax']))?($arrySupplier[0]['Fax']):(NOT_SPECIFIED)?></td>
      </tr> 


<? 	
	
		/********Connecting to main database*********
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		if($arrySupplier[0]['country_id']>0){
			$arryCountryName = $objRegion->GetCountryName($arrySupplier[0]['country_id']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($arrySupplier[0]['state_id'])) {
			$arryState = $objRegion->getStateName($arrySupplier[0]['state_id']);
			$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arrySupplier[0]['OtherState'])){
			 $StateName = stripslashes($arrySupplier[0]['OtherState']);
		}

		if(!empty($arrySupplier[0]['city_id'])) {
			$arryCity = $objRegion->getCityName($arrySupplier[0]['city_id']);
			$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arrySupplier[0]['OtherCity'])){
			 $CityName = stripslashes($arrySupplier[0]['OtherCity']);
		}

		/*******************************************/	
	



		$Currency = stripslashes($arrySupplier[0]["Currency"]);
		$CountryName = stripslashes($arrySupplier[0]["Country"]);
		$StateName = stripslashes($arrySupplier[0]['State']);
		$CityName = stripslashes($arrySupplier[0]['City']);
	
	?>
	
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :</td>
          <td  align="left" >
		   <?
		   if(!empty($arrySupplier[0]['Address'])) $Address =  stripslashes($arrySupplier[0]['Address']).'<br>';		   
		   if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';		   
		   if(!empty($StateName)) $Address .= $StateName.', ';		   
		   if(!empty($CountryName)) $Address .= $CountryName;		   
		   if(!empty($arrySupplier[0]['ZipCode'])) $Address .= ' - '. $arrySupplier[0]['ZipCode'];	
		   
			echo (!empty($Address))?($Address):(NOT_SPECIFIED)

		   ?>
		   
		   
		 </td>
        </tr>
   
 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left">
	<?=(!empty($arrySupplier[0]['Website']))?(stripslashes($arrySupplier[0]['Website'])):(NOT_SPECIFIED)?>
		</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Currency :</td>
        <td align="left">
	<?=$Currency?>
		</td>
      </tr>
</table>		
	
	
	</td>
	  
  </tr>
</table>
<? } ?>
