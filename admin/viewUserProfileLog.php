<?php 
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/user.class.php");
	$objCompany=new company();

	$objUser=new user();
	/****************************/

	/****************************/
	$CmpID   = $_SESSION['CmpID'];
	 (empty($_GET['mode']))?($_GET['mode']=""):("");
	$RedirectUrl = 'UserProfileLog.php.php?curP='.$_GET['curP'].'&mode='.$_GET['mode'];

	/*********************Delete Row start **********************/
	if(!empty($_POST['logID'])){
		CleanPost();
		$objUser->deleteProfileLog($_POST['logID']);
		$_SESSION['mess_profile'] = PROFILE_CHANGES_REMOVED;
		
	}
	/*********************Delete Row end *****************/	
	
	
	/******Get User Log Records***********/
	$RecordsPerPage = 100;
	$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryUserProfileLog=$objUser->GetProfileLog($_GET);
	/**********Count Records**************/
	$Config['GetNumRecords'] = 1;
        $arryCount=$objUser->GetProfileLog($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/


	$viewAll = 'UserProfileLog.php.php?curP='.$_GET['curP'];
			
	require_once("includes/footer.php"); 
?>
