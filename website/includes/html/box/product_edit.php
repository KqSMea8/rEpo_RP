<div class="e_right_box">
    <table width="100%"   border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td  align="center" valign="middle" >
                         <form name="form1" action=""  method="post"  enctype="multipart/form-data" <?php if ($_GET["tab"] == "recommended") { ?> onsubmit="return CheckPromoForm(this);" <?php }?>>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                               
                                    <? if (!empty($_SESSION['mess_product'])) { ?>
                                        <tr>
                                            <td  align="center"  class="message"  >
                                                <? if (!empty($_SESSION['mess_product'])) {
                                                    echo $_SESSION['mess_product'];
                                                    unset($_SESSION['mess_product']);
                                                } ?>	
                                            </td>
                                        </tr>
<? } ?>
                                    <tr>
                                        <td align="center" valign="top" >
                                            <table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">

<? if ($_GET["tab"] == "basic") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Basic Properties </td>
                                                    </tr>

                                                    <tr>
                                                        <td width="48%" align="right"   class="blackbold" >Product Category : <span class="red">*</span> </td>
                                                        <td width="52%" height="30" align="left">
                                                            <select name="CategoryID" id="CategoryID" class="inputbox">
                                                                <option value="">Select Category</option>
                                                                <?php
                                                                $objCategory->getCategories(0, 0, $_GET['CatID']);
                                                                ?>
                                                            </select>	

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td width="48%" align="right"   class="blackbold" >Product Name : <span class="red">*</span> </td>
                                                        <td width="52%" height="30" align="left">
                                                            <input  name="Name" id="Name" value="<? echo stripslashes($arryProduct[0]['Name']); ?>" type="text" class="inputbox"  size="30" maxlength="100" />	 </td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="right"   class="blackbold">Product Sku : </td>
                                                        <td height="30" align="left">
                                                            <input  name="ProductSku"  disabled id="ProductSku" value="<? echo stripslashes($arryProduct[0]['ProductSku']); ?>" type="text" class="inputbox"  size="30" style="color: #CCC;" maxlength="40" />	</td>
                                                    </tr>

                                                    <?php
                                                    global $Config;
                                                    if ($arryProduct[0]['Price2'] > 0) {
                                                        $Price = $arryProduct[0]['Price2'];
                                                        $Price2 = $arryProduct[0]['Price'];
                                                    } else {

                                                        $Price = $arryProduct[0]['Price'];
                                                        $Price2 = "";
                                                    }
                                                    ?>

                                                    <tr>
                                                        <td  height="30" align="right"  class="blackbold" >Price : <span class="red">*</span></td>
                                                        <td align="left"><input name="Price" type="text" class="inputbox" id="Price" value="<? echo number_format($Price, 2, '.', ''); ?>" onkeyup="keyup(this);" size="10" maxlength="10"> <?= $Config['Currency'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td  height="30" align="right"  class="blackbold" >Sale Price :</td>
                                                        <td  align="left"><input name="Price2" type="text" onkeyup="keyup(this);" class="inputbox" id="Price2" value="<? echo number_format($Price2, 2, '.', ''); ?>" size="10" maxlength="10"> <?= $Config['Currency'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td  height="70" align="right" valign="top" class="blackbold"> Product Image : </td>
                                                        <td  height="50" align="left" >

                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
                                                                <tr>
                                                                    <td width="35%" class="blacknormal" valign="top">
                                                                        <input name="Image" type="file" class="inputbox" id="Image" size="25" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                                                        <br>
                                                                        <?= $MSG[201] ?>	
                                                                        <br>
<? 
$MainDir = $Prefix."upload/products/images/".$_SESSION['CmpID']."/"; 
if ($arryProduct[0]['Image'] != '' && file_exists($MainDir.$arryProduct[0]['Image'])) { 
 $OldImage = $MainDir . $arryProduct[0]['Image']; 
?>
<span id="DeleteSpan">
<input type="hidden" name="OldImage" value="<?=$OldImage?>">  

<a data-fancybox-group="gallery" class="fancybox" href="<?=$MainDir.$arryProduct[0][Image]?>"><? echo '<img src="resizeimage.php?w=200&h=200&img=' . $MainDir. $arryProduct[0]['Image'] . '" border=0  >'; ?></a>&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryProduct[0]['Image']?>','DeleteSpan')" onmouseout="hideddrivetip();">
<?=$delete?></a>

</span>	
                                                                           
 <? } ?>	
                                                                    </td>
                                                                </tr>
                                                            </table>	</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"   class="blackbold">Status :  </td>
                                                        <td height="30" align="left"><span class="blacknormal">
                                                                <?
                                                                $ActiveChecked = ' checked';
                                                                if ($_GET['edit'] > 0) {
                                                                    if ($arryProduct[0]['Status'] == 1) {
                                                                        $ActiveChecked = ' checked';
                                                                        $InActiveChecked = '';
                                                                    }
                                                                    if ($arryProduct[0]['Status'] == 0) {
                                                                        $ActiveChecked = '';
                                                                        $InActiveChecked = ' checked';
                                                                    }
                                                                }
                                                                ?>
                                                                <input type="radio" name="Status" style="vertical-align: text-top;
width: 20px;" id="Status" value="1" <?= $ActiveChecked ?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" name="Status" style="vertical-align: text-top;
width: 20px; margin-left:20px;" id="Status" value="0" <?= $InActiveChecked ?>>InActive    </span></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($_GET['tab'] == "alterimages") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Alternative Images : <a class="fancybox" href="#addimage_div" style="float: right;"> Add Alternative Images </a></td>
                                                    </tr>
                                                    <?php if (count($MaxProductImageArr) > 0) { ?>
                                                        <tr>
                                                            <td colspan="2" class="list-Image">
                                                                <ul>
                                                                    <?php
                                                                    $irts = 1;
                                                                    foreach ($MaxProductImageArr as $image) {
                                                                        $ImageName = $image['Image'];
                                                                        $ImageId = $image['Iid'];
                                                                        if ($ImageName != '' && file_exists('../../upload/products/images/secondary/'.$_SESSION['CmpID'].'/' . $ImageName)) {
                                                                            $ImagePath = '../../resizeimage.php?img=upload/products/images/secondary/'.$_SESSION['CmpID'].'/' . $ImageName . '&w=100&h=100';
                                                                            $showImage = '<a data-fancybox-group="gallery" class="fancybox" href="../../upload/products/images/secondary/'.$_SESSION['CmpID'].'/'.$ImageName . '"><img src="' . $ImagePath . '" border=0 align=left></a><a href="javascript:void();" class="deleteProductImages" alt="' . $_GET['edit'] . "#" . $ImageId . '">' . $delete . '</a>';
                                                                        }
                                                                        ?>
                                                                        <li <?php if ($irts % 5 == "0") { ?> class="last"<?php } ?>><?= $showImage; ?></li>
                                                                        <? $irts = $irts + 1;
                                                                    } ?>  
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr valign="middle" bgcolor="#ffffff" align="left">
                                                            <td class="no_record" colspan="5">No Images Found.</td>

                                                        </tr>
                                                    <?php } ?>






                                                <?php } ?>
                                                <? if ($_GET["tab"] == "other") { ?>

                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Other Properties </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" width="48%"  class="blackbold">Product Weight (lbs) :</td>
                                                        <td height="30" align="left" width="52%"  class="blacknormal"><input  name="Weight" id="Weight" value="<? echo stripslashes($arryProduct[0]['Weight']); ?>" type="text" onkeyup="keyup(this);" class="inputbox"  size="10" maxlength="10" /> </td>
                                                    </tr> 

                                                    <tr>
                                                        <td align="right"    class="blackbold"> Featured :  </td>
                                                        <td height="30" align="left">
                                                            <select name="Featured" id="Featured"  class="inputbox">
                                                                <option value="No" <? if ($arryProduct[0]['Featured'] == 'No') echo 'selected'; ?>>No</option>
                                                                <option value="Yes" <? if ($arryProduct[0]['Featured'] == 'Yes') echo 'selected'; ?>>Yes</option>
                                                            </select> 
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td  align="right"   class="blackbold"> Product Manufacturer :  </td>
                                                        <td height="30" align="left">
                                                            <select name="Mid" class="inputbox" id="Mid">
                                                                <option value="">--- Select ---</option>
                                                                <? for ($i = 0; $i < sizeof($arryManufacturer); $i++) { ?>
                                                                    <option value="<?= $arryManufacturer[$i]['Mid'] ?>" <?
                                                            if ($arryManufacturer[$i]['Mid'] == $arryProduct[0]['Mid']) {
                                                                echo "selected";
                                                            }
                                                                    ?>>
                                                                                <?= stripslashes($arryManufacturer[$i]['Mname']) ?>
                                                                    </option>
                                                                <? } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  height="30" align="right"  class="blackbold" >Is this a taxable item? : </td>
                                                        <td align="left"><input type="checkbox" name="IsTaxable" id="IsTaxable" value="1" <? if ($arryProduct[0]['IsTaxable'] == 'Yes') echo 'checked'; ?>></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"    class="blackbold"> Select tax class :  </td>
                                                        <td height="30" align="left">
                                                            <select name="TaxClassId" id="TaxClassId"  class="inputbox">
                                                                <option value="">--- Select ---</option>
                                                                <?php foreach ($arryTaxClasses as $key => $value) { ?>
                                                                    <option value="<?= $value['ClassId'] ?>" <?php if ($value['ClassId'] == $arryProduct[0]['TaxClassId']) {
                                                                echo "selected";
                                                            } ?>><?= $value['ClassName'] ?></option>
    <?php } ?>
                                                            </select> 
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td align="right"    class="blackbold"> Tax rate at product level : </td>
                                                        <td height="30" align="left" >
                                                            <input type="text" name="TaxRate" id="TaxRate"  value="<//?php if($arryProduct[0]['TaxRate'] != "-1.00000"){echo number_format($arryProduct[0]['TaxRate'],2);};?>" class="inputbox">
                                                        </td>
                                                    </tr>-->

                                                    <tr>
                                                        <td  height="30" align="right"  class="blackbold" > Free shipping for this product? :  </td>
                                                        <td align="left"><input type="checkbox" name="FreeShipping" id="FreeShipping" value="Yes" <? if ($arryProduct[0]['FreeShipping'] == 'Yes') echo 'checked'; ?>></td>
                                                    </tr>

      <!-- <tr>
             <td align="right"    class="blackbold"> Shipping price for Product Level  </td>
             <td height="30" align="left" >
                 <input type="text" name="ShippingPrice" id="ShippingPrice"  value="<//?=number_format($arryProduct[0]['ShippingPrice'],2);?>" class="inputbox">
             </td>
         </tr>-->

<?php } ?>
<? if ($_GET["tab"] == "description") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Product Description :  </td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="right" valign="top" width="26%" class="blackbold"> Description :  </td>
                                                        <td align="left" class="editor_box" valign="top" width="52%">
                                                            <Textarea name="Detail" id="Detail" class="inputbox"  ><? echo stripslashes($arryProduct[0]['Detail']); ?></Textarea>

                                                            <script type="text/javascript">

                                                                var editorName = 'Detail';

                                                                var editor = new ew_DHTMLEditor(editorName);

                                                                editor.create = function() {
                                                                    var sBasePath = '../FCKeditor/';
                                                                    var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
                                                                    oFCKeditor.BasePath = sBasePath;
                                                                    oFCKeditor.ReplaceTextarea();
                                                                    this.active = true;
                                                                }
                                                                ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                                ew_CreateEditor(); 


                                                            </script>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td  align="right" valign="top"   class="blackbold">Short Description : </td>
                                                        <td class="editor_box"  align="left" valign="top">
                                                            <Textarea name="ShortDetail" id="ShortDetail" class="inputbox" ><? echo stripslashes($arryProduct[0]['ShortDetail']); ?></Textarea>


                                                            <script type="text/javascript">

                                                                var editorName = 'ShortDetail';

                                                                var editor = new ew_DHTMLEditor(editorName);

                                                                editor.create = function() {
                                                                    var sBasePath = '../FCKeditor/';
                                                                    var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
                                                                    oFCKeditor.BasePath = sBasePath;
                                                                    oFCKeditor.ReplaceTextarea();
                                                                    this.active = true;
                                                                }
                                                                ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                                ew_CreateEditor(); 


                                                            </script>


                                                        </td>
                                                    </tr> 
<?php } ?>
<? if ($_GET["tab"] == "seo") { ?>

                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Seo Properties </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" width="48%" class="blackbold"> Meta Title : </td>
                                                        <td height="30" align="left" width="52%" class="blacknormal">
                                                            <input  name="MetaTitle" id="MetaTitle" value="<? echo stripslashes($arryProduct[0]['MetaTitle']); ?>" type="text"  class="inputbox"  /> 
                                                        </td>
                                                    </tr> 
                                                    <tr>
                                                        <td valign="top" align="right" class="blackbold"> Meta Keywords : </td>
                                                        <td valign="top" align="left">
                                                            <textarea class="inputbox" id="MetaKeyword" name="MetaKeyword"><?= $arryProduct[0]['MetaKeyword']; ?></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" align="right" class="blackbold"> Meta Description : </td>
                                                        <td valign="top" align="left">
                                                            <textarea class="inputbox" id="MetaDescription" name="MetaDescription"><?= $arryProduct[0]['MetaDescription']; ?></textarea>
                                                        </td>
                                                    </tr>
                                                    <!--<tr>
                                                        <td align="right"    class="blackbold"> Product Url (custom):</td>
                                                        <td height="30" align="left"  class="blacknormal">
                                                            <input  name="UrlCustom" id="UrlCustom" value="<? //echo stripslashes($arryProduct[0]['UrlCustom']); ?>" type="text"  class="inputbox"  /> 
                                                        </td>
                                                    </tr>-->  



<?php } ?>
<? if ($_GET["tab"] == "addattributes") { ?>

                                                    <tr>
                                                        <td colspan="2" align="left"> <a class="fancybox" href="#addattribute_div" style="float: right;"> Add New Attribute  </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="head1">Attribute Name</td>
                                                                        <td class="head1">Priority</td>
                                                                        <td class="head1">Active</td>
                                                                        <td class="head1">Action</td>
                                                                    </tr>
    <?php if (count($AttributesArr) > 0) {
        foreach ($AttributesArr as $attribute) {
            ?>
                                                                            <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                                <td><?= $attribute['name']; ?></td>
                                                                                <td><?= $attribute['priority']; ?></td>
                                                                                <td><?= $attribute['is_active']; ?></td>
                                                                                <td><a href="editProduct.php?edit=<? echo $_GET['edit']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $_GET['CatID'] ?>&attID=<?= $attribute['paid']; ?>&tab=editattributes"><?= $edit ?></a>  <a href="javascript:void();" class="deleteProductAttribute" alt="<?= $_GET['edit'] . "#" . $attribute['paid'] ?>"><?= $delete ?></a>	</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                            <td class="no_record" colspan="5">No Attributes Found.</td>

                                                                        </tr>
    <?php } ?>
                                                                </tbody>
                                                            </table> 
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="formItemComment dialog-add-attribute-help">
                                                                You are allowed to enter an unlimited number of attributes to any product. 
                                                                Attributes allow you to give your customer's choices for any product. 
                                                                Examples include size, color, or type. Each new selection must be entered on a new line for it to appear correctly. 
                                                                If the attribute is a price modifier, you need to tell the system to increase or decrease the price (+ or -) 
                                                                between parenthesis ( ) at the end of each attribute.You can also modify weight on an attribute by entering the increase or decrease after the price and separated by a comma. 
                                                                Examples below.<br><br>
                                                                <table cellspacing="0" cellpadding="0" width="100%" class="attribute-admin-list-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Small(-25,-10)</td>
                                                                            <td>Decrease price by 25, decrease weight by 10</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Small(+25,+10)</td>
                                                                            <td>Increase price by 25, Increase weight by 10</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>X-Large(+10)</td>
                                                                            <td>Increase price by 10</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>


                                                        </td>
                                                    </tr>


<?php } ?>
<?php if ($_GET["tab"] == "editattributes") { ?>
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
                                                                    <td  align="right"   class="blackbold" valign="top">Options <span class="red">*</span></td>
                                                                    <td height="30" align="left">
                                                                        <textarea  name="options" id="options"  class="inputbox" style="width:90%; height: 115px;"><?= $productAttribute[0]['options']; ?></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

<?php } ?>
<? if ($_GET["tab"] == "discount") { ?>

                                                    <tr>
                                                        <td colspan="2" align="left"><a class="fancybox" href="#adddiscount_div" style="float: right;"> Add New Discount</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="head1">Min Range</td>
                                                                        <td class="head1">Max Range</td>
                                                                        <td class="head1">Discount</td>
                                                                        <td class="head1">Discount Type</td>
                                                                        <td class="head1">Active</td>
                                                                        <td class="head1">Action</td>
                                                                    </tr>
    <?php if (count($DiscountArr) > 0) {
        foreach ($DiscountArr as $discount) {
            ?>
                                                                            <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                                <td><?= $discount['range_min']; ?></td>
                                                                                <td><?= $discount['range_max']; ?></td>
                                                                                <td><?= number_format($discount['discount'], 2); ?></td>
                                                                                <td><?= $discount['discount_type']; ?></td>
                                                                                <td><?= $discount['is_active']; ?></td>
                                                                                <td>
                                                                                    <a href="editProduct.php?edit=<? echo $_GET['edit']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $_GET['CatID'] ?>&disID=<?= $discount['qd_id']; ?>&tab=editDiscount" ><?= $edit ?></a>  
                                                                                    <a href="javascript:void();" class="deleteProductDiscount" alt="<?= $_GET['edit'] . "#" . $discount['qd_id'] ?>"><?= $delete ?></a>
                                                                                    </td>
                                                                            </tr>
            <?php
        }
    } else {
        ?>
                                                                        <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                            <td class="no_record" colspan="6">No Discount Found.</td>

                                                                        </tr>
    <?php } ?>
                                                                </tbody>
                                                            </table> 
                                                        </td>
                                                    </tr>



<?php } ?>
<?php if ($_GET["tab"] == "editDiscount") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Edit Discount </td>
                                                    </tr>

                                                    <tr>
                                                        <td  colspan="2" > 
                                                            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right"  width="48%"  class="blackbold">Min Range :<span class="red">*</span></td>
                                                                    <td height="30" align="left" width="52%" class="blacknormal"><input  name="range_min" id="range_min"  class="inputbox" onkeyup="keyup(this);" value="<? echo stripslashes($productDiscount[0]['range_min']); ?>" type="text" />  </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td  height="30" align="right"  class="blackbold" >Max Range : <span class="red">*</span> </td>
                                                                    <td><input  name="range_max" id="range_max" onkeyup="keyup(this);"  class="inputbox" value="<? echo stripslashes($productDiscount[0]['range_max']); ?>" type="text" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td  height="30"  class="blackbold" align="right">Discount  :<span class="red">*</span> </td>
                                                                    <td>
                                                                        <input  name="discount" id="discount" onkeyup="keyup(this);"  class="inputbox" value="<? echo stripslashes(number_format($productDiscount[0]['discount'], 2)); ?>" type="text" />
                                                                    </td>
                                                                </tr>  
                                                                <tr>
                                                                    <td  height="30"  class="blackbold" align="right"> Discount Type : <span class="red">*</span> </td>
                                                                    <td>
                                                                        <select name="discount_type" class="inputbox" id="discount_type" style="width:190px;">
                                                                            <option>---Select---</option>
                                                                            <option value="Amount" <? if ($productDiscount[0]['discount_type'] == 'amount') echo 'selected'; ?>>Amount</option>
                                                                            <option value="Percent" <? if ($productDiscount[0]['discount_type'] == 'percent') echo 'selected'; ?>>Percent</option>
                                                                        </select>
                                                                    </td>
                                                                </tr> 
                                                                <!-- <tr>
                                                                    <td  height="30"  class="blackbold" align="right"> Customer Type  <span class="red">*</span></td>
                                                                    <td>
                                                                           <select name="customer_type" class="inputbox" id="customer_type" style="width:190px;">
                                                                            <option>---Select---</option>
                                                                            <option value="customer" <? //if ($productDiscount[0]['customer_type'] == 'customer') echo 'selected';  ?>>customer</option>
                                                                            <option value="wholesale" <? //if ($productDiscount[0]['customer_type'] == 'wholesale') echo 'selected';  ?>>wholesale</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>-->  

                                                                <tr>
                                                                    <td  height="30"  class="blackbold" align="right">Is This Discount Active? :  </td>
                                                                    <td>
                                                                        <input type="checkbox" name="is_active" id="is_active" value="Yes" <? if ($productDiscount[0]['is_active'] == 'Yes') echo 'checked'; ?>>
                                                                        <input type="hidden" name="ProductSalePrice" id="ProductSalePrice" value="<?= $ProductSalePrice ?>" />

                                                                    </td>
                                                                </tr>  


                                                            </table>
                                                        </td>
                                                    </tr>

<?php } ?>
<?php if ($_GET["tab"] == "recommended") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Recommended </td>
                                                    </tr>

                                                 <tr valign="top">
						<td class="formItemCaption required">Products:</td>
						<td class="formItemControl">
							Type in part of the product name or ID: <br/>
							<div id="inDiv">
								<input type="text" name="searchStr" class="inputbox" id="searchStr">
								<input type="hidden" name="searchLimit" id="searchLimit" value="10">
							</div>
							
							<div class="formHelp">
								Our auto search feature will attempt to search your product database as you are entering in the product data
							</div>
							
							<br/>
							
							<input type="hidden" name="promo_products" value="" style="padding:0px;margin:0px;width:1px;height:1px;">
							 Recommended product for this product: <br/>
							<select name="select_products[]"  class="select multiselect" multiple id="select_products">
							<?php
                                                       
								$result = mysql_query("
									SELECT  p.ProductID, p.ProductSku, p.Name 
									FROM e_recommended_products rp
									INNER JOIN e_products p ON p.ProductID = rp.RecommendedProductID
									WHERE rp.ProductID='".$_REQUEST['edit']."'
								");
								while ($row = mysql_fetch_array($result))
								{
								  echo '<option value="'.$row["ProductID"].'">'.$row["ProductSku"]." - ".$row["Name"].'</option>';
								}
                                                        
							?>
                                                           
							</select>
							<br/>
							<a href="javascript:removeProducts();">Remove Selected</a>
						</td>
					</tr>

                                            <?php } ?>
                                             <?php if ($_GET["tab"] == "inventory") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Inventory Control </td>
                                                    </tr>

                                                    <tr>
                                                        <td  colspan="2" > 
                                                            <?php
                                                            if ($arryProduct[0]['InventoryControl'] == "Yes")
                                                                $checked_yes = "checked";
                                                            else
                                                                $checked_no = "checked";
                                                            ?>
                                                            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right" width="48%"  class="blackbold">Inventory enable :</td>
                                                                    <td height="30" align="left" width="52%" class="blacknormal">
                                                                        <input type="radio" name="InventoryControl" id="inventory_control_no" value="No" style="vertical-align:text-top; width:10px;" <?= $checked_no; ?>> No
                                                                        <input type="radio" name="InventoryControl" id="inventory_control_yes" value="Yes" style="vertical-align:text-top; width:10px; margin-left:20px;" <?= $checked_yes; ?>> Yes
                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td  colspan="2"  style="display:<?php if ($arryProduct[0]['InventoryControl'] == "Yes") { ?>table-cell<?php } else { ?>none<?php } ?>;" id="showInventoryControl"> 
                                                                        <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                            <tr>
                                                                                <td  height="30" width="48%"  class="blackbold" align="right">  If product is out of stock  :<span class="red">*</span> </td>
                                                                                <td  width="52%" align="left">
                                                                                    <select name="InventoryRule" class="inputbox" id="inventory_rule">
                                                                                        <option>---Select---</option>
                                                                                        <option  value="OutOfStock" <?php if ($arryProduct[0]['InventoryRule'] == "OutOfStock") {
                                                                echo "selected";
                                                            } ?>>Show "Out of Stock" message</option>
                                                                                        <option value="Hide" <?php if ($arryProduct[0]['InventoryRule'] == "Hide") {
                                                                echo "selected";
                                                            } ?>>Do not display</option>
                                                                                    </select>
                                                                                </td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td  height="30" align="right"  class="blackbold" > Number of items in inventory  :<span class="red">*</span></td>
                                                                                <td align="left"><input  name="Quantity" id="Quantity" onkeyup="keyup(this);" class="inputbox" value="<? echo stripslashes($arryProduct[0]['Quantity']); ?>" type="text" /></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td  height="30"  class="blackbold" align="right">Notify me when inventory is equal to or less than  :<span class="red">*</span> </td>
                                                                                <td align="left">
                                                                                    <input  name="StockWarning" id="stock_warning" onkeyup="keyup(this);" class="inputbox" value="<? echo stripslashes($arryProduct[0]['StockWarning']); ?>" type="text" />
                                                                                </td>
                                                                            </tr>  
                                                                        </table>
                                                                    </td> 
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

                                            <?php } ?>       
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="54" align="center">
                                            <br>
                                            <?
                                            if ($_GET['edit'] > 0) {
                                                if ($_GET['tab'] == "addattributes" || $_GET['tab'] == "editattributes") {
                                                    $ButtonID = 'UpdateAttribute';
                                                    $ButtonTitle = 'Save';
                                                } elseif ($_GET['tab'] == "basic") {
                                                    $ButtonID = 'UpdateBasic';
                                                    $ButtonTitle = 'Update';
                                                } elseif ($_GET['tab'] == "discount" || $_GET['tab'] == "editDiscount") {
                                                    $ButtonID = 'UpdateDiscount';
                                                    $ButtonTitle = 'Save';
                                                } elseif ($_GET['tab'] == "other") {
                                                    $ButtonID = 'UpdateOther';
                                                    $ButtonTitle = 'Update';
                                                } elseif ($_GET['tab'] == "inventory") {
                                                    $ButtonID = 'UpdateInventory';
                                                    $ButtonTitle = 'Save';
                                                } elseif ($_GET['tab'] == "alterimages") {

                                                    $ButtonTitle = 'Save';
                                                } else {
                                                    $ButtonID = 'btn';
                                                    $ButtonTitle = 'Update';
                                                }
                                            } else {
                                                $ButtonTitle = 'Submit';
                                            }

                                           

                                            if (sizeof($arryCategory) <= 0)
                                                $DisabledButton = 'disabled';
                                            ?>
                                            <?php if ($_GET['tab'] != "alterimages" && $_GET['tab'] != "addattributes" && $_GET['tab'] != "discount") { ?>
                                                <input name="Submit" type="submit" class="button" id="<?= $ButtonID; ?>" value=" <?= $ButtonTitle ?> " <?= $DisabledButton ?> />
                                            <?php } ?>
                                            <input type="hidden" name="ProductID" id="ProductID" value="<? echo $_GET['edit']; ?>" />
                                            <input type="hidden" name="AttributeId" id="AttributeId" value="<? echo $_GET['attID']; ?>" />
                                            <input type="hidden" name="DiscountId" id="DiscountId" value="<? echo $_GET['disID']; ?>" />
                                            <input  name="ProductSku" value="<? echo stripslashes($arryProduct[0]['ProductSku']); ?>" type="hidden"/>
                                            <input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />


                                        </td>
                                    </tr>                                
                            </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<? if ($_GET['tab'] == "alterimages") {
    include("includes/html/box/addimage_form.php");
} ?>
<? if ($_GET['tab'] == "addattributes") {
    include("includes/html/box/addattribute_form.php");
} ?>
<? if ($_GET['tab'] == "discount") {
    include("includes/html/box/adddiscount_form.php");
} ?>
