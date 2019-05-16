<?
if(empty($arryAttributes)){
	$arryAttributes = $objConfigure->GetDefaultArrayValue('e_products_attributes'); 
}				 
?>
      <tr>
                                                        <td colspan="2">

                                    <input type="hidden" name="CategoryID" id="CategoryID" value="<? echo $CategoryID; ?>" /> 
      <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right"    class="blackbold">Attribute Name <span class="red">*</span></td>
                                                                    <td height="30" align="left"  class="blacknormal">
                                                                        <input  name="attname" class="inputbox" id="attname" value="" type="text" />  </td>
                                                                </tr> 
                                                                <!--<tr>
                                                                    <td  height="30" align="right"  class="blackbold" >Attribute Caption <span class="red">*</span> </td>
                                                                    <td><input  name="caption" id="caption" class="inputbox" value="" type="text" /></td>
                                                                </tr>-->
                                                                <tr>
                                                                <td  height="30"  class="blackbold" align="right">Attribute Type  </td>
                                                                <td>
                                                                       <select name="attribute_type" class="inputbox" id="attribute_type">
                                                                        <option value="select">Drop-down</option>
                                                                    </select>
                                                                </td>
                                                            </tr>  
                                                            <tr>
                                                               <td  height="30"  class="blackbold" align="right">Is This Attribute Active?  </td>
                                                               <td><input type="checkbox" name="is_active" id="is_active" value="Yes" ></td>
                                                           </tr>  
<tr>
                        <td  height="30"  class="blackbold" align="right">Is this attribute Required? :</td>
                        <td align="left" ><select  name="required" class="inputboxSmall" id="required">
                            <option value="1" <?php if($arryAttributes[0]['required'] == "1"){echo "selected";} ?>>Yes</option>
                            <option  value="0" <?php if($arryAttributes[0]['required'] == "0"){echo "selected";} ?>>No</option>
                          </select>
                        </td>
                      </tr>
<!--tr>
			<td  height="30"  class="blackbold" align="right">File Upload  </td>
			<td><input type="checkbox" name="is_upld" id="is_upld" onclick="getUploadType(this.value);" value="1" ></td>
			</tr> 
<tr id="label_up" style="display:none;">
			<td  height="30"  class="blackbold" align="right">Label  </td>
			<td><input type="text" class="inputbox" name="label_txt" id="label_txt" value="" ></td>
		</tr>-->
                                                         <tr>
                                                            <td align="right"    class="blackbold"> Priority  </td>
                                                            <td height="30" align="left" >
                                                            <select name="priority" id="priority" class="inputbox">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option selected="selected" value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
			</select>
                                                        </td>
                                                    </tr>

                                                    <tr>
	<td colspan="2"  align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			 <td  align="left" class="head" >Option List</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/global_att_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>
                                                 </table>
                                 
                               </td></tr>
                               
