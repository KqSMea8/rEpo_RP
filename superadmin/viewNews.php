<?php
include_once("includes/header.php");
require_once("../classes/newsarticle.class.php");
include_once("includes/FieldArray.php");

$ModuleName = "News";
$objNews=new news();

$arrayCatName=$objNews->GetCatName();
$arryNews=$objNews->ListNews($_GET);
$num=$objNews->numRows();

$pagerLink=$objPager->getPager($arryNews,$RecordsPerPage,$_GET['curP']);
(count($arryNews)>0)?($arryNews=$objPager->getPageRecords()):("");

require_once("includes/footer.php");
?>

