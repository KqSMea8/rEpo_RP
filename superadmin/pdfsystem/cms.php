<?php
include_once("includes/header.php");
	require_once("classes/cms.class.php");
	
	 $ModuleName = "Cms";
	 $objelement=new cms();	 
        $objUser=new user();
        $page=$_REQUEST['curP']=empty($_REQUEST['curP'])?1:$_REQUEST['curP'];
        $limit=$_REQUEST['limit']=10; 
        $offset=$_REQUEST['offset']= (($_REQUEST['curP']-1)*$_REQUEST['limit']);
        //$arryUser=$objUser->getUser($_GET); 
        $arryPages=$objelement->getPages($_REQUEST);
        //print_r($_GET);
        $c=0;
        $strURL='';
    
        if(!empty($arryPages)){
            $totalrecords=$num=$arryPages[0]->c;
        }
    
        $totalrecords=ceil($totalrecords/$_REQUEST['limit']);
        $pageslink='';

        $pageslink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
       
         
	 /*$arryPages=$objelement->getPages();
	  $num=$objelement->num_rows; 
	  $pagerLink=$objPager->getPager($arryElement,$RecordsPerPage);*/
	require_once("includes/footer.php"); 
?>


	
	
