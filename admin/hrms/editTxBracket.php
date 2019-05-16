<?php
	/**************************************************/
	$ThisPageName = 'viewTaxBracket.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	
	$ModuleName = "Bracket";
	
	$RedirectUrl = "viewTaxBracket.php?y=".$_GET['y'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_bracket'] = TAX_BRK_REMOVED;
		$objCommon->deleteTaxBracket($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	

	if($_POST) {
		CleanPost(); 
		$RedirectUrl = "viewTaxBracket.php?y=".$_POST['Year'];

		for($i=1;$i<=5;$i++){
			$_POST['Filing'.$i] = 	$_POST['From'.$i].'#'.$_POST['To'.$i];
		}


		if(!empty($_POST['bracketID'])) {
			$objCommon->updateTaxBracket($_POST);
			$_SESSION['mess_bracket'] = TAX_BRK_UPDATED;
		}else{		
			$objCommon->addTaxBracket($_POST);
			$_SESSION['mess_bracket'] = TAX_BRK_ADDED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}

	if(empty($_GET['y'])) $_GET['y'] = date('Y');

	if($_GET['edit']>0){
		$arryBracket = $objCommon->getTaxBracket($_GET['edit'],'');
	}else{
		if(empty($_GET['y'])){
			 $_GET['y'] = date('Y'); 
		}
		$arryBracket[0]['Year'] = $_GET['y'];
	}
 
	$arryFiling=$objCommon->getFiling('','1');

	require_once("../includes/footer.php"); 
  ?>
