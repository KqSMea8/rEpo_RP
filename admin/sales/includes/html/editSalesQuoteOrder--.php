<?
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$OrderSourceFlag = 1;
		$MandForEcomm = '<span class="red">*</span>';
	}
}

?>
<a href="<?=$RedirectURL?>" class="back">Back</a>





<? 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);
if($arrySale[0]["OrderType"] != '') $OrderType = $arrySale[0]["OrderType"]; else $OrderType = 'Standard';

if(!empty($_GET['edit'])){
            $total_received = $objSale->GetQtyInvoicedCheck($_GET['edit']);
			$total_ordered = $total_received[0]['Qty'];
			$total_invoiced = $total_received[0]['QtyInvoiced'];
		}
		 
 

	if($arrySale[0]['Approved'] == 1 && $arrySale[0]['Status'] == 'Open'){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_SALE_ORDER.'</a>';
			include("includes/html/box/convert_form.php");
		}else if($module=='Order' && $total_ordered != $total_invoiced && $OrderType == 'Standard'){ 
			#echo '<a class="edit" href="../finance/generateInvoice.php?so='.$arrySale[0]['SaleID'].'&invoice='.$arrySale[0]['OrderID'].'" target="_blank">'.GENERATE_INVOICE.'</a>';
				//include("includes/html/box/generate_invoice_form.php");
		}
	} 


	/*if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="../finance/viewInvoice.php?po='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}*/


 
	if($arrySale[0]['RecurringOption'] != "Yes"){
		if($module=='Order' &&  $arrySale[0]['Approved'] == 1 && $CreditCardFlag==1 && !empty($ProviderName)){	
	 		 echo '<div style="float:right">';
			 if($CardProcessed==1 && $CardVoided!=1 && !empty($VoidCardUrl)){						
				echo '<a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card'.$ButtonVoidTxt.'</a>';			
			
			}else if($InvoiceSpend<=0){
				echo '<a href="'.$AuthorizeCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Authorize Credit Card\', \''.AUTH_CARD.'\')" >Authorize Credit Card</a>';

			
			}
			echo '</div>';
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

function AutoCompleteCustomer(elm){
	$(elm).autocomplete({
		source: "../jsonCustomer.php",
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.hold==1){
					 event.preventDefault();
					 jQuery('#CustomerName').val('');
					alert('This customer on hold');
					
					
					//return false;
					//
					}
		}
		
	}).data("ui-autocomplete")
	._renderItem = function(ul, item) {
		console.log(item);
		var classitem='';
		classitem=(item.hold==1)?'customer-search-hold':'';
	    var listItem = $("<li class='"+classitem+"'></li>")
	        .data("item.autocomplete", item)
	        .append( item.label)
	        .appendTo(ul);

	    if (item.personal) {
	        listItem.addClass("personal");
	    }

	    return listItem;
	};;

}  


//function detele file by sachin

function DeleteFileStorage(file_path,file_div,orderid){
  //var Url = "ajax.php?action=delete_file&file_path="+escape(file_path)+"&r="+Math.random(); 

	$("#dialog-modal").html("Are you sure you want to delete this file?");
    $("#dialog-modal").dialog(
    {
        title: "Remove File",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				//alert('ghjkyy');
				$(this).dialog("close");
				var SendParam = "action=delete_file_Storage&file_path="+escape(file_path)+"&orderid="+orderid+"&r="+Math.random(); 
		    var IsExist = 0;
		    $.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) { 
				if(responseText==1) {
				   $("#IdProofDiv").hide();	
				   document.getElementById("filecheck").removeAttribute("checked");				
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
				 
				 //ShowHideLoader(1,'P');



			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });	
}

$(document).on('click','#filecheck',function(){
        if($(this).prop("checked") == true){
            $("#showfile").show();

                // alert("Checkbox is checked.");

            }
              else if($(this).prop("checked") == false){
                $("#showfile").hide();
            }

        });
window.onload = function () { 
var filecheckval=Trim(document.getElementById("filecheck")).value;
if(filecheckval==1){

document.getElementById("filecheck").setAttribute("checked", "checked"); 
	//alert('ss');
}
	else{
		document.getElementById("filecheck").removeAttribute("checked"); 
		
	}
	

}
        

//function detele file by sachin

function validateForm(frm){

	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}

	/***added code by sachin*/
	if(!ValidateOptionalDoc(frm.FileName, "FileName")){
			return false;
		}
	/***added code by sachin*/

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
		if(document.getElementById("PaymentMethod") != null){
			if(!ValidateForSelect(frm.PaymentMethod, "Payment Method")){        
			    return false;
			}
		}
	}

	var PaymentTerm = $("#PaymentTerm").val().toLowerCase();;
	if(PaymentTerm == 'prepayment'){
		if(!ValidateForSelect(frm.BankAccount, "Bank Account")){        
		    return false;
		}
	}

	/*if(   ValidateForSelect(frm.OrderDate, "Order Date") 
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
	){*/

if(document.getElementById("PaymentTerm").value != 'PayPal'){
		if(!ValidateForSimpleBlank(frm.Address, "Address")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.City, "City")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.State, "State")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.Country, "Country")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.ZipCode, "Zip Code")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.ShippingAddress, "Shipping Address")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.ShippingCity, "Shipping City")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.ShippingState, "Shipping State")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.ShippingCountry, "Shipping Country")){        
			return false;
		}
		if(!ValidateForSimpleBlank(frm.ShippingZipCode, "Shipping ZipCode")){        
			return false;
		}
if(!isEmailOpt(frm.ShippingEmail)){        
			return false;
		}
if(!isEmailOpt(frm.Email)){

return false;
}
	}else if(document.getElementById("PaymentTerm").value == 'PayPal' && document.getElementById("paypalemail").value==''){
				alert('Please enter paypal email');
				return false;
		} 
		
		for(var i=1;i<=NumLine;i++){
		 
		//if(document.getElementById("sku"+i).value == ""){
				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
					return false;
				}

var ClsName = document.getElementById("Condition"+i).className;
var rescls = ClsName.split(" "); 
//alert(rescls);
if(document.getElementById("comType").value != 1 && rescls[1]!='disabled' ){

if(document.getElementById("Condition"+i).value == ""){
			if(!ValidateForSelect(document.getElementById("Condition"+i), "Condition")){
					return false;
				}
}

}
/*if(document.getElementById("comType").value != 1){

if(document.getElementById("on_hand_qty"+i).value < document.getElementById("qty"+i).value){
 alert("Quantity Should be Less Than or equal to On hand Quantity");
document.getElementById("qty"+i).focus();
return false;
}

}*/


//return false;
				if(!ValidateForSimpleBlank(document.getElementById("description"+i), "Item Description")){
					return false;
				}
				if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}	
		//	}
		 
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

	/*}else{
		return false;	
	}	*/
		
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




// Get the <datalist> and <input> elements.
var dataList = document.getElementById('json-datalist');
var input = document.getElementById('CustomerName');

// Create a new XMLHttpRequest.
var request = new XMLHttpRequest();

// Handle state changes for the request.
// Handle state changes for the request.
request.onreadystatechange = function(response) {
  if (request.readyState === 4) {
    if (request.status === 200) {
      // Parse the JSON
      var jsonOptions = JSON.parse(request.responseText);

      // Loop over the JSON array.
      jsonOptions.forEach(function(item) {
        // Create a new <option> element.
        var option = document.createElement('option');
        // Set the value using the item in the JSON array.
        option.value = item;
        // Add the <option> element to the <datalist>.
        dataList.appendChild(option);
      });

      // Update the placeholder text.
      input.placeholder = "e.g. datalist";
    } else {
      // An error occured :(
      input.placeholder = "Couldn't load datalist options :(";
    }
  }
};

// Update the placeholder text.
input.placeholder = "Loading options...";

// Set up and make the request.
request.open('GET', 'html-elements.json', true);
request.send();


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
function ResetSearchdd(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetCustInfo(inf){
 
	if(inf == ''){
		document.getElementById("form1").reset();
		return false;
	}
 
	/*var arrayOfStrings = inf.split('-');
	//alert(arrayOfStrings[0]);
 	inf = arrayOfStrings[1];*/

	ResetSearchdd();
	document.getElementById("CustomerCompany").value='';
	document.getElementById("CustomerName").value='';
 	document.getElementById("Taxable").value='';
	document.getElementById("Address").value='';
	document.getElementById("City").value='';
	document.getElementById("State").value='';
	document.getElementById("Country").value='';
	document.getElementById("ZipCode").value='';
	document.getElementById("Mobile").value='';
	document.getElementById("Landline").value='';
	document.getElementById("Fax").value='';
	document.getElementById("Email").value='';
	
	document.getElementById("ShippingCompany").value='';
	document.getElementById("ShippingName").value='';
	document.getElementById("ShippingAddress").value='';
	document.getElementById("ShippingCity").value='';
	document.getElementById("ShippingState").value='';
	document.getElementById("ShippingCountry").value='';
	document.getElementById("ShippingZipCode").value='';
	document.getElementById("ShippingMobile").value='';
	document.getElementById("ShippingLandline").value='';
	document.getElementById("ShippingFax").value='';
	document.getElementById("ShippingEmail").value='';	        
			
var SendUrl = "&action=CustomerName&CustName="+escape(inf)+"&r="+Math.random();
	//var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();
 

   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText) {
		//alert(responseText["Cid"]);
		document.getElementById("CustCode").value=responseText["CustCode"];
		document.getElementById("CustID").value=responseText["Cid"];
var CustId = responseText["Cid"];
		document.getElementById("CustomerName").value=responseText["CustomerName"];

document.getElementById("tax_auths").value=responseText["Taxable"];
if(responseText["Taxable"] =='Yes' ){
//SetTaxable(1);
	//document.getElementById("TaxRate").value=responseText["TaxRate"];
document.getElementById("MainTaxRate").value=responseText["c_taxRate"];
SetTaxable();
freightSett(responseText["c_taxRate"]);

}


		//document.getElementById("tax_auths").value=responseText["Taxable"];

        if(responseText["MDType"]){
		  if(responseText["MDType"] == 'Discount'){
                        
			document.getElementById("CustDisType").value=responseText["DiscountType"];
			document.getElementById("MDAmount").value=responseText["MDAmount"];
			document.getElementById("MDType").value=responseText["MDType"];
      document.getElementById("MDiscount").value=responseText["MDiscount"];


		}else{

				document.getElementById("CustDisType").value='Percentage';
				document.getElementById("MDAmount").value=responseText["MDAmount"];
				document.getElementById("MDType").value=responseText["MDType"];
				document.getElementById("MDiscount").value=responseText["MDiscount"];
		}


	}else{
				document.getElementById("CustDisType").value='';
				document.getElementById("MDAmount").value='';
				document.getElementById("MDType").value='';
				document.getElementById("MDiscount").value='';
	}
		
		if(responseText["SalesPerson"]){
			document.getElementById("SalesPerson").value=responseText["SalesPerson"];
			document.getElementById("SalesPersonID").value=responseText["SalesPersonID"];
			document.getElementById("OldSalesPersonID").value=responseText["SalesPersonID"];
		}else{
			document.getElementById("SalesPerson").value='';
			document.getElementById("SalesPersonID").value='';
			document.getElementById("OldSalesPersonID").value='';
			
		}
		

		//Order Quote
		//if(creditnote == ""){
		document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
		//document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
		document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
		//}
		
	
	document.getElementById("CustomerCompany").value=responseText["CustomerCompany"];
	document.getElementById("BillingName").value=responseText["Name"];
	document.getElementById("Address").value=responseText["Address"];
	document.getElementById("City").value=responseText["CityName"];
	document.getElementById("State").value=responseText["StateName"];
	document.getElementById("Country").value=responseText["CountryName"];
	document.getElementById("ZipCode").value=responseText["ZipCode"];
	document.getElementById("Mobile").value=responseText["Mobile"];
	document.getElementById("Landline").value=responseText["Landline"];
	document.getElementById("Fax").value=responseText["Fax"];
	document.getElementById("Email").value=responseText["Email"];	
	document.getElementById("ShippingCompany").value=responseText["CustomerCompany"];
	document.getElementById("ShippingName").value=responseText["sName"];
	document.getElementById("ShippingAddress").value=responseText["sAddress"];
	document.getElementById("ShippingCity").value=responseText["sCityName"];
	document.getElementById("ShippingState").value=responseText["sStateName"];
	document.getElementById("ShippingCountry").value=responseText["sCountryName"];
	document.getElementById("ShippingZipCode").value=responseText["sZipCode"];
	document.getElementById("ShippingMobile").value=responseText["sMobile"];
	document.getElementById("ShippingLandline").value=responseText["sLandline"];
	document.getElementById("ShippingFax").value=responseText["sFax"];
	document.getElementById("ShippingEmail").value=responseText["sEmail"];
	if(document.getElementById("CustomerCurrency") != null){
		document.getElementById("CustomerCurrency").value=responseText["Currency"];
	}

	if(document.getElementById("OrderSource") != null){
		document.getElementById("OrderSource").value=responseText["OrderSource"];
	}


	if(document.getElementById("paypalemailSearch") != null){
			document.getElementById("paypalemailSearch").setAttribute("href", "paypalemail.php?cid="+CustId);
	}
	if(document.getElementById("paypa-email-tr")!= null && ! document.getElementById("paypalemailSearch")){
		var hh='<a href="paypalemail.php?cid='+CustId+'" class="fancybox fancybox.iframe" id="paypalemailSearch"><img src="../images/search.png"></a>';

		document.getElementById("paypal-email-input-td").appendChild(hh);

		//document.getElementById("paypalemail").insertAfter(hh);
	}










	/***/
	if(document.getElementById("contact_link") != null){
		document.getElementById("ContactDiv").innerHTML='';	
		document.getElementById("SpiffContact").value='';	
		var contact_link = document.getElementById("contact_link");
		contact_link.setAttribute("href", 'CustomerContact.php?CustID='+CustId);
	}
	/***/
 
	if(document.getElementById("shipTD") != null){
		document.getElementById("shipTR").style.display = "";
		document.getElementById("shipTD").innerHTML =responseText["shipList"]; 
	}



	SetTaxable();
freightSett(responseText["c_taxRate"]);
	ProcessTotal();
	shipCarrier();
	SelectCreditCard();
calculateGrandTotal();
	/************************************/
	

		   
	}

   });
				


}


/*********************** added by sanjiv ******************************/
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

		  var startItems = convertSerializedArrayToHash( $('#form1 [type!="hidden"]').serializeArray() ); 
		  $('#form1').submit(function () {
		    var currentItems = convertSerializedArrayToHash($('#form1 [type!="hidden"]').serializeArray());
		    var itemsToSubmit = hashDiff( startItems, currentItems);
		    var NewItemsToSubmit = hashDiff( currentItems, startItems);
				$("#USER_LOG").val(JSON.stringify(itemsToSubmit));
				$("#USER_LOG_NEW").val(JSON.stringify(NewItemsToSubmit));
		  });
		});
/************************* End ****************************/





</script>



<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<input type="hidden" name="USER_LOG" id="USER_LOG" value="" />
<input type="hidden" name="USER_LOG_NEW" id="USER_LOG_NEW" value="" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Customer 
	<?if($_GET['edit']>0){?> <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['edit']?>&module=Sales<?=$module?>" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a> <? }?>
	 </td>
</tr>
 
  <tr>
   <tr>
	<td  align="right"   class="blackbold" > Customer :<span class="red">*</span> </td>
	<td   align="left" >
<!-- list="json-datalist" -->


<? if($TransactionExist==1){ ?>
	<input name="CustomerName" type="text"  class="disabled_inputbox" readonly id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>"   maxlength="60"  autocomplete="off"  />
<? }else{ ?>
<input name="CustomerName" type="text"  class="inputbox"  id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>" onblur="SetCustInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCustomer(this);"/>
<a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>
<? } ?>

		<input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustCode']); ?>">
		<input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>">
	<input name="Taxable" id="Taxable" type="hidden" value="<?php echo stripslashes($arrySale[0]['Taxable']); ?>">

	

<!--datalist id="json-datalist">
  <?php //foreach($arryCustomer as $customer){?>
					<option value="<?=$customer['FullName'];?>-<?=$customer['CustCode'];?>"><?=$customer['FullName'];?></option>
					<?php //}?>  
</datalist-->


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



	<? if($TransactionExist==1){ ?>
	<input name="<?=$ModuleID?>" type="text" class="disabled_inputbox" readonly id="<?=$ModuleID?>" value="<?php echo stripslashes($arrySale[0][$ModuleID]); ?>"  maxlength="20"   /> 
	<? }else{?>
	<input name="<?=$ModuleID?>" type="text" class="datebox" id="<?=$ModuleID?>" value="<?php echo stripslashes($arrySale[0][$ModuleID]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');"  />	 
	<? } ?>
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
                         echo ($arrySale[0]['Approved'] == 1)?('<span class=green><b>Yes</b></span>'):('<span class=red><b>No</b></span>');
                         echo '<input type="hidden" name="Approved" id="Approved" value="'.$arrySale[0]['Approved'].'">';
						
                 }?>
                       
                 
                 
                 </td>
     </tr>
<? } ?>

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
		<? if($TransactionExist==1 || ($_SESSION['AdminType'] != 'admin' && $FullAcessLabel!=1)){ ?>
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
		
		<? } ?>

		<select name="SelectCard" class="textbox" id="SelectCard"  style="display:none;">
		  	<option value="">--- Select ---</option>
			<option value="New">New Card</option>
			<option value="Existing">Existing</option>	 	 
		</select> 

		</td>

		<!--td  align="right" class="blackbold">Payment Method  :<?=$MandForEcomm?></td>
                 <td align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<?php for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
                                    <option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arrySale[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
                                    </option>
			<? } ?>
		</select> 
		</td-->

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
			if($arryBankAccount[$i]['BankAccountID']==$arrySale[0]['AccountID']) $selected='Selected'; 
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



 <tr id="RecurringTR" >
	<td align="right">Recurring Option :</td>
	<td>

<? if($TransactionExist==1){ 
	echo ($arrySale[0]['RecurringOption']=="Yes")?("<span class=green><b>Yes</b></span>"):("<span class=red><b>No</b></span>");
	$HideRecurring = 'style="display:none"';
   }

?>

<label <?=$HideRecurring?>><input name="RecurringOption" type="radio" id="RecurringOption1" value="Yes" <?=($arrySale[0]['RecurringOption']=="Yes")?("checked"):("")?>/>&nbsp;Yes</label>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<label <?=$HideRecurring?>><input name="RecurringOption" type="radio" id="RecurringOption2" value="No" <?=($arrySale[0]['RecurringOption']!="Yes")?("checked"):("")?> />&nbsp;No </label>



</td>

</td>
</tr>

 <tr id="RecurringDateTR">
	<td  align="right"   class="blackbold"  > Recurring Start Date  : </td>
        <td   align="left" >

<? 
list($year, $month, $day) = explode("-",$arryTime[0]);
$TempDate  = mktime(0, 0, 0, $month , $day+1, $year);	
$Tomorrow = date("Y-m-d",$TempDate);

$RecurringDate = ($arrySale[0]['RecurringDate']>0)?($arrySale[0]['RecurringDate']):($Tomorrow); 


if($TransactionExist==1){ ?>		 
<input id="RecurringDate" name="RecurringDate" readonly="" class="disabled_inputbox" value="<?=$RecurringDate?>"  type="text" > 
<? }else{ ?>

<script type="text/javascript">
$(function() {
	$('#RecurringDate').datepicker(
		{
		showOn: "both",
		minDate: "+1D", 
		yearRange: '<?=date("Y")?>:<?=date("Y")+5?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="RecurringDate" name="RecurringDate" readonly="" class="datebox" value="<?=$RecurringDate?>"  type="text" > 
<? } ?>

</td>
</tr>


 <tr id="RecurringBillTR">
<td align="right">Billing Period:</td>

<td align="left">

<? if($TransactionExist==1){ ?>		 
<input id="BillingPeriod" name="BillingPeriod" readonly="" class="disabled" size="8" value="<?=$arrySale[0]['BillingPeriod']?>"  type="text" > 
<? }else{ ?>
<select name="BillingPeriod"  id="BillingPeriod"  class="textbox">
		<option value="Day" <?=($arrySale[0]['BillingPeriod']=="Day")?("selected"):("")?>>Day</option>
		<option value="Week" <?=($arrySale[0]['BillingPeriod']=="Week")?("selected"):("")?>>Week</option>
		<!--option value="SemiMonth" <?=($arrySale[0]['BillingPeriod']=="SemiMonth")?("selected"):("")?>>Semi Month</option-->
		<option value="Month" <?=($arrySale[0]['BillingPeriod']=="Month")?("selected"):("")?>>Month</option>
		<option value="Year" <?=($arrySale[0]['BillingPeriod']=="Year")?("selected"):("")?>>Year</option>
	</select>
<? } ?>

</td>

 <td align="right">Billing Frequency:</td>

<td align="left">
<? if($TransactionExist==1){ ?>		 
<input id="BillingFrequency" name="BillingFrequency" readonly="" class="disabled" size="8" value="<?=$arrySale[0]['BillingFrequency']?>"  type="text" onkeypress="return isNumberKey(event);" > 
<? }else{ ?>
<input size="6" class="textbox" type="text" name="BillingFrequency" id="BillingFrequency" maxlength="10"   value="<?=stripslashes($arrySale[0]['BillingFrequency'])?>" onkeypress="return isNumberKey(event);" ></td>
 <? } ?>

</tr>














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
<?php 
		
 		$MultiComment = explode("##",$arrySale[0]['Comment']); 
 		
 		if(empty($MultiComment[1]) && !empty($MultiComment[0])){ ?>
 			 <textarea name="Comment" class="inputbox" id="Comment" style="width:200px;hieght:100px;"><?php echo stripslashes($arrySale[0]['Comment']); ?></textarea>
 		<?php }else{ 
 			$module_type = 'sales';
 			$arrComments = $arrySale[0]['Comment'];
 			include("../includes/html/box/PO_SO_Comments.php"); ?>
 			<input type="hidden" name="Comment" id="Comment" value="<?php echo stripslashes($arrySale[0]['Comment']); ?>"/>	
 		<?php }	?>
<!--<textarea name="Comment" class="inputbox" id="Comment" style="width:200px;hieght:100px;"><?php echo stripslashes($arrySale[0]['Comment']); ?></textarea>
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arrySale[0]['Comment']); ?>"  maxlength="100" /-->          
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


	<td  align="right"   class="blackbold" > Tracking #  : </td>
	<td   align="left" >
	<input name="TrackingNo" type="text" class="inputbox" id="TrackingNo" value="<?php echo stripslashes($arrySale[0]['TrackingNo']); ?>"  maxlength="50" />          
	</td>


<td  align="right"   class="blackbold" > Shipping Account  : </td>
	<td   align="left" >
	<input name="ShipAccount" type="text" class="inputbox" id="ShipAccount" value="<?php echo stripslashes($arrySale[0]['ShipAccount']); ?>"  maxlength="50" />          
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

if(empty($arrySale[0]['CustomerCurrency']))$arrySale[0]['CustomerCurrency']= $Config['Currency'];

unset($arrySelCurrency);
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);
 

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
<!--Start code by sachin-->
<?php 

$dwnPath='';
$checkval='';
$Showfile='display:none;';
$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
    if(!empty($arrySale[0]['FileName']) && file_exists($MainDir.$arrySale[0]['FileName'])){
    	$dwnPath="http://" . $_SERVER['HTTP_HOST'] . "/erp/admin/sales/upload/Document/".$_SESSION['CmpID']."/".stripslashes($arrySale[0]['FileName']);	
    	$Showfile='';
    	$checkval="1";
    }

?>
<tr>
	<td  align="right"   class="blackbold"></td>
	<td   align="left">
		<div style="<?=$Showfile?>" id="showfile">
			<input type="file" style="margin-top:5px;" name="FileName" id="FileName" />

	<?php
	
    if(!empty($dwnPath)){
    	    	
    	   echo '<br/><div id="IdProofDiv">'.stripslashes($arrySale[0]['FileName']).'&nbsp;<a href="'.$dwnPath.'" target="_blank" style="margin-top: 5px; display: inline-block;" class="download">Download File</a>';?>
    	   
    	   <a href="Javascript:void(0);" style="margin-left: 5px;" onclick="Javascript:DeleteFileStorage('<?=$MainDir.stripslashes($arrySale[0]['FileName'])?>','IdProofDiv','<?=$_GET['edit']?>')"><?=$delete?></a></div>			
					<?php }
	?>
	<input type="hidden" name="OldFile" value="<?php echo stripslashes($arrySale[0]['FileName']); ?>">    

		</div>

	</td>
	<td  align="right"   class="blackbold">Upload Document: </td>
	<td   align="left">
		<input style="margin-top: 5px;" class="checkbox"  type="checkbox" id="filecheck" name="filecheck" value="<?=$checkval?>" />
	</td>
	</tr>   
<!--End code by sachin-->


 

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




  
  <? if($arrySale[0]['Status'] == '' || $arrySale[0]['Status'] == 'Open'){ 

	  if($HideSubmit != 1){ 
?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton"  value=" <?=$ButtonTitle?> "  />


 
<input type="hidden" name="TransactionAmount" id="TransactionAmount" class="inputbox" readonly value="<?=$CreditCardBalance?>" /> 

<input type="hidden" name="ChargeRefund" id="ChargeRefund" class="inputbox" readonly value="0" /> 
 
<input type="hidden" name="PayPalPaid" id="PayPalPaid" class="inputbox" readonly value="<?=$PayPalPaid?>" /> 

		<input type="hidden" name="OrderID" id="OrderID" readonly value="<?=$_GET['edit']?>" />

		<input type="hidden" name="Module" id="Module" value="<?=$module?>" />
<input type="hidden" name="comType" id="comType" value="<?=$_SESSION['SelectOneItem']?>" />

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

function SetForDisableDropship(){	
	$("#form1 :input").not('#SubmitButton').not('.formactive').not('#CustCode').not('#OrderID').not('#PayPalPaid').attr("disabled", true);
	$("#form1 :input").not('#SubmitButton').not('.formactive').not('#CustCode').not('#OrderID').not('#PayPalPaid').attr("class", "disabled");

	$("#form1 img, #form1 a").remove();
}


function SetRecurringOption(){	 	 
	 if($('#RecurringOption1').is(':checked')) { 
		$("#RecurringDateTR").show(500);
		$("#RecurringBillTR").show(500); 
	}else{
		$("#RecurringDateTR").hide(500);
		$("#RecurringBillTR").hide(500);
	}
}


function SelectCreditCard(){
	var PaymentTerm = $("#PaymentTerm").val().toLowerCase();;
	
	$("#RecurringTR").hide();
	$("#RecurringDateTR").hide();
	$("#RecurringBillTR").hide();
	
	/**********************/
	if(PaymentTerm == 'credit card'){  
		$("#SelectCard").show(); 
		//$("#RecurringTR").show();
		//SetRecurringOption();
		if($("#CreditCardNumber").val()!='' && $("#CreditCardType").val()!=''){
			$("#CreditCardInfo").show(); 			
		}else{
			$("#CreditCardInfo").hide();  
		}
	}else{
		$("#SelectCard").hide();
		$("#CreditCardInfo").hide();  
	}
	/**********************/
	if(PaymentTerm == 'prepayment'){
		 $("#BankAccountTR").show();	
	}else{
		 $("#BankAccountTR").hide();	  
	}
	
}


jQuery('document').ready(function(){
	$('#RecurringOption1').click(function(){
		SetRecurringOption();
	});
	$('#RecurringOption2').click(function(){
		SetRecurringOption();
	});


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
			jQuery("#mand_ship_add").hide();
				jQuery("#mand_ship_city").hide();
				jQuery("#mand_ship_state").hide();
				jQuery("#mand_ship_code").hide();
				jQuery("#mand_ship_country").hide();

				jQuery("#mand_bill_add").hide();
				jQuery("#mand_bill_city").hide();
				jQuery("#mand_bill_state").hide();
				jQuery("#mand_bill_code").hide();
				jQuery("#mand_bill_country").hide();
	
		}else{
			jQuery('.paypa-email-tr').remove();
			jQuery("#mand_add").show();
			jQuery("#mand_city").show();
			jQuery("#mand_state").show();
			jQuery("#mand_code").show();
			jQuery("#mand_country").show();
			
				jQuery("#mand_bill_add").show();
				jQuery("#mand_bill_city").show();
				jQuery("#mand_bill_state").show();
				jQuery("#mand_bill_code").show();
				jQuery("#mand_bill_country").show();
			jQuery('.paypa-email-tr').remove();
		}
		SelectCreditCard();
		
	});
})


SelectCreditCard();
</script>


<? if($PayPalPaid==1){?>
<script>SetForDisableDropship();</script>
<style>
.ui-datepicker-trigger{display:none;}
#TaxRate{background:#f3f3eb;}
</style>
<? } ?>
