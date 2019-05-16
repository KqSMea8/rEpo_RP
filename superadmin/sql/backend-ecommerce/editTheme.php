<?php 
	/**************************************************/
	$ThisPageName = 'viewMenus.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("includes/header.php");
         
	require_once("classes/theme.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(theme)) {
	  	$themeObj=new theme();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $ThemeId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($ThemeId && !empty($ThemeId)) {$ModuleTitle = "Edit Menu";}else{$ModuleTitle = "Add Menu";}
                        $ModuleName = 'Menu ';
                        $ListTitle  = 'Menus';
                        $ListUrl    = "themes.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($ThemeId)) 
                    {
                        $arryTheme = $themeObj->getThemeById($ThemeId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
					
					
					$WidgetsArray = $themeObj->GetWidgets();					
					$PagesArray = $themeObj->GetPagesByThemeId($ThemeId);
					 
                 	

	 if(!empty($_GET['del_id'])){
             
	 	$_SESSION['mess_Page'] = $ModuleName.REMOVED;
	 	$themeObj->deleteTheme($_GET['del_id']);
	 	header("location:".$ListUrl);
	 	exit;
	}
		

	$SubHeading = 'Menu';
 	if (is_object($themeObj)) {	
		 
		 if ($_POST) {
		
	 					
			
		}
		

	
	
		
		if($arryMenu[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("includes/footer.php"); 
 
 
 ?>
