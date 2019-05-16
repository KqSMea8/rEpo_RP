<? if($_GET['pop']!=1){ ?>



<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());
	
	var OrderID = Trim(document.getElementById("OrderID")).value;
        var EntryType = Trim(document.getElementById("EntryType")).value;
         var ModuleVal = Trim(document.getElementById("SaleInvoiceID")).value;

	if(ModuleVal!='' || OrderID>0 ){
		if(!ValidateMandRange(document.getElementById("SaleInvoiceID"), "Invoice Number",3,20)){
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
                }
  

var totalSum = 0;var remainQty=0;var inQty=0;
var evaluationType=''; var DropshipCheck='0';
var serial_value = '';

		for(var i=1;i<=NumLine;i++){
		
				/*if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}*/
                                
                                 DropshipCheck = document.getElementById("DropshipCheck"+i).value;
                                 serial_value = document.getElementById("serial_value"+i).value;
                                 var seriallength=0;
                                 if(serial_value != ''){
                                    var resSerialNo = serial_value.split(",");
                                    var seriallength = resSerialNo.length;
                                 }
                                 
                                
                                 
				 remainQty = document.getElementById("remainQty"+i).value;
				 inQty = document.getElementById("qty"+i).value;
				 evaluationType = document.getElementById("evaluationType"+i).value;
				 totalSum += inQty;
				if(parseInt(remainQty) < parseInt(inQty))
				 {
					//alert("Invoice Qty Should be Less Than Or Equal To Ordered Qty.");
					alert("Invoice qauntity must be be less than or equal to "+remainQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				 }
					
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}
                                
                                if(parseInt(seriallength) != parseInt(inQty) && evaluationType == 'Serialized' && DropshipCheck != 1 && parseInt(inQty) > 0)
                                    {
                                        alert("Please add "+inQty+" serial number.");
					document.getElementById("qty"+i).focus();
					return false;
                                    }
				

			
		}
		
  	    totalSum = parseInt(totalSum, 10);
		if(totalSum == 0)
		{
		  alert("Invoice qty should not be blank.");
		  document.getElementById("qty1").focus();
		  return false;
		}
	
		

		var Url = 'isRecordExists.php?SaleInvoiceID='+escape(ModuleVal)+'&editID='+OrderID;
		SendExistRequest(Url,SaleInvoiceID, "Invoice Number");
		return false;	

	
		
}
</script>


<!--a href="#" onClick="pop('mrgn')" class="edit">Margin</a-->
<a href="<?=$RedirectURL?>" class="back">Back</a>
	
<div class="had"><?=$MainModuleName?>    <span>&raquo;	<?=$ModuleName?> </span></div>	

	<div class="message" align="center"><? if(!empty($_SESSION['mess_Invoice'])) {echo $_SESSION['mess_Invoice']; unset($_SESSION['mess_Invoice']); }?></div>

<? 
}	
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	
?>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

 <tr>
	 <td align="left"><? include("includes/html/box/generate_invoice_form.php");?></td>
</tr>
 <tr>
	<td align="left">
		<? include("../includes/html/box/shipping_info.php");?>
	</td>
</tr>
 
<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("../sales/includes/html/box/sale_order_billto_form.php");?></td>
			<td align="left" valign="top"><? include("../sales/includes/html/box/sale_order_shipto_form.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?

$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" colspan="2">
				<? 	//include("includes/html/box/sales_order_item_invoice.php");?>
<? include("includes/html/box/sale_order_item_form.php");?>
			</td>
		</tr>
		
		</table>	
    
	
	</td>
   </tr>

  <tr>
		<td  align="center">
	    	        
			<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
			
		</td>
	</tr>

  
</table>

  </form>

<?php 
	
} ?>


<div id="mrgn"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn"><i class="fa fa-times" aria-hidden="true"></i></div>
<div class="popup-header">Invoice Margin</div>
<?php 

$subtotal = round($subtotal*$arrySale[0]['ConversionRate'],2);
$costofgood = round($costofgood*$arrySale[0]['ConversionRate'],2);
$Freight = round($Freight*$arrySale[0]['ConversionRate'],2);
$Commition[0]['CommPercentage'] = round($Commition[0]['CommPercentage']*$arrySale[0]['ConversionRate'],2);


$arrySale[0]['Fee'] = round($arrySale[0]['Fee']*$arrySale[0]['ConversionRate'],2);

$crfees = round($crfees*$arrySale[0]['ConversionRate'],2);
echo '<br><b>Sub Total</b> : '.number_format($subtotal,2);

echo '<br><br><b>Cost of Good </b>: '.number_format($costofgood,2);
echo '<br><br><b>Freight </b>: '.number_format($Freight,2);
$Grossprofit = $subtotal+$Freight - $costofgood; 
echo '<br><br><b>Gross profit </b>: '.number_format($Grossprofit,2);

//echo $Commition[0]['CommPercentage'];
echo '<br><br>-----------------------------------------------';
 $sale_comm = ($Commition[0]['CommPercentage'] / 100) * $Grossprofit;

echo '<br><br><b>Fees(amazon/ebay fees)</b>: '.number_format($arrySale[0]['Fee'],2);
echo '<br><br><b>Credit card fee </b>: '.number_format($crfees,2);

echo '<br><br><b>Sales Commision</b> : '.number_format($sale_comm,2);
echo '<br><br>-----------------------------------------------';
$totFee = $arrySale[0]['Fee']+$sale_comm+$crfees;

$Netprofit = $Grossprofit -$totFee;
echo '<br><b>Net profit </b>: '.number_format($Netprofit,2);

//echo 'CommPercentage';
?>
</div></div>

