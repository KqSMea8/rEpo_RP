<?php 
	/**************************************************/
	$ThisPageName = 'viewUsers.php'; $EditPage = 1; 
	/**************************************************/	
	include_once("includes/header.php");
	include("includes/html/box/edit_user.php");
 
	require_once("includes/footer.php"); 	
?>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if(empty($_GET['edit']) || $_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>
</SCRIPT>
