<?php
/**************************************************/
$ThisPageName = 'viewCoupon.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");
require_once("classes/category.class.php");
require_once("classes/discount.class.php");
require_once("classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number

if (class_exists(category)) {
	$objCategory=new category();
} else {
	echo "Class Not Found Error !! Category Class Not Found !";
	exit;
}

if (class_exists(discount)) {
	$objDiscount = new discount();
} else {
	echo "Class Not Found Error !! Discount Class Not Found !";
	exit;
}

$q = isset($_REQUEST['q'])?$_REQUEST['q']:"";
$promoID = isset($_REQUEST['promoID'])?$_REQUEST['promoID']:"";

$ModuleTitle = "Coupon";
$ModuleName = "Coupon";

$ListUrl    = "viewCoupon.php?curP=".$_GET['curP'];

if(!empty($promoID)){
	$arrayCoupon =  $objDiscount->getCouponCodeByID($promoID);
	$CustomerGroupID = $arrayCoupon[0]['CustomerGroupID'];
	$CustomerGroupID = explode(",",$CustomerGroupID);
	foreach($CustomerGroupID as $grpID)
	{
		$arrayCustGroupID[] = $grpID;
	}
	 
}
 
 
if(!empty($_GET['active_id'])){
	$_SESSION['mess_coupon'] = $ModuleName.STATUS;
	$objDiscount->changeCouponStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['del_id'])){

	$_SESSION['mess_coupon'] = $ModuleName.REMOVED;
	$objDiscount->deleteCoupon($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}



if (is_object($objDiscount)) {
	if (!empty($_POST)) {
		 
		if($_POST['promoID'] != "" && $_POST['actionPromo'] == "product")
		{
			 
			$_SESSION['mess_coupon'] = $ModuleName.ADDED;
			$objDiscount->addCouponProductCategory($_POST);
			$ListUrl    = "viewCoupon.php?curP=".$_GET['curP'];
			 
			 
		}else{
			 
			if (!empty($promoID)) {
				 
				$_SESSION['mess_coupon'] = $ModuleName.UPDATED;
				$objDiscount->updateCouponCode($_POST);
				header("location:".$ListUrl);
			} else {
				$_SESSION['mess_coupon'] = $ModuleName.ADDED;
				$prmoID = $objDiscount->addCouponCode($_POST);
				if($_POST['PromoType'] == "Product")
				{
					$ListUrl    = "editCoupon.php?promoID=".$prmoID;
				}else{
					$ListUrl    = "viewCoupon.php?curP=".$_GET['curP'];
				}
			}
			 
			 

		}
		 
		header("location:".$ListUrl);
		exit;
	}
}

$objCustomer = new Customer();
$arryCustomerGroups =$objCustomer->getCustomerGroups();

require_once("includes/footer.php");


?>
