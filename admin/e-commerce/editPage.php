<?php 
	/**************************************************/
	$ThisPageName = 'viewPages.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/cms.class.php");
	
		 $cmsObj=new cms();

                 $PageId = isset($_GET['edit'])?$_GET['edit']:"";	
                  if ($PageId && !empty($PageId)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Page';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "viewPages.php?curP=".$_GET['curP'];
                       
               
                    		
		 	 
                if(!empty($_GET['active_id'])){
		$_SESSION['mess_Page'] = $ModuleName.STATUS;
		$cmsObj->changePageStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $cmsObj->deletePage($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		
		 
		 if ($_POST) {
		
                                            if (!empty($PageId)) {
                                                    $_SESSION['mess_Page'] = $ModuleName.UPDATED;
                                                    $cmsObj->updatePage($_POST);
                                                    
                                            } else {		
                                                    $_SESSION['mess_Page'] = $ModuleName.ADDED;
                                                    $lastShipId = $cmsObj->addPage($_POST);	
                                                  
                                            }
                                            
                                             if($_FILES['Banner_image']['name'] != ''){
						
						$ImageExtension = GetExtension($_FILES['Banner_image']['name']);
						$imageName = $PageId.".".$ImageExtension;
						
						$MainDir = $Prefix."upload/page/images/".$_SESSION['CmpID']."/"; 
						if (!is_dir($MainDir)) { 
						mkdir($MainDir);
						chmod($MainDir,0777);
						}
						 $ImageDestination = $MainDir.$imageName;

						if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
						$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
						unlink($_POST['OldImage']);
						}

						if(@move_uploaded_file($_FILES['Banner_image']['tmp_name'], $ImageDestination)){
						
						$cmsObj->UpdateImage($imageName,$PageId);
						
						}
						
					
					}
					header("location:".$ListUrl);
                                            exit;
			
		}
		

	$PageStatus = "Yes";
	if (!empty($PageId)) 
                    {
                        $arryPage = $cmsObj->getPageById($PageId);
			if($arryPage[0]['Status'] == "No"){
			$PageStatus = "No";
			}else{
				$PageStatus = "Yes";
			}

                    }
		
		
                
                              




 require_once("../includes/footer.php"); 
 
 
 ?>
