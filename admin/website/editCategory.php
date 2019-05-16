<?php 
	/**************************************************/
	$ThisPageName = 'viewCategories.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(cms)) {
	  	$webcmsObj=new webcms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $CatId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($CatId && !empty($CatId)) {$ModuleTitle = "Edit Category";}else{$ModuleTitle = "Add Category";}
                        $ModuleName = 'Category';
                        $ListTitle  = 'Categories';
                        $ListUrl    = "viewCategories.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($CatId)) 
                    {
                        $arryCategory = $webcmsObj->getCategoryById($CatId);
                    }

					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeCategoryStatus($_REQUEST['active_id']);
					header("location:".$ListUrl);
				 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $webcmsObj->deleteCategory($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		


 	if (is_object($webcmsObj)) {	
		 
		 if ($_POST) {
		
						if (!empty($CatId)) {
								$_SESSION['mess_Page'] = $ModuleName.UPDATED;

								$webcmsObj->updateCategory($_POST);
								header("location:".$ListUrl);
						} else {		
								$_SESSION['mess_Page'] = $ModuleName.ADDED;
								$lastShipId = $webcmsObj->addCategory($_POST);	
							   header("location:".$ListUrl);
						}

						exit;
			
		}
		

	
	
		
		if($arryCategory[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
