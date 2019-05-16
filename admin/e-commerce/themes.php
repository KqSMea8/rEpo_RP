<?php
include_once("../includes/header.php");
require_once($Prefix."classes/webcms.class.php");
require_once($Prefix."classes/theme.class.php");
$webcmsObj=new webcms();
$themeObj=new theme();


if (is_object($webcmsObj)) {
	
	$arryTemplates=$themeObj->GetThemes();
	$num=$themeObj->numRows();

	$arrySetting=$webcmsObj->getecomSetting();

	if ($_POST) {
		$ModuleName = 'Template';
		if (!empty($_POST['TemplateId'])) {

			$_SESSION['mess_Page'] = $ModuleName.UPDATED;
			$ListUrl    = "themes.php";

			$webcmsObj->updateecomTemplate($_POST);
			header("location:".$ListUrl);
		}
		exit;
			
	}

}

require_once("../includes/footer.php");

?>
