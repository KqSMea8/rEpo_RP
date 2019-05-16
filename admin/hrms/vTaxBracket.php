<?php
	/**************************************************/
	$ThisPageName = 'viewTaxBracket.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/tax.class.php");
	$objTax=new tax();
	
	$ModuleName = "Tax Bracket";
	
	$RedirectUrl = "viewTaxBracket.php?y=".$_GET['y'];
	$EditUrl = "editTaxBracket.php?edit=".$_GET['view']."&y=".$_GET['y'];


	if($_GET['view']>0){
		$arryBracket = $objTax->getTaxBracket($_GET['view'],'');

		$arryBracketLine = $objTax->GetTaxBracketLine($_GET['view'],'');
		$NumLine = sizeof($arryBracketLine);

		

	}else{
		header("location:".$RedirectUrl);
		exit;
	}
	require_once("../includes/footer.php"); 
  ?>
