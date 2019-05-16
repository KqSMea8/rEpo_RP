<?php 

    /**************************************************/
    $ThisPageName = 'headerMenu.php'; $EditPage = 1; 
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
                        $ModuleName = 'Social Link';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "footerSocialLinksList.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                        $arryPage = $supercms->getsocialLinkById($id);
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_footer_link'] = FOOTER_SOCIAL_STATUS_CHANGED;
		$supercms->changeSocialStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_footer_link'] = FOOTER_SOCIAL_REMOVED;
                                $supercms->deleteSocialLink($_GET['del_id']);
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

    if($_FILES['Icon']['name'] != ''){
								
	echo $imageName = time(). $_FILES['Icon']['name'];
									
	echo $ImageDestinatiobvn = "../../ezneterp/img/".$imageName;
    @move_uploaded_file($_FILES['Icon']['tmp_name'], $ImageDestinatiobvn);
					
	}
									
	$errors=array();
	$validatedata=array(	
		'priority'=>array(array('rule'=>'notempty','message'=>'Please Enter The Priority')),
		'uri'=>array(array('rule'=>'notempty','message'=>'Please Enter The UTI'))
		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
		 if(empty($errors)){
		 	
		 	       if (!empty($id)) {
                                                    $_SESSION['mess_footer_link'] = FOOTER_SOCIAL_UPDATED;
                                                    $supercms->updateSocialLink($_POST,$imageName);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_footer_link'] = FOOTER_SOCIAL_ADDED;
                                                    $lastShipId = $supercms->addSocialLink($_POST,$imageName);	
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


