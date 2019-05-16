<script src="../js/jquery.switchButton.js"></script>
<link rel="stylesheet" href="../css/jquery.switchButton.css">

<!--Amit Singh-->
<script type="text/javascript" src="js/password_strength.js"></script>
<style>
    #pswd-info-wrap, #pswd-retype-info-wrap {
        right: 228px !important;
    top: 480px !important;
    }
</style>
<!------------------------------------>

<script language="JavaScript1.2" type="text/javascript">
function validate_company(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateForTextareaMand(frm.Description,"Description",10,1000)
		&& ValidateOptionalUpload(frm.Image, "Image")
		&& ValidateForSimpleBlank(frm.ContactPerson, "Contact Person")
		&& ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& isEmailOpt(frm.AlternateEmail)
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidatePhoneNumber(frm.LandlineNumber,"Landline Number",10,20)
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		){
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}

function validate_DateTime(frm){

	if( ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")
		){
			ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_permission(frm){
	if( ValidateMandNumField(frm.MaxUser, "Allowed Number Of Users")
		){	ShowHideLoader('1','S');
			return true;	
		}else{
			return false;	
		}	
}


function validate_account(frm){
	if( //ValidateMandRange(frm.DisplayName, "Display Name",3,30)
		//&& isDisplayName(frm.DisplayName)
		ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){
		

			if(document.getElementById("Password").value!=""){
				if(!ValidateForSimpleBlank(frm.Password, "Password")){
					return false;
				}
				/*if(!isPassword(frm.Password)){
					return false;
				}*/
				if(!ValidateMandRange(frm.Password, "Password",5,15)){
					return false;
				}
				if(!ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)){
					return false;
				}
                                
                                //****************Amit Singh*******************/
                                var isvaldd=$('#isvalidate').val();
                                //alert(isvaldd);
                                if(isvaldd != '1'){ 
                                    alert("Please Enter Valid Password.");
                                   
                                    return false;	
                                }
                                //*********************************************/
			}

			if(!ValidateForSimpleBlank(frm.SecurityCodeAccount, "Security Code")){
				return false;
			}	
							
			var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("CmpID").value+"&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

			SendMultipleExistRequest(Url,"Email", "Email Address","DisplayName", "Display Name")
			
			return false;	
		}else{
			return false;	
		}	
}



function ShipCareer(){

	var checkedValue = $('#ShippingCareer:checked').val();

	if(checkedValue==1){

		$("#shipVal").show();
		
	}else{

		$("#shipVal").hide();
		$('#ShippingCareerVal0').attr('checked', false); // Unchecks it
		$('#ShippingCareerVal1').attr('checked', false); // Unchecks it
		$('#ShippingCareerVal2').attr('checked', false); // Unchecks it
		$('#ShippingCareerVal3').attr('checked', false); // Unchecks it
		

	}

}

$(document).ready(function(){
/*$('#RsID').change(function() {
    //alert($(this).val());
if($(this).val()>0){
$('#licen').show();
}
});*/

$('#License').click(function() {
    //alert($(this).val());
if($(this).val()==1){
$('#lamt').show();
}else{
$('#lamt').hide();

}
});


});
</script>




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_company'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Company Admin Details</td>
</tr>
<tr>
	 <td  align="right" valign="top" width="45%">Admin Url : </td>
 <td  align="left" valign="top">
<?
if($arryCompany[0]['Department']=='5'){
	$AdminUrl = $Config['Url']."crm/";
}else{
	$AdminUrl = $Config['Url'].$arryCompany[0]["DisplayName"].'/'.$Config['AdminFolder']."/";
}
echo $AdminUrl
?>
<br><b class=red><?=ADMIN_URL_MSG?></b><br>
</td>
</tr>
  <tr>
	 <td  align="right">Login Type : </td>
 <td  align="left">
Administrator
</td>
</tr>
  <tr>
	 <td  align="right">Login Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
  <tr>
	 <td  align="right">Login Password : </td>
 <td  align="left">
****************
</td>
</tr>


  <tr>
	 <td  align="right">Package : </td>
 <td  align="left">
<?=(!empty($arryCompany[0]['PaymentPlan']))?(ucfirst($arryCompany[0]['PaymentPlan'])):('None')?>
</td>
</tr>



 <tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		

<?=date("jS F, Y",strtotime($arryCompany[0]['JoiningDate']))?>

</td>
      </tr>

<? if($arryCompany[0]['ExpiryDate'] > 0){?>
<tr>
	<td align="right"   class="blackbold">Expiry Date  :</td>
	<td  align="left" >		

	<?=date("jS F, Y",strtotime($arryCompany[0]['ExpiryDate']))?>

	</td>
</tr>
<? } ?>




<? if($_GET["tab"]=="company"){ ?>
<tr>
	 <td colspan="2" align="left" class="head">Company Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" > Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryCompany[0]['CompanyName']); ?>"  maxlength="50" />            </td>
      </tr>

	
 <tr>
          <td align="right"   class="blackbold" valign="top">Description  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Description" type="text" class="bigbox" id="Description"><?=stripslashes($arryCompany[0]['Description'])?></textarea>			          </td>
        </tr>		  
	   


<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Logo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	
	<? if($arryCompany[0]['Image'] !='' && file_exists('../upload/company/'.$arryCompany[0]['Image']) ){ ?>
	<input name="OldImage" type="hidden" value="../upload/company/<?=$arryCompany[0]['Image']?>">
	<? } ?>
	
		</td>
  </tr>	  

	
	<tr>
        <td  align="right"   class="blackbold"> Contact Person  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="ContactPerson" type="text" class="inputbox" id="ContactPerson" value="<?php echo stripslashes($arryCompany[0]['ContactPerson']); ?>"  maxlength="30" />            </td>
      </tr>	 
  
        <tr>
          <td align="right"   class="blackbold" valign="top"> Address  :<span class="red">*</span></td>
          <td  align="left" >


            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryCompany[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >

<div style="position:relative;"><?  
$arryCurrentLocation[0]['Timezone'] = $arryCompany[0]['Timezone'];
$SupPrefx = '../admin/';
include("../admin/includes/html/box/clock.php"); ?></div>

		<?
	if($arryCompany[0]['country_id'] != ''){
		$CountrySelected = $arryCompany[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
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
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCompany[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCompany[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" height="30" valign="top">Zip Code  :<span class="red">*</span></td>
        <td  align="left"  valign="top" >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryCompany[0]['ZipCode'])?>" maxlength="15"   />	
		</td>
      </tr>
<tr>
        <td align="right"   class="blackbold" valign="top" >Current Timezone  : </td>
        <td  align="left"  valign="top" >
<?=$arryCompany[0]['Timezone']?>




		</td>
      </tr>

	 <tr>
        <td align="right"   class="blackbold" valign="top">Timezone Update  : </td>
        <td  align="left" >
<label>
	 <input name="TimezoneUpdate" type="checkbox" value="1" />	
<?=TIMEZONE_UPDATE_MSG?>
</label>
		</td>
      </tr>

	  
 <tr>
        <td align="right"   class="blackbold" >Email  : </td>
        <td  align="left" ><input name="AlternateEmail" type="text" class="inputbox" id="AlternateEmail" value="<?php echo $arryCompany[0]['AlternateEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 

       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryCompany[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold">Landline  :<span class="red">*</span></td>
        <td   align="left" >
	 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryCompany[0]['LandlineNumber'])?>"     maxlength="30" />			
	</td>
      </tr>


<tr>
        <td align="right"   class="blackbold" >Fax  :</td>
        <td  align="left"  >
	 <input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arryCompany[0]['Fax'])?>"     maxlength="30" />			</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arryCompany[0]['Website']))?($arryCompany[0]['Website']):("")?>"  maxlength="100" /> <?=$MSG[205]?></td>
      </tr>


	<tr>
        <td  align="right"   class="blackbold">EIN  :</td>
        <td   align="left" >
	 <input name="EIN" type="text" class="inputbox" id="EIN" value="<?=stripslashes($arryCompany[0]['EIN'])?>"     maxlength="20" onkeypress="return isPhoneKey(event);" />			
	</td>
      </tr>

<tr>
				<td align="right" class="blackbold">Allowed MultiSite :</td>
				<td align="left"><input name="MultiSite" type="text" class="inputbox"
					id="MultiSite"
					value="<?=(!empty($arryCompany[0]['MultiSite']))?($arryCompany[0]['MultiSite']):("")?>"
					maxlength="100" /> </td>
			</tr>
<? } ?>
 

<? if($_GET["tab"]=="permission"){ ?>

<tr>
	 <td colspan="2" align="left" class="head">Permission Details</td>

</tr>
<tr>
	<td align="right"   class="blackbold" valign="top" width="45%">Allowed Number Of Users  :<span class="red">*</span></td>
	<td  align="left"  >
	<input name="MaxUser" type="text" class="textbox" size="7" id="MaxUser" value="<?=stripslashes($arryCompany[0]['MaxUser'])?>" maxlength="15" onkeypress="return isNumberKey(event);"/>	
	
 
 
 </td>
  </tr>

<tr>
	<td align="right"   class="blackbold" valign="top">Data Storage Limit   :</td>
	<td  align="left"  >
		<input name="StorageLimit" type="text" class="textbox" size="7" id="StorageLimit" value="<?=stripslashes($arryCompany[0]['StorageLimit'])?>" maxlength="15" onBlur="Javascript: StorageUnit();"/>
<!--<select name="StorageLimit" id="StorageLimit" class="textbox" onChange="Javascript: StorageUnit();">
	<?
	/*echo '<option value=""> Unlimited </option>';
	for($i=0;$i<=100;$i=$i+5){	
		$val = $i;	
		if($val==0) $val=1;
		$sel = ($arryCompany[0]['StorageLimit']==$val)?('selected'):('');
		echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
	} */
	?>
</select--> 

<select name="StorageLimitUnit" id="StorageLimitUnit" class="textbox">
<option value="GB" <?=($arryCompany[0]['StorageLimitUnit']=="GB")?('selected'):('')?>> GB </option>
<option value="TB" <?=($arryCompany[0]['StorageLimitUnit']=="TB")?('selected'):('')?>> TB </option>
</select> 

<SCRIPT LANGUAGE=JAVASCRIPT>
StorageUnit();
</SCRIPT>

 </td>

<tr>
        <td  align="right"   class="blackbold"  valign="top" > Allowed Module  : </td>
        <td   align="left" style="line-height:26px;" >
		
<?
$arrCmpDept =  array();
if(!empty($arryCompany[0]['Department'])){
	$arrCmpDept = explode("," , $arryCompany[0]['Department']);
}
?>


<label><input type="checkbox" name="Department[]" id="Department0" value="" <?=($arryCompany[0]['Department']=="")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_ERP?> <br></label>

<label><input type="checkbox" name="Department[]" id="Department1" value="1" <?=in_array("1",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_HRMS?> <br></label>
		
<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department2" value="5" <?=in_array("5",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_CRM?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department3" value="2" <?=in_array("2",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_ECOMMERCE?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department4" value="3,4,6,7,8" <?=in_array("6",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_INVENTORY?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department5" value="9" <?=in_array("9",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff(); SetDomain();" /> <?=MOD_WEBSITE?> <br></label>
		
<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department6" value="12" <?=in_array("12",$arrCmpDept)?("checked"):("")?> onclick="Javascript:SetModuleOff(); SetDomain();" /> <?=MOD_POS?> <br></label>		
<!-- EDI  -->
	<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department7" value="13" <?=(in_array("13", $arrCmpDept))?("checked"):("");?> onclick="Javascript:SetModuleOff(); SetDomain();" /> <?=MOD_EDI?> <br> </label>  <!-- End EDI  -->


</td>
 </tr>

<tr id="trtext" style="display:none;">
	<td align="center"   class="blackbold" valign="top" width="45%" colspan="2">If you leave blank then it id default domain.</td>
	
  </tr>
<tr id="trErpDomain" style="display:none;">
	<td align="right"   class="blackbold" valign="top" width="45%">ERP Domain Name / IP :</td>
	<td  align="left"  >
	<input name="ErpDomain" type="text" class="inputbox" size="7" id="ErpDomain" value="<?=stripslashes($arryCompany[0]['ErpDomain'])?>" />	
	
 
 
 </td>
  </tr>
<tr id="trWebDomain" style="display:none;">
	<td align="right"   class="blackbold" valign="top" width="45%">Website Domain Name / IP :</td>
	<td  align="left"  >
	<input name="WebDomain" type="text" class="inputbox" size="7" id="WebDomain" value="<?=stripslashes($arryCompany[0]['WebDomain'])?>" />	
	
 
 
 </td>
  </tr>
<tr>
        <td  align="right"   class="blackbold" 
		>Track Inventory  : </td>
        <td   align="left"  >
          <? 
		$TrackChecked = ' checked';
		if($_GET['edit'] > 0){
		 if($arryCompany[0]['TrackInventory'] == 1) {$TrackChecked = ' checked'; $InTrackChecked ='';}
		 if($arryCompany[0]['TrackInventory'] == 0) {$TrackChecked = ''; $InTrackChecked = ' checked';}
		}
	  ?>
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="1" <?=$TrackChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="0" <?=$InTrackChecked?> />
          No</label> </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" 
		>Hostbill  Setting : </td>
        <td   align="left"  >
          <? 
		$InHostbillChecked = ' checked';
		if($_GET['edit'] > 0){
		 if($arryCompany[0]['Hostbill'] == 1) {$HostbillChecked = ' checked'; $InHostbillChecked ='';}
		 if($arryCompany[0]['Hostbill'] == 0) {$HostbillChecked = ''; $InHostbillChecked = ' checked';}
		}
	  ?>
          <label><input type="radio" name="Hostbill" id="Hostbill" value="1" <?=$HostbillChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="Hostbill" id="Hostbill" value="0" <?=$InHostbillChecked?> />
          No</label> </td>
      </tr>


 <? } ?>

<? if($_GET["tab"]=="warehouse"){ ?>
<!---Batch Management added by chetan 16May--->
<tr>
       		 <td colspan="2" align="left" class="head">Batch</td>
        </tr>
<tr>
        <td  align="right"   class="blackbold"  
        >Batch Management  : </td>
        <td   align="left"  >
          <?  
        $batchChecked = ' checked';
        if($_GET['edit'] > 0){
         if($arryCompany[0]['batchmgmt'] == 1) {$batchChecked = ' checked'; $InbatchChecked ='';}
         if($arryCompany[0]['batchmgmt'] == 0) {$batchChecked = ''; $InbatchChecked = ' checked';}
        }
      ?>
          <label><input type="radio" name="batchmgmt" id="batchmgmt" value="1" <?=$batchChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="batchmgmt" id="batchmgmt" value="0" <?=$InbatchChecked?> />
          No</label> </td>
      </tr>
<!--End-->


<tr>
					<td align="right" class="blackbold">Shipping Career:</td>
					<td align="left"><?  
					$shipCareerChecked = 'checked';
					if($_GET['edit'] > 0){
						if($arryCompany[0]['ShippingCareer'] == 1) {$shipCareerChecked = 'checked'; $shipC ='';}
						if($arryCompany[0]['ShippingCareer'] == 0) {$shipCareerChecked = ''; $shipC = 'checked';}
					}
					?> <label><input type="radio" name="ShippingCareer"
						id="ShippingCareer" value="1" <?=$shipCareerChecked?> onclick="Javascript:ShipCareer();" /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="ShippingCareer"
						id="ShippingCareer" value="0" <?=$shipC?> onclick="Javascript:ShipCareer();" /> No</label></td>
				</tr>

				<?php
				$ship=explode(",", $arryCompany[0]['ShippingCareerVal']);

				?>

				<tr id="shipVal">
					<td align="right" class="blackbold" valign="top">Allowed Ship
					Career :</td>
					<td align="left" style="line-height: 26px;"><label><input
						type="checkbox" name="ShippingCareerVal[]" id="ShippingCareerVal0"
						value="Fedex" <?if(in_array('Fedex',$ship)){echo "checked";}?> />Fedex<br>
					</label> <label><input type="checkbox" name="ShippingCareerVal[]"
						id="ShippingCareerVal1" value="UPS"
						<?if(in_array('UPS',$ship)){echo "checked";}?> />UPS<br>
					</label> <label><input type="checkbox" name="ShippingCareerVal[]"
						id="ShippingCareerVal2" value="USPS"
						<?if(in_array('USPS',$ship)){echo "checked";}?> />USPS <br>
					</label> <label><input type="checkbox" name="ShippingCareerVal[]"
						id="ShippingCareerVal3" value="DHL"
						<?if(in_array('DHL',$ship)){echo "checked";}?> />DHL<br>
					</label></td>
				</tr>


<SCRIPT LANGUAGE=JAVASCRIPT>
ShipCareer();
</SCRIPT>
<? }?>




<? if($_GET["tab"]=="currency"){ 



/********Connecting to main database*********/
$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];

$Config['DbName2'] = $CmpDatabase;
if(!$objConfig->connect_check()){
	echo $ErrorMsg = ERROR_NO_DB;exit;
}else{
	$Config['DbName'] = $CmpDatabase;
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
}
/*******************************************/

$NumPaymentTable = $objConfigure->NumPaymentTable();
 
if($NumPaymentTable>0){
	$ClassName = 'disabled_inputbox';
	$Disabled = 'Disabled';
	$DisablesMsg =  CURRENCY_DISABLE_MSG;
}else{
	$ClassName = 'inputbox';
}
?>
<tr>
       		 <td colspan="2" align="left" class="head">Currency Details</td>
        </tr>
		<tr>
       		 <td colspan="2" height="10"></td>
        </tr>
	  <tr>
        <td  align="right"   class="blackbold" width="45%">Base Currency  :</td>
        <td   align="left" >
		<?
		if($arryCompany[0]['currency_id'] != ''){
			$CurrencySelected = $arryCompany[0]['currency_id']; 
		}else{
			$CurrencySelected = 9;
		}
		?>
            <select name="currency_id" class="<?=$ClassName?>" <?=$Disabled?>  id="currency_id">
              <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
              <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>>
              <?=$arryCurrency[$i]['name']?>
              </option>
              <? } ?>
            </select>   <?=$DisablesMsg?>     </td>
      </tr>
	  
	  	  
<tr>
       		 <td colspan="2" height="10"></td>
        </tr>

	  <tr>
        <td  align="right"   class="blackbold" valign="top">Additional Currency :</td>
        <td   align="left" >
<div id="PermissionValue" style="width:600px; height:300px; overflow:auto">
	<? 
	$arryAddCurrency = explode(",", $arryCompany[0]['AdditionalCurrency']);
	for($i=0;$i<sizeof($arryCurrency);$i++) {?>
	<div style="float:left;width:180px;"><label><input type="checkbox" name="AdditionalCurrency[]" id="AdditionalCurrency" value="<?=$arryCurrency[$i]['code']?>" <?=in_array($arryCurrency[$i]['code'],$arryAddCurrency)?("checked"):("")?>  /> <?=$arryCurrency[$i]['name']?> </label></div>
	<? } ?>
 </div>           



       </td>
      </tr>

<tr>
       		 <td colspan="2" height="10"></td>
        </tr>

<tr>
        <td  align="right"   class="blackbold" valign="top">Currency Conversion  : </td>
        <td   align="left"  >
          <?  
		$CurrencyToBase = ' checked';
		if($_GET['edit'] > 0){
		 if($arryCompany[0]['ConversionType'] == 0) {$CurrencyToBase = ' checked'; $BaseToCurrency ='';}
		 if($arryCompany[0]['ConversionType'] == 1) {$CurrencyToBase = ''; $BaseToCurrency = ' checked';}
		}
	  ?>
          <label><input type="radio" name="ConversionType" id="ConversionType1" value="0" <?=$CurrencyToBase?>   <?=$Disabled?> />
          Currency to Base </label><br><br>
          <label><input type="radio" name="ConversionType" id="ConversionType2" value="1" <?=$BaseToCurrency?>  <?=$Disabled?> />
           Base to Currency</label> </td>
      </tr>

	<tr>
       		 <td colspan="2" height="10"></td>
        </tr>

 <? } ?>

<? if($_GET["tab"]=="DateTime"){ ?>

		<tr>
       		 <td colspan="2" align="left" class="head">DateTime Settings</td>
        </tr>
  <tr>
        <td align="right"   class="blackbold" valign="top" width="45%">Timezone  :<span class="red">*</span></td>
        <td  align="left"  valign="top" >

<div style="position:relative;"><?  
$arryCurrentLocation[0]['Timezone'] = $arryCompany[0]['Timezone'];
$SupPrefx = '../admin/';
include("../admin/includes/html/box/clock.php"); ?></div>


<script>
  $(function() {
	$('#Timezone').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<?=getTimeZone($arryCompany[0]['Timezone'])?>

<script>
GetLocalTime();
</script>
		</td>
      </tr>
	<tr>
       		 <td colspan="2" height="20"></td>
        </tr>	


 <tr>
        <td align="right"   class="blackbold"  >Session Timeout  :</td>
        <td  align="left"   > 
<select name="SessionTimeout" id="SessionTimeout" class="textbox">
	<?
	echo '<option value=""> None </option>';
	for($i=5;$i<=60;$i=$i+5){
		$val = $i*60;
		$sel = ($arryCompany[0]['SessionTimeout']==$val)?('selected'):('');
		echo '<option value="'.$val.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select> &nbsp;Minutes
	  	</td>
      </tr>
<tr>
       		 <td colspan="2" height="20"></td>
        </tr>


	  <tr>
        <td align="right"   class="blackbold" valign="top" >Date Format  :<span class="red">*</span></td>
        <td  align="left"  valign="top" > 
		
<?
	$Today = date("Y-m-d");
	if(empty($arryCompany[0]['DateFormat'])) $arryCompany[0]['DateFormat'] = "Y-m-d";
	for($i=0;$i<sizeof($arrayDateFormat);$i++) {?>
<div style="float:left; width:250px; height:30px;">
 <label><input type="radio" name="DateFormat" value="<?=$arrayDateFormat[$i]['DateFormat']?>" <?  if($arrayDateFormat[$i]['DateFormat']==$arryCompany[0]['DateFormat']){echo "checked";}?>/> <?=date($arrayDateFormat[$i]['DateFormat'], strtotime($Today))?></label>
</div>
<? } ?>	
		



	  	</td>
      </tr>


 <tr>
        <td align="right"   class="blackbold"  >Time Format  :</td>
        <td  align="left"   > 
<select name="TimeFormat" id="TimeFormat" class="textbox">
<option value="H:i:s" <?=($arryCompany[0]['TimeFormat']=='H:i:s')?('selected'):('')?> > 24 Hour </option>
<option value="h:i:s a" <?=($arryCompany[0]['TimeFormat']=='h:i:s a')?('selected'):('')?> > am / pm </option>
</select> 
	  	</td>
      </tr>



<? } ?>

	
    <? if($_GET["tab"]=="default"){?>
            
<!--tr>
        <td colspan="2" align="left" class="head">Default Company Details</td>
        </tr>
<tr>
        <td  align="right"   class="blackbold" 
>Default Company: </td>
        <td   align="left"  >
          <? 
   $ActiveChecked = ' checked';
 if($_GET['edit'] > 0){
 if($arryCompany[0]['DefaultCompany'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
 if($arryCompany[0]['DefaultCompany'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
}
  ?>
          <label><input type="radio" name="DefaultCompany" id="DefaultCompany" value="1" <?=$ActiveChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="DefaultCompany" id="DefaultCompany" value="0" <?=$InActiveChecked?> />
          No</label> </td>
      </tr-->
        
        
    <? } ?>    

  
<? if($_GET["tab"]=="account"){ ?>
	
	<tr>
       		 <td colspan="2" align="left" class="head">Account Details</td>
        </tr>
		
   <tr>
        <td  align="right"   class="blackbold"> Display Name  : </td>
        <td   align="left" >
<!--
<input name="DisplayName" type="text" class="inputbox" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');" onBlur="Javascript:CheckAvailField('MsgSpan_Display','DisplayName','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Display"></span>
-->
<?=stripslashes($arryCompany[0]['DisplayName'])?>
<input name="DisplayName" type="hidden" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  />



</td>
      </tr>

      <tr>
        <td  align="right"   class="blackbold" >Login Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	 
        <tr>
        <td  align="right"   class="blackbold">New Password : </td>
        <td   align="left" class="blacknormal">
            <input name="Password" type="Password" class="inputbox" id="Password" value=""  maxlength="15" /> 
		<span class="passmsg">(Leave it blank, if do not want to change password.)</span>
		<?php require_once("password_strength_html.php"); ?>
		</td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password : </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value=""  maxlength="15" /> </td>
      </tr>	
	
 <? if($arryCompany[0]['JoiningDate'] > 0){?>

   <tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		

<?=date("jS F, Y",strtotime($arryCompany[0]['JoiningDate']))?>

</td>
      </tr>


<tr>
        <td  align="right"   > Expiry Date :  </td>
        <td   align="left" >
<? if($arryCompany[0]['ExpiryDate']>0)$ExpiryDate = $arryCompany[0]['ExpiryDate'];?>		
<script>
$(function() {
$( "#ExpiryDate" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")+20?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#expNone").on("click", function () { 
		$("#ExpiryDate").val("");
	}
	);	

});
</script>
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$ExpiryDate?>"  type="text" >         

&nbsp;&nbsp;&nbsp;&nbsp;<a href="Javascript:void(0);" id="expNone">None</a>


</td>
      </tr>

     
	  
<? } ?>	  
	
 <tr>
				<td align="right" class="blackbold">Default Company For Inventory:</td>
				<td align="left"><? 
				$ActiveChecked = ' checked';
				if($_GET['edit'] > 0){
					if($arryCompany[0]['DefaultInventoryCompany'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					if($arryCompany[0]['DefaultInventoryCompany'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
				?> <label><input type="radio" name="DefaultInventoryCompany"
					id="DefaultInventoryCompany" value="1" <?=$ActiveChecked?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="DefaultInventoryCompany"
					id="DefaultInventoryCompany" value="0" <?=$InActiveChecked?> /> No</label>
				</td>
			</tr>
	<tr>
				<td align="right" class="blackbold">Automatic Sync:</td>
				<td align="left"><? 
				$ActiveChecked = ' checked';
				if($_GET['edit'] > 0){
					if($arryCompany[0]['AutomaticSync'] == 'Yes') {$ActiveChecked = ' checked'; $InActiveChecked ='';}
					if($arryCompany[0]['AutomaticSync'] == 'No') {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
				?> <label><input type="radio" name="AutomaticSync"
					id="AutomaticSync" value="Yes" <?=$ActiveChecked?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="AutomaticSync"
					id="AutomaticSync" value="No" <?=$InActiveChecked?> /> No</label>
				</td>
			</tr>

<tr>
        <td  align="right"   class="blackbold" 
>Reseller : </td>
        <td   align="left"  >
<select name="RsID" id="RsID" class="inputbox">
	<option value=""> None </option>
<?

foreach($arryReseller as $keyr=>$values_rs){
	$selr = ($arryCompany[0]['RsID']==$values_rs['RsID'])?('selected'):('');
	echo '<option value="'.$values_rs['RsID'].'" '.$selr.'>'.stripslashes($values_rs['CompanyName']).'</option>';

}
?>
</select>
      </tr>	  
	<tr>
       		 <td colspan="2" align="left" class="head">Licensee</td>
        </tr>
<tr id="licen" >
        <td  align="right"   class="blackbold" 
>Licensee : </td>
        <td   align="left"  >
          <? 
   $ActiveChecked = ' checked';
 if($_GET['edit'] > 0){
$desPlay = ($arryCompany[0]['License']>0)?(''):('display:none;');
 if($arryCompany[0]['License'] == 1) {$ActiveLicense = ' checked'; $InActiveLicense ='';}
 if($arryCompany[0]['License'] == 0) {$ActiveLicense= ''; $InActiveLicense = ' checked';}
}
  ?>
          <label><input type="radio" name="License" id="License" value="1" <?=$ActiveLicense?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="License" id="License" value="0" <?=$InActiveLicense?> />
          No</label> </td>
      </tr>	
<tr id="lamt" style="<?=$desPlay?>">
        <td  align="right"   class="blackbold" 
>License Amount: </td>
        <td   align="left"  >
<select name="LicenseAmtype" id="LicenseAmtype" class="textbox">
	<option value=""> None </option>
<?

	$selrval = ($arryCompany[0]['LicenseAmtype']=='Percentage')?('selected'):('');
$selrval2 = ($arryCompany[0]['LicenseAmtype']=='Amount')?('selected'):('');
	echo '<option value="Percentage" '.$selrval.'>Percentage(%)</option>';
echo '<option value="Amount" '.$selrval2.'>Amount</option>';


?>
</select>&nbsp;&nbsp;<input id="LicenseAmt" name="LicenseAmt"  class="textbox" value="<?=$arryCompany[0]['LicenseAmt']?>"  type="text" > 
      </tr>	

     
<tr>
        <td  align="right"   class="blackbold" 
>Default Company : </td>
        <td   align="left"  >
       <input type="checkbox" name="DefaultCompany" id="DefaultCompany" value="1"  <?  if($arryCompany[0]['DefaultCompany'] == '1') {echo 'checked';}  ?> ></td>

</td>
      </tr>	  
	


 
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
             <input type="checkbox" name="Status" id="Status" value="1"  <?  if($arryCompany[0]['Status'] == '1') {echo 'checked';}  ?> ></td>
      </tr>
 

<tr>
        <td  align="right"   class="blackbold" 
		>Live Mode  : </td>
        <td   align="left"  >
          
          <!--label><input type="radio" name="LiveMode" id="LiveMode" value="1"  <?  if($arryCompany[0]['LiveMode'] == '1') {echo 'checked';}  ?> />
          Live</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="LiveMode" id="LiveMode" value="0"   <?  if($arryCompany[0]['LiveMode'] != '1') {echo 'checked';}  ?>/>
          Test</label--> 


   
        <input type="checkbox" name="LiveMode" id="LiveMode" value="1"  <?  if($arryCompany[0]['LiveMode'] == '1') {echo 'checked';}  ?> >
     

 

 
<script>
      $(function() { 
	
	 $("#DefaultCompany").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	});      
        $("#Status").switchButton({ 
		on_label: 'Active',
          	off_label: 'InActive' 
	});
	$("#LiveMode").switchButton({ });
	 

      })
</script>

</td>
      </tr>


<tr>
       		 <td colspan="2" align="left" class="head">Security Code	</td>
        </tr>
<tr>
        <td  align="right"   class="blackbold"> Enter Security Code :<span class="red">*</span> </td>
        <td   align="left" >

<input name="SecurityCodeAccount" type="password" class="inputbox" id="SecurityCodeAccount" value=""  maxlength="50" autocomplete="off" /> 
&nbsp; &nbsp; 
<a class="fancybox fancybox.iframe" href="sendSecurityCode.php?CmpID=<?=$CmpID?>">Send Security Code</a> 


</td>
      </tr>
	
 <? } ?>	
<? if($_GET["tab"]=="syncInventory"){ ?>

			<tr>
				<td colspan="2" align="left" class="head">Sync Inventory</td>
			</tr>
			<tr>
				<td class="blackbold">Action</td>
				<td>
				<?php //print_r(json_decode($arryCompany[0]['AutomaticSyncAction'],true));
				$AutomaticSyncActionArray=json_decode($arryCompany[0]['AutomaticSyncAction'],true);
				?>
				<input type="checkbox" name="AutomaticSyncAction[]" value="add" checked="checked" onclick="return false" readonly>Add
				<input type="checkbox" name="AutomaticSyncAction[]" value="update"<?php if(!empty($AutomaticSyncActionArray)) { if(in_array('update',$AutomaticSyncActionArray)) { ?> checked="checked"<?php } } ?> >Update
				<!--<input type="checkbox" name="AutomaticSyncAction[]" value="delete" <?php if(in_array('delete',$AutomaticSyncActionArray)) { ?> checked="checked"<?php }?>>Delete
				--></td>
				</tr>
			<tr>
				<td colspan="2" class="blackbold">
			<div>
			<?php 
				$SyncInventorySetting=json_decode($arryCompany[0]['SyncInventorySetting'],true) ;
				
				$ManufactureArray=array('all');
				foreach($AllManufacture as $Manufacture){
					array_push($ManufactureArray,$Manufacture['attribute_value']);
				}


				$arrayforSync=array('category',
				'items',
				'dimensions',
				array( 'required items'=>array('independent','with items') ),
				array('alias items'=>array('independent','with items')) ,
				'BOM',
				array('setting'=>array('global attributes','procurement','valuation type','adjustment reason'
				,'manage prefixes','manage model','manage generation','manage extended','manage manufacture'=>$ManufactureArray,'manage condition','reorder method','manage unit','item type')) );

						
				?>

				
				<?php
				$str='';
				

				foreach($arrayforSync as $key=>$value){
					if(is_array($value)){
						$class=trim(str_replace(' ','',key($value)) );
						$display='style="display:none;"';
						$str .='<div class="sync_inventory_section">
							<input type="checkbox" name="syncInventory['.$key.']" value="'.key($value).'" onclick="setDisplay(this.checked,\'sync'.$key.'\',\''.$class.'\')" ';
						if(ArrayMultiSerach(key($value), $SyncInventorySetting,'')){
							$str .='checked="checked"';
							$display='';

						}
						if(!empty($SyncCountArray[key($value)]))
						$str .='>'.ucfirst(key($value)).' ( '.$SyncCountArray[key($value)].' )
							<div id="sync'.$key.'" '.$display.'>';
						else $str .='>'.ucfirst(key($value)).'
							<div id="sync'.$key.'" '.$display.'>';
						
						$count=0;
						foreach($value[key($value)] as $key1=>$val1){
							
							if(is_array($val1)){
								
								$class1=trim(str_replace(' ','',$key1) );
								$display1='style="display:none;"';
								$str .='<div class="child_sync_section">
							<input type="checkbox" name="syncInventory['.$key.']['.key($value).']['.$count.']" value="'.$key1.'" onclick="setDisplay(this.checked,\'sync'.$class1.'\',\''.$class1.'\')"';
								
								
								if(ArrayMultiSerach($key1, $SyncInventorySetting, key($value))){
									$str .='checked="checked"';
									$display1='';
								}

								if($SyncCountArray[$key1]!='')
								$str .='>'.ucfirst($key1).' ( '.$SyncCountArray[$key1].' )';
								else $str .='>'.ucfirst($key1).'';

								$str .='<div id="sync'.$class1.'"  '.$display.' >';
								foreach($val1 as $key2=>$val2){
									
									$str .='<div class="child_sync_section">
									<input type="checkbox" name="syncInventory['.$key.']['.key($value).']['.$count.']['.$key1.'][]" value="'.$val2.'"';

									if(ArrayMultiSerach($val2, $SyncInventorySetting, $key1)){
										$str .='checked="checked"';

									}

									$str .='>'.ucfirst($val2).'</div>';


								}

								$str .='</div>';

								$str .='</div>';
									
							}else{

								if($val1=='independent'){
									$str .='<div class="child_sync_section">
							<input type="radio" name="syncInventory['.$key.']['.key($value).'][]" class="'.$class.'" value="'.$val1.'"';
								}
								elseif($val1=='with items'){
									$str .='<div class="child_sync_section">
							<input type="radio" name="syncInventory['.$key.']['.key($value).'][]" class="'.$class.'" value="'.$val1.'"';
								}else{
									$str .='<div class="child_sync_section">
							<input type="checkbox" name="syncInventory['.$key.']['.key($value).'][]" value="'.$val1.'"';
								}
									

								
								
								if(ArrayMultiSerach($val1, $SyncInventorySetting, key($value))){
									$str .='checked="checked"';

								}
									
								if(!empty($SyncCountArray[$val1]))
								$str .='>'.ucfirst($val1).' ( '.$SyncCountArray[$val1].' )</div>';
								else $str .='>'.ucfirst($val1).'</div>';
							}
							$count++;
						}
						$str .='</div></div>';
					}else{

						$str .='<div class="sync_inventory_section">
							<input type="checkbox" name="syncInventory['.$key.']" value="'.$value.'" ';
						if(!empty($SyncInventorySetting)){
						if(in_array($value, $SyncInventorySetting)){
							$str .='checked="checked"';
						}
						}
						$str .='>'.ucfirst($value).' ( '.$SyncCountArray[$value].' )
							</div>';
					}


				}
				echo $str;
				?>

					
				
				</div>	</td>

			</tr>






			<? } ?>	







<? if($_GET["tab"]=="pos"){ ?>

<tr>
       		 <td colspan="2" align="left" class="head">POS</td>
        </tr>
<tr>
        <td  align="right"   class="blackbold"  
        >Generate Invoice  : </td>
        <td   align="left"  >
          <?  
        $invoiceChecked = ' checked'; $InvoiceUnChecked ='';
        if($_GET['edit'] > 0){
         if($arryCompany[0]['PosInvoice'] == 1) {$invoiceChecked = ' checked'; $InvoiceUnChecked ='';}
         if($arryCompany[0]['PosInvoice'] == 0) {$invoiceChecked = ''; $InvoiceUnChecked = ' checked';}
        }
      ?>
          <label><input type="radio" name="PosInvoice" id="PosInvoice" value="1" <?=$invoiceChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="PosInvoice" id="PosInvoice" value="0" <?=$InvoiceUnChecked?> />
          No</label> </td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold"  
        > POS Ecommerce  : </td>
        <td   align="left"  >
          <?  
        $PosEcommChecked = ' checked';$PosEcommUnChecked ='';
        if($_GET['edit'] > 0){
         if($arryCompany[0]['PosEcomm'] == 1) {$PosEcommChecked = ' checked'; $PosEcommUnChecked ='';}
         if($arryCompany[0]['PosEcomm'] == 0) {$PosEcommChecked = ''; $PosEcommUnChecked = ' checked';}
        }
      ?>
          <label><input type="radio" name="PosEcomm" id="PosEcomm" value="1" <?=$PosEcommChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="PosEcomm" id="PosEcomm" value="0" <?=$PosEcommUnChecked?> />
          No</label> </td>
      </tr>
	

 

				


<? }?>




	
</table>	
  





	
	  
	
	</td>
   </tr>

   
<?
if($_SESSION['AdminType']=="user"){ 
	$CurrPageName = 'editCompany.php?tab='.$_GET['tab'];
	$arrayPageDt = $objUserConfig->GetHdMenuByLinkFooter($_SESSION['AdminID'],$CurrPageName);

}else{
	$arrayPageDt[0]['ModifyLabel']=1;
}



?>


   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	
	<? 
if($arrayPageDt[0]['ModifyLabel']==1){

if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

&nbsp;&nbsp;<input name="Reset" type="reset" class="button" id="ResetButton" value=" Reset "  />

<? } ?>


<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryCompany[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCompany[0]['city_id']; ?>" />

</div>

</td>
   </tr>


   </form>
</table>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="company"){ ?>
	StateListSend();
<? } ?>


function setDisplay(ch,DivID,classname){
	if(ch){
		$('#'+DivID).show();
		var allButtons = document.getElementsByClassName(classname);
		for (i=0; i<allButtons.length; i++) {			
		    allButtons[i].checked = true;
		}
	}else{
		$('#'+DivID).hide();

		var allButtons = document.getElementsByClassName(classname);
		for (i=0; i<allButtons.length; i++) {
		    allButtons[i].checked = false;
		}
	}
	
	
}
</SCRIPT>



