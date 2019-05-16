<?php 
	/**************************************************/
	$ThisPageName = 'viewCustomer.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
 		$webcmsObj=new webcms();
                 $MenuId = isset($_GET['edit'])?$_GET['edit']:"";	
                 $CustomerID=  $_GET['CustomerID'];
                 
                  if ($MenuId && !empty($MenuId)) {$ModuleTitle = "Edit Menu";}else{$ModuleTitle = "Add Menu";}
                        $ModuleName = 'Menu';
                        $ListTitle  = 'Menus';
                        $ListUrl    = "viewMenus.php?curP=".$_GET['curP']."&CustomerID=".$CustomerID;
                       
               
                    if (!empty($MenuId)) 
                    {
                        $arryMenu = $webcmsObj->getMenuById($MenuId);
                    }else{
				$arryMenu = $objConfigure->GetDefaultArrayValue('web_menus');
			}
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
					
					
					$MenutypeArr = $webcmsObj->getMenutype();					
					$ArticlesArray= $webcmsObj->getArticles($CustomerID);		
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeMenuStatus($_GET['active_id']);
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
		

	
	
		
		if(isset($arryMenu[0]['Status']) && $arryMenu[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
