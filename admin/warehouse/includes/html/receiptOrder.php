<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
</div>



<div class="message" align="center"><? if(!empty($_SESSION['mess_Receipt'])) {echo $_SESSION['mess_Receipt']; unset($_SESSION['mess_Receipt']); }?></div>


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

	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0;
	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleVal = Trim(document.getElementById("PoReceiptID")).value;

	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById("PoReceiptID"), "Receipt Number",3,20)){
			return false;
		}
	}

	var GenrateInvoice = Trim(document.getElementById("GenrateInvoice")).value;
	var ReceiptStatus = Trim(document.getElementById("ReceiptStatus")).value;

	if(GenrateInvoice == '1' && ReceiptStatus =="Completed"){	
		var RefInvoiceID = Trim(document.getElementById("RefInvoiceID")).value;
		if(RefInvoiceID!=''){
			var DataExist=0;
			if(!ValidateMandRange(document.getElementById("RefInvoiceID"), "Invoice Number",3,20)){
				return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&PoInvoiceID="+escape(RefInvoiceID), "RefInvoiceID","Invoice Number");
			if(DataExist==1)return false;
		}
	}

        var PrepaidFreight = $("#PrepaidFreight").val();
var POReceipt = $("#POReceipt").val();
	if(PrepaidFreight == '1' && POReceipt=='0'){
		var PrepaidAmount = parseFloat($("#PrepaidAmount").val());
		if(PrepaidAmount<=0){
			alert("Prepaid Freight must be greater than 0.");
			document.getElementById("PrepaidAmount").focus();
			return false;
		}
	}

        
        var evaluationType=''; var serial_value = '';var DropshipCheck='';
         DropshipCheck = document.getElementById("OrderDropShip").value;
       var comType =  document.getElementById("comType").value
	for(var i=1;i<=NumLine;i++){
            
            
		if(document.getElementById("item_id"+i) != null){
                    
                    
			qty_left = 0; qty = document.getElementById("qty"+i).value;
			qty_left = document.getElementById("ordered_qty"+i).value - document.getElementById("total_received"+i).value;
                        evaluationType = document.getElementById("evaluationType"+i).value;
                        
                        /******************************************************/
                       

                        serial_value = document.getElementById("serial_value"+i).value;
                                 var seriallength=0;
                                 if(serial_value != ''){
                                    var resSerialNo = serial_value.split(",");
                                    var seriallength = resSerialNo.length;
                                 }
                        /*********************************************************************/
                        
                       
                        

			if(qty_left > 0){

				if(!ValidateOptNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}			
				if(qty > qty_left){
					alert("Qauntity must be be less than or equal to "+qty_left+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}
					if(parseInt(seriallength) != parseInt(qty) && (evaluationType == 'Serialized' || evaluationType == 'Serialized Average') && DropshipCheck != 'Dropship' &&  parseInt(qty) > 0 && comType!=1)
					{
							alert("Please add "+qty+" serial number.");
							document.getElementById("qty"+i).focus();
							return false;
					}
                                    else{
					total_qty += +$("#qty"+i).val();
				}
				total_qty_left += +qty_left;
			}


		}
	}



	var TotalAmount = parseFloat($("#TotalAmount").val());
	/*if(TotalAmount<=0){
		alert("Grand Total must be greater than 0.");
		return false;
	}*/


	
	if(total_qty_left<=0){
		alert("All qauntity has been received this order.");
		return false;
	}else if(total_qty<=0){
		alert("Please enter qauntity received for any item.");
		return false;
	}





	if(ModuleVal!=''){
		var Url = "isRecordExists.php?PoReceiptID="+escape(ModuleVal)+"&editID=";
		SendExistRequest(Url,"PoReceiptID", "Receipt Number");
		return false;	
	}else{
		ShowHideLoader('1','S');
		return true;	
	}
	
		
}




$(document).ready(function(){
	$('#GenrateInvoice').change(function(){
		if(this.checked){
			$('#inv').fadeIn('slow');
			$('#invdate').fadeIn('slow');
		}else{
			$('#inv').fadeOut('slow');
			$('#invdate').fadeOut('slow');
		}

	});
});

$(document).ready(function () {
	$('#FillAllQty').change(function () {
		var NumLine = parseInt($("#NumLine").val());
		for(var i=1;i<=NumLine;i++){
			var ordered_qty = $("#ordered_qty"+i).val();
			var total_received = $("#total_received"+i).val();
			if (!this.checked) {
			
					$("#qty"+i).val('');
					$("#qty"+i).trigger("keyup");
			}else{ 
					var totOrderQty = ordered_qty - total_received;
					$("#qty"+i).val(totOrderQty) ;
					//$("#qty"+i).focus();
					$("#qty"+i).trigger("keyup");
			 }

		}
	});

});
</script>





<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Receipt # : </td>
        <td   align="left" >

	<input name="PoReceiptID" type="text" class="datebox" id="PoReceiptID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','PoReceiptID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>

</td>
      </tr>
 <!--tr>
        <td  align="right"   class="blackbold" >Item Received Date : </td>
        <td   align="left" >
<? 	
$arryTime = explode(" ",$Config['TodayDate']);
echo date($Config['DateFormat'], strtotime($arryTime[0]));
?>

		</td>
      </tr-->  
 <tr>
        <td  align="right"   class="blackbold" > Item Received Date :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReceivedDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});

</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReceivedDate = $arryTime[0]; 
?>
<input id="ReceivedDate" name="ReceivedDate" readonly="" class="datebox" value="<?=$ReceivedDate?>"  type="text" > 


</td>
      </tr>
 

 <tr>
        <td  align="right"   class="blackbold" > Generate Invoice  : </td>
        <td   align="left" >
		<input type="checkbox" name="GenrateInvoice" id="GenrateInvoice" value="1" <?=($arryPurchase[0]['GenrateInvoice']==1)?("checked"):("")?>> 
    

           </td>
      </tr>

 <tr id="inv" style="display: none;">
        <td  align="right"   class="blackbold" > Invoice Number #   : </td>
        <td   align="left" >		 
    <input name="RefInvoiceID" type="text" class="datebox" id="RefInvoiceID" value="<?=$NextInvModuleID?>"  maxlength="20" onKeyPress="Javascript:return isAlphaKey(event);" oncontextmenu="return false" onBlur="Javascript:RemoveSpecialChars(this);"  />
           </td>
      </tr>

 <tr id="invdate" style="display: none;">
        <td  align="right"   class="blackbold" > Invoice Date   : </td>
        <td   align="left" >		 



<script type="text/javascript">
$(function() {
	$('#RefInvoiceDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true


		}
	);
});

</script>
 
<input id="RefInvoiceDate" name="RefInvoiceDate" readonly="" class="datebox" value="<?=$arryTime[0]?>"  type="text" >

           </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" > Receipt Status  : </td>
        <td   align="left" >

						<select name="ReceiptStatus" id="ReceiptStatus" class="inputbox">
							<option value="Parked" <?=($arryPurchase[0]['ReceiptStatus']=="Parked")?("selected"):("")?>>Parked</option>
							<option value="Completed" <?=($arryPurchase[0]['ReceiptStatus']=="Completed")?("selected"):("")?>>Completed</option>
						</select>
    
           </td>
      </tr>


 	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="InvoiceComment" type="text" class="inputbox" id="InvoiceComment" value="<?php echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"  maxlength="100" />          
		</td>
	</tr>
 <!--tr>
        <td  align="right"   class="blackbold" > Invoice Paid  : </td>
        <td   align="left" >
		<input type="checkbox" name="InvoicePaid" value="1" <?=($arryPurchase[0]['InvoicePaid']==1)?("checked"):("")?>> 
    
           </td>
      </tr-->
</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_view.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
	 <td align="right">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" ></td>
		</tr>
		<tr>
	<td align="left" >
			 <input type="checkbox" name="FillAllQty" id="FillAllQty" class="textbox" value="1"/> <span class="heading">Fill All Quantity</span>
			</td>
			<td align="right" >
				<?

$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
			</td>
		</tr>
		</table>	

	 </td>

</tr>



<!--tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr-->


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" ><?=RECEIVED_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&view=<?=$_GET['po']?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		 
                    $(".slnoclass").fancybox({
			'width'         : 500
		 });

});

</script>



	 </td>
</tr>

<tr>
	<td align="left" >
		<? 	include("includes/html/box/po_item_receive.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? if($QtyFlag==1){ ?>	
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Process "  />
<? } ?>


<input type="hidden" name="ReceiveOrderID" id="ReceiveOrderID" value="<?=$_GET['po']?>" readonly />
<input type="hidden" name="PurchaseID" id="PurchaseID" value="<?=$arryPurchase[0]['PurchaseID']?>" readonly />
<input type="hidden" name="OrderDropShip" id="OrderDropShip" value="<?=$arryPurchase[0]['OrderType']?>" />
<input type="hidden" name="comType" id="comType" value="<?=$Config['SelectOneItem']?>" />
<input type="hidden" name="POReceipt" id="POReceipt" value="<?=$POReceipt?>" />
<input type="hidden" name="EdiRefInvoiceID" id="EdiRefInvoiceID" value="<?=$arrySales[0]['InvoiceID']?>" readonly />

</td>
   </tr>
  
</table>

 </form>








<? } ?>



