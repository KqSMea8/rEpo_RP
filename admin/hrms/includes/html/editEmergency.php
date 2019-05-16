<script language="JavaScript1.2" type="text/javascript">
function validateEmergency(frm){
	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.Name, "Relative Name")
		&& ValidateForSimpleBlank(frm.Relation, "Relation")
		&& ValidateForSimpleBlank(frm.Address,"Address")
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number",10,20)	
		&& isZipCode(frm.ZipCode)
	){				

			document.getElementById("prv_msg_div").style.display = 'block';
			document.getElementById("preview_div").style.display = 'none';

			return true;	
				
	}else{
		return false;	
	}	

		
}
</script>

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:550px;" >

<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">
<? echo $PageAction." Emergency Contact"; ?>   </div>


<form name="formContact" action=""  method="post" onSubmit="return validateEmergency(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" class="borderall">
<tr>
                      <td width="45%" align="right"  class="blackbold">
					Relative Name :<span class="red">*</span>
					  </td>
                      <td align="left">
						<input name="Name" type="text" class="inputbox" id="Name" maxlength="30" onkeypress="return isCharKey(event);" value="<?php echo stripslashes($ArryEmergency[0]['Name']); ?>"/>
					  </td>
                    </tr>
					
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Relation  :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						<input name="Relation" type="text" class="inputbox" id="Relation" maxlength="30" onkeypress="return isCharKey(event);" value="<?php echo stripslashes($ArryEmergency[0]['Relation']); ?>"/>  
					  </td>
                    </tr>	
					
					
				
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Address :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">

					<textarea name="Address" class="textarea" id="Address"  maxlength="200" onkeypress="return isAlphaKey(event);"><?php echo stripslashes($ArryEmergency[0]['Address']); ?></textarea>  


					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Mobile  :
					  </td>
                      <td  align="left" valign="top">
					<input name="Mobile" type="text" class="inputbox" id="Mobile" maxlength="20" onkeypress="return isNumberKey(event);" value="<?php echo stripslashes($ArryEmergency[0]['Mobile']); ?>" />  
	
					  </td>
                    </tr>	
							  	
                 <tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Home Phone  :
					  </td>
                      <td  align="left" valign="top">
					<input name="HomePhone" type="text" class="inputbox" id="HomePhone" maxlength="20" onkeypress="return isNumberKey(event);" value="<?php echo stripslashes($ArryEmergency[0]['HomePhone']); ?>" />  
	
					  </td>
                    </tr>	
					

					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Work Phone  :
					  </td>
                      <td  align="left" valign="top">
					<input name="WorkPhone" type="text" class="inputbox" id="WorkPhone" maxlength="20" onkeypress="return isNumberKey(event);" value="<?php echo stripslashes($ArryEmergency[0]['WorkPhone']); ?>"/>  
	
					  </td>
                    </tr>
                                              <tr>
                                                <td  align="right"   class="blackbold"> Country : <span class="red">*</span></td>
                                                <td   align="left" >
                                                    <?php
                                                    if ($ArryEmergency[0]['country_id'] >0) {
                                                        $CountrySelected = $ArryEmergency[0]['country_id'];
                                                    } else {
                                                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
                                                    }
                                                    ?>
                                                    <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <?php for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <?php if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : </td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State : </div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo stripslashes($ArryEmergency[0]['OtherState']); ?>"  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : </div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : </div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo stripslashes($ArryEmergency[0]['OtherCity']); ?>"  maxlength="30" />  </div>          </td>
                                            </tr>
                                            <tr>
                                                <td align="right" valign="top" class="blackbold">Zip Code : <span class="red">*</span> </td>
                                                <td align="left" valign="top">
                                                    <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($ArryEmergency[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
                                            </tr>
                                             
                                         

</table>		
	
	</td>
	
  </tr>

	<tr>
    <td align="center">
<input type="Submit" class="button" name="SubmitContact" id="SubmitContact" value="<?=$ButtonAction?>">
<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['EmpID']?>" />
<input type="hidden" name="contactID" id="contactID" value="<?=$_GET['contactID']?>" />
 <input type="hidden" name="RedirectURL" id="RedirectURL" value="<?=$_SERVER['HTTP_REFERER']?>" /> 

<input type="hidden" value="<?php echo $ArryEmergency[0]['state_id']; ?>" id="main_state_id" name="main_state_id">		
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $ArryEmergency[0]['city_id']; ?>" />


</td>	
  </tr>


</table>
</form>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>




<? } ?>
