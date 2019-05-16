<?php
include_once("includes/header.php");
	require_once("classes/cms.class.php");
	
	 $ModuleName = "Cms";
	 $objelement=new cms();	 
         /*****************************Pagination Amit Singh**************************************/
         $objUser=new user();
        $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
        $limit=$_GET['limit']=10; 
        $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
      	$totalrecords=$num=0;
        //$arryUser=$objUser->getUser($_GET); 
        $arryPages=$objelement->getPages($_GET);
        //print_r($_GET);
        $c=0;
        $strURL='';
    
        if(!empty($arryPages)){
            $totalrecords=$num=$arryPages[0]->c;
        }
    
        $totalrecords=ceil($totalrecords/$_GET['limit']);
        $pageslink='';

        $pageslink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
        /*******************************************************************/
         
	 /*$arryPages=$objelement->getPages();
	  $num=$objelement->num_rows; 
	  $pagerLink=$objPager->getPager($arryElement,$RecordsPerPage);*/
	require_once("includes/footer.php"); 
?>


	
	
