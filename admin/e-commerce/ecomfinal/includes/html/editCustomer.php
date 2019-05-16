<div class="had"> <?= $ModuleTitle; ?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
              <form name="form1" action="" method="post"  enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td colspan="2" align="left" class="head">Contact Information </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    First Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="FirstName" id="FirstName" value="<?= stripslashes($arryCustomer[0]['FirstName']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Last Name :<span class="red">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="LastName" id="LastName" value="<?= stripslashes($arryCustomer[0]['LastName']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Company :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Company" id="Company" value="<?= stripslashes($arryCustomer[0]['Company']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Phone : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Phone" id="Phone" onkeyup="keyup(this);" value="<?= stripslashes($arryCustomer[0]['Phone']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" align="left" class="head">Account Information </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> Email : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <?= $arryCustomer[0]['Email']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> Last Action : </td>
                                                <td width="56%"  align="left" valign="top">
                                                     <?=date($Config['DateFormat'],strtotime($arryCustomer[0]['SessionDate']))?> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Current Account Status : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="Status" id="Status" class="inputbox">
                                                        <option value="Yes" <?php if($arryCustomer[0]['Status']=="Yes"){echo "selected";}?>>Active</option>
                                                        <option value="No" <?php if($arryCustomer[0]['Status']=="No"){echo "selected";}?>>Inactive</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                             <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Custome Group : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="GroupID" id="GroupID" class="inputbox">
                                                      <?php foreach($arryCustomerGroups as $group){?>
                                                        <option value="<?=$group['GroupID']?>" <?php if($arryCustomer[0]['GroupID']==$group['GroupID']){echo "selected";}?>><?=$group['GroupName']?></option>
                                                      <?php }?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Email Newsletters : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="Newsletters" id="Newsletters" class="inputbox">
                                                        <option value="Yes">Yes</option>
                                                        <option selected="selected" value="No">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" class="head">Billing Information </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Address Line 1 :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Address1" id="Address1" value="<?= stripslashes($arryCustomer[0]['Address1']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Address Line 2 : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Address2" id="Address2" value="<?= stripslashes($arryCustomer[0]['Address2']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td  align="right"   class="blackbold"> Country : <span class="red">*</span></td>
                                                <td   align="left" >
                                                    <?
                                                    if ($arryCustomer[0]['Country'] != '') {
                                                        $CountrySelected = $arryCustomer[0]['Country'];
                                                    } else {
                                                        $CountrySelected = 106;
                                                    }
                                                    ?>
                                                    <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <? if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <? } ?>
                                                    </select>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : <span class="red">*</span></td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State : <span class="red">*</span></div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCustomer[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : <span class="red">*</span></div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : <span class="red">*</span></div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCustomer[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">ZIP / Postal Code : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($arryCustomer[0]['ZipCode']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <?php
                            if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            }
                            ?>
                            <input type="hidden" name="CustId" id="CustId" value="<?= $CustId; ?>" />
                            <input type="hidden" value="<?php echo $arryCustomer[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustomer[0]['City']; ?>" />
                            <input name="Submit" type="submit" class="button" id="UpdateCustomer" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>    
                    </tr>

                </table>
               </form>
            </td>
        </tr>

</table>

<SCRIPT LANGUAGE=JAVASCRIPT> 
  <?php if ($_GET['edit'] > 0) { ?>
    StateListSend();
  <?php } ?>
   
</SCRIPT>