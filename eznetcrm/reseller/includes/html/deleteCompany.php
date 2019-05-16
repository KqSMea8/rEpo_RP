<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>

<div class="had">
<span>Confirm Delete </span>
</div>
<? if (!empty($errMsg)) {?>
<div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>
<? } ?>
<? 
	include("includes/html/box/company_delete.php");

?>

