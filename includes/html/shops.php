
 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
       
	    <td width="22%" align="left" valign="top">
		
<? if(!empty($_GET['country'])){ ?>		
<table width="197" border="0" cellspacing="0" cellpadding="0">
 <tr>
		<td class="leftnavheader" >Country</td>
	  </tr>
	  <tr>
		<td align="left" class="leftnav" style="padding-left:20px;padding-top:10px;padding-bottom:10px;">
		<form name="left_cntry" action="shops.php" method="get" >
		<select name="country" class="txtfield" id="country" onchange="Javascript:ChangeLeftCountry();" style="width:160px;">
	 	<option value="">---Select---</option>
		<? for($i=0;$i<sizeof($arryCountryList);$i++) {?>
		<option value="<?=$arryCountryList[$i]['country_id']?>" <?  if($arryCountryList[$i]['country_id']==$_GET['country']){echo "selected";}?>>
		<?=$arryCountryList[$i]['name']?>
		</option>
		<? } ?>
    </select>
		<input type="hidden" name="cat" value="<?=$_GET['cat']?>" />
		</form>
		</td>
	</tr>	
</table>	
<? } ?>	
		<? 
		include("includes/html/box/left_category.php");
		 ?></td>
		
		
		<td valign="top">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
   
 <? 
			if($TopCatID>0 && $ModuleImagePath==''){
				$arrayModuleImage = $objCategory->GetCategoryNameByID($TopCatID);
				if($arrayModuleImage[0]['Image']!='' && file_exists("upload/category/".$arrayModuleImage[0]['Image'])){
					$ModuleImagePath = 'resizeimage.php?img=upload/category/'.$arrayModuleImage[0]['Image'].'&w=730&h=730'; 
				}
			}

			if($ModuleImagePath!=''){
			?>
          <tr>
            <td ><img src="<?=$ModuleImagePath?>"  style="padding-bottom:24px;"/></td>
          </tr>
		  <? } ?>  
   
   
   
   
     <tr>
            <td class="heading">Find your shop
            </td>
          </tr>
  <tr>
    <td align="left"  width="100%" valign="top">
	
			<table cellspacing="0" cellpadding="0"  width="100%">
			   
			<? if($_GET['country']>0 ||  $_GET['state']>0){ ?>
				<tr>
				<td height="32" align="left" valign="middle" class="pagenav">
				<?=$Nav_Home?> <a href="shops.php?cat=<?=$_GET['cat']?>">Shop finder</a> <?=$CountryStateNav?></td>
				</tr>
				<tr>
				<td height="20"></td>
				</tr> 
		<tr>
				<td class="blacktxt">
				
	<?
	//$arryState = $objRegion->getStateByCountry($_GET['country']);

		$StateHtml = '';
		if(sizeof($arryState)>0) {
			$StateHtml = '<strong>State / Region :	</strong> ';
			foreach($arryState as $key=>$values_state){
				$StateHtml .= '<div style="float:left; width:120px; padding-right:10px;padding-top:10px;"><a href="shops.php?state='.$values_state['state_id'].'&country='.$_GET['country'].'&cat='.$_GET['cat'].'">'.stripslashes($values_state['name']).'</a></div>';
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
				
			<? }else{ 
			
			$CancelUrl = $_SERVER['HTTP_REFERER'];
			if(empty($CancelUrl)) $CancelUrl='index.php';
			?>
				<tr>
				<td>
	<div id="light" class="white_content" style="background:none;border:0px;"  >	
<form name="from_cnt" action="shops.php" method="get" onsubmit="return validateCountry(this);">	

<table width="420" border="0" cellpadding="0" cellspacing="0"  align="center"   >
  <tr  >
          <td height="11" ><img src="images/top.gif"></td>
        </tr>
		
	  <tr  >
          <td valign="top" bgcolor="#FFFFFF" >
		  
		<table width="90%" border="0" cellpadding="0" cellspacing="0"  align="center"   >
		  
         	
		
  <tr>
            <td class="heading" colspan="3" bgcolor="#FFFFFF">
			 <div style="float:right"><a href="<?=$CancelUrl?>"><img src="images/delete.png" border="0"></a></div>
			Find your shop
            </td>
          </tr>
		  
  	  <tr  >
          <td  align="left" colspan="3" bgcolor="#FFFFFF">&nbsp;
          </td>
        </tr>	
		  
 <tr  >
          <td  align="left"  class="txt" colspan="3" bgcolor="#FFFFFF">
		 <strong> Please select a country first to find a shop.</strong>
		  </td>
		  </tr>
		  	  <tr  >
          <td  align="left" colspan="3" bgcolor="#FFFFFF">&nbsp;
          </td>
        </tr>	
 <tr  >
          <td  align="left"  class="generaltxt" width="110" bgcolor="#FFFFFF">
             
         Select Country :</td>
     
	<td align="left" width="220" bgcolor="#FFFFFF">
	 <select name="country" class="txtfield_normal" id="country" >
	 	<option value="">---Select---</option>
		<? for($i=0;$i<sizeof($arryCountryList);$i++) {?>
		<option value="<?=$arryCountryList[$i]['country_id']?>" <?  if($arryCountryList[$i]['country_id']==$CountrySelected){echo "selected";}?>>
		<?=$arryCountryList[$i]['name']?>
		</option>
		<? } ?>
    </select>
	</td>
	<td align="left" bgcolor="#FFFFFF" >
		<input type="hidden" name="cat" value="<?=$_GET['cat']?>" />
		<input type="submit" name="cnt_sb" value="Search" class="searchbutton" style="float:left"/>
	</td>
	
			
</tr>

	  <tr  >
          <td  align="left" colspan="3" bgcolor="#FFFFFF" height="15">
          </td>
        </tr>
		
		
		
		</table>
		 </td>
        </tr>
		
		
		 <tr  >
          <td height="11"><img src="images/bottom.gif"></td>
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

  </tr>
</table>


    </td>

  </tr>
</table>


	
		
<div id="fade" class="black_overlay"></div>
<script language="javascript1.2" type="text/javascript">

ChooseCountry();	
function ChooseCountry(){
	document.getElementById('fade').style.width = screen.width;

	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
}
</script>