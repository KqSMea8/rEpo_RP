<?php 
    /**************************************************/
    $ThisPageName = 'viewUser.php'; $EditPage = 1; 
    /**************************************************/
	
	$Prefix="../";

include_once("includes/header.php");


require_once($Prefix."classes/Suser.Class.php");
	$objUser=new Suser();
	$ModuleName = "User";
	$_SESSION['PASSWORD_LIMIT']=PASSWORD_LIMIT;
	$RedirectUrl = "viewUser.php?curP=".$_GET['curP'];
	
	//$arryDepartment=$objUser-> GetDepartment();
	
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editUser.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
	
	if ($_POST) 
            { CleanPost();
            	if($_GET['edit']>0 && $_GET['tab']=="account")
				{
				
				$arrpass=$objUser->ChangePassword($_POST['newPassword'],$_POST['Uid']);
	
				if($arrpass=="1")
				{ 
					$_SESSION['mess_user'] = PASSWORD_UPDATED;
					header("location:".$RedirectUrl);
				
				}
				else 
				{
					//$_SESSION['mess_user'] =PASSWORD_ERROR;	
					//header("location:".$ActionUrl);
					  
					
				}
					
				
					
					exit;
				}
            if($_GET['tab']=="role")
				{
					$objUser->UpdateRolePermissionCompany($_POST);					
					$objUser->UpdateRolePermission($_POST);
					
					
					$_SESSION['mess_user'] = Role_UPDATED;
						header("location:".$ActionUrl);
					exit;
				}
	
		if(!empty($_POST['Uid'])) 
                    {
			$objUser->updateUser($_POST);
			$Uid = $_POST['Uid'];
			$_SESSION['mess_user'] = USER_UPDATED;
			header("location:".$RedirectUrl);
		   exit;
			
		}
		else 
		{	
				
			$UserID = $objUser->AddUser($_POST);
			$_SESSION['mess_user'] =USER_ADDED;
			header("location:".$RedirectUrl);
		   exit;
                         
                }
            }
	
	 if($_GET['del_id'] && !empty($_GET['del_id']))
	 {
	
		$objUser->deleteUser($_REQUEST['del_id']);
			$_SESSION['mess_user'] =USER_REMOVED;
		
		header("location:".$RedirectUrl);
		exit;
	} 
	if($_GET['active_id'] && !empty($_GET['active_id']))
	{
		
	
		
		$objUser->changeUserStatus($_REQUEST['active_id']);
		$_SESSION['mess_user'] = USER_STATUS_CHANGED;
		header("location:".$RedirectUrl);
		exit;
	}	
	if($_GET['edit']>0)
	{
	
		$arryUser = $objUser->getUser($_GET['edit'],'');
	
	
	
	   
		
	
	}
	
		
				
	if($_GET['tab']=='role')
				{
		$SubHeading = 'Role/Permission';
	}
	else if($_GET['tab']=='account')
	{
		$SubHeading = 'Change Password';
	}
	//include("includes/html/box/edit_user.php");
 
	//require_once("includes/footer.php");	
	require_once("includes/footer.php");
	
?>

