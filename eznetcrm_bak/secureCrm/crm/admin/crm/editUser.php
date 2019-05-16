<?php 
	/**************************************************/
	$ThisPageName = 'viewUser.php'; $EditPage = 1; $Division = 5; 
	/**************************************************/	
	include_once("../includes/header.php");
	include("../includes/html/box/edit_user.php");
 
	require_once("../includes/footer.php"); 	
?>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($HideForm!=1){ 
 if(empty($_GET['edit']) || $_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } } ?>
</SCRIPT>
