<?php 
    
	/**************************************************/
	$ThisPageName = 'viewNews.php'; $EditPage = 1;
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/newsarticle.class.php");
	require_once("../classes/function.class.php");

	$objFunction	=	new functions();
	$objNews = new news();
	$ModuleName = "News";
	$NewsID = (int)$_GET['edit'];
	$RedirectURL = "viewNews.php?curP=".$_GET['curP'];

        $arryCategoryName = $objNews->GetNewsCategory($CategoryID,$Status);
        $arraycategoryNametById = $objNews->categoryNametById($_GET['edit']);

if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_news'] = NEWS_REMOVED;
		$objNews->RemoveNews($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_news'] = NEWS_STATUS_CHANGED;
		$objNews->changeNewsStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}



if (is_object($objNews)) {	
		 
		 if (!empty($_POST)) {
		
		             
       if($_FILES['Image']['name'] != ''){
								
	
			$imageFile = escapeSpecial($_FILES['Image']['name']); 
			$FileInfoArray['FileType'] = "Image";
			$FileInfoArray['FileDir'] = $Config['NewsDir'];
			$FileInfoArray['FileID'] = $imageFile;
			$FileInfoArray['OldFile'] = $_POST['OldImage'];
			$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);	

			if($ResponseArray['Success']=="1"){  
				$imageName = $ResponseArray['FileName']; 
			}else{
				$ErrorMsg = $ResponseArray['ErrorMsg'];
			}

					
	}     
                        if (!empty($NewsID)) {
                                                     $_SESSION['mess_news'] =  NEWS_UPDATED;
                                                    $objNews->UpdateNews($_POST,$imageName);
                                                    
                                            } else {
                                            	
							                        
                                                    $_SESSION['mess_news'] =  NEWS_ADDED;
                                                    $NewsID = $objNews->AddNews($_POST,$imageName);	
                                                  
                                            }
					if(!empty($ErrorMsg)){
					if(!empty($_SESSION['mess_news'])) $ErrorPrefix = '<br><br>';
					$_SESSION['mess_news'] .= $ErrorPrefix.$ErrorMsg;
					}
					header("location:".$RedirectURL);

					exit;

		}
       }
       

       $NewsID   = (int)$_GET['edit'];	
	if (!empty($_GET['edit'])) {
		$arryNews = $objNews->GetNews($NewsID,'');
		
		//print_r($arryNews);
		
		
		/***************/
		if(empty($arryNews[0]['NewsID'])){
			header("Location:".$RedirectURL);
			exit;
		}
		/***************/	
	}
	
		
	 
if($arryNews[0]['Status'] != ''){
        $NewsStatus = $arryNews[0]['Status'];
    }else{
        $NewsStatus = 1;
    }    

		
      require_once("includes/footer.php"); 

?>


