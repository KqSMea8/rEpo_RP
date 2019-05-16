<?php 
	/**************************************************/
	$ThisPageName = 'viewCustomer.php'; $EditPage = 1;  //$SetFullPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	 $webcmsObj=new webcms();
                 $ArticleId = isset($_GET['edit'])?$_GET['edit']:"";	
                  $CustomerID=  $_GET['CustomerID'];
                  if ($ArticleId && !empty($ArticleId)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Page';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "viewContents.php?curP=".$_GET['curP']."&CustomerID=".$CustomerID;
                       
               
                    if (!empty($ArticleId)) 
                    {
                        $arryArticle = $webcmsObj->getArticleById($ArticleId);
                    }else{
				$arryArticle = $objConfigure->GetDefaultArrayValue('web_articles');
			}
					
					
					/****************Create Tree Array for Menu****************/
					$CategoriesArray = $webcmsObj->getCategories();
					$FormsArray = $webcmsObj->getForms($CustomerID);
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeArticleStatus($_GET['active_id']);
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
		

	
	
		
		if(!empty($arryArticle) && $arryArticle[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
