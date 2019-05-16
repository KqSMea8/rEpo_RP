<?php 

require_once("includes/header.php"); 
include_once("includes/header_menu.php");
CleanGet();
require_once("classes/company.class.php");
$objCompany=new company();

   $url = $_GET["url"];
    if(!empty($url)){
        $urlMd5 = md5($url);
        $arryPageId=$cmsObj->getPageIdByHash($urlMd5);
    }
  
 
   if(!empty($arryPageId[0]['PageId'])){$pageId = $arryPageId[0]['PageId'];}else{$pageId = $_GET['page_id'];}
  
    if(!empty($pageId) && is_numeric($pageId))
    {
      $arryPage=$cmsObj->getPageById($pageId);
      $num=$cmsObj->numRows();
    }

require_once("includes/footer.php"); 
 ?>


