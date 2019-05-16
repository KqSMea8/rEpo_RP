<div class="had">Add Item</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  
	if($HideForm!=1){ 
		include("includes/html/box/quick_item_form.php");
	}
	?>
	