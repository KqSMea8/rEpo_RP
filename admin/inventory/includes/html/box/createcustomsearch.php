<?php

/**************************************************/
$ThisPageName = 'viewCustomSearch.php';
$EditPage = 1;

/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/custom_search.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/inv_category.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix . "classes/bom.class.php");

$ModuleName = "CustomSearch";
$RedirectURL = "viewCustomSearch.php";
$EditURL = "editCustomsearch.php";

$csearch = new customsearch();
$objItems=new items();
$objTax = new tax();
$objCategory = new category();
$objCommon = new common();
$objbom  = new bom();

CleanPost();
 
if($_POST['Submit'] == 'Generate Search')
{
    if($_POST['search_name'] == '' || $_POST['moduleID'] == '' || $_POST['columns'] == '')
    {       
        $_SESSION['mesg_report'] = 'Fill all required fields';
        header('Location:'.$EditURL);
    }

    if(is_array($_POST['checkboxes']))
    {
        $_POST['checkboxes'] =  implode(',',$_POST['checkboxes']);
    }else{
        $_POST['checkboxes'] =  $_POST['checkboxes'];
    }
 
    $_POST['purduration'] = '';
    $_POST['saleduration'] = '';
    if($_POST['saleMon'] || $_POST['saleDay'] || $_POST['saleYr'])
    {
        $_POST['saleduration'] = $_POST['saleMon'].','.$_POST['saleDay'].','.$_POST['saleYr'];
    }
    if($_POST['purMon'] || $_POST['purDay'] || $_POST['purYr'])
    {
        $_POST['purduration'] = $_POST['purMon'].','.$_POST['purDay'].','.$_POST['purYr'];
    }
    $postdata = $_POST;
    $searchdata =  $csearch->generateInputsByPostData($_POST['columns'],$_POST,1);//print_r($searchdata);die;
}


if($_POST['go'] || $_SESSION['PostData'] || $_POST['Save'])
{     
        if((isset($_POST['go']) || $_SESSION['PostData']) && (!isset($_POST['Save'])))
        {    
            if(empty($_SESSION['PostData']))
            {
                $_SESSION['PostData'] =   $_POST;
                $postdata = $_POST;
            }else{
                $postdata   = $_SESSION['PostData'];
            }   
               
              $Config['RecordsPerPage'] = $RecordsPerPage;
              $resArray = $csearch->generateFilterRows($postdata);

              $Config['GetNumRecords'] = 1;
              $arryCount = $csearch->generateFilterRows($postdata);
              $num=$arryCount[0]['NumCount'];	
              $pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);


              $fr = ($postdata['moduleID'] != '601') ? '3' : '1';
              if(empty($postdata['displayCol']))
              {
                  $clms = $csearch->getAllFldFrTableByModID($postdata['moduleID'],$fr);//
              }else{
                  $clms = $csearch->generateInputsByPostData($postdata['displayCol'],$postdata,$fr);//echo "<pre/>";print_r($clms); die;
              }   


        }
    
        if(isset($_POST['Save']))
        {
            if(!empty($_POST['search_ID']))
            {
                 $_SESSION['message'] = CS_UPDATE_ERROR;
                 $Searchdata =  $csearch->saveSearchData($_POST);
                 header('Location:'.$RedirectURL);exit;
            }else{

                $_SESSION['message'] = CS_SAVE_ERROR;
                $Searchdata = $csearch->saveSearchData($_POST);
                header('LOCATION:'.$RedirectURL);exit;
            }    

        }
        
}






require_once("../includes/footer.php");

?>

