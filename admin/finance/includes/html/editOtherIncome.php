<a href="<?=$ListUrl?>" class="back">Back</a>
<div class="had"><?=$MainModuleName?><span>&nbsp;&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span></div>
<!--<p>This is where you can record cash sales and other money you have received. It can be used if you don't need to create invoices, and just want to record the income when it is paid.</p>-->
<div class="message" align="center">
<?php if(!empty($_SESSION['mess_add_income'])) {echo $_SESSION['mess_add_income']; unset($_SESSION['mess_add_income']); }?></div>
 
	<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
	<?php }
    else{  
 
		include("includes/html/box/other_income_form.php");
		
	}	
 ?>
