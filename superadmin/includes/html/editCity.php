
<SCRIPT LANGUAGE=JAVASCRIPT>
function CheckMultipleCityName(SendUrl,Params){
	 
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
				alert("City : ["+responseText+"] already exists in database.");
				
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



function ValidateForm(frm)
{
	

	if(  ValidateForBlank(frm.name, "City Name") 
	      
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


		/*var Url = "isRecordExists.php?City="+escape(document.getElementById("name").value)+"&StateID="+escape(document.getElementById("main_state_id").value)+"&CountryID="+escape(document.getElementById("country_id").value)+"&editID="+escape(document.getElementById("city_id").value);		
		SendExistRequest(Url,"name","City Name");*/


		if(document.getElementById("city_id").value>0){
				
			DataExist = CheckExistingData("isRecordExists.php","&City="+escape(document.getElementById("name").value)+"&StateID="+escape(document.getElementById("main_state_id").value)+"&CountryID="+escape(document.getElementById("country_id").value)+"&editID="+escape(document.getElementById("city_id").value), "name","City Name");

			if(DataExist==1)return false;
			
		}else{
			DataExist = CheckMultipleCityName("isRecordExists.php", "&City="+escape(document.getElementById("name").value)+"&StateID="+escape(document.getElementById("main_state_id").value)+"&CountryID="+escape(document.getElementById("country_id").value));
		
			if(DataExist==1)return false;

		}



		return true;
	}else{
		return false;	
	}
	
}


</SCRIPT>

<a href="<?=$RedirectUrl?>"  class="back">Back</a>
<div class="had">
Manage Cities   <span>  &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>

<TABLE WIDTH="90%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		
		    <table width="100%"   border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
                <tr>
                  <td height="60">
				  </td>
				  </tr>
                <tr>
                  <td align="center" valign="bottom" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td  align="right" valign="middle"   class="blackbold"> City Name : </td>
                    


<? if(empty($name)){ ?>
	  <td width="80%">
	<input value="" name="name" id="name" type="text" class="inputbox" style="width:800px;"  maxlength="1000"/> <span class="red">*</span></td>
	<? }else{ ?>
	 <td width="55%">
	<input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name"  maxlength="30" /> <span class="red">*</span>
	</td>
	<?}?>

                    </tr>


<? if(empty($name)){ ?>
<tr align="right" valign="middle"   class="blackbold">
	<td>&nbsp;</td>
	<td align="left" class="red">
	Please enter the multiple city names separated by comma(')
	</td>
</tr>
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
                     <tr style="display:none">
                      <td align="right" valign="middle" class="blackbold"> Major City : </td>
                      <td  align="left" class="blacknormal">
					  	<input type="checkbox" name="major_city" value="1" <?=($major_city==1)?("checked"):("")?>/>
					  </td>
                    </tr>  
					
					
					
                  </table></td>
                </tr>
				
		 <tr>
                  <td align="center" colspan="2" height="50" ><input name="Submit" type="submit" id="SubmitButton" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>"  />
                          <input type="hidden" name="city_id" id="city_id"  value="<?=$_GET['edit']?>" />                      <input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$state_id?>" />
                        
						  
						  </td>
                    </tr>		
				
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
