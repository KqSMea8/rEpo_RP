<div class="had">Edit Company Profile  <span> &raquo; <?=$SubHeading?></span></div>

<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
<? } ?>
  
<? include("includes/html/box/company_edit.php"); ?>
