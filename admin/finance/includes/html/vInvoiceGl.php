<?php if($_GET['pop']!=1) {?>
<a href="<?=$ListUrl?>" class="back">Back</a>
<!--<a href="<?=$EditUrl?>" class="edit">Edit</a>-->

	<? 
	/*********************/
	/*********************/
	if($ModifyLabel==1){
		$CloneLabel = 'Copy '.$module;
		$CloneConfirm = str_replace("[MODULE]", $module, CLONE_CONFIRM_MSG);
	?>
	<a href="<?=$CloneURL?>" class="edit" onclick="return confirmAction(this, '<?=$CloneLabel?> ', '<?=$CloneConfirm?>')" ><?=$CloneLabel?></a>
	<?	
 	}
	/*********************/
	/*********************/
 	?>



<div class="had">Invoice Entry Details</div>
<? }else{ ?>
<div class="had">Invoice Entry Details</div>
<?php }?>
 
	<? if (!empty($ErrorMSG)) {?>
	<div align="center"  class="redmsg" ><?php echo $ErrorMSG;?></div>
	<?php }
    else{  
			include("includes/html/box/invoice_gl_view.php");
		}
		
		
 ?>
