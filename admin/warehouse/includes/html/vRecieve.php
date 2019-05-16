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
	 <td  width="40%" align="left"><? include("includes/html/box/return_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
    <td>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
				 <td colspan="5" align="left" class="head">Ship-From Address</td>

			</tr>
			<tr>
				<td  width="25%" align="right" class="blackbold"> Warehouse Code  :</td>
				<td   align="left" >
				<?=(!empty($arrySale[0]['warehouse_code']))?(stripslashes($arrySale[0]['warehouse_code'])):(NOT_SPECIFIED)?>
					


                                                     
                            
				</td>
			</tr>
			<!--<tr>
				<td  align="right" class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
				<td   align="left" >
					<input name="warehouse_name" type="text" class="inputbox" id="receiving_number" value=""  maxlength="50" />
				</td>
			</tr>-->
			<tr>
				 <td colspan="5" align="left" class="head">Ship Information</td>
			</tr>
			

	 

 <tr>
	<td  align="right"   class="blackbold" width="40%"> Ship No# : </td>
	<td align="left">
	<?php if(!empty($_GET['view'])){?>
	 <?=$arrySale[0]['RecieveID'];?>
	<?php } else {?>
	<input name="ReturnID" type="text" class="datebox" id="RecieveID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','RecieveID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>
	<?php }?>
	</td>

        <td  align="right"   class="blackbold" >Item Ship Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['view'])){
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
		<td  align="right"   class="blackbold" > Ship Amount Paid  : </td>
		<td><?=(!empty($arrySale[0]['RecievePaid']))?(stripslashes($arrySale[0]['RecievePaid'])):(NOT_SPECIFIED)?> </td>
	
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left"><?=(!empty($arrySale[0]['RecieveComment']))?(stripslashes($arrySale[0]['RecieveComment'])):(NOT_SPECIFIED)?>
	        
		</td>
	<tr>
         <td  align="right"   class="blackbold"> Mode of Transport  : </td>
		 <td   align="left" ><?=(!empty($arrySale[0]['transport']))?(stripslashes($arrySale[0]['transport'])):(NOT_SPECIFIED)?>
		 
		    </td>
          </tr>			   
		      
			  <tr>
			 	<td colspan="5" align="left"   class="head">Package Information</td>
			</tr>

			 <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" ><?=(!empty($arrySale[0]['packageCount']))?(stripslashes($arrySale[0]['packageCount'])):(NOT_SPECIFIED)?>
		    		          
				</td>
			
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" ><?=(!empty($arrySale[0]['PackageType']))?(stripslashes($arrySale[0]['PackageType'])):(NOT_SPECIFIED)?>
				
				</td>
				</tr> 
                                <tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" ><?=(!empty($arrySale[0]['Weight']))?(stripslashes($arrySale[0]['Weight'])):(NOT_SPECIFIED)?>
		    			   
				</td>
			</tr>


			
		
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
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
		<?php include("includes/html/box/so_item_return.php");?>
	<?php } else {?>
	<?php include("includes/html/box/so_item_return_view.php");?>
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
		
		<input type="hidden" name="RecieveOrderID" id="RecieveOrderID" value="<?=$RecieveSo?>" readonly />
		<input type="hidden" name="InvoiceID" id="InvoiceID" value="<?=$_GET['InvoiceID']?>" readonly />
	
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$ReturnSo?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



