<?php
/**************************************************/
           $EditPage = 1;
	/**************************************************/
 	include_once("includes/header.php");
	require_once("classes/cartsettings.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(cartsettings)) {
	  	$objcartsettings=new Cartsettings();
	} else {
  		echo "Class Not Found Error !! Cart Settings Class Not Found !";
		exit;
  	}
	
         $groupId = isset($_GET['module'])?intval($_GET['module']):0;
          if($groupId == "3")
          {
                $ModuleName = 'Bestseller Settings';
                $ListUrl = "cartSetting.php?module=3";
                
          }else if($groupId == "1")
          {
                $ModuleName = 'Store Settings';
                $ListUrl = "cartSetting.php?module=1";
                
          }else if($groupId == "2")
          {
                $ModuleName = 'Social Settings';
                $ListUrl = "cartSetting.php?module=2";
                
          }else {
                $ModuleName = 'Store Settings';
                $ListUrl = "cartSetting.php";
             }
             
         //Update Default Store Name And Email
        
          $storenumRow = $objcartsettings->checkStoreFiled();
        
          if($storenumRow > 0)
          {
               global $Config;
               $arrayFields = array();
               $arrayFields['StoreName'] = $Config['SiteName'];
               $arrayFields['CompanyEmail'] = $Config['AdminEmail'];
               $objcartsettings->updateCartSettingsFields($arrayFields);
               
          }
         
        //End
             
         $arryCartSettingFields = $objcartsettings->getCartSettingsFields($groupId);
         $arrydomain = $objcartsettings->getDomain();
         

     
 	if (is_object($objcartsettings)) {	
		 
		 if(!empty($_POST)){
		                                   
                            $_SESSION['mess_cart'] = $ModuleName.$MSG[102];
                            $objcartsettings->updateCartSettingsFields($_POST);
                            
                            
							
                            header("location:".$ListUrl);
                            exit;
			
		}
		
}



 require_once("includes/footer.php"); 
 
 
 ?>
