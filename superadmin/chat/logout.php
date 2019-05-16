<?php ob_start();
session_start();	
	if (isset($_SESSION['SuperAdminID'])) { unset($_SESSION['SuperAdminID']); }
		if (isset($_COOKIE[session_name()])) {
	  setcookie(session_name(), '', time()-42000, '/');
	}
	unset($_SESSION);
	session_destroy();	
	header("location:index.php");
	ob_end_flush();
?>
