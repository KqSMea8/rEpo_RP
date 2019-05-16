
<SCRIPT LANGUAGE=JAVASCRIPT>



function ValidateForm(frm)
{

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForTextareaMand(frm.Address,"Address",10,200)
	){
		if(document.getElementById("main_state_id").value<=0 && Trim(document.getElementById("OtherState")).value==''){
			alert("State is empty.");
			return false;
		}
		if(document.getElementById("main_city_id").value<=0 && Trim(document.getElementById("OtherCity")).value==''){
			alert("City is empty.");
			return false;
		}
		
		if(!isZipCode(frm.ZipCode)){
			return false;
		}
		
		if(!ValidateForSelect(frm.Timezone, "Timezone")){
			return false;
		}
		
		

		var Url = "isRecordExists.php?LocationCountry=1&country_id="+document.getElementById("country_id").value+"&state_id="+document.getElementById("main_state_id").value+"&city_id="+document.getElementById("main_city_id").value+"&State="+escape(document.getElementById("OtherState").value)+"&City="+escape(document.getElementById("OtherCity").value)+"&locationID="+document.getElementById("locationID").value;
		
		SendExistRequest(Url,"country_id","Location");
		return false;
	}else{
		return false;	
	}
	
}


</SCRIPT>
 <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had">Company Location  <span> &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
			echo $MemberTitle.$ModuleName;
			 ?></span>
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" >
	  <? if(!empty($ErrorMsg)){?>
	  	<div class="redmsg"><?=$ErrorMsg?></div>
	  <? }else{ ?>

	  <table width="100%"   border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
                     <tr>
          <td align="right"   class="blackbold" valign="top" width="45%"> Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address" maxlength="200"><?=stripslashes($arryLocation[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryLocation[0]['country_id'] != ''){
		$CountrySelected = $arryLocation[0]['country_id']; 
	}else{
		$CountrySelected = 106;
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
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :<span class="red">*</span></td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryLocation[0]['State']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :<span class="red">*</span></div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryLocation[0]['City']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryLocation[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
       
	  <tr>
        <td align="right"   class="blackbold" valign="top" >Timezone  :<span class="red">*</span></td>
        <td  align="left"  valign="top" >

<div style="position:relative;"><? 
if(!empty($arryLocation[0]['Timezone'])){ 
$arryCurrentLocation[0]['Timezone'] = $arryLocation[0]['Timezone'];
include("includes/html/box/clock.php"); 
}?></div>



<script>
  $(function() {
	$('#Timezone').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<?=getTimeZone($arryLocation[0]['Timezone'])?>

<script>
GetLocalTime();
</script>
		</td>
      </tr>  
	   
	       
	<tr>
        <td  align="right"   class="blackbold" > Currency  :</td>
        <td   align="left" >
		<?
		if($arryLocation[0]['currency_id'] >0 ){
			$CurrencySelected = $arryLocation[0]['currency_id']; 
		}else{
			$CurrencySelected = $arryCompany[0]['currency_id'];
		}
	
		?>
            <select name="currency_id" class="inputbox" id="currency_id">
              <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
              <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>>
              <?=$arryCurrency[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>			



	<tr>
        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryLocation[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryLocation[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status1" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status2" value="0" <?=$InActiveChecked?> />
          InActive
		  
		
		  
		   </td>
      </tr>			
				
				
				                 
                   
                  </table></td>
                </tr>
				
		 <tr>
                  <td align="center"  height="50"><input name="Submit" type="submit" id="SubmitButton" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit';?>" />
                          <input type="hidden" name="locationID" id="locationID"  value="<?=$_GET['edit']?>" />  
						               
<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLocation[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLocation[0]['city_id']; ?>" />								   
									   
									   
                          </td>
                    </tr>		
				
				
              </form>
          </table>
	  <? } ?>
	  
	  </TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
