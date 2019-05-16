<?php 
	/**************************************************/
	$ThisPageName = 'viewMenus.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/theme.class.php");
	
	 $themeObj=new theme();

                 $ThemeId = isset($_GET['edit'])?$_GET['edit']:"";	
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
 
	 
	
		if(isset($arryMenu)){	
		if($arryMenu[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}}
                
                              
 


 require_once("../includes/footer.php"); 
 
 
 ?>
