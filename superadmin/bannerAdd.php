<?php 

    /**************************************************/
    $ThisPageName = 'bannerManagement.php'; $EditPage = 1; 
    /**************************************************/
    
	include_once("includes/header.php");

require_once("../classes/superAdminCms.class.php");
require_once("../classes/class.validation.php");
require_once("../classes/function.class.php");
 
               	$objFunction =	new functions();	             
	  	$supercms=new supercms();
	 
                 $id = isset($_GET['edit'])?$_GET['edit']:"";
               
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
		 	CleanPost();
     $data=array();

	$data=$_POST;

	//echo $_FILES['Icon']['name'];
	
	//print_r($data);

    if($_FILES['Image']['name'] != ''){

		$imageFile = escapeSpecial($_FILES['Image']['name']); 
		$FileInfoArray['FileType'] = "Image";
		$FileInfoArray['FileDir'] = $Config['BannerDir'];
		$FileInfoArray['FileID'] = $imageFile;
		$FileInfoArray['OldFile'] = $_POST['OldImage'];
		$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);	

		if($ResponseArray['Success']=="1"){  
			$imageName = $ResponseArray['FileName']; 
		}else{
			$ErrorMsg = $ResponseArray['ErrorMsg'];
		}
					
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
                                                    
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_banner'] = BANNER_ADDED;
                                                    $lastShipId = $supercms->addBanner($_POST,$imageName);	
                                                }
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_banner'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_banner'] .= $ErrorPrefix.$ErrorMsg;
					}

						header("location:".$ListUrl);
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


