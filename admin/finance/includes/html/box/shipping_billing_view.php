<?
$arryBillShipp = $objSupplier->GetShippingBilling($_GET['view'],$_GET['tab'],null,' Status DESC , AddID DESC');
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
   
<? if($NumBillShipp>0){
 echo '<tr><td>';
    $i=0;
     foreach($arryBillShipp as $v){
?>
 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall <?php echo empty($arryBillShipp[$i]['Status'])?'no-active':'';?>">
<tr>
        <td  align="right"   class="blackbold" ><?=$BillShipp?> Name  : </td>
        <td   align="left" >
	<?=(!empty($arryBillShipp[0]['Name']))?(stripslashes($arryBillShipp[$i]['Name'])):(NOT_SPECIFIED)?>
         </td>
      </tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :</td>
          <td  align="left" >
	<?=(!empty($arryBillShipp[0]['Address']))?(nl2br(stripslashes($arryBillShipp[$i]['Address']))):(NOT_SPECIFIED)?>
		   
		   
		   </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >

	<?=(!empty($arryBillShipp[$i]['Country']))?(stripslashes($arryBillShipp[$i]['Country'])):(NOT_SPECIFIED)?>

		        </td>
      </tr>

<? if(!empty($arryBillShipp[$i]['State'])){ ?>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">

<?=stripslashes($arryBillShipp[$i]['State'])?>

	  
	  </td>
	</tr>
	   <? } ?> 
     
	   <tr>
        <td  align="right"   class="blackbold">City   :</td>
        <td  align="left"  >
<?=(!empty($arryBillShipp[$i]['City']))?(stripslashes($arryBillShipp[$i]['City'])):(NOT_SPECIFIED)?>


		</td>
      </tr> 
	    
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	<?=(!empty($arryBillShipp[$i]['ZipCode']))?($arryBillShipp[$i]['ZipCode']):(NOT_SPECIFIED)?>

				</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=(!empty($arryBillShipp[$i]['Mobile']))?($arryBillShipp[$i]['Mobile']):(NOT_SPECIFIED)?>

		</td>
      </tr>
		<? if(!empty($arryBillShipp[$i]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" > <?=stripslashes($arryBillShipp[0]['Landline'])?>	
		
			</td>
      </tr>
		<? } ?>
	    <tr>
        <td align="right"   class="blackbold" >Fax  : </td>
        <td  align="left" >
	<?=(!empty($arryBillShipp[$i]['Fax']))?(stripslashes($arryBillShipp[$i]['Fax'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 

	  	  <tr>
        <td align="right" class="blackbold">Email  : </td>
        <td  align="left" >
	<?=(!empty($arryBillShipp[$i]['Email']))?(stripslashes($arryBillShipp[$i]['Email'])):(NOT_SPECIFIED)?>
	 </td>
      </tr> 
      </table>
      <?php $i++;} echo '</tr></td>';} else{ ?>
<tr>
       		 <td colspan="2" height="300" align="center"><?=NOT_SPECIFIED?></td>
        </tr>
<? } ?>


