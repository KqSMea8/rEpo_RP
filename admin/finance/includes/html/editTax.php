<SCRIPT LANGUAGE=JAVASCRIPT>
 function validateTax(frm){
	if( ValidateForSimpleBlank(frm.RateDescription,"Tax Name")
	    //&& ValidateForSelect(frm.ClassId,"Tax Class")
             //&& ValidateForSelect(frm.country_id,"Country")
             && ValidateMandRange (frm.TaxRate,"Tax Rate")
		){	

		if(document.getElementById("TaxRate").value >100){
			alert("Tax rate should be less then 100");
			document.getElementById("TaxRate").focus();
			 return false;
		}

	
                  var Url = "isRecordExists.php?RateDes="+escape(document.getElementById("RateDescription").value)+"&Class="+escape(document.getElementById("ClassId").value)+"&country="+escape(document.getElementById("country_id").value)+"&state="+escape(document.getElementById("state_id").value)+"&editID="+document.getElementById("taxId").value;
				 
                           
                                  SendExistRequest(Url,"RateDescription", "Tax Name "+document.getElementById("RateDescription").value);
					//SendExistRequest(Url,'Item Sku '+document.getElementById("Sku").value);
		  	
		                   return false;
				
					
			}else{
					return false;	
			}	

		
}
</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage  Tax   <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit  Tax") :("Add  ".$ModuleName); ?></span>
		
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <form name="form1" action="" method="post" onSubmit="return validateTax(this);"  enctype="multipart/form-data">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left"  class="head" >Tax</td>
     
</tr>
	<tr>
	 <td  align="right" width="45%" class="blackbold">  Tax Name <span class="red">*</span> </td>
	 <td  align="left"><input  name="RateDescription" id="RateDescription" value="<?= stripslashes($arryTax[0]['RateDescription']) ?>" type="text" class="inputbox"  size="50" />
	</td>
	</tr>

 

 <tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		
	<?
$CountrySelected ='';
 if($arryTax[0]['Coid'] != ''){
	   $CountrySelected = $arryTax[0]['Coid']; }?>
	
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
             <option value="" >-- All Country --</option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
<tr>
<td  align="right" valign="top"   class="blackbold"> 
	  Tax Class : </td>
	<td  align="left" valign="top">
  <?php for($j = 0;$j<sizeof($arryTaxClasses);$j++){
	  $class = explode(",",$arryTax[0]['ClassId']);
?>
	<input type="checkbox" name ="ClassId[]" id="ClassId<?=$j?>" <? if(in_array($arryTaxClasses[$j]['ClassName'], $class)){
	echo "checked";}?> value="<?=$arryTaxClasses[$j]['ClassName']?>"/> <?=$arryTaxClasses[$j]['ClassName']?>&nbsp;&nbsp;
	<? }?>
</td>
</tr>
<tr>
<td align="right"  class="blackbold"> Freight Tax : </td>
<td align="left" class="blacknormal">
      

<select name="FreightTax" class="inputbox" id="FreightTax"  >
            
            
              <option value="Yes" <?=($arryTax[0]['FreightTax'] == "Yes") ? "selected" : "" ?>>
              Yes
              </option>
<option value="No" <?=($arryTax[0]['FreightTax'] == "No") ? "selected" : "" ?>>
              No
              </option>
           
            </select> 


                    
</td>
</tr>
<tr>
<td  align="right" class="blackbold"> 
Tax Rate % :<span class="red">*</span> </td>
<td  align="left" valign="top">
<input  name="TaxRate" onkeypress="return isDecimalKey(event);" id="TaxRate" value="<?=$arryTax[0]['TaxRate']?>" type="text" class="textbox" size="10" maxlength="5" />
</td>
</tr>
                                             
<tr>
<td align="right"  class="blackbold"> Status : </td>
<td align="left" class="blacknormal">
    <table  border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
        <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($TaxStatus == "Yes") ? "checked" : "" ?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td align="left" valign="middle"><input name="Status" type="radio" <?= ($TaxStatus == "No") ? "checked" : "" ?> value="0" /></td>
            <td  align="left" valign="middle">Inactive</td>
        </tr>
    </table>                      
</td>
</tr>


   
</table>

	
	</td>
    </tr>
   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	
<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
   <input type="hidden" name="taxId" id="taxId" value="<?=$_GET['edit'];?>" />
   <input type="hidden" value="<?=$arryTax[0]['Stid'];?>" id="main_state_id" name="main_state_id">
<input type="hidden" value="1" id="AllOption" name="AllOption">		
   <input name="Submit" type="submit" class="button" id="SubmitTax" value=" <?= $ButtonTitle ?> " />&nbsp;

</div>




</td>
   </tr>
 </form>
</table>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
