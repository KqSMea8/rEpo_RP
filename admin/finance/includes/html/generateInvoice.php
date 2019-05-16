<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	
	
	<?  

	if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="viewInvoice.php?key='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}

?>
	<div class="had">
	<?=$MainModuleName?><span> &raquo; <?=GENERATE_INVOICE;?></span>
	</div>
		
	  <? 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	



?>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleField = '<?=$ModuleID?>';
	//alert(ModuleField);return false;
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
        //var EntryType = Trim(document.getElementById("EntryType")).value;
        
       /*  if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                }*/
                
	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById(ModuleField), "<?=$ModuleIDTitle?>",3,20)){
			return false;
		}
	}

var totalSum = 0;var remainQty=0;var inQty=0;
var evaluationType=''; var DropshipCheck='0';
var serial_value = ''; var className='';


		//alert('a'+NumLine);return false;
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
                                 
                                 className = $('#qty'+i).attr('class');
 
                                 
				 remainQty = document.getElementById("remainQty"+i).value;
				 inQty = document.getElementById("qty"+i).value;
				 evaluationType = document.getElementById("evaluationType"+i).value;
				 totalSum += inQty;
				if(className!='disabled' && parseInt(remainQty) < parseInt(inQty))
				 {
					//alert("Invoice Qty Should be Less Than Or Equal To Ordered Qty.");
					alert("Invoice qauntity must be be less than or equal to "+remainQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				 }
					
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}
                                
                 if(parseInt(seriallength) != parseInt(inQty) && (evaluationType == 'Serialized' || evaluationType == 'Serialized Average') && DropshipCheck != 1 && parseInt(inQty) > 0 && parseInt(inQty) !='')
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
	
		if(ModuleVal!=''){
			var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
			SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	
		
}
</script>




 <script>


				$(document).ready(function () {
							$('#FillAllQty').change(function () {
										var NumLine = parseInt($("#NumLine").val());
										for(var i=1;i<=NumLine;i++){
													var ordered_qty = $("#ordered_qty"+i).val();
													if (!this.checked) {
													
															$("#qty"+i).val('');
															$("#qty"+i).trigger("keyup");
															calculateGrandTotal();
													}else{ 
															$("#qty"+i).val(ordered_qty) ;
															$("#qty"+i).trigger("keyup");
													 }

										}
							});

				});



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
 

<div class="message" align="center"><? if(!empty($_SESSION['mess_gen'])) {echo $_SESSION['mess_gen']; unset($_SESSION['mess_gen']); }

if (!empty($errMsg)) {
	echo $errMsg;
}


?></div>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
 
 <tr>
	 <td align="left"><? include("includes/html/box/generate_invoice_form.php");?></td>
</tr>
</tr>

<tr>
	<td align="left">
	<? include("../includes/html/box/shipping_info.php");?>
	</td>
</tr>

<tr>
	 <td align="left"><? 
$SpiffSaleID = $arrySale[0]['SaleID'];
include("includes/html/box/sales_order_view.php");?></td>
</tr>

<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td align="left" valign="top"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" ></td>
		</tr>
		<tr>
	<td align="left" >
			 <input type="checkbox" name="FillAllQty" id="FillAllQty" class="textbox" value="1"/> <span class="heading">Fill All Quantity</span>
			</td>
			<td align="right" >
				<?

$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
			</td>
		</tr>
		</table>	

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
				<? 	include("includes/html/box/sales_order_item_invoice.php");?>
			</td>
		</tr>
		</table>	
    
	
	</td>
   </tr>

  
	<tr>
		<td  align="center">
	    	         <input type="hidden" name="GenerateInVoice" id="GenerateInVoice" value="<?=$_GET['invoice']?>" />
			<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['invoice']?>" />
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
			
		</td>
	</tr>
  
</table>

 </form>

<? } ?>


