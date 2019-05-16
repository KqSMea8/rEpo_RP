<?php
/**************************************************/
           $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/cartsettings.class.php");
	
	$objcartsettings=new Cartsettings();
	
         $groupId = isset($_GET['module'])?intval($_GET['module']):0;
	/**************/
	$ModuleArray = array('1','2','3'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/
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



 require_once("../includes/footer.php"); 
 
 
 ?>
