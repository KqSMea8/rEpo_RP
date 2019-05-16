<?php      
                     
                    // get setting
                      $payment_mode=0;
                       $allow_shop=0;
                       $allow_annotation=0;
                   foreach($settingData as $rows){                
                       if($rows['optionKey']=='PAYMENT_MODE_ON_LINE')
                       {
                           $payment_mode = $rows['optionValue'];
                       }
                       if($rows['optionKey']=='ALLOW_SHOPPING')
                       {
                           $allow_shop = $rows['optionValue'];
                           
                       }
                       if($rows['optionKey']=='ALLOW_ANNOTATION')
                       {
                           $allow_annotation = $rows['optionValue'];
                       }
                  if($rows['optionKey']=='ALLOWED_STORE')
                       {
                           $allow_store = $rows['optionValue'];
                       }
                   } ?>


<table width="97%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post"  enctype="multipart/form-data">
	<tr>
		<td align="center" valign="top">


		<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    
                   
                    <tr>
                            <td colspan="2" align="left" class="head">Setting</td>
                    </tr>
                 <tr>
                            <td align="right" class="blackbold" width="35%">Allow Shopping  :
                            </td>
                            <td align="left">
                               <input type="checkbox" id = 'onLinePayment' value="1" name="allowedShopping" <?php if($allow_shop == 1){?> checked="checked" <?php } ?> >
                            </td>
			</tr>
		 <tr>
                            <td align="right" class="blackbold" width="35%">Allow Annotation   :
                            </td>
                            <td align="left">
                               <input type="checkbox" id = 'onLinePayment' value="1" name="allowedAnnotation" 
<?php if($allow_annotation == 1){?> checked="checked" <?php } ?> >
                            </td>
			</tr>
 <tr>
                            <td align="right" class="blackbold" width="35%">Online Payment Mode  :
                            </td>
                            <td align="left">
                               <input type="checkbox" id = 'onLinePayment' value="1" name="paymentMode" <?php if($payment_mode == 1){?> checked="checked" <?php } ?>  > 
                            </td>
			</tr>
<?php if(empty($arryUser->recordInsertedBy)) {?>
<tr>
                        <td align="right" class="blackbold">Allow License:<span class="red">*</span></td>
                        <td align="left"><div class="input text"><input style="width: 50px;" type="text" name="allowLicense"  maxlength="50" value="<?php echo $allow_store ?>" class="inputbox"></td>
                    </tr>
<?php } else{?>

<input style="width: 50px;" type="hidden" name="allowLicense"  maxlength="50" value="<?php echo $allow_store ?>" class="inputbox">
<?php }?>
		</table>

		</td>
	</tr>

	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>

	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
		<input name="Submit" type="submit" class="button" id="SubmitButton"value=" <?=$ButtonTitle?> " /> <input type="hidden" name="userID"
			id="userID" value="<?=$_REQUEST['edit']?>" /> </div>

		</td>
	</tr>
	</form>
</table>





