<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/rma.sales.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
#include_once("language/en_lead.php");

$ModuleName = "RMA Form";
$objRmaSale = new rmasale();
$objFilter = new filter();
$objGroup = new group();

$RedirectUrl = "viewCreateRMA.php?curP=" . $_GET['curP'];


/*********************Set Defult ************/

    
    unset($_SESSION['msg_lead_form']);
    
   
   $arryLeadForm = $objRmaSale->ListCreateRMA($_GET);


$num = $objRmaSale->numRows();

$pagerLink = $objPager->getPager($arryLeadForm, $RecordsPerPage, $_GET['curP']);
(count($arryLeadForm) > 0) ? ($arryLeadForm = $objPager->getPageRecords()) : ("");



/* * ******************************************** */






require_once("../includes/footer.php");
?>
