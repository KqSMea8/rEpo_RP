<?php
 /**************************************************/
    $ThisPageName = 'viewAttribute.php'; $EditPage = 1;
    /**************************************************/
	require_once("../includes/header.php");
	 require_once($Prefix."classes/crm.class.php");
		 	$objCommon=new common();
	$_GET['att'] = (int)$_GET['att'];
	$_GET['edit'] = (int)$_GET['edit'];
	$RedirectUrl ="viewAttribute.php?att=".$_GET['att'];

	if(empty($_GET['att'])){
		header("location: viewAttribute.php?att=1");
		exit;
	}

	$arryAttribute=$objCommon->AllAttributes($_GET['att']);  
	if($_GET['att']==17){
      $ModuleName = "Opportunity Type";
	}else{
	  $ModuleName = $arryAttribute[0]["attribute"];
	}
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[103];
		$objCommon->deleteAttribute($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[104];
		$objCommon->changeAttributeStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	
	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['value_id'])) {
			$objCommon->updateAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[102];
		} else {		
			$objCommon->addAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[101];
		}
	
		$RedirectUrl ="viewAttribute.php?att=".$_POST['attribute_id'];
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objCommon->getAttribute($_GET['edit'],'','');
        $PageHeading = 'Edit '.$ModuleName.' for '.stripslashes($arryAtt[0]['attribute_value']);
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
	}


	 require_once("../includes/footer.php"); 
 
?>
