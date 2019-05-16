<? if(empty($ErrorExist)){ ?>

<div class="had" style="margin-bottom:5px;"><?=stripslashes($arryCustomer[0]['CompanyName'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left">


<table width="100%" border="0" cellpadding="3" cellspacing="0" >

	  
<tr>
  <td  align="right"   class="blackbold" width="20%"> Customer  Code  :</td>
  <td   align="left" ><?=$arryCustomer[0]['CustCode']?>  </td>
</tr>
<tr>
        <td  align="right"   class="blackbold" > Customer Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCustomer[0]['FirstName']. " ".$arryCustomer[0]['LastName']); ?>           </td>
  </tr>
	  
<tr>
        <td  align="right"   class="blackbold"> Company  Name : </td>
        <td   align="left" >
			
			<?=(!empty($arryCustomer[0]['Company']))?(stripslashes($arryCustomer[0]['Company'])):(NOT_SPECIFIED)?>
			</td>
      </tr>


	  
  
	 <tr>
        <td  align="right"   class="blackbold" >Email : </td>
        <td   align="left" ><?=$arryCustomer[0]['Email']?>		</td>
      </tr>	  

  
		  <tr>
        <td align="right"   class="blackbold" >Mobile :</td>
        <td  align="left"  >
	<?=(!empty($arryCustomer[0]['Mobile']))?($arryCustomer[0]['Mobile']):(NOT_SPECIFIED)?>
	</td>
      </tr>
		
		<? if(!empty($arryCustomer[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline :</td>
        <td   align="left" >


<?  

if($arryCurrentLocation[0]['country_id']==2){
print preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $arryCustomer[0]['Landline']). "\n";
}else if($arryCurrentLocation[0]['country_id']==1){

print preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $arryCustomer[0]['Landline']);


//preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $arrySupplier[0]['Landline']). "\n";

}else{

print preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $arryCustomer[0]['Landline']);

}

?>







 <?/*=stripslashes($arryCustomer[0]['Landline'])*/?>			</td>
      </tr>
	  <? } ?>  
	  	 <tr>
        <td align="right" class="blackbold" >Fax : </td>
        <td  align="left" ><?=(!empty($arryCustomer[0]['Fax']))?($arryCustomer[0]['Fax']):(NOT_SPECIFIED)?></td>
      </tr> 


<? 	
	

		$Currency = stripslashes($arryCustomer[0]["Currency"]);
		$CountryName = stripslashes($arryCustomer[0]["CountryName"]);
		$StateName = stripslashes($arryCustomer[0]['StateName']);
		$CityName = stripslashes($arryCustomer[0]['CityName']);
	
	?>
	
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :</td>
          <td  align="left" >
		   <?
		   if(!empty($arryCustomer[0]['Address'])) $Address =  stripslashes($arryCustomer[0]['Address']).'<br>';		   
		   if(!empty($CityName)) $Address .= htmlentities($CityName).', ';		   
		   if(!empty($StateName)) $Address .= $StateName.', ';		   
		   if(!empty($CountryName)) $Address .= $CountryName;		   
		   if(!empty($arryCustomer[0]['ZipCode'])) $Address .= ' - '. $arryCustomer[0]['ZipCode'];	
		   
			echo (!empty($Address))?($Address):(NOT_SPECIFIED)

		   ?>
		   
		   
		 </td>
        </tr>
   
    <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left">
	<?=(!empty($arryCustomer[0]['Website']))?(stripslashes($arryCustomer[0]['Website'])):(NOT_SPECIFIED)?>
		</td>
      </tr>


</table>		
	
	
	</td>
	 <td align="right" width="20%" valign="top">
	  <?

$MainDir = "upload/customer/".$_SESSION['CmpID']."/";
 if($arryCustomer[0]['Image'] !='' && file_exists($MainDir.$arryCustomer[0]['Image']) ){ 
		$ImageExist = 1;
	?>
		 <? echo '<img src="resizeimage.php?w=200&h=200&img='.$MainDir.$arryCustomer[0]['Image'].'" border=0 >';?>
		<?	}else{ ?>
	        <img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryCustomer[0]['FirstName']?>" />

		<? } ?>
	 
	 </td>
  </tr>
</table>
<? } ?>
