<?php 

	include_once("includes/header.php");
     
    include_once("classes/class.validation.php");
	$ModuleName = "Package";
        $RedirectURL = "package.php?curP=" . $_GET['curP']; 

        $objPackage=new package();
        $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
        $limit=$_GET['limit']=10 ; 
        $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
      
        //$arryUser=$objUser->getUser($_GET); 
        $arryPackage=$objPackage->getPackage($_GET,'');

        //print_r($_GET);
        $c=0;
        $strURL='';
    
        if(!empty($arryPackage)){
            $totalrecords=$num=$arryPackage[0]->c;
        }
    
        $totalrecords=ceil($totalrecords/$_GET['limit']);
        $pagerLink='';

        $pagerLink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);


        if (!empty($_GET['del_id'])) { 
               $pckg_id   = $_GET['del_id']; 
	       $arryPackage = $objPackage->DeletePackage($_GET['del_id']);
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
		 exit;
	}
	
        
	require_once("includes/footer.php");  
?>
