<?php

/**************************************************/
$ThisPageName = 'viewTerritoryRule.php';
/**************************************************/

require_once("../includes/header.php");
require_once($Prefix."classes/territory.class.php");


$objTerritory=new territory();

(!$_GET['curP']) ? ($_GET['curP'] = 1) : (""); // current page number
$RedirectURL = "viewTerritoryRule.php?curP=" . $_GET['curP'] . "";
$ModuleName = "Territory Rule";

if(!empty($_GET['view'])){
		$arryTerritoryRule=$objTerritory->ListTerritoryRule($_GET['view'],'','','');		
		$TRID   = $arryTerritoryRule[0]['TRID'];	

		 //echo "<pre>";
                // print_r($arryTerritoryRule);
                // exit;


		if($TRID>0){
			$arryTerritoryRuleLocation = $objTerritory->GetTerritoryRuleLocation($TRID);
                        //echo "<pre>";
                        // print_r($arryTerritoryRuleLocation);
                        //exit;
			$NumLine = sizeof($arryTerritoryRuleLocation);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}




if (empty($NumLine))
    $NumLine = 1;

require_once("../includes/footer.php");
?>
