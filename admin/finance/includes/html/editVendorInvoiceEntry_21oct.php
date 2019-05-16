<a href="<?=$RedirectURL?>" class="back">Back</a>
<?
	if($OrderIsOpen ==  1){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_PO.'</a>';
			include("includes/html/box/convert_form.php");
		}else if($module=='Order' ){ 
			echo '<a href="../finance/recieveOrder.php?po='.$arryPurchase[0]['OrderID'].'&curP='.$_GET['curP'].'"  class="edit" target="_blank">'.RECIEVE_ORDER.'</a>';
		}
	} 


	if($module=='Order' && $arryPurchase[0]['PurchaseID']!='' ){ 
		$TotalInvoice=$objPurchase->CountInvoices($arryPurchase[0]['PurchaseID']);
		if($TotalInvoice>0)
			echo '<a href="../finance/viewPoInvoice.php?po='.$arryPurchase[0]['PurchaseID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
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


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());
	
        
        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;
        
	var ModuleVal = Trim(document.getElementById("PoInvoiceID")).value;

	
        
          if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greather Than Start Date.");
                      return false;
                     }
                }


	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById("PoInvoiceID"), "Invoice Number",3,20)){
			return false;
		}
	}

	if( ValidateForSelect(frm.SuppCode, "Vendor")
		&& ValidateForSimpleBlank(frm.SuppCompany, "Company Name")
		&& ValidateForSimpleBlank(frm.Address, "Address")
		&& ValidateForSimpleBlank(frm.City, "City")
		&& ValidateForSimpleBlank(frm.State, "State")
		&& ValidateForSimpleBlank(frm.Country, "Country")
		&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
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



                if(ModuleVal!=''){
                        var Url = "isRecordExists.php?PoInvoiceID="+escape(ModuleVal)+"&editID=";
                        SendExistRequest(Url,"PoInvoiceID", "Invoice Number");
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
	if(document.getElementById("OrderType").value=="Drop Ship"){
		$("#wCodeTitle").hide();
		$("#wCodeVal").hide();
		$("#wNameTitle").html('Customer');		
	}else{
		$("#wCodeTitle").show();
		$("#wCodeVal").show();
		$("#wNameTitle").html('Warehouse');		
	}

}

</script>






<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Invoice Information</td>
</tr>
  <!---Recurring Start-->
        <?php   
        //$arryRecurr = $arrySale;
        include("../includes/html/box/recurring_2column.php");?>

        <!--Recurring End-->
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" width="36%">

	<input name="PoInvoiceID" type="text" class="datebox" id="PoInvoiceID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','PoInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>

</td>

        <td  align="right"  class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
<? 	
$arryTime = explode(" ",$Config['TodayDate']);
echo date($Config['DateFormat'], strtotime($arryTime[0]));
?>

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

  <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryPurchase[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		</td>
      </tr>
      
      <tr>
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
 
        <td  align="right" class="blackbold">Shipping Method  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryPurchase[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>
 
<tr>
        <td  align="right"   class="blackbold">Assigned To  : </td>
        <td   align="left">

<input name="EmpName" id="EmpName" type="text" class="disabled" style="width:250px;" value="<?=$arryPurchase[0]['AssignedEmp']?>" readonly />
<input name="EmpID" id="EmpID" type="hidden" class="disabled" value="<?=$arryPurchase[0]['AssignedEmpID']?>"  maxlength="20" readonly />
<input name="OldEmpID" id="OldEmpID" type="hidden" class="disabled" value="<?=$arryPurchase[0]['AssignedEmpID']?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="../purchasing/EmpList.php?dv=4" ><?=$search?></a>	  
		  
		   </td>
                   <td valign="top" align="right" class="blackbold">Reference No#  :</td>
                   <td valign="top" align="left">
                    <input type="text" name="ReferenceNo" class="inputbox" id="ReferenceNo" value="">
                </td>
      </tr>
 
 	<tr>
            <td  align="right" valign="top" class="blackbold" >&nbsp;</td>
			<td   align="left" >&nbsp;</td>
			<td  align="right"  valign="top" class="blackbold" > Comments  : </td>
			<td  valign="top" align="left" >
                        <textarea name="InvoiceComment" type="text" class="textarea" id="InvoiceComment"></textarea>
		</td>
	</tr>

</table>  
    
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
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
		echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
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
				<? 	include("includes/html/box/po_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($HideSubmit != 1){ ?>

   <tr>
    <td  align="center">
        <input type="hidden" name="ReceiveOrderID" id="ReceiveOrderID" value="1" readonly />
        <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />
        <input name="Taxable" id="Taxable" type="hidden" value="<?=stripslashes($arryPurchase[0]['Taxable'])?>">
      <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />

	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<? } ?>





