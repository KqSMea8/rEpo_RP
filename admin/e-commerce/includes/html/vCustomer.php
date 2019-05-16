<div class="had"> <?= $ModuleTitle; ?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
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
                                                    First Name :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <?= stripslashes($arryCustomer[0]['FirstName']) ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Last Name : </td>
                                                <td  align="left"  class="blacknormal">
                                                   <?= stripslashes($arryCustomer[0]['LastName']) ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Company :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <?= stripslashes($arryCustomer[0]['Company']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Phone : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <?= stripslashes($arryCustomer[0]['Phone']) ?>
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
                                                <td width="30%" align="right" valign="top" class="blackbold"> Last Action :</td>
                                                <td width="56%"  align="left" valign="top">
                                                   <?=date($Config['DateFormat'],strtotime($arryCustomer[0]['SessionDate']))?> 
                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Customer Group : </td>
                                                <td width="56%"  align="left" valign="top">
                                                   <?=ucfirst($CustomerGroup)?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Current Account Status : </td>
                                                <td width="56%"  align="left" valign="top">
                                                   <?php
                                                   if(($arryCustomer[0]['Status'])=="Yes")
                                                       {echo "Active";}
                                                       else{echo "Inactive";}
                                                   ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Email Newsletters : </td>
                                                <td width="56%"  align="left" valign="top">
                                                  <?php
                                                   if(($arryCustomer[0]['Newsletters'])=="Yes")
                                                       {echo "Yes";}
                                                       else{echo "No";}
                                                   ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" class="head">Billing Information </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Address Line 1 : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <?= stripslashes($arryCustomer[0]['Address1']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Address Line 2 : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <?= stripslashes($arryCustomer[0]['Address2']) ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td  align="right"   class="blackbold"> Country :</td>
                                                <td   align="left" >
                                                    <?
                                                   
                                                    /********Connecting to main database*********/
                                                $Config['DbName'] = $Config['DbMain'];
                                                $objConfig->dbName = $Config['DbName'];
                                                $objConfig->connect();
                                            /*******************************************/
                                            if($arryCustomer[0]['Country']>0){
                                                    $arryCountryName = $objRegion->GetCountryName($arryCustomer[0]['Country']);
                                                    $CountryName = stripslashes($arryCountryName[0]["name"]);
                                            }

                                            if(!empty($arryCustomer[0]['State'])) {
                                                    $arryState = $objRegion->getStateName($arryCustomer[0]['State']);
                                                    $StateName = stripslashes($arryState[0]["name"]);
                                            }else if(!empty($arryCustomer[0]['OtherState'])){
                                                     $StateName = stripslashes($arryCustomer[0]['OtherState']);
                                            }

                                            if(!empty($arryCustomer[0]['City'])) {
                                                    $arryCity = $objRegion->getCityName($arryCustomer[0]['City']);
					if(!empty($arryCity[0]["name"])) {

                                                    $CityName = stripslashes($arryCity[0]["name"]);
						}
                                            }else if(!empty($arryCustomer[0]['OtherCity'])){
                                                     $CityName = stripslashes($arryCustomer[0]['OtherCity']);
                                            }

                                            /*******************************************/	



                                    ?>

                                                    <?php echo $CountryName;?>
                                                </td>
                                            </tr>

					 <?  if(!empty($StateName)) { ?>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State :</td>
                                             <td  align="left"  class="blacknormal"><?=$StateName;?></td>
                                            </tr>
					<? } ?>
                                            <tr>
                                                <td  align="right" class="blackbold"> City :</td>
                                                <td  align="left"><?=$CityName;?></td>
                                            </tr> 
                                           
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">ZIP / Postal Code : </td>
                                                <td width="56%"  align="left" valign="top">
                                                   <?= stripslashes($arryCustomer[0]['ZipCode']) ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           
                            <input type="hidden" name="CustId" id="CustId" value="<?= $CustId; ?>" />
                            <input type="hidden" value="<?php echo $arryCustomer[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustomer[0]['City']; ?>" />
                            
                        </td>

                    </tr>

                </table>
            </td>
        </tr>
</table>

