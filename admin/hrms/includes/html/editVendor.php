<a href="<?=$RedirectURL?>" class="back">Back</a>


<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  

	include("includes/html/box/vendor_form.php");

	/*if(!empty($_GET['edit'])) {
		include("../includes/html/box/upload_image.php"); 
	}*/


	?>
	







