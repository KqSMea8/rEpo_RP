<?php
	
	/**************************************************/
	$ThisPageName = 'viewEvent.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	
	$objEmployee=new employee();

	$RedirectUrl = 'viewEvent.php';

	(!$_GET['cat'])?($_GET['cat']=1):(""); 
	$ModuleName = "Email Template";

	if($_POST){
		$objEmployee->SendEventEmail($_POST);
		$_SESSION['mess_event'] =  EMAIL_SEND;
		header("location:".$RedirectUrl);
		exit;
	}


	$arrayCat = $objEmployee->GetTemplateCategory('');
	$arryTemplate = $objEmployee->GetTemplateByCategory($_GET['cat']);
	$TemplateID=$arryTemplate[0]['TemplateID'];
	
	if($_GET['EmpID']>0){
		$arryEmployee = $objEmployee->GetEmployee($_GET['EmpID'],'');
	}
	

	$arrayContents = $objEmployee->GetTemplateContent($TemplateID,'');

if($arrayContents[0]['Status'] == 1){
  $Status=1;
}else{
	$Status =0;
}
	
	require_once("../includes/footer.php"); 
?>


