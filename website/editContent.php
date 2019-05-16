<?php 
	/**************************************************/
	$ThisPageName = 'viewContents.php'; $EditPage = 1;
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
                 $ArticleId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($ArticleId && !empty($ArticleId)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Page';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "viewContents.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($ArticleId)) 
                    {
                        $arryArticle = $webcmsObj->getArticleById($ArticleId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					$CategoriesArray = $webcmsObj->getCategories();
					$FormsArray = $webcmsObj->getForms();
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeArticleStatus($_REQUEST['active_id']);
					header("location:".$ListUrl);
				 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $webcmsObj->deleteArticle($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		

	$SubHeading = 'Page';
 	if (is_object($webcmsObj)) {	
		 
		 if ($_POST) {
		
						if (!empty($ArticleId)) {
								$_SESSION['mess_Page'] = $ModuleName.UPDATED;
															
								$webcmsObj->updateArticle($_POST);
								header("location:".$ListUrl);
						} else {		
								$_SESSION['mess_Page'] = $ModuleName.ADDED;
								$lastShipId = $webcmsObj->addArticle($_POST);	
							   header("location:".$ListUrl);
						}

						exit;
			
		}
		

	
	
		
		if($arryArticle[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
