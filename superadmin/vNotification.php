<?php 
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/notification.class.php");
        
	  $objNotification = new notification();	  
		
	 	$NotificationID=$_GET['view'];
	 	
	 	$arryvnotification=$objNotification->vNotification($NotificationID);
		$num=$objNotification->numRows();

	require_once("includes/footer.php"); 	 
?>
