<?php
	/**************************************************/
	$ThisPageName = 'viewCoupon.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
        require_once($Prefix."classes/category.class.php");
	require_once($Prefix."classes/discount.class.php");
        require_once($Prefix."classes/customer.class.php");
	
        $objCategory=new category();   
        $objDiscount = new discount();
        
        
                    $q = isset($_GET['q'])?$_GET['q']:"";	
                    $promoID = isset($_GET['promoID'])?$_GET['promoID']:"";
                    
                    $ModuleTitle = "Coupon";
                    $ModuleName = "Coupon";

                    $ListUrl    = "viewCoupon.php?curP=".$_GET['curP'];
                      
		    $arrayCustGroupID = array();
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
			exit;
                    }
	

                    if(!empty($_GET['del_id'])){
                        $_SESSION['mess_coupon'] = $ModuleName.REMOVED;
                        $objDiscount->deleteCoupon($_GET['del_id']);
                        header("location:".$ListUrl);
                        exit;
                    }
		

		 if (!empty($_POST)) {
                     
                     if(!empty($_POST['promoID']) && $_POST['actionPromo'] == "product")
                     {
                         
                           $_SESSION['mess_coupon'] = $ModuleName.ADDED;
                           $objDiscount->addCouponProductCategory($_POST);	
                           $ListUrl    = "viewCoupon.php?curP=".$_GET['curP'];
                                 
                         
                     }else{
                         
                            if (!empty($promoID)) {
                               
                                    $_SESSION['mess_coupon'] = $ModuleName.UPDATED;
                                    $objDiscount->updateCouponCode($_POST);
                                    header("location:".$ListUrl);
				    exit;
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
           

   $objCustomer = new Customer();
   $arryCustomerGroups =$objCustomer->getCustomerGroups();

 require_once("../includes/footer.php"); 
 
 
 ?>
