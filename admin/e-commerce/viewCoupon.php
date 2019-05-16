<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/discount.class.php");
       
	  $ModuleTitle = "Coupon";
          $ModuleName = "Coupon";
	  $objDiscount = new discount();
          $ListUrl    = "viewCoupon.php?curP=".$_GET['curP'];
          
          if(!empty($_POST))
          {    
                $objDiscount->updatePromoSetting($_POST);
             
          }
         
        $arryCartSetting =  $objDiscount->getCartsettings();
        $settings = array();
         foreach($arryCartSetting as $field)
             {
                $settings[$field["Name"]] = $field["Value"];
             }

              
           
	 if (is_object($objDiscount)) {
	 	$arryCouponCodes=$objDiscount->getCouponCodes('','','','','');
		$num=$objDiscount->numRows();

              }
              
          
  
  require_once("../includes/footer.php");
  
?>
