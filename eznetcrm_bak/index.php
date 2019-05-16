<?php
include ('includes/header.php');
if(!empty($datah['template'])){
	include_once($datah['template']);
}else{
	include_once('content.php');
}
include ('includes/footer.php');
?>