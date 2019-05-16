<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
}
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);

if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$OrderSourceFlag = 1;
	}
}

?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information
	<a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['view']?>&module=Sales<?=$module?>" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a>
</td>
</tr>

<? if(!empty($arrySale[0][$ModuleID])){ ?>
 <tr>
        <td  align="right"   class="blackbold" > <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>	

	<? if($arrySale[0]['OrderPaid']>0 && $module=='Order') { ?>
	 <td  align="right"   class="blackbold" >Payment Status  : </td>
        <td   align="left" >
		<? #echo ($arrySale[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>');  ?>

<? echo $objSale->GetCreditStatusMsg($arrySale[0]['Status'],$arrySale[0]['OrderPaid']); ?>

	</td>
	<? } ?>

 </tr>
<? } ?>


 <tr>
	<td  align="right"   class="blackbold" > Customer : </td>
	<td   align="left" >
	<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
	</td>
	<?php if($Config['spiffDis']==1){?>
	<td align="right"   class="blackbold">Spiff  : </td>
	<td  align="left"><?=($arrySale[0]['Spiff']=="Yes")?("Yes"):("No")?> </td>
<? }?>
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
	<?php if($OrderType == 'Against PO' || $OrderType == 'PO'){?>
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
<? if($OrderSourceFlag==1){ ?>
<tr>
        <td  align="right"   class="blackbold" width="20%">  </td>
        <td   align="left" width="30%"></td>
	
        <td  align="right"   class="blackbold" width="20%">Order Source  : </td>
        <td   align="left" >
 <?=(!empty($arrySale[0]['OrderSource']))?(stripslashes($arrySale[0]['OrderSource'])):(NOT_SPECIFIED)?>
		</td>
	
      </tr>
<? } ?>

  <tr>
        <td  align="right"   class="blackbold" width="20%"> Sales Person : </td>
        <td   align="left" width="30%">
<? 


if(!empty($arrySale[0]['SalesPerson'])){ 
 
	if($arrySale[0]['SalesPersonType']=='1') {?>
<a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a>
 <? } else { ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a>
<? } }else{ echo NOT_ASSIGNED;}?>

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
		  <?=($arrySale[0]['Approved'] == 1)?('<span class="greenmsg">Yes</span>'):('<span  class="redmsg">No</span>')?>
		  
		 </td>
	  </tr>

	<? if($arrySale[0]['CreatedDate']>0){ ?>
		<tr>
		<td  align="right"   class="blackbold" > Created Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['CreatedDate'])); ?>
		</td>
		<td  align="right"   class="blackbold" >  Updated Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['UpdatedDate'])); ?>
		</td>
		</tr>
	<? } ?>

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

	<? if($arrySale[0]['PaymentTerm']=='PayPal' && !empty($arrySale[0]['paypalEmail'])){?>
	<tr>
			<td  align="right"   class="blackbold" > Paypal Email : </td>
			<td   align="left" >
	        	 <?=stripslashes($arrySale[0]['paypalEmail'])?>
			</td>

			<td  align="right" class="blackbold"> Paypal Invoice Number#  : </td>
			<td   align="left">
			<?=stripslashes($arrySale[0]['paypalInvoiceNumber'])?>
		   </td>
	</tr>
	<? } ?>

	<? if(!empty($BankAccount)){ ?>
	<tr>
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

			 
	</tr>
	<? } ?>

	

<tr>
			<td  align="right" valign="top" class="blackbold">Currency  : </td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['CustomerCurrency']))?(stripslashes($arrySale[0]['CustomerCurrency'])):(NOT_SPECIFIED)?>
		  </td>
		<td  align="right" valign="top"  class="blackbold" > Customer PO#  : </td>
			<td   align="left" valign="top">
	<?=(!empty($arrySale[0]['CustomerPO']))?(stripslashes($arrySale[0]['CustomerPO'])):(NOT_SPECIFIED)?>

		</td>
			
	</tr>
<? if($arrySale[0]['Fee']>0){ ?>
<tr>
        <td  align="right"   class="blackbold"  >  </td>
        <td   align="left"  ></td>
	
        <td  align="right"   class="blackbold" >Fees  : </td>
        <td   align="left" >
<?php echo $arrySale[0]['Fee']; ?>
		</td>
	
      </tr>
<? } ?>

<tr>
	<td  align="right" valign="top"  class="blackbold" > Comments  : </td>
			<td   align="left" valign="top">
	<?php $cmt = $objBankAccount->viewComments($arrySale[0]['Comment']);?>
	<?=(!empty($cmt))?($cmt):(NOT_SPECIFIED)?></td>
<td align="right" valign="top" class="blackbold">Document :</td>
		<td align="left" valign="top">
<?php
 
 
  if(!empty($getDocumentArry)){
foreach($getDocumentArry as $val){
    if(!empty($val['FileName']) && IsFileExist($Config['S_DocomentDir'],$val['FileName'])){
 
    	$Showfile='';
    	$checkval="1";
    	echo ''.stripslashes($val['FileName']).'&nbsp;<a href="../download.php?file='.$val['FileName'].'&folder='.$Config['S_DocomentDir'].'"   style="display: inline-block;margin-bottom:5px;" class="download">Download File</a>';
    	//echo '<input type="hidden" name="FileName" value="'.stripslashes($val['FileName']).'">';
    }
    }
    }
?>    

		</td>
</tr>



<tr>
			<td  align="right" valign="top" class="blackbold">Shipping Carrier  : </td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['ShippingMethod']))?(stripslashes($arrySale[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
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
			

		</td>
	</tr>



	<tr>
			<td  align="right" valign="top" class="blackbold">Shipping Account Customer :</td>
			<td  align="left" valign="top"><? if ($arrySale[0]['ShippingAccountCustomer']==1) { echo "Yes";}
			else if(empty($arrySale[0]['ShippingAccountCustomer']) ) { echo "No";} ?>
		  </td>

<?php if(!empty($arrySale[0]['ShippingAccountCustomer']) ) { ?>
			<td align="right" valign="top" class="blackbold">Shipping Account Number :</td>
		<td align="left" valign="top">

<?
if($arrySale[0]['ShippingAccountCustomer']==1){		
    
    if(!empty($arrySale[0]['ShippingAccountNumber'])) { echo $arrySale[0]['ShippingAccountNumber']; }
    else { echo NOT_SPECIFIED; }
    
}
			}
?>

		</td>
			

		</td>
	</tr>
	

<tr>
			<td  align="right" valign="top" class="blackbold">Freight Discounted :</td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['FreightDiscounted']) )?("Yes"):("No")?>
		  </td>
			
	</tr>




<?php  

$TrackingNo	= explode(':',$arrySale[0]['TrackingNo']);	
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


<? if(!empty($TrackingNo[$i]) && !empty($arrySale[0]['ShippingMethod'])){ ?>
<script language="JavaScript1.2" type="text/javascript">
TrackShippAPINew('<?=$TrackingNo[$i]?>', '<?=strtolower($arrySale[0]["ShippingMethod"])?>','<?=$ln?>');
</script>
<? } ?>


<? }?>

<!--tr>
<td  align="right"   class="blackbold" > Shipping Account  : </td>
	<td   align="left" ><?=(!empty($arrySale[0]['ShipAccount']))?(stripslashes($arrySale[0]['ShipAccount'])):(NOT_SPECIFIED)?>
	       
	</td>

</tr--> 
</table>

<!--<tr>
			<td  align="right" valign="top" class="blackbold">Tracking #  : </td>
			<td  align="left" valign="top"><?=(!empty($arrySale[0]['TrackingNo']))?(stripslashes($arrySale[0]['TrackingNo'])):(NOT_SPECIFIED)?>
		  </td>
		<td  align="right" valign="top"  class="blackbold" > Shipping Account  : </td>
			<td   align="left" valign="top">
	<?=(!empty($arrySale[0]['ShipAccount']))?(stripslashes($arrySale[0]['ShipAccount'])):(NOT_SPECIFIED)?>

		</td>
			
	</tr>

<tr id="TrackingStatusTR" style="display:none">
				<td  align="right" valign="top" class="blackbold">Tracking Status : </td>
				<td  align="left" valign="top" id="TrackingStatusTD" colspan="3">
			  </td>
	</tr>
</table>

<? if(!empty($arrySale[0]['TrackingNo']) && !empty($arrySale[0]['ShippingMethod'])){ ?>
<script language="JavaScript1.2" type="text/javascript">
TrackShippAPI('<?=$arrySale[0]["TrackingNo"]?>', '<?=strtolower($arrySale[0]["ShippingMethod"])?>');
</script>
<? } ?>-->
