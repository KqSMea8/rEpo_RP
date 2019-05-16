<?php
	/**************************************************/
	$ThisPageName = 'viewBenefit.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	
	$ModuleName = "Benefit";
	
	$RedirectUrl = "viewBenefit.php?curP=".$_GET['curP'];


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_pp'] =BENEFIT_ADDED;
		$objCommon->deleteBenefit($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_benefit'] = BENEFIT_STATUS_CHANGED;
		$objCommon->changeBenefitStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if ($_POST){
		
		if(!empty($_POST['Bid'])) 
                    {
			$objCommon->updateBenefit($_POST);
			$Bid = $_POST['Bid'];
			$_SESSION['mess_benefit'] = BENEFIT_UPDATED;
			
		}
		else 
		{		
			$Bid = $objCommon->addBenefit($_POST);
			$_SESSION['mess_benefit'] = BENEFIT_ADDED;
                         
                }
                
               
		/************************************/
		if($_FILES['Document']['name'] != '')
                    {
			$FileInfoArray['FileType'] = "Document";
			$FileInfoArray['FileDir'] = $Config['BenefitDir'];
			$FileInfoArray['FileID'] =  $Bid;
			$FileInfoArray['OldFile'] = $_POST['OldDocument'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['Document'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){   
				$objCommon->UpdateBenefitDocument($ResponseArray['FileName'],$Bid);
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}
 

			if(!empty($ErrorMsg))
                            {
				if(!empty($_SESSION['mess_benefit'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_benefit'] .= $ErrorPrefix.$ErrorMsg;
			}

		}
		/************************************/
	
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		//print_r($_GET['edit']);exit;
		$arryBenefit = $objCommon->getBenefit($_GET['edit'],'');
		$Status   = $arryBenefit[0]['Status'];
	}


 
 require_once("../includes/footer.php"); 
 
 ?>
