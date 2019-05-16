<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
</div>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
#include("includes/html/box/po_recieve.php");

?>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleField = '<?=$ModuleID?>';
	//alert(ModuleField);return false;
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;
	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById(ModuleField), "<?=$ModuleIDTitle?>",3,20)){
			return false;
		}
	}
	
	if(ModuleVal!='' && OrderID!=''){
		var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
		SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
		return false;	
	}

var totalSum = 0;var remainQty=0;var inQty=0;
		for(var i=1;i<=NumLine;i++){
		
				/*if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}*/
				 
				 remainQty = document.getElementById("remainQty"+i).value;
				 inQty = document.getElementById("qty"+i).value;
				 totalSum += inQty;
				if(parseInt(remainQty) < parseInt(inQty))
				 {
					//alert("Return Qty Should be Less Than Or Equal To Invoice Qty.");
					alert("Return qauntity must be be less than or equal to "+remainQty+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				 }
					
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}
				

			
		}
		//alert(totalSum);return false;
  	    totalSum = parseInt(totalSum, 10);
		if(totalSum == 0)
		{
		  alert("Return qty should not be blank.");
		  document.getElementById("qty1").focus();
		  return false;
		}else{
			ShowHideLoader('1','S');
			return true;	
		}
	

	
		
}
</script>

<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
	 <td align="left"><? include("includes/html/box/transfer_order_view.php");?></td>
</tr>




<tr>
    <td >
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >

			
			<tr>
				 <td colspan="2" align="left" class="head">Receive Information</td>
			</tr>
			

	 

 <tr>
	<td  align="right" width="45%"   class="blackbold" width="20%"> Receive No# : </td>
	<td align="left">
	<?php if(!empty($_GET['rtn'])){?>
	 <?=$arrySale[0]['RecieveID'];?>
	<?php } else {?>
	<input name="ReturnID" type="text" class="datebox" id="RecieveID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','RecieveID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>
	<?php }?>
	</td>
   </tr>
 
 <tr>
        <td  align="right"   class="blackbold" >Item Receive Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['rtn'])){
	$arryTime = explode(" ",$Config['TodayDate']);
	$ReturnDate = ($arrySale[0]['RecieveDate']>0)?($arrySale[0]['RecieveDate']):($arryTime[0]); 
	echo $ReturnDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#RecieveDate').datepicker(
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
$ReturnDate = ($arrySale[0]['RecieveDate']>0)?($arrySale[0]['RecieveDate']):($arryTime[0]); 
?>
<input id="RecieveDate" name="RecieveDate" readonly="" class="datebox" value="<?=$ReturnDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
 
	
 	<tr>
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		 <input name="RecieveComment" type="text" class="inputbox" id="RecieveComment" value="<?php echo stripslashes($arrySale[0]['RecieveComment']); ?>"  maxlength="100" />          
		</td>
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
		  		<td align="right"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" >
		    			<input name="packageCount" type="text" class="inputbox" id="packageCount" value="<?=$arryInbound[0]['packageCount']?>"  maxlength="50" /><span>	<a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a></span>		          
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
		    			<input name="Weight" type="text" class="inputbox" id="Weight" value="<?=$arryInbound[0]['Weight']?>"  maxlength="50" />	          
				</td>
			</tr>


			<tr>
			 	<td colspan="2" align="left"   class="head">Charges</td>
			</tr>

			 <tr>
		  		<td align="right"   class="blackbold" valign="top">Charge :</td>
		  		<td  align="left" >
		    			<select name="charge" id="charge" class="inputbox">
                                <option value="">Select Charge</option>
		    			 <? for ($i = 0; $i < sizeof($arryCharge ); $i++) { ?>
                                    <option value="<?= $arryCharge[$i]['attribute_value'] ?>" <? if ($arryCharge[$i]['attribute_value'] == $arryInbound[0]['charge']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryCharge[$i]['attribute_value'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>			          
				</td>
			</tr> <tr>
		  		<td align="right"   class="blackbold" valign="top">Currency :</td>
		  		<td  align="left" >
		    			<input name="Currency" type="text" class="inputbox" id="Currency" value="<?=$arryInbound[0]['Currency']?>"  maxlength="50" />			          
				</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Description :</td>
		  		<td  align="left" >
		    			<textarea name="Description" type="text" class="inputbox" id="Description" maxlength="50" /><?=stripslashes($arryInbound[0]['Description'])?>	</textarea>		          
				</td>
			</tr>
			 <tr>
		  		<td align="right"   class="blackbold" valign="top">Apply To :</td>
		  		<td  align="left" >
		    			<input name="apply_to" type="text" class="inputbox" id="apply_to" value="<?=$arryInbound[0]['apply_to']?>"  maxlength="50" />			          
				</td>
				<tr>
				 <tr>
		  		<td align="right"   class="blackbold" valign="top">Price :</td>
		  		<td  align="left" >
		    			<input name="Price" type="text" class="inputbox" id="Price" value="<?=$arryInbound[0]['Price']?>"  maxlength="50" />			          
				</td>
				<tr>
				 <tr>
		  		<td align="right"   class="blackbold" valign="top">Paid As :</td>
		  		<td  align="left" >
		    			<select name="PaidAs" id="PaidAs" class="inputbox">
                                <option value="">Select Paid</option>
		    			 <? for ($i = 0; $i < sizeof($arryPaid ); $i++) { ?>
                                    <option value="<?=$arryPaid[$i]['attribute_value'] ?>" <? if ($arryPaid[$i]['attribute_value'] == $arryInbound[0]['PaidAs']) {
                                    echo "selected";
                                } ?>>
                                    <?=$arryPaid[$i]['attribute_value'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>			          
				</td>
				<tr>
				 <tr>
		  		<td align="right"   class="blackbold" valign="top">Ammount :</td>
		  		<td  align="left" >
		    			<input name="ammount" type="text" class="inputbox" id="ammount" value="<?=$arryInbound[0]['amount']?>"  maxlength="50" />			          
				</td>
				<tr>
		
			</table>
			</td>
			</tr>
<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arrySale[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" ><?=RETURN_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>



	 </td>
</tr>

<tr>
	<td align="left">
	<? if($HideSubmit!=1){ ?>	
		<?php include("includes/html/box/adjustment_item_return.php");?>
	<?php } else {?>
	<?php include("includes/html/box/adjustment_item_return_view.php");?>
	<?php }?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
		<? } ?>
		<?php if(empty($_GET['rtn'])){?>
		<input type="hidden" name="RecieveOrderID" id="RecieveOrderID" value="<?=$_GET['edit']?>" readonly />
		<input type="hidden" name="InvoiceID" id="InvoiceID" value="<?=$_GET['InvoiceID']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



