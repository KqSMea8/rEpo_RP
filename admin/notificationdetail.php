<?php  $HideNavigation = 1;
	require_once("includes/header.php");
	require_once("../classes/notification.class.php");
        
	$objNotification = new notification();
	$NotificationID=$_GET['NotifiID'];

	$arryvnotification=$objNotification->GetNotificationById($NotificationID);

    require_once("includes/footer.php"); 
?>
