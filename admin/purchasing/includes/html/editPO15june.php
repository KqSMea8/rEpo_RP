<a href="<?=$RedirectURL?>" class="back">Back</a>
<?
	if($OrderIsOpen ==  1){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_PO.'</a>';
			include("includes/html/box/convert_form.php");
		}else if($module=='Order' ){ 
			echo '<a href="../warehouse/receiptOrder.php?po='.$arryPurchase[0]['OrderID'].'&curP='.$_GET['curP'].'"  class="edit" target="_blank">'.RECIEVE_ORDER.'</a>';
		}
	} 


	if($module=='Order' && $arryPurchase[0]['PurchaseID']!='' ){ 
		$TotalInvoice=$objPurchase->CountInvoices($arryPurchase[0]['PurchaseID']);
		if($TotalInvoice>0)
			echo '<a href="../warehouse/viewPoInvoice.php?po='.$arryPurchase[0]['PurchaseID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}

?>





<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
 <? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_form.php");

?>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">



function validateForm(frm){

if(!ValidateMandRange(document.getElementById("SuppCode"), "Vendor Code",3,20)){
			return false;
		}


	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}

	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleField = '<?=$ModuleID?>';
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
var TrackInv = document.getElementById("TracInv").value;
var comType = document.getElementById("comType").value;

	

	if(ModuleVal!='' || OrderID>0){
		if(!ValidateMandRange(document.getElementById(ModuleField), "<?=$ModuleIDTitle?>",3,20)){
			return false;
		}
	}

        var PaymentTerm = $("#PaymentTerm").val().toLowerCase();
	if(PaymentTerm == 'prepayment'){
		if(!ValidateForSelect(frm.BankAccount, "Bank Account")){        
		    return false;
		}
	}

	var PrepaidFreight = $("#PrepaidFreight").val();
	if(PrepaidFreight == '1'){
		if(!ValidateForSelect(frm.PrepaidVendor, "Prepaid Freight Vendor")){        
		    return false;
		}
	}




	if( ValidateForSelect(frm.OrderDate, "Order Date")
		&& ValidateForSelect(frm.SuppCode, "Vendor")
		//&& ValidateForSelect(frm.PaymentTerm, "Payment Term")
		//&& ValidateForSimpleBlank(frm.SuppCompany, "Company Name")
		//&& ValidateForSimpleBlank(frm.Address, "Address")
		//&& ValidateForSimpleBlank(frm.City, "City")
		//&& ValidateForSimpleBlank(frm.State, "State")
		//&& ValidateForSimpleBlank(frm.Country, "Country")
		//&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidateForSimpleBlank(frm.SuppContact, "Contact Name")
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		&& isEmailOpt(frm.wEmail)
	){
		//alert("aaaa");return false;
		for(var i=1;i<=NumLine;i++){
			if(document.getElementById("sku"+i) != null){
				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
					return false;
				}
if(TrackInv ==1){
     if(!ValidateForSelect(document.getElementById("Condition"+i), "Condition")){
					return false;
				}
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
		}



	
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


function setPrepaidFreight(){	
	$("#PrepaidAmount").val(0); 	
	if(document.getElementById("PrepaidFreight").value=="1"){
		$("#PrepaidVendorTr").show();
		$("#PrepaidAmountDiv").show();
		
		/****************/
		var TrackingNo =  '';var tVal ='';
		$('input[name^="TrackingNo"]').each(function() {
			tVal = $(this).val();
			if(tVal!=''){
    				TrackingNo += $(this).val()+':';
			}
		});		 
		var PostalCodeD = $("#wZipCode").val();		
		if(TrackingNo!='' && PostalCodeD!=''){
			var SendParam = 'action=GetShippingRate&track='+TrackingNo+'&PostalCodeD='+PostalCodeD;
			$("#PrepaidAmount").addClass('loaderbox');	 
			$.post("../shipping/fedexRate.php", SendParam, function(theResponse){
				$("#PrepaidAmount").val(theResponse); 
				$("#PrepaidAmount").removeClass('loaderbox');	
			});	
		}
		/****************/
		
	}else{		
		$("#PrepaidVendorTr").hide();
		$("#PrepaidAmountDiv").hide();
	}
	//calculateGrandTotal();
}

jQuery('document').ready(function(){
	 $("#PrepaidFreight,#wZipCode,#TrackingNo").change(function(){
			setPrepaidFreight();
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




function setShipTo(ProcessCal){

	var DropshipDisplay = '0';
	if(document.getElementById("OrderType").value=="Dropship"){
		$("#wCodeTitle").hide();
		$("#wCodeVal").hide();
		$("#wNameTitle").html('Customer');
                $("#showCustList").show();

		$("#SoTitle").show();	
		$("#SoVal").show();
                

		DropshipDisplay = '1';	
	}else{
		$("#wCodeTitle").show();
		$("#wCodeVal").show();
		$("#wNameTitle").html('Warehouse');	
                
		$("#SoTitle").hide();	
		$("#SoVal").hide();	
                $("#showCustList").hide();
                
                
	}

	$("table.order-list").find('input[name^="DropshipCost"]').each(function () {
		if(DropshipDisplay==1){
			$(this).show();
		}else{
			$(this).hide();
			$(this).val('0');
		}
	});


	if(ProcessCal==1){
		ProcessTotal();
	}

}
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
//alert(node);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey; 


function ResetSearchdd(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetVendorInfo(inf){
 
	if(inf == ''){
		//document.getElementById("form1").reset();

//document.getElementById("PaymentMethod").value='';
document.getElementById("PaymentTerm").value='';
document.getElementById("SuppCode").value='';
document.getElementById("SuppCompany").value='';
document.getElementById("SuppContact").value='';
document.getElementById("Address").value='';
document.getElementById("City").value='';
document.getElementById("State").value='';
document.getElementById("Country").value='';
document.getElementById("ZipCode").value='';
document.getElementById("Mobile").value='';
document.getElementById("Landline").value='';
document.getElementById("Email").value='';
document.getElementById("Currency").value='';
document.getElementById("tax_auths").value='';
document.getElementById("MainTaxRate").value='';
SetTaxable();

		return false;
	}
 
	/*var arrayOfStrings = inf.split('-');
	//alert(arrayOfStrings[0]);
 	inf = arrayOfStrings[1];*/

	ResetSearchdd();

var separator = '-';
var arrayOfStrings = inf.split(separator);

    //console.log('The original string is: "' + inf + '"');
 // console.log('The separator is: "' + separator + '"');
  //console.log('The array has ' + arrayOfStrings.length + ' elements: ' + arrayOfStrings.join(' / '));  
			//console.log(arrayOfStrings);

//alert(arrayOfStrings[0]);
var SendUrl = "&action=SupplierInfo&SuppCode="+escape(arrayOfStrings[0])+"&r="+Math.random(); 

				$.ajax({
					type: "GET",
					url: "ajax.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText) {
if(responseText["SuppID"]>0){
	//document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
	document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
	//document.getElementById("Currency").value=responseText["Currency"];
	//document.getElementById("SuppCurrency").value=responseText["Currency"];




	//alert(responseText["Currency"])
	document.getElementById("SuppCode").value=responseText["SuppCode"];
	document.getElementById("SuppCompany").value=responseText["CompanyName"];
	document.getElementById("SuppContact").value=responseText["UserName"];
	//document.getElementById("SuppCurrency").value=responseText["Currency"];
	
	document.getElementById("Address").value=responseText["Address"];
	document.getElementById("City").value=responseText["City"];
	document.getElementById("State").value=responseText["State"];
	document.getElementById("Country").value=responseText["Country"];
	document.getElementById("ZipCode").value=responseText["ZipCode"];
	document.getElementById("Mobile").value=responseText["Mobile"];
	document.getElementById("Landline").value=responseText["Landline"];
	document.getElementById("Email").value=responseText["Email"];
	//if(document.getElementById("Currency") != null){
		//document.getElementById("Currency").value=responseText["Currency"];

	//}

	if(responseText["Currency"] != null){
		document.getElementById("Currency").value=responseText["Currency"];

	}


	//alert(responseText["Taxable"]);
	document.getElementById("tax_auths").value=responseText["Taxable"];
	if(responseText["Taxable"] =='Yes' ){
	//SetTaxable(1);
		//document.getElementById("TaxRate").value=responseText["TaxRate"];
	document.getElementById("MainTaxRate").value=responseText["TaxRate"];
	SetTaxable();

//alert($("#TaxRate :selected").attr("freight_tax"));
	freightSett(responseText["TaxRate"]);
//$("#freightTxSet").val($("#TaxRate :selected").attr("freight_tax"));

	}
}else{
	document.getElementById("SuppCode").value='';
	document.getElementById("SuppCompany").value='';
	document.getElementById("SuppContact").value='';
	document.getElementById("Address").value='';
	document.getElementById("City").value='';
	document.getElementById("State").value='';
	document.getElementById("Country").value='';
	document.getElementById("ZipCode").value='';
	document.getElementById("Mobile").value='';
	document.getElementById("Landline").value='';
	document.getElementById("Email").value='';
}

        
SelectPaymentTerm();					 


					}
				});

	}





function AutoCompleteVendor(elm){
	$(elm).autocomplete({
		source: "../jsonVendor.php",
		minLength: 1
	});

}  


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






<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<input type="hidden" name="USER_LOG" id="USER_LOG" value="" />
<input type="hidden" name="USER_LOG_NEW" id="USER_LOG_NEW" value="" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 


<tr>
		 <td colspan="4" align="left" class="head"><?=VENDOR_DETAIL?> <?if($_GET['edit']>0){?><a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['edit']?>&module=Purchases<?=$module?>" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()"></a><? }?></td>
	</tr>
	<tr>
			<td  align="right"   class="blackbold" > Vendor Code  :<span class="red">*</span> </td>
			<td   align="left" >
<? if($_GET['edit']>0){ $SuppCode=$arryPurchase[0]['SuppCode'];}else{ $SuppCode =''; }?>
	<input name="SuppCode" type="text" class="textbox" style="width:90px;" autocomplete="off"  onclick="Javascript:AutoCompleteVendor(this);" onblur="SetVendorInfo(this.value);" id="SuppCode" value="<?php echo stripslashes($arryPurchase[0]['SuppCode']); ?>"    />
	<a class="fancybox fancybox.iframe" href="SupplierList.php" ><?=$search?></a>

			</td>
	 </tr>


 <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information
<? 
if(!empty($_GET['edit'])) {
	echo '<div style="float:right;">';

	if($arryPurchase[0]['Approved'] == 1){
		/*if($arryPurchase[0]['Status'] != 'Completed' && $module=='Order'){
			echo '<a href="'.$EditUrl.'&Complete='.$_GET['edit'].'" onclick="return confirmAction(this, \'Complete & Close\', \''.COMPLETE_PO.'\')" class="action_bt">Complete</a> ';
		}*/
	}else{

		if(($_SESSION['AdminType'] == 'admin' || $ApproveLabel==1) && $CancelledRejected != 1 ){
			echo '<a href="'.$EditUrl.'&Approve='.$_GET['edit'].'" onclick="return confirmAction(this, \'Approve\', \''.$ApproveMSG.'\')" class="action_bt">Approve</a> ';
			echo '<a href="'.$EditUrl.'&Cancel='.$_GET['edit'].'" onclick="return confirmAction(this, \'Cancel\', \''.$CancelMSG.'\')" class="action_bt">Cancel</a> ';
			echo '<a href="'.$EditUrl.'&Reject='.$_GET['edit'].'" onclick="return confirmAction(this, \'Reject\', \''.$RejectMSG.'\')" class="action_bt">Reject</a> ';
		}
	}

	echo '</div>';
 }
 ?>
	 </td>
</tr>
 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" width="30%">
<? if(!empty($_GET['edit'])) {?>
	<!--input name="<?=$ModuleID?>" type="text" class="disabled" readonly style="width:90px;" id="<?=$ModuleID?>" value="<?php echo stripslashes($arryPurchase[0][$ModuleID]); ?>"  maxlength="20" -->
	<input name="<?=$ModuleID?>" type="text" class="datebox"  style="width:90px;" id="<?=$ModuleID?>" value="<?php echo stripslashes($arryPurchase[0][$ModuleID]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');" />
    <span id="MsgSpan_ModuleID"></span>

<? }else{?>
	<input name="<?=$ModuleID?>" type="text" class="datebox" id="<?=$ModuleID?>" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_ModuleID"></span>
<? } ?>

</td>

	<td  align="right" class="blackbold" width="20%">Order Status  :</td>
        <td   align="left">
		<? 
		if($_GET['edit']>0){ 

		 if($OrderIsOpen == 1){
		?>
		  <select name="Status" class="textbox" id="Status" style="width:100px;">
				<? for($i=0;$i<sizeof($arryOrderStatus);$i++) {?>
					<option value="<?=$arryOrderStatus[$i]?>" <?  if($arryOrderStatus[$i]==$arryPurchase[0]['Status']){echo "selected";}?>>
					<?=$arryOrderStatus[$i]?>
					</option>
				<? } ?>
			</select> 
		<? 
		}else if($CancelledRejected==1){
			echo '<span class=red>'.$arryPurchase[0]['Status'].'</span>';
			echo '<input type="hidden" name="Status" id="Status" value="'.$arryPurchase[0]['Status'].'">';

		}else if($Completed==1){
			echo '<span class=green>'.$arryPurchase[0]['Status'].'</span>';
			echo '<input type="hidden" name="Status" id="Status" value="'.$arryPurchase[0]['Status'].'">';
		}else{ ?>
		<input type="text" class="disabled" readonly style="width:90px;" name="Status" id="Status" value="<?=$arryPurchase[0]['Status']?>" readonly />
		<? }
		
		}else{
			echo '<input type="text" class="disabled" readonly style="width:90px;" name="Status" id="Status" value="'.$arryOrderStatus[0].'">';
		}?>

		</td>


      </tr>

<? if($_GET['edit']>0){ ?>
   <tr>    
      
        <td  align="right" class="blackbold" >Created By  : </td>
        <td   align="left">
		<?
			if($arryPurchase[0]['AdminType'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryPurchase[0]['AdminID'].'" >'.stripslashes($arryPurchase[0]['CreatedBy']).'</a>';
			}
			echo $CreatedBy;
		?>
          </td>


	  <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
         <?
		  echo ($arryPurchase[0]['Approved'] == 1)?('<span class=greenmsg>Yes</span>'):('<span class=redmsg>No</span>');
		  echo '<input type="hidden" name="Approved" id="Approved" value="'.$arryPurchase[0]['Approved'].'">';
		 ?>
			
		  
		  
		  </td>
        </tr>

	<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>


<? } ?>

<tr>
        <td  align="right" class="blackbold">Order Type  :</td>
        <td   align="left">
<? if(!empty($_GET['edit'])) {?>
<input name="OrderType" id="OrderType" type="text" class="disabled" readonly style="width:90px;"  value="<?php echo $arryPurchase[0]['OrderType']; ?>"  maxlength="20" />
<? }else{?>		
<select name="OrderType" class="textbox" id="OrderType" style="width:100px;" onchange="Javascript:setShipTo(1);">
	<? for($i=0;$i<sizeof($arryOrderType);$i++) {?>
		<option value="<?=$arryOrderType[$i]['attribute_value']?>" <?  if($arryOrderType[$i]['attribute_value']==$arryPurchase[0]['OrderType']){echo "selected";}?>>
		<?=$arryOrderType[$i]['attribute_value']?>
</option>
	<? } ?>
</select> 
<? }?>	

	
	</td>
  
	<td  align="right" class="blackbold"> <div id="SoTitle">Sales Order # :</div> </td>
        <td   align="left">
<div id="SoVal">
<input name="SaleID" id="SaleID" type="text" class="disabled" value="<?=$SaleID?>" readonly style="width:90px;" maxlength="30" />
<? if(empty($_GET['edit']) || empty($SaleID)) {?>
<a class="fancybox fancybox.iframe" href="selectSO.php?o=<?=$_GET['edit']?>" ><?=$search?></a>
<? } ?>	  
</div>	  
	</td>
       
</tr>


  <tr>
        <td  align="right"   class="blackbold" >Order Date  :<span class="red">*</span> </td>
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
$OrderDate = ($arryPurchase[0]['OrderDate']>0)?($arryPurchase[0]['OrderDate']):($arryTime[0]); 
?>
<input id="OrderDate" name="OrderDate" readonly="" class="datebox" value="<?=$OrderDate?>"  type="text" > 


</td>
     
        
</tr>






<tr>

	<td  align="right"   class="blackbold" > Expected Date : </td>
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
$DeliveryDate = ($arryPurchase[0]['DeliveryDate']>0)?($arryPurchase[0]['DeliveryDate']):(''); 
?>
<input id="DeliveryDate" name="DeliveryDate" readonly="" class="datebox" value="<?=$DeliveryDate?>"  type="text" > 

</td>
</tr>


<tr>
        <td  align="right" class="blackbold">Payment Term  : </td>
        <td   align="left">
	<? if($_SESSION['AdminType'] != 'admin' && $FullAcessLabel!=1){ ?>
		<input type="text" name="PaymentTerm" id="PaymentTerm" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arryPurchase[0]['PaymentTerm'])?>">
	<? }else{ ?>
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						if($arryPaymentTerm[$i]['termType']==1){
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
						}else{
							$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
						}
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryPurchase[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select>
		
 	<? } ?>
		</td>

       
</tr>



<tr id="BankAccountTR">
		<td  align="right" class="blackbold">Bank Account :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
		
	<select name="BankAccount" class="inputbox" id="BankAccount" >
		<option value="">--- Select ---</option>
		<? 
		for($i=0;$i<sizeof($arryBankAccount);$i++) {
		$selected='';
		if($_GET['edit']>0){ 		 
			if($arryBankAccount[$i]['BankAccountID']==$arryPurchase[0]['AccountID']) $selected='Selected'; 
		}else if($arryBankAccount[$i]['DefaultAccount']==1){
			$selected='Selected';
		}

		?>
		<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?=$selected?>>
		<?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
		<? } ?>
	</select> 

		</td>
</tr>


<tr id="CreditCardVendorTR">
		<td  align="right" class="blackbold">Credit Card Vendor :</td>
		<td  align="left" class="blacknormal">
		
	<select name="CreditCardVendor" class="inputbox" id="CreditCardVendor" >
		 <option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryCreditCardVendor);$i++) {     ?>
			 <option value="<?=$arryCreditCardVendor[$i]['SuppCode']?>" <?php if($arryPurchase[0]['CreditCardVendor'] == $arryCreditCardVendor[$i]['SuppCode']){echo "selected";}?>>
			 <?=stripslashes($arryCreditCardVendor[$i]["VendorName"])?></option>
				<? } ?>
	</select> 
<script>
$("#CreditCardVendor").select2();
</script> 
		</td>
</tr>


<!--tr>

 <td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryPurchase[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
	</tr-->




	<tr>
        <td  align="right" class="blackbold">Shipping Carrier  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod" onchange="Javascript:shipCarrier();">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryPurchase[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>

	
</tr>
<tr id="spmethod" style="display:none;">
	<td align="right" class="blackbold">Shipping Method : </td>
	<td align="left">
	<select name="ShippingMethodVal" class="inputbox" id="ShippingMethodVal">
	</select>
	<input type="hidden" name="spval" id="spval" value="<?=$arryPurchase[0]['ShippingMethodVal'];?>">

	</td>
</tr>

<script>

	$(document).on('keyup', '.track', function(){
		//$(this).closest('td').parent('tr').find('span,a').remove();
		//$new = $(this).val().replace(/[^0-9]/g, '');
            	//$(this).val($new);
		var clostd = $(this).closest('td');
		
	

		
			if($.trim(clostd.parent('tr').find('.track').val()) != '')
			{	
				//$('<a href="javascript:;" class="add_row_po" id="addmore">Add More</a>').insertAfter('#TrackingNo');
				//$('#prpercent').show().insertAfter('#TrackingNo');
				
			}
				
	})


$(document).on('click', '.rangDel', function(){ 
	if($(this).closest('td').parent('tr').find('.add_row_po').length) {
		//$(this).closest('td').parent('tr').prev('tr').find('.qtyto').closest('td').append('<a href="javascript:;" class="add_row_po" id="addmore">Add More</a>');
	}
	$(this).closest('td').parent('tr').remove(); 
})

function addMoreRangePr(thisobj)
{	
		$('.TrackingRange:first').clone().attr('id','TrackingRange'+$('.TrackingRange').length).insertAfter($('.TrackingRange:last')).find('td:last').append('<img src="../images/delete-161.png" class="rangDel" style="cursor:pointer">');
		$('.TrackingRange:last a').remove();
		$('.TrackingRange:last').find(':input').val('');
		//$('.TrackingRange:last .prpercent').show();
}
$(document).on('click','.add_row_po', function(){	addMoreRangePr($(this));	});
</script>

<?php  

$TrackingNo	= explode(':',$arryPurchase[0]['TrackingNo']);	
		$count 		= count($TrackingNo);
		for($i=0;$i<$count;$i++){

?>


<tr id='TrackingRange' class="TrackingRange" >
<td  align="right"   class="blackbold" > Tracking #  : </td>
	<td   align="left" >
	<input name="TrackingNo[]" type="text" class="inputbox track" id="TrackingNo" value="<?php echo stripslashes($TrackingNo[$i]); ?>"  maxlength="100" />     <? if($i==0){?>		<a href="javascript:;" class="add_row_po" id="addmore">Add More</a> <?}?> <? if($i>=1){?> <img src="../images/delete-161.png" class="rangDel" style="cursor:pointer"> <? }?>    
	</td>
</tr>
<? }?>
<!--<tr>
<td  align="right"   class="blackbold" > Tracking #  : </td>
	<td   align="left" >
	<input name="TrackingNo" type="text" class="inputbox" id="TrackingNo" value="<?php echo stripslashes($arryPurchase[0]['TrackingNo']); ?>"  maxlength="100" />          
	</td>
</tr>-->

<tr>
        <!--td  align="right" class="blackbold">Assigned To  : </td>
        <td   align="left">

<input name="EmpName" id="EmpName" type="text" class="disabled" style="width:250px;" value="<?=$arryPurchase[0]['AssignedEmp']?>" readonly />
<input name="EmpID" id="EmpID" type="hidden" class="disabled" value="<?=$arryPurchase[0]['AssignedEmpID']?>"  maxlength="20" readonly />
<input name="OldEmpID" id="OldEmpID" type="hidden" class="disabled" value="<?=$arryPurchase[0]['AssignedEmpID']?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="EmpList.php?dv=4" ><?=$search?></a>	  
		  
	</td-->

	<td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<!-- <input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arryPurchase[0]['Comment']); ?>"  maxlength="100" /> -->
	<?php 
 		$MultiComment = @explode("##",$arryPurchase[0]['Comment']); 
 		
 		if(empty($MultiComment[1]) && !empty($MultiComment[0])){ ?>
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arryPurchase[0]['Comment']); ?>"  maxlength="100" />
	<?php }else{ 
 			$module_type = 'purchases';
 			$arrComments = $arryPurchase[0]['Comment'];
 			include("../includes/html/box/PO_SO_Comments.php"); ?>
 			<input type="hidden" name="Comment" id="Comment" value="<?php echo stripslashes($arryPurchase[0]['Comment']); ?>"/>	
 		<?php } ?>
	</td>
</tr>




<tr>
        <td  align="right" class="blackbold">Prepaid Freight :</td>
        <td   align="left">		
<select name="PrepaidFreight" class="textbox" id="PrepaidFreight" style="width:100px;" >	
	<option value="0" <?  if($arryPurchase[0]['PrepaidFreight']==0){echo "selected";}?>>No</option>	
	<option value="1" <?  if($arryPurchase[0]['PrepaidFreight']==1){echo "selected";}?>>Yes</option>
</select> 	
	</td>
 </tr>


<tr id="PrepaidVendorTr" <?  if($arryPurchase[0]['PrepaidFreight']!=1){echo 'style="display:none"';}?>>
        <td  align="right" class="blackbold">Vendor :<span class="red">*</span></td>
        <td   align="left">		
	<select name="PrepaidVendor" class="inputbox" id="PrepaidVendor" >
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryVendor);$i++) {     ?>
			 <option value="<?=$arryVendor[$i]['SuppCode']?>" <?php if($arryPurchase[0]['PrepaidVendor'] == $arryVendor[$i]['SuppCode']){echo "selected";}?>>
			 <?=stripslashes($arryVendor[$i]["VendorName"])?></option>
				<? } ?>
		</select> 
	</td>
 </tr>

	<script>
$("#PrepaidVendor").select2();
</script> 



<tr>

<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<?
 
if(empty($arryPurchase[0]['Currency']))$arryPurchase[0]['Currency']= $Config['Currency'];

unset($arrySelCurrency);
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryPurchase[0]['Currency']) && !in_array($arryPurchase[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryPurchase[0]['Currency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);

?>
<select name="Currency" class="inputbox" id="Currency">
<!--option value="<?=$Config['Currency']?>" <?  if($Config['Currency']==$arryPurchase[0]['Currency']){echo "selected";}?>>
	<?=$Config['Currency']?></option-->
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryPurchase[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>

      </tr>

</table>

</td>
   </tr>

  

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"   >
		<tr>
			<td align="left" valign="top" width="50%"  class="borderpo"><? include("includes/html/box/po_supp_form.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top"  class="borderpo"><? include("includes/html/box/po_warehouse_form.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
			 <td align="right">
		<?
		
		$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
		 $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
		?>	 
			 </td>
		</tr>

<tr>
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" ><?=LINE_ITEM?></td>
		</tr>
		<tr>
			<td align="left" >
		<?php if ($_SESSION['SelectOneItem']=='1'){	
					include("includes/html/box/po_item_subform.php"); 
		}else { 
					include("includes/html/box/po_item_form.php");
		}?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($HideSubmit != 1){ ?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="Module" id="Module" value="<?=$module?>" />

<input type="hidden" name="ModuleID" id="ModuleID" value="<?=$ModuleID?>" />
<input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />
<input type="hidden" name="comType" id="comType" value="<?=$_SESSION['SelectOneItem']?>" />

<input name="Taxable" id="Taxable" type="hidden" value="<?=stripslashes($arryPurchase[0]['Taxable'])?>">
<? if($TracInv!=''){
echo $TracInv;
}else{
echo '<input id="TracInv" type="hidden" value="0" name="TracInv">';

}?>
	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<? } ?>

<script language="JavaScript1.2" type="text/javascript">
setShipTo();
shipCarrier();

function SelectPaymentTerm(){
	var PaymentTerm = $("#PaymentTerm").val().toLowerCase();;
 
	/**********************/
	if(PaymentTerm == 'prepayment'){
		 $("#BankAccountTR").show();
		 $("#CreditCardVendorTR").hide();
	}else if(PaymentTerm == 'credit card'){
		$("#CreditCardVendorTR").show();
		$("#BankAccountTR").hide();
	}else{
		 $("#BankAccountTR").hide();	
		 $("#CreditCardVendorTR").hide();  
	}
	
}



jQuery('document').ready(function(){
   jQuery('#PaymentTerm').change(function(){
           SelectPaymentTerm();	
	});
})

SelectPaymentTerm();
</script>

