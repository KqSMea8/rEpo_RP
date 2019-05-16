 <tr>
                                                        <td colspan="2" align="left" class="head">Edit <? echo stripslashes($productAttribute[0]['name']); ?> Attribute </td>
                                                    </tr>
                                                    <tr>
                                                        <td  colspan="2" > 
                                                            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right"  width="48%"  class="blackbold">Attribute Name <span class="red">*</span></td>
                                                                    <td height="30" align="left" width="52%"  class="blacknormal">
                                                                        <input  name="attname" id="attname" class="inputbox" value="<? echo stripslashes($productAttribute[0]['name']); ?>" type="text" />  </td>
                                                                </tr> 
                                                                <!--<tr>
                                                                    <td  height="30" align="right"  class="blackbold" >Attribute Caption <span class="red">*</span> </td>
                                                                    <td><input  name="caption" id="caption" value="<? //echo stripslashes($productAttribute[0]['caption']);  ?>" type="text" /></td>
                                                                </tr>-->
                                                                <tr>
                                                                    <td  height="30"  class="blackbold" align="right">Attribute Type  </td>
                                                                    <td>
                                                                        <select name="attribute_type" class="inputbox" id="attribute_type" style="width:190px;">
                                                                            <option value="select">Drop-down</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>  
                                                                <tr>
                                                                    <td  height="30"  class="blackbold" align="right">Is This Attribute Active?  </td>
                                                                    <td><input type="checkbox" name="is_active" id="is_active" value="Yes" <? if ($productAttribute[0]['is_active'] == 'Yes') echo 'checked'; ?>></td>
                                                                </tr>  
<tr>
                        <td   class="blackbold" align="right">Is this attribute Required? :</td>
                        <td align="left" ><select  name="required" class="inputboxSmall" id="required">
                            <option value="1" <?php if($productAttribute[0]['required'] == "1"){echo "selected";} ?>>Yes</option>
                            <option  value="0" <?php if($productAttribute[0]['required'] == "0"){echo "selected";} ?>>No</option>
                          </select>
                        </td>
                      </tr>
                                                                <tr>
                                                                    <td align="right"    class="blackbold"> Priority  </td>
                                                                    <td height="30" align="left" >
                                                                        <select name="priority" id="priority" class="inputbox" style="width:185px;">
                                                                            <option value="1" <? if ($productAttribute[0]['priority'] == '1') echo 'selected'; ?>>1</option>
                                                                            <option value="2" <? if ($productAttribute[0]['priority'] == '2') echo 'selected'; ?>>2</option>
                                                                            <option value="3" <? if ($productAttribute[0]['priority'] == '3') echo 'selected'; ?>>3</option>
                                                                            <option value="4" <? if ($productAttribute[0]['priority'] == '4') echo 'selected'; ?>>4</option>
                                                                            <option value="5" <? if ($productAttribute[0]['priority'] == '5') echo 'selected'; ?>>5</option>
                                                                            <option value="6" <? if ($productAttribute[0]['priority'] == '6') echo 'selected'; ?>>6</option>
                                                                            <option value="7" <? if ($productAttribute[0]['priority'] == '7') echo 'selected'; ?>>7</option>
                                                                            <option value="8" <? if ($productAttribute[0]['priority'] == '8') echo 'selected'; ?>>8</option>
                                                                            <option value="9" <? if ($productAttribute[0]['priority'] == '9') echo 'selected'; ?>>9</option>
                                                                            <option value="10" <? if ($productAttribute[0]['priority'] == '10') echo 'selected'; ?>>10</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>

						<tr>
						<td colspan="2">

                                                               <? 	include("includes/html/box/global_att_form.php");?>
 						</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
