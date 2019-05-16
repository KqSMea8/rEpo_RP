
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  

 
   <tr>
            <td class="heading">Find your shop
            </td>
          </tr>



  <tr>
       
    <td align="left" width="100%" valign="top">
	<table cellspacing="0" cellpadding="0"  width="100%">
           
	  <? if($_GET['country']>0 ||  $_GET['state']>0){ ?>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		<?=$Nav_Home?> <a href="shops.php">Shop finder</a> <?=$CountryStateNav?></td>
      </tr>
	  <tr>
        <td height="20"></td>
      </tr> 

	  <tr>
        <td valign="top"><? require_once("includes/html/box/store-listing.php"); ?></td>
      </tr>

	  <? }else{ ?>
  <tr>
    <td height="30" ></td>
  </tr>
	  <tr>
        <td valign="top">
<input type="hidden" name="NumCountry" id="NumCountry" value="<?=sizeof($arryCountry)?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center" >
<tr>
 <? 
   
 
   $i=0;
   
  foreach($arryCountry as $key=>$values){
   $i++;
		
		$CountryLink = 'shops.php?country='.$values['country_id'];
   
		$arryState = $objRegion->getStateByCountry($values['country_id']);

		$StateHtml = '';
		if(sizeof($arryState)>0) {
			foreach($arryState as $key=>$values_state){
				$StateHtml .= '<a href="shops.php?state='.$values_state['state_id'].'">'.stripslashes($values_state['name']).'</a><br>';
			}

			$CountryLink = 'Javascript:ShowState('.$i.');';

		}
		
		

		

		
		
			echo '<td align=center valign="top" width="20%">
				   <table width="100%" border="0" cellspacing="0" cellpadding="2" align=center>
						<tr>
						<td align=left class="txt" valign="top">
						<a href="'.$CountryLink.'" ><b>'.stripslashes($values['name']).'</b></a>
					
						</td>
						</tr>
						 <tr>
						<td align=left  valign="top" class="sub_links"><div id="stateDiv'.$i.'" style="display:none;">'.$StateHtml.'</div></td>
						</tr>
						
					 <tr>
						<td height=15 ></td>
						</tr>
				   </table>
			    </td>';
				
		if($i%5==0)  echo '</tr><tr>';		
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>

		
		</td>
      </tr>

<? } ?>
     
    </table></td>
   
  </tr>
</table>
