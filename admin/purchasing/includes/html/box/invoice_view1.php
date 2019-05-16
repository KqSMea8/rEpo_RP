<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Order Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0][$ModuleID])?></B></td>
      </tr>





  <tr>
        <td  align="right"   class="blackbold" >Order Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arryPurchase[0]['Approved'] == 1)?('Yes'):('No')?>
		  
		 </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" >Order Status  : </td>
        <td   align="left" >
		<?=$arryPurchase[0]['Status']?>
           </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" > Order Type  : </td>
        <td   align="left" >
	<?=$arryPurchase[0]['OrderType']?>
    
           </td>
      </tr>


  <tr>
        <td  align="right"   class="blackbold" > Delivery Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['Comment']))?(stripslashes($arryPurchase[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>


</table>

	 </td>
</tr>


<tr>
	<td align="left" valign="top" width="50%"><? include("includes/html/box/po_supp_view.php");?></td>
	<td align="left" valign="top"><? include("includes/html/box/po_warehouse_view.php");?></td>
</tr>

<tr>
	 <td colspan="2" align="left" class="head" >Line Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/po_item_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

  
</table>