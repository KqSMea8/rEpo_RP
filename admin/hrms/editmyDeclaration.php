<?php
	/**************************************************/
	$ThisPageName = 'myDeclaration.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();
	$objPayroll=new payroll();
	$objEmployee=new employee();

	CleanGet();

	$RedirectUrl ="myDeclaration.php?curP=".$_GET['curP'];
	$ModuleName = "Declaration Form";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_dec'] = DEC_REMOVED;
		$objPayroll->deleteDeclaration($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		/********************************/
		CleanPost();
		/********************************/



		if (!empty($_POST['decID'])) {
			$decID = $_POST['decID'];
			$objPayroll->updateDeclaration($_POST);
			$_SESSION['mess_dec'] = DEC_UPDATED;
		} else {		
			$decID = $objPayroll->addDeclaration($_POST);
			$_SESSION['mess_dec'] = DEC_ADDED;
		}

		/*****************************************/
		if($_FILES['document']['name'] != ''){
			$arryEmployee = $objEmployee->GetEmployeeBrief($_POST['EmpID']);
			$UserName = stripslashes($arryEmployee[0]['UserName']);
			$arrHeading=explode(".",$_FILES['document']['name']);
			$heading = escapeSpecial($arrHeading[0].'_'.$UserName);

			$FileInfoArray['FileType'] = "Document";
			$FileInfoArray['FileDir'] = $Config['DeclarationDir'];
			$FileInfoArray['FileID'] = $heading."_".$decID;
			$FileInfoArray['OldFile'] = $_POST['OldDocument'];
			$FileInfoArray['UpdateStorage'] = '1';
			$ResponseArray = $objFunction->UploadFile($_FILES['document'], $FileInfoArray);
			if($ResponseArray['Success']=="1"){  
				$objPayroll->updateDeclarationFile($ResponseArray['FileName'],$decID);
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}
 

			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_dec'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_dec'] .= $ErrorPrefix.$ErrorMsg;
			}

		}
		/*****************************************/

		header("location:".$RedirectUrl);
		exit;		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryDeclaration = $objPayroll->getDeclaration($_GET['edit'],'');
		$_GET['emp'] = $arryDeclaration[0]['EmpID'];
	}else{
		$arryEmployee = $objEmployee->GetEmployeeBrief('');
	}
	

	$arryTaxForm = $objCommon->getTaxDocument('','',1);	
	$document = stripslashes($arryTaxForm[0]['document']);
        
	if($document !='' && IsFileExist($Config['DeclarationDir'],$document)){ 
		$TaxFormExist=1;
	}else if(empty($_GET['edit'])){
		$ErrorMsg = DEC_FORM_NOT_USER;
		$TaxFormExist=0;
	}

	require_once("../includes/footer.php"); 
?>
