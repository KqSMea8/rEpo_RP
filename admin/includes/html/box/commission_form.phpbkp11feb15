<? 
if($Config['SalesCommission']==1){
	
	$arryTier=$objCommon->getTier('','1');
	$arrySpiff=$objCommon->getSpiffTier('','1');

	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); 
?>
<script language="JavaScript1.2" type="text/javascript">

function CommTypeOption(){
	if(document.getElementById("CommType").value=='Commision'){
		$("#CommDiv").show();
		$("#SpiffDiv").hide();		
	}else if(document.getElementById("CommType").value=='Spiff'){
		$("#CommDiv").hide();
		$("#SpiffDiv").show();
	}else if(document.getElementById("CommType").value=='Commision & Spiff'){
		$("#CommDiv").show();
		$("#SpiffDiv").show();
	}else{
		$("#CommDiv").hide();
		$("#SpiffDiv").hide();
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
			if(!ValidateForSelect(frm.spiffID, "Spiff Tier")){
				return false;
			}

			if(!ValidateForSimpleBlank(frm.SpiffTarget, "Spiff Target")){
				return false;
			}
			if(!ValidateForSimpleBlank(frm.SpiffEmp, "Spiff Amount")){
				return false;
			}

		}

		
		

		ShowHideLoader('1','S');
		return true;		
	}else{
		return false;	
	}
		
}
</script>

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
		Sales Person Type  :<span class="red">*</span></td>
    <td align="left" valign="top" >

<select name="SalesPersonType" id="SalesPersonType" class="inputbox"  >
   <option value="">--- Select ---</option>
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








<div id="SpiffDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
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
</tr>	



<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Target :<span class="red">*</span>
	</td>
	<td align="left" valign="top" >
	<input name="SpiffTarget" type="text" class="textbox" id="SpiffTarget" value="<?=stripslashes($arrySalesCommission[0]['SpiffTarget'])?>" size="10"  maxlength="10" onkeypress='return isDecimalKey(event)'/>  <?=$Config['Currency']?>	
	</td>
</tr>

<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Amount :<span class="red">*</span>
	</td>
	<td align="left" valign="top" >
	<input name="SpiffEmp" type="text" class="textbox" id="SpiffEmp" value="<?=stripslashes($arrySalesCommission[0]['SpiffEmp'])?>" size="10"  maxlength="10" onkeypress='return isDecimalKey(event)'/> 	<?=$Config['Currency']?>	
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
	AcceleratorOption();
</SCRIPT>
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
<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>
<? } ?>

