<?php 

$Cid=$_SESSION['UserData']['Cid'];
$CustCode=$_SESSION['UserData']['CustCode'];

?>
<a href="<?=$RedirectURL?>" class="back">Back</a>

<? 
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);
if($arrySale[0]["OrderType"] != '') $OrderType = $arrySale[0]["OrderType"]; else $OrderType = 'Standard';

if(!empty($_REQUEST['edit'])){
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
function validateForm(frm){
	
	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}
	 

	var NumLine = parseInt($("#NumLine").val());
	
	var ModuleField = '<?=$ModuleID?>';
	
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
	   
        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;
       	
        //var SpiffSetting = Trim(document.getElementById("SpiffSetting")).value;
        
        var OrderType = Trim(document.getElementById("OrderType")).value;
        //var PONumber = Trim(document.getElementById("PONumber")).value;
         
    
	if(ModuleVal!=''){
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
                      alert("End Date Should be Greater Than Start Date.");
                      return false;
                     }
                }


	if(  /* ValidateForSelect(frm.SalesPerson, "Sales Person")*/ 
		ValidateForSelect(frm.OrderDate, "Order Date") 
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



	
		if(ModuleVal!='' && OrderID==''){
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

	<!--<a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>

	--></td>

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
        <td   align="left" colspan="3">
<? if(!empty($_GET['edit'])) {?>
	<input name="<?=$ModuleID?>" type="text" class="disabled" readonly style="width:90px;" id="<?=$ModuleID?>" value="<?php echo stripslashes($arrySale[0][$ModuleID]); ?>"  maxlength="20" />
<? }else{?>
	<input name="<?=$ModuleID?>" type="text" class="datebox" id="<?=$ModuleID?>" value="<?php echo stripslashes($arrySale[0][$ModuleID]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_ModuleID"></span>
<? } ?>

</td>

 
  
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
    
   //include("includes/html/box/recurring_2column_sales.php"); ?>
   
   <!--Recurring End-->

 <tr>
			<td  align="right"   class="blackbold" width="20%"> Sales Person  : </td>
			<td   align="left" width="30%">
				<input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arrySale[0]['SalesPerson']); ?>"  maxlength="40" readonly />
				<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arrySale[0]['SalesPersonID']); ?>" type="hidden">
				<input name="OldSalesPersonID" id="OldSalesPersonID" value="<?php echo stripslashes($arrySale[0]['SalesPersonID']); ?>" type="hidden">
				<? if($Config['FullPermission'] == 1){?>
				<a class="fancybox fancybox.iframe" href="EmpList.php?dv=7"  ><?=$search?></a>
				<? } ?>

			</td>
	
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
                      if(($_SESSION['AdminType'] == 'admin' || $FullAcessLabel==1) && $arrySale[0]['Approved'] != 1){
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


<!--<tr>

        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySale[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		</td>

		<td  align="right" class="blackbold">Payment Method  :</td>
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


--><tr><!--
        

        <td  align="right" class="blackbold">Shipping Method  :</td>
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arrySale[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>

--><td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arrySale[0]['Comment']); ?>"  maxlength="100" />          
	</td>

</tr>

<!--tr style="display:none44">
			<td  align="right"   class="blackbold" > Currency  : </td>
			<td   align="left" >
	        <input name="CustomerCurrency" type="text" class="disabled" readonly style="width:90px;" id="CustomerCurrency" value="<?=stripslashes($arrySale[0]['CustomerCurrency'])?>"/> 

		</td>
   </tr-->
   
 
<tr>
	<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<?
//unset($arryCompany[0]['AdditionalCurrency']);
if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
}

 ?>
<select name="CustomerCurrency" class="inputbox" id="CustomerCurrency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arrySale[0]['CustomerCurrency']){echo "selected";}?>>
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




  
  <? if($arrySale[0]['Status'] == '' || $arrySale[0]['Status'] == 'Open'){ ?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

		<input type="hidden" name="Module" id="Module" value="<?=$module?>" />

		<input type="hidden" name="ModuleID" id="ModuleID" value="<?=$ModuleID?>" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="<?=$PrefixSale?>" />

	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<? } ?>



<script>
 var OrderType = Trim(document.getElementById("OrderType")).value;
        setPOrder(OrderType);
</script>


<script type="text/javascript">
$( document ).ready(function() {
	
	SetCustCode('<?php echo $CustCode; ?>','<?php echo $Cid; ?>','');
	
});

function SetCustCode(CustCode,CustId,creditnote){

	var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();
   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText) {
		
		window.parent.document.getElementById("CustCode").value=CustCode;
		window.parent.document.getElementById("CustID").value=CustId;
		window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];
		window.parent.document.getElementById("Taxable").value=responseText["Taxable"];

        if(responseText["MDType"]){
		  if(responseText["MDType"] == 'Discount'){
                        
			window.parent.document.getElementById("CustDisType").value=responseText["DiscountType"];
			window.parent.document.getElementById("MDAmount").value=responseText["MDAmount"];
			window.parent.document.getElementById("MDType").value=responseText["MDType"];
                        window.parent.document.getElementById("MDiscount").value=responseText["MDiscount"];


		}else{

                        window.parent.document.getElementById("CustDisType").value='Percentage';
			window.parent.document.getElementById("MDAmount").value=responseText["MDAmount"];
		        window.parent.document.getElementById("MDType").value=responseText["MDType"];
                        window.parent.document.getElementById("MDiscount").value=responseText["MDiscount"];
		}


	}else{
         window.parent.document.getElementById("CustDisType").value='';
	 window.parent.document.getElementById("MDAmount").value='';
	 window.parent.document.getElementById("MDType").value='';
	window.parent.document.getElementById("MDiscount").value='';
	}
		
		if(responseText["SalesPerson"]){
			window.parent.document.getElementById("SalesPerson").value=responseText["SalesPerson"];
			window.parent.document.getElementById("SalesPersonID").value=responseText["SalesPersonID"];
			window.parent.document.getElementById("OldSalesPersonID").value=responseText["SalesPersonID"];
		}else{
			window.parent.document.getElementById("SalesPerson").value='';
			window.parent.document.getElementById("SalesPersonID").value='';
			window.parent.document.getElementById("OldSalesPersonID").value='';
			
		}
		

		//Order Quote
		if(creditnote == ""){
		//window.parent.document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
		//window.parent.document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
		//window.parent.document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
		}
		//window.parent.document.getElementById("CustomerCurrency").value=responseText["Currency"];
	
	window.parent.document.getElementById("CustomerCompany").value=responseText["CustomerCompany"];
	window.parent.document.getElementById("BillingName").value=responseText["Name"];
	window.parent.document.getElementById("Address").value=responseText["Address"];
	window.parent.document.getElementById("City").value=responseText["CityName"];
	window.parent.document.getElementById("State").value=responseText["StateName"];
	window.parent.document.getElementById("Country").value=responseText["CountryName"];
	window.parent.document.getElementById("ZipCode").value=responseText["ZipCode"];
	window.parent.document.getElementById("Mobile").value=responseText["Mobile"];
	window.parent.document.getElementById("Landline").value=responseText["Landline"];
	window.parent.document.getElementById("Fax").value=responseText["Fax"];
	window.parent.document.getElementById("Email").value=responseText["Email"];	

	window.parent.document.getElementById("ShippingCompany").value=responseText["CustomerCompany"];
	window.parent.document.getElementById("ShippingName").value=responseText["sName"];
	window.parent.document.getElementById("ShippingAddress").value=responseText["sAddress"];
	window.parent.document.getElementById("ShippingCity").value=responseText["sCityName"];
	window.parent.document.getElementById("ShippingState").value=responseText["sStateName"];
	window.parent.document.getElementById("ShippingCountry").value=responseText["sCountryName"];
	window.parent.document.getElementById("ShippingZipCode").value=responseText["sZipCode"];
	window.parent.document.getElementById("ShippingMobile").value=responseText["sMobile"];
	window.parent.document.getElementById("ShippingLandline").value=responseText["sLandline"];
	window.parent.document.getElementById("ShippingFax").value=responseText["sFax"];
	window.parent.document.getElementById("ShippingEmail").value=responseText["sEmail"];





	/***/
	if(window.parent.document.getElementById("contact_link") != null){
		window.parent.document.getElementById("ContactDiv").innerHTML='';	
		window.parent.document.getElementById("SpiffContact").value='';	
		var contact_link = window.parent.document.getElementById("contact_link");
		contact_link.setAttribute("href", 'CustomerContact.php?CustID='+CustId);
	}
	/***/






	ProcessTotal();
	/************************************/
	


		
	
		   
	}

   });
				


}
</script>
