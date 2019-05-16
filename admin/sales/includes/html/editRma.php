<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had"><?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span></div>

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
		
	var ModuleField = '<?=$ModuleID?>';
	//alert(ModuleField);return false;
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
	if(ModuleVal!='' || OrderID>0){
		if(!ValidateMandRange(document.getElementById(ModuleField), "<?=$ModuleIDTitle?>",3,20)){
			return false;
		}
	}
	
	

	for(var k=1;k<=NumLine;k++){
		if(document.getElementById("qty"+k) != null){	
		
		  if(document.getElementById("qty"+k).value != "" ){
				if(document.getElementById("req_item"+k).value == "" )
									{
									if(document.getElementById("Condition"+k).value == "" )
									{
										 alert( "Please select Condition!" );
										 document.getElementById("Condition"+k).focus() ;
										 return false;
									}
				}

			    if(document.getElementById("Type"+k).value == "" )
			    {
			       alert( "Please select Type!" );
			       document.getElementById("Type"+k).focus() ;
			       return false;
			    }

			    if(document.getElementById("Action"+k).value == "" )
			    {
			       alert( "Please select Action!" );
			       document.getElementById("Action"+k).focus() ;
			       return false;
			    }


			    if(document.getElementById("Reason"+k).value == "" )
			    {
			       alert( "Please select Reason!" );
			       document.getElementById("Reason"+k).focus();
			       return false;
			    }
			}

    		}

	}
    
var evaluationType=''; 
	var serial_value = '';
	var RmaStatus = document.getElementById("Status").value;
var DropshipCheck = 0;
var totalSum = 0;var remainQty=0;var inQty=0;
		for(var i=1;i<=NumLine;i++){
     evaluationType = document.getElementById("evaluationType"+i).value;
			   serial_value = document.getElementById("serial_value"+i).value;
        DropshipCheck = document.getElementById("DropshipCheck"+i).value;
			   var seriallength=0;
			   if(serial_value != ''){
			      var resSerialNo = serial_value.split(",");
			      var seriallength = resSerialNo.length;

			   }
			if(document.getElementById("qty"+i) != null){	
							 
				 remainQty = document.getElementById("remainQty"+i).value;
				 inQty = document.getElementById("qty"+i).value;
				 totalSum += inQty;
				if(parseInt(remainQty) < parseInt(inQty))
				 {
					//alert("Return Qty Should be Less Than Or Equal To Invoice Qty.");
					alert("RMA qauntity must be be less than or equal to "+remainQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				 }
					
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}

if(RmaStatus == 'Completed'){
				if( (evaluationType == 'Serialized' || evaluationType == 'Serialized Average') && seriallength!=inQty && DropshipCheck!=1 ){
					alert("Please select "+inQty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
				}
}
				
			}
			
		}
		//alert(totalSum);return false;
  	    totalSum = parseInt(totalSum, 10);
		if(totalSum == 0)
		{
		  alert("RMA qauntity should not be blank.");
			  return false;
		}else{
			if(ModuleVal!='' && OrderID!=''){
				var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
				SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
				return false;	
			}else{
				ShowHideLoader('1','S');
				return true;	
			}

		}
	

	
		
}
</script>

<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">RMA Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> RMA No# : </td>
	<td align="left" width="30%" valign="top">
	<?php if(!empty($_GET['edit'])){?>
<input name="ReturnID" type="text" class="datebox" id="ReturnID" value="<?=$arrySale[0]['ReturnID']?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','ReturnID','<?=$_GET['edit']?>');"  />
	<div id="MsgSpan_ModuleID"></div>
	<?php }else{
		$NextModuleID = $objConfigure->GetNextModuleID('s_order','RMA');
	?>
	<input name="ReturnID" type="text" class="datebox" id="ReturnID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','ReturnID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Item RMA Date  :</td>
        <td   align="left" >

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

</td>
      </tr>
 
<tr>
	 
	
		
		
		
        <td  align="right"   class="blackbold" width="20%">RMA Expiry Date :</td>
        <td   align="left" >

		<script type="text/javascript">
		$(function() {
			$('#ExpiryDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				minDate: "-0D", 
				changeMonth: true,
				changeYear: true

				}
			);
		});
</script>

<? 	
$ExpiryDate = ($arrySale[0]['ExpiryDate']>0)?($arrySale[0]['ExpiryDate']):('');
?>
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$ExpiryDate?>"  type="text" > 


</td>
	

	<td  align="right"   class="blackbold"> RMA Status : </td>
	<td   align="left" >
		<select name="Status" id="Status" class="textbox" style="width:100px;">
		<option value="Parked" <?=($arrySale[0]['Status']=="Parked")?("Selected"):("")?>>Parked</option>     
		<option value="Completed"  <?=($arrySale[0]['Status']=="Completed")?("Selected"):("")?>>Completed</option>   
		</select>  
 
	</td>

	
</tr>
		
	
<tr>
	<td  align="right" class="blackbold"> Re-Stocking : </td>
	<td align="left">	 
<select class="textbox" id="ReSt" name="ReSt" onchange="Javascript:reStock();" style="width:100px;">
	<option value="0" <?=($arrySale[0]['ReSt']=='0')?('selected'):('')?>>No</option>
	<option value="1" <?=($arrySale[0]['ReSt']=='1')?('selected'):('')?>>Yes</option>
</select>	
	</td>
	

	<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		 	<input name="ReturnComment" type="text" class="inputbox" id="ReturnComment" value="<?php echo stripslashes($arrySale[0]['ReturnComment']); ?>"  maxlength="100" />          
		</td>

 
</tr>

 <? if($arrySale[0]['EDIRefNo']!=''){?>
  <tr>
<td  align="right"   class="blackbold" > Edi Ref No  : </td>
			<td   align="left" >
	<input name="EDIRefNo" type="text" class="disabled" id="EDIRefNo" readonly value="<?php echo stripslashes($arrySale[0]['EDIRefNo']); ?>"  maxlength="100" />          
		</td>
    </tr>
<? }?>
	

<tr>

	<td align="left"></td>
	<td align="left"></td>
<? 
 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
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
$arryShipStand["REFERENCE_NUMBER"] = $arrySale[0]['ReturnID']; 
$arryShipStand["CustID"] = $arrySale[0]['CustID']; 
$arryShipStand["ModuleType"] = 'SalesRMA';
include("../includes/html/box/shipping_box_standalone.php");
?>
</tr>	
	

</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/rma_order_view.php");?></td>
</tr>
<tr>
	<td align="left">
	<?
	$arryShipStand['ModuleType'] = 'SalesRMA';
	$arryShipStand['RefID'] = $OrderID; 
	include("../includes/html/box/shipping_info_standalone.php");
	?>
	</td>
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
	 <td  align="left" class="head" ><?='Line Item'?>


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
	<? include("includes/html/box/so_item_rma.php"); ?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="<?=$ButtonTitle?>"  />
		<? } ?>
		<?php if(!empty($_GET['Inv'])){?>
		<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['Inv']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		<input type="hidden" name="EdiRefInvoiceID" id="EdiRefInvoiceID" value="<?=$arrySale[0]['EdiRefInvoiceID']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



