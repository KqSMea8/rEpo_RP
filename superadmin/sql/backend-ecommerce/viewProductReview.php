<?php
include_once("includes/header.php");
require_once("classes/product.class.php");

$productObj=new product();
 
if (is_object($productObj)) {
	$arryReviews=$productObj->getReviews($id,$status,$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$productObj->numRows();


}

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
