<?
if(empty($ModuleID)){
	$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; $module ='Order';
}
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information</td>
</tr>
<? if(!empty($arrySale[0][$ModuleID])){ ?>
 <tr>
        <td  align="right"   class="blackbold" > <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>
  </tr>
<? }else{ ?>
 <tr>
        <td  align="right"   class="blackbold" > SO Number # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]["SaleID"])?></B></td>

	<? if($arrySale[0]['OrderPaid']>0 && $module=='Order') { ?>
	 <td  align="right"   class="blackbold" >Payment Status  : </td>
        <td   align="left" >
		<?=($arrySale[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>')?>
	</td>
	<? } ?>

  </tr>
<? } ?>

 <tr>
        <td  align="right"   class="blackbold" width="20%"> Customer : </td>
        <td   align="left" width="30%">
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
</td>

	<td align="right"   class="blackbold" width="20%">Spiff  : </td>
	<td  align="left"><?=($arrySale[0]['Spiff']=="Yes")?("Yes"):("No")?> </td>


  </tr>

<? if($arrySale[0]['Spiff']=="Yes"){ ?>
 <tr>
	<td  align="right"   class="blackbold" valign="top"> Customer Contact : </td>
	<td  align="left"  valign="top">
		<?=str_replace("|","",stripslashes($arrySale[0]['SpiffContact']))?>
	</td>
	
	<td align="right" class="blackbold" valign="top">Spiff Amount (<?=$Currency?>) :</td>
	<td  align="left" valign="top"><?=stripslashes($arrySale[0]['SpiffAmount'])?> </td>

  </tr>
 <? } ?>


  <tr>
        <td  align="right"   class="blackbold" > Sales Person : </td>
        <td   align="left" >
<? if(!empty($arrySale[0]['SalesPerson'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a>
<? }else{ echo NOT_ASSIGNED;}?>

</td>
 
        <td  align="right"   class="blackbold" >Order Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	  
	  <tr>
       <td  align="right" class="blackbold" >Created By  : </td>
       <td   align="left">
               <?
                       if($arrySale[0]['AdminType'] == 'admin'){
                               $CreatedBy = 'Administrator';
                       }else{
                               $CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arrySale[0]['AdminID'].'" >'.stripslashes($arrySale[0]['CreatedBy']).'</a>';
                       }
                       echo $CreatedBy;
               ?>
         </td>
    
		<td  align="right"   class="blackbold" >Approved  : </td>
		<td   align="left"  >
		  <?=($arrySale[0]['Approved'] == 1)?('Yes'):('No')?>
		  
		 </td>
	  </tr>

	<tr>
        <td  align="right"  class="blackbold" >Order Status  : </td>
        <td   align="left">
		

 <?=$objSale->GetOrderStatusMsg($arrySale[0]['Status'],$arrySale[0]['Approved'],$arrySale[0]['PaymentTerm'],$arrySale[0]['OrderPaid'])?>






          </td>
   
        <td  align="right"   class="blackbold" > Delivery Date  : </td>
        <td   align="left" >
		<?=($arrySale[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	         <?=(!empty($arrySale[0]['PaymentTerm']))?(stripslashes($arrySale[0]['PaymentTerm'])):(NOT_SPECIFIED)?>
			</td>
	
			<!--td  align="right" class="blackbold"> Payment Method  : </td>
			<td   align="left">
			<?=(!empty($arrySale[0]['PaymentMethod']))?(stripslashes($arrySale[0]['PaymentMethod'])):(NOT_SPECIFIED)?>
		   </td-->
	</tr>

	<tr>
			<td  align="right" class="blackbold">Shipping Carrier  : </td>
			<td  align="left"><?=(!empty($arrySale[0]['ShippingMethod']))?(stripslashes($arrySale[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
		  </td>

		<td align="right" valign="top" class="blackbold">Shipping Method :</td>
		<td align="left" valign="top">
<?
if(!empty($arrySale[0]['ShippingMethodVal'])){	
	$arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'],$arrySale[0]['ShippingMethodVal']);
}
?>


<?=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED)?>
		</td>

	</tr>
</table>
