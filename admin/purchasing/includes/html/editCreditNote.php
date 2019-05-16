
<a href="<?=$RedirectURL?>" class="back">Back</a>

<? 
	/*if($arryPurchase[0]['CreditID']!='' ){ 
		$TotalInvoice=$objPurchase->CountInvoices($arryPurchase[0]['CreditID']);
		if($TotalInvoice>0)
			echo '<a href="viewRefund.php?po='.$arryPurchase[0]['CreditID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}
*/
?>

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
		
	var CreditIDVal = Trim(document.getElementById("CreditID")).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;

	if(CreditIDVal!=''){
		if(!ValidateMandRange(document.getElementById("CreditID"), "Credit Note ID",3,20)){
			return false;
		}
	}

	if( ValidateForSelect(frm.ClosedDate, "Expiry Date")
		&& ValidateForSelect(frm.SuppCode, "Vendor")
		&& ValidateForSimpleBlank(frm.SuppCompany, "Company Name")
		&& ValidateForSimpleBlank(frm.Address, "Address")
		&& ValidateForSimpleBlank(frm.City, "City")
		&& ValidateForSimpleBlank(frm.State, "State")
		&& ValidateForSimpleBlank(frm.Country, "Country")
		&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidateForSimpleBlank(frm.SuppContact, "Contact Name")
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateOptPhoneNumber(frm.Landline,"Landline Number")
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		&& isEmailOpt(frm.wEmail)
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



	
		if(CreditIDVal!='' && OrderID==''){
			var Url = "isRecordExists.php?CreditID="+escape(CreditIDVal)+"&editID="+OrderID;
			SendExistRequest(Url,"CreditID", "Credit Note ID");
			return false;	
		}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}	
		
}







function setShipTo(){
	if(document.getElementById("OrderType").value=="Drop Ship"){
		$("#wCodeTitle").hide();
		$("#wCodeVal").hide();
		$("#wNameTitle").html('Customer');		
	}else{
		$("#wCodeTitle").show();
		$("#wCodeVal").show();
		$("#wNameTitle").html('Warehouse');		
	}

}
</script>








<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$ModuleName?> Information</td>
</tr>
 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Credit Note ID # : </td>
        <td   align="left" >
<? if(!empty($_GET['edit'])) {?>
	<input name="CreditID" type="text" class="disabled" readonly style="width:90px;" id="CreditID" value="<?php echo stripslashes($arryPurchase[0]["CreditID"]); ?>"  maxlength="20" />
<? }else{?>
	<input name="CreditID" type="text" class="datebox" id="CreditID" value="<?php echo stripslashes($arryPurchase[0]["CreditID"]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_CreditID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_CreditID','CreditID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_CreditID"></span>
<? } ?>

</td>
      </tr>





<? if($_GET['edit']>0){ ?>

  <tr>
        <td  align="right"   class="blackbold" >Posted Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

<tr>
        <td  align="right" class="blackbold" >Created By  : </td>
        <td   align="left">
		<?
			if($arryPurchase[0]['AdminType'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryPurchase[0]['AdminID'].'" >'.stripslashes($arryPurchase[0]['CreatedBy']).'</a>';
			}
			echo $CreatedBy;
		?>
          </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          
		  <? 
			if($_SESSION['AdminType'] == 'admin'){
				 $ActiveChecked = ' checked';
				 if($_REQUEST['edit'] > 0){
					 if($arryPurchase[0]['Approved'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					 if($arryPurchase[0]['Approved'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
			  ?>
          <input type="radio" name="Approved" id="Approved" value="1" <?=$ActiveChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Approved" id="Approved" value="0" <?=$InActiveChecked?> />
          No 
		  <? }else{ 
			  echo ($arryPurchase[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>');
			  echo '<input type="hidden" name="Approved" id="Approved" value="'.$arryPurchase[0]['Approved'].'">';
		  }?>
			 </td>
      </tr>
<? } ?>


<tr>
        <td  align="right" class="blackbold">Status  :</td>
        <td   align="left">
		<?
		if($arryPurchase[0]['Status'] == 'Open' || $arryPurchase[0]['Status'] == ''){
		?>
		  <select name="Status" class="textbox" id="Status" style="width:100px;">
				<? for($i=0;$i<sizeof($arryOrderStatus);$i++) {?>
					<option value="<?=$arryOrderStatus[$i]['attribute_value']?>" <?  if($arryOrderStatus[$i]['attribute_value']==$arryPurchase[0]['Status']){echo "selected";}?>>
					<?=$arryOrderStatus[$i]['attribute_value']?>
					</option>
				<? } ?>
			</select> 
		<? }else{ ?>
		<span class="redmsg"><?=$arryPurchase[0]['Status']?></span> <input type="hidden" name="Status" id="Status" value="<?=$arryPurchase[0]['Status']?>" readonly />
		<? } ?>

		</td>
</tr>


  <tr>
        <td  align="right"   class="blackbold" > Expiry Date  :<span class="red">*</span> </td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ClosedDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		minDate: "-0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$ClosedDate = ($arryPurchase[0]['ClosedDate']>0)?($arryPurchase[0]['ClosedDate']):(''); 
?>
<input id="ClosedDate" name="ClosedDate" readonly="" class="datebox" value="<?=$ClosedDate?>"  type="text" > 


</td>
      </tr>





<tr>
	<td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arryPurchase[0]['Comment']); ?>"  maxlength="100" />          
	</td>
</tr>


</table>

</td>
   </tr>

  

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"   >
		<tr>
			<td align="left" valign="top" width="50%"  class="borderpo"><? include("includes/html/box/po_supp_form.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top"  class="borderpo"><? include("includes/html/box/po_warehouse_form.php");?></td>
		</tr>
	</table>

</td>
</tr>



<tr>
			 <td align="right">
		<?
		
		$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
		echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
		?>	 
			 </td>
		</tr>

<tr>
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" ><?=LINE_ITEM?></td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/po_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($arryPurchase[0]['Status'] == '' || $arryPurchase[0]['Status'] == 'Open'){ ?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="Module" id="Module" value="Credit" />

<input type="hidden" name="ModuleID" id="ModuleID" value="CreditID" />
<input type="hidden" name="PrefixPO" id="PrefixPO" value="CRD" />
<input name="Taxable" id="Taxable" type="hidden" value="<?=stripslashes($arryPurchase[0]['Taxable'])?>">

	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<? } ?>





