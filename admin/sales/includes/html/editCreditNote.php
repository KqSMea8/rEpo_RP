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
		
	var CreditIDVal = Trim(document.getElementById("CreditID")).value;
	var OrderID = Trim(document.getElementById("OrderID")).value;

	if(CreditIDVal!=''){
		if(!ValidateMandRange(document.getElementById("CreditID"), "Credit Note ID",3,20)){
			return false;
		}
	}

	if(ValidateForSelect(frm.CustomerName, "Customer")
	    /*&& ValidateForSelect(frm.SalesPerson, "Sales Person")*/ 
		&& ValidateForSelect(frm.ClosedDate, "Expiry Date") 
		//&& ValidateForSimpleBlank(frm.BillingName, "Billing Name")
		&& ValidateForSimpleBlank(frm.Address, "Address")
		&& ValidateForSimpleBlank(frm.City, "City")
		&& ValidateForSimpleBlank(frm.State, "State")
		&& ValidateForSimpleBlank(frm.Country, "Country")
		&& ValidateForSimpleBlank(frm.ZipCode, "Zip Code")
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
	
		//&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& isEmailOpt(frm.Email)
		
		//&& ValidateForSimpleBlank(frm.ShippingName, "Shipping Name")
		&& ValidateForSimpleBlank(frm.ShippingAddress, "Shipping Address")
		&& ValidateForSimpleBlank(frm.ShippingCity, "City")
		&& ValidateForSimpleBlank(frm.ShippingState, "State")
		&& ValidateForSimpleBlank(frm.ShippingCountry, "Country")
		&& ValidateForSimpleBlank(frm.ShippingZipCode, "Zip Code")
		//&& ValidatePhoneNumber(frm.ShippingMobile,"Mobile Number",10,20)
		//&& ValidateForSimpleBlank(frm.ShippingEmail, "Email Address")
		&& isEmailOpt(frm.ShippingEmail)
	){
		
		for(var i=1;i<=NumLine;i++){
		 
			if(document.getElementById("sku"+i).value == ""){
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
		 
			if(parseInt(document.getElementById("discount"+i).value) >= parseInt(document.getElementById("price"+i).value))
			{
			   alert("Discount Should be Less Than Unit Price!");
			   return false;
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
</script>


<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Search Customer</td>
</tr>
  <tr>
   <tr>
			<td  align="right"   class="blackbold" width="30%"> Customer  :<span class="red">*</span> </td>
			<td   align="left">
				<input name="CustomerName" type="text" class="disabled_inputbox"  id="CustomerName" value="<?php echo stripslashes($arrySale[0]['CustomerName']); ?>"  maxlength="60" readonly />
				
	<input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustCode']); ?>">
	<input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>">
<input name="Taxable" id="Taxable" type="hidden" value="<?php echo stripslashes($arrySale[0]['Taxable']); ?>">

				<a class="fancybox fancybox.iframe" href="CustomerList.php?creditnote=1" ><?=$search?></a>

			</td>
	 </tr>
</tr>
 <tr>
	 <td colspan="2" align="left" class="head">Credit Note Information</td>
</tr>
 
   <tr>
        <td  align="right"   class="blackbold" width="20%"> Credit Note ID # : </td>
        <td   align="left" >
<? if(!empty($_GET['edit'])) {?>
	<input name="CreditID" type="text" class="disabled" readonly style="width:90px;" id="CreditID" value="<?php echo stripslashes($arrySale[0]["CreditID"]); ?>"  maxlength="20" />
<? }else{?>
	<input name="CreditID" type="text" class="datebox" id="CreditID" value="<?php echo stripslashes($arrySale[0]["CreditID"]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_CreditID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_CreditID','CreditID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_CreditID"></span>
<? } ?>

</td>
      </tr>





<? if($_GET['edit']>0){ ?>

  <tr>
        <td  align="right"   class="blackbold" >Posted Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

<tr>
        <td  align="right" class="blackbold" >Created By  : </td>
        <td   align="left">
		<?
			if($arrySale[0]['AdminType'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arrySale[0]['AdminID'].'" >'.stripslashes($arrySale[0]['CreatedBy']).'</a>';
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
					 if($arrySale[0]['Approved'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					 if($arrySale[0]['Approved'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
			  ?>
          <input type="radio" name="Approved" id="Approved" value="1" <?=$ActiveChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Approved" id="Approved" value="0" <?=$InActiveChecked?> />
          No 
		  <? }else{ 
			  echo ($arrySale[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>');
			  echo '<input type="hidden" name="Approved" id="Approved" value="'.$arrySale[0]['Approved'].'">';
		  }?>
			 </td>
      </tr>
<? } ?>


<tr>
        <td  align="right" class="blackbold">Status  :</td>
        <td   align="left">
		<?
		if($arrySale[0]['Status'] == 'Open' || $arrySale[0]['Status'] == ''){
		?>
		  <select name="Status" class="textbox" id="Status" style="width:100px;">
				<? for($i=0;$i<sizeof($arryOrderStatus);$i++) {?>
					<option value="<?=$arryOrderStatus[$i]['attribute_value']?>" <?  if($arryOrderStatus[$i]['attribute_value']==$arrySale[0]['Status']){echo "selected";}?>>
					<?=$arryOrderStatus[$i]['attribute_value']?>
					</option>
				<? } ?>
			</select> 
		<? }else{ ?>
		<span class="redmsg"><?=$arrySale[0]['Status']?></span> <input type="hidden" name="Status" id="Status" value="<?=$arrySale[0]['Status']?>" readonly />
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
$ClosedDate = ($arrySale[0]['ClosedDate']>0)?($arrySale[0]['ClosedDate']):(''); 
?>
<input id="ClosedDate" name="ClosedDate" readonly="" class="datebox" value="<?=$ClosedDate?>"  type="text" > 


</td>
      </tr>



<tr style="display:none">
		<td  align="right"   class="blackbold" > Currency  : </td>
		<td   align="left" >
		<input name="CustomerCurrency" type="text" class="disabled" readonly style="width:90px;" id="CustomerCurrency" value="<?=stripslashes($arrySale[0]['CustomerCurrency'])?>"/> 

	</td>
   </tr>

<tr>
	<td  align="right"   class="blackbold" > Comments  : </td>
	<td   align="left" >
	<input name="Comment" type="text" class="inputbox" id="Comment" value="<?php echo stripslashes($arrySale[0]['Comment']); ?>"  maxlength="100" />          
	</td>
</tr>


</table>

</td>
   </tr>

  

<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("includes/html/box/sale_order_billto_form.php");?></td>
			<td align="left" valign="top"><? include("includes/html/box/sale_order_shipto_form.php");?></td>
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
	<td align="left" >
		
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/sale_order_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>




  
  <? if($arrySale[0]['Status'] == '' || $arrySale[0]['Status'] == 'Open'){ ?>

   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

		<input type="hidden" name="Module" id="Module" value="Credit" />

		<input type="hidden" name="ModuleID" id="ModuleID" value="CreditID" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="CRD" />

	</td>
   </tr>



<? } ?>
  
</table>

 </form>


<? } ?>





