


<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage Help    <span> &raquo;
	<? 
	if(!empty($_GET['edit'])){
		echo 'Edit '.$ModuleName;
	}else{
		echo 'Add '.$ModuleName;
	}
	 ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } ?>
  <?php if(!empty($_SESSION['mess_help'])){
  	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_help'].'</div>';
  	unset($_SESSION['mess_help']);  	
  }?>


	<? 
	include("includes/html/box/help_form.php");
	
	
	
	?>

