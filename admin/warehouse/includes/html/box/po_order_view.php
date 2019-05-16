<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $module ='Order';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="5" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0][$ModuleID])?></B></td>
  </tr>
  <tr>
        <td  align="right"   class="blackbold" >Order Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED)?>
		</td>
   
        <td  align="right" class="blackbold" >Created By  : </td>
        <td   align="left">
		<?
			if($arryPurchase[0]['AdminType'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryPurchase[0]['AdminID'].'" >'.stripslashes($arryPurchase[0]['CreatedBy']).'</a>';
			}
			echo $CreatedBy;
		?>
          </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arryPurchase[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>')?>
		  
		 </td>
 
        <td  align="right"   class="blackbold" >Order Status  : </td>
        <td   align="left" >
		 <? 
		 if($arryPurchase[0]['Status'] == 'Cancelled' || $arryPurchase[0]['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($arryPurchase[0]['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryPurchase[0]['Status'].'</span>';
		
		 ?>

           </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" > Order Type  : </td>
        <td   align="left" >
	<?=$arryPurchase[0]['OrderType']?>
    
           </td>
  
        <td  align="right"   class="blackbold" > Delivery Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

	<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['PaymentTerm']))?(stripslashes($arryPurchase[0]['PaymentTerm'])):(NOT_SPECIFIED)?>

		</td>



<? if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='credit card' && !empty($arryPurchase[0]['CreditCardVendor'])){  
	$arryCreditCardVendor = $objPurchase->GetSupplier('',$arryPurchase[0]['CreditCardVendor'],'');
 ?>
	 
		<td  align="right" class="blackbold">Credit Card Vendor :</td>
		<td   align="left">
		 
		<a class="fancybox fancybox.iframe" href="../finance/suppInfo.php?view=<?=$arryCreditCardVendor[0]['SuppCode']?>" ><?=stripslashes($arryCreditCardVendor[0]["VendorName"])?></a>
		 		
		
		</td>
	 

	
	<? } ?>

	<?   if(!empty($BankAccount)){ ?>
	 
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

	 
	<? } ?>
			<!--td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['PaymentMethod']))?(stripslashes($arryPurchase[0]['PaymentMethod'])):(NOT_SPECIFIED)?>

		</td-->
	</tr>

	<tr>
			<td  align="right"   class="blackbold" > Shipping Carrier  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['ShippingMethod']))?(stripslashes($arryPurchase[0]['ShippingMethod'])):(NOT_SPECIFIED)?>

		</td>


		<td align="right" valign="top" class="blackbold">Shipping Method :</td>
		<td align="left" valign="top">

		<?
		if(!empty($arryPurchase[0]['ShippingMethodVal'])){		
		$arryShipMethodName = $objConfigure->GetShipMethodName($arryPurchase[0]['ShippingMethod'],$arryPurchase[0]['ShippingMethodVal']);
		}
		?>

		<?=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED)?>
		</td>



	
			
	</tr>
<tr>
		<td  align="right" class="blackbold">Prepaid Freight :</td>
		<td   align="left">			
		<?=($arryPurchase[0]['PrepaidFreight']=='1' && $POReceipt!=1)?("Yes"):("No")?>
		
		</td>

		<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['Comment']))?(stripslashes($arryPurchase[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>


	 </tr>

	<? if($arryPurchase[0]['PrepaidFreight']=='1'){   ?>
	<tr>
		<td  align="right" class="blackbold">Vendor :</td>
		<td   align="left">
		<? if (!empty($arryPurchase[0]['PrepaidVendor'])) {
			$arrySupplier = $objPurchase->GetSupplier('',$arryPurchase[0]['PrepaidVendor'],'');
			if(!empty($arrySupplier[0]['SuppCode'])){
			?>
		<a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$arrySupplier[0]['SuppCode']?>" ><?=stripslashes($arrySupplier[0]["VendorName"])?></a>
		<?
			}
		  }
		?>		
		
		</td>
	 </tr>

	 
	<? } ?>

<tr>
			<td  align="right"   class="blackbold" > Currency  : </td>
			<td   align="left" >

                            
<? if(!empty($arryPurchase[0]['Currency'])){ ?>
<?=stripslashes($arryPurchase[0]['Currency'])?>  
<? 
	}else{
		echo NOT_SPECIFIED;
	}
?>	



		</td>
	</tr>
	<!--tr>
			<td  align="right"   class="blackbold" > Assigned To  : </td>
			<td   align="left" >

                            
<? if(!empty($arryPurchase[0]['AssignedEmp'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryPurchase[0]['AssignedEmpID']?>" ><?=stripslashes($arryPurchase[0]['AssignedEmp'])?></a>   
<? 
	}else{
		echo NOT_SPECIFIED;
	}
?>	



		</td>
	</tr-->
</table>
