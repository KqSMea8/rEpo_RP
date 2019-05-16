<a href="<?=$ListUrl?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
 <div class="message"><? if (!empty($_SESSION['mess_account'])) {  echo stripslashes($_SESSION['mess_account']);   unset($_SESSION['mess_account']);} ?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
  
       		include("includes/html/box/account_type_form.php");
	}	
 ?>
