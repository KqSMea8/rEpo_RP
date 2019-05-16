<?php
	
	require_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");

	$objCommon =new common();
	$_GET['cat'] = (int)$_GET['cat'];
	(!$_GET['cat'])?($_GET['cat']=9):(""); 
	

	if($_POST){
		/*******************/
		$TemplateContent = addslashes($_POST['TemplateContent']);
		CleanPost(); 
		$_POST['TemplateContent'] = $TemplateContent;
		/*******************/
		$objCommon->UpdateTemplateContent($_POST);
		//$_SESSION['mess'] =  $MSG[6];
		$_SESSION['mess_template'] =  "Email Template has been Updated Successfully.";
		header("location: email_template.php?cat=".$_GET['cat']);
		exit;
	}

if($_GET['cat'] >0){
	
	$arrayCat = $objCommon->GetTemplateCategory('');
	
	$arryTemplate = $objCommon->GetTemplateByCategory($_GET['cat']);
	
	$TemplateID=$arryTemplate[0]['TemplateID'];
	if(empty($TemplateID)){
		$TemplateID=10;
	}
	
}

			

	$arrayContents = $objCommon->GetTemplateContent($TemplateID,'');
	
            if ($arrayContents[0]['Status'] == 1) {
               $Status = 1;
            } else {
               $Status = 0;
            }

	$ToUserArray = array(1,7,8,9,14,13,10,11,17,18,19,20);
	$ToAdminArray = array(16,12,15);
	
	$ExpiryMailArray = array(17,18,20);

	$HideFromEmail='';
	if(in_array($_GET['cat'],$ToUserArray)){
		$HideToEmail = 'Style="display:none"';		
	}else if(in_array($_GET['cat'],$ToAdminArray)){
		$HideFromEmail = 'Style="display:none"';
	}


	require_once("includes/footer.php"); 
?>

