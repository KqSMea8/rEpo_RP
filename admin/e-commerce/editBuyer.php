<?php
	require_once("includes/header.php");
	require_once("../classes/member.class.php");
	require_once("../classes/template.class.php");
	require_once("../classes/region.class.php");
	
	$_GET['opt']="Buyer";
	
	$ModuleName = $_GET['opt'];
	$RedirectURL = "viewBuyers.php?curP=".$_GET['curP'];


	$objMember=new member();
	$objTemplate=new template();
	$objRegion=new region();
	
	
	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objMember->RemoveMember($del_id);
					}
					$_SESSION['mess_member'] = $_GET['opt'].'(s) '.$MSG[103];
					break;
			case 'active':
					$objMember->MultipleMemberStatus($multiple_action_id,1);
					$_SESSION['mess_member'] = $_GET['opt'].'(s) '.$MSG[107];
					break;
			case 'inactive':
					$objMember->MultipleMemberStatus($multiple_action_id,0);
					$_SESSION['mess_member'] = $_GET['opt'].'(s) '.$MSG[108];
					break;				
		}
		header("location: ".$RedirectURL);
		
	 }
	
	/*********  End Multiple Actions **********/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_member'] = $ModuleName.$MSG[103];
		$objMember->RemoveMember($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_member'] = $ModuleName.$MSG[104];
		$objMember->changeMemberStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}
	

	
	
		
	 if ($_POST) {
			 if (empty($_POST['Email'])) {
				$errMsg = $MSG[10];
			 } else {
				if (!empty($_POST['MemberID'])) {
					$objMember->UpdateMember($_POST);
					
					$_SESSION['mess_member'] = $ModuleName.$MSG[102];
					$ImageId = $_POST['MemberID'];
				} else {	
					if($objMember->isUserNameExists($_POST['UserName'],'',$_POST['Type'])){
						$_SESSION['mess_member'] = $MSG[105];
					}else{	
						$ImageId = $objMember->AddMember($_POST); 
						$_SESSION['mess_member'] = $ModuleName.$MSG[101];
					}
				}
				
				$_POST['MemberID'] = $ImageId;
				
					header("Location:".$RedirectURL);
					
					
					
					
				
			}
		}
		

		if ($_REQUEST['edit'] && !empty($_REQUEST['edit'])) {
			$arryMember = $objMember->GetMembers($_GET['edit'],'','');
			$ParentID   = $arryMember[0]['ParentID'];
			
			$MemberID   = $_REQUEST['edit'];
			

		
				
			
			
			
		}
				
		if($arryMember[0]['Status'] != ''){
			$MemberStatus = $arryMember[0]['Status'];
		}else{
			$MemberStatus = 1;
		}
		
		
		
		
		
		
		
	$OnSubmitFunction = 'onSubmit="return validateBuyer(this);"';
	
	
	
	$arryCountry = $objRegion->getCountry('','');
	$arryIsd = $objRegion->getCountryIsd('','');


	require_once("includes/footer.php"); 

?>


