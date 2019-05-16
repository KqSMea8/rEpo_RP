<? if($_GET['pop']!=1){ ?>
<a href="<?=$ListUrl?>" class="back">Back</a>
<!--<a href="<?=$EditUrl?>" class="edit">Edit</a>-->

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo "Detail ".$ModuleName; ?>
		
		</span>
</div>
<?php }?>
 <div class="message"><? if (!empty($_SESSION['mess_journal'])) {  echo stripslashes($_SESSION['mess_journal']);   unset($_SESSION['mess_journal']);} ?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
  
     			 include("includes/html/box/view_journal_entry_form.php");
	}	
 ?>
