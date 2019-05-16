<a href="<?=$RedirectURL?>" class="back">Back</a>

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


?>
<script language="JavaScript1.2" type="text/javascript">


$(document).ready(function(){   


			
				
				 $("#sameBilling").click(function(){
				 
				       if($("#sameBilling").prop('checked') == true)
					    {
						  $("#ShippingName").val($("#CustomerName").val());
						  $("#ShippingCompany").val($("#CustomerCompany").val());
						  $("#ShippingAddress").val($("#Address").val());
						  
						  $("#ShippingCity").val($("#City").val());
						  
						  $("#ShippingState").val($("#State").val());
						  $("#ShippingCountry").val($("#Country").val());
						  $("#ShippingZipCode").val($("#ZipCode").val());
						  
						  $("#ShippingMobile").val($("#Mobile").val());
						  $("#ShippingLandline").val($("#Landline").val());
						  $("#ShippingFax").val($("#Fax").val());
						  $("#ShippingEmail").val($("#Email").val());
						  
						}else{
						  $("#ShippingName").val('');
						  $("#ShippingCompany").val('');
						  $("#ShippingAddress").val('');
						  $("#ShippingCity").val('');
						  
						  $("#ShippingState").val('');
						  $("#ShippingCountry").val('');
						  $("#ShippingZipCode").val('');
						  
						  $("#ShippingMobile").val('');
						  $("#ShippingLandline").val('');
						  $("#ShippingFax").val('');
						  $("#ShippingEmail").val('');
						}
				 
				 });
			//added by nisha for phone  o pattern
	$("#Mobile,#Landline,#ShippingMobile,#ShippingLandline").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //alert("Digits Only");
               return false;
    }
    

   });		
				
});






function SetGLAccount(){	
	var AccountID =  $("#AccountID").val();
	if(AccountID>0){
		$("#GlAmountLabel").show(1000);
		$("#GlAmountValue").show(1000); 

		$("#BillingShippingTr").hide(); 
		$("#LineItemTr").hide();  
		$("#ReStTr").hide();  			 
	}else{
		$("#GlAmountLabel").hide(1000);
		$("#GlAmountValue").hide(1000); 

		$("#BillingShippingTr").show(); 
		$("#LineItemTr").show(); 
		$("#ReStTr").show();  			 
			
	}
	SetCreditType();
}			


function SetCreditType(){
	var CreditType =  $("#CreditType").val();
	if(CreditType==1){
		$("#InvTD").show(); 
		$("#InvTDVal").show(); 	
	}else{
		$("#InvTD").hide(); 
		$("#InvTDVal").hide(); 
		$("#InvoiceID").val(""); 	
	}
	
}



function validateForm(frm){
	
	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}

	var NumLine = parseInt($("#NumLine").val());
		
	var CreditIDVal = Trim(document.getElementById("SaleCreditID")).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;

	if(CreditIDVal!='' || OrderID>0 ){
		if(!ValidateMandRange(document.getElementById("SaleCreditID"), "Credit Memo ID",3,20)){
			return false;
		}
	}

	/***************************/
	var AccountID =  $("#AccountID").val();
	if(AccountID>0){
		if(ValidateForSelect(frm.CustomerName, "Customer")
		&& ValidateForSimpleBlank(frm.GlAmount, "GlAmount")
		){
 			if(frm.GlAmount.value == "" || frm.GlAmount.value == 0){
			      alert("Please Enter Gl Amount.");
			      frm.GlAmount.focus();
			      return false;
			} 

			if(CreditIDVal!=''){
				var Url = "isRecordExists.php?SaleCreditID="+escape(CreditIDVal)+"&editID="+OrderID;
				SendExistRequest(Url,"SaleCreditID", "Credit Memo ID");
				return false;	
			}else{
				ShowHideLoader('1','S');
				return true;	
			}
		}else{
			return false;	
		}
	}
	/***************************/


	if(ValidateForSelect(frm.CustomerName, "Customer")
		&& ValidateForSelect(frm.CustomerCurrency, "Currency")
	    /*&& ValidateForSelect(frm.SalesPerson, "Sales Person")*/ 
		//&& ValidateForSelect(frm.ClosedDate, "Expiry Date") 
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
		

var totalSum = 0;var remainQty=0;var inQty=0;
var evaluationType=''; var DropshipCheck='';
var serial_value = '';


		for(var i=1;i<=NumLine;i++){
		 
			DropshipCheck = document.getElementById("DropshipCheck"+i).checked;
			serial_value = document.getElementById("serial_value"+i).value;
			inQty = document.getElementById("qty"+i).value;
			var seriallength=0;
			if(serial_value != ''){
			var resSerialNo = serial_value.split(",");
			var seriallength = resSerialNo.length;
			}

			evaluationType = document.getElementById("evaluationType"+i).value;

			//if(document.getElementById("sku"+i).value == ""){
				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
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


				/* if(parseInt(seriallength) != parseInt(inQty) && evaluationType == 'Serialized' && DropshipCheck == false && parseInt(inQty) > 0)
                                    {
                                        alert("Please add "+inQty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
                                    }*/




	
			//}
		 
			if(parseInt(document.getElementById("discount"+i).value) > parseInt(document.getElementById("price"+i).value))
			{
			   alert("Discount Should be Less Than Unit Price!");
			   return false;
			}
		}



	
		if(CreditIDVal!=''){
			var Url = "isRecordExists.php?SaleCreditID="+escape(CreditIDVal)+"&editID="+OrderID;
			SendExistRequest(Url,"SaleCreditID", "Credit Memo ID");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}	
		
}


function AutoCompleteInvoice(elm){
	$(elm).autocomplete({
		source: "../jsonInvoice.php",
		minLength: 1
	});

}


 


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
	};

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
	url: "../sales/ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText) {
		/************************************/
		document.getElementById("CustCode").value=responseText["CustCode"];
		document.getElementById("CustID").value=responseText["Cid"];
		var CustId = responseText["Cid"];
		document.getElementById("CustomerName").value=responseText["CustomerName"];

		document.getElementById("tax_auths").value=responseText["Taxable"];
		if(responseText["Taxable"] =='Yes' ){		 
			document.getElementById("MainTaxRate").value=responseText["c_taxRate"];
			SetTaxable();
			freightSett(responseText["c_taxRate"]);
		}
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
		if(window.parent.document.getElementById("AccountID") != null){
			window.parent.document.getElementById("AccountID").value=responseText["DefaultAccount"]; 
			$("#AccountID").select2();
		}
		SetGLAccount();
		SetTaxable();
		ProcessTotal();
		/************************************/
	

		   
	}

   });
				


}

</script>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

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
			<td  align="right"   class="blackbold" > Customer  :<span class="red">*</span> </td>
			<td   align="left"  colspan="3">
				<input name="CustomerName" type="text" class="inputbox"  id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>"  maxlength="60" onblur="SetCustInfo(this.value);" onclick="Javascript:AutoCompleteCustomer(this);" />
				
	<input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustCode']); ?>">
	<input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>">
<input name="Taxable" id="Taxable" type="hidden" value="<?php echo stripslashes($arrySale[0]['Taxable']); ?>">

				<a class="fancybox fancybox.iframe" href="CustomerList.php?creditnote=1" ><?=$search?></a>

			</td>
	 </tr>
</tr>
 <tr>
	 <td colspan="4" align="left" class="head">Credit Memo Information</td>
</tr>
 
   <tr>
        <td  align="right"   class="blackbold" width="20%"> Credit Memo ID # : </td>
        <td   align="left" width="35%">
<? if(!empty($_GET['edit'])) {?>
	<input name="SaleCreditID" type="text" class="datebox" id="SaleCreditID" value="<?php echo stripslashes($arrySale[0]['CreditID']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleCreditID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_SaleCreditID','SaleCreditID','<?=$_GET['edit']?>');" oncontextmenu="return false" />
	<span id="MsgSpan_SaleCreditID"></span>
<? }else{?>
	<input name="SaleCreditID" type="text" class="datebox" id="SaleCreditID" value="<?=$NextModuleID?>"   maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleCreditID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_SaleCreditID','SaleCreditID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" />
	<span id="MsgSpan_SaleCreditID"></span>
<? } ?>

</td>
      

		 <td  align="right"   class="blackbold" width="15%"> Posted Date  :  </td>
        <td   align="left" >

		<script type="text/javascript">
		$(function() {
			$('#PostedDate').datepicker(
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
$PostedDate = ($arrySale[0]['PostedDate']>0)?($arrySale[0]['PostedDate']):($arryTime[0]); 
?>
<input id="PostedDate" name="PostedDate" readonly="" class="datebox" value="<?=$PostedDate?>"  type="text" > 


</td>
        
</tr>


<tr>
       
	<td  align="right" class="blackbold" > Credit Memo Type :</td>
	<td   align="left">
	<select name="CreditType" class="textbox" id="CreditType" style="width:100px;" onChange="Javascript:SetCreditType();">
		<option value="0">Standard</option>
		<option value="1" <?  if(!empty($arrySale[0]['InvoiceID'])){echo "selected";}?>>Against Invoice</option>				
	</select> 
	</td>

	<td  align="right"   class="blackbold" id="InvTD" style="display:none"> Invoice Number #  : </td>
	<td   align="left" id="InvTDVal" style="display:none">
	<input name="InvoiceID" type="text" class="inputbox" id="InvoiceID" value="<?php echo stripslashes($arrySale[0]['InvoiceID']); ?>"  maxlength="30" onKeyPress="Javascript:return isAlphaKey(event);"   onclick="Javascript:AutoCompleteInvoice(this);" oncontextmenu="return false" onBlur="Javascript:RemoveSpecialChars(this);" />   
<a class="fancybox fancybox.iframe" href="selectArInvoice.php" ><?=$search?></a>
       
	</td>

	
</tr>




<tr>
       
	<td  align="right" class="blackbold" >Status  :</td>
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
		<span class="redmsg"><?=$arrySale[0]['Status']?></span> <input type="hidden" name="Status" id="Status" value="<?=$arrySale[0]['Status']?>" readonly />
		<? } ?>

		</td>

	<? if($_GET['edit'] > 0){ ?>

      <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          
		  <? 
			if(($_SESSION['AdminType'] == 'admin' || $ApproveLabel==1) && $arrySale[0]['Approved'] != 1){
				 $ActiveChecked = ' checked';
				 if($_GET['edit'] > 0){
					 if($arrySale[0]['Approved'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					 if($arrySale[0]['Approved'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
			  ?>
          <input type="radio" name="Approved" id="Approved" value="1" <?=$ActiveChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Approved" id="Approved" value="0" <?=$InActiveChecked?> />
          No 
		  <? }else{ 
			  echo ($arrySale[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>');
			  echo '<input type="hidden" name="Approved" id="Approved" value="'.$arrySale[0]['Approved'].'">';
		  }?>
			 </td>

	<? } ?>

	
</tr>


<? if($_GET['edit']>0){ ?>

  <tr>
        
     
        <td  align="right" class="blackbold" >Posted By  : </td>
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
     

	 <? /*if(!empty($arrySale[0]['InvoiceID'])) { 
		$arryInvoice = $objSale->GetInvoice('',$arrySale[0]['InvoiceID'],"Invoice");
	?>
	  
		<!--td  align="right"   class="blackbold" > Invoice Number # :</td>
		<td   align="left" >
	<a class="fancybox fancybox.iframe" href="vInvoice.php?view=<?=$arryInvoice[0]['OrderID']?>&pop=1" ><?=$arrySale[0]["InvoiceID"]?></a>
			</td-->
	      
	<? }*/ ?>
       
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
	 
<? } ?>

<tr>
	<td align="right" class="blackbold">GL Account :</td>
	<td align="left">

		<select name="AccountID" class="inputbox" id="AccountID" onchange="Javascript:SetGLAccount();">
			<?if($Config['SelectOneItem']==0){?><option value="">--- None ---</option><?}?>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arrySale[0]['AccountID']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select> 
<script>
$("#AccountID").select2();
</script>
	</td>

		<td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arrySale[0]['Comment']); ?>"  maxlength="100" />          
	</td>


		
 
	

<tr>
	
	<td  align="right"   class="blackbold" > Currency  :<span class="red">*</span> </td>
		<td   align="left" >
 <?
 if(empty($arrySale[0]['CustomerCurrency']))$arrySale[0]['CustomerCurrency']= $Config['Currency'];

$arrySelCurrency=array();

if(!empty($arryCompany[0]['AdditionalCurrency']))$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);

 ?>
<select name="CustomerCurrency" class="inputbox" id="CustomerCurrency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arrySale[0]['CustomerCurrency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>

	</td>

	<td align="right"  id="GlAmountLabel" style="display:none;" class="blackbold"> Amount :<span class="red">*</span></td>
        <td align="left" id="GlAmountValue" style="display:none;">
		<?php if(!empty($arrySale[0]['TotalAmount'])){$Amnt = $arrySale[0]['TotalAmount'];}else{$Amnt = "0.00";}?>
    	<input name="GlAmount"  type="text" class="textbox" size="15" id="GlAmount"  value="<?=$Amnt?>" maxlength="20" onkeypress="return isDecimalKey(event);"  /> 
		</td>

  </tr>


<tr id="ReStTr" >
	<td  align="right" class="blackbold"> Re-Stocking : </td>
	<td align="left">	 
<select class="textbox" id="ReSt" name="ReSt" style="width:100px;">
	<option value="0" <?=($arrySale[0]['ReSt']=='0')?('selected'):('')?>>No</option>
	<option value="1" <?=($arrySale[0]['ReSt']=='1')?('selected'):('')?>>Yes</option>
</select>	
	</td>
</tr>




  

</table>

</td>
   </tr>

  

<tr>
    <td  align="center" id="BillingShippingTr">

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
		
		/*$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
		echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);*/
		?>	 
			 </td>
		</tr>

<tr>
	<td align="left" id="LineItemTr">
		
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/sale_credit_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($arrySale[0]['Status'] == '' || $arrySale[0]['Status'] == 'Open'){ ?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

		<input type="hidden" name="Module" id="Module" value="Credit" />

		<input type="hidden" name="ModuleID" id="ModuleID" value="CreditID" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="CRD" />



	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<script language="JavaScript1.2" type="text/javascript">
SetGLAccount();
</script>

<? } ?>





