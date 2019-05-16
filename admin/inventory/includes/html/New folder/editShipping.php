<div class="had"> <?=$ModuleTitle;?></div>
<TABLE WIDTH=768   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <form name="form1" action="" method="post"  enctype="multipart/form-data"><TR>
            <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top" =""  class="blackbold"> 
                                                Carrier Name <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="CarrierName" id="CarrierName" value="<?= stripslashes($arryShipping[0]['CarrierName']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <?php if ($Ssid && !empty($Ssid)) {?>
                                             <tr>
                                                <td width="30%" align="right" valign="top" =""  class="blackbold"> 
                                               Calculation Method <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top"><?=$MethodId;?></td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Countries </td>
                                                <td align="left" valign="top">
                                                    <?php 
                                                      /********Connecting to main database*********/
                                                        $Config['DbName'] = $Config['DbMain'];
                                                        $objConfig->dbName = $Config['DbName'];
                                                        $objConfig->connect();
                                                        /*******************************************/
                                                    if($arryShipping[0]['Country']>0){
                                                                $arryCountryName = $objRegion->GetCountryName($arryShipping[0]['Country']);
                                                                $CountryName = stripslashes($arryCountryName[0]["name"]);
                                                                        }
                                                            echo $CountryName;
                                                    ?>
                                                </td>
                                            </tr>
                                              <tr>
                                                <td  align="right" valign="top"   class="blackbold"> States </td>
                                               <td  align="left"  class="blacknormal"><?php
                                               if(!empty($arryShipping[0]['State'])) {
			$StateName = $objRegion->getAllStateName($arryShipping[0]['State']);
                                           
		                } 
                                               echo $StateName;
                                               ?></td>
                                            </tr>
                                            <?php }else{?>
                                            <tr>
                                                <td width="30%" align="right" valign="top" =""  class="blackbold"> 
                                               Calculation Method <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                <select name="MethodId" id="MethodId" class="inputbox">
                                                    <option value="">---Select---</option>
                                                    <option value="flat">Flat (per item)</option>
                                                        <option value="price">Price-based</option>
                                                        <option value="weight">Weight</option>      
                                                     </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Countries </td>
                                                <td align="left" valign="top">
                                                      <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSendShipping(this.value);">
                                                          <option value="0">All Country</option>
                                                                <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                                                                <option value="<?=$arryCountry[$i]['country_id']?>">
                                                                <?=$arryCountry[$i]['name']?>
                                                                </option>
                                                                <? } ?>
                                                              </select> 
                                                </td>
                                            </tr>
                                              <tr>
                                                <td  align="right" valign="top"   class="blackbold"> States </td>
                                               <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <?php }?>
                                            
                                            <tr> 
                                                <td   align="right" valign="top"    class="blackbold"> 
                                                  Priority  </td>
                                                <td  height="50" align="left" valign="top" class="blacknormal"> 
                                                   <select class="inputbox"  name="Priority" id="Priority">
                                                            <option value="1" <?php if($arryShipping[0]['Priority'] == "1"){echo "selected";}?>>1</option>
                                                            <option value="2" <?php if($arryShipping[0]['Priority'] == "2"){echo "selected";}?>>2</option>
                                                            <option value="3" <?php if($arryShipping[0]['Priority'] == "3"){echo "selected";}?>>3</option>
                                                            <option value="4" <?php if($arryShipping[0]['Priority'] == "4"){echo "selected";}?>>4</option>
                                                            <option  value="5" <?php if($arryShipping[0]['Priority'] == "5"){echo "selected";}?>>5</option>
                                                            <option value="6" <?php if($arryShipping[0]['Priority'] == "6"){echo "selected";}?>>6</option>
                                                            <option value="7" <?php if($arryShipping[0]['Priority'] == "7"){echo "selected";}?>>7</option>
                                                            <option value="8" <?php if($arryShipping[0]['Priority'] == "8"){echo "selected";}?>>8</option>
                                                            <option value="9" <?php if($arryShipping[0]['Priority'] == "9"){echo "selected";}?>>9</option>
                                                            <option value="10" <?php if($arryShipping[0]['Priority'] == "10"){echo "selected";}?>>10</option>
                                                     </select>
                                            </tr>
                                            
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($ShippingStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($ShippingStatus == "No") ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                           
                                           

                                        </table>
                                        
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <? if ($_GET['edit'] > 0) {$ButtonTitle = 'Update'; $buttonId = "UpdateShipping";} else{ $ButtonTitle = 'Submit'; $buttonId = "SubmitShipping";}?>
                            <input type="hidden" name="CarrierId" id="CarrierId" value="custom">
                             <?php if ($Ssid && !empty($Ssid)) {?>
                              <input type="hidden" value="<?=$Ssid;?>" id="Ssid" name="Ssid">	
                            <?php } else{?>
                             <input type="hidden" value="" id="main_state_id" name="main_state_id">	
                              <input type="hidden" value="" id="all_state_id" name="all_state_id">	
                              <?php }?>
                            <input name="Submit" type="submit" class="button" id="<?=$buttonId;?>" value=" <?= $ButtonTitle ?> " />&nbsp;
                           
                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>
    $(document).ready(function() {
   $("#SubmitShipping").click(function(){
       
            var CarrierName = $.trim($("#CarrierName").val());
            var MethodId = $.trim($("#MethodId").val());
           
           
 if(CarrierName == "")
       {
           alert("Please enter carrier name");
           $("#CarrierName").focus();
           return false;
       }
       
     if(MethodId == "")
       {
           alert("Please select calculation method");
           $("#MethodId").focus();
           return false;
       }
     
   
     });
     
      $("#UpdateShipping").click(function(){
       
       var CarrierName = $.trim($("#CarrierName").val());

        if(CarrierName == "")
              {
                  alert("Please enter carrier name");
                  $("#CarrierName").focus();
                  return false;
              }
          });
     
 
  }); 
    
    
	StateListSendShipping();
</SCRIPT>