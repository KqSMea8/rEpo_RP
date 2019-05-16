<?
if(empty($ModuleID)){
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $module ='Invoice';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left"  width="30%"><B><?=stripslashes($arryPurchase[0][$ModuleID])?></B></td>

        <td  align="right"   class="blackbold"  width="20%"></td>
        <td   align="left" >

		</td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" > Order Type  : </td>
        <td   align="left" ><?=$arryPurchase[0]['OrderType']?></td>
 		
	<? if($arryPurchase[0]['OrderType']=='Dropship'){ ?>

	<td  align="right"   class="blackbold" > Sales Order # : </td>
	<td   align="left" >
		<? if(!empty($arryPurchase[0]['SaleID'])){
		echo '<a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&curP=1&so='.$arryPurchase[0]['SaleID'].'&pop=1">'.$arryPurchase[0]['SaleID'].'</a>';
		} ?>
		

		</td>

	<? } ?>

</tr>


 <tr>
       <td  align="right"   class="blackbold" >Order Date  : </td>
<td   align="left" >
<?=($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED)?>
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
          <?=($arryPurchase[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>')?>
		  
		 </td>
      </tr>




  <tr>
        <td  align="right"   class="blackbold" > Delivery Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_SPECIFIED)?>
		</td>
 
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['PaymentTerm']))?(stripslashes($arryPurchase[0]['PaymentTerm'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

	<tr>
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['PaymentMethod']))?(stripslashes($arryPurchase[0]['PaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	
			<td  align="right"   class="blackbold" > Shipping Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['ShippingMethod']))?(stripslashes($arryPurchase[0]['ShippingMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>


	<tr><!--td  align="right"   class="blackbold" > Assigned To  : </td>
			<td   align="left" >

<? if(!empty($arryPurchase[0]['AssignedEmp'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryPurchase[0]['AssignedEmpID']?>" ><?=stripslashes($arryPurchase[0]['AssignedEmp'])?></a>   
<? 
	}else{
		echo NOT_SPECIFIED;
	}
?>	

		</td-->
		<td  align="right"   class="blackbold" valign="top"> Comments  : </td>
			<td   align="left" valign="top">
	<?=(!empty($arryPurchase[0]['Comment']))?(stripslashes($arryPurchase[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>


	</tr>
</table>
