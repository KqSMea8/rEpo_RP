<div class="had">
My Profile  <span>&raquo; <?=$SubHeading?>	</span>
</div>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>

<? 
	 
	if($_GET['tab']=="employment"){
		include("includes/html/box/employment.php");
	}else if($_GET['tab']=="family"){
		include("includes/html/box/family.php");
	}else if($_GET['tab']=="emergency"){
		include("includes/html/box/emergency.php");
	}else{
		include("includes/html/box/profile_edit.php");
	}

    	//include("../includes/html/box/upload_image.php"); 

	if($_GET['tab']=="education"){
		include("includes/html/box/education_doc.php");
		$DocType = "Scan"; $SupportedDoc = SUPPORTED_SCAN_DOC;
		include("../includes/html/box/upload_doc.php");
	}

?>
