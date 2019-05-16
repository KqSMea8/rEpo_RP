<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1"   method="post">
  
  <? if (!empty($_SESSION['mess_supplier'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_supplier'])) {echo $_SESSION['mess_supplier']; unset($_SESSION['mess_supplier']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<? if($_GET["tab"]=="general"){ ?>
<tr>
	 <td colspan="2" align="left" class="head">General Information</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Vendor Code  : </td>
        <td   align="left" ><?php echo stripslashes($arrySupplier[0]['SuppCode']); ?>
	</td>
</tr>
<tr>
	     <td  align="right"  class="blackbold" width="45%">Company Name : </td>
	     <td   align="left" >
		<?=stripslashes($arrySupplier[0]['CompanyName'])?>		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold" > Contact Name : </td>
        <td   align="left" >
<?php echo stripslashes($arrySupplier[0]['UserName']); ?>           </td>
      </tr>

	
	   
      <tr>
        <td  align="right"   class="blackbold" > Email : </td>
        <td   align="left" ><?php echo $arrySupplier[0]['Email']; ?>		</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=(!empty($arrySupplier[0]['Mobile']))?($arrySupplier[0]['Mobile']):(NOT_SPECIFIED)?>

		</td>
      </tr>
		<? if(!empty($arrySupplier[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" > <?=stripslashes($arrySupplier[0]['Landline'])?>	
		
			</td>
      </tr>
		<? } ?>
	    <tr>
        <td align="right"   class="blackbold" >Fax  : </td>
        <td  align="left" >
	<?=(!empty($arrySupplier[0]['Fax']))?(stripslashes($arrySupplier[0]['Fax'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left">
	<?=(!empty($arrySupplier[0]['Website']))?(stripslashes($arrySupplier[0]['Website'])):(NOT_SPECIFIED)?>
		</td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Currency :</td>
        <td   align="left" >
		<?=$arrySupplier[0]['Currency']?>
          </td>
      </tr>
	    <tr>
        <td align="right"   class="blackbold" >Vendor Since :</td>
        <td  align="left"  >
 <?=($arrySupplier[0]['SupplierSince']>0)?(date($Config['DateFormat'], strtotime($arrySupplier[0]['SupplierSince']))):(NOT_SPECIFIED)?>

				</td>
      </tr>
	<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	<?=(!empty($arrySupplier[0]['PaymentTerm']))?(stripslashes($arrySupplier[0]['PaymentTerm'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

	<tr>
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arrySupplier[0]['PaymentMethod']))?(stripslashes($arrySupplier[0]['PaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

	<tr>
			<td  align="right"   class="blackbold" > Shipping Method  : </td>
			<td   align="left" >
	<?=(!empty($arrySupplier[0]['ShippingMethod']))?(stripslashes($arrySupplier[0]['ShippingMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>


	<? 
	$arryExisting = $arrySupplier;
	include("includes/html/box/custom_field_view.php");
	?>

	  <tr>
        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <?  echo ($arrySupplier[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>

<? } ?>


<? if($_GET['tab'] == "contacts"){ ?>
<tr>
	<td colspan="2" align="left" class="head">Contacts </td>
</tr>	
<tr>
	<td colspan="2" align="left">
<? 
$SuppID = $_GET['view'];
include("includes/html/box/supplier_contacts.php");
?>
</td>
</tr>	
<? } ?> 


<? if($_GET["tab"]=="contact"){
	
	
		/********Connecting to main database*********
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		if($arrySupplier[0]['country_id']>0){
			$arryCountryName = $objRegion->GetCountryName($arrySupplier[0]['country_id']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($arrySupplier[0]['state_id'])) {
			$arryState = $objRegion->getStateName($arrySupplier[0]['state_id']);
			$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arrySupplier[0]['OtherState'])){
			 $StateName = stripslashes($arrySupplier[0]['OtherState']);
		}

		if(!empty($arrySupplier[0]['city_id'])) {
			$arryCity = $objRegion->getCityName($arrySupplier[0]['city_id']);
			$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arrySupplier[0]['OtherCity'])){
			 $CityName = stripslashes($arrySupplier[0]['OtherCity']);
		}

		/*******************************************/	
	
		$CountryName = stripslashes($arrySupplier[0]["Country"]);
		$StateName = stripslashes($arrySupplier[0]['State']);
		$CityName = stripslashes($arrySupplier[0]['City']);

	?>
	
	<tr>
       		 <td colspan="2" align="left"   class="head">Contact Information</td>
        </tr>
  
	<tr>
        <td  align="right"   class="blackbold" > Contact Name : </td>
        <td   align="left" >
<?php echo stripslashes($arrySupplier[0]['UserName']); ?>           </td>
      </tr>

	
	   
      <tr>
        <td  align="right"   class="blackbold" > Email : </td>
        <td   align="left" ><?php echo $arrySupplier[0]['Email']; ?>		</td>
      </tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :</td>
          <td  align="left" >
	<?=(!empty($arrySupplier[0]['Address']))?(nl2br(stripslashes($arrySupplier[0]['Address']))):(NOT_SPECIFIED)?>
		   
		   
		   </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
	<?=(!empty($CountryName))?($CountryName):(NOT_SPECIFIED)?>


		        </td>
      </tr>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">
	<?=(!empty($StateName))?($StateName):(NOT_SPECIFIED)?>
	  
	  </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold">City   :</td>
        <td  align="left"  >
	<?=(!empty($CityName))?($CityName):(NOT_SPECIFIED)?>

		</td>
      </tr> 
	    
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	<?=(!empty($arrySupplier[0]['ZipCode']))?($arrySupplier[0]['ZipCode']):(NOT_SPECIFIED)?>

				</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=(!empty($arrySupplier[0]['Mobile']))?($arrySupplier[0]['Mobile']):(NOT_SPECIFIED)?>

		</td>
      </tr>
		<? if(!empty($arrySupplier[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" > <?=stripslashes($arrySupplier[0]['Landline'])?>	
		
			</td>
      </tr>
		<? } ?>
	    <tr>
        <td align="right"   class="blackbold" >Fax  : </td>
        <td  align="left" >
	<?=(!empty($arrySupplier[0]['Fax']))?(stripslashes($arrySupplier[0]['Fax'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left">
	<?=(!empty($arrySupplier[0]['Website']))?(stripslashes($arrySupplier[0]['Website'])):(NOT_SPECIFIED)?>
		</td>
      </tr>



<? } ?>




 
  <? if($_GET["tab"]=="bank"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Bank Details</td>
        </tr>
		
	 <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
        <td   align="left" >
	<?=(!empty($arrySupplier[0]['BankName']))?(stripslashes($arrySupplier[0]['BankName'])):(NOT_SPECIFIED)?>

            </td>
      </tr>	
	 <tr>
        <td  align="right"   class="blackbold"> Account Name  : </td>
        <td   align="left" >
	<?=(!empty($arrySupplier[0]['AccountName']))?(stripslashes($arrySupplier[0]['AccountName'])):(NOT_SPECIFIED)?>
			 </td>
      </tr>	  
	  <tr>
        <td  align="right"   class="blackbold"> Account Number  : </td>
        <td   align="left" >
	<?=(!empty($arrySupplier[0]['AccountNumber']))?(stripslashes($arrySupplier[0]['AccountNumber'])):(NOT_SPECIFIED)?>
			 </td>
      </tr>	
	   <tr>
        <td  align="right"   class="blackbold"> Routing Number :</td>
        <td   align="left" >
 	<?=(!empty($arrySupplier[0]['IFSCCode']))?(stripslashes($arrySupplier[0]['IFSCCode'])):(NOT_SPECIFIED)?>
			 </td>
      </tr>	
	  
	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
  <? } ?>
 



<? if($_GET["tab"]=="currency"){ ?>  
	<!--
		<tr>
       		 <td colspan="2" align="left" class="head">Currency</td>
        </tr>
		
	 <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
	 <tr>
        <td  align="right"   class="blackbold" width="45%"> Currency  :</td>
        <td   align="left" >
		<?
		if($arrySupplier[0]['currency_id'] > 0 ){
			$CurrencySelected = $arrySupplier[0]['currency_id']; 
		}else{
			$CurrencySelected = 9;
		}
		/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		$arryCurrency = $objRegion->getCurrency($CurrencySelected,'');
		$Currency = $arryCurrency[0]['name'].'&nbsp;&nbsp;['.$arryCurrency[0]['code'].']';

		echo $Currency;



		?>
                   </td>
      </tr>


	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		-->
  <? } ?>




 
<? 
if($_GET["tab"]=="shipping" || $_GET["tab"]=="billing"){ 
	include("includes/html/box/shipping_billing_view.php");
} 
?>


	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table>
</div>

