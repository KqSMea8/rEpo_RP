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
          $("#SecurityCode").mask("9999");
    }
    else{
        $("#CardNumber").mask("9999-9999-9999-9999");
        $("#SecurityCode").mask("999");
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
	&& ValidateForSimpleBlank(frm.SecurityCode, "Security Code of 4 digit for Amex,3 for others")
	&& ValidateForSimpleBlank(frm.CardHolderName,"Card Holder Name")
	&& ValidateForSimpleBlank(frm.CreditState,"State")
	&& ValidateForSimpleBlank(frm.CreditCity,"City")
	&& ValidateForSimpleBlank(frm.CreditZipCode,"Zip Code")
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
                                        <td align="left"><input  type="text" name="SecurityCode"
					maxlength="4" size="5" class="textbox" id="SecurityCode"
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
 
	if(!empty($arryCard[0]['Country'])){
		$CountrySelected = $arryCard[0]['Country']; 
	}else if(!empty($arryCurrentLocation[0]['CountryCode'])){
		$CountrySelected = $arryCurrentLocation[0]['CountryCode'];
	}
 
	?>
            <select name="CreditCountry" class="inputbox" id="CreditCountry"   >
			 <!--option value="">--- Select ---</option-->
              <?php for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['code']?>" <?  if(!empty($arryCountry[$i]['code']) && $arryCountry[$i]['code']==$CountrySelected){echo "selected";}?>>
              <?=stripslashes($arryCountry[$i]['name'])?>
              </option>
              <? } ?>
            </select>        </td>
           
   
	 <td  align="right"   class="blackbold">  State  :<span class="red">*</span> </td>
        <td  align="left" > <input name="CreditState" type="text" class="inputbox" id="CreditState" value="<?php echo stripslashes($arryCard[0]['State']); ?>"  maxlength="30" />       </td>

    </tr>  

            <tr>
	 
	 <td  align="right"   class="blackbold">  City :<span class="red">*</span>  </td>
        <td align="left" > <input name="CreditCity" type="text" class="inputbox" id="CreditCity" value="<?php echo stripslashes($arryCard[0]['City']); ?>"  maxlength="30" />         </td>


           <td align="right" valign="top" class="blackbold">Zip Code : <span class="red">*</span> </td>
    <td align="left" valign="top">
        <input  name="CreditZipCode" id="CreditZipCode" value="<?= stripslashes($arryCard[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
    </td>
	 
      
        
       
      </tr>
                  
    
			 
 
        

</table>


