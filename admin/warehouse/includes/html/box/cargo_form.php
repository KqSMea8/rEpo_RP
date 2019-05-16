<script language="JavaScript1.2" type="text/javascript">
function validateCargo(frm){

	var DataExist=0;
	/**********************/
	var SuppCode = Trim(document.getElementById("SuppCode")).value;
	
	if(SuppCode!=''){
		if(!ValidateMandRange(document.getElementById("SuppCode"), "Vendor Code",3,20)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php","&SuppCode="+escape(SuppCode), "SuppCode","Vendor Code");
		//alert(DataExist);
		//return false;
		if(DataExist==1)return false;

	}
	/**********************/
		if(!ValidateForSimpleBlank(frm.ShipmentNo, "Shipment Number")){
		return false;
	}

	if(!ValidateForSimpleBlank(frm.PackageLoad, "Package Load")){
		return false;
	}
	
	/**********************/
	
	if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
		return false;
	}

	if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
		return false;
	}
	/**********************/
		
	if(!ValidateForSimpleBlank(frm.LicenseNo, "License No")){
		return false;
	}
	
	
	DataExist = CheckExistingData("isRecordExists.php", "&Type=LicenseNo&Email="+escape(document.getElementById("LicenseNo").value), "LicenseNo","Email Address");
	if(DataExist==1)return false;
	/**********************/

	if( ValidateForTextareaMand(frm.Address,"Address",10,200)
		){
				
				ShowHideLoader('1','S');
				/*	var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value+"&CompanyName="+escape(document.getElementById("CompanyName").value)+"&Type=Supplier";
				SendMultipleExistRequest(Url,"Email", "Email Address","CompanyName", "Company Name")
				return false;	
				*/
				return true;
					
		}
		
		
	if(!ValidateForSimpleBlank(frm.Mobile, "Mobile No")){
		return false;
	}
	
	if(ValidateOptPhoneNumber(frm.Mobile, "Mobile No")){
		return false;
	}
	

	else{
				return false;	
		}	
		
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCargo(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td colspan="4" align="left" class="head">General Information</td>
</tr>
<tr>
        <td  align="right" width="25%"   class="blackbold"> Release Number  : </td>
	<td   align="left"  >	<input name="SuppCode" type="text" class="datebox" id="SuppCode" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_CargoCode');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_CargoCode','SuppCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_CargoCode"></span>
        
	</td>
</tr>
   




  <tr>
        <td  align="right"   class="blackbold" >Release Date :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ReleaseDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-50?>:<?=date("Y")?>', 
		maxDate: "-1D", 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$ReleaseDate = ($arrySupplier[0]['ReleaseDate']>0)?($arrySupplier[0]['ReleaseDate']):(""); 
?>
<input id="ReleaseDate" name="ReleaseDate" readonly="" class="datebox" value="<?=$ReleaseDate?>"  type="text" > 


</td>
     
        <td  align="right" class="blackbold">Released By  :</td>
       	<td   align="left" width="30%">
				<input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arryCargo[0]['ReleaseBy']); ?>"  maxlength="40" readonly />
				<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arryCargo[0]['SalesPersonID']); ?>" type="hidden">
	
				<a class="fancybox fancybox.iframe" href="EmpList.php?dv=7"  ><?=$search?></a>
				

			</td>
 
</tr>

<tr>
        <td  align="right" class="blackbold">Release To  :</td>
         <td   align="left" >
		<input name="CustomerName" type="text" class="disabled_inputbox"  id="CustomerName" value="<?php echo stripslashes($arryCargo[0]['ReleaseTo']); ?>"  maxlength="60" readonly />
		<input name="CustCode" id="CustCode" type="hidden" value="<?php echo stripslashes($arryCargo[0]['CustCode']); ?>">
		<input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arryCargo[0]['CustID']); ?>">
	

	<a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>

	</td>

        <td  align="right" class="blackbold">Carrier Name  :</td>
        <td   align="left">
		  <select name="CarrierName" class="inputbox" id="CarrierName">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arrySupplier[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>
<tr>
       		 <td colspan="4" align="left"   class="head">Package Information</td>
        </tr>
   
	   <tr>
        <td  align="right"   class="blackbold"> Shipment Number  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="ShipmentNo" type="text" class="disabled" id="ShipmentNo" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
     
        <td  align="right"   class="blackbold"> Package Load  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="PackageLoad" type="text" class="inputbox" id="PackageLoad" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" />  </td>
      </tr>
	


	<tr>
       		 <td colspan="4" align="left"   class="head">Driver Information</td>
        </tr>
   
	  
<tr>
        <td  align="right"   class="blackbold"  > First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
     
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   
 <tr>
        <td  align="right"   class="blackbold"> Licence Number :<span class="red">*</span> </td>
        <td   align="left" ><input name="LicenseNo" type="text" class="inputbox" id="LicenseNo" value="<?php echo $arrySupplier[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','LicenseNo','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
     
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arrySupplier[0]['Address'])?></textarea>			          </td>
        </tr>
         
	
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"     maxlength="20" />			</td>
    
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryCargo[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryCargo[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>

	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="SuppID" id="SuppID" value="<?=$_GET['edit']?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
