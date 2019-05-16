<? 
if($Config['SalesCommission']==1){
	
	$arryTier=$objCommon->getTier('','1');
	$arrySpiff=$objCommon->getSpiffTier('','1');
 if(!empty($SuppID)) {
	$SuppID = $SuppID;
   }
	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID,$SuppID); 


	if(empty($arrySalesCommission[0]['comID'])){
		$arrySalesCommission = $objConfigure->GetDefaultArrayValue('h_commission'); 
	}
?>
<script language="JavaScript1.2" type="text/javascript">

function CommTypeOption(){
	if(document.getElementById("CommType").value=='Commision'){
		$("#CommDiv").show();
		$("#SpiffDiv").hide();	
		$("#VendorSpiffDiv").hide();			
	}else if(document.getElementById("CommType").value=='Spiff'){
		$("#CommDiv").hide();
		$("#SpiffDiv").show();
		$("#VendorSpiffDiv").show();
		VendorSpiffOnOption();
	}else if(document.getElementById("CommType").value=='Commision & Spiff'){
		$("#CommDiv").show();
		$("#SpiffDiv").show();
		$("#VendorSpiffDiv").hide();	
	}else{
		
		$("#CommDiv").hide();
		$("#SpiffDiv").hide();
		$("#VendorSpiffDiv").hide();

		 
	}
	
}

function SpiffAmtPer(sfval){
	if(sfval=='Percentage'){
		$("#perShow").show();
			
	}else{
		$("#perShow").hide();
	
	}
	
}



function CommBasedOnOption(sfval){
	if(sfval=='Customer'){
		$("#amtty").show();
		$("#sfamt").show();		
	}else{
		$("#amtty").hide();
		$("#sfamt").hide();
	}
	
}

function VendorSpiffOnOption(){
	if(document.getElementById("CommType").value=='Spiff'){
		var SpiffOn = $("#SpiffOn").val();

		if(SpiffOn=='1'){
			$("#SpiffDiv").hide();	
			$(".vendorspiffTR").show();			
		}else{
			$("#SpiffDiv").show();	
			$(".vendorspiffTR").hide();		
		}
	}	
}


function SetStructureType(){
 
	if(document.getElementById("SalesStructureType").value=='1'){ 
		$("#SalesPersonTR").show();
	}else{
		$("#SalesPersonTR").hide();
		document.getElementById("SalesPersonType").value = "Residual"; 
	}
}


function AcceleratorOption(opt){
	var tierID = 0; var CommPercentage = 0;
	$("#AccTitle").hide();
	$("#AccVal").hide();
	$("#AccPerTitle").hide();
	$("#AccPerVal").hide();	
	
	var tierIDVal = document.getElementById("tierID").value;
	var arrytierID = tierIDVal.split("|");

	if(arrytierID[0]>0)tierID = arrytierID[0];
	if(arrytierID[1]>0)CommPercentage = arrytierID[1];

	if(opt==1){
		$("#RangeSpan").hide();	
		document.getElementById("CommPercentage").value = CommPercentage;
		if(arrytierID[3]>0){
		document.getElementById("RangeSpan").innerHTML = '[ Range: '+arrytierID[2]+' - '+arrytierID[3]+' ]';
		$("#RangeSpan").show();	
}
	}

	if(tierID>0){		
		$("#AccTitle").show();
		$("#AccVal").show();	
		if(document.getElementById("Accelerator").value=="Yes"){
			$("#AccPerTitle").show();
			$("#AccPerVal").show();
		}	
	}
}



function SpiffOption(opt){
	var spiffID = 0; var SpiffTarget = 0; var SpiffEmp = 0;
	
	var spiffIDVal = document.getElementById("spiffID").value;
	var arryspiffID = spiffIDVal.split("|");

	if(arryspiffID[0]>0)spiffID = arryspiffID[0];
	if(arryspiffID[1]>0)SpiffTarget = arryspiffID[1];
	if(arryspiffID[2]>0)SpiffEmp = arryspiffID[2];

	if(opt==1){
		document.getElementById("SpiffTarget").value = SpiffTarget;
		document.getElementById("SpiffEmp").value = SpiffEmp;
	}

}



function validate_sales(frm){

	if(ValidateForSelect(frm.CommType, "Sales Structure")	
	){	
		if(document.getElementById("CommDiv").style.display=="" || document.getElementById("CommDiv").style.display=="block"){
			if(!ValidateForSelect(frm.SalesPersonType, "Sales Person Type")){
				return false;
			}
			if(!ValidateForSelect(frm.tierID, "Commission Tier")){
				return false;
			}
			if(!ValidateForSimpleBlank(frm.CommPercentage, "Commission Percentage")){
				return false;
			}
			if(frm.CommPercentage.value >= 100){
				alert("Commission Percentage should be less than 100.");
				frm.CommPercentage.focus();
				return false;
			}




			if(!ValidateForSelect(frm.Accelerator, "Accelerator")){
				return false;
			}

			if(document.getElementById("Accelerator").value=="Yes"){
				if(!ValidateForSimpleBlank(frm.AcceleratorPer, "Accelerator Percentage")){
					return false;
				}
				if(frm.AcceleratorPer.value >= 100){
					alert("Accelerator Percentage should be less than 100.");
					frm.AcceleratorPer.focus();
					return false;
				}
			}

		}

		if(document.getElementById("SpiffDiv").style.display=="" || document.getElementById("SpiffDiv").style.display=="block"){

 

			if(!ValidateForSelect(frm.SpiffType, "Spiff Type")){
				return false;
			}
				if(!ValidateForSelect(frm.spiffBasedOn, "Spiff Based on")){
				return false;
			}
			
			if(frm.spiffBasedOn.value =='Customer'){
			
			     if(!ValidateForSelect(frm.amountType, "Amount Type")){
				     return false;
			     }

			     //if(!ValidateForSimpleBlank(frm.SpiffTarget, "Spiff Target")){
				     //return false;
			     //}
			     if(!ValidateForSimpleBlank(frm.SpiffEmp, "Spiff Amount")){
				     return false;
			     }
			
			
		        if(frm.amountType.value == 'Percentage'){
			        if(frm.SpiffEmp.value >= 100){
					        alert("Spiff Amount Percentage should be less than 100.");
					        frm.SpiffEmp.focus();
					        return false;
				        }
			        }
			}

			

		}

		
		

		ShowHideLoader('1','S');
		return true;		
	}else{
		return false;	
	}
		
}
</script>
<? #echo "<pre>"; print_r($arrySalesCommission);?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validate_sales(this);" enctype="multipart/form-data">
  <? if (!empty($_SESSION['mess_user'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?>	
</td>
</tr>
<? } ?>

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>

<tr>
       		 <td colspan="2" height="20">&nbsp;</td>
        </tr>	



<tr>
	<td  align="right" class="blackbold" width="45%">Sales Structure :<span class="red">*</span></td>
	<td align="left">

	<select name="CommType" class="inputbox" id="CommType" onChange="Javascript:CommTypeOption();">
		<option value="">--- Select ---</option>
		 <option value="Commision" <? if($arrySalesCommission[0]['CommType'] == "Commision") echo 'selected';?>> Commision </option>
        <option value="Spiff" <? if($arrySalesCommission[0]['CommType'] == "Spiff") echo 'selected';?>> Spiff </option>
<option value="Commision & Spiff" <? if($arrySalesCommission[0]['CommType'] == "Commision & Spiff") echo 'selected';?>> Both </option>
	</select> 	</td>
  </tr>	 

  


<tr>     
    <td colspan="2">

<div id="CommDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
        <td align="right" class="blackbold" valign="top" width="45%">
		Sales Structure Type  : </td>
    <td align="left" valign="top" >

<select name="SalesStructureType" id="SalesStructureType" class="inputbox" onChange="Javascript:SetStructureType();" >
 
     <option value="0" <? if($arrySalesCommission[0]['SalesStructureType'] == "0") echo 'selected';?>> Standard </option>
        <option value="1" <? if($arrySalesCommission[0]['SalesStructureType'] == "1") echo 'selected';?>> Subscription </option>
       
 </select>   	

	
	</td>
  </tr>	 
  
  



<tr id="SalesPersonTR">
        <td align="right" class="blackbold" valign="top"  >
		Sales Person Type  :<span class="red">*</span></td>
    <td align="left" valign="top" >

<select name="SalesPersonType" id="SalesPersonType" class="inputbox"  >
  
     <option value="Residual" <? if($arrySalesCommission[0]['SalesPersonType'] == "Residual") echo 'selected';?>> Residual </option>
        <option value="Non Residual" <? if($arrySalesCommission[0]['SalesPersonType'] == "Non Residual") echo 'selected';?>> Non Residual </option>
       
 </select>   	

	
	</td>
  </tr>	 	

<tr>
        <td align="right" class="blackbold" valign="top" >
		Commission On  :</td>
    <td align="left" valign="top" >

<select name="CommOn" id="CommOn" class="inputbox"  >
     <option value="0" <? if($arrySalesCommission[0]['CommOn'] == "0") echo 'selected';?>> Total Amount</option>
        <option value="1" <? if($arrySalesCommission[0]['CommOn'] == "1") echo 'selected';?>>Per Invoice Payment</option>
       <option value="2" <? if($arrySalesCommission[0]['CommOn'] == "2") echo 'selected';?>>Margin</option>
       
 </select>   	

	
	</td>
  </tr>	
  
  <tr>
		<td  align="right" class="blackbold"  valign="top">Commission Paid On :<span class="red">*</span></td>
		<td align="left">

 <select name="CommPaidOn" id="CommPaidOn" class="inputbox">
	    <option value="All" <?php if($arrySalesCommission[0]['CommPaidOn']=="All") echo 'selected'; ?> >All Invoices</option>
           <option value="Paid" <?php if($arrySalesCommission[0]['CommPaidOn']=="Paid") echo 'selected'; ?>>Paid Invoices</option>
                
       
        </select>   

 </td>
</tr>	


<tr style="display:none55">
      <td align="right" class="blackbold" valign="top" >Commission Type  :</td>
      <td align="left" valign="top" >
           
        <select name="Commission_type" id="Commission_type" class="inputbox">
           <option value="Monthly" <?php if($arrySalesCommission[0]['CommissionType']=="Monthly") echo 'selected'; ?>>Monthly</option>
           <option value="Quaterly" <?php if($arrySalesCommission[0]['CommissionType']=="Quaterly") echo 'selected'; ?> >Quaterly</option>
           <option value="Yearly" <?php if($arrySalesCommission[0]['CommissionType']=="Yearly") echo 'selected'; ?>>Yearly</option>
       
        </select>   	
    </td>
</tr>

<tr>
		<td  align="right" class="blackbold"  valign="top">Commission Tier :<span class="red">*</span></td>
		<td align="left">

<select name="tierID" id="tierID" class="textbox"  style="width:300px;" onChange="Javascript:AcceleratorOption(1);">
<option value="">--- Select ---</option>
<? 
foreach($arryTier as $key=>$values){ 
$selT = ($arrySalesCommission[0]['tierID']==$values['tierID'])?("selected"):("");
$optionval = $values['tierID']."|".$values['Percentage']."|".$values['RangeFrom']."|".$values['RangeTo'];
echo '<option value="'.$optionval.'" '.$selT.'>'.$values['Percentage'].' %  on Range : '.$values['RangeFrom'].' - '.$values['RangeTo'].'</option>';
}
?>           
</select>  



 </td>
</tr>	
	

<tr>
	<td align="right" class="blackbold" valign="top" >
	Commission  Percentage :<span class="red">*</span>
	</td>
	<td align="left" valign="top" >
	<input name="CommPercentage" type="text" class="textbox" id="CommPercentage" value="<?=stripslashes($arrySalesCommission[0]['CommPercentage'])?>" size="3"  maxlength="6" onkeypress='return isDecimalKey(event)'/> % &nbsp;&nbsp;&nbsp;&nbsp;

<span id="RangeSpan">
<?
if($arrySalesCommission[0]['TargetFrom']!='' && $arrySalesCommission[0]['TargetTo']!='')
{
	$TargetFrom = $arrySalesCommission[0]['TargetFrom'];
	$TargetTo = $arrySalesCommission[0]['TargetTo'];
	#if($TargetTo==0) $TargetTo=$arrySalesCommission[0]['RangeFrom'];
	echo '[ Range: '.$TargetFrom.' - '.$TargetTo.' ]';
}
?>
</span>
	
	</td>
</tr>

	

<tr>
        <td align="right" class="blackbold" valign="top" >
		<div id="AccTitle">Accelerator  :<span class="red">*</span></div>
	</td>
    <td align="left" valign="top" >

<div id="AccVal">
	<select name="Accelerator" id="Accelerator" class="textbox" onChange="Javascript:AcceleratorOption();" >
		<option value="">--- Select ---</option>
		<option value="Yes" <? if($arrySalesCommission[0]['Accelerator'] == "Yes") echo 'selected';?>> Yes </option>
		<option value="No" <? if($arrySalesCommission[0]['Accelerator'] == "No") echo 'selected';?>> No </option>       
	 </select>   	
</div>

	</td>
  </tr>	


<tr>
        <td align="right" class="blackbold" valign="top" >
		<div id="AccPerTitle">Accelerator  Percentage :<span class="red">*</span></div></td>
    <td align="left" valign="top" >
<div id="AccPerVal">
<input name="AcceleratorPer" type="text" class="textbox" id="AcceleratorPer" value="<?=stripslashes($arrySalesCommission[0]['AcceleratorPer'])?>" size="3"  maxlength="6" onkeypress='return isDecimalKey(event)'/> % 	
</div>
	</td>
  </tr>









	
</table>
</div>






<div id="VendorSpiffDiv">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<? if(!empty($SuppID)){ ?>
<tr>
        <td align="right" class="blackbold" valign="top" width="45%">
		Spiff On  :</td>
    <td align="left" valign="top" >
<select name="SpiffOn" id="SpiffOn" class="inputbox" onChange="Javascript:VendorSpiffOnOption();" >
     <option value="0" <? if($arrySalesCommission[0]['SpiffOn'] != "1") echo 'selected';?>>All Invoices</option>
        <option value="1" <? if($arrySalesCommission[0]['SpiffOn'] == "1") echo 'selected';?>>Per Invoice</option>     
 </select>  	
	</td>
  </tr>	

  <tr class="vendorspiffTR">
	<td  align="right" class="blackbold"  valign="top">Commission Paid On : </td>
	<td align="left">
 <select name="SpiffPaidOn" id="SpiffPaidOn" class="inputbox">
	    <option value="All" <?php if($arrySalesCommission[0]['CommPaidOn']=="All") echo 'selected'; ?> >All Invoices</option>
           <option value="Paid" <?php if($arrySalesCommission[0]['CommPaidOn']=="Paid") echo 'selected'; ?>>Paid Invoices</option>  
        </select>   
 </td>
</tr>	
<? } ?>

</table>
</div>







<div id="SpiffDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>
    <td  align="right" class="blackbold"  valign="top" width="45%">Spiff Type :<span class="red">*</span></td>
      <td align="left" valign="top" >
           
        <select name="SpiffType" id="SpiffType" class="inputbox">
          
           <option value="one" <?php if($arrySalesCommission[0]['SpiffType']=="one") echo 'selected'; ?> >Onetime</option>
           <option value="recurring" <?php if($arrySalesCommission[0]['SpiffType']=="recurring") echo 'selected'; ?>>Recurring</option>
       
        </select>   	
    </td>
</tr>


<tr>
    <td  align="right" class="blackbold"  valign="top" width="45%">Spiff Based On :<span class="red">*</span></td>
      <td align="left" valign="top" >
           
        <select name="spiffBasedOn" id="spiffBasedOn" class="inputbox" onChange="Javascript:CommBasedOnOption(this.value);">
          
           <option value="Customer" <?php if($arrySalesCommission[0]['spiffBasedOn']=="Customer") echo 'selected'; ?> >Customer</option>
           <option value="Product" <?php if($arrySalesCommission[0]['spiffBasedOn']=="Product") echo 'selected'; ?>>Product</option>
       
        </select>   	
    </td>
</tr>


<? 
$HideShowSpifamt='';

if($arrySalesCommission[0]['spiffBasedOn']=="Product"){

$HideShowSpifamt = 'style="display:none"';}

if($arrySalesCommission[0]['amountType']=="Percentage"){

$HideShowSpifPeramt = '';}else{

$HideShowSpifPeramt = 'style="display:none"';
}

?>
<!--<tr>
<td  align="right" class="blackbold"  valign="top" width="45%">Spiff Tier :<span class="red">*</span></td>
<td align="left">
	<select name="spiffID" id="spiffID" class="textbox" style="width:300px;" onChange="Javascript:SpiffOption(1);">
	<option value="">--- Select ---</option>
	<? 
	foreach($arrySpiff as $key=>$values){ 
	$selS = ($arrySalesCommission[0]['spiffID']==$values['spiffID'])?("selected"):("");
	$optionval = $values['spiffID']."|".$values['SalesTarget']."|".$values['SpiffAmount'];
	echo '<option value="'.$optionval.'" '.$selS.'>'.$values['SpiffAmount'].' '.$Config['Currency'].'  on sale of : '.$values['SalesTarget'].' '.$Config['Currency'].'</option>';
	}
	?>           
	</select>  
</td>
</tr>	-->

<tr id="amtty" <?=$HideShowSpifamt?>>
<td  align="right" class="blackbold"  valign="top" width="45%">Amount Type :<span class="red">*</span></td>
<td align="left">

	<select name="amountType" id="amountType" class="textbox"  onChange="Javascript:SpiffAmtPer(this.value);" >
	 
	  <option value="Percentage" <?=($arrySalesCommission[0]['amountType']=='Percentage')?("selected"):("");?>>Percentage</option>
	  <option value="Amount" <?=($arrySalesCommission[0]['amountType']=='Amount')?("selected"):("");?>>Fixed Amount</option>
	         
	</select>  
</td>
</tr>

<!--<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Target :<span class="red">*</span>
	</td>
	<td align="left" valign="top" >
	<input name="SpiffTarget" type="text" class="textbox" id="SpiffTarget" value="<?=stripslashes($arrySalesCommission[0]['SpiffTarget'])?>" size="10"  maxlength="10" onkeypress='return isDecimalKey(event)'/>  <?=$Config['Currency']?>	
	</td>
</tr>-->

<tr id="sfamt" <?=$HideShowSpifamt?>>
	<td align="right" class="blackbold" valign="top" >
	Spiff Amount <span id="perShow" <?=$HideShowSpifPeramt?>>Percentage</span> :<span class="red">*</span>
	</td>
	<td align="left" valign="top" >
	<input name="SpiffEmp" type="text" class="textbox" id="SpiffEmp" value="<?=stripslashes($arrySalesCommission[0]['SpiffEmp'])?>" size="10"  maxlength="10" onkeypress='return isDecimalKey(event)'/> 		
	</td>
</tr>




</table>
</div>

	
	</td>
  </tr>	 




	
	 
	 



 <tr>
       		 <td colspan="2" height="20">

<SCRIPT LANGUAGE=JAVASCRIPT>
	CommTypeOption();
	SetStructureType();
	AcceleratorOption();
</SCRIPT>

<? if(!empty($SuppID)){ ?>
	<SCRIPT LANGUAGE=JAVASCRIPT>
	VendorSpiffOnOption();
	</SCRIPT>
<? } ?>

</td>
        </tr>		 
	
	  
       
	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="Division" id="Division" value="<?=$Division?>" />
<input type="hidden" name="EmpID" id="EmpID" value="<?=$EmpID?>" />
<input type="hidden" name="SuppID" id="SuppID" value="<?=$SuppID?>" />
<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>
<? } ?>

