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
	var NumLine1 = parseInt($("#NumLine1").val());
        
        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;
        
        var EntryTypeGL = Trim(document.getElementById("EntryTypeGL")).value;
        var EntryFromGL = Trim(document.getElementById("EntryFromGL")).value;
        var EntryToGL = Trim(document.getElementById("EntryToGL")).value;
        
	var ModuleVal = Trim(document.getElementById("PoInvoiceID")).value;
	var GLAccountLineItem = Trim(document.getElementById("GLAccountLineItem")).value;
        var TotalGlAmount  = Trim(document.getElementById("TotalGlAmount")).value;
       
        
       if(GLAccountLineItem == "GLAccount")
           {  
               
                if(EntryTypeGL == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFromGL, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryToGL, "Entry To")){        
                        return false;
                    }
                    if(EntryFromGL >= EntryToGL) {
                        document.getElementById("EntryFromGL").focus();   
                        alert("End Date Should be Greather Than Start Date.");
                        return false;
                     }
                }
                
                    if(frm.PaidTo.value == "")
                    {
                        alert("Please Select Vendor.");
                        frm.PaidTo.focus();
                        return false;
                    }
                     if(frm.Amount.value == "" || frm.Amount.value == 0)
                    {
                        alert("Please Enter Amount.");
                        frm.Amount.focus();
                        return false;
                    }
                    
                     if(frm.GlEntryType.value == "")
                    {
                        alert("Please Select GL Entry Type.");
                        frm.GlEntryType.focus();
                        return false;
                    }
                     if(frm.PaymentMethodGL.value == "")
                    {
                        alert("Please Select Payment Method.");
                        frm.PaymentMethodGL.focus();
                        return false;
                    }
                    if(frm.ExpenseTypeID.value == "" && frm.GlEntryType.value == "Single")
                    {
                        alert("Please Select GL Account.");
                        frm.ExpenseTypeID.focus();
                        return false;
                    }
                    
                     if(frm.PaymentDate.value == "")
                    {
                        alert("Please Select Payment Date.");
                        frm.PaymentDate.focus();
                        return false;
                    }

                    //CODE FOR PERIOD END SETTING
                    var BackFlag = 0;
                    var PaymentDate = Trim(document.getElementById("PaymentDate")).value;
                    var CurrentPeriodDate = Trim(document.getElementById("CurrentPeriodDate")).value;
                    var CurrentPeriodMsg = Trim(document.getElementById("CurrentPeriodMsg")).value;
                    var strBackDate = Trim(document.getElementById("strBackDate")).value;
                    var strSplitBackDate = strBackDate.split(",");
                    var backDateLength = strSplitBackDate.length;

                    var spliPDate = PaymentDate.split("-");
                    var StrspliPDate = spliPDate[0]+"-"+spliPDate[1];


                    for(var bk=0;bk<backDateLength;bk++)
                    {
                      if(strSplitBackDate[bk] == StrspliPDate)
                          {
                              BackFlag = 1;
                              break;
                          }

                    }


                    var CurrentPeriodDate = Date.parse(CurrentPeriodDate);
                    var PDate = Date.parse(PaymentDate);

                    if(PDate < CurrentPeriodDate && BackFlag == 0) 
                    {
                      alert("Sorry! You Can Not Enter Back Date Entry.\n"+CurrentPeriodMsg+".");
                      document.getElementById("PaymentDate").focus();
                      return false;
                    }

                    //END PERIOD SETTING  
                     if(frm.BankAccount.value == "")
                    {
                        alert("Please Select Account.");
                        frm.BankAccount.focus();
                        return false;
                    } 
              if(frm.GlEntryType.value == "Multiple") 
                  {
                          for(var i=1;i<=NumLine1;i++){


                                var GlAmnt = document.getElementById("GlAmnt"+i).value;

                                        if(!ValidateForSelect(document.getElementById("AccountID"+i), "GL Account.")){
                                                return false;
                                        }

                                        if(parseInt(GlAmnt) == 0){

                                                alert("Please enter amount.");
                                                document.getElementById("GlAmnt"+i).focus();
                                                return false;
                                        } 


                           }	
                  }
            if(frm.PoInvoiceIDGL.value != ''){
                              var Url = "isRecordExists.php?PoInvoiceIDGL="+escape(frm.PoInvoiceIDGL.value);
                              //alert(Url);return false;
                              SendExistRequest(Url,PoInvoiceIDGL, "InvoiceID");
                              return false;	
                      }
                      
                    if((parseFloat(frm.Amount.value) != parseFloat(TotalGlAmount)) && (frm.GlEntryType.value == "Multiple"))  
                        {
                               alert("Amount Should be Equal.");
                                frm.Amount.focus();
                                return false;
                        }
                      
            
                else{

                    ShowHideLoader('1','S');
                       return true;
                    }
               
           }
        
        else{ 

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
                
                var evaluationType =''; var serial_value = '';
		
		for(var i=1;i<=NumLine;i++){
                    
                             evaluationType = document.getElementById("evaluationType"+i).value;
                             qty = document.getElementById("qty"+i).value;
                             serial_value = document.getElementById("serial_value"+i).value;
                                 var seriallength=0;
                                 if(serial_value != ''){
                                    var resSerialNo = serial_value.split(",");
                                    var seriallength = resSerialNo.length;
                                 }
                    
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
                                if(parseInt(seriallength) != parseInt(qty) && evaluationType == 'Serialized'  &&  parseInt(qty) > 0)
                                   {
                                       alert("Please add "+qty+" serial number.");
                                       document.getElementById("qty"+i).focus();
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

function SetGLAccountLineItem(str)
{
    if(str == "LineItem"){
        $("#vendorFrom").show(1000);
        $("#itemFrom").show(1000);
        $("#invoiceFrom").show(1000);
        $("#glFrom").hide(1000);
        $("#GLAccountLineItemType").val('LineItem');
        
        
    }else{
         $("#vendorFrom").hide(1000);
         $("#itemFrom").hide(1000);
         $("#invoiceFrom").hide(1000);
         $("#glFrom").show(1000);
         $("#GLAccountLineItemType").val('GLAccount');
    }
}

</script>



	<table cellspacing="0" cellpadding="0" border="0" id="search_table" style="margin:0">
	<tbody>
            <tr>
                <td align="left"><b>GL Account/Line Item:</b></td>
             <td align="left">
              <select name="GLAccountLineItem" class="inputbox" id="GLAccountLineItem" onchange="Javascript: SetGLAccountLineItem(this.value);"> 
                        <option value="GLAccount">GL Account</option>
                        <option value="LineItem">Line Item</option>
                   </select>
             </td>

	</tr>
			

</tbody>
        </table>
            
<br>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
    
    <!--FOR GL ACCOUNT-->

  <table width="100%"  border="0" align="center" id="glFrom"  cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

     <!---Recurring Start-->
        <?php   
        //$arryRecurr = $arrySale;
        include("../includes/html/box/recurring_gl.php");
        
        ?>

        <!--Recurring End-->
    <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left" width="30%">
		 <input name="PoInvoiceIDGL" type="text" class="datebox" id="PoInvoiceIDGL" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_InvoiceIDGL');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_InvoiceIDGL','PoInvoiceIDGL','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
		 &nbsp;&nbsp;<span id="MsgSpan_InvoiceIDGL"></span>
		</td>
   
	<td  align="right" width="20%"  class="blackbold">Pay to Vendor : <span class="red">*</span></td>
	<td   align="left" >
	 <select name="PaidTo" class="inputbox" id="PaidTo">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arrySupplier);$i++) {
                            
                                if(empty($values["SuppCompany"])){ 
                                     $SupplierName = $objBankAccount->getSupplierName($arrySupplier[$i]['SuppCode']);
                                }else{
                                    $SupplierName = $arrySupplier[$i]["CompanyName"];
                                }
        
                            ?>
			 <option value="<?=$arrySupplier[$i]['SuppCode']?>" <?php if($arryOtherExpense[0]['PaidTo'] == $arrySupplier[$i]['SuppCode']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($SupplierName))?></option>
				<? } ?>
		</select> 
	</td>
	</tr>	
        
         <tr>
        <td align="right"   class="blackbold"> Amount : <span class="red">*</span></td>
        <td align="left">
		<?php if(!empty($arryOtherExpense[0]['Amount'])){$Amnt = $arryOtherExpense[0]['Amount'];}else{$Amnt = "0.00";}?>
    	<input name="Amount" type="text" class="textbox" id="Amount" onkeypress="return isDecimalKey(event);" value="<?=$Amnt;?>"  /><?=$Config['Currency'];?>
		   
		</td>
    
	<td  align="right"   class="blackbold" >GL Entry Type : <span class="red">*</span></td>
	<td   align="left" >
	 <select name="GlEntryType" class="inputbox" id="GlEntryType">
		  	<option value="">--- Select ---</option>
                        <option value="Single">Single</option>
                        <option value="Multiple">Multiple</option>
			 
		</select> 
	</td>
	</tr>	
     
	<tr>
            <td  align="right" class="blackbold">Payment Method : <span class="red">*</span></td>
		<td   align="left">
		  <select name="PaymentMethodGL" class="inputbox" id="PaymentMethodGL">
			<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
					<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?php if($arryOtherExpense[0]['PaymentMethod'] == $arryPaymentMethod[$i]['attribute_value']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
                <td  align="right" class="blackbold"><span id="glAccountSingleRow" style="display: none;">GL Account : <span class="red">*</span></span></td>
		<td  align="left">
                    <span id="glAccountSingleRowFld" style="display: none;">
                    <select name="ExpenseTypeID" class="inputbox" id="ExpenseTypeID">
                    <option value="">&nbsp;--- Select ---</option>
                    <? for($i=0;$i<sizeof($arryExpenseType);$i++) {?>
                    <option value="<?=$arryExpenseType[$i]['BankAccountID']?>" <?php if($arryOtherExpense[0]['ExpenseTypeID'] == $arryExpenseType[$i]['BankAccountID']){echo "selected";}?>>
                    &nbsp;<?=$arryExpenseType[$i]['AccountName']?> - (<?=$arryExpenseType[$i]['Type']?>)
                    </option>
                    <? } ?>
                    </span>
                    </select> 
		</td>
	 
		
	</tr>  
	
	<tr>
		<td  align="right"   class="blackbold">Payment Date  :<span class="red">*</span> </td>
		
		<td   align="left" >
                    <script type="text/javascript">
			$(function() {
			$('#PaymentDate').datepicker(
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
		<?php 	
			
			if(!empty($arryOtherExpense[0]['PaymentDate'])){
				$paymentDate = $arryOtherExpense[0]['PaymentDate'];
			}else{
			 $arryTime = explode(" ",$Config['TodayDate']);
			 $paymentDate = $arryTime[0];
			}
			 
		?>
		 <input id="PaymentDate" name="PaymentDate" readonly="" class="datebox" value="<?=$paymentDate;?>"  type="text" > 
                 
                 <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $IECurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>
		</td>
	 
	<td  align="right"   class="blackbold"> Paid From A/C :<span class="red">*</span> </td>
	<td   align="left" >
	 <select name="BankAccount" class="inputbox" id="BankAccount">
		  	<option value="">--- Select ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			 <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?php if($arryOtherExpense[0]['BankAccount'] == $arryBankAccount[$i]['BankAccountID']){echo "selected";}?>>
			 <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> - <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountType']))?></option>
				<? } ?>
		</select> 
	</td>
	</tr>	
	
	
	
	
   <tr>
        <td  align="right" valign="top"   class="blackbold">Reference No#  : </td>
        <td   align="left" valign="top">
		 <input name="ReferenceNo" type="text" class="inputbox" id="ReferenceNo" value="<?=$arryOtherExpense[0]['ReferenceNo']?>"  />
		</td>
    
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><textarea id="Comment" class="textarea" type="text" name="Comment"><?=$arryOtherExpense[0]['Comment']?></textarea></td>
	</tr>
        <tr id="glAccountMultipleRow" style="display: none;">
			<td colspan="4">
				<? 	include("includes/html/box/add_multi_gl.php");?>
			</td>
		</tr>
	 
</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
	    <input type="hidden" name="ExpenseID" id="ExpenseID" value="<?=$_GET['edit'];?>">
	
	</td>
	</tr>
</table>

    
    
 <!--END FOR GL ACCOUNT--->
  <table width="100%" border="0" cellpadding="5" cellspacing="0" id="invoiceFrom" style="display: none;"  class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Invoice Information</td>
</tr>
  <!---Recurring Start-->
        <?php   
        //$arryRecurr = $arrySale;
        //include("../includes/html/box/recurring_2column.php");
        include("../includes/html/box/recurring_2column_sales.php");
        
        ?>

        <!--Recurring End-->
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" width="36%">

	<input name="PoInvoiceID" type="text" class="datebox" id="PoInvoiceID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','PoInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>

</td>

        <td  align="right"  class="blackbold" >Invoice Date  : </td>
        <td   align="left">
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
 
<!--<tr>
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
      </tr>-->
 
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
<tr id="vendorFrom" style="display: none;">
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

<tr id="itemFrom" style="display: none;">
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" ><?=LINE_ITEM?></td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/po_item_invoice_entry_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($HideSubmit != 1){ ?>

   <tr>
    <td  align="center">
        <input type="hidden" name="GLAccountLineItemType" id="GLAccountLineItemType" value="GLAccount" readonly />
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




<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		 
                    $(".slnoclass").fancybox({
			'width'         : 300
		 });

});

</script>

