<?php

    /**************************************************/
    $ThisPageName = 'ErpManageCoupons.php'; $EditPage = 1; 
    /**************************************************/
    
include_once("includes/header.php");

require_once("../classes/erp.superAdminCms.class.php");
require_once("../classes/class.validation.php");
 

$erpsupercmsObj=new erpsupercms();
$id = isset($_GET['edit'])?$_GET['edit']:"";
 
if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
$ModuleName = 'Social Link';
$ListTitle  = 'Pages';
$ListUrl    = "ErpManageCoupons.php?curP=".$_GET['curP'];
 
 
if (!empty($id))
{
	$arryCoupon = $erpsupercmsObj->getCouponsById($id);
	
}

	
 
if(!empty($_GET['active_id'])){
	$_SESSION['mess_coupons'] = COUPONS_STATUS_CHANGED;
	$erpsupercmsObj->changeCouponsStatus($_GET['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['del_id'])){
	 
	$_SESSION['mess_coupons'] = COUPONS_REMOVED;
	$erpsupercmsObj->deleteCoupons($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}

 
		
    if (!empty($_POST)) {
        CleanPost();
        $data=array();

        $data=$_POST;
        //print_r($_POST);

        $_POST['Package']=implode(',', $_POST['Package']);	

        $errors=array();
        $validatedata=array(
        //'priority'=>array(array('rule'=>'notempty','message'=>'Please Enter The Priority')),
        //'uri'=>array(array('rule'=>'notempty','message'=>'Please Enter The UTI'))
        )	;
        $objVali->requestvalue=$data;
        $errors  =	$objVali->validate($validatedata);

        if(empty($errors)){

            if (!empty($id)) {
                    $_SESSION['mess_coupons'] = COUPONS_UPDATED;
                    $erpsupercmsObj->updateCoupons($_POST,$id);

                    header("location:".$ListUrl);
            } else {


                    $_SESSION['mess_coupons'] = COUPONS_ADDED;
                    $lastShipId = $erpsupercmsObj->addCoupons($_POST);

                    header("location:".$ListUrl);
            }
            exit;
        }
     

    if($arryPage[0]['Status'] == "No"){
            $PageStatus = "No";
    }else{
            $PageStatus = "Yes";
    }

}

require_once("includes/footer.php");
?>
