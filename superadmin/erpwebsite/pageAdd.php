<?php 
    /**************************************************/
    $ThisPageName = 'pageList.php'; $EditPage = 1; 
    /**************************************************/

	include_once("includes/header.php");

require_once("../../classes/erp.superAdminCms.class.php");
require_once("../../classes/class.validation.php");
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(supercms)) {
	  	$supercms=new supercms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
  CleanGet();	
$dir = "meeting-template";
$dh  = opendir($dir);
$files[]='default';
while (false !== ($filename = readdir($dh))) {
if (strpos($filename,'template') !== false) {
    $files[$filename] = $filename;
}

}
//print_r($files);
                 $id = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Page';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "pageList.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                        $arryPage = $supercms->getPageById($id);
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_pg'] = PAGE_STATUS_CHANGED;
		$supercms->changePageStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_pg'] = PAGE_REMOVED;
                                $supercms->deletePage($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		


 	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		
		 		$data=array();

	$data=$_POST;
	$errors=array();
	$validatedata=array(	
		'Name'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Name')),
		'Title'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Title')),
	    'UrlCustom'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Slug')),
		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
		 if(empty($errors)){
		 	
		 	       if (!empty($id)) {
                                                    $_SESSION['mess_pg'] = PAGE_UPDATED;
                                                    $supercms->updatePage($_POST);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	$chkslug=$supercms->getPageSlug();
                                            	//print_r($reshgj);
                                                                                        
												if (in_array($data['UrlCustom'],$chkslug)) {
												   $_POST['UrlCustom']=$_POST['UrlCustom'].'-1';
												}
												                                            


                                                    $_SESSION['mess_pg'] = PAGE_ADDED;
                                                    $lastShipId = $supercms->addPage($_POST);	
                                                   header("location:".$ListUrl);
                                            }

                                            exit;
		
		}
		
                                     
			
		}
		

	
	
		
		if($arryPage[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}
	

	
		
	require_once("includes/footer.php"); 	 
?>


