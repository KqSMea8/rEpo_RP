<?php
//require_once("pageList.php");
session_start();
if(empty($_SESSION['SuperAdminID'])){
	header("Location: ../index.php");
}else{
header("Location: pageList.php");
}
exit;

?>
