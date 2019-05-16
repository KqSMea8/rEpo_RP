<SCRIPT LANGUAGE=JAVASCRIPT>
function CheckMultipleZipCode(SendUrl,Params){
	var SendParam = Params+"&r="+Math.random(); 
	var IsExist = 0;

	$.ajax({
		type: "GET",
		async:false,
		url: SendUrl,
		data: Params,
		success: function (responseText) {
			 responseText = responseText.trim();
			if(responseText!='') {
				alert("Zip Code: ["+responseText+"] already exists in database.");
				
				IsExist = 1;
			}else if(responseText==0) {
				IsExist = 0;
			}else{
				alert("Error occur : " + responseText);
				IsExist = 1;
			}
			
		}
	});	
	return IsExist;
}




function ValidateForm(frm){
	var DataExist=0;
	 
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(ValidateForSimpleBlank(frm.zip_code, "Zip Code")	  
	){

		/**************/
		var stateDisplay = $("#state_td").css('display');
		if(stateDisplay!='none'){
			if(document.getElementById("state_id") != null){
				document.getElementById("main_state_id").value = document.getElementById("state_id").value;
			}
			if(!ValidateForSelect(document.getElementById("main_state_id"), "State")){
				return false;
			}
		}	 
		/**************/
		if(!ValidateForSelect(document.getElementById("main_city_id"), "City")){
			return false;
		}



		if(document.getElementById("zipcode_id").value>0){
					
			DataExist = CheckExistingData("isRecordExists.php","&ZipCode="+escape(document.getElementById("zip_code").value)+"&CityID="+document.getElementById("main_city_id").value+"&editID="+document.getElementById("zipcode_id").value, "zip_code","Zip Code");
			if(DataExist==1)return false;
			
		}else{
			DataExist = CheckMultipleZipCode("isRecordExists.php","&ZipCode="+escape(document.getElementById("zip_code").value)+"&CityID="+document.getElementById("main_city_id").value);
			if(DataExist==1)return false;

		}


	}else{
		return false;	
	}
	
}


</SCRIPT>

<a href="<?=$RedirectUrl?>"  class="back">Back</a>
<div class="had">
Manage Zip Code  <span>  &raquo;&nbsp;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
			  
		    <table width="100%"   border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
                <tr>
                  <td height="60" width="10">
				  </td>
				  </tr>
                <tr>
                  <td align="left" valign="bottom" >
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">                   
<tr>
	<td width="45%" align="right" valign="middle"   class="blackbold"> Zip Code : </td>
	<td align="left">	
	<? if(empty($zip_code)){ ?>
	<input value="<?=stripslashes($zip_code)?>" name="zip_code" id="zip_code" type="text" class="inputbox" style="width:500px;" id="zip_code" maxlength="300"/>
	<? }else{ ?>
	<input value="<?=stripslashes($zip_code)?>" name="zip_code" id="zip_code" type="text" class="inputbox" id="zip_code"  maxlength="20" />
	<?}?>
	<span class="red">*</span>
</td> 
</tr>
<? if(empty($zip_code)){ ?>
<tr align="right" valign="middle"   class="blackbold">
	<td>&nbsp;</td>
	<td align="left" class="red">
	Please enter the multiple Zip Codes separated by comma(')
	</td>
</tr>
<? } ?>
	
<? if(!empty($_SESSION['duplicate_zipcode'])){?>
<div id="txtHint"></div>
<? } ?>
                     <tr <?=$Config['CountryDisplay']?>>
                       <td align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Country : </td>
                       <td align="left">
                           <select name="country_id" class="inputbox" id="country_id" onchange="Javascript: StateListSend(1);">
                             <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                             <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
                             <?=$arryCountry[$i]['name']?>
                             </option>
                             <? } ?>
                           </select>
                       </td>
                     </tr>
					 
                     <tr>
                      <td align="right" valign="middle" class="blackbold"> State : </td>
                      <td  align="left" id="state_td" class="blacknormal">
					  </td>
                    </tr>  
					
					  <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	  
                  	
					
					
                  </table></td>
                </tr>
				
		 <tr>
                  <td align="center" colspan="2" height="50" ><input name="Submit" type="submit" id="SubmitButton" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
<input type="hidden" name="zipcode_id" id="zipcode_id"  value="<?=$_GET['edit']?>" />
<input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$state_id?>" />
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?=$city_id?>" />
						  
						  </td>
                    </tr>		
				
				
              </form>
          </table>
		    
		  
		  </td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
