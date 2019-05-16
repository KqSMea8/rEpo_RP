<?php 
include_once("../includes/header.php");
require_once($Prefix."classes/custom_search.class.php");
require_once($Prefix."classes/admin.class.php");
        //require_once($Prefix."classes/employee.class.php");
       //require_once($Prefix."classes/crm.class.php");

$objSearch = new customsearch();
$objadmin  = new admin();
$RedirectURL = "viewCustomSearch.php?curP=" . $_GET['curP'];
(empty($_GET['Del_ID'])) ? ($_GET['Del_ID']='') : (""); 

if ($_GET['Del_ID']!=0){
        $Del_ID = $_GET['Del_ID'];
        $delete = $objSearch->deleteSearchList($Del_ID);
        header('Location:'.$RedirectURL);

}

$searchLists = $objSearch->GetSearchLists();
$Config['GetNumRecords'] = 1;
$arryCount = $objSearch->GetSearchLists();
$num = $arryCount[0]['NumCount'];	//print_r($arryCount);
$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);

require_once("../includes/footer.php"); 	
?>
