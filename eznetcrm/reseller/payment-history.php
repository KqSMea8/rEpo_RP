<?php
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

ValidateCrmSession();
require_once("../../classes/cmp.class.php");
$objCmp=new cmp();
$CmpId=$_SESSION['CrmAdminID'];
$arrayOrder=$objCmp->getOrderByCmpId($CmpId);
$num=$objCmp->numRows();
//print_r($arrayOrder);

include ('includes/footer.php');
?>	