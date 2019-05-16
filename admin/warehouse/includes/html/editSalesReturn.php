<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span> &raquo; Stock In</span>
</div>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
#include("includes/html/box/po_recieve.php");

	

?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());	
		
	if($("#MsgSpan_ModuleID span").hasClass('redmsg')){		
		alert("Receipt Number Already Exist In Database.");		
		return false;
	}

var totalSum = 0;var remainQty=0;var inQty=0;
		for(var i=1;i<=NumLine;i++){

			if(document.getElementById("qty"+i) !=null){
				/*if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}*/
				 
				 remainQty = document.getElementById("remainQty"+i).value;
				 inQty = document.getElementById("qty"+i).value;
				 totalSum += inQty;
				if(parseInt(remainQty) < parseInt(inQty))
				 {
					//alert("Return Qty Should be Less Than Or Equal To Invoice Qty.");
					alert("Return qauntity must be be less than or equal to "+remainQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				 }
					
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}

		}
			
		}
		
		//alert(totalSum);return false;
  	    totalSum = parseInt(totalSum, 10);
		if(totalSum == 0)
		{
		  alert("Return qauntity should not be blank.");
		  //document.getElementById("qty1").focus();
		  return false;
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

		
		
}


</script>

<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    
   <tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> Receipt No# : </td>
	<td align="left" width="30%" valign="top">
	<?php if(!empty($_GET['rcpt'])){?>
	 <?=$arrySale[0]['ReceiptNo'];?>
	<?php } else {?>
	<input name="ReceiptNo" type="text" class="datebox" id="ReceiptNo" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','ReceiptNo','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Receipt Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['rcpt'])){
	$arryTime = explode(" ",$Config['TodayDate']);
	$ReturnDate = ($arrySale[0]['ReceiptDate']>0)?($arrySale[0]['ReceiptDate']):($arryTime[0]); 
	echo $ReturnDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#ReceiptDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

				}
			);
		});
</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReturnDate = (!empty($arrySale[0]['ReceiptDate']))?($arrySale[0]['ReceiptDate']):($arryTime[0]); 
?>
<input id="ReceiptDate" name="ReceiptDate" readonly="" class="datebox" value="<?=$ReturnDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
 
	<tr>
				<td  align="right" class="blackbold"> Warehouse Code</td>
				<td   align="left" >
					<select name="warehouse" id="warehouse" class="inputbox">
                                <option value="">Select Location</option>
                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                    <option value="<?= $arryWarehouse[$i]['warehouse_code'] ?>" <? if ($arryWarehouse[$i]['warehouse_code'] == $arrySale[0]['wCode']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>
				</td>
			
         <td  align="right"   class="blackbold"> Mode of Transport  : </td>
		 <td   align="left" ><select name="transport" id="transport" class="inputbox">
                                <option value="">Select Transport</option>
                                <? 
$transport = (!empty($arrySale[0]['transport']))?($arrySale[0]['transport']):('');

for ($i = 0; $i < sizeof($arryTrasport); $i++) { ?>
                                    <option value="<?= $arryTrasport[$i]['attribute_value'] ?>" <? if ($arryTrasport[$i]['attribute_value'] == $transport) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryTrasport[$i]['attribute_value'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>   </td>
          </tr>	
          
             <tr>
              
         <td  align="right"   class="blackbold"> Status : </td>
		 <td   align="left" >
<?
$ReceiptStatus = (!empty($arrySale[0]['ReceiptStatus']))?($arrySale[0]['ReceiptStatus']):('');
?>
                     <select name="ReceiptStatus" id="ReceiptStatus" class="inputbox">
                         <option value="Parked" <?=($ReceiptStatus=="Parked")?("Selected"):("")?>>Parked</option>     
                         <option value="Completed"  <?=($ReceiptStatus=="Completed")?("Selected"):("")?>>Completed</option>   
                     </select>   
                 </td>
         
		  		<td align="right"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" >
		    			<input name="packageCount" type="text" class="inputbox" id="packageCount" value="<?=(!empty($arrySale[0]['packageCount']))?($arrySale[0]['packageCount']):('')?>"  maxlength="50" /><!--span>	<a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a></span-->		          
				</td>
			</tr> 
<tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" >
				<select name="PackageType" id="PackageType" class="inputbox">
                                <option value="">Select Package Type</option>
		    			 <? 
 
$PackageType = (!empty($arrySale[0]['PackageType']))?($arrySale[0]['PackageType']):('');

for ($i = 0; $i < sizeof($arryPackageType); $i++) { ?>
                                    <option value="<?= $arryPackageType[$i]['attribute_value'] ?>" <? if ($arryPackageType[$i]['attribute_value'] == $PackageType) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryPackageType[$i]['attribute_value'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>		          
				</td>
				
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<input name="Weight" type="text" class="inputbox" id="Weight"  value="<?=(!empty($arrySale[0]['Weight']))?($arrySale[0]['Weight']):('')?>"     maxlength="50" />	          
				</td>
			</tr>

        <tr>			
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		 <input name="ReceiptComment" type="text" class="inputbox" id="ReceiptComment"  value="<?=(!empty($arrySale[0]['ReceiptComment']))?(stripslashes($arrySale[0]['ReceiptComment'])):('')?>"   maxlength="100" />          
		</td>


		<td  align="right" class="blackbold"> Re-Stocking : </td>
	<td align="left">
	<?php if($arrySale[0]['ReSt']==1){echo "Yes";}else{echo "No";}?>
	 <input name="ReSt" type="hidden" id="ReSt" value="<?=$arrySale[0]['ReSt']?>"  maxlength="1" />
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$arrySale[0]['ExpiryDate'];?>"  type="hidden" > 


	</td>
	</tr>

<tr>

	<td align="left"></td>
	<td align="left"></td>
<? 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);  
/*
$arryShipStand['ShippingState'] = $arrySale[0]['ShippingState']; 
$arryShipStand['ShippingCountry'] = $arrySale[0]['ShippingCountry']; 
$arryShipStand['ConversionRate'] = $arrySale[0]['ConversionRate']; 
$arryShipStand['ShippingZipCode'] = $arrySale[0]['ShippingZipCode']; 
$arryShipStand['ShippingCompany'] = $arrySale[0]['ShippingCompany']; 
$arryShipStand['ShippingCountry'] = $arrySale[0]['ShippingCountry']; 
$arryShipStand['ShippingAddress'] = $arrySale[0]['ShippingAddress']; 
$arryShipStand['ShippingCity'] = $arrySale[0]['ShippingCity']; 
$arryShipStand['ShippingMobile'] = $arrySale[0]['ShippingMobile']; 
$arryShipStand['ShippingFax'] = $arrySale[0]['ShippingFax']; 
$arryShipStand['ShippingName'] = $arrySale[0]['ShippingName']; 
$arryShipStand['ShippingLandline'] = $arrySale[0]['ShippingLandline']; 
$arryShipStand["INVNumber"] = $arrySale[0]['InvoiceID']; 
$arryShipStand["SALENUMBER"] = $arrySale[0]['SaleID']; 
include("../includes/html/box/shipping_box_standalone.php");*/
?>
</tr>
                        
	<?php if(!empty($_GET['rcpt'])){?>
		<tr>
			<td align="right"></td>
			<td align="left"> 
			<input type="hidden" name="rcptID" id="rcptID" value="<?=$_GET['edit']?>" readonly />
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Save">
			
			</td>
		</tr>
	<?php }?>

</table>

	 </td>
</tr> 
    
    
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">RMA Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> RMA No# : </td>
	<td align="left" width="30%" valign="top">
	
	 <?=$arrySale[0]['ReturnID'];?>
	
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Item RMA Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['rtn'])){?>

	<?=($arrySale[0]['ReturnDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ReturnDate']))):(NOT_SPECIFIED)?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#ReturnDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

				}
			);
		});
</script>


<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReturnDate = ($arrySale[0]['ReturnDate']>0)?($arrySale[0]['ReturnDate']):($arryTime[0]); 
?>
<input id="ReturnDate" name="ReturnDate" readonly="" class="datebox" value="<?=$ReturnDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
 
	<tr>
		<? if(empty($arrySale[0]['ReturnPaid'])) $arrySale[0]['ReturnPaid']='';?>
		<!--td  align="right"   class="blackbold" > RMA Amount Paid  : </td>
		<td   align="left">	<input type="checkbox" name="ReturnPaid" value="Yes" <?=($arrySale[0]['ReturnPaid'] == "Yes")?("checked"):("")?>></td-->
	
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		 <?php echo stripslashes($arrySale[0]['ReturnComment']); ?>        
		</td>
	</tr>
	

</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/return_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?php

echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Line Item 
	 <div style="float:right;display:none;"><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>

	 </td>
</tr>

<tr>
	<td align="left">
	<? if($HideSubmit!=1){ ?>	
		<?php include("includes/html/box/warehouse_so_item_return.php");?>
	<?php } else {?>
	<?php include("includes/html/box/warehouse_so_item_return_view.php");?>
	<?php }?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
		<? } ?>
		<?php if(empty($_GET['rcpt'])){?>
		<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['edit']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
        <input type="hidden" name="Recipt_ID" id="Recipt_ID" value="<?=$Receipt_id?>" readonly />

		
	</td>
	</tr>
  
</table>

 </form>

<? } ?>



