<?php
/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * Description: For user_form.php
 */
//print_r($arryUser); die('');
?>

<table width="97%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post" onSubmit="" enctype="multipart/form-data">
	<tr>
		<td align="center" valign="top">


		<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                            <td colspan="2" align="left" class="head">User Details</td>
                    </tr>
                     <tr>
                            <td align="right" class="blackbold">CompanyName :<span class="red">*</span></td>
                            <td align="left"><?php echo $FormHelper->input(__('companyName'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'companyName', 'maxlength' => 50, 'value' => stripslashes($arryUser->CompanyName)));
                            ?></td>
                    </tr>
                    <tr>
                            <td align="right" class="blackbold">DisplayName :<span class="red">*</span></td>
                            <td align="left"><?php echo $FormHelper->input(__('displayName'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'displayName', 'maxlength' => 50, 'value' => stripslashes($arryUser->DisplayName)));
                            ?></td>
                    </tr>
                    <tr>
                            <td align="right" class="blackbold">FirstName :<span class="red">*</span></td>
                            <td align="left"><?php 
				//$namenew=stripslashes($arryUser->ContactPerson);
				//echo $arryUser->ContactPerson;
				//echo $namenew;
			//$name= implode('',$namenew);
			//print_r($name); die('Suneel');
		 echo $FormHelper->input(__('userFname'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userFname', 'maxlength' => 50, 'value' => stripslashes($arryUser->userFname)));
                            ?></td>
                    </tr>

                    <tr>
                            <td align="right" class="blackbold">LastName :<span class="red">*</span></td>
                            <td align="left"><?php echo $FormHelper->input(__('userLname'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userLname', 'maxlength' => 50, 'value' => stripslashes($arryUser->userLname)));
                            ?></td>
                    </tr>

                    <tr>
                            <td align="right" class="blackbold">ContactNo :<span class="red">*</span></td>
                            <td align="left"><?php echo $FormHelper->input(__('userContacts'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userContacts', 'maxlength' => 50, 'value' => stripslashes($arryUser->Mobile)));
                            ?></td>
                    </tr>


                    <tr>
                            <td align="right" class="blackbold" valign="top">Address :<span
                                    class="red">*</span></td>
                            <td align="left"><?php echo $FormHelper->input(__('userAddress'), array('type' => 'textarea', 'class' => '', 'id' => 'userAddress', 'maxlength' => 50, 'value' => stripslashes($arryUser->Address)));
                            ?></td>


                    <tr>
                            <td align="right" class="blackbold">Package :<span class="red">*</span></td>
                            <td align="left"><?php echo $FormHelper->input(__('userPackageId'), array('type' => 'select', 'class' => 'inputbox', 'id' => 'userPackageId', 'maxlength' => 50, 'selected'=>$arryUser->userPackageId,'options' => $package));
                            ?></td>
                    </tr>
                    <!-------------------------------Amit Singh------------------------------------->
                    <tr>
                        <td align="right" class="blackbold">Ecom Type : <span class="red">*</span></td>
                        <td align="left">
                            
                            <?php echo $FormHelper->input(__('allow_user'), array('type' => 'select', 'options'=>array('leisure'=>'Leisure','health'=>'Health','generalmerchandise'=>'General Merchandise','footwear'=>'Footwear', 'clothing'=>'Clothing/ Apparel', 'specialty'=>'Specialty', 'electronics'=>'Electronics', 'software'=>'Software', 'sporting'=>'Sporting Goods', 'homegoods'=>'Home Goods', 'transportation'=>'Transportation', 'telecommunication'=>'Telecommunication', 'books'=>'Books','restaurants'=>'Restaurants', 'other'=>'Other'), 'class' => 'inputbox', 'id' => 'allow_user', 'maxlength' => 50, 'selected'=>$arryUser->ecomType));?>
                        </td>
                    </tr>
                    <!-------------------------------------------------------------------->
                    <tr>
                            <td colspan="2" align="left" class="head">Account Details</td>
                    </tr>

<!--			<tr>
                            <td align="right" class="blackbold">User Name :<span class="red">*</span>
                            </td>
                            <td align="left"><?php //echo $FormHelper->input(__('userDispalyname'), array('type' => 'inputbox', 'class' => 'inputbox', 'id' => 'userDispalyname', 'maxlength' => 50, 'value' => stripslashes($arryUser->userDispalyname)));
                            ?></td>
                    </tr>-->
                    <?php if(!empty( $_GET['edit'])) {?>

                        <tr>
                                <td align="right" class="blackbold" width="35%">User Name :</td>
                                <td align="left"><level><?php echo stripslashes($arryUser->userEmail);?></label></td>
                        </tr>

                    <?php }else {?>

                        <tr>
                            <td align="right" class="blackbold" width="35%">Login Email :<span class="red">*</span>
                            </td>
                            <td align="left">
                                <?php echo $FormHelper->input(__('userEmail'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userEmail', 'maxlength' => 50, 'value' => stripslashes($arryUser->userEmail)));?>
                            </td>
			</tr>

			<tr>
                            <td align="right" class="blackbold">Password :<span class="red">*</span>
                            </td>
                            <td align="left">
                                <?php echo $FormHelper->input(__('userPwd'), array('type' => 'password', 'class' => 'inputbox', 'id' => 'userPwd', 'maxlength' => 50, 'value' => stripslashes($arryUser->userPwd)));?>
                            </td>
			</tr>

<?php }?>

			<tr>
				<td align="right" class="blackbold">Status :</td>
				<td align="left"><? 
				$ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryUser->Status == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryUser->Status == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			 }
		  ?> 
		  <label><input type="radio" name="status" id="status" value="1"
		  <?=$ActiveChecked?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp; 
		  <label><input type="radio" name="status" id="status" value="0" <?=$InActiveChecked?> /> InActive</label></td>
			</tr>

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
			id="userID" value="<?=$_GET['edit']?>" /> </div>

		</td>
	</tr>
	</form>
</table>
