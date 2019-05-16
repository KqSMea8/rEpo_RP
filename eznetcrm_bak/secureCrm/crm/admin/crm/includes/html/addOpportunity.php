<div class="had">Add Opportunity</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  
	if($HideForm!=1){ 
		include("includes/html/box/quick_opportunity_form.php");
	}
	?>
	