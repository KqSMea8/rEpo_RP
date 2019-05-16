<?php 
    /**************************************************/
    $ThisPageName = 'viewReseller.php'; if(empty($_GET["edit"]))$EditPage = 1; 
    /**************************************************/
	require_once("includes/header.php");
	require_once("../classes/reseller.class.php");
	require_once("../classes/region.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/function.class.php");
	require_once("../classes/company.class.php");
	require_once("../classes/commonsuper.class.php");
	
	$objFunction	=	new functions();
	$objConfigure	=	new configure();
	$objReseller	=	new reseller();
	$objRegion	=	new region();	
	$objCompany	=	new company();
	$objCommon	=	new common();
	$ModuleName = "Reseller";
	$RedirectURL = "viewReseller.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editReseller.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];

	

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_reseller'] = RESELLER_REMOVED;
		$objReseller->RemoveReseller($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_reseller'] = RESELLER_STATUS_CHANGED;
		$objReseller->changeResellerStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if($_POST){	
			CleanPost();
	

			 if (empty($_POST['Email']) && empty($_POST['RsID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				if (!empty($_POST['RsID'])) {
					$ImageId = $_POST['RsID'];
					/*
					$objReseller->UpdateReseller($_POST);
					$_SESSION['mess_reseller'] = RESELLER_UPDATED;
					*/
					/***************************/
					switch($_GET['tab']){
						case 'personal':
							$objReseller->UpdateResellerProfile($_POST);
							$_SESSION['mess_reseller'] = RESELLER_PROFILE_UPDATED;
							break;
						case 'login':
							$objReseller->UpdateAccount($_POST);
							$_SESSION['mess_reseller'] = LOGIN_UPDATED;
							break;	
						case 'discount':
							$objReseller->UpdateDiscount($_POST);
							$_SESSION['mess_reseller'] = RESELLER_DISCOUNT_UPDATED;
							break;	
						case 'term':
							$objReseller->UpdateAccountLimit($_POST);
							$_SESSION['mess_reseller'] = RESELLER_LIMIT_UPDATED;
							break;	
						case 'comm':							
							$objReseller->UpdateSalesCommission($_POST);	
							$_SESSION['mess_reseller'] = SALE_COMM_UPDATED;
							break;	
						
					}
					/***************************/
				} else {	
					if($objReseller->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_reseller'] = EMAIL_ALREADY_REGISTERED;
					
					}else{	
						$ImageId = $objReseller->AddReseller($_POST); 
						$_SESSION['mess_reseller'] = RESELLER_ADDED;
						
					}
				}
				
				$_POST['RsID'] = $ImageId;
				
				/************************************
				if($_FILES['Image']['name'] != ''){
					$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");

					if(empty($FileArray['ErrorMsg'])){
						$ImageExtension = GetExtension($_FILES['Image']['name']); 
						$imageName = $ImageId.".".$ImageExtension;	
						$ImageDestination = "../upload/reseller/".$imageName;

						if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
							unlink($_POST['OldImage']);		
						}

						if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){

							$objReseller->UpdateImage($imageName,$ImageId);
						}
					}else{
						$ErrorMsg = $FileArray['ErrorMsg'];
					}

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_reseller'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_reseller'] .= $ErrorPrefix.$ErrorMsg;
					}

				}*/


				if($_FILES['Image']['name'] != ''){
					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['ResellerDir'];
					$FileInfoArray['FileID'] = $ImageId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);

					if($ResponseArray['Success']=="1"){
						 $objReseller->UpdateImage($ResponseArray['FileName'],$ImageId);					
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}	 

					if(!empty($ErrorMsg)){
						$_SESSION['mess_reseller'] .= '<br><br>'.$ErrorMsg;
					} 
				}
				/************************************/
				
				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			}
		}
		

	if (!empty($_GET['edit'])) {
		$arryReseller = $objReseller->GetReseller($_GET['edit'],'');
		$RsID   = $_REQUEST['edit'];	
		
		/***************/
		if(empty($arryReseller[0]['RsID'])){
			header("Location:".$RedirectURL);
			exit;
		}
		/***************/	
	}
				
	if($arryReseller[0]['Status'] != ''){
		$ResellerStatus = $arryReseller[0]['Status'];
	}else{
		$ResellerStatus = 1;
	}		
	
	$arryCountry = $objRegion->getCountry('','');


	/***************/	
	if(!empty($_GET['edit'])){
		if($_GET['tab']=="discount"){
			$PageTitle = "Package Discount";
		}else if($_GET['tab']=="term"){
			$PageTitle = "Payment Term";	
		}else if($_GET['tab']=="comm"){
			$PageTitle = "Sales Commission Structure";
		}else if($_GET['tab']=="sales"){
			$PageTitle = "Sales Report";
		}else if($_GET['tab']=="report"){
			$PageTitle = "Sales Commission Report";
		}else{
			$PageTitle = ucfirst($_GET["tab"])." Details";
		}
	}



	require_once("includes/footer.php"); 
?>


