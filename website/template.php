<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	
	 if (is_object($webcmsObj)) {
	 	$arryTemplates=$webcmsObj->getTemplates();
		$num=$webcmsObj->numRows();
		
		$arrySetting=$webcmsObj->getSetting();
		
		if ($_POST) {
			 $ModuleName = 'Template';
			if (!empty($_POST['TemplateId'])) {
				$_SESSION['mess_Page'] = $ModuleName.UPDATED;
				$ListUrl    = "template.php";
												
				$webcmsObj->updateTemplate($_POST);
				header("location:".$ListUrl);
			}
			exit;
			
		}

       }
  
  require_once("../includes/footer.php");
  
?>
