<?php 

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For element.php
 */
	include_once("includes/header.php");
    	include_once("classes/class.validation.php");

	$ModuleName = "Elements";
	$objelement=new plan();
	$arryElement=$objelement->getPlanelement($_GET,'','');
 
	$num=$objelement->num_rows;
	$pagerLink=$objPager->getPager($arryElement,$RecordsPerPage,$_GET['curP']);
	(count($arryElement)>0)?($arryElement=$objPager->getPageRecords()):("");
        $RedirectURL = "element.php?curP=" . $_GET['curP']; 
        if (!empty($_GET['del_id'])) { 
                $element_id   = $_GET['del_id']; 
               
		$arryElement = $objelement->DeleteElement($_REQUEST['del_id']);
               if($arryElement){
               	$_SESSION['plan_message']='Delete Successfuly';
				header("Location:".$RedirectURL);    
				exit;            
               }else{               	
               	 $_SESSION['plan_message']='This Element could not delete.';
				header("Location:".$RedirectURL);
				exit;
               }
        }
      
         if(!empty($_GET['active_id'])){
         	$_SESSION['mess_element'] = USER_STATUS_CHANGED;
              $status = $_GET['status']; 
              $data = array('status'=>$status);
              $active_id = $_GET['active_id']; 
		$objelement->changeElementStatus($data,$active_id);
		header("Location:".$RedirectURL);
		exit;
	}
	
        
	require_once("includes/footer.php"); 	 
?>


