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
<? }else if($_GET['pay']==1) { ?>
<div class="had">Payment History </div>
<?php } else{ ?>
<div class="had">Invoice Entry Details</div>
<?php }?>
 
	<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
	<?php }
    else{  
 		if($_GET['pay']==1) {
				
			include("includes/html/box/purchase_payment_invoice_view.php");
		}else{
			include("includes/html/box/other_expense_view.php");
		}
		
	}	
 ?>
