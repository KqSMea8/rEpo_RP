<?php 
	/**************************************************/
	$ThisPageName = 'viewTestimonial.php'; $EditPage = 1; 
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/superAdminCms.class.php");
	//require_once("../classes/class.validation.php");
	require_once("../classes/function.class.php");

	$supercms=new supercms();
        $objFunction =	new functions();	             

	$_GET['edit'] = (int)$_GET['edit'];
  	$TestimonialID = (int)$_GET['edit'];
	$_GET['active_id'] = (int)$_GET['active_id'];
	$_GET['del_id'] = (int)$_GET['del_id'];
	$ModuleName = 'Testimonial';
	
	$ListUrl    = "viewTestimonial.php?curP=".$_GET['curP'];

  	if(!empty($_GET['active_id'])){
		$_SESSION['mess_testimonial'] = TESTIMONIAL_STATUS_CHANGED;
		$supercms->changeTestimonialStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){             
                $_SESSION['mess_testimonial'] = TESTIMONIAL_REMOVED;
                $supercms->deleteTestimonial($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}



	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		 CleanPost();
		             
       if($_FILES['Image']['name'] != ''){
								
	/*$imageName = time(). $_FILES['Image']['name'];								
	 $ImageDestinatiobvn = "../images/".$imageName; 
    						
                            
       move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestinatiobvn);*/

		$imageFile = escapeSpecial($_FILES['Image']['name']); 
		$FileInfoArray['FileType'] = "Image";
		$FileInfoArray['FileDir'] = $Config['TestimonialDir'];
		$FileInfoArray['FileID'] = $imageFile;
		$FileInfoArray['OldFile'] = $_POST['OldImage'];
		$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);	

		if($ResponseArray['Success']=="1"){  
			$imageName = $ResponseArray['FileName']; 
		}else{
			$ErrorMsg = $ResponseArray['ErrorMsg'];
		}
					
	}     
                        if (!empty($TestimonialID)) {
                                                     $_SESSION['mess_testimonial'] = TESTIMONIAL_UPDATED;
                                                    $supercms->updateTestimonial($_POST,$imageName);
                                                   
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_testimonial'] = TESTIMONIAL_ADDED;
                                                    $lastShipId = $supercms->addTestimonial($_POST,$imageName);	
                                                   
                                            }
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_testimonial'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_testimonial'] .= $ErrorPrefix.$ErrorMsg;
					}

						header("location:".$ListUrl);

                                            exit;

		}
       }


    if (!empty($TestimonialID)){
		$arryeditTestimonial = $supercms->getTestimonialById($TestimonialID);
         // print_r($arryeditTestimonial);die;
		
	}
	
	if($arryeditTestimonial[0]['Status'] == "0"){
		$TestimonialStatus = "0";
	}else{
		$TestimonialStatus = "1";
	}                           

	
		
	require_once("includes/footer.php"); 	 
?>


