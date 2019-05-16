<a href="<?=$ListUrl?>" class="back">Back</a>
<!--<a href="<?//=$EditUrl?>" class="edit">Edit</a>--> 
<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<?=$ModuleName?> Detail
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
  
       if(!empty($_GET['view'])){
			include("includes/html/box/view_account_form.php");
		} 
	}	
 ?>
