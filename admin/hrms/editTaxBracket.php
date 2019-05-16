<?php
	/**************************************************/
	$ThisPageName = 'viewTaxBracket.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();
	
	$ModuleName = "Bracket";
	
	$RedirectUrl = "viewTaxBracket.php?y=".$_GET['y'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_bracket'] = TAX_BRK_REMOVED;
		$objTax->deleteTaxBracket($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	

	if($_POST) {
		CleanPost(); 
		$RedirectUrl = "viewTaxBracket.php?y=".$_POST['Year'];

		if(!empty($_POST['bracketID'])) {
			$objTax->updateTaxBracket($_POST);
			$_SESSION['mess_bracket'] = TAX_BRK_UPDATED;
		}else{		
			$_POST['bracketID'] = $objTax->addTaxBracket($_POST);
			$_SESSION['mess_bracket'] = TAX_BRK_ADDED;
		}

		$objTax->AddUpdateTaxBracketLine($_POST['bracketID'],$_POST); 
		
		header("location:".$RedirectUrl);
		exit;
	}

	if(empty($_GET['y'])) $_GET['y'] = date('Y');

	if($_GET['edit']>0){
		$arryBracket = $objTax->getTaxBracket($_GET['edit'],'');

		$arryBracketLine = $objTax->GetTaxBracketLine($_GET['edit'],'');
		$NumLine = sizeof($arryBracketLine);

	}else{
		$arryBracketLine = $objConfigure->GetDefaultArrayValue('h_tax_bracket_line'); 

		if(empty($_GET['y'])){
			 $_GET['y'] = date('Y'); 
		}
		$arryBracket[0]['Year'] = $_GET['y'];
		$NumLine='';
	}
 

	$arryPayPeriod=$objTax->getPayPeriod('','1');

	require_once("../includes/footer.php"); 
  ?>
