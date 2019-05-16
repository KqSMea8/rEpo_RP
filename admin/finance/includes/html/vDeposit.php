<?php if($_GET['pop']!=1){ ?>
<a href="<?=$ListUrl?>" class="back">Back</a>
<div class="had"><?=$MainModuleName?></div>
<?php }?>
 <div class="message">
 <? if (!empty($_SESSION['mess_deposit'])) 
 {  echo stripslashes($_SESSION['mess_deposit']);   unset($_SESSION['mess_deposit']);} ?>
 </div>
 
	<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
	<?php }
    else{  
 
		include("includes/html/box/bank_deposit_view.php");
		
	}	
 ?>
