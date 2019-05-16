<div class="had"> <?= $ModuleTitle; ?></div>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action="" method="post"  enctype="multipart/form-data">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Tax Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="RateDescription" id="RateDescription" value="<?= stripslashes($arryTax[0]['RateDescription']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <?php
                                            /*                                             * ******Connecting to main database******** */
                                            $Config['DbName'] = $Config['DbMain'];
                                            $objConfig->dbName = $Config['DbName'];
                                            $objConfig->connect();
                                            /*                                             * **************************************** */
                                            if ($arryTax[0]['Coid'] > 0) {
                                                $arryCountryName = $objRegion->GetCountryName($arryTax[0]['Coid']);
                                                $CountryName = stripslashes($arryCountryName[0]["name"]);
                                            } else {
                                                $CountryName = "ALL";
                                            }
                                            if ($arryTax[0]['Stid'] > 0) {
                                                $StateName = $objRegion->getAllStateName($arryTax[0]['Stid']);
                                            } else {
                                                $StateName = "ALL";
                                            }
                                            //if ($TaxId && !empty($TaxId)) {
                                            ?>
                                           <!-- <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    
                                               Tax Country  </td>
                                                <td width="56%"  align="left" valign="top">
<?= $CountryName; ?>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                               Tax State  </td>
                                                  <td  align="left"   class="blacknormal">    <?= $StateName; ?></td>
                                             </tr>-->
<? //php } else { ?>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 

                                                    Tax Country :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="Coid" class="inputbox" id="country_id"  onChange="Javascript: GetStateListForTax();">
                                                        <option value="0">All Country</option>
                                                        <? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <?php if ($arryCountry[$i]['country_id'] == $arryTax[0]['Coid']) {
                                                            echo "selected";
                                                        } ?>>
    <?= $arryCountry[$i]['name'] ?>
                                                            </option>
<? } ?>
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Tax State :  </td>
                                                <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                                        <? //php } ?>
                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Tax Class :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="ClassId" id="ClassId" class="inputbox" >
                                                        <option>---Select---</option>
<?php foreach ($arryTaxClasses as $key => $value) { ?>
                                                            <option value="<?= $value['ClassId'] ?>" <?php if ($value['ClassId'] == $arryTax[0]['ClassId']) {
        echo "selected";
    } ?>><?= $value['ClassName'] ?></option>
<?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Tax Rate(%) :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="TaxRate" id="TaxRate" value="<?=$arryTax[0]['TaxRate']; ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Apply To :</td>
                                                <td width="56%"  align="left" valign="top">    
                                             <select multiple="multiple" class="select multiselect" size="10"  name="user_level[]" id="user_level">
                                              
                                             <?php
if(isset($arryCustomerGroups)) {	
 foreach($arryCustomerGroups as $group){?>
                                              <option value="<?=$group['GroupID']?>" <?php if(in_array($group['GroupID'],$arrayUserLevelID)){echo "selected";}?>><?=$group['GroupName']?></option>
                                             <?php }}?>
                                            </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status :  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($TaxStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($TaxStatus == "No") ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>           
                                        </table>  
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                            <input type="hidden" name="taxId" id="taxId" value="<?= $TaxId; ?>" />
                            <input type="hidden" value="<?= $arryTax[0]['Stid']; ?>" id="main_state_id" name="main_state_id">	
                            <input name="Submit" type="submit" class="button" id="SubmitTax" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
    GetStateListForTax();
</SCRIPT>
