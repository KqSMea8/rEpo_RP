<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script
	type="text/javascript" src="../../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<style>
.error-message {
	color: red;
	padding: 5px;
}
.input.text.time {
    
    margin-left: 200px;
    margin-top: -26px;
    
}
.input.text.allowedSpace {
    
    margin-left: 200px;
    margin-top: -26px;
    
}
</style>
<table width="97%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post" onSubmit=""	enctype="multipart/form-data">
	<tr>
		<td align="center" valign="top">

		<table width="80%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="2" align="left" class="head">Package Details Form</td>
			</tr>

	<?php $package =array(""=>"Select Package", "STORAGE"=>"Normal", "DOCUMENT"=>"Advance"); ?>		
<tr>
                            <td align="right" class="blackbold">Select Plan Type:<span class="red">*</span></td>
                            <td align="left"><?php 

 $plan_type = (!empty($arryPackage->plan_type))?($arryPackage->plan_type):('');
echo $FormHelper->input(__('planType'), array('type' => 'select',  'class' => 'upload-type inputbox', 'id' => 'planType', 'maxlength' => 50, 'selected'=>$plan_type,'options'=>$package));
                            ?></td>
                    </tr>
                 <tr class="name">
				<td align="right" class="blackbold">Package Name :<span class="red">*</span>
				</td>
				<td align="left"><?php 
 $package_name = (!empty($arryPackage->name))?($arryPackage->name):('');
echo $FormHelper->input(__('name'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'name', 'maxlength' => 50, 'value' => stripslashes($package_name)));
				?></td>
			</tr>

			<tr class="allowedDoc">
				<td align="right" class="blackbold ">Allowed Doc :</td>
				<td align="left"><?php 

 $allowedDoc = (!empty($arryPackage->allowedDoc))?($arryPackage->allowedDoc):('');

echo $FormHelper->input(__('allowedDoc'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'allowedDoc', 'maxlength' => 50, 'value' => stripslashes($allowedDoc))); ?>
				</td>
			</tr>

			<tr class="overageCostPerDoc">
				<td align="right" class="blackbold">Overage Cost Per Doc :
				</td>
				<td align="left"><?php 
 $overageCostPerDoc = (!empty($arryPackage->overageCostPerDoc))?($arryPackage->overageCostPerDoc):('');
echo $FormHelper->input(__('overageCostPerDoc'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'overageCostPerDoc', 'maxlength' => 5, 'value' => stripslashes($overageCostPerDoc))); ?>
				</td>
			</tr>
			<tr class="allowedPage">
				<td align="right" class="blackbold">Allowed Page :
				</td>
				<td align="left"><?php
 $allowedPage = (!empty($arryPackage->allowedPage))?($arryPackage->allowedPage):('');
 echo $FormHelper->input(__('allowedPage'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'allowedPage', 'maxlength' => 50, 'value' => stripslashes($allowedPage))); ?>
				</td>
			</tr>
			<tr class="overageCostPerPage">
				<td align="right" class="blackbold ">Overage Cost Per Page :
				</td>
				<td align="left"><?php 
 $overageCostPerPage = (!empty($arryPackage->overageCostPerPage))?($arryPackage->overageCostPerPage):('');
echo $FormHelper->input(__('overageCostPerPage'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'overageCostPerPage', 'maxlength' => 5, 'value' => stripslashes($overageCostPerPage))); ?>
				</td>
			</tr>
			<tr class="allowedVideo">
				<td align="right" class="blackbold">Allowed Video :<span class="red">*</span>
				</td>
				<td align="left"><?php 
 $allowedVideo = (!empty($arryPackage->allowedVideo))?($arryPackage->allowedVideo):('');
 echo $FormHelper->input(__('allowedVideo'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'allowedVideo', 'maxlength' => 5, 'value' => stripslashes($allowedVideo))); ?>
				</td>
			</tr>
			<tr class="overageCostPerVideo">
				<td align="right" class="blackbold">Overage Cost Per Video :
				</td>
				<td align="left"><?php 
 $overageCostPerVideo = (!empty($arryPackage->overageCostPerVideo))?($arryPackage->overageCostPerVideo):('');
echo $FormHelper->input(__('overageCostPerVideo'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'overageCostPerVideo', 'maxlength' => 5, 'value' => stripslashes($overageCostPerVideo))); ?>
				</td>
			</tr>
			<tr class="allowMaxvideoSize">
				<td align="right" class="blackbold">Allowed Video Size (in MB) :
				</td>
				<td align="left"><?php 
$allowMaxvideoSize = (!empty($arryPackage->allowMaxvideoSize))?($arryPackage->allowMaxvideoSize):('');
echo $FormHelper->input(__('allowMaxvideoSize'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'allowMaxvideoSize', 'maxlength' => 5, 'value' => stripslashes($allowMaxvideoSize))); ?>
				</td>
			</tr>
			<tr class="overageCostVideoSize" >
				<td align="right" class="blackbold">Overage Cost Per Video Size :
				</td>
				<td align="left"><?php
$overageCostVideoSize = (!empty($arryPackage->overageCostVideoSize))?($arryPackage->overageCostVideoSize):('');
 echo $FormHelper->input(__('overageCostVideoSize'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'overageCostVideoSize', 'maxlength' => 5, 'value' => stripslashes($overageCostVideoSize))); ?>
				</td>
			</tr>
			<tr class="allowUser">
				<td align="right" class="blackbold">Allowed User :
				</td>
				<td align="left"><?php 
$allowUser = (!empty($arryPackage->allowUser))?($arryPackage->allowUser):('');
echo $FormHelper->input(__('allowUser'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'allowUser', 'maxlength' => 5, 'value' => stripslashes($allowUser))); ?>
				</td>
			</tr>
			<tr  class="overageCostPerUser" >
				<td align="right" class="blackbold">Overage Cost Per User :
				</td>
				<td align="left"><?php 
$overageCostPerUser = (!empty($arryPackage->overageCostPerUser))?($arryPackage->overageCostPerUser):('');
echo $FormHelper->input(__('overageCostPerUser'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'overageCostPerUser', 'maxlength' => 5, 'value' => stripslashes($overageCostPerUser))); ?>
				</td>
			</tr>
			<tr class="amount" >
				<td align="right" class="blackbold ">Amount :<span
					class="red">*</span></td>
				<td align="left"><?php 
$amount = (!empty($arryPackage->amount))?($arryPackage->amount):('');
echo $FormHelper->input(__('amount'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'amount', 'maxlength' => 5, 'value' => stripslashes($amount))); ?>
				</td>
			</tr>
			<tr class="timePeriod">


				<td align="right" class="blackbold  ">Time Period (in days) :<span
					class="red">*</span></td>

<?php $periodTypeOpt =array("day"=>"Day", "month"=>"Month", "year"=>"Year"); ?>		
                           
                            <td align="left"><?php 
$periodType = (!empty($arryPackage->periodType))?($arryPackage->periodType):('');
$timePeriod = (!empty($arryPackage->timePeriod))?($arryPackage->timePeriod):('');
echo $FormHelper->input(__('periodType'), array('type' => 'select',  'class' => 'inputbox', 'id' => 'periodType', 'maxlength' => 50, 'selected'=>$periodType,'options'=>$periodTypeOpt));?>
                    <?php echo $FormHelper->input(__('timePeriod'), array('type' => 'text time', 'class' => 'inputbox', 'id' => 'timePeriod', 'maxlength' => 5, 'value' => stripslashes($timePeriod))); ?>
				</td></tr>
<tr  class="alloweLicense">
<td align="right" class="blackbold ">Allowed License :</td>
				<td align="left"><?php 
$alloweLicense = (!empty($arryPackage->alloweLicense))?($arryPackage->alloweLicense):('');
echo $FormHelper->input(__('allowedStore'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'allowedStore', 'maxlength' => 5, 'value' => stripslashes($alloweLicense))); ?>
				</td>
</tr>
	
<tr class="allowedStore">
<td align="right" class="blackbold">Allowed Storage:</td>
<?php $storageTypeOpt =array("MB"=>"MB", "GB"=>"GB", "TB"=>"TB"); ?>
<td align="left"><?php
$storageType = (!empty($arryPackage->storageType))?($arryPackage->storageType):('');
 echo $FormHelper->input(__('storageType'), array('type' => 'select',  'class' => 'inputbox', 'id' => 'storageType', 'maxlength' => 50, 'selected'=>$storageType,'options'=>$storageTypeOpt));?>

<?php
$allowedStorage = (!empty($arryPackage->allowedStorage))?($arryPackage->allowedStorage):('');
 if($storageType=='MB'){
           
            $allowedStorage=round($allowedStorage * 1024);
        }
        elseif ($storageType=='TB') {
            $allowedStorage=round($allowedStorage / 1024);    
    }?>


				<?php 

echo $FormHelper->input(__('allowedSpace'), array('type' => 'text allowedSpace', 'class' => 'inputbox', 'id' => 'allowedSpace', 'maxlength' => 5, 'value' => stripslashes($allowedStorage))); ?>
				</td></tr>
			

				<tr class="statusradio">
					<td align="right" class="blackbold">Status :</td>
					<td align="left"><?php
					$ActiveChecked = ' checked';
					$InActiveChecked = '';
					if ($_GET['edit'] > 0) {
						if ($arryPackage->status == 1) {
							$ActiveChecked = ' checked';
							$InActiveChecked = '';
						}
						if ($arryPackage->status == 0) {
							$ActiveChecked = '';
							$InActiveChecked = ' checked';
						}
					}
					?> <label><input type="radio" name="status" id="status" value="1"
					<?= $ActiveChecked ?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp; <label><input
						type="radio" name="status" id="status" value="0"
						<?= $InActiveChecked ?> /> InActive</label></td>
				</tr>
		
		</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><?php
		if ($_GET['edit'] > 0)
		$ButtonTitle = 'Update ';
		else
		$ButtonTitle = ' Submit ';
		?> <input name="Submit" type="submit" class="button" id="SubmitButton"
			value=" <?= $ButtonTitle ?> " /> <input type="hidden" name="pckg_id"
			id="pckg_id" value="<?= $_GET['edit'] ?>" /></div>

		</td>
	</tr>
	</form>
</table>
<script>

$( document ).ready(function() {
   if($('.upload-type').val()==''){
                                        $('.name').hide();
                                        $('.allowedDoc').hide();
                                        $('.overageCostPerDoc').hide();
                                        $('.allowedPage ').hide();
                                        $('.overageCostPerPage').hide();
                                        $('.allowedVideo').hide();
                                        $('.overageCostPerVideo').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.overageCostPerUser').hide();
                                        $('.allowUser').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.amount').hide();
                                        $('.allowedStore').hide();
                                        $('.amount').hide();
                                        $('.timePeriod').hide();
                                        $('.statusradio').hide();
                                        $('.overageCostVideoSize').hide();
                                        $('.alloweLicense').hide();
       
            }
                                       if($('.upload-type').val()=='STORAGE'){					                                       
                                        $('.allowedDoc').hide();
                                        $('.overageCostPerDoc').hide();
                                        $('.allowedPage ').hide();
                                        $('.overageCostPerPage').hide();
                                        $('.allowedVideo').hide();
                                        $('.overageCostPerVideo').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.overageCostPerUser').hide();
                                        $('.allowUser').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.overageCostVideoSize').hide();
                                        $('.allowedStore').show();
                                        $('.timePeriod').show();
                                        $('.statusradio').show();
                                        $('.alloweLicense').show();
                                        $('.amount').show();
                                        $('.name').show();
                                       
                                        
				}else if($('.upload-type').val()=='DOCUMENT'){					

                                       $('.allowedStore').hide();
                                       $('.alloweLicense').show();
                                        $('.allowdoc').show();
                                        $('.overageCost').show();
                                        $('.allowedPage ').show();
                                        $('.overageCostPerPage').show();
                                        $('.allowedVideo').show();
                                        $('.overageCostPerVideo').show();
                                        $('.allowMaxvideoSize').show();
                                        $('.overageCostPerUser').show();
                                        $('.allowUser').show();
                                        $('.allowMaxvideoSize').show();
                                        $('.overageCostVideoSize').show();
                                        $('.statusradio').show();
                                        $('.amount').show();
                                        $('.timePeriod').show();
                                         $('.name').show();
                                       
                                        
                                        
					}
       
    
   	$('.upload-type').change(function(){
            if($(this).val()==''){
                                        $('.name').hide();
                                        $('.allowedDoc').hide();
                                        $('.overageCostPerDoc').hide();
                                        $('.allowedPage ').hide();
                                        $('.overageCostPerPage').hide();
                                        $('.allowedVideo').hide();
                                        $('.overageCostPerVideo').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.overageCostPerUser').hide();
                                        $('.allowUser').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.amount').hide();
                                        $('.allowedStore').hide();
                                        $('.amount').hide();
                                        $('.timePeriod').hide();
                                        $('.statusradio').hide();
                                        $('.overageCostVideoSize').hide();
                                        $('.alloweLicense').hide();
       
            }
			if($(this).val()=='STORAGE'){					
                                        
                                        $('.allowedDoc').hide();
                                        $('.overageCostPerDoc').hide();
                                        $('.allowedPage ').hide();
                                        $('.overageCostPerPage').hide();
                                        $('.allowedVideo').hide();
                                        $('.overageCostPerVideo').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.overageCostPerUser').hide();
                                        $('.allowUser').hide();
                                        $('.allowMaxvideoSize').hide();
                                        $('.overageCostVideoSize').hide();
                                        $('.allowedStore').show();
                                        $('.timePeriod').show();
                                        $('.statusradio').show();
                                        $('.alloweLicense').show();
                                        $('.amount').show();
                                          $('.name').show();
                                       
                                       
                                        
				}else if($(this).val()=='DOCUMENT'){					

                                       $('.allowedStore').hide();
                                       $('.alloweLicense').show();
                                        $('.allowdoc').show();
                                        $('.overageCost').show();
                                        $('.allowedPage ').show();
                                        $('.overageCostPerPage').show();
                                        $('.allowedVideo').show();
                                        $('.overageCostPerVideo').show();
                                        $('.allowMaxvideoSize').show();
                                        $('.overageCostPerUser').show();
                                        $('.allowUser').show();
                                        $('.allowMaxvideoSize').show();
                                        $('.overageCostVideoSize').show();
                                        $('.statusradio').show();
                                        $('.amount').show();
                                        $('.timePeriod').show();                                      
                                          $('.name').show();
                                        
					}
                                        
                                        
		});
		
		
});


</script>



