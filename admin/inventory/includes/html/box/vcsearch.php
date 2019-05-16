<?php 
/**************************************************/
if(isset($_GET['menu']))
{
    $ThisPageName = 'vcsearch.php?view='.$_GET['view'].'&menu=1&tab=look';
}else{

    $ThisPageName = 'viewCustomSearch.php';
}
$EditPage = 1;
/************************************************* */

include_once("../includes/header.php");
require_once($Prefix."classes/custom_search.class.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix . "classes/inv.class.php");
require_once($Prefix . "classes/inv_tax.class.php");
require_once($Prefix . "classes/inv_category.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix . "classes/bom.class.php");
//ini_set('display_errors','1');
$csearch = new customsearch();
$objItems=new items();
$objTax = new tax();
$objCategory = new category();
$objCommon = new common();
$objbom  = new bom();
$RedirectURL  =  "viewCustomSearch.php";

CleanPost();
CleanGet();
if(!empty($_SESSION['PostData'])  && (($_GET['view']!= $_SESSION['PostData']['search_ID']) || (!strstr($_SERVER['REQUEST_URI'],'curP'))))
{
  unset($_SESSION['PostData']);
}
if((isset($_POST['go']) || $_SESSION['PostData'])){
   
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
    $pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);//echo "<pre/>";print_r($arryCount);die;
    
    $fr = ($postdata['moduleID'] != '601') ? '3' : '1';
    if(!empty($resArray)){
        if(empty($postdata['displayCol']))
        {
            $clms = $csearch->getAllFldFrTableByModID($postdata['moduleID'],$fr);//
        }else{
            $clms = $csearch->generateInputsByPostData($postdata['displayCol'],$postdata,$fr);//echo "<pre/>";print_r($clms);die;
        }
    }   
}else{



unset($_SESSION['PostData']);
$Viewdata = $csearch->GetSearchLists($_GET['view']);
$Viewdata = $Viewdata[0];
$searchdata =  $csearch->generateInputsByPostData($Viewdata['columns'],$Viewdata,1);

}


require_once("../includes/footer.php"); 	

?>
