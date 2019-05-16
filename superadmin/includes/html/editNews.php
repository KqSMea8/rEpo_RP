
<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>
<div class="had">Manage News <span> &raquo; <? 
if(!empty($_GET['edit'])){
	echo 'Edit '.$ModuleName;
}else{
	echo 'Add '.$ModuleName;
}
?> </span></div>
<? if (!empty($errMsg)) {?>
<div height="2" align="center" class="red"><?php echo $errMsg;?></div>

<? } ?>
<?php if(!empty($_SESSION['mess_news'])){
	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_news'].'</div>';
	unset($_SESSION['mess_news']);
}?>

<?
include("includes/html/box/news_form.php");

?>

