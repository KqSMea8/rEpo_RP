	<div class="had" style="margin-bottom:5px;">Location Detail</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left">
<div style="position:relative;"><? 
if(!empty($arryLocation[0]['Timezone'])){ 
$arryCurrentLocation[0]['Timezone'] = $arryLocation[0]['Timezone'];
include("includes/html/box/clock.php"); 
}?></div>

	<table width="100%" border="0" cellpadding="5" cellspacing="1" >
                   
   <tr>
          <td align="right"   class="blackbold" valign="top" width="42%"> Address  :</td>
          <td  align="left" >
            <?=nl2br(stripslashes($arryLocation[0]['Address']))?>		          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?=stripslashes($arryLocation[0]['Country'])?>       </td>
      </tr>

	<? if(!empty($arryLocation[0]['State'])){ ?>
     <tr>
	  <td  align="right" valign="middle" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal"><?=stripslashes($arryLocation[0]['State'])?>  </td>
	</tr>
<? } ?>
	   
	   <tr>
        <td  align="right"   class="blackbold"> City   :</td>
        <td  align="left"  ><?=stripslashes($arryLocation[0]['City'])?></td>
      </tr> 
	   
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	<?=stripslashes($arryLocation[0]['ZipCode'])?>		</td>
      </tr>
       
	  <tr>
        <td align="right"   class="blackbold" valign="top" >Timezone  :</td>
        <td  align="left"  valign="top" >


	<?=stripslashes($arryLocation[0]['Timezone'])?>	
		</td>
      </tr>  
	   
	       
	<tr>
        <td  align="right"   class="blackbold" > Currency  :</td>
        <td   align="left" >
			<?=stripslashes($arryCurrency[0]['name'])?>	
       </td>
      </tr>			





<?php
	$CountrySelected = $arryLocation[0]['country_id']; 

	$StyleUS  = "style='display:none;'";
	$StyleIndia  = "style='display:none;'";

	if($CountrySelected=='1'){ //us
		$StyleUS  = "";
	}else if($CountrySelected=='106' || $CountrySelected=='234'){ //india or uae 
		$StyleIndia  = "";
	} 

?>

	<? if(!empty($arryLocation[0]['EIN'])){ ?>
<tr <?=$StyleUS?> class="ClassUS" >
        <td  align="right"   class="blackbold">EIN  :</td>
        <td   align="left" >
	 <?=stripslashes($arryLocation[0]['EIN'])?> 
	</td>
      </tr>
 	<? }
	if(!empty($arryLocation[0]['VAT'])){ ?>
      
      <tr <?=$StyleIndia?> class="ClassIndia">
        <td  align="right"   class="blackbold">VAT No  :</td>
        <td   align="left" >
	 <?=stripslashes($arryLocation[0]['VAT'])?> 
	</td>
      </tr>
      <? }
	if(!empty($arryLocation[0]['CST'])){ ?>
      <tr <?=$StyleIndia?> class="ClassIndia">
        <td  align="right"   class="blackbold">CST No :</td>
        <td   align="left" >
	 <?=stripslashes($arryLocation[0]['CST'])?> 
	</td>
      </tr>
	 <? }
	if(!empty($arryLocation[0]['TRN'])){ ?>
	<tr <?=$StyleIndia?> class="ClassIndia" >

        <td  align="right"   class="blackbold">TRN No :</td>
        <td   align="left" >
	  <?=stripslashes($arryLocation[0]['TRN'])?> 
		 
	  		
	</td>
      </tr>
	 <? }
	  ?>


	<tr>
        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <? 
			if($arryLocation[0]['Status'] == 1) {echo 'Active';}else{echo 'InActive'; }
		  ?>
        
		   </td>
      </tr>			
				
				
				                 
                   
                  </table>



	
	
	</td>
	
  </tr>
</table>






	
	
	
	
	

  



