<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'CrmSetting.php'; $EditPage = 1;
    /**************************************************/
   
	  require_once("../includes/header.php");
  
		require_once($Prefix."classes/crm.class.php");
		require_once($Prefix."classes/field.class.php");
		include_once("language/en_lead.php");
	
	$_GET['mod'] = (int)$_GET['mod'];
	$_GET['edit'] = (int)$_GET['edit'];
	$_GET['head'] = (int)$_GET['head'];

	$ModuleName = "Field";
	$RedirectURL = "CrmSetting.php?curP=".$_GET['curP']."&head=".$_GET["head"]."&mod=".$_GET["mod"];
	$EditUrl = "editCustomField.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&head=".$_GET["head"]."&mod=".$_GET["mod"];
	$objField=new field();
	$objCommon=new common();
	
	/*********  Multiple Actions To Perform **********/
$fid = ($_GET['edit'])? $_GET['edit'] : $_GET['del_id'];
	$arrayFld = $objField->getFormField($fid,'',''); 
	
	/************************  End Multiple Actions ***************/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_field'] = CF_REMOVE;
		if($arrayFld[0]['editable'] == 1){
			$objField->removeColFrMainTable($_GET['del_id'],$_GET["mod"]);//By chetan//
		}
		$objField->removeField($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_lead'] = LEAD_STATUS;
		$objField->changeFormFieldStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
	
	/***************************************************************/
	
	      if ($_POST) {

			CleanPost(); 

                  
			
			if (!empty($_POST['fieldid'])) {
				$ImageId = $_POST['fieldid'];
				/*********************/
				if($arrayFld[0]['editable'] == 1){ 
				$objField->AddColumnToMainTable($_GET["mod"], $_POST,'update');//By chetan//
				} 
				$objField->UpdateFormField($_POST);
									               
				$_SESSION['mess_field'] = CF_UPDATED;//By Chetan 13July//
				header("Location:".$RedirectURL);
				exit;					
				/***************************/
			} else {
	
				 
				$_POST['fieldname'] = substr(md5(time()),0,2).'cf'.substr(md5(strrev(time())),0,2);
			        $ImageId = $objField->addFormField($_POST,$_GET["mod"]); //By chetan 2DEc//
			        $objField->AddColumnToMainTable($_GET["mod"], $_POST,'add');//By chetan//
			        
				$_SESSION['mess_field'] = CF_ADDED;//By Chetan 13July//
			}
				
				$_POST['headid'] = $ImageId;
				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}
		}
		
		
		
	$class = '';
	$disabled = '';
	$readOnly = '';
	if (!empty($_GET['edit'])) {
		$arryFormField = $objField->getFormField($_GET['edit'],'','');

		if($arryFormField[0]['editable']==0){
            $readOnly='readonly="readonly"';
			$disabled = "disabled";
			$class ="disabled";
		}
       

		$fieldid   = $_GET['edit'];	
		$Status= $arryFormField[0]['Status'];
	}else{
		$Status= 1;	
	}
				
	
	
    
	/*$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry','');
	$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');*/

  

	require_once("../includes/footer.php"); 
?>


