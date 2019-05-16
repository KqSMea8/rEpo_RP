<?php 
	/**************************************************/
	$ThisPageName = 'viewTraining.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/training.class.php");	
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objTraining=new training();
	$objEmployee=new employee();
	$ModuleName = "Training";
	$RedirectURL = "viewTraining.php?curP=".$_GET['curP'];

	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objTraining->RemoveTraining($del_id);
					}
					$_SESSION['mess_training'] = TRAINING_REMOVED;
					break;
			case 'active':
					$objTraining->MultipleTrainingStatus($multiple_action_id,1);
					$_SESSION['mess_training'] = TRAINING_STATUS_CHANGED;
					break;
			case 'inactive':
					$objTraining->MultipleTrainingStatus($multiple_action_id,0);
					$_SESSION['mess_training'] = TRAINING_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/		

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_training'] = TRAINING_REMOVED;
		$objTraining->RemoveTraining($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_training'] = TRAINING_STATUS_CHANGED;
		$objTraining->changeTrainingStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			CleanPost(); 
			 if (empty($_POST['CourseName'])) {
				$errMsg = ENTER_COURSE;
			 } else {
				if (!empty($_POST['trainingID'])) {
					$trainingID = $_POST['trainingID'];
					$objTraining->UpdateTraining($_POST);
					$_SESSION['mess_training'] = TRAINING_UPDATED;
				} else {	
					$trainingID = $objTraining->AddTraining($_POST); 
					$_SESSION['mess_training'] = TRAINING_ADDED;
				}
				
				$_POST['trainingID'] = $trainingID; 



				/*****************************************/
				if($_FILES['document']['name'] != ''){

					$FileInfoArray['FileType'] = "Document";
					$FileInfoArray['FileDir'] = $Config['TrainingDir'];
					$FileInfoArray['FileID'] =  $trainingID;
					$FileInfoArray['OldFile'] = $_POST['OldDocument'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['document'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objTraining->UpdateDocument($ResponseArray['FileName'],$trainingID);						 
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
			  
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_training'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_training'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				/*****************************************/	

				header("Location:".$RedirectURL);
				exit;



				
			}
		}
		

	$Status = 1;
	if(!empty($_GET['edit'])){
		$arryTraining = $objTraining->GetTraining($_GET['edit'],'');
		$PageHeading = 'Edit Training for Course: '.stripslashes($arryTraining[0]['CourseName']);
		$trainingID   = $_GET['edit'];	
		$Status = $arryTraining[0]['Status'];
	}else{
		$arryTraining[0]['Department']='';
	}
	$arryEmployee = $objEmployee->GetEmployeeBrief('');

	require_once("../includes/footer.php"); 	 
?>
