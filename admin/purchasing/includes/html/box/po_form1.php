<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var NumLine = parseInt($("#NumLine").val());
		
	var ModuleField = '<?=$ModuleID?>';
	var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;

	if(ModuleVal!=''){
		if(!ValidateMandRange(document.getElementById(ModuleField), "<?=$ModuleIDTitle?>",3,20)){
			return false;
		}
	}

	if( ValidateForSelect(frm.OrderDate, "Order Date")
		&& ValidateForSelect(frm.SuppCode, "Vendor")
		&& ValidateForSimpleBlank(frm.SuppCompany, "Company Name")
		&& ValidateForSimpleBlank(frm.Address, "Address")
		&& ValidateForSimpleBlank(frm.City, "City")
		&& ValidateForSimpleBlank(frm.State, "State")
		&& ValidateForSimpleBlank(frm.Country, "Country")
		&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		&& ValidateForSimpleBlank(frm.SuppContact, "Contact Name")
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmail(frm.Email)
	){
		
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
				

			}
		}



	
		if(ModuleVal!='' && OrderID==''){
			var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
			SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
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
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Order Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" >
<? if(!empty($_GET['edit'])) {?>
	<input name="<?=$ModuleID?>" type="text" class="disabled" readonly style="width:90px;" id="<?=$ModuleID?>" value="<?php echo stripslashes($arryPurchase[0][$ModuleID]); ?>"  maxlength="20" />
<? }else{?>
	<input name="<?=$ModuleID?>" type="text" class="datebox" id="<?=$ModuleID?>" value="<?php echo stripslashes($arryPurchase[0][$ModuleID]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','<?=$ModuleID?>','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_ModuleID"></span>
<? } ?>

</td>
      </tr>





  <tr>
        <td  align="right"   class="blackbold" >Order Date  :<span class="red">*</span> </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#OrderDate').datepicker(
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
$OrderDate = ($arryPurchase[0]['OrderDate']>0)?($arryPurchase[0]['OrderDate']):($arryTime[0]); 
?>
<input id="OrderDate" name="OrderDate" readonly="" class="datebox" value="<?=$OrderDate?>"  type="text" > 


</td>
      </tr>
<? if($_GET['edit']>0){ ?>
<tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryPurchase[0]['Approved'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryPurchase[0]['Approved'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Approved" id="Approved" value="1" <?=$ActiveChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Approved" id="Approved" value="0" <?=$InActiveChecked?> />
          No </td>
      </tr>
<? } ?>

<tr>
        <td  align="right"   class="blackbold" >Order Status  : </td>
        <td   align="left" >
		<? if($_GET['edit']>0){
			  $Status = $arryPurchase[0]['Status'];
		?>
		<input type="checkbox" name="Closed" value="1" <?=($arryPurchase[0]['Closed']==1)?("checked"):("")?>> Close
        <? }else{
			$Status = "New";
			echo  "New ".$ModuleName;
		}?>

		<input type="hidden" name="Status" id="Status" value="<?=$Status?>" />
           </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" > Drop Ship  : </td>
        <td   align="left" >
		<input type="checkbox" name="DropShip" value="1" <?=($arryPurchase[0]['DropShip']==1)?("checked"):("")?>> 
    
           </td>
      </tr>


  <tr>
        <td  align="right"   class="blackbold" > Delivery Date  : </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#DeliveryDate').datepicker(
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
$DeliveryDate = ($arryPurchase[0]['DeliveryDate']>0)?($arryPurchase[0]['DeliveryDate']):(''); 
?>
<input id="DeliveryDate" name="DeliveryDate" readonly="" class="datebox" value="<?=$DeliveryDate?>"  type="text" > 


</td>
      </tr>

	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arryPurchase[0]['Comment']); ?>"  maxlength="100" onkeypress="return isAlphaKey(event);"/>          
		</td>
	</tr>


</table>

	 </td>
</tr>


<tr>
	<td align="left" valign="top" width="50%"><? include("includes/html/box/po_supp_form.php");?></td>
	<td align="left" valign="top"><? include("includes/html/box/po_warehouse_form.php");?></td>
</tr>



<tr>
	 <td colspan="2" align="left" class="head" >Line Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/po_item_form.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="OrderType" id="OrderType" value="<?=$module?>" />

<input type="hidden" name="ModuleID" id="ModuleID" value="<?=$ModuleID?>" />
<input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />


</td>
   </tr>
  
</table>

 </form>
