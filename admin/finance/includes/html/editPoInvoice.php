
<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Create ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_invoice_form.php");

?>



<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0;
	var NumLine = parseInt($("#NumLine").val());   
        var evaluationType=''; var serial_value = '';var DropshipCheck='0';
	var ModuleVal = Trim(document.getElementById("PoInvoiceID")).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;

	if(!ValidateMandRange(document.getElementById("PoInvoiceID"), "Invoice Number",3,20)){
		return false;
	}

       
	for(var i=1;i<=NumLine;i++){
            
            
		if(document.getElementById("item_id"+i) != null){
                    
                    
			qty_left = 0; qty = document.getElementById("qty"+i).value;
			qty_left = document.getElementById("ordered_qty"+i).value - document.getElementById("total_received"+i).value;
                        qty_left = parseInt(qty_left) + parseInt(document.getElementById("oldqty"+i).value);
			evaluationType = document.getElementById("evaluationType"+i).value;
                      

                        /******************************************************/
                        DropshipCheck = document.getElementById("DropshipCheck"+i).value;
                        serial_value = document.getElementById("serial_value"+i).value;
                                 var seriallength=0;
                                 if(serial_value != ''){
                                    var resSerialNo = serial_value.split(",");
                                    var seriallength = resSerialNo.length;
                                 }
                        /*********************************************************************/
                       
                       
                        

			if(qty_left > 0){
 
				if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}			
				if(qty > qty_left){
					alert("Qauntity must be be less than or equal to "+qty_left+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}
			/*if(parseInt(seriallength) != parseInt(qty) && evaluationType == 'Serialized' && DropshipCheck != 'Dropship' &&  parseInt(qty) > 0)
				{
				alert("Please add "+qty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
				}	else{
			total_qty += +$("#qty"+i).val();
			}*/
total_qty += +$("#qty"+i).val();
				total_qty_left += +qty_left;
			}


		}
	}

	var TotalAmount = parseFloat($("#TotalAmount").val());
	if(TotalAmount<=0){
		alert("Grand Total must be greater than 0.");
		return false;
	}

	
	if(total_qty_left<=0){
		alert("All qauntities has been received this order.");
		return false;
	}else if(total_qty<=0){
		alert("Please enter qauntity received for any item.");
		return false;
	}


	var Url = "isRecordExists.php?PoInvoiceID="+escape(ModuleVal)+"&editID="+OrderID;
	SendExistRequest(Url,"PoInvoiceID", "Invoice Number");
	return false;
	
		
}
/*
function validateForm5555(frm){
	 if(document.getElementById("InvoicePaid").checked == true){
		 if(!ValidateForSelect(frm.PaymentDate, "Payment Date")){
			return false;
		}
		 if(!ValidateForSelect(frm.InvPaymentMethod, "Payment Method")){
			return false;
		}
	 }	
	 
	 ShowHideLoader('1','S');
}*/

/************************* Sanjiv ****************************/
function hashDiff(h1, h2) {
	  var d = {};
	  for (k in h2) {
	    if (h1[k] !== h2[k]) d[k] = h1[k];
	  }
	  return d;
	}


	function convertSerializedArrayToHash(a) { 
	  var r = {}; 
	  for (var i = 0;i<a.length;i++) { 
	    r[a[i].name] = a[i].value;
	  }
	  return r;
	}

	$(function() {
		  var startItems = convertSerializedArrayToHash( $('form[name="form1"] [type!="hidden"]').serializeArray() ); 
		  $('form[name="form1"]').submit(function () { 
		    var currentItems = convertSerializedArrayToHash($('form[name="form1"] [type!="hidden"]').serializeArray());
		    var itemsToSubmit = hashDiff( startItems, currentItems);
		    var NewItemsToSubmit = hashDiff( currentItems, startItems);
				$("#USER_LOG").val(JSON.stringify(itemsToSubmit));
				$("#USER_LOG_NEW").val(JSON.stringify(NewItemsToSubmit));
		  });
		});
/************************* End ****************************/

</script>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<input type="hidden" name="USER_LOG" id="USER_LOG" value="" />
<input type="hidden" name="USER_LOG_NEW" id="USER_LOG_NEW" value="" />

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Invoice Information <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['edit']?>&module=PurchasesInvoice" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()"></a></td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" >

<input name="PoInvoiceID" type="text" class="datebox" id="PoInvoiceID" value="<?=$arryPurchase[0]['InvoiceID']?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','PoInvoiceID','<?=$_GET['edit']?>');"  oncontextmenu="return false"  />
	<span id="MsgSpan_ModuleID"></span>


</td>
      </tr>
	 <tr>
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#PostedDate').datepicker(
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
$PostedDate = ($arryPurchase[0]['PostedDate']>0)?($arryPurchase[0]['PostedDate']):($arryTime[0]); 
?>
<input id="PostedDate" name="PostedDate" readonly="" class="datebox" value="<?=$PostedDate?>"  type="text" > 



		</td>
      </tr> 
 <tr>
        <td  align="right"   class="blackbold" >Item Received Date  :</td>
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
$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?($arryPurchase[0]['ReceivedDate']):($arryTime[0]); 
?>
<input id="ReceivedDate" name="ReceivedDate" readonly="" class="datebox" value="<?=$ReceivedDate?>"  type="text" > 


</td>
      </tr>

	<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	</tr>
	<tr>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>



  	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?php // added by sanjiv
			$module = 'Invoice';
	 		$MultiComment = explode("##",$arryPurchase[0]['InvoiceComment']); 
	 		if(empty($MultiComment[1]) && !empty($MultiComment[0])){ ?>
	 			 <input type="text" id="InvoiceComment" class="inputbox" name="InvoiceComment" maxlength="200" value="<?=$arryPurchase[0]['InvoiceComment']?>">
	 		<?php }else{ 
	 			$module_type = 'purchases';
	 			$arrComments = $arryPurchase[0]['InvoiceComment'];
	 			include("../includes/html/box/PO_SO_Comments.php"); ?>
	 			<input type="hidden" name="InvoiceComment" id="InvoiceComment" value="<?php echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"/>	
	 		<?php }
		 	?>
				<!--  <input name="InvoiceComment" type="text" class="inputbox" id="InvoiceComment" value="<?php //echo stripslashes($arryPurchase[0]['InvoiceComment']); ?>"  maxlength="100" />  -->           
		</td>
	</tr> 
<? if($arryCurrentLocation[0]['country_id']==106){ ?>
<tr>
	<td valign="top" align="right" class="blackbold">Upload Document :</td>
		<td  align="left" valign="top" >
	<input name="UploadDocuments" type="file" class="inputbox" id="UploadDocuments" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
               	<?=SUPPORTED_SCAN_DOC?>
	<? 
	 
         if(IsFileExist($Config['P_DocomentDir'],$arryPurchase[0]['UploadDocuments']) ){

	$OldUploadDocuments = $arryPurchase[0]['UploadDocuments'];
 ?>
	<br><br>
	<input type="hidden" name="OldUploadDocuments" value="<?=$OldUploadDocuments?>">
	<div id="UploadDocumentsDiv">
	<?=$arryPurchase[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryPurchase[0]['UploadDocuments']?>&folder=<?=$Config['P_DocomentDir']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['P_DocomentDir']?>', '<?=$arryPurchase[0]['UploadDocuments']?>','UploadDocumentsDiv')"><?=$delete?></a>
	</div>
<?	} ?>
               
                </td>
	</tr>
<?php } 
// End // ?>
 <!--tr>
        <td  align="right" class="heading">Payment Details</td>
		 <td  align="right" class="heading"></td>
      </tr>
	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';?>
		</td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" > Invoice Paid  : </td>
        <td   align="left" >
		<? if($arryPurchase[0]['InvoicePaid']!=1){ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" <?=($arryPurchase[0]['InvoicePaid']==1)?("checked"):("")?>> 
		<? }else{ ?>
		<input type="checkbox" name="InvoicePaid" id="InvoicePaid" value="1" style="display:none" checked> <span class="green">Yes</span>
		<? } ?>

	<input type="hidden" name="OldInvoicePaid" id="OldInvoicePaid" value="<?=$arryPurchase[0]['InvoicePaid']?>" readonly >	
           </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Payment Date :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#PaymentDate').datepicker(
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
$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?($arryPurchase[0]['PaymentDate']):(""); 
?>
<input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$PaymentDate?>"  type="text" > 


</td>
      </tr>

<tr>
        <td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		  <select name="InvPaymentMethod" class="inputbox" id="InvPaymentMethod">
		  	<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryPurchase[0]['InvPaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>

<tr>
        <td  align="right" class="blackbold">Payment Ref #  :</td>
        <td   align="left">
	<input name="PaymentRef" type="text" class="inputbox" id="PaymentRef" value="<?php echo stripslashes($arryPurchase[0]['PaymentRef']); ?>"  maxlength="30" onKeyPress="Javascript:return isAlphaKey(event);"/>          
	
		</td>
</tr>

 <tr>
        <td  align="right" ></td>
        <td   align="left" > <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Save " ></td>
      </tr-->
 

</table>

	 </td>
</tr>

<tr>
	 <td  align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>


<tr>
    <td >

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
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td  align="left" class="head" ><?=RECEIVED_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
	<td align="left" >
		<? include("includes/html/box/po_item_receive.php"); ?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? //if($TotalQtyLeft>0){ ?>	
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update " >
<? //} ?>

<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />



</td>
   </tr>
  
</table>

 </form>


<? } ?>





