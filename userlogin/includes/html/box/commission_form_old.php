<? 

if($Config['SalesCommission']==1){
	$arryCommType = $objCommon->GetFixedAttribute('HeadType',''); 	
   $arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); ?>
<script language="JavaScript1.2" type="text/javascript">

function CommTypeOption(){
	if(document.getElementById("CommType").value=='Fixed'){
		document.getElementById('AmountTitle').style.display = 'block'; 
		document.getElementById('AmountValue').style.display = 'block'; 
		
		document.getElementById('PercentageTitle').style.display = 'none'; 
		document.getElementById('PercentageValue').style.display = 'none'; 

		document.getElementById('TargetTitle').style.display = 'block'; 
		document.getElementById('TargetValue').style.display = 'block'; 

	}else if(document.getElementById("CommType").value=='Percentage'){
		document.getElementById('AmountTitle').style.display = 'none'; 
		document.getElementById('AmountValue').style.display = 'none'; 
		
		document.getElementById('PercentageTitle').style.display = 'block'; 
		document.getElementById('PercentageValue').style.display = 'block'; 

		document.getElementById('TargetTitle').style.display = 'block'; 
		document.getElementById('TargetValue').style.display = 'block'; 

	}else{
		document.getElementById('AmountTitle').style.display = 'none'; 
		document.getElementById('AmountValue').style.display = 'none'; 
		
		document.getElementById('PercentageTitle').style.display = 'none'; 
		document.getElementById('PercentageValue').style.display = 'none'; 

		document.getElementById('TargetTitle').style.display = 'none'; 
		document.getElementById('TargetValue').style.display = 'none'; 
	}
}


function validate_sales(frm){
	
	if(document.getElementById("CommType").value=='Percentage'){
		if(!ValidateMandNumField2(frm.CommPercentage,"Commission Percentage",1,100)){
			return false;
		}
	}
	if(document.getElementById("CommType").value=='Fixed'){
		if(!ValidateMandNumField2(frm.CommAmount,"Commission Amount",1,10000000)){
			return false;
		}
	}

	ShowHideLoader('1','S');
	return true;	
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
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	

	  <tr>
				<td  align="right" class="blackbold" width="45%">Sales Commission :</td>
				<td align="left">

				<select name="CommType" class="inputbox" id="CommType" onChange="Javascript:CommTypeOption();">
					<option value="">--- None ---</option>
					<? for($i=0;$i<2;$i++) {?>
						<option value="<?=$arryCommType[$i]['attribute_value']?>" <?  if($arryCommType[$i]['attribute_value']==$arrySalesCommission[0]['CommType']){echo "selected";}?>>
						<?=$arryCommType[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select> 	</td>
			  </tr>	
					
			      <tr>
				<td align="right" class="blackbold" >
				<div id="PercentageTitle">Commission Percentage  :<span class="red">*</span></div>
				<div id="AmountTitle">Commission Amount  :<span class="red">*</span></div>
				</td>
				<td  align="left"  >
				<div id="PercentageValue">
				<input name="CommPercentage" type="text" class="textbox" id="CommPercentage" value="<?=stripslashes($arrySalesCommission[0]['CommPercentage'])?>" size="3"  maxlength="3" onkeypress='return isNumberKey(event)'/> %	of Sales</div>	
				<div  id="AmountValue"><input name="CommAmount" type="text" class="textbox" id="CommAmount" value="<?=stripslashes($arrySalesCommission[0]['CommAmount'])?>" maxlength="10" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?></div>
						

			

		</td>
	</tr>


<tr>
        <td align="right"   class="blackbold" valign="top">
		<div id="TargetTitle">Sales Target for  Commission  :</div></td>
    <td height="30" align="left" valign="top" >
	
	 <div id="TargetValue"><input name="TargetAmount" type="text" class="textbox" id="TargetAmount" value="<?=stripslashes($arrySalesCommission[0]['TargetAmount'])?>" maxlength="15" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?></div>
	
	</td>
  </tr>	 




 <tr>
       		 <td colspan="2" height="50">

<SCRIPT LANGUAGE=JAVASCRIPT>
	CommTypeOption();
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

