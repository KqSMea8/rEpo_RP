<?php 

require_once("includes/header.php");
require_once("classes/banner.class.php");
	
	 $ModuleName = "Cms";
	 $objelement=new banner();	 
         
         
         
         
         
         /*****************************Pagination Amit Singh**************************************/
        $objUser=new user();
        $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
        $limit=$_GET['limit']=10; 
        $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
     	$totalrecords=$num=0;
        //$arryUser=$objUser->getUser($_GET); 
        $arryBanner=$objelement->getbanner($_GET);
   
        $c=0;
        $strURL='';
    
        if(!empty($arryBanner)){
            $totalrecords=$num=$arryBanner[0]->c;
        }
    
        $totalrecords=ceil($totalrecords/$_GET['limit']);
        
        $pageslink='';

        $pageslink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
        
        
        if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_banner'] = 'Banner removed';
                                $objelement->delete_banner($_GET['del_id']);
                                header('Location:banner.php');
                                exit;
	}
        








require_once("includes/footer.php");
?>
