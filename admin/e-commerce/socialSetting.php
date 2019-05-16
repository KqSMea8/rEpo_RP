<?php
 	include_once("../includes/header.php");
	require_once($Prefix."classes/cartsettings.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(cartsettings)) {
	  	$objcartsettings = new Cartsettings();
	} else {
  		echo "Class Not Found Error !! Cart Settings Class Not Found !";
		exit;
  	}
	
                $ModuleName = 'Social Sharing';
                $ListUrl = "socialSetting.php";
         
                    
                    $arryCartSetting = $objcartsettings->getCartsettings();

 	if (is_object($objcartsettings)) {	
		 
		 if ($_POST) {
		                                                 
                        $_SESSION['mess_cart'] = $ModuleName.$MSG[102];
                        $objcartsettings->updateSocialsettings($_POST);

                        header("location:".$ListUrl);
                        exit;
			
		}
		
}



 require_once("../includes/footer.php"); 
 
 
 ?>
