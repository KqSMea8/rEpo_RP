<?php 
    
	/**************************************************/
	$ThisPageName = 'viewNotification.php'; $EditPage = 1;
	/**************************************************/
    $ModuleName ="Notification";
	include_once("includes/header.php");

	require_once("../classes/notification.class.php");
	require_once("../classes/function.class.php");

	$objFunction	=	new functions();
	$objNotification = new notification();

	$NotificationID = (int)$_GET['edit'];
	$RedirectURL = "viewNotification.php?curP=".$_GET['curP'];


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_notification'] = NOTIFICATION_REMOVED;
		$objNotification->RemoveNotification($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_notification'] = NOTIFICATION_STATUS_CHANGED;
		$objNotification->changeNotificationStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


    if (!empty($_POST)) {


		   if (!empty($NotificationID)) {
			      $LastNotificationID = $NotificationID;
		              $_SESSION['mess_notification'] =  NOTIFICATION_UPDATED;
		              $objNotification->UpdateNotification($_POST);
		              //header("location:".$RedirectURL);
		   } 
			    else 
			       {
		                                    	
				$_SESSION['mess_notification'] =  NOTIFICATION_ADDED;
				$LastNotificationID = $objNotification->AddNotification($_POST);	
				//header("location:".$RedirectURL);
		     }
			if($_FILES['Image']['name'] != ''){
					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['NotificationDir'];
					$FileInfoArray['FileID'] = 'Notification_'.$LastNotificationID;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);	
					//echo '<pre>a';print_r($ResponseArray);die;
					if($ResponseArray['Success']=="1"){  
						$objNotification->UpdateImageNotification($ResponseArray['FileName'],$LastNotificationID);
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_notification'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_notification'] .= $ErrorPrefix.$ErrorMsg;
						}

				}
			header("location:".$RedirectURL);
                 	 exit;

  	}
    
	if (!empty($NotificationID)) {
		$arryNotification = $objNotification->GetNotificationById($NotificationID);
	}
	
      require_once("includes/footer.php"); 

?>


