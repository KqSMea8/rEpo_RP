<?php
/**************************************************/
$ThisPageName = 'viewProductReview.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");
require_once("classes/product.class.php");

$productObj=new product();
 
$ModuleName = "Review";
$ListUrl    = "viewProductReview.php?curP=".$_GET['curP'];
if(!empty($_GET['active_id'])){
	$_SESSION['mess_Review'] = $ModuleName.STATUS;
	$productObj->changeReviewStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
	exit;
}


if(!empty($_GET['del_id'])){
	 
	$_SESSION['mess_Review'] = $ModuleName.REMOVED;
	$productObj->deleteReview($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}
require_once("includes/footer.php");


?>
