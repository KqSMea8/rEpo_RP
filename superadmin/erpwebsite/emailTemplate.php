<?php
	
	require_once("includes/header.php");
	require_once("../../classes/commonsuper.class.php");

	$objCommon =new common();

	(!$_GET['cat'])?($_GET['cat']=1):(""); 
	

	if($_POST){		
		
			$objCommon->eznetERPUpdateTemplateContent($_POST);
			//$_SESSION['mess'] =  $MSG[6];
			$_SESSION['mess_template'] =  "Email Template has been Updated successfully.";
			header("location: emailTemplate.php?cat=".$_GET['cat']);
			 exit;
		
	}

if($_GET['cat'] >0){
	
	$arrayCat = $objCommon->eznetERPGetTemplateCategory('');
	
	$arryTemplate = $objCommon->eznetERPGetTemplateByCategory($_GET['cat']);
	
	$TemplateID=$arryTemplate[0]['TemplateID'];
	if(empty($TemplateID)){
		$TemplateID=10;
	}
	
}

			

	$arrayContents = $objCommon->eznetERPGetTemplateContent($TemplateID,'');
	
            if ($arrayContents[0]['Status'] == 1) {
               $Status = 1;
            } else {
               $Status = 0;
            }



	require_once("includes/footer.php"); 
?>

