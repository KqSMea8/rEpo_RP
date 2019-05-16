<div class="had">Add Lead</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  
	if($HideForm!=1){ 
		include("includes/html/box/quick_lead_form.php");
	}
	?>
	







