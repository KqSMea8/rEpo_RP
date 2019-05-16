<div class="had"> <?= $ModuleTitle; ?> <a href="<?= $ListUrl ?>" class="back">Back</a></div>
<form name="form1" action="" method="post"  enctype="multipart/form-data" id="PromoCodeForm" onsubmit="return CheckPromoForm(this);">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr><td><?php 
if(!isset($arrayCoupon[0]['PromoType'])) $arrayCoupon[0]['PromoType']='';
if(!isset($_GET['promotype'])) $_GET['promotype']='';

if($arrayCoupon[0]['PromoType'] == "Product" && empty($_GET['promotype'])){ ?><a href="editCoupon.php?promoID=<?=$_GET['promoID']?>&promotype=product" class="edit">Edit Product</a><?php }?></td></tr>
                    <tr>
                        <td align="center" valign="middle">
                           <?php if(!empty($_GET['promoID']) && $_GET['promotype'] == "product"){?>
                           
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr valign="top">
						<td class="formItemCaption required">Categories:</td>
						<td class="formItemControl">                                                   
							<select name="promo_categories[]" multiple class="select multiselect"  id="select_products2">
								 <?php 
                                                                   $objCategory->getPromoCategories(0,0,$_GET['ParentID'],$_GET['promoID']);
                                                                  ?>
							</select>
						</td>
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
							Current products included in the promotion: <br/>
							<select name="select_products[]"  class="select multiselect" multiple id="select_products">
							<?php
								$result = mysql_query("
									SELECT  p.ProductID, p.ProductSku, p.Name 
									FROM e_promo_products pp
									INNER JOIN e_products p ON p.ProductID = pp.ProductID
									WHERE pp.promoID='".$_GET['promoID']."'
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
				</table>
                            <?php } else { ?>
                             <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Campaign Name :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?=$arrayCoupon[0]['Name']?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
                                          
                                         
                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                   Coupon Code :<span class="red">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <?php if(!empty($_GET['promoID'])) {?>
                                                    <input type="text" name="PromoCode"  value="<?=$arrayCoupon[0]['PromoCode']?>" disabled style="background-color: gainsboro;" class="inputboxSmall">
                                                    <?php } else{ ?>
                                                    <input type="text" name="PromoCode" id="PromoCode" value="" class="inputboxSmall">
                                                    <a href="#" onclick="return makeid();">Click To Generate</a>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                                       
                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> Active :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="Active" id="Active" class="inputboxSmall" >
                                                        <option value="Yes" <?php if($arrayCoupon[0]['Active'] == "Yes"){echo "selected";}?>>Yes</option>
                                                        <option value="No" <?php if($arrayCoupon[0]['Active'] == "No"){echo "selected";}?>>No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Type of promotion</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="PromoType" id="PromoType" class="inputboxSmall" >
                                                        <option value="Global" <?php if($arrayCoupon[0]['PromoType'] == "Global"){echo "selected";}?>>Global</option>
                                                        <option value="Product" <?php if($arrayCoupon[0]['PromoType'] == "Product"){echo "selected";}?>>Product</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td width="30%" align="right" valign="top" class="blackbold">Customer Groups :<span class="red">*</span></td>
                                            <td class="value" align="left">
                                            <select multiple="multiple" class="select multiselect" size="10"  name="CustomerGroupID[]" id="CustomerGroupID">
                                                <option value="0" <?php if(in_array(0,$arrayCustGroupID)){echo "selected";}?>>Guest</option>
                                            <?php foreach($arryCustomerGroups as $group){?>
                                              <option value="<?=$group['GroupID']?>" <?php if(in_array($group['GroupID'],$arrayCustGroupID)){echo "selected";}?>><?=$group['GroupName']?></option>
                                             <?php }?>
                                            </select> 
                                            </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Start Date :<span class="red">*</span></td>
                                                <td width="56%"  align="left" valign="top"><input type="text" name="DateStart" id="DateStart" value="<?=$arrayCoupon[0]['DateStart']?>" class="datebox"></td>
                                            </tr>
                                            <tr>
                                                <td align="right" class="blackbold"> End Date :<span class="red">*</span>  </td>
                                                <td align="left" class="blacknormal"><input type="text" name="DateStop" id="DateStop" value="<?=$arrayCoupon[0]['DateStop']?>" class="datebox"></td>
                                            </tr>     
                                              <tr>
                                                <td align="right"  class="blackbold"> Discount :<span class="red">*</span>  </td>
                                                <td align="left" class="blacknormal">
                                                    <input type="text" name="Discount" id="Discount" onkeyup="keyup(this);" value="<?=$arrayCoupon[0]['Discount']?>" class="inputboxSmall" style="width: 51px;">
                                                    <select class="inputboxSmall" style="width: 85px;" name="DiscountType">
                                                        <option value="amount" <?php if($arrayCoupon[0]['DiscountType'] == "amount"){echo "selected";}?>>amount</option>
							<option value="percent" <?php if($arrayCoupon[0]['DiscountType'] == "percent"){echo "selected";}?>>%</option>
						  </select>
                                                </td>
                                            </tr>  
                                             <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Uses Per Coupon:</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input type="text" name="UsesTotal" id="UsesTotal" onkeyup="keyup(this);" value="<?=$arrayCoupon[0]['UsesTotal']?>"  class="inputboxSmall">
                                                     <br>(The maximum number of times the coupon can be used by any customer. Leave blank for unlimited.)
                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Uses Per Customer:</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input type="text" name="UsesCustomer" id="UsesCustomer" onkeyup="keyup(this);" value="<?=$arrayCoupon[0]['UsesCustomer']?>"  class="inputboxSmall">
                                                     <br>(The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited.)
                                                </td>
                                            </tr>
                                             <tr>
                                                <td align="right" valign="top"  class="blackbold"> Order Subtotal:  </td>
                                                <td align="left" class="blacknormal"><input type="text" name="MinAmount" value="<?=$arrayCoupon[0]['MinAmount']?>" class="inputboxSmall">
                                                    <br>(The total amount that must reached before the coupon is valid.)
                                                </td>
                                            </tr>   
                                        </table>  
                                    </td>
                                </tr>
                            </table>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['promoID'] > 0) {
                                $ButtonTitle = 'Update';
                                $type = "submit";
                            } else {
                                $ButtonTitle = 'Submit';
                                $type = "button";
                            } ?>
                         
                             <input name="promoID" type="hidden" value="<?= $_GET['promoID'] ?>" />
                             <?php if(!empty($_GET['promotype'])){?>
                             <input name="actionPromo" type="hidden" value="product" />
                             <?php }?>
                             
                            <input name="Submit" type="<?=$type?>" class="button" id="SaveCoupon" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
</table>
</form>

<script type="text/javascript">
$(function() {
       $('#DateStart').datepicker(
               {
               showOn: "both",
               dateFormat: 'yy-mm-dd',
               yearRange: '<?=date("Y")?>:<?=date("Y")+20?>',
               minDate: "-D",
               changeMonth: true,
               changeYear: true
               }
       );
       
       $('#DateStop').datepicker(
               {
               showOn: "both",
               dateFormat: 'yy-mm-dd',
               yearRange: '<?=date("Y")?>:<?=date("Y")+20?>',
               minDate: "+1D",
               changeMonth: true,
               changeYear: true
               }
       );
});
</script>
