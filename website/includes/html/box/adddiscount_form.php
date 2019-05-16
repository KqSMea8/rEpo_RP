<div id="adddiscount_div" style="display:none; width: 370px; height: 228px;">
      <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
                                    <input type="hidden" name="CategoryID" id="CategoryID" value="<? echo $CategoryID; ?>" /> 
         <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right"    class="blackbold">Min Range :<span class="red">*</span></td>
                                                                    <td height="30" align="left"  class="blacknormal">
                                                                        <input  name="range_min" id="range_min" class="inputbox" onkeyup="keyup(this);" value="" type="text" />  </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td  height="30" align="right"  class="blackbold" >Max Range : <span class="red">*</span> </td>
                                                                    <td><input  name="range_max" id="range_max" class="inputbox" onkeyup="keyup(this);" value="" type="text" /></td>
                                                                </tr>
                                                                <tr>
                                                                <td  height="30"  class="blackbold" align="right">Discount : <span class="red">*</span> </td>
                                                                <td>
                                                                       <input  name="discount" id="discount" class="inputbox" onkeyup="keyup(this);" value="" type="text" />
                                                                </td>
                                                            </tr>  
                                                              <tr>
                                                                <td  height="30"  class="blackbold" align="right"> Discount Type : <span class="red">*</span> </td>
                                                                <td>
                                                                       <select name="discount_type" class="inputbox" id="discount_type">
                                                                        <option>---Select---</option>
                                                                        <option value="amount">Amount</option>
                                                                        <option value="percent">Percent</option>
                                                                    </select>
                                                                </td>
                                                            </tr> 
                                                           <!--  <tr>
                                                                <td  height="30"  class="blackbold" align="right"> Customer Type  <span class="red">*</span></td>
                                                                <td>
                                                                       <select name="customer_type" class="inputbox" id="customer_type">
                                                                        <option>---Select---</option>
                                                                        <option value="customer">customer</option>
                                                                        <option value="wholesale">wholesale</option>
                                                                    </select>
                                                                </td>
                                                            </tr>-->  
                                                           
                                                            <tr>
                                                               <td  height="30"  class="blackbold" align="right">Is This Discount Active? :  </td>
                                                               <td><input type="checkbox" name="is_active" id="is_active" value="Yes"></td>
                                                           </tr>  

                                                    
                                                 </table>
                                     <input name="Submit" type="submit" style="display: block; margin: 0 0 0 147px;" class="button" id="<?=$ButtonID;?>" value=" <?= $ButtonTitle ?> " <?= $DisabledButton ?> />
                                            
                                        <input type="hidden" name="ProductSalePrice" id="ProductSalePrice" value="<?=$ProductSalePrice?>" />
                                            <input type="hidden" name="ProductID" id="ProductID" value="<? echo $_GET['edit']; ?>" />
                                            <input type="hidden" name="AttributeId" id="AttributeId" value="<? echo $_GET['attID']; ?>" />
                                              <input type="hidden" name="DiscountId" id="DiscountId" value="<? echo $_GET['disID']; ?>" />
                                            <input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
                               </form>
                               </div>
