<?php if($_GET['pop']!=1){ ?>
<a href="<?=$ListUrl?>" class="back">Back</a>
<a href="<?=$EditUrl?>" class="edit">Edit</a>

<div class="had"><?=$MainModuleName?><span>&raquo;
	<? 	echo "Other ".$ModuleName." Details"; ?>
		
		</span></div>
<?php }else{?>
<div class="had">Payment Details</div>
<?php }?>

 
	<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
	<?php }
    else{  
 
		include("includes/html/box/other_income_view.php");
		
	}	
 ?>
