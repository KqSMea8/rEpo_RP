<div class="had"><?=$MainModuleName?></div>
 <div class="message">
 <? if (!empty($_SESSION['mess_bank_account'])) 
 {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?>
 </div>
 
	<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
	<?php }
    else{  
 
		include("includes/html/box/bank_deposit_form.php");
		
	}	
 ?>