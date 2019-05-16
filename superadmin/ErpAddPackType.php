<?php 
include_once("includes/header.php");
require_once("../classes/erp.superAdminCms.class.php");
require_once("../classes/class.validation.php");
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(supercms)) {
	  	$supercms=new supercms();
	} else {
  		echo "Class Not Found Error !! supercms Class Not Found !";
		exit;
  	}
  	              $packTpData=$supercms->getPackFeatureList();
  	
                 $id = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
               
                  if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Package Feature&nbsp;';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "managePackType.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                      
                           $arryPage = $supercms->getpackTypeById($id);
                         
                           $arr = unserialize($arryPage[0]['value']);
                           //print_r($arr);
                         
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_Page'] = $ModuleName.STATUS;
		$supercms->changePackType($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	                     if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $supercms->deletePackType($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	                        }
	

 	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		 	
     $data=array();
	$data=$_POST;

    $str = serialize($_POST['value']);
  
	$errors=array();
	$validatedata=array(	
		'name'=>array(array('rule'=>'notempty','message'=>'Please Enter The Name'))

		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
		 if(empty($errors)){
		 	
		 		 	       if (!empty($id)) {
 
		 		 	       	                   $_SESSION['mess_Page'] = $ModuleName.Updated;
                                                    $supercms->updatePackType($_POST,$str,$id);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_Page'] = $ModuleName.Add;
                                                    $lastShipId = $supercms->addPkType($_POST,$str);	
                                                   header("location:".$ListUrl);
                                            }

                                            exit;
		}
	
		}

                
                              
}
	
		
	require_once("includes/footer.php"); 	 
?>


