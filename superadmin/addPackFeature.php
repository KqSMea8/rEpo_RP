<?php 
include_once("includes/header.php");
require_once("../classes/superAdminCms.class.php");
require_once("../classes/class.validation.php");
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(supercms)) {
	  	$supercms=new supercms();
	} else {
  		echo "Class Not Found Error !! supercms Class Not Found !";
		exit;
  	}
  	              //$pageDta=$supercms->showPage();
  	
                 $id = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
               
                  if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Package Feature&nbsp;';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "managePackFeature.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                      
                           $arryPage = $supercms->getpackFeatureById($id);
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_Page'] = $ModuleName.STATUS;
		$supercms->changePackFeature($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	                     if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $supercms->deletePackFeature($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	                        }
	

 	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		 	
     $data=array();
	$data=$_POST;

	$errors=array();
	$validatedata=array(	
		'feature'=>array(array('rule'=>'notempty','message'=>'Please Enter The Feature')),
		'type'=>array(array('rule'=>'notempty','message'=>'Please Select The Type'))
		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
		 if(empty($errors)){
		 	
		 		 	       if (!empty($id)) {
echo 
		 		 	       	                   $_SESSION['mess_Page'] = $ModuleName.Updated;
                                                    $supercms->updatePackFeature($_POST);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_Page'] = $ModuleName.Add;
                                                    $lastShipId = $supercms->addPackFeature($_POST);	
                                                   header("location:".$ListUrl);
                                            }

                                            exit;
		}
	
		}

                
                              
}
	
		
	require_once("includes/footer.php"); 	 
?>


