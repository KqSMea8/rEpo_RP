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

$EditUrl = "editAdjustment.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "";


if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_territory'] = TERRITORY_RULE_REMOVE;
		$objTerritory->RemoveTerritoryRule($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}

if(!empty($_POST)){
        $TRID = $objTerritory->addTerritoryRule($_POST);
        $_SESSION['mess_territory'] = ADD_TERRITORY_RULE;
        $objTerritory->addTerritoryRuleLocation($TRID, $_POST); 

        header("Location:".$RedirectURL);
        exit;
}




if (empty($NumLine))
    $NumLine = 1;

require_once("../includes/footer.php");
?>
