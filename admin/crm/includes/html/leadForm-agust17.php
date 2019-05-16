<!--div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div-->

<div class="had">Create Lead Form</div>
	<?php  if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php } 
  
	
		include("includes/html/box/create_lead_form.php");
	
	?>
	







