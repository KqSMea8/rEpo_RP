<?php 
 	include_once("includes/header.php");
	require_once("classes/discount.class.php");
        
         $ModuleTitle = "Global Discounts";
         $ModuleName = "Discounts";
         
	  $objDiscount = new discount();
          
           if(!empty($_POST))
            {
                $_SESSION['mess_discount'] = $ModuleName.UPDATED;
                $discountStatus = $objDiscount->updateDiscounts($_POST);
            }

            
                   $arryCartSetting =  $objDiscount->getCartsettings();
                    $settings = array();
                     foreach($arryCartSetting as $field)
                         {
                            $settings[$field["Name"]] = $field["Value"];
                         } 
          
	 if (is_object($objDiscount)) {
	 	$arryDiscount=$objDiscount->getDiscounts();
		$num=$objDiscount->numRows();

              }
              
        
              
              
          require_once("includes/footer.php");
  
?>
