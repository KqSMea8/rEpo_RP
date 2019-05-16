
<?
$EcommFlag = $MandForEcomm = '';
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$EcommFlag = 1;
		$MandForEcomm = '<span class="red">*</span>';
	}
}

?>
<script language="JavaScript1.2" type="text/javascript">
// ali shipping account customer 2-july 2018 

$(document).on("blur","#AddNewAcc", function(){

	var AccountAvailable='';
	var values = [];
	$('#ShippingAccNo option').each(function() { 
	    values.push( $(this).val() );
	});

	var AddNewAcc= $('#AddNewAcc').val();

 
	for(var ik=0; ik<values.length; ik++){
		if(values[ik]==AddNewAcc){
			var AccountAvailable="yes";
		}
	}

	if(AccountAvailable=="yes"){
		$('#errormessage').html("<span class=redmsg>Already Exist!</span>");
	}else{
		if(AddNewAcc!=''){
			$("#save_shipp_acc_div").fancybox().click();
		}
	}
		
});

 

$(document).ready(function() {
	$('#yesShipSave').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
	        $.fancybox.close();
		$('#errormessage').html("<span class=greenmsg>Available!</span>");
                $('#ShippingAccountAdjust').val(1);

	});


	$('#cancelShipSave').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
	        $.fancybox.close();
                $('#errormessage').html("<span class=greenmsg>Available!</span>");
                $('#ShippingAccountAdjust').val(0);
	});
});

$(document).on("change","#ShippingAccNo", function(){

	var AddNewShipping= $('#ShippingAccNo').val();
	if(AddNewShipping=="Add New"){
		$('#AddNewAcc').css("display", "inline");
	}else {
		$('#AddNewAcc').css("display", "none");
		$('#AddNewAcc').val('');
                $('#errormessage').html("");
                $('#ShippingAccountAdjust').val(0);
	}

});



//ali shipping account customer 2-may-2018

$(document).on("change","#ShippingMethod", function(){
$('#shippingAccount').css("display", "none");
	$('#ShippingAccNo').val('');
	$('#ShippingAccountCustomer').val(0);
	$('#shippingAccountnumber').css("display", "none");

});

$(document).on("change","#ShippingMethodVal", function(){

	var ShippingMethodVal= $('#ShippingMethodVal').val();
	
	 
	

if( ShippingMethodVal != '')
{
	$('#shippingAccount').removeAttr('style');
}
else
{  
	
	$('#shippingAccount').css("display", "none");
	$('#ShippingAccNo').val('');
	$('#ShippingAccountCustomer').val(0);
	
	$('#AddNewAcc').val('');
        $('#errormessage').html("");
        $('#ShippingAccountAdjust').val(0);
	$('#shippingAccountnumber').css("display", "none");
}
});

$(document).on("change","#ShippingAccountCustomer", function(){

	var ShippingAccountCustomer= $('#ShippingAccountCustomer').val();
	
	var custid=$('#CustID').val();
	
if( ShippingAccountCustomer != '0')
{   
	if(custid!=''){

	$('#shippingAccountnumber').removeAttr('style');
    var shippingmethod2=$('#ShippingMethod').val();
    
    
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data:{action:'ShippingAccountCustomer',CustID:custid,Type:shippingmethod2}, 
	    success: function(data){
			$("#ShippingAccNo").html(data);
		}
		});
	}else {
		alert("Please select customer first.");

		$('select option:contains("No")').prop('selected',true); 
		
		
	}
		
	
}
else
{  
	
	$('#shippingAccountnumber').css("display", "none");
	$('#ShippingAccNo').val('');
	$('#ShippingAccountCustomer').val(0);

	$('#AddNewAcc').val('');
        $('#errormessage').html("");
        $('#ShippingAccountAdjust').val(0);
}
});
//ali shipping account customer




function shipCarrier(){
	var method = document.getElementById("ShippingMethod").value;
	var spval = document.getElementById("spval").value;
	 
	var countryCode= '';
	var SendParam = 'action='+method+'&countryCode='+countryCode+'&shippval='+spval; 

	if(method==''){
		// document.getElementById("spmethod").style.display = 'none'; 
		//document.getElementById("ShippingMethodVal").value=''; 
		document.getElementById("spmethod").style.display = 'none'; 
		document.getElementById("shippingAccount").style.display = 'none';
		document.getElementById("ShippingMethodVal").value='';
		document.getElementById("ShippingAccountCustomer").value=0; 
		document.getElementById("ShippingMethodVal").value='';
		$('#ShippingAccNo').val(''); 

	        $('#AddNewAcc').val('');
                $('#errormessage').html("");
                $('#ShippingAccountAdjust').val(0);


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
/**Start function detele file by sachin**/ 
function DeleteFileStorage(file_dir,file_name, file_div,id,ModuleName,Module){  

	$("#dialog-modal").html("Are you sure you want to delete this file?");
    $("#dialog-modal").dialog(
    {
        title: "Remove File",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				
				$(this).dialog("close");
				var SendParam = "action=remove_file_Storage&file_dir="+escape(file_dir)+"&file_name="+escape(file_name)+"&id="+id+"&ModuleName="+ModuleName+"&Module="+Module+"&r="+Math.random(); 
		    var IsExist = 0;
		    $.ajax({
			type: "GET",
			async:false,
			url: '../ajax.php',
			data: SendParam,
			success: function (responseText) { 
				  
				$(".IdProofDiv_"+responseText).hide();
				
				
			}
		});	

		return IsExist;
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


$(document).on('change','.FileName',function(){
	$("#validfileval").val('0');
	$('input[name="FileName[]"]').each(function(){
           
			
			
			var checkfiles    =   $(this).val();
				//alert(checkfiles);
		    if(checkfiles){
            var files    =   $(this)[0].files;
            
			var fname = files[0].name.toLowerCase();
				
                var ext = fname.split('.').pop();
				if(ValidateOptionalDocFiles(ext)!=1){
					
			        $("#validfileval").val('1');
			        alert('Only following filetypes are supported:\n1) pdf\n2) doc\n3) docx\n4) ppt\n5) pptx\n6) xls\n7) xlsx\n8) rtf\n9) txt');
			    }
			    }
			
	       
	       
        });
	
	
});

window.onload = function () { 
var filecheckval=Trim(document.getElementById("filecheck")).value;
if(filecheckval==1){

document.getElementById("filecheck").setAttribute("checked", "checked"); 
	
}
else{
		document.getElementById("filecheck").removeAttribute("checked"); 
		
	}
   
   
    var maxField = 10; 
    var addButton = $('.add_button'); 
    var wrapper = $('.field_wrapper');
    
    

    var x = 1;
    $(addButton).click(function(){ 
        if(x < maxField){ 
 var fieldHTML = '<div class="FilenameDiv_'+x+'"><input type="file" style="margin-top:5px;" name="FileName[]" numberUpFile="'+x+'" class="FileName" /><a href="javascript:void(0);" class="remove_button" numberUp="'+x+'" title="Remove field"><img border="0" onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip(\'<center>Delete</center>\', 40,\'\')" class="delicon" src="https://www.eznetcrm.com/erp/admin/images/delete.png"></a></div>'; 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){
       
        
        e.preventDefault();
        var y=0;
        $("#validfileval").val('0');
        var numUp=$(this).attr("numberUp");
        
        $('input[name="FileName[]"]').each(function(){
           var numUpFile= $(this).attr("numberUpFile");
			
			if(numUpFile!=numUp){
				var checkfiles    =   $(this).val();
				//alert(checkfiles);
		    if(checkfiles){
            var files    =   $(this)[0].files;
            
			var fname = files[0].name.toLowerCase();
				
                var ext = fname.split('.').pop();
				if(ValidateOptionalDocFiles(ext)!=1){
					
			        $("#validfileval").val('1');
			    }
			    }
			}
	       
	        y++;
        });
        $(this).parent('div').remove();
        x--; 
    });

    }
/**end function detele file by sachin**/
</script>
<style type="text/css">
	.FileName{width: 220px;}
        #showfile > div{width: 315px;}
	.add_button{color:#fff !important;}
</style>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="4" align="left" class="head">Invoice Information</td>
	</tr>
        
        <!---Recurring Start-->
        <?php   
        $arryRecurr = $arrySale;
        //include("../includes/html/box/recurring_2column_sales.php");?>

        <!--Recurring End-->


<? if($arrySale[0]['OrderPaid']>0) { ?>
	<tr>
		 <td  align="right"   class="blackbold" >Payment Status  : </td>
		<td   align="left" >
			<? #echo ($arrySale[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>'); ?>

<? echo $objSale->GetCreditStatusMsg($arrySale[0]['Status'],$arrySale[0]['OrderPaid']); ?>


		</td>
	</tr>
	<? } ?>

	<tr>
        <td  align="right"   class="blackbold" width="20%" valign="top"> Invoice Number # : </td>
        <td   align="left" width="25%">
<? if(!empty($_GET['edit'])) {?>
	<input name="SaleInvoiceID" type="text" class="datebox" id="SaleInvoiceID" value="<?php echo stripslashes($arrySale[0]['InvoiceID']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleInvoiceID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_SaleInvoiceID','SaleInvoiceID','<?=$_GET['edit']?>');" oncontextmenu="return false" />
		<div id="MsgSpan_SaleInvoiceID"></div>
<? }else{?>
		 <input name="SaleInvoiceID" type="text" class="datebox" id="SaleInvoiceID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleInvoiceID');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_SaleInvoiceID','SaleInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" />
		 <div id="MsgSpan_SaleInvoiceID"></div>
<? } ?>

		</td>
         <td  align="right"   class="blackbold" width="25%"> Sales Person  : </td>
			<td   align="left">
				<input name="SalesPerson" type="text" class="disabled"  id="SalesPerson" value="<?php echo stripslashes($arrySale[0]['SalesPerson']); ?>"   readonly />
				<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arrySale[0]['SalesPersonID']); ?>" type="hidden">
				<input name="vendorSalesPersonID" id="vendorSalesPersonID" value="<?php echo stripslashes($arrySale[0]['VendorSalesPerson']); ?>" type="hidden">
<input name="SalesPersonType" id="SalesPersonType" value="<?php echo stripslashes($arrySale[0]['SalesPersonType']); ?>" type="hidden">
 <input name="SalesPersonName" id="SalesPersonName" value="<?php echo stripslashes($empSalesPersonName); ?>" type="hidden">
  <input name="vendorSalesPersonName" id="vendorSalesPersonName" value="<?php echo stripslashes($venSalesPersonName); ?>" type="hidden">

				<? if($AssignLabel == 1){?>
			<!--<a class="fancybox fancybox.iframe" href="../sales/EmpList.php?dv=7&Department=17"  ><?//=$search?></a>-->
				<a class="fancybox fancybox.iframe" href="../sales/SalesPersonList.php?dv=7&Department=17"  ><?=$search?></a><!-- modified by nisha-->
		<? } ?>		

			</td>
	 
	</tr>

	<tr>
       <td  align="right" class="blackbold"> Invoice Date  : </td>
		<td  align="left">
<script type="text/javascript">
	$(function() {
	$('#InvoiceDate').datepicker(
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
		$InvoiceDate = ($arrySale[0]['InvoiceDate']>0)?($arrySale[0]['InvoiceDate']):($arryTime[0]); 
		?>
		<input id="InvoiceDate" name="InvoiceDate" readonly="" class="datebox" value="<?=$InvoiceDate?>"  type="text" > 


		</td>
	 <td  align="right"   class="blackbold"> Ship Date  : </td>
		<td   align="left" >

			<script type="text/javascript">
			$(function() {
			$('#ShippedDate').datepicker(
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
		$ShippedDate = ($arrySale[0]['ShippedDate']>0)?($arrySale[0]['ShippedDate']):($arryTime[0]); 
		?>
		<input id="ShippedDate" name="ShippedDate" readonly="" class="datebox" value="<?=$ShippedDate?>"  type="text" > 


		</td>
	
      
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


	<tr>
          <td  align="right" class="blackbold">Ship From :</td>
        <td   align="left">
		<input name="wCode" type="text" class="disabled" style="width:90px;" id="wCode" value="<?php echo stripslashes($arrySale[0]['wCode']); ?>"  maxlength="40" readonly />
	     <a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?=$search?></a>
		</td>    
        <td  align="right" class="blackbold">Ship From(Warehouse) :</td>
        <td   align="left">
		<input name="wName" type="text" class="inputbox" id="wName" value="<?php echo stripslashes($arrySale[0]['wName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		
			<input name="wContact" type="hidden" class="inputbox" id="wContact" value="">
			<input name="wAddress" type="hidden" class="inputbox" id="wAddress" value="">
			<input name="wCity" type="hidden" class="inputbox" id="wCity" value="">
			<input name="wState" type="hidden" class="inputbox" id="wState" value="">
			<input name="wCountry" type="hidden" class="inputbox" id="wCountry" value="">
			<input name="wZipCode" type="hidden" class="inputbox" id="wZipCode" value="">
			<input name="wMobile" type="hidden" class="inputbox" id="wMobile" value="">
			<input name="wLandline" type="hidden" class="inputbox" id="wLandline" value="">
			<input name="wEmail" type="hidden" class="inputbox" id="wEmail" value="">
		</td>
   
		</tr>
                
                <tr>
        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">

		<? if($TransactionExist==1 || ($_SESSION['AdminType'] != 'admin' && $FullAcessLabel!=1)){ ?>
		<input type="text" name="PaymentTerm" id="PaymentTerm" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['PaymentTerm'])?>">
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
 
	<td  align="right"   class="blackbold" valign="top"> Currency  :<span class="red">*</span> </td>
	<td   align="left" valign="top" >
<? if($TransactionExist==1){ ?>
		<input type="text" name="CustomerCurrency" id="CustomerCurrency" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['CustomerCurrency'])?>">
<? }else{ 

if(empty($arrySale[0]['CustomerCurrency']))$arrySale[0]['CustomerCurrency']= $Config['Currency'];

$arrySelCurrency=array();
if(!empty($arryCompany[0]['AdditionalCurrency']))$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}

if(!empty($arrySale[0]['CustomerCurrency']) && !in_array($arrySale[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arrySale[0]['CustomerCurrency'];
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

<? } ?>

</td> 
        
</tr>


 
       
 

	
<tr id="BankAccountTR">
		<td  align="right" class="blackbold">Bank Account :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
		
	<select name="BankAccount" class="inputbox" id="BankAccount" >
		<option value="">--- Select ---</option>
		<? 
		for($i=0;$i<sizeof($arryBankAccountVal);$i++) {
		$selected='';
		if($_GET['edit']>0){ 
			
			if($arryBankAccountVal[$i]['BankAccountID']==$arrySale[0]['AccountID']) $selected='Selected'; 
		}else if($arryBankAccountVal[$i]['DefaultAccount']==1){
			$selected='Selected';
		}

		?>
		<option value="<?=$arryBankAccountVal[$i]['BankAccountID']?>" <?=$selected?>>
		<?=$arryBankAccountVal[$i]['AccountName']?>  [<?=$arryBankAccountVal[$i]['AccountNumber']?>]</option>
		<? } ?>
	</select> 

		</td>
</tr>


                <tr>

	

	<!--td align="right" class="blackbold">GL Account :</td>
		<td align="left">

		<select name="AccountID" class="inputbox" id="AccountID">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arrySale[0]['AccountID']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select> 

	</td-->

		
		</tr>
	


<? if($arrySale[0]['EntryBy']=='C'  && $arrySale[0]['CardCharge']=='1'  && $arrySale[0]['OrderPaid']<=0 && empty($CardPaymentFailed)){  ?>
<tr>
	 <td  align="right" class="blackbold">Auto Card Charge  :</td>
        <td   align="left">
<span class="greenmsg">Yes</span>
  <input readonly type="hidden" name="CardCharge" id="CardCharge" value="<?=$arrySale[0]['CardCharge']?>">
	</td>

	 <td  align="right" class="blackbold">Auto Card Charge Date :</td>
        <td   align="left">
 

<select name="CardChargeDate" class="inputbox" id="CardChargeDate" style="width:60px;">
	<option value="0" >None</option>
	<?php		
	 for($i=1;$i<=31;$i++){?>
	<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
	<option value="<?=$prefix.$i;?>" <?php if($arrySale[0]['CardChargeDate'] == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
	<?php }?>
</select> 
             

		<strong><? #echo ($arrySale[0]['CardChargeDate']>0)?(date("jS", strtotime(date("Y-m-".$arrySale[0]['CardChargeDate'])))):(''); ?> day of month</strong>
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
 
                
		<td valign="top" align="right" class="blackbold">Reference No#  :</td>
		<td align="left" valign="top">
                    <input type="text" value="<?=stripslashes($arrySale[0]['SaleID'])?>" id="ReferenceNo" class="inputbox" name="ReferenceNo">
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

  <script>
shipCarrier();
</script>


<?php if (($arrySale[0]['ShippingAccountCustomer']==0 || $arrySale[0]['ShippingAccountCustomer']==1) && $_GET['edit']>0) { ?>
<tr id="shippingAccount"> <?php }else { ?>
<tr id="shippingAccount" style="display:none;"> <?php } ?>
	<td align="right" class="blackbold">Shipping Account Customer : </td>
	<td align="left">
	<select name="ShippingAccountCustomer" class="textbox" id="ShippingAccountCustomer" >
	<option <?php if($arrySale[0]['ShippingAccountCustomer']==0) echo "selected"; ?> value="0" > No </option>
	<option <?php if($arrySale[0]['ShippingAccountCustomer']==1) echo "selected"; ?> value="1" > Yes </option>
	</select>

	<?php if (!empty($arrySale[0]['ShippingAccountNumber']) && !empty($arrySale[0]['ShippingAccountCustomer'])) { ?>
		<span id="shippingAccountnumber"> 
	<?php }else { ?>
		<span id="shippingAccountnumber" style="display:none;" align="left"> 
	<?php } ?>

	<select class="inputbox" name="ShippingAccNO" id="ShippingAccNo" style="width: 145px;">
		<option>--- Select ---</option>
		<?php if(!empty($arryShipAccount)){ foreach($arryShipAccount as $vals) { ?>

		<option <?php if($vals['api_account_number']==$arrySale[0]['ShippingAccountNumber']) { echo "Selected"; } ?> value="<?=$vals['api_account_number']?>"><?=$vals['api_account_number']?></option>
		<?php } } ?>
		<option value="Add New" >Add New</option>
	</select> 

	<br>  <input class="inputbox" type="text" id="AddNewAcc" Name="AddNewAcc" placeholder="Enter Shipping Account Number" style="display:none;"><span id="errormessage"></span>  </span>  <input type="hidden" id="ShippingAccountAdjust" name="ShippingAccountAdjust" value="0" readonly> 




		</td>
		
</tr>



	<? if($EcommFlag==1 || $objConfig->isHostbillActive() ){ ?>
	<tr>

	
	<td  align="right" valign="top"class="blackbold">Order Source :<span class="red">*</span></td>
                 <td align="left" valign="top">
		  <select name="OrderSource" class="inputbox" id="OrderSource">
		  	<option value="">--- None ---</option>
				<?php for($i=0;$i<sizeof($arryOrderSource);$i++) {?>
                                    <option value="<?=$arryOrderSource[$i]['attribute_value']?>" <?  if($arryOrderSource[$i]['attribute_value']==$arrySale[0]['OrderSource']){echo "selected";}?>>
					<?=$arryOrderSource[$i]['attribute_value']?>
                                    </option>
			<? } ?>
		</select> 
		</td>
		<td  align="right"   class="blackbold" width="20%">Fees :  </td>
        <td   align="left" >

<input name="Fee" id="Fee" type="text" class="disabled" readonly style="width:90px;"  value="<?php echo $arrySale[0]['Fee']; ?>"  maxlength="20" />


</td>
	</tr>
	<? } ?>

	<tr>
	<td valign="top" align="right" class="blackbold">Invoice Comment :</td>
		<td align="left">
                    <textarea id="InvoiceComment" class="textarea" type="text" name="InvoiceComment"><?=stripslashes($arrySale[0]['InvoiceComment'])?></textarea></td>
	
		<!---- Abid ----->
<?php if($arryCurrentLocation[0]['country_id']==106){ ?>

<td valign="top" align="right" class="blackbold">Upload Document :</td>
		<td  align="left" valign="top" >
	<input name="UploadDocuments" type="file" class="inputbox" id="UploadDocuments" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
               	<?=SUPPORTED_SCAN_DOC?>
	<? 
        
	if(IsFileExist($Config['S_DocomentDir'], $arrySale[0]['UploadDocuments']) ){
 
	$OldUploadDocuments =  $arrySale[0]['UploadDocuments'];
 ?>
	<br><br>
	<input type="hidden" name="OldUploadDocuments" value="<?=$OldUploadDocuments?>">
	<div id="UploadDocumentsDiv">
	<?=$arrySale[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	
	<a href="../download.php?file=<?=$arrySale[0]['UploadDocuments']?>&folder=<?=$Config['S_DocomentDir']?>" class="download">Download</a> 
 

	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['S_DocomentDir']?>', '<?=$arrySale[0]['UploadDocuments']?>','UploadDocumentsDiv')"><?=$delete?></a>

	</div>
<?	} ?>
               
                </td>
	<?php } else{

echo '<input name="UploadDocuments" id="UploadDocuments" type="hidden" class="disabled" readonly style="width:90px;"  value=""  maxlength="20" />';


}?>
<!---- End Abid ------>
	</tr>


	
	<!--Start code by sachin-->
<?php 
$dwnPath='';
$checkval='';
$Showfile='display:none;';

$MainDir = $Config['FileUploadDir'].$Config['S_DocomentDir'];
if(!empty($getDocumentArry)){
	$Showfile='';
    $checkval="1";
}


?>
<tr>
	<td  align="right"   class="blackbold"></td>
	<td   align="left">
		<div style="<?=$Showfile?>" id="showfile">
			<div class="field_wrapper">
    <div>
			<input type="file" style="margin-top:5px;" name="FileName[]" class="FileName" />

			<a href="javascript:void(0);" class="add_button" style="margin:0px;" title="Add field">Add More</a>
			</div>
			<input type="hidden" name="validfileval" id="validfileval" value="0">  
</div>

	<?php
	if(!empty($getDocumentArry)){


	 
    foreach($getDocumentArry as $val) {
      if(!empty($val['FileName']) && IsFileExist($Config['S_DocomentDir'], $val['FileName'])){
    	 
    	
   
    	    	
    	   echo '<div class="IdProofDiv_'.$val['id'].'">'.stripslashes($val['FileName']).'&nbsp;<a href="../download.php?file='.$val['FileName'].'&folder='.$Config['S_DocomentDir'].'"   style="margin-top: 5px; display: inline-block;" class="download">Download File</a>';
	#echo '<input type="hidden" name="OldFile[]" readonly value="'.$MainDir.$val['FileName'].'">';
	?>
    	   
    	   <a href="Javascript:void(0);" style="margin-left: 5px;" onclick="Javascript:DeleteFileStorage('<?=$Config['S_DocomentDir']?>','<?=stripslashes($val['FileName'])?>','IdProofDiv','<?=$val['id']?>','<?=$_GET['ModuleName']?>','<?=$_GET['Module']?>')" ><?=$delete?></a></div>			
					<?php 



	 }
}
}
	?>   

		</div>

	</td>
	<td  align="right"   class="blackbold">Upload Document: </td>
	<td   align="left">
		<input style="margin-top: 5px;" class="checkbox"  type="checkbox" id="filecheck" name="filecheck" value="<?=$checkval?>" />
	</td>
	</tr>   
<!--End code by sachin-->


	</table>


<? 
$Action='VCard';  
$BoxPrefix = '../sales/'; 
include($BoxPrefix."includes/html/box/sale_card.php");

?>

<? include("../includes/html/box/confirm_shipping_account.php"); ?>

<script>
	
	function SelectCreditCard(){

		var PaymentTerm = $("#PaymentTerm").val().toLowerCase();
		/**********************/
		if(PaymentTerm == 'credit card'){
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
		/**********************/
		 
		if(PaymentTerm == 'prepayment'){
			 $("#BankAccountTR").show();	
		}else{
			 $("#BankAccountTR").hide();	  
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



		  jQuery("#PaymentTerm").change(function(){
			
			SelectCreditCard();
		  });










	});

	SelectCreditCard();
	
	</script>
