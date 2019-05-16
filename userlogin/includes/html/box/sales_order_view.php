<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
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
<? } ?>


 <tr>
	<td  align="right"   class="blackbold" > Customer : </td>
	<td   align="left" >
	<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
	</td>
	
	<td align="right"   class="blackbold">Spiff  : </td>
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
	<td  align="right" class="blackbold">Order Type  : </td>
	<td   align="left">
 
        <?php
            if($arrySale[0]["OrderType"] != '') $OrderType = $arrySale[0]["OrderType"]; else $OrderType = 'Standard'; 
        ?>         
 
        <?=stripslashes($OrderType);?></td>
	<?php if($OrderType == 'Against PO'){?>
	<td align="right" class="blackbold">Purchase Order # : </td>
	<td  align="left">
            <a href="../purchasing/vPO.php?module=Order&amp;pop=1&amp;po=<?=$arrySale[0]["PONumber"]?>" class="fancybox hideprint fancybox.iframe"><?=stripslashes($arrySale[0]["PONumber"])?></a> 
            &nbsp; &nbsp;[ &nbsp;Status:  
             <?  $OrderIsOpen = 0;
		 if($POStatus == 'Cancelled' || $POStatus == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($POStatus == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
			 $OrderIsOpen = 1;
		 }

		echo '<span class="'.$StatusCls.'">'.$POStatus.'</span> &nbsp;]';
		
	 ?>
            
        </td>
        <?php } else {?>
        <td align="right" class="blackbold">&nbsp;</td>
	<td  align="left">&nbsp;</td>
        <?php }?>

  </tr>



      <!---Recurring Start-->
   <?php
    $arryRecurr = $arrySale;
   include("../includes/html/box/recurring_2column_sales_view.php");?>
   
   <!--Recurring End-->

  <tr>
        <td  align="right"   class="blackbold" width="20%"> Sales Person : </td>
        <td   align="left" width="30%">
<? if(!empty($arrySale[0]['SalesPerson'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a>
<? }else{ echo NOT_ASSIGNED;}?>

</td>

        <td  align="right"   class="blackbold" width="20%">Order Date  : </td>
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
		 <?/* 
		 if($arrySale[0]['Status'] =='Open'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'redmsg';
		 }

		echo '<span class="'.$StatusCls.'">'.$arrySale[0]['Status'].'</span>';
		*/
		 ?>

 <? 
		 if($arrySale[0]['Status'] =='Completed'){
			 $Status = ST_CLR_CREDIT;
			 $StatusCls = 'green';
		 }else{
			$StatusCls = 'red';

			 if($arrySale[0]['Status'] =='Open'){
				if($arrySale[0]['tax_auths'] ='Yes'){
					$Status = ST_TAX_APP_HOLD;			
				}else{
					$Status = ST_CREDIT_HOLD;
				}
			}else{
				$Status = $arrySale[0]['Status'];		
			}	
		 }

		echo '<span class="'.$StatusCls.'">'.$Status.'</span>';
		
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
			<td  align="right" valign="top" class="blackbold">Shipping Method  : </td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['ShippingMethod']))?(stripslashes($arrySale[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
		  </td>

			<td  align="right" valign="top"  class="blackbold" > Comments  : </td>
			<td   align="left" valign="top">
	<?=(!empty($arrySale[0]['Comment']))?(stripslashes($arrySale[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

<tr>
			<td  align="right" valign="top" class="blackbold">Currency  : </td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['CustomerCurrency']))?(stripslashes($arrySale[0]['CustomerCurrency'])):(NOT_SPECIFIED)?>
		  </td>

			
	</tr>
</table>
