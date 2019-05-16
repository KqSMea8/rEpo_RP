<?php
	require_once($Prefix."classes/inv_tax.class.php");

	require_once($Prefix."classes/region.class.php");
	$objTax=new tax();

       $objRegion=new region();

	$ModuleName = 'Tax';

	$RedirectURL    = "viewTax.php?curP=".$_GET['curP'];
            


        
     		
    // Status Update tax into database	 
	 	 
	if(!empty($_GET['active_id'])){
		
		$objTax->changeTaxStatus($_GET['active_id']);
                $_SESSION['mess_tax'] = TAX_STATUS;
		header("location:".$RedirectURL);
	}

     // delete tax into database
	 
	if(!empty($_GET['del_id'])){
		
		$objTax->deleteTax($_GET['del_id']);
                $_SESSION['mess_tax'] = TAX_REMOVED;
		header("location:".$RedirectURL);
		exit;
	}
		


	
	// Add,Update tax into database	 
	 if ($_POST) {
				CleanPost();
	            if (!empty($_POST['taxId'])) {
	                    $_SESSION['mess_tax'] = TAX_UPDATED;
	                    $objTax->updateTax($_POST);
	                    header("location:".$RedirectURL);
	            } else {		
	                    
	                    $lastShipId = $objTax->addTax($_POST);
                            $_SESSION['mess_tax'] = TAX_ADDED;	
	                   header("location:".$RedirectURL);
	            }

	            exit;
		
	}
		

	
		if(!empty($_GET['edit'])){
		  
		     $arryTax = $objTax->getTaxById($_GET['edit']);

		 }
	
	
		
		if(!empty($arryTax) && $arryTax[0]['Status'] == 'No'){
			$TaxStatus = "No";
		}else{
			$TaxStatus = "Yes";
		}
                
		  
           $arryTaxClasses =$objTax->getClasses();

/*******Connecting to main database********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
if(!empty($arryTax) && $arryTax[0]['Coid']>0){
$arryCountryName = $objRegion->GetCountryName($arryTax[0]['Coid']);
$CountryName = stripslashes($arryCountryName[0]["name"]);
}

if(!empty($arryTax[0]['Stid'])) {
$arryState = $objRegion->getStateName($arryTax[0]['Stid']);
$StateName = stripslashes($arryState[0]["name"]);
}

if($Config['CurrentDepID']==5){
	$HideTd = 'style="display:none;" ';
	$arryTax[0]['ClassId'] = 'Sales';
}
?>

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
if($Config['CurrentDepID']==5){
	$HideTd = 'style="display:none;" ';
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
	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($arryTax[0]['RateDescription'])." Tax") :("Add  ".$ModuleName); ?></span>
		
		
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
	 <td  align="left"><input  name="RateDescription" id="RateDescription" value="<?= (isset($arryTax[0]['RateDescription'])) ? stripslashes($arryTax[0]['RateDescription']) : ''; ?>" type="text" class="inputbox"  size="50" />
	</td>
	</tr>

 

 <tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		
	<? $CountrySelected = '';
	if(!empty($arryTax) && isset($arryTax[0]['Coid']) &&  $arryTax[0]['Coid']!=''){
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
<tr <?=$HideTd?>>
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
<td  align="right" class="blackbold"> 
Tax Rate % :<span class="red">*</span> </td>
<td  align="left" valign="top">
<input  name="TaxRate" onkeypress="return isDecimalKey(event);" id="TaxRate" value="<?=(isset($arryTax[0]['TaxRate'])) ? $arryTax[0]['TaxRate'] : '';?>" type="text" class="textbox" size="10" maxlength="5" />
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
   <input type="hidden" value="<?=(isset($arryTax[0]['Stid'])) ? $arryTax[0]['Stid'] : '';?>" id="main_state_id" name="main_state_id">
   <input type="hidden" value="1" id="AllOption" name="AllOption">		
   <input name="Submit" type="submit" class="button" id="SubmitTax" value=" <?= $ButtonTitle ?> " />&nbsp;

</div>




</td>
   </tr>
 </form>
</table>

