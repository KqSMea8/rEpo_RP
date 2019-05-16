<?php 
	/**************************************************/
	$ThisPageName = 'viewPages.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("includes/header.php");
         
	require_once("classes/cms.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(cms)) {
	  	$cmsObj=new cms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $PageId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($PageId && !empty($PageId)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Page';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "viewPages.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($PageId)) 
                    {
                        $arryPage = $cmsObj->getPageById($PageId);
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_Page'] = $ModuleName.STATUS;
		$cmsObj->changePageStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $cmsObj->deletePage($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		


 	if (is_object($cmsObj)) {	
		 
		 if ($_POST) {
		
                                            if (!empty($PageId)) {
                                                    $_SESSION['mess_Page'] = $ModuleName.UPDATED;
                                                    $cmsObj->updatePage($_POST);
                                                    header("location:".$ListUrl);
                                            } else {		
                                                    $_SESSION['mess_Page'] = $ModuleName.ADDED;
                                                    $lastShipId = $cmsObj->addPage($_POST);	
                                                   header("location:".$ListUrl);
                                            }

                                            exit;
			
		}
		

	
	
		
		if($arryPage[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}



 require_once("includes/footer.php"); 
 
 
 ?>