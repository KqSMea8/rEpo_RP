<? 
if($Config['SalesCommission']==1){
	
	$arryTier=$objCommon->getTier('','1');
	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); 
?>
<script language="JavaScript1.2" type="text/javascript">
function validate_sales(frm){
	if( ValidateForSelect(frm.SalesPersonType, "Sales Person Type")
	
	){	
	
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
       		 <td colspan="2" height="30">&nbsp;</td>
        </tr>	


<tr>
        <td align="right" width="45%"  class="blackbold" valign="top" >
		Sales Person Type  :<span class="red">*</span></td>
    <td align="left" valign="top" >

<select name="SalesPersonType" id="SalesPersonType" class="textbox">
   <option value="">--- Select ---</option>
     <option value="Residual" <? if($arrySalesCommission[0]['SalesPersonType'] == "Residual") echo 'selected';?>> Residual </option>
        <option value="Non Residual" <? if($arrySalesCommission[0]['SalesPersonType'] == "Non Residual") echo 'selected';?>> Non Residual </option>
       
 </select>   	

	
	</td>
  </tr>	 	


	  <tr>
				<td  align="right" class="blackbold"  valign="top">Commission Tier :</td>
				<td align="left">


<label style="line-height:25px;"><input type="radio" name="tierID" id="tierID0" value="" <?=($arrySalesCommission[0]['Tier']=="")?("checked"):("")?>> None</label><br>

<?
$Line=0; 
foreach($arryTier as $key=>$values){ 
$Line++;
?>
<label style="line-height:25px;"><input type="radio" name="tierID" id="tierID<?=$Line?>" value="<?=$values['tierID']?>" <?=($arrySalesCommission[0]['tierID']==$values['tierID'])?("checked"):("")?>> 
<?=$values['Percentage']." %  on sale of : ".$values['RangeFrom']." - ".$values['RangeTo']." ".$Config['Currency'].""?></label>  <br>
<? } ?>
			

	</td>
			  </tr>	
					
	 <tr>
				<td align="right" class="blackbold" >
				Spiff Amount   :
				
				</td>
				<td  align="left"  >					
				<input name="SpiffAmount" type="text" class="textbox" id="SpiffAmount" value="<?=stripslashes($arrySalesCommission[0]['SpiffAmount'])?>" maxlength="10" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?>		

		</td>
	</tr>

	<tr>
				<td align="right" class="blackbold" >
				Sales Target for Spiff Amount  :
				
				</td>
				<td  align="left"  >					
				<input name="SpiffTarget" type="text" class="textbox" id="SpiffTarget" value="<?=stripslashes($arrySalesCommission[0]['SpiffTarget'])?>" maxlength="10" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?>		

		</td>
	</tr>




 <tr>
       		 <td colspan="2" height="30">


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

