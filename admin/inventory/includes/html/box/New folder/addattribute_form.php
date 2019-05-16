<div id="addattribute_div" style="display:none; width: 400px; height: 350px;">
      <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
                                    <input type="hidden" name="CategoryID" id="CategoryID" value="<? echo $CategoryID; ?>" /> 
      <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right"    class="blackbold">Attribute Name <span class="red">*</span></td>
                                                                    <td height="30" align="left"  class="blacknormal">
                                                                        <input  name="attname" class="inputbox" id="attname" value="" type="text" />  </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td  height="30" align="right"  class="blackbold" >Attribute Caption <span class="red">*</span> </td>
                                                                    <td><input  name="caption" id="caption" class="inputbox" value="" type="text" /></td>
                                                                </tr>
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
                                                        <td  align="right"   class="blackbold" valign="top">Options <span class="red">*</span></td>
                                                        <td height="30" align="left">
                                                         <textarea  name="options" id="options" style="width:100%; height: 115px;"></textarea>
                                                        </td>
                                                    </tr>
                                                 </table>
                                     <input name="Submit" type="submit" style="display: block; margin: auto;" class="button" id="<?=$ButtonID;?>" value=" <?= $ButtonTitle ?> " <?= $DisabledButton ?> />
                                            
                                            <input type="hidden" name="ProductID" id="ProductID" value="<? echo $_GET['edit']; ?>" />
                                            <input type="hidden" name="AttributeId" id="AttributeId" value="<? echo $_GET['attID']; ?>" />
                                              <input type="hidden" name="DiscountId" id="DiscountId" value="<? echo $_GET['disID']; ?>" />
                                            <input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
                               </form>
                               </div>
