
<a href="<?=$RedirectURL?>" class="back">Back</a>

<? 
	/*if($arryPurchase[0]['CreditID']!='' ){ 
		$TotalInvoice=$objPurchase->CountInvoices($arryPurchase[0]['CreditID']);
		if($TotalInvoice>0)
			echo '<a href="viewRefund.php?po='.$arryPurchase[0]['CreditID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}
*/
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
	

?>


<script language="JavaScript1.2" type="text/javascript">

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
}



function validateForm(frm){

	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}


	var NumLine = parseInt($("#NumLine").val());
		
	var CreditIDVal = Trim(document.getElementById("PoCreditID")).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;

	if(CreditIDVal!='' || OrderID>0){
		if(!ValidateMandRange(document.getElementById("PoCreditID"), "Credit Memo ID",3,20)){
			return false;
		}
	}

	/***************************/
	var AccountID =  $("#AccountID").val();
	if(AccountID>0){
		if(ValidateForSelect(frm.SuppCode, "Vendor")
		&& ValidateForSimpleBlank(frm.SuppCompany, "Vendor Name")
		&& ValidateForSimpleBlank(frm.GlAmount, "GlAmount")
		){
 			if(frm.GlAmount.value == "" || frm.GlAmount.value == 0){
			      alert("Please Enter Gl Amount.");
			      frm.GlAmount.focus();
			      return false;
			} 

			if(CreditIDVal!=''){
				var Url = "isRecordExists.php?PoCreditID="+escape(CreditIDVal)+"&editID="+OrderID;
				SendExistRequest(Url,"PoCreditID", "Credit Memo ID");
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



	if(  ValidateForSelect(frm.SuppCode, "Vendor")
		&& ValidateForSelect(frm.Currency, "Currency")
		&& ValidateForSimpleBlank(frm.SuppCompany, "Vendor Name")
		//&& ValidateForSimpleBlank(frm.Address, "Address")
		//&& ValidateForSimpleBlank(frm.City, "City")
		//&& ValidateForSimpleBlank(frm.State, "State")
		//&& ValidateForSimpleBlank(frm.Country, "Country")
		//&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidateForSimpleBlank(frm.SuppContact, "Contact Name")
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		&& isEmailOpt(frm.wEmail)
	){
		
		for(var i=1;i<=NumLine;i++){
			if(document.getElementById("sku"+i) != null){
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
				

			}
		}



	
		if(CreditIDVal!=''){
			var Url = "isRecordExists.php?PoCreditID="+escape(CreditIDVal)+"&editID="+OrderID;
			SendExistRequest(Url,"PoCreditID", "Credit Memo ID");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}	
		
}







function setShipTo(){
	if(document.getElementById("OrderType").value=="Dropship"){
		$("#wCodeTitle").hide();
		$("#wCodeVal").hide();
		$("#wNameTitle").html('Customer');		
	}else{
		$("#wCodeTitle").show();
		$("#wCodeVal").show();
		$("#wNameTitle").html('Warehouse');		
	}

}


function AutoCompleteVendor(elm){
	$(elm).autocomplete({
		source: "../jsonVendor.php",
		minLength: 1
	});

} 

function ResetSearchdd(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function SetVendorInfo(inf){
 
	if(inf == ''){
		//document.getElementById("form1").reset();

 
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
document.getElementById("AccountID").value='';
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
 
  
document.getElementById("SuppCode").value=responseText["SuppCode"];
document.getElementById("SuppCompany").value=responseText["CompanyName"];
document.getElementById("SuppContact").value=responseText["UserName"];
 
document.getElementById("Address").value=responseText["Address"];
document.getElementById("City").value=responseText["City"];
document.getElementById("State").value=responseText["State"];
document.getElementById("Country").value=responseText["Country"];
document.getElementById("ZipCode").value=responseText["ZipCode"];
document.getElementById("Mobile").value=responseText["Mobile"];
document.getElementById("Landline").value=responseText["Landline"];
document.getElementById("Email").value=responseText["Email"];
if(responseText["Currency"] != null){
	document.getElementById("Currency").value=responseText["Currency"];

}
if(responseText["AccountID"] != null){
	document.getElementById("AccountID").value=responseText["AccountID"];
	$("#AccountID").select2();
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
	document.getElementById("AccountID").value='';
}
        
	SetGLAccount();					 


					}
				});

	}

$(document).ready(function(){   
//added by nisha for phone no pattern
	$("#Mobile,#Landline,#wMobile,#wLandline").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //alert("Digits Only");
               return false;
    }
    

   });	
});




</script>



<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>




<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 <tr>
	 <td colspan="4" align="left" class="head">Vendor</td>
</tr>	 
	<tr>
			<td  align="right"   class="blackbold"  > Vendor Code  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="SuppCode" type="text" class="textbox" style="width:90px;" id="SuppCode" value="<?php echo stripslashes($arryPurchase[0]['SuppCode']); ?>"  maxlength="40" onclick="Javascript:AutoCompleteVendor(this);" onblur="SetVendorInfo(this.value);" />
	<a class="fancybox fancybox.iframe" href="SupplierList.php?creditnote=1" ><?=$search?></a>

			</td>
	 
			<td  align="right"   class="blackbold" > Vendor Name  :<span class="red">*</span> </td>
			<td   align="left" >
	<input name="SuppCompany" type="text" class="inputbox" id="SuppCompany" value="<?php echo stripslashes($arryPurchase[0]['SuppCompany']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		</td>
	</tr>

 <tr>
	 <td colspan="4" align="left" class="head"><?=$ModuleName?> Information</td>
</tr>
 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Credit Memo ID # : </td>
        <td   align="left" width="35%">
<? if(!empty($_GET['edit'])) {?>
	<!--input name="PoCreditID" type="text" class="disabled" readonly style="width:90px;" id="PoCreditID" value="<?php echo stripslashes($arryPurchase[0]['CreditID']); ?>"  maxlength="20" -->
	<input name="PoCreditID" type="text" class="datebox" id="PoCreditID" value="<?php echo stripslashes($arryPurchase[0]['CreditID']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_PoCreditID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_PoCreditID','PoCreditID','<?=$_GET['edit']?>');"  oncontextmenu="return false" />
	<span id="MsgSpan_PoCreditID"></span>
<? }else{?>
	<input name="PoCreditID" type="text" class="datebox" id="PoCreditID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_PoCreditID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_PoCreditID','PoCreditID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"  oncontextmenu="return false" />
	<span id="MsgSpan_PoCreditID"></span>
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
$PostedDate = ($arryPurchase[0]['PostedDate']>0)?($arryPurchase[0]['PostedDate']):($arryTime[0]); 
?>
<input id="PostedDate" name="PostedDate" readonly="" class="datebox" value="<?=$PostedDate?>"  type="text" > 


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

<tr>
        <td  align="right" class="blackbold"  >Status  :</td>
        <td   align="left" >
		<?
		if($arryPurchase[0]['Status'] == 'Open' || $arryPurchase[0]['Status'] == ''){
		?>
		  <select name="Status" class="textbox" id="Status" style="width:100px;">
				<? for($i=0;$i<sizeof($arryOrderStatus);$i++) {?>
					<option value="<?=$arryOrderStatus[$i]['attribute_value']?>" <?  if($arryOrderStatus[$i]['attribute_value']==$arryPurchase[0]['Status']){echo "selected";}?>>
					<?=$arryOrderStatus[$i]['attribute_value']?>
					</option>
				<? } ?>
			</select> 
		<? }else{ ?>
		<span class="redmsg"><?=$arryPurchase[0]['Status']?></span> <input type="hidden" name="Status" id="Status" value="<?=$arryPurchase[0]['Status']?>" readonly />

		<? } ?>

		</td>
 
	<? if($_GET['edit'] > 0){ ?>
		<td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          
		  <? 
			if(($_SESSION['AdminType'] == 'admin' || $ApproveLabel==1) && $arryPurchase[0]['Approved'] != 1){
				 $ActiveChecked = ' checked';
				 if($_GET['edit'] > 0){
					 if($arryPurchase[0]['Approved'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					 if($arryPurchase[0]['Approved'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
			  ?>
          <input type="radio" name="Approved" id="Approved" value="1" <?=$ActiveChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Approved" id="Approved" value="0" <?=$InActiveChecked?> />
          No 
		  <? }else{ 
			  echo ($arryPurchase[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>');
			  echo '<input type="hidden" name="Approved" id="Approved" value="'.$arryPurchase[0]['Approved'].'">';
		  }?>
			 </td>

        <? } ?>
      </tr>




<? if($_GET['edit']>0){ ?>


<tr>
        


	 <td  align="right" class="blackbold" >Posted By  : </td>
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


	 <? if(!empty($arryPurchase[0]['InvoiceID'])) { 
	$arryInvoice = $objPurchase->GetPurchaseInvoice('',$arryPurchase[0]['InvoiceID'],"Invoice");
?>
        <td  align="right"   class="blackbold" > Invoice Number # :</td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="vPoInvoice.php?view=<?=$arryInvoice[0]['OrderID']?>&pop=1" ><?=$arryPurchase[0]["InvoiceID"]?></a>
</td>
		
	<? } ?>


      </tr>

 



<? } ?>






<tr>
	<td align="right" class="blackbold">GL Account :</td>
	<td align="left">

		<select name="AccountID" class="inputbox" id="AccountID" onchange="Javascript:SetGLAccount();">
			<?if($Config['SelectOneItem']==0){?><option value="">--- None ---</option><?}?>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryPurchase[0]['AccountID']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select> 

<script>
$("#AccountID").select2();
</script>


	</td>
 
	<td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arryPurchase[0]['Comment']); ?>"  maxlength="100" />          
	</td>


</tr>




<tr>
	

<td  align="right"   class="blackbold" > Currency  :<span class="red">*</span> </td>
		<td   align="left" >
		 
  <?
 if(empty($arryPurchase[0]['Currency']))$arryPurchase[0]['Currency']= $Config['Currency'];

$arrySelCurrency=array();
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
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryPurchase[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>

	</td>


	<td align="right"  id="GlAmountLabel" style="display:none;" class="blackbold"> Amount :<span class="red">*</span></td>
        <td align="left" id="GlAmountValue" style="display:none;">
		<?php if(!empty($arryPurchase[0]['TotalAmount'])){$Amnt = $arryPurchase[0]['TotalAmount'];}else{$Amnt = "0.00";}?>
    	<input name="GlAmount"  type="text" class="textbox" size="15" id="GlAmount"  value="<?=$Amnt?>" maxlength="20" onkeypress="return isDecimalKey(event);"  /> 
		</td>

</tr>

<tr id="ReStTr" >
	<td  align="right" class="blackbold"> Re-Stocking : </td>
	<td align="left">	 
<select class="textbox" id="Restocking" name="Restocking" style="width:100px;">
	<option value="0" <?=($arryPurchase[0]['Restocking']=='0')?('selected'):('')?>>No</option>
	<option value="1" <?=($arryPurchase[0]['Restocking']=='1')?('selected'):('')?>>Yes</option>
</select>	
	</td>
</tr>

</table>

</td>
   </tr>

  

<tr>
    <td  align="center" id="BillingShippingTr">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"   >
		<tr>
			<td align="left" valign="top" width="50%"  class="borderpo"><? include("includes/html/box/po_vendor_form.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top"  class="borderpo"><? include("includes/html/box/po_warehouse_form.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
			 <td align="right">
		<?
		
		/*$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
		echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);*/
		?>	 
			 </td>
		</tr>

<tr>
	<td align="left" id="LineItemTr">
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" ><?=LINE_ITEM?></td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/po_credit_item.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($arryPurchase[0]['Status'] == '' || $arryPurchase[0]['Status'] == 'Open'){ ?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="Module" id="Module" value="Credit" />

<input type="hidden" name="ModuleID" id="ModuleID" value="CreditID" />
<input type="hidden" name="PrefixPO" id="PrefixPO" value="CRD" />
<input name="Taxable" id="Taxable" type="hidden" value="<?=stripslashes($arryPurchase[0]['Taxable'])?>">

<input type="hidden" name="InvoiceID" id="InvoiceID" value="<?=$arryPurchase[0]['InvoiceID']?>" readonly />


	</td>
   </tr>



<? } ?>
  
</table>

 </form>
<script language="JavaScript1.2" type="text/javascript">
SetGLAccount();
</script>

<? } ?>





