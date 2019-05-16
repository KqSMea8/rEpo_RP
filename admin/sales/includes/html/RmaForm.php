<!--div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div-->

<div class="had">Create RMA Form</div>
	<?php  if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php } 
  
	
		include("includes/html/box/create_rma_form.php");
	
	?>
	







