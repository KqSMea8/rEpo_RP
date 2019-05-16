<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<? if(empty($ErrorMSG)){?>
	<!--<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>-->
	<!--a href="<?=$EditUrl?>" class="edit">Edit</a -->
	<? } ?>
	<!--<a href="<?//=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>-->
<? 
	
/*
	if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="viewInvoice.php?po='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}
	*/

?>
	<div class="had">
	<?=$MainModuleName?><span> &raquo; <?=CREATE_SHIPPING;?></span>
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
		
	var ModuleVal = 1;

var totalSum = 0;var remainQty=0;var inQty=0;
		for(var i=1;i<=NumLine;i++){
		
				/*if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}*/
				 remainQty = document.getElementById("ordered_qty"+i).value;
				 inQty = document.getElementById("pickQty"+i).value;
				 totalSum += inQty;
				if(parseInt(remainQty) != parseInt(inQty))
				 {
					//alert("Invoice Qty Should be Less Than Or Equal To Ordered Qty.");
					alert("Pick qauntity must  be  equal to "+remainQty+" for this item.");
					document.getElementById("pickQty"+i).focus();
					return false;
				 }
					
				
				if(inQty == '' || inQty == 0){
                  alert("pick qty should not be blank.");
		          document.getElementById(inQty).focus();
		          return false;
				}		

			
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

<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
 
 <tr>
	 <td align="left"><? include("includes/html/box/ship_invoice_form.php");?></td>
</tr>
</tr>

<tr>
	 <td align="left"><? include("../sales/includes/html/box/sales_order_view.php");?></td>
</tr>

<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("../sales/includes/html/box/sale_order_billto_view.php");?></td>
			<td align="left" valign="top"><? include("../sales/includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>

<tr>
	 <td colspan="2" align="left" class="head">Shipping Information</td>
</tr>
<tr>
	 <td colspan="2" align="left">
<table width="100%" border="0" cellpadding="5" cellspacing="0">	
<tr>
				<td  align="right"   class="blackbold"> Transaction Ref  :<span class="red">*</span> </td>
				<td   align="left" >
				<input name="transaction_ref" type="text" class="disabled" id="transaction_ref" value="<?=$transferNo?>" size="14"  maxlength="50" />            </td>
		       </tr>  
			<tr>
				<td  align="right"   class="blackbold"> Ship Date  :<span class="red">*</span> </td>
				<td   align="left" >
				<script type="text/javascript">
					$(function() {
						$('#ShipDate').datepicker(
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
$ShipDate = ($arryShip[0]['ShipDate']>0)?($arryShip[0]['ShipDate']):($Config['TodayDate']); 
?>
<input id="ShipDate" name="ShipDate" readonly="" class="datebox" value="<?=$ShipDate?>"  type="text" >         </td>
		       </tr>  

<tr>
         <td  align="right"   class="blackbold"> Mode of Transport  : </td>
		 <td   align="left" ><select name="transport" id="transport" class="inputbox">
                                <option value="">Select Transport</option>
                                <? for ($i = 0; $i < sizeof($arryTrasport); $i++) { ?>
                                    <option value="<?= $arryTrasport[$i]['attribute_value'] ?>" <? if ($arryTrasport[$i]['attribute_value'] == $arryInbound[0]['transport']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryTrasport[$i]['attribute_value'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>   </td>
          </tr>			   
		      
			  <tr>
			 	<td colspan="2" align="left"   class="head">Package Information</td>
			</tr>

			 <tr>
		  		<td align="right" width="45%"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" >
		    			<input name="packageCount" type="text" class="textbox" size="10" id="packageCount" value="<?=$arryInbound[0]['packageCount']?>"  maxlength="50" /><!--span>	<a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a></span-->		          
				</td>
			</tr> <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" >
				<select name="PackageType" id="PackageType" class="inputbox">
                                <option value="">Select Package Type</option>
		    			 <? for ($i = 0; $i < sizeof($arryPackageType); $i++) { ?>
                                    <option value="<?= $arryPackageType[$i]['attribute_value'] ?>" <? if ($arryPackageType[$i]['attribute_value'] == $arryInbound[0]['PackageType']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryPackageType[$i]['attribute_value'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>		          
				</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<input name="Weight" type="text" size="10" class="textbox" id="Weight" value="<?=$arryInbound[0]['Weight']?>"  maxlength="50" />	          
				</td>
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
				<? 	include("includes/html/box/sales_ship_item_invoice.php");?>
			</td>
		</tr>
		</table>	
    
	
	</td>
   </tr>

  
	<tr>
		<td  align="center">
	    	<input type="hidden" name="ShipInVoice" id="ShipInVoice" value="<?=$_GET['shipid']?>" />
			<input type="hidden" name="shipID" id="shipID" value="" />
			<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['so']?>" />
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
			
		</td>
	</tr>
  
</table>

 </form>

<? } ?>


