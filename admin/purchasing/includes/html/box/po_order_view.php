<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $module ='Order';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 



	<tr>
		 <td colspan="4" align="left" class="head"><?=VENDOR_DETAIL?>
			 <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['view']?>&module=Purchases<?=$module?>" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a>
		</td>
	</tr>
	<tr>
			<td  align="right"   class="blackbold" > Vendor Code  : </td>
			<td   align="left" >
<?=stripslashes($arryPurchase[0]['SuppCode'])?>

			</td>
	 </tr>

 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left"  width="30%"><B><?=stripslashes($arryPurchase[0][$ModuleID])?></B></td>

       <td  align="right"   class="blackbold" width="20%">Order Status  : </td>
        <td   align="left" > 
		 <? 
		 if($arryPurchase[0]['Status'] == 'Cancelled' || $arryPurchase[0]['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($arryPurchase[0]['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'"><strong>'.$arryPurchase[0]['Status'].'</strong></span>';
		
		 ?>

           </td>
      </tr>

     <tr>
      
 
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

	  <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arryPurchase[0]['Approved'] == 1)?('<span class=greenmsg>Yes</span>'):('<span class=redmsg>No</span>')?>
		  
		 </td>
</tr>

	<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>

 <tr>
        <td  align="right"   class="blackbold" > Order Type  : </td>
        <td   align="left" ><?=$arryPurchase[0]['OrderType']?></td>
 	</tr>

<? if($arryPurchase[0]['OrderType']=='Dropship'){ ?>
 <tr>

	<td  align="right"   class="blackbold" > Sales Order # : </td>
	<td   align="left" >
		<? if(!empty($arryPurchase[0]['SaleID'])){
		echo '<a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&curP=1&so='.$arryPurchase[0]['SaleID'].'&pop=1">'.$arryPurchase[0]['SaleID'].'</a>';
		} ?>
		

		</td>

</tr>
<? } ?>

 <tr>
       <td  align="right"   class="blackbold" >Order Date  : </td>
<td   align="left" >
<?=($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED)?>
	</td>

      </tr>


  <tr>
        <td  align="right"   class="blackbold" > Expected Date  : </td>
        <td   align="left" id="ExpectedDateTd" >
 <?=($arryPurchase[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_SPECIFIED)?>
		</td>
 
   </tr>
   <tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['PaymentTerm']))?(stripslashes($arryPurchase[0]['PaymentTerm'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

<? if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='credit card' && !empty($arryPurchase[0]['CreditCardVendor'])){  
	$arryCreditCardVendor = $objPurchase->GetSupplier('',$arryPurchase[0]['CreditCardVendor'],'');
 ?>
	<tr>
		<td  align="right" class="blackbold">Credit Card Vendor :</td>
		<td   align="left">
		 
		<a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$arryCreditCardVendor[0]['SuppCode']?>" ><?=stripslashes($arryCreditCardVendor[0]["VendorName"])?></a>
		 		
		
		</td>
	 </tr>

	
	<? } ?>

<?  if(!empty($BankAccount)){ ?>
	<tr>
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

			 
	</tr>
	<? } ?>

	<!--tr>
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['PaymentMethod']))?(stripslashes($arryPurchase[0]['PaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	   </tr>
	   <tr-->
	
			<td  align="right"   class="blackbold" > Shipping Carrier  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['ShippingMethod']))?(stripslashes($arryPurchase[0]['ShippingMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

   <tr>
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

	<!--tr><td  align="right"   class="blackbold" > Assigned To  : </td>
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

<?php  

$TrackingNo	= explode(':',$arryPurchase[0]['TrackingNo']);	
		$count 		= count($TrackingNo);
		for($i=0;$i<$count;$i++){
$ln =$i+1;
?>
	<tr>
				<td  align="right" valign="top" class="blackbold">Tracking # <?=$ln?>  : </td>
				<td  align="left" valign="top" ><?=(!empty($TrackingNo[$i]))?(stripslashes($TrackingNo[$i])):(NOT_SPECIFIED)?>
			  </td>
	</tr>

<tr id="TrackingStatusTR<?=$ln?>" style="display:none">
				<td  align="right" valign="top" class="blackbold">Tracking Status <?=$ln?> : </td>
				<td  align="left" valign="top" id="TrackingStatusTD<?=$ln?>">
			  </td>
	</tr>


<? if(!empty($TrackingNo[$i]) && !empty($arryPurchase[0]['ShippingMethod'])){ ?>
<script language="JavaScript1.2" type="text/javascript">
TrackShippAPINew('<?=$TrackingNo[$i]?>', '<?=strtolower($arryPurchase[0]["ShippingMethod"])?>','<?=$ln?>');
</script>
<? } ?>


<? }?>

	<!--<tr>
				<td  align="right" valign="top" class="blackbold">Tracking #  : </td>
				<td  align="left" valign="top" ><?=(!empty($arryPurchase[0]['TrackingNo']))?(stripslashes($arryPurchase[0]['TrackingNo'])):(NOT_SPECIFIED)?>
			  </td>
	</tr>

	<tr id="TrackingStatusTR" style="display:none">
				<td  align="right" valign="top" class="blackbold">Tracking Status : </td>
				<td  align="left" valign="top" id="TrackingStatusTD">
			  </td>
	</tr>-->

	   <tr>
		<td  align="right"   class="blackbold" valign="top"> Comments  : </td>
			<td   align="left" valign="top">
		<?php $cmt = $objBankAccount->viewComments($arryPurchase[0]['Comment']);?>
	<?=(!empty($cmt))?($cmt):(NOT_SPECIFIED)?>
	<?php //(!empty($arryPurchase[0]['Comment']))?(stripslashes($arryPurchase[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>



	<tr>
		<td  align="right" class="blackbold">Prepaid Freight :</td>
		<td   align="left">			
		<?=($arryPurchase[0]['PrepaidFreight']=='1')?("Yes"):("No")?>
		
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
		<a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$arrySupplier[0]['SuppCode']?>" ><?=stripslashes($arrySupplier[0]["VendorName"])?></a>
		<? }
		  }
		?>		
		
		</td>
	 </tr>

	
	<? } ?>




	 <tr>
		<td  align="right"   class="blackbold" valign="top"> Currency  : </td>
			<td   align="left" valign="top">
	<?=(!empty($arryPurchase[0]['Currency']))?(stripslashes($arryPurchase[0]['Currency'])):(NOT_SPECIFIED)?>

		</td>


	</tr>
</table>


<?/* if(!empty($arryPurchase[0]['TrackingNo']) && !empty($arryPurchase[0]['ShippingMethod'])){ ?>
<script language="JavaScript1.2" type="text/javascript">
TrackShippAPI('<?=$arryPurchase[0]["TrackingNo"]?>', '<?=strtolower($arryPurchase[0]["ShippingMethod"])?>');
</script>
<? } */?>
