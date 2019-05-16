<?php

$RedirectUrl = "meeting.php?curP=".$_GET['curP']."&module=".$_GET['module']."&tab=UserManagement";

/***********************/

if(!empty($_GET['del_id'])){
	$_POST['userId'] = $_GET['del_id'];
	$result = $objMeeting->deleteUserPermanently();
	if($result->id){
		$objMeeting->deleteUserByID($result->id);
		$_SESSION['mess_meeting'] = 'User deleted successfully.';
	}else if($result->error){
		$_SESSION['mess_meeting'] = $result->error->message;
	}else{
		$_SESSION['mess_meeting'] = 'Not able to delete. Try after some time!';
	}
	
	header("location:" . $RedirectUrl);
	exit;
}

if (!empty($_GET['active_id']))
{
	$_GET['active_id'] = (int) $_GET['active_id'];
	$objMeeting->updateUserStatus($_GET['active_id'],$_GET['status']);
	$_SESSION['mess_meeting'] ="User status has been changed successfully!";
	header("location:" . $RedirectUrl);
	exit;
}


if(!empty($MeetingUser) && $MeetingUser[0]['account_type']=='admin'){
	$group_id = $MeetingUser[0]['group_id'];
	$admin_id = $MeetingUser[0]['id'];
}

if($_POST['confirmAddUser'] && ($_SESSION['AdminType']=='admin')) {
		CleanPost();
		
		if(empty($group_id) || empty($admin_id)){
			$_SESSION['mess_meeting'] = 'It seems like you are not admin!';
			header("location:" . $RedirectUrl);
			exit;
		}
		
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$result = $objMeeting->custcreateUser($_POST);
			if(!empty($result->email)){
				$result->created_at  = $objMeeting->convertIsoDateToSql($result->created_at);
				$result->cust_id = $_POST['customers'];
				$objMeeting->saveUser($result);
				$_SESSION['mess_meeting'] = 'User is added successfully.';
			}else if($result->error){
				$_SESSION['mess_meeting'] = $result->error->message;
			}else{
				$_SESSION['mess_meeting'] = 'Something went wrong. Contact to Administrator!';
			}
		}else{
			$_SESSION['mess_meeting'] = 'Email is not valid!';
		}
        header("location:" . $RedirectUrl);
        exit;
}
/***********************/

//$arryCustomer = $objMeeting->getCustomerList();
$arryCustomer = $objMeeting->ListEmployee();
//pr($arryCustomer);
$arryMeetingUsers = $objMeeting->getMeetingUserList($_SESSION['AdminType']);
$num = $objMeeting->numRows();

//pr($arryMeetingUsers);
$pagerLink = $objPager->getPager($arryMeetingUsers, $RecordsPerPage, $_GET['curP']);
(count($arryMeetingUsers) > 0) ? ($arryMeetingUsers = $objPager->getPageRecords()) : ("");
 

require_once("includes/html/meetingUserManagement.php");

?>
