<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>
<div class="had">Manage Server    <span> &raquo;Add Server</span></div>
<?php if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>
<? } ?>

<?php include("includes/html/box/server_edit.php"); ?>

