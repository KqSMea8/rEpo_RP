<?php
	
	require_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	
	$objEmployee=new employee();

	
	(!$_GET['cat'])?($_GET['cat']=1):(""); 
	$ModuleName = "Email Template";

	if($_POST){

		
		
			$objEmployee->UpdateTemplateContent($_POST);
			//$_SESSION['mess'] =  $MSG[6];
			$_SESSION['mess_template'] =  "Email Template has been Updated successfully.";
			header("location: email_template.php?cat=".$_GET['cat']);
			 exit;
		
	}


	$arrayCat = $objEmployee->GetTemplateCategory('');
	$arryTemplate = $objEmployee->GetTemplateByCategory($_GET['cat']);
	$TemplateID=$arryTemplate[0]['TemplateID'];
	

	

	$arrayContents = $objEmployee->GetTemplateContent($TemplateID,'');

if($arrayContents[0]['Status'] == 1){
  $Status=1;
}else{
	$Status =0;
}
	
	require_once("../includes/footer.php"); 
?>


