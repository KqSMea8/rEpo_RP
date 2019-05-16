<?
	require_once($Prefix."classes/warehousing.class.php");
	require_once($Prefix."classes/supplier.class.php");
	$objCommon=new common();
	$objSupplier = new supplier();
	
	
	$_GET['att'] = (int)$_GET['att'];
	$_GET['edit'] = (int)$_GET['edit'];

	 
	if(empty($_GET['att'])){
		header("location:".$RedirectUrl);
		exit;
	}

	$arryAttribute=$objCommon->AllAttributes($_GET['att']);  
	$ModuleName = $arryAttribute[0]["attribute"];
	 

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = $ModuleName.REMOVED;
		$objCommon->deleteAttribute($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = $ModuleName.STATUS;
		$objCommon->changeAttributeStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if(!empty($_POST)) { 
		CleanPost();
		if (!empty($_POST['value_id'])) {
			$objCommon->updateAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.UPDATED;
		} else {		
			$objCommon->addAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.ADDED;
		}	
		
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$attribute_value ='';$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objCommon->getAttrib($_GET['edit'],'','');
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
		if($arryAtt[0]['FixedCol']==1){
			header("location:".$RedirectUrl);
			exit;
		}
	}
?>
<SCRIPT LANGUAGE=JAVASCRIPT>
var ModuleName = '<?=$ModuleName?>';
function ValidateForm(frm)
{
	if(  ValidateForSimpleBlank(frm.attribute_value, ModuleName) 
	){
		var Url = "isRecordExists.php?WAttribValue="+escape(document.getElementById("attribute_value").value)+"&attribute_id="+document.getElementById("attribute_id").value+"&editID="+document.getElementById("value_id").value;
		SendExistRequest(Url,"attribute_value",ModuleName);
		return false;
	}else{
		return false;	
	}
	

	
	
}

</SCRIPT>
  <div ><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$ModuleName?>  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:80px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   
                    <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> 
					  <?=$ModuleName?> :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top"><input  name="attribute_value" id="attribute_value" value="<?=stripslashes($attribute_value)?>" type="text" class="inputbox" maxlength="30" />
					  </td>
                    </tr>
					
	<?php 

if($arryAtt[0]['FixedCol']!="1" && $_GET['edit'] >0 && $_GET['att']=='6' ){ //Shipping Carrier
	$ShipCareers = explode(',', $arryCompany[0]['ShippingCareerVal']);
	foreach($ShipCareers as $ShipCareer){	
		$ShippingMethodArray[] = $ShipCareer;
	} 
	if(!in_array($attribute_value, $ShippingMethodArray)){

		 $_GET['Status'] = '1';
		$arryVendor = $objSupplier->GetSupplierList($_GET);
?>			
					
<tr>
	<td  align="right" class="blackbold">Vendor :</td>
	<td   align="left">		
		<select name="SuppCode" class="inputbox" id="SuppCode" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryVendor);$i++) {     ?>
		<option value="<?=$arryVendor[$i]['SuppCode']?>" <?php if($arryAtt[0]['SuppCode'] == $arryVendor[$i]['SuppCode']){echo "selected";}?>>
		<?=stripslashes($arryVendor[$i]["VendorName"])?></option>
		<? } ?>
		</select> 
	</td>
</tr>
<?php } } ?>				
                  
	
					
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status :</td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                      </td>
                    </tr>
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
			<? if(isset($_GET['edit']) && $_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="value_id" id="value_id" value="<?=$_GET['edit']?>">   
 	<input type="hidden" name="attribute_id" id="attribute_id" value="<?=$_GET['att']?>">   
 
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" /></td>
		  </tr>
	    </form>
</TABLE>
