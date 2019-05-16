<?php

//$FancyBox=1;
/* * *********************************************** */
$ThisPageName = 'viewManageBin.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix . "classes/warehouse.class.php");


$objWarehouse = new warehouse();

$RedirectURL = "viewManageBin.php?curP=" . $_GET['curP'] . "&module=" . $_GET["module"];

if (empty($_GET['tab']))
    $_GET['tab'] = "Summary";

if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_lead'] = WAREHOUSE_REMOVE;
    $objWarehouse->RemoveBinLocation($_GET['del_id']);
    header("Location:" . $RedirectURL);
}
if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_lead'] = WAREHOUSE_STATUS;
    $objWarehouse->changeBinStatus($_GET['active_id']);
    header("Location:" . $RedirectURL);
}



if ($_POST) {

    if (!empty($_POST['binid'])) {
        $ImageId = $_POST['binid'];
        /*         * ************************ */
        $objWarehouse->UpdateBinLocation($_POST);
        $_SESSION['mess_warehouse'] = WAREHOUSE_UPDATED;

        /*         * ************************ */
    } else {
        //if($objWarehouse->isEmailExists($_POST['Email'],'')){
        //$_SESSION['mess_warehouse'] = $MSG[105];
        //}else{	
        $ImageId = $objWarehouse->AddBinLocation($_POST);
        $_SESSION['mess_warehouse'] = WAREHOUSE_ADDED;

        //}
    }
    if (!empty($_GET['edit'])) {
        header("Location:" . $RedirectURL);
        exit;
    } else {
        header("Location:" . $RedirectURL);
        exit;
    }
}


if ($_GET['edit'] > 0) {

    $arryBin = $objWarehouse->getBindata($_GET['edit']);
}

if ($arryBin[0]['status'] == 1): $Status = 1;
endif;


$warehouse_listted = $objWarehouse->AllWarehouses('');




require_once("../includes/footer.php");
?>


