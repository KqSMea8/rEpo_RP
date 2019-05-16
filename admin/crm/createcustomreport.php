<?php

/* * *********************************************** */
$ThisPageName = 'viewCustomReports.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix . "classes/custom_reports.class.php");
require_once($Prefix . "classes/field.class.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/sales.customer.class.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix . "classes/region.class.php");


$ModuleName = "CustomReports";
$RedirectURL = "viewCustomReports.php?curP=" . $_GET['curP'];
$EditURL = "editCustomReports.php";

$creport = new customreports();
$objLead = new lead();
$objCustomer = new Customer();
$objItems=new items();
$GLOBALS['useMainDB'] = $Config;
$objregion  = new region(); 


if($_POST)
{       
        if($_POST['report_name'] != '' || $_POST['report_desc'] != '' || $_POST['moduleID'] != '' || $_POST['selectclms'] != '')
        {

                if(isset($_POST['Save']))
                {
                   
                     if(!empty($_POST['report_ID']))
                    {

                         $_SESSION['post']   =   $_POST;
			 $_SESSION['message'] = CR_UPDATE_ERROR;
                         $reportdata =  $creport->saveReportData($_POST);
                         header('Location:'.$RedirectURL);exit;
                    }else{
                    
			$_SESSION['message'] = CR_SAVE_ERROR;
                        $savereportdata = $creport->saveReportData($_POST);
                        header('LOCATION:'.$RedirectURL);exit;
                    }    

                }else{

                    $_SESSION['post']   =   $_POST;
                    $reportdata =  $creport->generateReportData($_POST);
                            //echo "<pre/>";print_r($reportdata);
                }
 
        }else{
            $_SESSION['mesg_report'] = 'Fill all required fields';
            header('Location:'.$EditURL);
        }
    
}







require_once("../includes/footer.php");

?>
