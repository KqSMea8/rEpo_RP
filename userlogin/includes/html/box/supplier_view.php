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
<?
if($_GET["tab"]=="general"){ ?>
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
	//include("includes/html/box/custom_field_view.php");
	?>

	  <tr>
        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <?  echo ($arrySupplier[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>

<? } ?>


<? if($_GET['tab'] == "contact"){ ?>
<tr>
	<td colspan="2" align="left" class="head">Contact </td>
</tr>	
<tr>
	<td colspan="2" align="left">
<? 
	include("supplier_contacts.php");
?>
</td>
</tr>	
<? } ?> 


<? if($_GET["tab"]=="contact" AND 1==2){
		$CountryName = stripslashes($arrySupplier[0]["Country"]);
		$StateName = stripslashes($arrySupplier[0]['State']);
		$CityName = stripslashes($arrySupplier[0]['City']);

?>
	
		<tr>
       		 <td colspan="2" align="left"   class="head">Contact Information</td>
  		</tr>  
		<tr>
	        <td  align="right"   class="blackbold" > Contact Name : </td>
	        <td   align="left" ><?php echo stripslashes($arrySupplier[0]['UserName']); ?>  </td>
       </tr>
       <tr>
	        <td  align="right"   class="blackbold" > Email : </td>
	        <td   align="left" ><?php echo $arrySupplier[0]['Email']; ?></td>
       </tr>	  
        <tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Address  :</td>
          <td  align="left" >
			<?=(!empty($arrySupplier[0]['Address']))?(nl2br(stripslashes($arrySupplier[0]['Address']))):(NOT_SPECIFIED)?>
		  </td>
        </tr>
		<tr <?=$Config['CountryDisplay']?>>
	        <td  align="right"   class="blackbold"> Country  :</td>
	        <td   align="left" ><?=(!empty($CountryName))?($CountryName):(NOT_SPECIFIED)?></td>
        </tr>
      <tr>
		  <td  align="right" class="blackbold"> State  :</td>
		  <td  align="left" class="blacknormal"><?=(!empty($StateName))?($StateName):(NOT_SPECIFIED)?> </td>
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
<? }  if($_GET["tab"]=="bank"){ ?>  
	 <tr>
       		 <td colspan="2" align="left" class="head">Bank Details</td>
        </tr>
		<?php if(empty($_GET['e'])){?>
			<tr>
				 <td colspan="4">&nbsp;<div style="float:right;"><a href="dashboard.php?curP=1&tab=<?php echo $_GET['tab']?>&e=1" class="fancybox"><img border="0" src="<?php echo _SiteUrl?>admin/images/edit.png"></a></div></td>
			</tr>
			<?php }?>	
	 <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
		
	<tr>
        <td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
        <td   align="left" >
			<?php 
			if(empty($_GET['e'])){
			echo (!empty($arrySupplier[0]['BankName']))?(stripslashes($arrySupplier[0]['BankName'])):(NOT_SPECIFIED);
			}else{
				$v= (!empty($arrySupplier[0]['BankName']))?(stripslashes($arrySupplier[0]['BankName'])):'';
				echo '<input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="'.$v.'" onkeypress="Javascript:return isAlphaKey(event);">';
			}?>
            </td>
      </tr>	
	 <tr>
        <td  align="right"   class="blackbold"> Account Name  : </td>
        <td   align="left" >
        <?php 
			if(empty($_GET['e'])){
			echo (!empty($arrySupplier[0]['AccountName']))?(stripslashes($arrySupplier[0]['AccountName'])):(NOT_SPECIFIED);
			}else{
				$v= (!empty($arrySupplier[0]['AccountName']))?(stripslashes($arrySupplier[0]['AccountName'])):'';
				echo '<input type="text" name="AccountName" maxlength="40" class="inputbox" id="AccountName" value="'.$v.'" onkeypress="Javascript:return isAlphaKey(event);">';
			}?>
		
			 </td>
      </tr>	  
	  <tr>
        <td  align="right"   class="blackbold"> Account Number  : </td>
        <td   align="left" >
         	 <?php 
				if(empty($_GET['e'])){
				echo (!empty($arrySupplier[0]['AccountNumber']))?(stripslashes($arrySupplier[0]['AccountNumber'])):(NOT_SPECIFIED);
				}else{
					$v= (!empty($arrySupplier[0]['AccountNumber']))?(stripslashes($arrySupplier[0]['AccountNumber'])):'';
					echo '<input type="text" name="AccountNumber" maxlength="40" class="inputbox" id="AccountNumber" value="'.$v.'" onkeypress="Javascript:return isAlphaKey(event);">';
				}?>
			 </td>
      </tr>	
	   <tr>
        <td  align="right"   class="blackbold"> Routing Number :</td>
        <td   align="left" >
        <?php 
				if(empty($_GET['e'])){
				echo (!empty($arrySupplier[0]['IFSCCode']))?(stripslashes($arrySupplier[0]['IFSCCode'])):(NOT_SPECIFIED);
				}else{
					$v= (!empty($arrySupplier[0]['IFSCCode']))?(stripslashes($arrySupplier[0]['IFSCCode'])):'';
					echo '<input type="text" name="IFSCCode" maxlength="40" class="inputbox" id="IFSCCode" value="'.$v.'" onkeypress="Javascript:return isAlphaKey(event);">';
				}?> 	
			 </td>
      </tr>	
	  
	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		<?php if(!empty($_GET['e'])){
		  	echo '<tr><td>&nbsp;</td>  <td align="" height="135" valign="top"><br><input type="hidden" name="SuppID" id="SuppID" value="'.$Customer_ID.'">
		  	<input type="hidden" name="UserID" id="UserID" value="0">
		  	<input name="Submit" type="submit" class="button" id="UpdateBank" value="Update">&nbsp;</td>  </tr>';
		  }?>
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
	include("shipping_billing_view.php");
} 
if($_GET["tab"]=="invoice"){ 
	include("SuppInvoice_view.php");
} 
if($_GET["tab"]=="purchaseorder"){ 
	
	include("SuppPO_view.php");
} 
?>
</table>	
	</td>
   </tr>
</form>
</table>
</div>

