<?php 
	include_once("includes/header.php");
	
	$ModuleName = "UserInfo";
	$objUser=new user();
	
	$arryUser=$objUser->getUser($_GET); 
	$num=$objUser->num_rows;

	$pagerLink=$objPager->getPager($arryUser,$RecordsPerPage,$_GET['curP']);
	//(count($arryUser)>0)?($arryUser=$objPager->getPageRecords()):("");
	 $RedirectURL = "user.php?curP=" . $_GET['curP']; 
	 
   if (!empty($_GET['del_id'])) { 
		$arryUser = $objUser->DeleteUser($_REQUEST['del_id']);
                 echo 'Row deleted successfully.';
                 header("Location:".$RedirectURL);
                 exit;
        }
	require_once("includes/footer.php"); 	
    
?>


