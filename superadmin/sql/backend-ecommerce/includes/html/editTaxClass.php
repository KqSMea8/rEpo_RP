<div class="had"> <?=$ModuleTitle;?></div>
  <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
               <form name="form1" action="" method="post" id="taxClassForm"  enctype="multipart/form-data">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                               Class Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="ClassName" id="ClassName" value="<?= stripslashes($arryTaxClass[0]['ClassName']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                           <!-- <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Class Description <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="ClassDescription" id="ClassDescription" value="<?= stripslashes($arryTaxClass[0]['ClassDescription']) ?>" type="text" class="inputbox" />
                                                </td>
                                             </tr>-->
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status :  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($TaxClassStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($TaxClassStatus == "No") ? "checked" : "" ?> value="0" /></td>
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
                           <? if ($_GET['edit'] > 0) {$ButtonTitle = 'Update';} else{ $ButtonTitle = 'Submit';}?>
                            <input type="hidden" name="taxclassId" id="taxclassId" value="<?=$TaxClassId;?>" />
                            <input name="Submit" type="button" class="button" id="SubmitClass" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>
                    </tr>

                </table>
                 </form>   
            </td>
        </tr>
</table>