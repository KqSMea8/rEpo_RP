<script language="JavaScript1.2" type="text/javascript">
function validateSupplier(frm){

	var DataExist=0;
	/**********************/
	var SuppCode = Trim(document.getElementById("SuppCode")).value;
	if(SuppCode!=''){
		if(!ValidateMandRange(document.getElementById("SuppCode"), "Vendor Code",3,20)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php","&SuppCode="+escape(SuppCode), "SuppCode","Vendor Code");
		if(DataExist==1)return false;

	}
	/**********************/
	if(!ValidateMandRange(frm.CompanyName, "Company Name",3,30)){
		return false;
	}
	
	DataExist = CheckExistingData("isRecordExists.php","&CompanyName="+escape(document.getElementById("CompanyName").value), "CompanyName","Company Name");
	if(DataExist==1)return false;
	/**********************/

	if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
		return false;
	}
	if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
		return false;
	}
	/**********************/
	if(!ValidateForSimpleBlank(frm.Email, "Email Address")){
		return false;
	}
	if(!isEmail(frm.Email)){
		return false;
	}
	DataExist = CheckExistingData("isRecordExists.php", "&Type=Supplier&Email="+escape(document.getElementById("Email").value), "Email","Email Address");
	if(DataExist==1)return false;
	/**********************/

	if( ValidateForSimpleBlank(frm.Address,"Address")
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		){

				ShowHideLoader('1','S');
				
				/*	var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("SuppID").value+"&CompanyName="+escape(document.getElementById("CompanyName").value)+"&Type=Supplier";
				SendMultipleExistRequest(Url,"Email", "Email Address","CompanyName", "Company Name")
				return false;	
				*/
				document.getElementById("prv_msg_div").style.display = 'block';
				document.getElementById("preview_div").style.display = 'none';

				return true;
					
		}else{
				return false;	
		}	

		
}
</script>


<div id="prv_msg_div" style="display:none;margin-top:100px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateSupplier(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
        <td  align="right"   class="blackbold"> Vendor Code : </td>
        <td   align="left" >

	<input name="SuppCode" type="text" class="datebox" id="SuppCode" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SuppCode');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_SuppCode','SuppCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_SuppCode"></span>

</td>
      </tr>

   <tr>
        <td  align="right"   class="blackbold" width="45%"> Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arrySupplier[0]['CompanyName']); ?>"  maxlength="40" onKeyPress="Javascript:ClearAvail('MsgSpan_Company');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_Company','CompanyName','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Company"></span>
</td>
      </tr>


 


 <tr>
        <td  align="right"   class="blackbold"> Currency  :</td>
        <td   align="left" >
		<?
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		$arryCurrency = $objRegion->getCurrency('',1);

		if(!empty($arrySupplier[0]['Currency'])){
			$CurrencySelected = $arrySupplier[0]['Currency']; 
		}else{
			$CurrencySelected = 'USD';
		}
		?>
            <select name="Currency" class="inputbox" id="Currency">
              <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
              <option value="<?=$arryCurrency[$i]['code']?>" <?  if($arryCurrency[$i]['code']==$CurrencySelected){echo "selected";}?>>
              <?=$arryCurrency[$i]['name']?>
              </option>
              <? } ?>
            </select>       
		</td>
</tr>



<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arrySupplier[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arrySupplier[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>


	<tr>
       		 <td colspan="2" align="left"   class="head">Contact Information</td>
        </tr>
   
	  
<tr>
        <td  align="right"   class="blackbold"  > First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arrySupplier[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arrySupplier[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   
 <tr>
        <td  align="right"   class="blackbold"> Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arrySupplier[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Supplier','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>	 	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arrySupplier[0]['Address'])?></textarea>			          </td>
        </tr>
         
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arrySupplier[0]['Mobile'])?>"     maxlength="20" />			</td>
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

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arrySupplier[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arrySupplier[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

</div>