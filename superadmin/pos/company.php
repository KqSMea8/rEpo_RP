<?php 
    include_once("includes/header.php");

    $ModuleName = "company";
    $objUser=new user();
 
     
            
    $RedirectURL = "company.php?curP=" . $_GET['curP']; 

	


   if (!empty($_GET['del_id'])) { 
   	   $_SESSION['mess_company'] = COMPANYUSER_REMOVED;
		$arryUser = $objUser->DeleteUser($_REQUEST['del_id']);
         header("Location:".$RedirectURL);
                 exit;
        }


	
   	$arryUser=$objUser->getUser($_GET,'',''); 

	$num=$objUser->num_rows;
	$pagerLink=$objPager->getPager($arryUser,$RecordsPerPage,$_GET['curP']);
	(count($arryUser)>0)?($arryUser=$objPager->getPageRecords()):("");
	require_once("includes/footer.php"); 	
    
?>


