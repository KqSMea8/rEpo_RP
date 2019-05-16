<?php

/* * *********************************************** */
$ThisPageName = 'viewCustomSearch.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix . "classes/custom_search.class.php");
//require_once($Prefix . "classes/field.class.php");


$ModuleName = "CustomSearch";
$RedirectURL = "viewCustomSearch.php?curP=" . $_GET['curP'];

$csearch = new customsearch();
//$field   =   new field();

if($_GET['edit'])
{
    CleanGet();
    $editData =  $csearch->GetSearchLists($_GET['edit']);
    $editData =  $editData[0];

    //echo "<pre/>";print_r($editData);
}


require_once("../includes/footer.php");

?>
