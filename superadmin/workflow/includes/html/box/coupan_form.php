<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For element_form.php
 */
//print_r($arryElement);
//echo stripslashes($arryElement->element_slug);
?>

<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action=""  method="post" onSubmit="return validateElement(this);" enctype="multipart/form-data">
        <tr>
            <td  align="center" valign="top" >

                <table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">Coupan Details</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> Coupan Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <?php echo $FormHelper->input(__('coupan_name'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'Coupan_name', 'maxlength' => 50, 'value' => stripslashes($arryElement->name)));
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Voucher Type :<span class="red">*</span> </td>
                        <td   align="left" >
				<?php
                            $typehecked = 'selected';
                            if ($_REQUEST['edit'] > 0) {
                                if ($arryElement->voucher_type == 'Percentage') {
                                    $typehecked = 'selected';
                                    
                                }
                                if ($arryElement->voucher_type == 'Price') {
                                    $typehecked = 'selected';
                                    
                                }
                            }
                            ?>
                            <?php echo $FormHelper->input(__('btype'), array('type' => 'select', 'options'=>array('Percentage'=>'Percentage','Price'=>'Price'),'selected'=>$arryElement->voucher_type, 'class' => 'inputbox', 'id' => 'btype', 'maxlength' => 50,  'value' => stripslashes($arryElement->voucher_type))); ?>

                        </td>
                    </tr>
                    
                     <tr>
                        <td  align="right"   class="blackbold"> Coupan Qunatity  :<span class="red">*</span> </td>
                        <td   align="left" >
			<?php echo $FormHelper->input(__('coupan_quantity'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'coupan_quantity', 'maxlength' => 50, 'value' => stripslashes($arryElement->coupan_quantity))); ?>
                            
                        </td>
                    </tr>
<tr>
                        <td  align="right"   class="blackbold"> Customer Voucher Use :<span class="red">*</span> </td>
                        <td   align="left" >
				<?php
                            $typehecked = 'selected';
                            if ($_REQUEST['edit'] > 0) {
                                if ($arryElement->customer_voucher_use == 'onetime') {
                                    $typehecked = 'selected';
                                    
                                }
                                if ($arryElement->customer_voucher_use == 'mulitpletime') {
                                    $typehecked = 'selected';
                                    
                                }
                            }
                            ?>
                            <?php echo $FormHelper->input(__('vouchertime'), array('type' => 'select', 'options'=>array('ontime'=>'Ontime','multipletime'=>'Multipletime'),'selected'=>$arryElement->voucher_type, 'class' => 'inputbox', 'id' => 'vouchertime', 'maxlength' => 50,  'value' => stripslashes($arryElement->voucher_type))); ?>

                        </td>
                    </tr>
 <tr>
                        <td  align="right"   class="blackbold"> Discount Amount  :<span class="red">*</span> </td>
                        <td   align="left" >
			<?php echo $FormHelper->input(__('discount_amount'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'discount_amount', 'maxlength' => 50, 'value' => stripslashes($arryElement->discount))); ?>
                            
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Expire Date :<span class="red">*</span></td>
                        <td  align="left" >
                            <?php echo $FormHelper->input(__('expire_date'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'datepicker', 'maxlength' => 50, 'value' => stripslashes($arryElement->expire_date))); ?>
                        </td>
                    </tr>	

                    <tr>
                        <td  align="right"   class="blackbold" 
                             >Status  : </td>
                        <td   align="left"  >
                            <?php
                            $ActiveChecked = ' checked';
                            if ($_REQUEST['edit'] > 0) {
                                if ($arryElement->status == 'Active') {
                                    $ActiveChecked = ' checked';
                                    $InActiveChecked = '';
                                }
                                if ($arryElement->status == 'Inactive') {
                                    $ActiveChecked = '';
                                    $InActiveChecked = ' checked';
                                }
                            }
                            ?>
                            <label><input type="radio" name="status" id="status" value="Active" <?= $ActiveChecked ?> />
                                Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="status" id="status" value="Inactive" <?= $InActiveChecked ?> />
                                InActive</label> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">&nbsp;
            </td>
        </tr>
        <tr>
            <td  align="center">

                <div id="SubmitDiv" style="display:none1">

                    <?php if ($_GET['edit'] > 0)
                        $ButtonTitle = 'Update ';
                    else
                        $ButtonTitle = ' Submit ';
                    ?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="element_id" id="element_id" value="<?= $_GET['edit'] ?>" />
                </div>

            </td>
        </tr>
    </form>
</table>
<script type="text/javascript">
$(document).ready(function(){
		$('#SubmitButton').on('click',function(){
			if($('#Coupan_name').val()==""){
				alert("Coupan name is required");
				$('#Coupan_name').css('border','1px solid #ff0000');
				return false;
			} else {
				$('#Coupan_name').css('border','1px solid #dae1e8');
				
				}
			
			if($('#btype').val()==""){
				alert("Voucher type is required");
				$('#btype').css('border','1px solid #ff0000');
				return false;
			}
		
			if($('#coupan_quantity').val()==""){
				
				alert("Coupan quantity  is required");
				$('#coupan_quantity').css('border','1px solid #ff0000');
				return false;
			} 
			else{	
					var quantity= $('#coupan_quantity').val();
					if($.isNumeric(quantity)){
					//alert($.isNumeric(quantity));
					$('#coupan_quantity').css('border','1px solid #dae1e8');
					
					}else{
					alert('Please enter number');
					return false;
					}
					$('#coupan_quantity').css('border','1px solid #dae1e8');

				
				
				
			}
			
			if($('#discount_amount').val()==""){
				alert("Discount amount  is required");
				$('#discount_amount').css('border','1px solid #ff0000');
				return false;
			} else {
				var discounta= $('#discount_amount').val();
					if($.isNumeric(discounta)){
					//alert($.isNumeric(quantity));
					$('#discount_amount').css('border','1px solid #dae1e8');
					
					}else{
					alert('Please enter number');
					return false;
					}
					
				$('#discount_amount').css('border','1px solid #dae1e8');
			}
			if($('#datepicker').val()==""){
				alert("Expire date is required");
				$('#datepicker').css('border','1px solid #ff0000');
				return false;
			}else {$('#datepicker').css('border','1px solid #dae1e8');}
		
		});
		return true;
});
</script>

