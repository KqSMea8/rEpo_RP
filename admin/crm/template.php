<?php 

/**************************************************/
$ThisPageName = 'viewCustomer.php'; $EditPage = 1;  $SetFullPage = 1;
/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/webcms.class.php");
        
	 $webcmsObj=new webcms();
	
	 if (is_object($webcmsObj)) {
	 	$arryTemplates=$webcmsObj->getTemplates('w');
		$num=$webcmsObj->numRows();
		
		$CustomerID=  $_GET['CustomerID'];
		$arrySetting=$webcmsObj->getSetting($CustomerID);

		if(empty($arrySetting[0]['Id'])){
			$arrySetting = $objConfigure->GetDefaultArrayValue('web_setting');
		}

		
		if ($_POST) {
			 $ModuleName = 'Template';
			if (!empty($_POST['TemplateId'])) {
				$_SESSION['mess_Page'] = $ModuleName.UPDATED;
				$ListUrl    = "template.php?&CustomerID=".$CustomerID;
												
				$webcmsObj->updateTemplate($_POST);
				header("location:".$ListUrl);
			}
			exit;
			
		}

       }
  $MainModuleName='Template';
  require_once("../includes/footer.php");
  
?>
