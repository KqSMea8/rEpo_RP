<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("language/en_lead.php");

$ModuleName = "Lead Form";
$objLead = new lead();
$objFilter = new filter();
$objGroup = new group();

$RedirectUrl = "viewCreateLead.php?curP=" . $_GET['curP'];


/*********************Set Defult ************/

    
    unset($_SESSION['msg_lead_form']);
    
//$Config['']
   $_GET['FormType'] = 'Lead';
   $arryLeadForm = $objLead->ListCreateLead($_GET);


$num = $objLead->numRows();

$pagerLink = $objPager->getPager($arryLeadForm, $RecordsPerPage, $_GET['curP']);
(count($arryLeadForm) > 0) ? ($arryLeadForm = $objPager->getPageRecords()) : ("");



/* * ******************************************** */






require_once("../includes/footer.php");
?>
