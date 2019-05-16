<?php 
	/**************************************************/
	$ThisPageName = 'viewIndustry.php'; $EditPage = 1; 
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/industry.class.php");
	
	$industry = new industry();
    
	$_GET['edit'] = (int)$_GET['edit'];
  	$IndustryID = (int)$_GET['edit'];
	$_GET['active_id'] = (int)$_GET['active_id'];
	$_GET['del_id'] = (int)$_GET['del_id'];
	$ModuleName = 'Industry';
	$ListUrl    = "viewIndustry.php?curP=".$_GET['curP'];
       
    $arryIndustryName = $industry->GetIndustryName($IndustryID);
	if(!empty($_GET['active_id'])){
		$_SESSION['mess_industry'] = INDUSTRY_STATUS_CHANGED;
		$industry->changeIndustryStatus($_GET['active_id']);
		header("location:".$ListUrl);
	    exit;
	 }
	
	 if(!empty($_GET['del_id']) && $_GET['del_id']>100){             
                $_SESSION['mess_industry'] = INDUSTRY_REMOVED;
                $industry->deleteIndustry($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}

	if (is_object($industry)) {	
		 
		 if (!empty($_POST)) {
		 CleanPost();
		                     
                        if (!empty($IndustryID)) {
                                                    $_SESSION['mess_industry'] = INDUSTRY_UPDATED;
                                                    $industry->updateIndustry($_POST);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
                                                    $_SESSION['mess_industry'] = INDUSTRY_ADDED;
                                                    $lastShipId = $industry->addIndustry($_POST);	
                                                   header("location:".$ListUrl);
                                            }

                                            exit;

		}
       }


	    if (!empty($IndustryID)){
	$arryeditIndustry = $industry->getIndustryById($IndustryID);
	
	}
	
	if($arryeditIndustry[0]['Status'] == "0"){
	$IndustryStatus = "0";
	}else{
	$IndustryStatus = "1";
	}                           
	
	require_once("includes/footer.php"); 	 
?>


