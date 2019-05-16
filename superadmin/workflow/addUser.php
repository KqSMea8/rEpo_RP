<?php 

    /**************************************************/
    $ThisPageName = 'addUser.php'; if(empty($_GET["edit"]))$EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	/* * *********************************************** */
  
	$ModuleName = "Userinfo";
	$RedirectURL = "user.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="user";

	$EditUrl = "addUser.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
	$objUser=new user();
	$arryUser=$objUser->getUser($_GET);

	$objPackage=new package();
    $arryPackage=$objPackage->getPackage($_GET);
	/*if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_company'] = COMPANY_REMOVED;
		$objCompany->RemoveCompany($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}*/
	
  #edit the Usercompany data 
if (!empty($_GET["edit"])){ 
    $userID =$_REQUEST['edit'];
    $arryUser = $objUser->getUser($_GET['edit'],$userID);

  //  header("Location:".$EditUrl);
			//exit;
}
	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_user'] = USER_STATUS_CHANGED;
	     $status = $_GET['status']; 
         $data = array('status'=>$status);
		$objUser->changeUserStatus($data,$_REQUEST['active_id']);
		header("Location:".$RedirectURL);
		
	}
	//$HideModule = 'Style="display:none"';
	require_once("includes/footer.php"); 
?>


