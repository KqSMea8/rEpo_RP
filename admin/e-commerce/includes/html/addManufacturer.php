<div class="had"><span><?php   echo $ModuleName;?></span></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="top">
            <form name="form1" action="" id="ManufacturerForm" method="post"  enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    <?= $ModuleName ?> Name :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Mname" id="Mname" value="<?= stripslashes($arryManufacturer[0]['Mname']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    <?= $ModuleName ?> Code :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Mcode" id="Mcode" value="<?= stripslashes($arryManufacturer[0]['Mcode']) ?>" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','Mcode','');" type="text" class="inputbox <?php if (!empty($_GET['edit'])) { ?>disabled<?php } ?>" <?php if (!empty($_GET['edit'])) { ?>disabled<?php } ?>  size="50" />
													 
	                                             <span id="MsgSpan_ModuleID"></span>
                                                </td>
                                            </tr>
                                         
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold">Status :</td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($ManufacturerStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($ManufacturerStatus == 0) ? "checked" : "" ?> value="0" /></td>
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
                          <input type="hidden" name="Mid" id="Mid" value="<?php echo $Mid; ?>">
                          <input name="Submit" type="button" class="button" id="AddQuickManufacturer" value="Submit" />&nbsp;
                        </td>   
                    </tr>
                </table>
            </form>      
        </td>
    </tr>
</table>
