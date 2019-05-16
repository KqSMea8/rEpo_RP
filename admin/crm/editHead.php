<?php
 /**************************************************/
    $ThisPageName = 'viewHeads.php'; $EditPage = 1;
    /**************************************************/
	require_once("../includes/header.php");
	 require_once($Prefix."classes/field.class.php");
		 	$objField=new field();

	$RedirectUrl ="viewHeads.php?mod=".$_GET['mod'];

	$_GET['mod'] = (int)$_GET['mod'];
	$_GET['edit'] = (int)$_GET['edit'];

	if(empty($_GET['mod'])){
		header("location: viewHeads.php?mod=1");
		exit;
	}

	//$arryAttribute=$objField->AllAttributes($_GET['mod']);  
	$ModuleName = "Header";
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_mod'] = $ModuleName.$MSG[103];
		$objField->deleteField($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_mod'] = $ModuleName.$MSG[104];
		$objField->changeFieldStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
		/*******************/
		CleanPost(); 
		/*******************/
		//By chetan 28July//
		if($objField->isHeadExists($_POST['head_value'],$_POST['module']))
                {
                    $_SESSION['mess_mod'] = HD_ERROR;
                    header("location:editHead.php?mod=".$_GET['mod']);
                    exit;
                }
            //End//
		if (!empty($_POST['value_id'])) {
			$objField->updateHead($_POST);
			$_SESSION['mess_mod'] = $ModuleName.$MSG[102];
		} else {		
			$objField->addHead($_POST);
			$_SESSION['mess_mod'] = $ModuleName.$MSG[101];
		}
	
		$RedirectUrl ="viewHeads.php?mod=".$_POST['module'];
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objField->getHead($_GET['edit'],'','');
		
		if($arryAtt[0]['edittable']==0){
		$style='style="display:none"';
		}
		
		$attribute_value = stripslashes($arryAtt[0]['head_value']);
		$Status   = $arryAtt[0]['Status'];
	}




	 require_once("../includes/footer.php"); 
 
?>
