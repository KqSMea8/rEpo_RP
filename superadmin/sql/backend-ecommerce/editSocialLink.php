<?php

/* * *********************************************** */
$ThisPageName = 'socialLinks.php';
$EditPage = 1;
/* * *********************************************** */

include_once("includes/header.php");

require_once( "classes/cartsettings.class.php");

(!$_GET['curP']) ? ($_GET['curP'] = 1) : (""); // current page number
if (class_exists(cms)) {
    $objcartsettings = new Cartsettings();
} else {
    echo "Class Not Found Error !! CMS Class Not Found !";
    exit;
}
$LinkId = isset($_REQUEST['edit']) ? $_REQUEST['edit'] : "";
if ($LinkId && !empty($LinkId)) {
    $ModuleTitle = "Edit Social Link";
} else {
    $ModuleTitle = "Add Social Link";
}
$ModuleName = 'Social Link ';
$ListTitle = 'Social Links';
$ListUrl = "socialLinks.php?curP=" . $_GET['curP'];


if (!empty($LinkId)) {
    $arrySocial = $objcartsettings->getSocialLinkById($LinkId);
}


$arrySocialMediaList = $objcartsettings->getSocialMediaList();

if (!empty($_GET['active_id'])) {


    $objcartsettings->changeSocialLinkStatus($_REQUEST['active_id']);
    $total = $objcartsettings->getActiveSocialLinks();
    $msg=STATUS;
    if ($total >= 5) {
       
        $msg= SOCIAL_ERR_MSG;
    }
    $_SESSION['mess_Page'] = $ModuleName . $msg;
    header("location:" . $ListUrl);
}


if (!empty($_GET['del_id'])) {

    $_SESSION['mess_Page'] = $ModuleName . REMOVED;
    $objcartsettings->deleteSocialLink($_GET['del_id']);
    header("location:" . $ListUrl);
    exit;
}


$SubHeading = 'Menu';
if (is_object($objcartsettings)) {

    if ($_POST) {


        if (!empty($LinkId)) {
            $total = $objcartsettings->getActiveSocialLinks();
            if ($total > 5) {
                $activemesg = " Only 5 social links active at a time.";
            }
            $_SESSION['mess_Page'] = $ModuleName . UPDATED . $activemesg;
            $objcartsettings->updateSocialLink($_POST);

            header("location:" . $ListUrl);
        } else {
           /* $total = $objcartsettings->getActiveSocialLinks();
            if ($total >= 5) {
                $activemesg = " Only 5 social links active at a time.";
            }*/
            $is_exist = $objcartsettings->CheckExistSocialLink($_POST['Social_media_id']);  
            if($is_exist){
              $_SESSION['mess_Page'] = $ModuleName . ADDED ;
              $lastShipId = $objcartsettings->addSocialLink($_POST);  
            }else{
               $_SESSION['mess_Page'] = $ModuleName . SOCIAL_ERR_MSG1 ; 
            }
            
            header("location:" . $ListUrl);
        }

        exit;
    }





    if ($arrySocial[0]['Status'] == "No") {
        $PageStatus = "No";
    } else {
        $PageStatus = "Yes";
    }
}



require_once("includes/footer.php");
?>
