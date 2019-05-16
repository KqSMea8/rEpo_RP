
<a href="<?=$RedirectURL?>" class="back">Back</a>



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
	var NumLine = parseInt($("#NumLine").val());
		
	
	var transferID = Trim(document.getElementById("transferID")).value;

	

	if( ValidateForSelect(frm.from_WID, "Transfer from Location ")
        && ValidateForSelect(frm.to_WID, "Transfer to Location")
		&& ValidateForSelect(frm.transfer_reason, "Transfer Reason")
		
	){
	
            
            if(document.getElementById("from_WID").value == document.getElementById("to_WID").value){
                alert("Transfer Location is same .Please select diffrent Location.")
                return false;
            }
		for(var i=1;i<=NumLine;i++){
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
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}
                                
                                //if(document.getElementById("on_hand_qty"+i).value != document.getElementById("qty"+i).value){
                                    
                                     //alert("Not Enough Quantity on Hand .Please Enter Corroct Quantity.");
                                     
                                     //document.getElementById("qty"+i).focus();
                                        //return false;
                                //}
                                    
                              }
				

			}
		
                



	
		 
			ShowHideLoader('1','S');
			return true;	
		

	}else{
		return false;	
	}	
		
}
</script>




 <script>
$(function() {
	var ModuleID = '';
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
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Transfer Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
      <tr>
		<td  align="right"   class="blackbold" > Transfer From Location:  <span class="red">*</span> </td>
		<td   align="left">
		<!--<input  name="warehouse" id="warehouse" value="" readonly="readonly" type="text" class="disabled"  maxlength="30" />-->	
		<!--<input  name="WID" id="WID" value="" type="hidden"  class="inputbox"  maxlength="30" />	-->
		<select name="from_WID" id="from_WID" class="inputbox">
		<option value="">Select Transfer Location</option>
		<? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
		<option value="<?= $arryWarehouse[$i]['WID'] ?>" <? if ($arryWarehouse[$i]['WID'] == $arryTransfer[0]['from_WID']) {
		echo "selected";
		} ?>>
		<?= $arryWarehouse[$i]['warehouse_name'] ?>
		</option>
		<? } ?>                                                     
		</select>

		<!--<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?= $search ?></a>--></td>
                    </tr>
<tr>
                        <td align="right"   class="blackbold" > Transfer To Location:  <span class="red">*</span> </td>
                        <td  align="left">
                        <!--<input  name="warehouse" id="warehouse" value="" readonly="readonly" type="text" class="disabled"  maxlength="30" />-->	
                        <!--<input  name="WID" id="WID" value="" type="hidden"  class="inputbox"  maxlength="30" />	-->
                            <select name="to_WID" id="to_WID" class="inputbox">
                                <option value="">Select Transfer Location</option>
                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                    <option value="<?= $arryWarehouse[$i]['WID'] ?>" <? if ($arryWarehouse[$i]['WID'] == $arryTransfer[0]['to_WID']) {
                                    echo "selected";
                                } ?>>
                                    <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                    </option>
<? } ?>                                                     
                            </select>

<!--<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?= $search ?></a>--></td>
                    </tr>
                    <tr>
                        <td align="right"   class="blackbold" >Transfer Reason:  <span class="red">*</span> </td>
                        <td  align="left">

                            <select name="transfer_reason" id="transfer_reason" class="inputbox">
                                <option value="">Select Transfer Reason</option>
                                    <? for ($i = 0; $i < sizeof($arryReason); $i++) { ?>
                                    <option value="<?= $arryReason[$i]['attribute_value'] ?>" <? if ($arryReason[$i]['attribute_value'] == $arryTransfer[0]['transfer_reason']) {
                                        echo "selected";
                                    } ?>>
    <?= $arryReason[$i]['attribute_value'] ?>
                                    </option>
<? } 




?>                                                     
                            </select>
                        </td>
                    </tr>

<tr>
        <td  align="right"   class="blackbold" >Transfer Status  : </td>
        <td   align="left" >

		<? if(empty($_GET['edit'])){ $checked="selected";}?>
			<select name="Status" id="Status" class="inputbox">
				<option value="1"  <? if ( $arryTransfer[0]['Status']=='1') {echo "selected";} ?>>Parked</option>
				<option value="2" <? if ( $arryTransfer[0]['Status']=='2') { echo "selected"; } ?>>Completed</option>
				   
			</select>

		
           </td>
      </tr>



</table>

	 </td>
</tr>






<tr>
	 <td colspan="2" align="right">
<?

//$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>
<tr>
	 <td colspan="2" align="left" class="head" >Transfer Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/transfer_item_form.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  <? 
$disNone="";
if($_GET['edit'] >0) { if ( $arryTransfer[0]['Status']==2 ||  $arryTransfer[0]['Status']==0) { $disNone="style='display:none;'"; } else{ $disNone=""; } }?>

   <tr <?=$disNone?>>
    <td  align="center">
	
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="transferID" id="transferID" value="<?=$_GET['edit']?>" />




<input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />



</td>
   </tr>
  
</table>

 </form>


<? } ?>

<? 
echo '<script>SetInnerWidth();</script>'; ?>



