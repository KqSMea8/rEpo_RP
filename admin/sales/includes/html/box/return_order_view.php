<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left"  width="30%"><B><?=stripslashes($arrySale[0]['InvoiceID'])?></B></td>

        <td  align="right"   class="blackbold" width="20%"> Customer : </td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
</td>
  </tr>

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
		 <? 
		 if($arrySale[0]['Status'] =='Open'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'redmsg';
		 }

		echo '<span class="'.$StatusCls.'">'.$arrySale[0]['Status'].'</span>';
		
		 ?>
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

			<td  align="right" class="blackbold"> Payment Method  : </td>
			<td   align="left">
			<?=(!empty($arrySale[0]['PaymentMethod']))?(stripslashes($arrySale[0]['PaymentMethod'])):(NOT_SPECIFIED)?>
		   </td>
	</tr>

	<tr>
			<td  align="right" class="blackbold" valign="top">Shipping Method  : </td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['ShippingMethod']))?(stripslashes($arrySale[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
		  </td>
	
			<td  align="right"   class="blackbold" valign="top"> Comments  : </td>
			<td   align="left" valign="top" >
	<?=(!empty($arrySale[0]['Comment']))?(stripslashes($arrySale[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>
</table>
