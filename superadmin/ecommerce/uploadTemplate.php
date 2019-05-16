<?php
    /**************************************************/
    $ThisPageName = 'viewTemplate.php'; $EditPage = 1; 
    /**************************************************/
	$ModuleID = 20;
	require_once("includes/header.php");

	require_once("classes/template.class.php"); 
	
	$ModuleName = "Template";
	$objtemplate=new template();

	 $RedirectUrl = "viewTemplates.php";


	/* if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_country'] = $ModuleName.$MSG[103];
		$objRegion->deleteCountry($_REQUEST['del_id']);
		header("location: ".$RedirectUrl);
		exit;
	}


	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_country'] = $ModuleName.$MSG[104];
		$objRegion->changeCountryStatus($_REQUEST['active_id']);
		header("location: ".$RedirectUrl);
		exit;
	}*/
	
	

	if ($_POST) {
		//CleanPost();
		
		if (!empty($_POST['TemplateId'])) { 
			$objtemplate->updateTemplate($_POST);
			$_SESSION['mess_template'] = UPDATE_TEMPLATE_SUCCESS;
		} else {	
						
			$response=$objtemplate->addTemplate($_POST);
			
			if($response=='success') $response=ADD_TEMPLATE_SUCCESS;
			
			$_SESSION['mess_template'] = $response;
		}
	
		$RedirectUrl = "viewTemplates.php";
		header("location: ".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryTemplate = $objtemplate->getTemplateById($_GET['edit']);
		
	}

	#$arryContinent = $objRegion->getContinent('');


	require_once("includes/footer.php");
 
 ?>
