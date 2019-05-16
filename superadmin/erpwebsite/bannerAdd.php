<?php 

    /**************************************************/
    $ThisPageName = 'bannerManagement.php'; $EditPage = 1; 
    /**************************************************/
    
	include_once("includes/header.php");

require_once("../../classes/erp.superAdminCms.class.php");
require_once("../../classes/class.validation.php");
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(supercms)) {
	  	$supercms=new supercms();
	} else {
  		echo "Class Not Found Error !! supercms Class Not Found !";
		exit;
  	}
                 $id = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
               
                  if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Banner';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "bannerManagement.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                        $arryPage = $supercms->getBannerById($id);
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_banner'] = BANNER_STATUS_CHANGED;
		$supercms->changeBannerStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_banner'] = BANNER_REMOVED;
                                $supercms->deleteBanner($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		


 	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		 	$text = $_POST['Text'];
		 	CleanPost();
		 	$_POST['Text'] = addslashes($text);
     $data=array();

	$data=$_POST;

	//echo $_FILES['Icon']['name'];
	
	//print_r($data);

    if($_FILES['Image']['name'] != ''){
								
	$imageName = time(). $_FILES['Image']['name'];
									
	$ImageDestinatiobvn = "../../ezneterp/images/".$imageName;
        //$ImageDestinatiobvn = "../../images/".$imageName;
        @move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestinatiobvn);
					
	}
									
	$errors=array();
	$validatedata=array(	
		'Priority'=>array(array('rule'=>'notempty','message'=>'Please Enter The Priority'))
		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
		 if(empty($errors)){
		 	
		 	       if (!empty($id)) {
                                                     $_SESSION['mess_banner'] = BANNER_UPDATED;
                                                    $supercms->updateBanner($_POST,$imageName);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_banner'] = BANNER_ADDED;
                                                    $lastShipId = $supercms->addBanner($_POST,$imageName);	
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


