<div class="e_right_box">
<table width="100%"   border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
        <td  align="center" valign="top">
            <table width="100%"   border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td  align="center" valign="middle" >     
                        <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                            <form name="form1" id="productBasicInfoForm" action=""  method="post"  enctype="multipart/form-data">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">
       
                                        <tr>
                                                 <td colspan="2" align="left" class="head">General </td>
                                        </tr>
                                        
                                         <tr>
                                                <td width="31%" align="right"   class="blackbold" >Item Code/Input scan bar code:  <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                    <input  name="Name" id="Name" value="<? echo stripslashes($arryProduct[0]['Name']); ?>" type="text" class="inputbox"  size="30" maxlength="100" />	 </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="31%" align="right"   class="blackbold" >Item Description : <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                    <textarea name="Name" class="inputbox" id="Name" ><? echo stripslashes($arryProduct[0]['Name']); ?></textarea>	 </td>
                                            </tr>
                                            
                                              <tr>
                                                <td width="31%" align="right"   class="blackbold" >Item Serial Number : <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                    <input  name="Name" id="Name" value="<? echo stripslashes($arryProduct[0]['Name']); ?>" type="text" class="inputbox"  size="30" maxlength="100" />	 </td>
                                            </tr>
                                             <tr>
                                                <td width="31%" align="right"   class="blackbold" >Procurement Method :  <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                   <select name="CategoryID" id="CategoryID" class="inputbox">
                                                        <option value="">Select Procurement</option>
                                                        <option value="Procurement1">Procurement1</option>
                                                        <option value="Procurement2">Procurement2</option>  
                                                          </select>
                                                        </td>
                                            </tr>
                                             <tr>
                                                <td width="31%" align="right"   class="blackbold" >Evaluation Type :  <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                   <select name="CategoryID" id="CategoryID" class="inputbox">
                                                        <option value="">Select Evaluation</option>
                                                        <option value="Evaluation1">Evaluation1</option>
                                                        <option value="Evaluation2">Evaluation2</option>  
                                                          </select>
                                                        </td>
                                            </tr>
                                        
                                          <tr>
                                                <td width="31%" align="right"   class="blackbold" >Category /SubCategory<span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                    <select name="CategoryID" id="CategoryID" class="inputbox">
			                            <option value="">Select Category</option>
                                                    <?php 
                                                    
                                                       foreach($listAllCategory as $key=>$value){
                                                        
                                                        $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                        
                                                    
                                                             ?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
                                                    <?php 
                                                    
                                                     foreach ($arrySubCategory as $key => $value) {
                                                      $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                    ?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     
                                                     <?php
                                                     foreach ($arrySubCategory as $key => $value) { 
                                                         $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']); 
                                                         ?>
                                                      <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                      <?php
                                                     foreach ($arrySubCategory as $key => $value) { ?>
                                                      <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     <?php 
                                                         }
                                                        }
                                                     
                                                      }
                                                    } 
                                                     ?>
                                                    </select>	
                                                
                                                </td>
                                            </tr>
 <tr>
                                                <td width="31%" align="right"   class="blackbold" >Item Type :  <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                   <select name="itemType" id="itemType" class="inputbox">
                                                        <option value="">Select Evaluation</option>
                                                        <option value="Never Diminising">Never Diminising</option>
                                                        <option value="Assembled">Assembled</option>  
                                                         <option value="Component">Component</option>  
                                                          </select>
                                                        </td>
                                            </tr>
                                            <tr>
                                                <td width="31%" align="right"   class="blackbold" >Unit Measure:<span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                    <input  name="UnitMeasure" id="UnitMeasure" value="<? echo stripslashes($arryProduct[0]['UnitMeasure']); ?>" type="text" class="inputbox"  size="30" maxlength="100" />	 </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold">Min Stock Alert Level : </td>
                                                <td height="30" align="left">
                                                    <input  name="min_stock_alert_level" id="min_stock_alert_level" value="<? echo stripslashes($arryProduct[0]['min_stock_alert_level']); ?>" type="text" class="inputbox"  size="30" maxlength="40" />	</td>
                                            </tr>
                                             <td  align="right"   class="blackbold">Max Stock Alert Level : </td>
                                                <td height="30" align="left">
                                                    <input  name="max_stock_alert_level" id="max_stock_alert_level" value="<? echo stripslashes($arryProduct[0]['max_stock_alert_level']); ?>" type="text" class="inputbox"  size="30" maxlength="40" />	</td>
                                            </tr>

                                          <tr>
                                                <td  height="30" align="right"  class="blackbold" >Insurance Policy :</td>
                                                <td   ><input name="insurance_policy" type="text" class="inputbox" id="insurance_policy" value="<? echo $arryProduct[0]['insurance_policy']; ?>"  size="10" maxlength="10"></td>
                                            </tr>
                                           <tr>
                                                <td width="31%" align="right"   class="blackbold" >Purchase Tax Rate :  <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                   <select name="purchase_tax_rate" id="purchase_tax_rate" class="inputbox">
                                                        <option value="">Select Purchase Tax Rate</option>
                                                        <option value="Never Diminising">Purchase Tax Rate1</option>
                                                        <option value="Assembled">Purchase Tax Rate2</option>  
                                                         <option value="Component">Purchase Tax Rate3</option>  
                                                          </select>
                                                        </td>
                                            </tr>
                                             <tr>
                                                <td width="31%" align="right"   class="blackbold" >Sale Tax Rate :  <span class="red">*</span> </td>
                                                <td width="69%" height="30" align="left">
                                                   <select name="sale_tax_rate" id="sale_tax_rate" class="inputbox">
                                                        <option value="">Select Sale Tax Rate</option>
                                                        <option value="Never Diminising">sale Tax Rate1</option>
                                                        <option value="Assembled">sale Tax Rate2</option>  
                                                         <option value="Component">sale Tax Rate3</option>  
                                                          </select>
                                                        </td>
                                            </tr>
                                            <tr>
                                                <td  height="70" align="right" valign="top"   class="blackbold"> Product Image </td>
                                                <td  height="50" align="left" valign="top" >

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
                                                        <tr>
                                                            <td width="51%" class="blacknormal" valign="top"><input name="Image" type="file" class="inputbox" id="Image" size="25" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                                                <br>
<?= $MSG[201] ?>	</td>
                                                            <td width="49%">
                                                                <? if ($arryProduct[0]['Image'] != '' && file_exists('../../upload/products/images/' . $arryProduct[0]['Image'])) { ?>
                                                                    <a  href="Javascript:OpenNewPopUp('../../showimage.php?img=upload/products/images/<? echo $arryProduct[0][Image]; ?>', 150, 100, 'yes' );"><? echo '<img src="../../resizeimage.php?w=100&h=100&img=upload/products/images/' . $arryProduct[0]['Image'] . '" border=0  >'; ?></a>	
                                                                  <? } ?>	
                                                            </td>
                                                        </tr>
                                                    </table>	</td>
                                            </tr>
           <tr>
                                                <td align="right"   class="blackbold">Status  </td>
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
                                                        <input type="radio" name="Status" id="Status" value="1" <?= $ActiveChecked ?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="Status" id="Status" value="0" <?= $InActiveChecked ?>>InActive    </span></td>
                                            </tr>
                                        
                                       
          
                                        </table>
                                    </td>
                                </tr>
                                <tr><td height="54" align="center">
                                        <br>
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
                                        <input name="Submit" type="button" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> " <?= $DisabledButton ?> />
                                        <input type="hidden" name="ProductID" id="ProductID" value="<? echo $_GET['edit']; ?>" />
                                        <input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
                                        <input type="hidden" name="OldStatus" id="OldStatus" value="<?= $arryProduct[0]['Status'] ?>" >
                                        <input  type="hidden" name="NumLanguages" id="NumLanguages" value="<?= $NumLanguages ?>" />
                                        <input type="reset" name="Reset" value="Reset" class="button" /></td>
                                </tr>

                            </form>
                        </table>
                    </td>
                </tr>
            </table></td>
    </tr>
 </table>
</div>