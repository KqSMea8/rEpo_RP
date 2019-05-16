<?php   
 
 /**************************************************/
    $ThisPageName = 'viewGroup.php'; $EditPage = 1;
    /**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/role.class.php");
	$ModuleName = "Role";
	
	$RedirectURL = "viewGroup.php?curP=".$_GET['curP'];
	

	$EditUrl = "editGroup.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
	$ActionUrl = $EditUrl;
 

	$objRole=new role();


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_Group'] = GROUP_REMOVED;
		$objRole->RemoveRoleGroup($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_Group'] = GROUP_STATUS;
		$objRole->changeRoleGroupStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
	

	
	 if ($_POST) {
		 CleanPost(); 
		if (!empty($_POST['GroupID'])) {
			$ImageId = $_POST['GroupID'];
			$objRole->UpdateRoleGroup($_POST);
			
			/* permission*/
			 $objRole->UpdateGroupRolePermission($_POST);
			/* permission*/
			
			 
			$_SESSION['mess_Group'] = GROUP_UPDATED;
		} else {	
			$ImageId = $objRole->AddRoleGroup($_POST); 
			$_SESSION['mess_Group'] = GROUP_ADDED;
		}
		$_POST['GroupID'] = $ImageId;
                 header("Location:".$RedirectURL);
		  exit;
		
	 }
		
	if (!empty($_GET['edit'])) {
		$arryGroup = $objRole->getRoleGroup($_GET['edit'],'');

	}
	

			
				
	if($arryGroup[0]['Status'] != ''){
		$GroupStatus = $arryGroup[0]['Status'];
	}else{
		$GroupStatus = 1;
	}				
		

	require_once("../includes/footer.php"); 
?>


