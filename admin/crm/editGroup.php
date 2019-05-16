<?php   
 
 /**************************************************/
    $ThisPageName = 'viewGroup.php'; $EditPage = 1;
    /**************************************************/

	require_once("../includes/header.php");
		require_once($Prefix."classes/group.class.php");
	
	require_once($Prefix."classes/employee.class.php");
	
	$ModuleName = "Group";
	
	$RedirectURL = "viewGroup.php?curP=".$_GET['curP'];
	

	$EditUrl = "editGroup.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]; 
	$ActionUrl = $EditUrl;
 

	$objGroup=new group();
	
	$objEmployee=new employee();
	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objGroup->RemoveGroup($del_id);
					}
					$_SESSION['mess_Group'] = DOC_REMOVED;
					break;
			case 'active':
					$objGroup->MultipleGroupStatus($multiple_action_id,1);
					$_SESSION['mess_Group'] = DOC_REMOVED;
					break;
			case 'inactive':
					$objGroup->MultipleGroupStatus($multiple_action_id,0);
					$_SESSION['mess_Group'] = DOC_REMOVED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_Group'] = GROUP_REMOVED;
		$objGroup->RemoveGroup($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_Group'] = GROUP_STATUS;
		$objGroup->changeGroupPublish($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
	

	
	 if ($_POST) {
		/*******************/
		$description = $_POST['description'];
		CleanPost(); 
		$_POST['description'] = $description;
		/*******************/

		if (!empty($_POST['GroupID'])) {
			$ImageId = $_POST['GroupID'];
			$objGroup->UpdateGroup($_POST);
			$_SESSION['mess_Group'] = GROUP_UPDATED;
		} else {	
			$ImageId = $objGroup->AddGroup($_POST); 
			$_SESSION['mess_Group'] = GROUP_ADDED;
		}
		$_POST['GroupID'] = $ImageId;
                 header("Location:".$RedirectURL);
		  exit;
		
	 }
		

	if (!empty($_GET['edit'])) {
		$arryGroup = $objGroup->getGroup($_GET['edit'],'');
                $PageHeading = 'Edit Group for :'.stripslashes($arryGroup[0]['group_name']);
		$arryEmp=$objGroup->getGroupUser($arryGroup[0]['group_user']);
		
		$return_array = array();
		for ($i=0;$i<sizeof($arryEmp);$i++) {

			$row_array2['id'] = $arryEmp[$i]['EmpID'];
			$row_array2['name'] =$arryEmp[$i]['UserName'];
			$row_array2['department'] =$arryEmp[$i]['emp_dep'];
			$row_array2['designation'] = $arryEmp[$i]['JobTitle'];

		   if($arryEmp[$i]['Image']==''){
			$row_array2['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
		   }else{
			$row_array2['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$arryEmp[$i]['Image']."";
		   }

		array_push($return_array,$row_array2);
		}

		 $json_response2= json_encode($return_array);
		 
		
		$GroupID   = $_GET['edit'];			
	}
				
	if(!empty($arryGroup) && $arryGroup[0]['Status'] != ''){
		$GroupStatus = $arryGroup[0]['Status'];
	}else{
		$GroupStatus = 1;
	}				
		
	//$arryEmployee = $objEmployee->GetEmployeeBrief('');

	require_once("../includes/footer.php"); 
?>


