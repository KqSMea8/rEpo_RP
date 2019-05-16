<?php 
	/**************************************************/
	$ThisPageName = 'viewMenus.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
    if (class_exists('cms')) {
	  	$webcmsObj=new webcms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $MenuId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($MenuId && !empty($MenuId)) {$ModuleTitle = "Edit Menu";}else{$ModuleTitle = "Add Menu";}
                        $ModuleName = 'Menu ';
                        $ListTitle  = 'Menus';
                        $ListUrl    = "viewMenus.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($MenuId)) 
                    {
                        $arryMenu = $webcmsObj->getMenuById($MenuId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
					
					
					$MenutypeArr = $webcmsObj->getMenutype();					
					$ArticlesArray= $webcmsObj->getArticles();		
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeMenuStatus($_REQUEST['active_id']);
					header("location:".$ListUrl);
				 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $webcmsObj->deleteMenu($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		

	$SubHeading = 'Menu';
 	if (is_object($webcmsObj)) {	
		 
		 if ($_POST) {
		
	 					$postArray=$_POST;
							if( !empty($postArray['Alias']) ){
							  $postArray['Alias']=str_replace(" ","_",strtolower(trim($postArray['Alias']))); 
							}
							else{
							 $postArray['Alias']=str_replace(" ","_",strtolower($postArray['Name'])); 
							}
								
						if (!empty($MenuId)) {
								
								if($webcmsObj->validateAlias($postArray)){
								 	$_SESSION['mess_Page'] = $ModuleName.UPDATED;					
									$webcmsObj->updateMenu($postArray);
									
								}else{
									$_SESSION['mess_Page'] = $ModuleName.ALIASEXIST;		
								}
								
								
								
								header("location:".$ListUrl);
								
						} else {		
								$_SESSION['mess_Page'] = $ModuleName.ADDED;
								$lastShipId = $webcmsObj->addMenu($postArray);	
							   header("location:".$ListUrl);
						}

						exit;
			
		}
		

	
	
		
		if(!empty($arryMenu) && $arryMenu[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
