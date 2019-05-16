<?php
include_once("includes/header.php");
require_once("../classes/newsarticle.class.php");
$objNews = new news();

$ModuleName = "News  Category";

$arryNewsCategory=$objNews->ListNewsCategory($_GET);
$num=$objNews->numRows();

$pagerLink=$objPager->getPager($arryNewsCategory,$RecordsPerPage,$_GET['curP']);
(count($arryNewsCategory)>0)?($arryNewsCategory=$objPager->getPageRecords()):("");

require_once("includes/footer.php");
?>


