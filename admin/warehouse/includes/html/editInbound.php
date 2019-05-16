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

function validateEditForm(frm){
	 if(document.getElementById("InvoicePaid").checked == true){
		 if(!ValidateForSelect(frm.PaymentDate, "Payment Date")){
			return false;
		}
		 if(!ValidateForSelect(frm.InvPaymentMethod, "Payment Method")){
			return false;
		}
	 }	
	 
	 ShowHideLoader('1','S');
}







function validateForm(frm){


	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0; 
	var total_received=0; var total_qty_received=0;
	var to_return=0; var total_to_return=0;
	var total_returned=0; 

	var EditReturnID = Trim(document.getElementById("OrderID")).value;
	var EditReturnOrderID = Trim(document.getElementById("ReturnOrderID")).value;
	//alert(EditReturnID);

	if(EditReturnID>0){
		ShowHideLoader('1','S');
		return true;	
	}
     
	if(!ValidateForSelect(frm.warehouse, "Warehouse")){
			return false;
		}

    if(!ValidateForSelect(frm.RecieveDate, "Recieve Date")){
			return false;
		}

	var NumLine = parseInt($("#NumLine").val());
		
	
	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("item_id"+i) != null){
			qty_left = 0; qty = document.getElementById("qty"+i).value;
			total_received = document.getElementById("total_received"+i).value;
			total_returned = document.getElementById("total_returned"+i).value;
			
			to_return = total_received - total_returned;
		
			if(to_return > 0){

				if(!ValidateOptNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}			
				if(qty > to_return){
					alert("Qauntity must be be less than or equal to "+to_return+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}else{
					total_qty += +$("#qty"+i).val();
				}

				total_to_return += +to_return;
				
			}

			total_qty_received += +total_received;


		}
	}


	
	//if(total_qty_received<=0){
		//alert("No qauntities has been received for this order.");
		//return false;
	//}else
		
	if(total_to_return<=0){
		alert("No qauntities left to Receive for this order.");
		return false;
	}else if(total_qty<=0){
		alert("Please enter qauntity to Receive for any item.");
		return false;
	}




	if(ModuleVal!=''){
		var Url = "isRecordExists.php?RecieveID="+escape(ModuleVal)+"&editID=";
		SendExistRequest(Url,"RecieveID", "Recieve No");
		return false;	
	}else{
		ShowHideLoader('1','S');
		return true;	
	}
	
		
}
</script>

<? if(!empty($_GET['edit'])){ ?>
<form name="form1" action=""  method="post" onSubmit="return validateEditForm(this);" enctype="multipart/form-data">
<? }else{ ?>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<? } ?>

<? if(!empty($_SESSION['mess_return'])){?><div align="center" class="redmsg"><? echo $_SESSION['mess_return']; unset($_SESSION['mess_return']);?></div><? }?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
	 <td align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_view.php");?></td>
		</tr>
	</table>

</td>
</tr>
<tr>
    <td>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
				 <td colspan="2" align="left" class="head">Ship-To Address</td>

			</tr>
			<tr>
				<td  align="right" class="blackbold"> Warehouse Code  :<span class="red">*</span> </td>
				<td   align="left" >
					<select name="warehouse" id="warehouse" class="inputbox">
                                <option value="">Select Location</option>
                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                    <option value="<?= $arryWarehouse[$i]['warehouse_code'] ?>" <? if ($arryWarehouse[$i]['warehouse_code'] == $arryInbound[0]['warehouse']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                    </option>
<? } 


?>                                                     
                            </select>
				</td>
			</tr>
			<!--<tr>
				<td  align="right" class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
				<td   align="left" >
					<input name="warehouse_name" type="text" class="inputbox" id="receiving_number" value=""  maxlength="50" />
				</td>
			</tr>-->
			<tr>
				 <td colspan="2" align="left" class="head">Receive Information</td>
			</tr>
			

	<tr>
        <td  align="right"   class="blackbold" width="20%"> Receipt No# :<? if(empty($_GET['edit'])){ ?><span class="red">*</span><? }?> </td>
        <td   align="left" >
<? if(!empty($_GET['edit']) || !empty($arryPurchase[0]["RecieveID"]) ){ ?>
     <B><?=stripslashes($arryPurchase[0]["RecieveID"])?></B>

<? }else{ ?>
	<input name="RecieveID" type="text" class="datebox" id="RecieveID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','RecieveID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>
<? } ?>
</td>
      </tr>

			<tr>
				<td  align="right"   class="blackbold"> Transaction Ref  :<span class="red">*</span> </td>
				<td   align="left" >
				<input name="transaction_ref" type="text" class="disabled" id="transaction_ref" value="<?=$arryInbound[0]['transaction_ref']?>" size="14"  maxlength="50" />            </td>
		       </tr>  
			<tr>
				<td  align="right"   class="blackbold"> Receipt Date  :<span class="red">*</span> </td>
				<td   align="left" >
				<script type="text/javascript">
					$(function() {
						$('#RecieveDate').datepicker(
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
$RecieveDate = ($arryInbound[0]['RecieveDate']>0)?($arryInbound[0]['RecieveDate']):($arryTime[0]); 
?>
<input id="RecieveDate" name="RecieveDate" readonly="" class="datebox" value="<?=$RecieveDate?>"  type="text" >         </td>
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
              
         <td  align="right"   class="blackbold"> Status : </td>
		 <td   align="left" >
                     <select name="ReceiveStatus" id="ReceiveStatus" class="inputbox">
                         <option value="Parked" <?=($arryInbound[0]['RecieveStatus']=="Parked")?("Selected"):("")?>>Parked</option>     
                         <option value="Completed"  <?=($arryInbound[0]['RecieveStatus']=="Completed")?("Selected"):("")?>>Completed</option>   
                     </select>   
                 </td>
          </tr>	
		      
			  <tr>
			 	<td colspan="2" align="left"   class="head">Package Information</td>
			</tr>

			 <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" >
		    			<input name="packageCount" type="text" class="inputbox" id="packageCount" value="<?=$arryInbound[0]['packageCount']?>"  maxlength="50" />	<!--a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a-->
	          
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


			
			
			
				
				
		
			</table>
			</td>
			</tr>

<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Received Item
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$po?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
	<td align="left" >
		<? 	
	if(!empty($_GET['edit'])){
		include("includes/html/box/w_item_recieve_view.php");
	}else{
		include("includes/html/box/w_item_recieve.php");
	}

?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
<? if($HideSubmit!=1){ ?>	
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Process "  />
<? } ?>

<input type="hidden" name="InboundID" id="InboundID" value="<?=$arryInbound[0]['InboundID']?>" readonly />
<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['po']?>" readonly />
<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />


</td>
   </tr>
  
</table>

 </form>








<? } ?>



