<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top">
	
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
				<td height="20" class="blacktxt">
				
	<?
	$arryState = $objRegion->getStateByCountry($_GET['country']);

		$StateHtml = '';
		if(sizeof($arryState)>0) {
			$StateHtml = '<strong>State / Region :	</strong> ';
			foreach($arryState as $key=>$values_state){
				$StateHtml .= '<div style="float:left; width:120px; padding-right:10px;padding-top:10px;"><a href="shops.php?state='.$values_state['state_id'].'&country='.$_GET['country'].'">'.stripslashes($values_state['name']).'</a></div>';
			}
			
			echo $StateHtml;

		}
	?>			
				
				</td>
				</tr> 
				<tr>
				<td height="20"></td>
				</tr> 			
				<tr>
				<td valign="top"><? require_once("includes/html/box/store-listing.php"); ?></td>
				</tr>
				
			<? }else{ ?>
				<tr>
				<td>
	<div id="light" class="white_content"  >	
<form name="from_cnt" action="shops.php" method="get" onsubmit="return validateCountry(this);">	
<table width="95%" border="0" cellpadding="0" cellspacing="0"  align="center" >
  <tr>
            <td class="heading" colspan="3">Find your shop
            </td>
          </tr>
 <tr  >
          <td  align="left" height="50" class="txt" colspan="3" >
		 <strong> Please select a country first to find a shop.</strong>
		  </td>
		  </tr>
 <tr  >
          <td  align="left" height="30" class="generaltxt" width="100" >
             
         Country</td>
     
	<td align="left" width="220">
	 <select name="country" class="txtfield_normal" id="country" >
	 	<option value="">---Select---</option>
		<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
		<option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
		<?=$arryCountry[$i]['name']?>
		</option>
		<? } ?>
    </select>
	</td>
	<td align="left"  >
		<input type="submit" name="cnt_sb" value="Search" class="searchbutton" style="float:left"/>
	</td>
	
			
</tr>
</table>
</form>	
<input type="hidden" name="main_state_id" id="main_state_id"  value="<? echo $arryMember[0]['state_id']; ?>" />
            <input type="hidden" name="main_city_id" id="main_city_id"  value="<? echo $arryMember[0]['city_id']; ?>" />

	</div> 			
				
				</td>
				</tr>	
			<? } ?>	
			</table>
	
	
	
	

</td>
    </td>

  </tr>
</table>
	
		
<div id="fade" class="black_overlay"></div>
<script language="javascript1.2" type="text/javascript">
ChooseCountry();	
function ChooseCountry(){
	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
}
</script>