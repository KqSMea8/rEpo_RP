<script type="text/javascript" src="js/product.js"></script>
<div class="had"> <span><?=$ModuleName; ?></span></div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
<?php if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	  <table width="100%"   border="0" align="center" cellpadding="0" cellspacing="0" >
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
      <td  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td  align="center" valign="middle" ><table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                <form name="form1" id="productBasicInfoForm" action=""  method="post"  enctype="multipart/form-data">
                  <tr>
                    <td align="center" valign="top" >
					<table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">
                        <tr>
                          <td width="40%" align="right"   class="blackbold" >Product Category : <span class="red">*</span> </td>
                          <td width="60%" height="30" align="left">
                              <select name="CategoryID" id="CategoryID" class="inputbox">
                              <option value="">Select Category</option>
                              <?php 
                                                    
                                                      $objCategory->getCategories(0,0,$_GET['ParentID']);
                                                     ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td width="31%" align="right"   class="blackbold" >Product Name : <span class="red">*</span> </td>
                          <td width="69%" height="30" align="left"><input  name="Name" id="Name" value="<? echo stripslashes($arryProduct[0]['Name']); ?>" type="text" class="inputbox"  size="30" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td align="right"   class="blackbold">Product Sku : <span class="red">*</span> </td>
                          <td height="30" align="left">
						  <input  name="ProductSku" id="ProductSku" value="<? echo stripslashes($arryProduct[0]['ProductSku']); ?>" type="text" class="inputbox" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ProductSku','');" size="30" maxlength="40" />
	                     <span id="MsgSpan_ModuleID"></span>
						 
                          </td>
                        </tr>
                        <tr>
                          <td  height="30" align="right"  class="blackbold" >Price : <span class="red">*</span></td>
                          <td   align="left"><input name="Price" type="text" class="inputbox" id="Price" value="<? echo $arryProduct[0]['Price']; ?>" onkeyup="keyup(this);" size="10" maxlength="10">
                            <?= $Config['Currency']; ?></td>
                        </tr>
                       
                        <tr>
                          <td  height="70" align="right" valign="top"   class="blackbold"> Product Image : </td>
                          <td  height="50" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0"  >
                              <tr>
                                <td width="66%" class="blacknormal" valign="top"><input name="Image" type="file" class="inputbox" id="Image" size="25" onkeypress="javascript: return false;" style="width: 183px;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                  <br>
                                  <?= $MSG[201] ?>
                                </td>
                                <td width="34%"><? if ($arryProduct[0]['Image'] != '' && file_exists('../../upload/products/images/' . $arryProduct[0]['Image'])) { ?>
                                  <a  href="Javascript:OpenNewPopUp('../../showimage.php?img=upload/products/images/<? echo $arryProduct[0][Image]; ?>', 150, 100, 'yes' );"><? echo '<img src="../../resizeimage.php?w=100&h=100&img=upload/products/images/' . $arryProduct[0]['Image'] . '" border=0  >'; ?></a>
                                  <? } ?>
                                </td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td align="right"   class="blackbold">Status : </td>
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
                            <input type="radio" name="Status" style="vertical-align:text-top; width:10px;" id="Status" value="1" <?= $ActiveChecked ?>>
                            Active&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="Status" style="vertical-align:text-top; width:10px; margin-left:20px;" id="Status" value="0" <?= $InActiveChecked ?>>
                            InActive </span></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td height="54" align="center"><br>
                      <?php
                                        if ($_GET['edit'] > 0)
                                            $ButtonTitle = 'Update'; else
                                            $ButtonTitle = 'Submit';

                                        $PostedByID = $arryProduct[0]['PostedByID'];
                                        if ($PostedByID <= 1)
                                            $PostedByID = 1;

                                        if (sizeof($arryCategory) <= 0)
                                            $DisabledButton = 'disabled';
                                        ?>
                 <input name="Submit" type="button" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    
                     
					  </td>
                  </tr>
                </form>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
	
     </td>
    </tr>
</table>