<?php
/**************************************************/
$ThisPageName = 'viewNewsCategory.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");
require_once("../classes/newsarticle.class.php");
$objNews = new news();
$ModuleName = "News  Category";
$RedirectURL = "viewNewsCategory.php?curP=".$_GET['curP'];

if($_GET['del_id'] && !empty($_GET['del_id'])){
	$_SESSION['mess_news'] = NCAT_REMOVED;
	$objNews->RemoveNewsCategory($_GET['del_id']);
	header("Location:".$RedirectURL);
	exit;
}

if($_GET['active_id'] && !empty($_GET['active_id'])){
	$_SESSION['mess_news'] = NCAT_STATUS_CHANGED;
	$objNews->changeNewsCategoryStatus($_GET['active_id']);
	header("Location:".$RedirectURL);
	exit;
}

if($_POST){
	CleanPost();
	if (empty($_POST['NewsCategoryName'])) {
		$errMsg = ENTER_CATEGORY;
	} else {
		if (!empty($_POST['CategoryID'])) {
			$CategoryID = $_POST['CategoryID'];
			$objNews->UpdateNewsCategory($_POST);
			$_SESSION['mess_news'] = NCAT_UPDATED;
		} else {
			$CategoryID = $objNews->AddNewsCategory($_POST);
			$_SESSION['mess_news'] = NCAT_ADDED;
		}
		header("Location:".$RedirectURL);
		exit;
			
	}
}
$Status = 1;
if(!empty($_GET['edit'])){
	$arryNewsCategory = $objNews->GetNewsCategory($_GET['edit'],'');
	$CategoryID   = $_GET['edit'];
	$Status = $arryNewsCategory[0]['Status'];
}
require_once("includes/footer.php");
?>
