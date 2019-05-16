<?
function getExpiryYears($year_value,$year_field,$class_name){

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" >';
		$c_year = date('Y');
		$end_year = $c_year+20;
			$Year_String .= '<option value="">--- Year ---</option>';
		 for($y=$c_year;$y<$end_year;$y++){
				if($year_value == $y) $y_selected=' Selected'; else $y_selected='';
				$Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
			}
		$Year_String .= ' </select>';
		
		return $Year_String;
	}
?>

<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
 

<script language="JavaScript1.2" type="text/javascript">
function getSelectedCard(sel){    
    if(sel.value == 'Amex'){
          $("#CardNumber").mask("9999-999999-99999");  
          $("#securityCode").mask("9999");
    }
    else{
        $("#CardNumber").mask("9999-9999-9999-9999");
        $("#securityCode").mask("999");
        }
        
}

/*
jQuery(function($){
   $("#CardNumber").mask("9999-9999-9999-9999");
});*/

function CheckCardForm(){
	var frm = document.forms[0];
	
	var InValidCard = 0;

	if( ValidateForSelect(frm.CardType, "Card Type")
	&& ValidateForSimpleBlank(frm.CardNumber, "Card Number")
	&& ValidateForSelect(frm.ExpiryMonth, "Card Expiry Month")
	&& ValidateForSelect(frm.ExpiryYear, "Card Expiry Year")
	&& ValidateForSimpleBlank(frm.securityCode, "Security Code of 4 digit for Amex,3 for others")
	&& ValidateForSimpleBlank(frm.CardHolderName,"Card Holder Name")
	&& ValidateForSimpleBlank(frm.ZipCode,"Zip Code")
	){
		InValidCard = 0;
	}else{
		InValidCard = 1;
	}
	return InValidCard;
}
</script>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="borderall">
 <tr>
				<td class="head1" colspan="4">Credit Card Detail</td>
				</tr>

			<tr>
				<td align="right" class="blackbold" width="16%">Card Type :<span class="red">*</span>
				</td>
				<td align="left" width="34%">

 

<select id="CardType" class="inputbox" name="CardType" onchange="getSelectedCard(this)">
	<option value="">--- Select ---</option>
	<option value="Visa" <?  if($arryCard[0]['CardType']=="Visa"){echo "selected";}?>>Visa</option>
	<option value="MasterCard" <?  if($arryCard[0]['CardType']=="MasterCard"){echo "selected";}?>>MasterCard</option>
	<option value="Discover" <?  if($arryCard[0]['CardType']=="Discover"){echo "selected";}?>>Discover</option>
	<option value="Amex" <?  if($arryCard[0]['CardType']=="Amex"){echo "selected";}?>>American Express</option>
</select>
	 
			</td>
			 
				<td align="right" class="blackbold" width="20%">Card Number :<span
					class="red">*</span></td>
				<td align="left">
 
<input type="text" name="CardNumber" maxlength="30"
					class="inputbox" id="CardNumber"
					value="<?=stripslashes($arryCard[0]['CardNumber'])?>"
					onKeyPress="Javascript:return isNumberKey(event);">

 


</td>
			</tr>

	<tr>
				<td align="right" class="blackbold" >Card Expiry :<span
					class="red">*</span></td>
				<td align="left">
<?=getMonths($arryCard[0]['ExpiryMonth'],"ExpiryMonth","textbox")?>&nbsp;&nbsp;<?=getExpiryYears($arryCard[0]['ExpiryYear'],"ExpiryYear","textbox")?>
			 </td>
			 
				<td align="right" class="blackbold">Security Code : <span
					class="red">*</span></td>
                                        <td align="left"><input  type="text" name="securityCode"
					maxlength="4" size="5" class="textbox" id="securityCode"
					value="<?=stripslashes($arryCard[0]['SecurityCode'])?>" onKeyPress="Javascript:return isNumberKey(event);">
                                
                                </td>
			</tr>
			
			<tr>
				<td align="right" class="blackbold">Card Holder Name : <span
					class="red">*</span></td>
				<td align="left"><input type="text" name="CardHolderName"
					maxlength="30" class="inputbox" id="CardHolderName"
					value="<?=stripslashes($arryCard[0]['CardHolderName'])?>"></td>
			 
				<td align="right" class="blackbold">Address : </td>
				<td align="left"><input type="text" name="CreditAddress" maxlength="200"
					class="inputbox" id="CreditAddress"
					value="<?=stripslashes($arryCard[0]['Address'])?>"></td>
			</tr>
<tr>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td  align="left" >
		<?php
	if($arryCard[0]['country_id'] >0 ){
		$CountrySelected = $arryCard[0]['country_id']; 
	}else{
		$CountrySelected = $arryCurrentLocation[0]['country_id'];
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
			 <!--option value="">--- Select ---</option-->
              <?php for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
           
    <td align="right" valign="top" class="blackbold">Zip Code : <span class="red">*</span> </td>
    <td align="left" valign="top">
        <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($arryCard[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
    </td>
    </tr>  

            <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left"  id="state_td" class="blacknormal" >&nbsp;</td>
          
	 
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td  align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCard[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCard[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
      
<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryCard[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCard[0]['city_id']; ?>" />
                        
    
			 
 
        

</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
StateListSend();
</SCRIPT>
