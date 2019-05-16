<?php 
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For Package List Root file package.php
 */
	include_once("includes/header.php");
    include_once("classes/class.validation.php");
	$ModuleName = "Package";
	$objPackage=new package();
	$arryPackage=$objPackage->getPackage($_GET);
    $RedirectURL = "package.php?curP=" . $_GET['curP']; 
	$num=$objPackage->num_rows;
	$pagerLink=$objPager->getPager($arryPackage,$RecordsPerPage,$_GET['curP']);
	//(count($arryElement)>0)?($arryElement=$objPager->getPageRecords()):("");

        if (!empty($_GET['del_id'])) { 
               $pckg_id   = $_GET['del_id']; 
		$arryPackage = $objPackage->DeletePackage($_REQUEST['del_id']);
                 echo 'Row deleted successfully.';
                 header("Location:".$RedirectURL);
                 exit;
        }
      
         if(!empty($_GET['active_id'])){
              $status = $_GET['status']; 
              $data = array('status'=>$status);
              $active_id = $_GET['active_id']; 
		$objPackage->changePackageStatus($data,$active_id);
		header("Location:".$RedirectURL);
	}
	if(!empty($_GET['demo_id'])){
	$objPackage->query('Update plan_package SET `demo`=0');
	$objPackage->query('Update plan_package SET `demo`=1 WHERE pckg_id="'.$_GET['demo_id'].'"');
	
	 header("Location:".$RedirectURL);
                 exit;
	}
	
        
	require_once("includes/footer.php");  
?>
