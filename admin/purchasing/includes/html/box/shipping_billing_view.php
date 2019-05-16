<?
$arryBillShipp = $objSupplier->GetShippingBilling($_GET['view'],$_GET['tab']);
$BillShipp = ucfirst($_GET["tab"]);
$NumBillShipp = sizeof($arryBillShipp);

if($NumBillShipp>0){
	/********Connecting to main database*********
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************
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
   
<? if($NumBillShipp>0){ ?>
<tr>
        <td  align="right"   class="blackbold" ><?=$BillShipp?> Name  : </td>
        <td   align="left" >
	<?=(!empty($arryBillShipp[0]['Name']))?(stripslashes($arryBillShipp[0]['Name'])):(NOT_SPECIFIED)?>
         </td>
      </tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :</td>
          <td  align="left" >
	<?=(!empty($arryBillShipp[0]['Address']))?(nl2br(stripslashes($arryBillShipp[0]['Address']))):(NOT_SPECIFIED)?>
		   
		   
		   </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >

<?=(!empty($arryBillShipp[0]['CountryName']))?(stripslashes($arryBillShipp[0]['CountryName'])):(NOT_SPECIFIED)?>

		        </td>
      </tr>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">

<?=(!empty($arryBillShipp[0]['StateName']))?(stripslashes($arryBillShipp[0]['StateName'])):(NOT_SPECIFIED)?>

	  
	  </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold">City   :</td>
        <td  align="left"  >
<?=(!empty($arryBillShipp[0]['CityName']))?(stripslashes($arryBillShipp[0]['CityName'])):(NOT_SPECIFIED)?>


		</td>
      </tr> 
	    
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	<?=(!empty($arryBillShipp[0]['ZipCode']))?($arryBillShipp[0]['ZipCode']):(NOT_SPECIFIED)?>

				</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=(!empty($arryBillShipp[0]['Mobile']))?($arryBillShipp[0]['Mobile']):(NOT_SPECIFIED)?>

		</td>
      </tr>
		<? if(!empty($arryBillShipp[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" > <?=stripslashes($arryBillShipp[0]['Landline'])?>	
		
			</td>
      </tr>
		<? } ?>
	    <tr>
        <td align="right"   class="blackbold" >Fax  : </td>
        <td  align="left" >
	<?=(!empty($arryBillShipp[0]['Fax']))?(stripslashes($arryBillShipp[0]['Fax'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 

	  	  <tr>
        <td align="right" class="blackbold">Email  : </td>
        <td  align="left" >
	<?=(!empty($arryBillShipp[0]['Email']))?(stripslashes($arryBillShipp[0]['Email'])):(NOT_SPECIFIED)?>
	 </td>
      </tr> 
<? } else{ ?>
<tr>
       		 <td colspan="2" height="300" align="center"><?=NOT_SPECIFIED?></td>
        </tr>
<? } ?>


