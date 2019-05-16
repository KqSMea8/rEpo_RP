<?php 
/**************************************************/
if(isset($_GET['menu']))
{
    $ThisPageName = 'viewItem.php';
}else{

    $ThisPageName = 'viewCustomSearch.php';
}
//$EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
require_once($Prefix."classes/custom_search.class.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/inv_category.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix . "classes/bom.class.php");
require_once($Prefix."classes/inv.condition.class.php");
//ini_set('display_errors','1');
$csearch = new customsearch();
$objItems=new items();
$objTax = new tax();
$objCategory = new category();
$objCommon = new common();
$objbom  = new bom();
$objCondition=new condition();
$RedirectURL  =  "viewCustomSearch.php";
$numCheck=0;
//ini_set('display_errors',1);
		//error_reporting(E_ALL);
CleanPost();
CleanGet();
//echo "<pre/>";print_r($_SESSION);
$Viewdata = $csearch->GetSearchLists($_GET['view']);
$Viewdata = $Viewdata[0];
if(!empty($_SESSION['PostData'])  && (($_GET['view']!= $_SESSION['PostData']['search_ID']) || (!strstr($_SERVER['REQUEST_URI'],'curP'))))
{
	unset($_SESSION['PostData']);
	unset($_SESSION['CurrencyRealTimeRate']); //Added on 5Sept2017 by chetan//	
}
if((isset($_POST['go']) || isset($_SESSION['PostData']))){
   
    if(empty($_SESSION['PostData']))
    {
      $_SESSION['PostData'] =   $_POST;
      $postdata = $_POST;
    }
    elseif(isset($_POST['go'])){
	$_SESSION['PostData'] =   $_POST;
      	$postdata = $_POST;
    }else{
        $postdata   = $_SESSION['PostData'];
    } 
    
    $Config['RecordsPerPage'] = 8;//$RecordsPerPage;
    $resArray = $csearch->generateFilterRows($postdata);
    $num = count($resArray);   //updated 7Jan below remove//	
   	//update 10Mar2017 by chetan//		
    $alias = $csearch->isAlias();
    if(!$alias){		
	    $Config['GetNumRecords'] = 1;
	    $arryCount = $csearch->generateFilterRows($postdata);
	    $num=$arryCount[0]['NumCount'];
	    $Config['GetNumRecords'] = '';	
    }	
    //End//	
    $pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);//echo "<pre/>";print_r($arryCount);die;
    $Config['RecordsPerPage'] = '';	//Added by Chetan on 4Apr2017 //

    $fr = ($postdata['moduleID'] != '601') ? '3' : '1';
    if(!empty($resArray)){
        if(empty($postdata['displayCol']))
        {
            $clms = $csearch->getAllFldFrTableByModID($postdata['moduleID'],$fr);
        }else{
            $clms = $csearch->generateInputsByPostData($postdata['displayCol'],$postdata,$fr);//echo "<pre/>";print_r($clms);die;
        }
    }   
}else{
	unset($_SESSION['CurrencyRealTimeRate']); //Added on 5Sept2017 by chetan//
	unset($_SESSION['PostData']);
	$searchdata =  $csearch->generateInputsByPostData($Viewdata['columns'],$Viewdata,1);
	$_SESSION['searchdata'] = $searchdata;
}


require_once("../includes/footer.php"); 	

?>
