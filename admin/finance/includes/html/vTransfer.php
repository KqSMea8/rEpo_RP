<?php if($_GET['pop']!=1){ ?>
<a href="<?=$ListUrl?>" class="back">Back</a>
<div class="had"><?=$ModuleName;?></div>
<?php }?>
 <div class="message"><? if (!empty($_SESSION['mess_transfer'])) {  echo stripslashes($_SESSION['mess_transfer']);   unset($_SESSION['mess_transfer']);} ?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
  
     	 include("includes/html/box/view_transfer_form.php");
	}	
 ?>
