<?

$arryBillShipp = $objSupplier->GetShippingBilling($_GET['view'],$_GET['tab'],1);
$BillShipp = ucfirst($_GET["tab"]);
$NumBillShipp = sizeof($arryBillShipp);

if($NumBillShipp>0){
	/********Connecting to main database**********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		$allcountry=$objRegion->getCountry();
		
		if($arryBillShipp[0]['country_id']>0){
			$arryCountryName = $objRegion->GetCountryName($arryBillShipp[0]['country_id']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($arryBillShipp[0]['state_id'])) {
			$arryState = $objRegion->getStateName($arryBillShipp[0]['state_id']);
			$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arryBillShipp[0]['OtherState'])){
			 $StateName = stripslashes($arryBillShipp[0]['OtherState']);
		}

		if(!empty($arryBillShipp[0]['city_id'])) {
			$arryCity = $objRegion->getCityName($arryBillShipp[0]['city_id']);
			$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arryBillShipp[0]['OtherCity'])){
			 $CityName = stripslashes($arryBillShipp[0]['OtherCity']);
		}

		/*******************************************/

}
?>
<tr>
       		 <td colspan="2" align="left"   class="head"><?=$BillShipp?> Address</td>
        </tr>
   
<? if($NumBillShipp>0){	
if(empty($_GET['e'])){
?>
			<tr>
				 <td colspan="4">&nbsp;<div style="float:right;"><a href="dashboard.php?curP=1&tab=<?php echo $_GET['tab']?>&e=1" class="fancybox"><img border="0" src="<?php echo _SiteUrl?>admin/images/edit.png"></a></div></td>
			</tr>
			<?php }?>	
<tr>
        <td  align="right"   class="blackbold" ><?=$BillShipp?> Name  : </td>
        <td   align="left" >
         <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['Name']))?($arryBillShipp[0]['Name']):(NOT_SPECIFIED);}else{
			echo '<input name="Name" type="text" class="inputbox" id="Name" value="'.$arryBillShipp[0]['Name'].'" maxlength="40" onkeypress="return isCharKey(event);">';
		
			}?>
         </td>
      </tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :</td>
          <td  align="left" >
           <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['Address']))?($arryBillShipp[0]['Address']):(NOT_SPECIFIED);}else{
			echo '<textarea name="Address" type="text" class="textarea" id="Address">'.$arryBillShipp[0]['Address'].'</textarea>';
		
			}?>		   
		   </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >

<?php

if(empty($_GET['e'])){
	echo (!empty($arryBillShipp[0]['Country']))?(stripslashes($arryBillShipp[0]['Country'])):(NOT_SPECIFIED);}
	else{?>
		<select name="country_id" class="inputbox" id="country_id" onchange="Javascript: StateListSend();">
		<?php if(!empty($allcountry)){
			foreach($allcountry as $country){
				$select=($country['name']==$arryBillShipp[0]['Country'])?'Selected="selected"':"";
			echo '<option value="'.$country['country_id'].'" '.$select.'>'.$country['name'].'</option>';
			}}?>
		</select>
		
	<?php }?>

		        </td>
      </tr>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal" id="state_td">

		<?=(!empty($StateName))?($StateName):(NOT_SPECIFIED)?>

	  
	  </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv">City   :</div></td>
        <td  align="left"  ><div id="city_td">
				<?=(!empty($CityName))?($CityName):(NOT_SPECIFIED)?>		</div>
		</td>
      </tr> 
	    
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
        <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['ZipCode']))?($arryBillShipp[0]['ZipCode']):(NOT_SPECIFIED);}else{
			echo '<input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="'.$arryBillShipp[0]['ZipCode'].'" maxlength="15">';
		
			}?>

				</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
        <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['Mobile']))?($arryBillShipp[0]['Mobile']):(NOT_SPECIFIED);}else{
			echo '<input name="Mobile" type="text" class="inputbox" id="Mobile" value="'.$arryBillShipp[0]['Mobile'].'" maxlength="20">';
		
			}?>
		</td>
      </tr>
		<? if(!empty($arryBillShipp[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
        <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['Landline']))?($arryBillShipp[0]['Landline']):(NOT_SPECIFIED);}else{
			echo '<input name="Landline" type="text" class="inputbox" id="Landline" value="'.$arryBillShipp[0]['Landline'].'" maxlength="20">';
		
			}?>
			</td>
      </tr>
		<? } ?>
	    <tr>
        <td align="right"   class="blackbold" >Fax  : </td>
        <td  align="left" >
        
        <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['Fax']))?($arryBillShipp[0]['Fax']):(NOT_SPECIFIED);}else{
			echo '<input name="Fax" type="text" class="inputbox" id="Fax" value="'.$arryBillShipp[0]['Fax'].'" maxlength="15">';
		
			}?>
		
		</td>
      </tr> 

	  	  <tr>
        <td align="right" class="blackbold">Email  : </td>
        <td  align="left" >
        <?php if(empty($_GET['e'])){
			echo (!empty($arryBillShipp[0]['Email']))?($arryBillShipp[0]['Email']):(NOT_SPECIFIED);}else{
			echo '<input name="Email" type="text" class="inputbox" id="Email" value="'.$arryBillShipp[0]['Email'].'" maxlength="15">';
		
			}?>
	 </td>
      </tr> 
      <?php if(!empty($_GET['e'])){
		  	echo '<tr><td>&nbsp;</td>  <td align="" height="135" valign="top"><br><input type="hidden" name="SuppID" id="SuppID" value="'.$Customer_ID.'">
		  	<input type="hidden" name="UserID" id="UserID" value="0">
		  	<input name="Submit" type="submit" class="button" id="UpdateBank" value="Update">&nbsp;</td>  </tr>';
		  }?>
         <input type="hidden" name="main_state_id" id="main_state_id" value="<?php echo $arryBillShipp[0]['state_id']?>">
     	 <input type="hidden" name="main_city_id" id="main_city_id" value="<?php echo $arryBillShipp[0]['city_id']?>">
<? } else{ ?>
<tr>
       		 <td colspan="2" height="300" align="center"><?=NOT_SPECIFIED?></td>
        </tr>
<? } ?>


