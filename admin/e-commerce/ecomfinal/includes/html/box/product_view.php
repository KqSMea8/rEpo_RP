<div class="e_right_box">
    <table width="100%"   border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td  align="center" valign="middle" >

                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                                <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
                                    <input type="hidden" name="CategoryID" id="CategoryID" value="<? echo $CategoryID; ?>" /> 
                                     <? if (!empty($_SESSION['mess_product'])) {?>
                                                        <tr>
                                                        <td  align="center"  class="message"  >
                                                                <? if(!empty($_SESSION['mess_product'])) {echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); }?>	
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
                                                            <select name="CategoryID" id="CategoryID" class="inputbox" disabled>
                                                            <option value="0">Select Category</option>
                                                            <?php 

                                                               foreach($listAllCategory as $key=>$value){

                                                                $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);


                                                                     ?>
                                                             <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
                                                            <?php 

                                                             foreach ($arrySubCategory as $key => $value) {
                                                              $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                            ?>
                                                             <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>

                                                             <?php
                                                             foreach ($arrySubCategory as $key => $value) { 
                                                                 $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']); 
                                                                 ?>
                                                              <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                              <?php
                                                             foreach ($arrySubCategory as $key => $value) { ?>
                                                              <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
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
                                                        <td align="right"   class="blackbold" >Product Name : </td>
                                                        <td height="30" align="left">
                                                            <? echo stripslashes($arryProduct[0]['Name']); ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="right"   class="blackbold">Product Sku : </td>
                                                        <td height="30" align="left">
                                                           <? echo stripslashes($arryProduct[0]['ProductSku']); ?>	</td>
                                                    </tr>

                                                    <tr>
                                                        <td  height="30" align="right"  class="blackbold" >Price :</td>
                                                        <td><? echo $Config['Currency']." ".number_format($arryProduct[0]['Price2'],2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td  height="30" align="right"  class="blackbold" >Sale Price :</td>
                                                        <td><? echo $Config['Currency']." ".number_format($arryProduct[0]['Price'],2); ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td  height="70" align="right" valign="top" class="blackbold"> Product Image : </td>
                                                        <td  height="50" align="left">

                                                            <?php
															$MainDir = $Prefix."upload/products/images/".$_SESSION['CmpID']."/"; 
                                                            if ($arryProduct[0]['Image'] != '' && file_exists($MainDir . $arryProduct[0]['Image'])) { ?>
                                                                            <a  data-fancybox-group="gallery" class="fancybox" href="<? echo $MainDir.$arryProduct[0][Image]; ?>"><? echo '<img src="resizeimage.php?w=100&h=100&img='.$MainDir . $arryProduct[0]['Image'] . '" border=0  >'; ?></a>	
																			 <? } else { ?>
																				<? echo '<img src="../../resizeimage.php?w=70&h=50&img=./images/no.jpg" border=0  >'; ?>
																			
																			<?php }?>
                                                                       
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"   class="blackbold">Status :  </td>
                                                        <td height="30" align="left"><span class="blacknormal">
                                                                <?
                                                              if ($arryProduct[0]['Status'] == 1) {
                                                                        $ActiveChecked = ' Active';
                                                              }
                                                            else {
                                                                $ActiveChecked="Inactive";
                                                            }
                                                                ?>
                                                                <?= $ActiveChecked ?>
                                                                </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($_GET['tab'] == "alterimages") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Alternative Images</td>
                                                    </tr>
                                                    <?php if(count($MaxProductImageArr) >0){?>
                                                          <tr>
                                                               <td colspan="2" class="list-Image">
                                                                  <ul>
                                                                      <?php
                                                                      $irts = 1;
                                                                      foreach($MaxProductImageArr as $image){
                                                                           $ImageName = $image['Image'];
                                                                            $ImageId = $image['Iid'];
                                                                            if ($ImageName != '' && file_exists('../../upload/products/images/secondary/' . $ImageName)) {
                                                                            $ImagePath = '../../resizeimage.php?img=upload/products/images/secondary/' . $ImageName . '&w=100&h=100';
                                                                            $showImage =  '<a data-fancybox-group="gallery" class="fancybox" href="../../upload/products/images/secondary/'.$ImageName.'"><img src="' . $ImagePath . '" border=0 align=left></a>';
                                                                        }
                                                                          ?>
                                                                      <li <?php if($irts%5 == "0"){?> class="last"<?php }?>><?=$showImage;?></li>
                                                                        <?$irts = $irts+1;}?>  
                                                                   </ul>
                                                               </td>
                                                               </tr>
                                                               <?php }else{?>
                                                                <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td class="no_record" colspan="5">No Images Found.</td>
                                                                       
                                                                     </tr>
                                                                     <?php }?>
                                                               
                                                      
                                                       
                                                    
                                                   
                                               
                                                <?php } ?>
                                                <? if ($_GET["tab"] == "other") { ?>

                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Other Properties </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" width="48%"  class="blackbold">Product Weight (lbs) :</td>
                                                        <td height="30" align="left" width="52%" class="blacknormal">
                                                            <? echo stripslashes($arryProduct[0]['Weight']); ?>
                                                        </td>
                                                    </tr> 

                                                    <tr>
                                                        <td align="right"    class="blackbold"> Featured : </td>
                                                        <td height="30" align="left">
                                                          <? if ($arryProduct[0]['Featured'] == 'Yes') {echo 'Yes';}else{echo "No";} ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td  align="right"   class="blackbold"> Product Manufacturer :  </td>
                                                        <td height="30" align="left">
                                                 
                                                                                <?= $ManufacturerName; ?>
                                                          
                                                        </td>
                                                    </tr>
                                                <tr>
                                                 <td  height="30" align="right"  class="blackbold" >Is this a taxable item? : </td>
                                               <td><? if ($arryProduct[0]['IsTaxable'] == 'Yes') echo 'Yes'; ?></td>
                                              </tr>
                                                 <tr>
                                                        <td align="right"    class="blackbold"> Select tax class : </td>
                                                        <td height="30" align="left" >
                                                            <? if ($arryProduct[0]['TaxClassId'] == '1') echo 'General'; ?>
                                                            
                                                        </td>
                                                    </tr>
                                                     <!--<tr>
                                                        <td align="right"    class="blackbold"> Tax rate at product level : </td>
                                                        <td height="30" align="left" >
                                                            <?//php if($arryProduct[0]['TaxRate'] != "-1.00000"){echo number_format($arryProduct[0]['TaxRate'],2);};?>
                                                        </td>
                                                    </tr>-->
                                                    
                                                 <tr>
                                                  <td  height="30" align="right"  class="blackbold" > Free shipping for this product? :  </td>
                                                 <td><? if ($arryProduct[0]['FreeShipping'] == 'Yes'){ echo 'Yes';} else {echo 'No';} ?></td>
                                               </tr>
                                               
                                                  <!--<tr>
                                                        <td align="right"    class="blackbold"> Shipping price for Product Level :  </td>
                                                        <td height="30" align="left" >
                                                           <//?=number_format($arryProduct[0]['ShippingPrice'],2);?>
                                                        </td>
                                                    </tr>-->
                                                  
                                                <?php } ?>
                                                <? if ($_GET["tab"] == "description") { ?>
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Product Description  </td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="right" valign="top"  width="30%"  class="blackbold"> Description :  </td>
                                                        <td align="left" valign="top" width="70%">
                                                          
															 <?=(!empty($arryProduct[0]['Detail']))?(stripslashes($arryProduct[0]['Detail'])):(NOT_SPECIFIED)?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td  align="right" valign="top"   class="blackbold">Short Description :  </td>
                                                        <td  align="left" valign="top">
                                                            <?=(!empty($arryProduct[0]['ShortDetail']))?(stripslashes($arryProduct[0]['ShortDetail'])):(NOT_SPECIFIED)?>
															</td>
                                                    </tr> 
                                                     <?php } ?>
                                                     <? if ($_GET["tab"] == "seo") { ?>

                                                    <tr>
                                                        <td colspan="2" align="left" class="head">Seo Properties </td>
                                                    </tr>
                                                        <tr>
                                                            <td align="right" width="48%" class="blackbold"> Meta Title : </td>
                                                            <td align="left" width="52%" class="blacknormal">
                                                               <? echo stripslashes($arryProduct[0]['MetaTitle']); ?>
                                                            </td>
                                                        </tr> 
                                                        <tr>
                                                          <td valign="top" align="right" class="blackbold"> Meta Keywords : </td>
                                                          <td valign="top" align="left">
                                                              <?=$arryProduct[0]['MetaKeyword'];?>
                                                          </td>
                                                      </tr>
                                                   <tr>
                                                   <td valign="top" align="right" class="blackbold"> Meta Description : </td>
                                                 <td valign="top" align="left">
                                                    <?=$arryProduct[0]['MetaDescription'];?>
                                                 </td>
                                                </tr>
                                                    <!-- <tr>
                                                            <td align="right"    class="blackbold"> Product Url (custom) :</td>
                                                            <td height="30" align="left"  class="blacknormal">
                                                           <?// echo stripslashes($arryProduct[0]['UrlCustom']); ?>
                                                            </td>
                                                        </tr>-->  
                                            
                                                   
                                                  
                                                <?php } ?>
                                                        <? if ($_GET["tab"] == "addattributes") { ?>
                                             
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">View Attributes</td>
                                                    </tr>
                                                           <tr>
                                                               <td colspan="2">
                                                                <table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="head1">Attribute Name</td>
                                                                        <td class="head1">Attribute Caption</td>
                                                                        <td class="head1">Priority</td>
                                                                        <td class="head1">Active</td>
                                                                         <td class="head1">Option</td>
                                                                  </tr>
                                                                  <?php  if(count($AttributesArr) > 0) {
                                                                      foreach($AttributesArr as $attribute) {   ?>
                                                                    <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td><?=$attribute['name'];?></td>
                                                                        <td><?=$attribute['caption'];?></td>
                                                                        <td><?=$attribute['priority'];?></td>
                                                                        <td><?=$attribute['is_active'];?></td>
                                                                        <td><?=$attribute['options'];?></td>
                                                                    </tr>
                                                                  <?php   
                                                                            }
                                                                      } else { 
                                                                      ?>
                                                                   <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td class="no_record" colspan="5">No Attributes Found.</td>
                                                                       
                                                                     </tr>
                                                                    <?php   }   ?>
		                    </tbody>
			</table> 
                                                            </td>
                                                           </tr>
                                                           
                                              
                                                <?php } ?>
                                                 
                                                     <? if ($_GET["tab"] == "discount") { ?>
                                             
                                                    <tr>
                                                        <td colspan="2" align="left" class="head">View Discounts</td>
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
                                                                         <td class="head1">Customer Type</td>
                                                                         <td class="head1">Active</td>
                                                                  </tr>
                                                                  <?php  if(count($DiscountArr) > 0) {
                                                                      foreach($DiscountArr as $discount) {   ?>
                                                                    <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td><?=$discount['range_min'];?></td>
                                                                        <td><?=$discount['range_max'];?></td>
                                                                        <td><?=number_format($discount['discount'],2);?></td>
                                                                        <td><?=$discount['discount_type'];?></td>
                                                                        <td><?=$discount['customer_type'];?></td>
                                                                        <td><?=$discount['is_active'];?></td>
                                                                    </tr>
                                                                  <?php   
                                                                            }
                                                                      } else { 
                                                                      ?>
                                                                   <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td class="no_record" colspan="6">No Discount Found.</td>
                                                                       
                                                                     </tr>
                                                                    <?php   }   ?>
		                    </tbody>
			</table> 
                                                            </td>
                                                           </tr>
                                                        
                                                       
                                              
                                                <?php } ?>
                                              
                                                   <?php if ($_GET["tab"] == "inventory") { ?>
                                                    <tr>
                                                                <td colspan="2" align="left" class="head">Inventory Control </td>
                                                           </tr>
                                                           
                                                            <tr>
                                                               <td  colspan="2" > 
                                                                
                                                              <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                                <tr>
                                                                    <td align="right" width="48%"  class="blackbold">Inventory enable :</td>
                                                                    <td height="30" align="left" width="52%" class="blacknormal">
                                                                        <?php  
                                                                      if($arryProduct[0]['InventoryControl'] == "Yes") {echo "Yes";}else{echo "No";} ?>
                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                               <td  colspan="2"  style="display:<?php if($arryProduct[0]['InventoryControl'] == "Yes"){?>table-cell<?php } else {?>none<?php }?>;" id="showInventoryControl"> 
                                                                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                                             <tr>
                                                                <td  height="30" width="48%"  class="blackbold" align="right">  If product is out of stock :</td>
                                                                <td width="52%">
                                                                    <?php if($arryProduct[0]['InventoryRule'] == "OutOfStock") {echo "Show Out of Stock message";}else{echo "Do not display";}?>
                                                                      
                                                                </td>
                                                            </tr> 
                                                                <tr>
                                                                    <td  height="30" align="right"  class="blackbold" > Number of items in inventory : </td>
                                                                    <td><? echo stripslashes($arryProduct[0]['Quantity']); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td  height="30"  class="blackbold" align="right">Notify me when inventory is equal to or less than :  </td>
                                                                <td>
                                                                       <? echo stripslashes($arryProduct[0]['StockWarning']); ?>
                                                                </td>
                                                            </tr>  
                                                             </table>
                                                            </td> 
                                                          </tr>
                                                 </table>
                                                   </td>
                                                  </tr>
                                                  
                                                  <?php }?>
                                                </table>
                                            </td>
                                        </tr>
                                   

                                </form>
                            </table></td>
                    </tr>
                </table></td>
        </tr>
    </table>
</div>
