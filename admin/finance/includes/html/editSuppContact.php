<script language="JavaScript1.2" type="text/javascript">
function validateSuppContact(frm){

	
	if( ValidateForSimpleBlank(frm.Name, "Contact Name")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
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
<div id="preview_div" >

<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">
<? echo $PageAction." Contact"; ?>   </div>


<form name="formContact" action=""  method="post" onSubmit="return validateSuppContact(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" class="borderall">

 	  
<tr>
                                                <td width="20%" align="right" valign="top"  class="blackbold"> 
                                                    Contact Name : <span class="red">*</span> </td>
                                                <td width="25%" align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?= stripslashes($arrySuppAddress[0]['Name']) ?>" type="text" class="inputbox"  maxlength="60" />
                                                </td>
                                           
                                                <td width="25%" align="right" valign="top" class="blackbold"> 
                                                    Email : <span class="red">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input name="Email" id="Email"  value="<?= stripslashes($arrySuppAddress[0]['Email']) ?>" type="text" class="inputbox"  maxlength="80" />
                                                     <span id="MsgSpan_Email"></span>
                                                </td>
                                            </tr>

<tr>
                                               
                                           
                                                <td align="right" valign="top" class="blackbold"> 
                                                    Mobile :   </td>
                                                <td  align="left" valign="top">
 <input  name="Mobile" id="Mobile" value="<?= stripslashes($arrySuppAddress[0]['Mobile']) ?>" type="text" class="inputbox"  maxlength="20" onkeypress="return isNumberKey(event);"/>
                                                </td>
                                           
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Landline  : </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Landline" id="Landline" value="<?= stripslashes($arrySuppAddress[0]['Landline']) ?>" type="text"  class="inputbox"  maxlength="20" onkeypress="return isNumberKey(event);"/>
                                                    
                                                </td>
                                           
                                             
                                            </tr>

                                             <tr>
                                                
<td  align="right" valign="top"   class="blackbold"> 
                                                    Fax :</td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Fax" id="Fax" value="<?= stripslashes($arrySuppAddress[0]['Fax']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
 <td align="right" valign="top" class="blackbold">Zip Code : <span class="red">*</span> </td>
                                                <td align="left" valign="top">
                                                    <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($arrySuppAddress[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>

                                             </tr>




                                              <tr>

<td valign="top" align="right" class="blackbold">Address  : </td>
                                                <td align="left">
                                                  <textarea id="Address" class="textarea" type="text" name="Address" maxlength="250"><?=stripslashes($arrySuppAddress[0]['Address']) ?></textarea></td>
   
                                                <td  align="right" valign="top"  class="blackbold"> Country : <span class="red">*</span></td>
                                                <td   align="left"  valign="top">
                                                    <?php
                                                    if ($arrySuppAddress[0]['country_id'] >0) {
                                                        $CountrySelected = $arrySuppAddress[0]['country_id'];
                                                    } else {
                                                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
                                                    }
                                                    ?>
                                                    <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
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
                                           
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State : </div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arrySuppAddress[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : </div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                           
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : </div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arrySuppAddress[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
                                            </tr>
                                            
                                         
<tr>
	<td colspan="4" align="left" class="head">Assign Role</td>
</tr>

    <tr>                                                
	<td  align="right" valign="top"   class="blackbold"> 
            Payment Info :</td>
        <td  align="left"  class="blacknormal">
            <input type="checkbox" name="PaymentInfo" value="1" <?  if($arrySuppAddress[0]['PaymentInfo']=="1"){echo "checked";}?>>
        </td>
<td align="right" valign="top" class="blackbold">Purchase Order Delivery :   </td>
        <td align="left" valign="top">
          <input type="checkbox" name="PoDelivery" value="1" <?  if($arrySuppAddress[0]['PoDelivery']=="1"){echo "checked";}?>>
        </td>

     </tr>   
 <tr>                                                
	<td  align="right" valign="top"   class="blackbold"> 
            Invoice Delivery :</td>
        <td  align="left"  class="blacknormal">
            <input type="checkbox" name="InvoiceDelivery" value="1" <?  if($arrySuppAddress[0]['InvoiceDelivery']=="1"){echo "checked";}?>>
        </td>
 	<td  align="right" valign="top"   class="blackbold"> 
            Credit Memo Delivery :</td>
        <td  align="left"  class="blacknormal">
            <input type="checkbox" name="CreditDelivery" value="1" <?  if($arrySuppAddress[0]['CreditDelivery']=="1"){echo "checked";}?>>
        </td>

     </tr>                                 
   <tr>                                                
	
<td align="right" valign="top" class="blackbold">Vendor Return Delivery :   </td>
        <td align="left" valign="top">
          <input type="checkbox" name="ReturnDelivery" value="1" <?  if($arrySuppAddress[0]['ReturnDelivery']=="1"){echo "checked";}?>>
        </td>

     </tr> 


</table>		
	
	</td>
	
  </tr>

	<tr>
    <td align="center">
<input type="Submit" class="button" name="SubmitContact" id="SubmitContact" value="<?=$ButtonAction?>">
<input type="hidden" name="SupplierID" id="SupplierID" value="<?=$_GET['SuppID']?>" />
<input type="hidden" name="AddressID" id="AddressID" value="<?=$_GET['AddID']?>" />

<input type="hidden" value="<?php echo $arrySuppAddress[0]['state_id']; ?>" id="main_state_id" name="main_state_id">		
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arrySuppAddress[0]['city_id']; ?>" />


</td>	
  </tr>


</table>
</form>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>




<? } ?>
