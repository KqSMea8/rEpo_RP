<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
}
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$OrderSourceFlag = 1;
	}
}
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	

<tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information
	 <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['view']?>&module=Sales<?=$module?>" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a>
	 </td>
</tr>
    <?php   
        $arryRecurr = $arrySale;

        include("../includes/html/box/recurring_2column_sales_view.php");
        ?>  
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" width="30%"><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>

        <td  align="right"   class="blackbold"  width="20%">Invoice Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):(NOT_SPECIFIED)?>
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
        <td  align="right"   class="blackbold" >Ship Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['ShippedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ShippedDate']))):(NOT_SPECIFIED)?>
		</td>
     
        <td  align="right"   class="blackbold" > Ship From(Warehouse) : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]['wName'])?></B></td>
       </tr>
	  
	   <tr>
			<td  align="right"   class="blackbold"> SO/Reference Number # : </td>
			<td   align="left" ><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$arrySale[0]['SaleID']?>" ><?=stripslashes($arrySale[0]['SaleID'])?></a></td>
	
			<td  align="right"   class="blackbold" > Sales Person : </td>
			<td   align="left" >
                            <?php if(!empty($arrySale[0]['SalesPerson'])){?>
                            <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a></td>
                            <?php } else {?>
                            <?=NOT_SPECIFIED?>
                            <?php }?>
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

	<? if(!empty($BankAccount)){ ?>
	<tr>
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

			 
	</tr>
	<? } ?>



<td  align="right"   class="blackbold" > Shipping Account  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['ShipAccount']))?(stripslashes($arrySale[0]['ShipAccount'])):(NOT_SPECIFIED)?>
	         
	</td>

</tr>
<tr>


	<td  align="right" valign="top"  class="blackbold" > Customer PO#  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['CustomerPO']))?(stripslashes($arrySale[0]['CustomerPO'])):(NOT_SPECIFIED)?>
	      
</td>
</tr>

<?php
$MainDir = "../sales/upload/Document/".$_SESSION['CmpID']."/";
  if(!empty($getDocumentArry)){?>


<tr>
<td  align="right" valign="top"  class="blackbold">Document :</td>

	<td   align="left" >
<?
foreach($getDocumentArry as $val){
    if(!empty($val['FileName']) && file_exists($MainDir.$val['FileName'])){
    	$dwnPath="http://" . $_SERVER['HTTP_HOST'] . "/erp/admin/sales/upload/Document/".$_SESSION['CmpID']."/".stripslashes($val['FileName']);	
    	$Showfile='';
    	$checkval="1";
    	echo ''.stripslashes($val['FileName']).'&nbsp;<a href="'.$dwnPath.'" target="_blank" style="display: inline-block;margin-bottom:5px;" class="download">Download File</a>';
    	//echo '<input type="hidden" name="FileName" value="'.stripslashes($val['FileName']).'">';
    }
    }?>
</td>
</tr>
   <? } ?>
      
	









<? if($OrderSourceFlag==1){ ?>
<tr>
	<td  align="right"   class="blackbold" > Order Source  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['OrderSource']))?(stripslashes($arrySale[0]['OrderSource'])):(NOT_SPECIFIED)?>
	         
	</td>
</tr>
<? } ?>







<? if($arrySale[0]['OrderSource']=="POS"){ ?>
<tr>
	<td  align="right"   class="blackbold" >  </td>
	<td   align="right" ></td>
	<td  align="right"   class="blackbold" > Vendor Name : </td>
	<td   align="left" >
<?  
//echo $Prefix . "classes/sales.class.php";
$getVendorNamePOS = $objSale->getVendorNamePOS($arrySale[0]['VendorID']);
    echo $getVendorNamePOS;
 ?>
	         
	</td>


</tr>
<? } ?>

<? if($arrySale[0]['Fee'] >0) {?>
<tr>
<td  align="right"   class="blackbold" >  </td>
<td   align="right" ></td>
<td  align="right"   class="blackbold" > Fees  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['Fee']))?(stripslashes($arrySale[0]['Fee'])):(NOT_SPECIFIED)?>
	         
	</td>
</tr>
<? }?>
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
   
			<td  align="right"   class="blackbold" > Invoice Status : </td>
			<td   align="left" ><?=stripslashes($arrySale[0]['InvoicePaid'])?></td>
	  </tr>

<tr>
<td  align="right" class="blackbold"  > Currency : </td>
			<td  align="left"> <? echo $Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);  ?>
</td>

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



<tr>


	<td  align="right"   class="blackbold" > Tracking #  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['TrackingNo']))?(stripslashes($arrySale[0]['TrackingNo'])):(NOT_SPECIFIED)?>
	       
	</td>

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
<? } ?>
