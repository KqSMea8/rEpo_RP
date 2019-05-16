 <?  if($_GET['supp']!=''){
  $arrySupplierDt = $objSupplier->GetSupplier('',$_GET['supp'],''); ?>
 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Vendor Detail</td>
	</tr>   
	  
	   <tr>
		  <td align="left" class="blackbold" width="12%">Vendor Code : </td>
		  <td align="left" width="40%" ><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$arrySupplierDt[0]['SuppCode']?>" ><?=$arrySupplierDt[0]["SuppCode"]?></a>	 </td>
		  <td align="left" class="blackbold" width="12%">Contact Name : </td>
		  <td align="left" ><?=stripslashes($arrySupplierDt[0]['UserName'])?>	 </td>
		  
   </tr>
	   <tr>
		  <td align="left" class="blackbold">Company  : </td>
		  <td align="left" ><?=stripslashes($arrySupplierDt[0]['CompanyName'])?></td>
		   <td align="left" class="blackbold">Location : </td>
		  <td align="left" >
		  
	 <?
			$CountryName = stripslashes($arrySupplier[0]["Country"]);
			$StateName = stripslashes($arrySupplier[0]['State']);
			$CityName = stripslashes($arrySupplier[0]['City']);

		   $Address =  '';		   
		   if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';		   
		   if(!empty($StateName)) $Address .= $StateName.', ';		   
		   if(!empty($CountryName)) $Address .= $CountryName;		   
		   if(!empty($arrySupplierDt[0]['ZipCode'])) $Address .= ' - '. $arrySupplierDt[0]['ZipCode'];	
		   
			echo (!empty($Address))?($Address):(NOT_SPECIFIED)

		   ?>	  
		  
		  
		  </td>
   </tr>
  
</table>
<? } ?>