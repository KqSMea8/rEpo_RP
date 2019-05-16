
<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?php echo "RMA";?>  <span>&raquo; <?=$ModuleName?></span>
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
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">RMA Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> RMA No# : </td>
	<td align="left" width="30%" valign="top">
	<?php if(!empty($_GET['rtn'])){?>
	 <?=$arrySale[0]['ReturnID'];?>
	<?php } else {?>
	<input name="ReturnID" type="text" class="datebox" id="ReturnID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ReturnID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Item RMA Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['rtn'])){
	$arryTime = explode(" ",$Config['TodayDate']);
	$ReturnDate = ($arrySale[0]['ReturnDate']>0)?($arrySale[0]['ReturnDate']):($arryTime[0]); 
	echo $ReturnDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#ReturnDate').datepicker(
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
$ReturnDate = ($arrySale[0]['ReturnDate']>0)?($arrySale[0]['ReturnDate']):($arryTime[0]); 
?>
<input id="ReturnDate" name="ReturnDate" readonly="" class="datebox" value="<?=$ReturnDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
 
	<tr>
		<td  align="right"   class="blackbold" > RMA Amount Paid  : </td>
		<td   align="left">	<input type="checkbox" name="ReturnPaid" value="Yes" <?=($arrySale[0]['ReturnPaid'] == "Yes")?("checked"):("")?>></td>
	
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		 	<input name="ReturnComment" type="text" class="inputbox" id="ReturnComment" value="<?php echo stripslashes($arrySale[0]['ReturnComment']); ?>"  maxlength="100" />          
		</td>
	</tr>
	
	<tr>

	<td  align="right" class="blackbold">Action	:</td>
	<td align="left">
		<select name="Module" class="inputbox" id="Module">
		<option value="Return" <?php if($arrySale[0]['Module']=='Return'){ echo "selected='selected'";}?>>Return</option>
		<option value="Credit" <?php if($arrySale[0]['Module']=='Credit'){ echo "selected='selected'";}?>>Credit</option>
		</select>
	</td>
	</tr>
	
	
	<?php if(!empty($_GET['rtn'])){?>
		<tr>
			<td align="right"></td>
			<td align="left"> 
			<input type="hidden" name="rtnID" id="rtnID" value="<?=$_GET['rtn']?>" readonly />
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Save">
			
			</td>
		</tr>
	<?php }?>

</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/cust_credit_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_rm_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_rma_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?php
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" ><?=RETURN_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="vSalesQuoteOrderCredit.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
		<?php include("includes/html/box/so_item_cust_credit.php");?>
	<?php } else {?>
	<?php include("includes/html/box/so_item_cust_credit_view.php");?>
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
		<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['edit']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



