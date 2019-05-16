<?
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$OrderSourceFlag = 1;
		$MandForEcomm = '<span class="red">*</span>';
	}
}

?>
<a href="<?=$RedirectURL?>" class="back">Back</a>

<a class="add authopen" href="javascript:void(0)">Paypal</a>





<? 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);
if($arrySale[0]["OrderType"] != '') $OrderType = $arrySale[0]["OrderType"]; else $OrderType = 'Standard';

if(!empty($_GET['edit'])){
            $total_received = $objSale->GetQtyInvoiced($_REQUEST['edit']);
			$total_ordered = $total_received[0]['Qty'];
			$total_invoiced = $total_received[0]['QtyInvoiced'];
		}
		
	if($arrySale[0]['Approved'] == 1 && $arrySale[0]['Status'] == 'Open'){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_SALE_ORDER.'</a>';
			include("includes/html/box/convert_form.php");
		}else if($module=='Order' && $total_ordered != $total_invoiced && $OrderType == 'Standard'){ 
			echo '<a class="edit" href="../finance/generateInvoice.php?so='.$arrySale[0]['SaleID'].'&invoice='.$arrySale[0]['OrderID'].'" target="_blank">'.GENERATE_INVOICE.'</a>';
				//include("includes/html/box/generate_invoice_form.php");
		}
	} 


	/*if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="../finance/viewInvoice.php?po='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}*/


 

	if($module=='Order' &&  $arrySale[0]['Approved'] == 1 && $CreditCardFlag==1 && !empty($ProviderName)){	
 
		 if($CardProcessed==1 && $CardVoided!=1){						
			echo '<div style="float:right"><a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" onMouseover="ddrivetip(\'<center><img src=../icons/provider'.$ProviderID.'.jpg></center>\', 120,\'\')"; onMouseout="hideddrivetip()">Void Credit Card</a></div>';			
		}else{
			echo '<div style="float:right"><a href="'.$AuthorizeCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Authorize Credit Card\', \''.AUTH_CARD.'\')" onMouseover="ddrivetip(\'<center><img src=../icons/provider'.$ProviderID.'.jpg></center>\', 120,\'\')"; onMouseout="hideddrivetip()">Authorize Credit Card</a></div>';
		}
	 }

?>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	


<?
    if (!empty($_SESSION['mess_Sale'])) {
        echo '<div class="message" align="center">'.$_SESSION['mess_Sale'].'</div>';
        unset($_SESSION['mess_Sale']);
    }
?>



<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}
	

	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleField = '<?=$ModuleID?>';
	
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
        
        /*var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;*/

        //var SpiffSetting = Trim(document.getElementById("SpiffSetting")).value;
        
        var OrderType = Trim(document.getElementById("OrderType")).value;
        //var PONumber = Trim(document.getElementById("PONumber")).value;
         
        var TotalAmount = parseFloat($("#TotalAmount").val());
	var TransactionAmount = parseFloat($("#TransactionAmount").val());
	 

	if(ModuleVal!='' || OrderID>0){
		if(!ValidateMandRange(document.getElementById(ModuleField), "<?=$ModuleIDTitle?>",3,20)){
			return false;
		}
	}
       
       
        if(!ValidateForSelect(frm.CustomerName, "Customer")){        
            return false;
        }
        
        if(OrderType == 'Against PO'){
            
            if(!ValidateForSelect(frm.PONumber, "Purchase Order")){        
                return false;
             }
        }
        
	if(document.getElementById("Spiff1") != null){
		if(document.getElementById("Spiff1").checked){
			 
		       var SpiffSetting =  checkSpiffSetting();
		         
		        if(SpiffSetting == 0){        
		            alert("Please configure spiff settings.");
		            return false;
			 }
		        if(!ValidateForSelect(frm.SpiffContact, "Customer Contact")){        
		    		return false;
			 }
			 if(!ValidateForSimpleBlank(frm.SpiffAmount, "Spiff Amount")){        
		    		return false;
			 }
		}

	}

       /* if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greater Than Start Date.");
                      return false;
                     }
                }*/


	if(document.getElementById("OrderSource") != null){
		if(!ValidateForSelect(frm.OrderSource, "Order Source")){        
		    return false;
		}
		if(!ValidateForSelect(frm.PaymentMethod, "Payment Method")){        
		    return false;
		}
	}
	 if(document.getElementById("PaymentTerm").value == 'PayPal' && document.getElementById("paypalemail").value==''){
			alert('Please enter paypal email');
			return false;
	} 


	if(   ValidateForSelect(frm.OrderDate, "Order Date") 
		//&& ValidateForSimpleBlank(frm.BillingName, "Billing Name")
                                
		&& ValidateForSimpleBlank(frm.Address, "Address")
		&& ValidateForSimpleBlank(frm.City, "City")
		&& ValidateForSimpleBlank(frm.State, "State")
		&& ValidateForSimpleBlank(frm.Country, "Country")
		&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)	
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		
		//&& ValidateForSimpleBlank(frm.ShippingName, "Shipping Name")
		&& ValidateForSimpleBlank(frm.ShippingAddress, "Shipping Address")
		&& ValidateForSimpleBlank(frm.ShippingCity, "City")
		&& ValidateForSimpleBlank(frm.ShippingState, "State")
		&& ValidateForSimpleBlank(frm.ShippingCountry, "Country")
		&& ValidateForSimpleBlank(frm.ShippingZipCode, "Zip Code")
		//&& ValidatePhoneNumber(frm.ShippingMobile,"Mobile Number",10,20)
		//&& ValidateForSimpleBlank(frm.ShippingEmail, "Email Address")
		&& isEmailOpt(frm.ShippingEmail)
	){


		
		for(var i=1;i<=NumLine;i++){
		 
			if(document.getElementById("sku"+i).value == ""){
				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
					return false;
				}

if(!ValidateForSelect(document.getElementById("Condition"+i), "Condition")){
					return false;
				}
				if(!ValidateForSimpleBlank(document.getElementById("description"+i), "Item Description")){
					return false;
				}
				if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}	
			}
		 
			if(parseFloat(document.getElementById("discount"+i).value) > parseFloat(document.getElementById("price"+i).value))
			{
			   alert("Discount Should be Less Than Unit Price!");
			   return false;
			}
		}


		/*******************************/		 
		if(OrderID>0 && $("#PaymentTerm").val()=='Credit Card'){
			var TotalAmount = parseFloat($("#TotalAmount").val());
			if(TotalAmount<=0){
				 alert("Order Total must be greater than 0.");
			   	return false;
			}

			if(TransactionAmount>0 && TotalAmount>0 && TotalAmount!=TransactionAmount){
				var TransactionDiff = TotalAmount - TransactionAmount;
				if(TransactionDiff>0){
					var ChargeRefundMsg = "An amount of "+TransactionDiff.toFixed(2)+" will be charged on credit card.\nAre you sure you want to authorize and charge the credit card?";
				}else{
					TransactionDiff = -TransactionDiff;
					var ChargeRefundMsg = "An amount of "+TransactionDiff.toFixed(2)+" will be refunded on credit card.\nAre you sure you want to refund this amount for credit card?";
				}

				/*confirmAlert("ChargeRefund","Credit Card", ChargeRefundMsg);
				if($("#ChargeRefund").val('0')){
					return false;
				}*/

				if(confirm(ChargeRefundMsg)){
					$("#ChargeRefund").val('1');
				}else{
					$("#ChargeRefund").val('0');
					return false;
				}				 
				
			}
		}

		
		/*******************************/
		
	
		if(ModuleVal!=''){
			var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
			SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}	
		
}



    function checkSpiffSetting(){
		var SendParam = 'action=checkSpiffSetting&r='+Math.random(); 
		var IsExist = 0;
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) { 
				if(responseText==1) {					
					IsExist = 1;
				}else if(responseText==0) {
					IsExist = 0;
				}else{
					alert("Error occur : " + responseText);
					IsExist = 1;
				}
				
			}
		});	
		return IsExist;
	}
        
        
        function setPOrder(str){

            if(str == "Against PO"){
                $("#pordertxt").show();
                $("#porderfld").show();

            }else{
            
                $("#pordertxt").hide();
                $("#porderfld").hide();
                $("#PONumber").val('');
              }
        }
        
 function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
//alert(node);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey; 
</script>




 <script>
$(function() {
	var ModuleID = '<?=$ModuleID555?>';
$( "#"+ModuleID ).tooltip({
	position: {
	my: "center bottom-2",
	at: "center+110 bottom+70",
		using: function( position, feedback ) {
			$( this ).css( position );

		}
	}
	});
});

jQuery('document').ready(function(){
		jQuery('.authopen').click(function(){
			window.open("https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?scope=https://uri.paypal.com/services/invoicing&response_type=code&redirect_uri=https://www.eznetcrm.com/erp/paypalAuthAccept.php&client_id=AQZ4wvC7sS6xKMgfNWdyqjmAYDxKLkdKNE5TEepaDKWIXouZKC5tki2rr1_nW-L0ok-b4VipmLB-0ny4", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=500,width=500,height=600");
			
		});
	
});




function shipCarrier(){
	var method = document.getElementById("ShippingMethod").value;
	var spval = document.getElementById("spval").value;
	 
	var countryCode= '';
	var SendParam = 'action='+method+'&countryCode='+countryCode+'&shippval='+spval; 

	if(method==''){
		 document.getElementById("spmethod").style.display = 'none'; 
		document.getElementById("ShippingMethodVal").value=''; 
	}else{

		 $.ajax({
			type: "GET",
			url: '../ajax.php',
			data: SendParam,
			success: function (responseText) {
				if(responseText!=''){
					document.getElementById("spmethod").style.display = 'table-row';
					document.getElementById("ShippingMethodVal").innerHTML=responseText; 
				}else{
					 document.getElementById("spmethod").style.display = 'none'; 
					document.getElementById("ShippingMethodVal").value=''; 
				}
		
			}
		});	
 	}

}




</script>



<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Customer</td>
</tr>
  <tr>
   <tr>
	<td  align="right"   class="blackbold" > Customer :<span class="red">*</span> </td>
	<td   align="left" >
		<input name="CustomerName" type="text" class="disabled_inputbox"  id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>"  maxlength="60" readonly />
		<input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustCode']); ?>">
		<input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>">
	<input name="Taxable" id="Taxable" type="hidden" value="<?php echo stripslashes($arrySale[0]['Taxable']); ?>">

	<a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>

	</td>

<?php if($Config['spiffDis']==1){?>
	<td align="right"   class="blackbold">Spiff  : </td>
	<td  align="left" >
	<label><input name="Spiff" type="radio" id="Spiff1" value="Yes" <?=($arrySale[0]['Spiff']=="Yes")?("checked"):("")?> onclick="Javascript:SetSpiff();" />&nbsp;Yes</label>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<label><input name="Spiff" type="radio" id="Spiff2" value="No" <?=($arrySale[0]['Spiff']!="Yes")?("checked"):("")?> onclick="Javascript:SetSpiff();" />&nbsp;No </label>
        
	</td>
<? }?>
</tr>
<tr style="display:none;" id="SpiffRow">
	<td align="right"   class="blackbold" valign="top">Customer Contact  :<span class="red">*</span> </td>
	<td  align="left"  valign="top">
<div id="ContactDiv" class="textarea_div" style="float:left"><?=str_replace("|","",stripslashes($arrySale[0]['SpiffContact']))?></div>

 <input id="SpiffContact" readonly type="hidden" name="SpiffContact" value="<?=stripslashes($arrySale[0]['SpiffContact'])?>">

&nbsp;<a class="fancybox fancybox.iframe" id="contact_link" href="CustomerContact.php?CustID=<?=$arrySale[0]['CustID']?>" ><?=$search?></a>

	</td>

	<td align="right"   class="blackbold"  valign="top">Spiff Amount (<?=$Currency?>) :<span class="red">*</span> </td>
	<td  align="left"  valign="top">
<input name="SpiffAmount" type="text" class="textbox" size="10" id="SpiffAmount" value="<?=stripslashes($arrySale[0]['SpiffAmount'])?>"  maxlength="10" onkeypress="return isDecimalKey(event);" />
	</td>
</tr>
<script language="JavaScript1.2" type="text/javascript">
SetSpiff();
function SetSpiff(){
	if(document.getElementById("Spiff2").checked){
		$("#SpiffRow").hide();
	}else{
		$("#SpiffRow").show();
	}	
}
</script>



 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information</td>
</tr>
   
 <tr>
        <td  align="right"   class="blackbold" > <?=$ModuleIDTitle?> # : </td>
        <td   align="left" >
<? if(!empty($_GET['edit'])) {?>

	<input name="<?=$ModuleID?>" type="text" class="datebox" id="<?=$ModuleID?>" value="<?php echo stripslashes($arrySale[0][$ModuleID]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');"  />
	<span id="MsgSpan_ModuleID"></span>


<? }else{?>
	<input name="<?=$ModuleID?>" type="text" class="datebox" id="<?=$ModuleID?>"  value="<?=$NextModuleID?>"   maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_ModuleID"></span>
<? } ?>

</td>

 	<? if($arrySale[0]['OrderPaid']>0 && $module=='Order') { ?>
	 <td  align="right"   class="blackbold" >Payment Status  : </td>
        <td   align="left" >
		<?=($arrySale[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>')?>
	</td>
	<? } ?>
  
</tr>
<tr>
 
  <td  align="right" class="blackbold">Order Type  :</td>
        <td   align="left">
<? if(!empty($_GET['edit'])) {
    
    
            if($arrySale[0]["OrderType"] != '') $OrderType = $arrySale[0]["OrderType"]; else $OrderType = 'Standard'; 
        ?> 
    
   
<input name="OrderType" id="OrderType" type="text" class="disabled" readonly style="width:90px;"  value="<?php echo $OrderType; ?>"  maxlength="20" />
<? }else{?>		
<select name="OrderType" class="textbox" id="OrderType" style="width:100px;" onchange="Javascript:setPOrder(this.value);">
		<option value="Standard">Standard</option>
                <option value="Against PO">Against PO</option>
</select> 
<? }?>	

	
	</td>  
        <td  align="right" class="blackbold"><span id="pordertxt" <?php if($arrySale[0]['OrderType'] == 'Against PO') {?> <?php } else {?> style=" display: none;" <?php }?>> Purchase Order # :<span class="red">*</span></span></td>
 <td  align="left">
     <span id="porderfld" <?php if($arrySale[0]['OrderType'] == 'Against PO') {?> <?php } else {?> style=" display: none;" <?php }?>> 
    <input name="PONumber" id="PONumber" type="text" class="disabled" value="<?php echo $arrySale[0]['PONumber']; ?>" readonly style="width:90px;" maxlength="30" />
    <? if(empty($_GET['edit']) || empty($arrySale[0]['PONumber'])) {?>
    <a class="fancybox fancybox.iframe" href="selectPO.php?o=<?=$_GET['edit']?>&module=<?=$module;?>" ><?=$search?></a>
    <? } ?>	  
    </span>
</td>

        
</tr>






 <!---Recurring Start-->
  <?php   
    //$arryRecurr = $arrySale;
    
   //include("../includes/html/box/recurring_2column_sales.php");?>
   
   <!--Recurring End-->

 <tr>
			<td  align="right"   class="blackbold" width="20%"> Sales Person  : </td>
			<td   align="left" width="30%">
				<input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arrySale[0]['SalesPerson']); ?>"  maxlength="40" readonly />
				<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arrySale[0]['SalesPersonID']); ?>" type="hidden">
				<input name="OldSalesPersonID" id="OldSalesPersonID" value="<?php echo stripslashes($arrySale[0]['SalesPersonID']); ?>" type="hidden">

				<? if($AssignLabel == 1){?>
				<a class="fancybox fancybox.iframe" href="EmpList.php?dv=7"  ><?=$search?></a>
				<? } ?>

			</td>
	

<? if($OrderSourceFlag==1){ ?>

<td  align="right" class="blackbold" >Order Source :<span class="red">*</span></td>
                 <td align="left"  >
		  <select name="OrderSource" class="inputbox" id="OrderSource" style="width:100px;">
		  	<option value="">--- None ---</option>
				<?php for($i=0;$i<sizeof($arryOrderSource);$i++) {?>
                                    <option value="<?=$arryOrderSource[$i]['attribute_value']?>" <?  if($arryOrderSource[$i]['attribute_value']==$arrySale[0]['OrderSource']){echo "selected";}?>>
					<?=$arryOrderSource[$i]['attribute_value']?>
                                    </option>
			<? } ?>
		</select> 
		</td>
<? } ?>






<tr>
        <td  align="right"   class="blackbold" width="20%">Order Date  :<span class="red">*</span> </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#OrderDate').datepicker(
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
$OrderDate = ($arrySale[0]['OrderDate']>0)?($arrySale[0]['OrderDate']):($arryTime[0]); 
?>
<input id="OrderDate" name="OrderDate" readonly="" class="datebox" value="<?=$OrderDate?>"  type="text" > 


</td>
  
<? if($arrySale[0]['Fee']>0){ ?>
<td  align="right"   class="blackbold" width="20%">Fees :  </td>
        <td   align="left" >

<input name="Fee" id="Fee" type="text" class="disabled" readonly style="width:90px;"  value="<?php echo $arrySale[0]['Fee']; ?>"  maxlength="20" />


</td>
<? } ?>





</tr>


	<? if($_GET['edit']>0){ ?>
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
         <?
                      if(($_SESSION['AdminType'] == 'admin' || $ApproveLabel==1) && $arrySale[0]['Approved'] != 1){
                                $ActiveChecked = ' checked';
                                if($_REQUEST['edit'] > 0){
                                        if($arrySale[0]['Approved'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
                                        if($arrySale[0]['Approved'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
                               }
                         ?>
					 <input type="radio" name="Approved" id="Approved" value="1" <?=$ActiveChecked?> />
					 Yes    
					 <input type="radio" name="Approved" id="Approved" value="0" <?=$InActiveChecked?> />
					 No
					 <input type="hidden" name="SentEmail" id="SentEmail" value="1">
                 <? }else{
                         echo ($arrySale[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>');
                         echo '<input type="hidden" name="Approved" id="Approved" value="'.$arrySale[0]['Approved'].'">';
						
                 }?>
                       
                 
                 
                 </td>
     </tr>
<? } ?>


<tr>
        <td  align="right" class="blackbold">Order Status  :</td>
        <td   align="left">
		<?
		if($arrySale[0]['Status'] == 'Open' || $arrySale[0]['Status'] == ''){
		?>
		  <select name="Status" class="textbox" id="Status" style="width:100px;">
				<? for($i=0;$i<sizeof($arryOrderStatus);$i++) {?>
					<option value="<?=$arryOrderStatus[$i]['attribute_value']?>" <?  if($arryOrderStatus[$i]['attribute_value']==$arrySale[0]['Status']){echo "selected";}?>>
					<?=$arryOrderStatus[$i]['attribute_value']?>
					</option>
				<? } ?>
			</select> 
		<? }else{ ?>
		<span class="redmsg"><?=$arrySale[0]['Status']?></span> <input type="hidden" name="Status" id="Status" value="<?=$arrySale[0]['OrderType']?>" readonly />
		<? } ?>

		</td>

        <td  align="right"   class="blackbold" > Delivery Date  : </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#DeliveryDate').datepicker(
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
$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?($arrySale[0]['DeliveryDate']):(''); 
?>
<input id="DeliveryDate" name="DeliveryDate" readonly="" class="datebox" value="<?=$DeliveryDate?>"  type="text" > 


</td>
     
</tr>


<tr>

        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		<? if($TransactionExist==1){ ?>
		<input type="text" name="PaymentTerm" id="PaymentTerm" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['PaymentTerm'])?>">
		<? }else{ ?>
		  <select name="PaymentTerm" class="inputbox"   id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						if($arryPaymentTerm[$i]['termType']==1){
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
						}else{
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
						}
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySale[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		
		<select name="SelectCard" class="textbox" id="SelectCard"  style="display:none;">
		  	<option value="">--- Select ---</option>
			<option value="New">New Card</option>
			<option value="Existing">Existing</option>	 	 
		</select> 
		<? } ?>

		</td>

		<td  align="right" class="blackbold">Payment Method  :<?=$MandForEcomm?></td>
                 <td align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<?php for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
                                    <option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arrySale[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
                                    </option>
			<? } ?>
		</select> 
		</td>



</tr>

<? if($arrySale[0]['PaymentTerm']=='PayPal' && !empty($arrySale[0]['paypalEmail'])){?>
	<tr>
			<td  align="right"   class="blackbold" > Paypal Email : </td>
			<td   align="left" >
<input type="text" name="paypalEmail" id="paypalEmail" maxlength="100" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['paypalEmail'])?>">
	        	 
			</td>

			<td  align="right" class="blackbold"> Paypal Invoice Number#  : </td>
			<td   align="left">
<input type="text" name="paypalInvoiceNumber" id="paypalInvoiceNumber" maxlength="100" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['paypalInvoiceNumber'])?>">
			 
		   </td>
	</tr>

	<? } ?>


<tr>
        

        <td  align="right" class="blackbold">Shipping Carrier  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod" onchange="Javascript:shipCarrier();">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arrySale[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>

<td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arrySale[0]['Comment']); ?>"  maxlength="100" />          
	</td>

</tr>

<tr id="spmethod" style="display:none;">
	<td align="right" class="blackbold">Shipping Method : </td>
	<td align="left">
	<select name="ShippingMethodVal" class="inputbox" id="ShippingMethodVal">
	</select>
	<input type="hidden" name="spval" id="spval" value="<?=$arrySale[0]['ShippingMethodVal'];?>">

	</td>
</tr>

   
 
<tr>
	<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<? if($TransactionExist==1){ ?>
		<input type="text" name="CustomerCurrency" id="CustomerCurrency" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['CustomerCurrency'])?>">
<? }else{ 

//unset($arryCompany[0]['AdditionalCurrency']);
/*if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
}else{
$arrySale[0]['CustomerCurrency'] = $Config['Currency'];
}*/

if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
}

 ?>
<select name="CustomerCurrency" class="inputbox"  id="CustomerCurrency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arrySale[0]['CustomerCurrency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>
<? } ?>

</td>

	<td  align="right"   class="blackbold" > Customer PO#  : </td>
	<td   align="left" >
	<input name="CustomerPO" type="text" class="inputbox" id="CustomerPO" value="<?php echo stripslashes($arrySale[0]['CustomerPO']); ?>"  maxlength="50" />          
	</td>
</tr>
   
<tr>


	<td  align="right"   class="blackbold" > Tracking #  : </td>
	<td   align="left" >
	<input name="TrackingNo" type="text" class="inputbox" id="TrackingNo" value="<?php echo stripslashes($arrySale[0]['TrackingNo']); ?>"  maxlength="50" />          
	</td>


<td  align="right"   class="blackbold" > Shipping Account  : </td>
	<td   align="left" >
	<input name="ShipAccount" type="text" class="inputbox" id="ShipAccount" value="<?php echo stripslashes($arrySale[0]['ShipAccount']); ?>"  maxlength="50" />          
	</td>

</tr>


 

</table>


<?      include("includes/html/box/sale_card.php");
	
?>




</td>
   </tr>

  





<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("includes/html/box/sale_order_billto_form.php");?></td>
			<td align="left" valign="top"><? include("includes/html/box/sale_order_shipto_form.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
			 <td align="right">
		<?
				 
		//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
		?>	 
			 </td>
		</tr>

<tr>
	<td align="left" >
		
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" >
					<?php

 if($_SESSION['SelectOneItem'] == 1){ 

						   include("includes/html/box/sale_order_item_subform.php");
					}else{

					    include("includes/html/box/sale_order_item_form.php");
					}

 ?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? 
  
   echo $HideSubmit=0;
  if($arrySale[0]['Status'] == '' || $arrySale[0]['Status'] == 'Open'){ 

  
 
	  if($HideSubmit != 1){ 
?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton"  value=" <?=$ButtonTitle?> "  />


 
<input type="hidden" name="TransactionAmount" id="TransactionAmount" class="inputbox" readonly value="<?=$CreditCardBalance?>" /> 

<input type="hidden" name="ChargeRefund" id="ChargeRefund" class="inputbox" readonly value="0" /> 
 


		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

		<input type="hidden" name="Module" id="Module" value="<?=$module?>" />

		<input type="hidden" name="ModuleID" id="ModuleID" value="<?=$ModuleID?>" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="<?=$PrefixSale?>" />

	</td>
   </tr>



<? }} ?>
  
</table>

 </form>


<? } ?>



<script>
var OrderType = Trim(document.getElementById("OrderType")).value;
setPOrder(OrderType);
shipCarrier();
</script>
<?php if($_SESSION['SelectOneItem'] != 1){ ?>
<div id="popup1" class="modal-box">
  <header> <a href="#" class="btn btn-small js-modal-close">Close</a> 
    <h3>Select Item</h3>
  </header>
  <div class="modal-body">
      
  </div>    
     <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
</div>
<? }?>


<script>

function SelectCreditCard(){
	/*$('#SelectCard').hide();
	$('#CreditCardInfo').hide();  */
 
	
	if($("#PaymentTerm").val()=='Credit Card'){
		$('#SelectCard').show(); 
		if($("#CreditCardNumber").val()!='' && $("#CreditCardType").val()!=''){
			$('#CreditCardInfo').show(); 
		}else{
			$('#CreditCardInfo').hide();  
		}
	}else{
		$('#SelectCard').hide();
		$('#CreditCardInfo').hide();  
	}
	
}


jQuery('document').ready(function(){

	$('#SelectCard').change(function(){
		var CustID = $("#CustID").val();
		if(CustID>0){
			var url = '';
			if($(this).val()=='New'){
				url = '../editCustCard.php?CustID='+CustID+'&SaveSelect=1';
			}else{
				url = '../selectCustCard.php?CustID='+CustID;
			}
			 
			$.fancybox({
				 'href' : url,
				 'type' : 'iframe',
				 'width': '800',
				 'height': '800'
			});
		}else{
			alert("Please select customer first.");
		}
	});



	jQuery('#PaymentTerm').change(function(){
		if(jQuery(this).val()=='PayPal'){
			if(jQuery('.paypa-email-tr').length==0){
				var html='';
				html+='<tr class="paypa-email-tr" id="paypa-email-tr"><td align="right" class="blackbold">Paypal Email:</td>';
				html+='<td align="left" id="paypal-email-input-td"><input type="text" class="inputbox" name="paypalemail" id="paypalemail">';
				if(jQuery('#CustID').val()){
					html+='<a href="paypalemail.php?cid='+jQuery('#CustID').val()+'" class="fancybox fancybox.iframe" id="paypalemailSearch"><img src="../images/search.png"></a>';
				}
				html+='</td>';
				html+='<td align="right" class="blackbold"> </td><td align="left"></td></tr>';
			jQuery(this).parent('td').parent('tr').after(html);
			}		
		}else{
			jQuery('.paypa-email-tr').remove();
		}
		SelectCreditCard();
		
	});
})


SelectCreditCard();
</script>
