<?php 

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For element.php
 */
	include_once("includes/header.php");
    include_once("classes/class.validation.php");
	$ModuleName = "payment";
	$objpayment=new payment();
	 $limit=$_GET['limit']=20; 
    	$offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
	$arrypayment=$objpayment->getPlanelement($_GET);
	   //print_r($arrypayment[0]); die();
	    $d=0;
	    $strURL='';

    	 if(!empty($arrypayment)){
        $totalrecords=$num=$arrypayment[0]->d;
    	}
	//echo '555555'.$totalrecords; 
	$totalrecords=ceil($totalrecords/$_GET['limit']);
    	$pageslink='';

	
	$pageslink=$objpayment->pagingChat($page,$limit,$offset,$num,$totalrecords);
	//(count($arrypayment)>0)?($arrypayment=$objPager->getPageRecords()):("");
        $RedirectURL = "payment.php?curP=" . $_GET['curP']; 
        if (!empty($_GET['del_id'])) { 
                $element_id   = $_GET['del_id']; 
               
		$arrypayment = $objpayment->DeleteElement($_REQUEST['del_id']);
               if($arrypayment){
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
	}
	
        
	require_once("includes/footer.php"); 	 
?>


