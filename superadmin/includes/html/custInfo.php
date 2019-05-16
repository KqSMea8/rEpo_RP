<SCRIPT LANGUAGE=JAVASCRIPT>
function SetClose(){
	parent.jQuery.fancybox.close();
}

</SCRIPT>
<? if(!empty($ErrorMsg)){
	echo '<div class="redmsg" align="center">'.$ErrorMsg.'</div>';
 }else{ ?>
	<div class="had" style="margin-bottom:5px;"><?php echo stripslashes($arryCustomer[0]['CustomerName']); ?>   </div>
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
<?php echo stripslashes($arryCustomer[0]['FullName']); ?>           </td>
  </tr>
	
<? if($arryCustomer[0]['CustomerType']=='Company'){ ?>  
<tr>
        <td  align="right"   class="blackbold"> Company  Name : </td>
        <td   align="left" >
			
			<?=(!empty($arryCustomer[0]['Company']))?(stripslashes($arryCustomer[0]['Company'])):(NOT_SPECIFIED)?>
			</td>
      </tr>
<? } ?>

	  
  
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
        <td   align="left" > <?=stripslashes($arryCustomer[0]['Landline'])?>			</td>
      </tr>
	  <? } ?>  
	<? if(!empty($arryCustomer[0]['Fax'])){ ?>
<tr>
        <td align="right" class="blackbold" >Fax : </td>
        <td  align="left" ><?=(!empty($arryCustomer[0]['Fax']))?($arryCustomer[0]['Fax']):(NOT_SPECIFIED)?></td>
      </tr> 
	<? } ?>
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
			$Address = '';
		   if(!empty($arryCustomer[0]['Address'])) $Address .=  stripslashes($arryCustomer[0]['Address']).'<br>';		   
		   if(!empty($CityName)) $Address .= htmlentities($CityName).', ';		   
		   if(!empty($StateName)) $Address .= $StateName.', ';		   
		   if(!empty($CountryName)) $Address .= $CountryName;		   
		   if(!empty($arryCustomer[0]['ZipCode'])) $Address .= ' - '. $arryCustomer[0]['ZipCode'];	
		   
			echo (!empty($Address))?($Address):(NOT_SPECIFIED)

		   ?>
		   
		   
		 </td>
        </tr>
   <? if(!empty($arryCustomer[0]['Website'])){ ?>
    <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left">
	<?=(!empty($arryCustomer[0]['Website']))?(stripslashes($arryCustomer[0]['Website'])):(NOT_SPECIFIED)?>
		</td>
      </tr>
	<? } ?>

	
<tr>
			<td  align="right"   class="blackbold" > Sales Person : </td>
			<td   align="left" >
			 <?=(!empty($arryCustomer[0]['sales_person']))?(stripslashes($arryCustomer[0]['sales_person'])):(NOT_SPECIFIED)?>
			
				</td>
		  </tr>	
	


</table>		
	
	
	</td>
	  
  </tr>
</table>
<? } ?>
