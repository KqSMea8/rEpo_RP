<?php 

	include_once("includes/header.php");
        $ModuleName = "Order";
        $RedirectURL = "OrderList.php?curP=" . $_GET['curP']; 	        
        $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
        $limit=$_GET['limit']=10 ; 
        $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
        $searchType = !empty($_GET['type'])?$_GET['type']:'';
        $searchKeyword = !empty($_GET['keyword'])?$_GET['keyword']:'';
        
        $objOrder=new user();
        
        $arryOrder=$objOrder->getOrderList($_GET,$searchType,$searchKeyword);
     
        $c=0;
        $strURL='';
    
        if(!empty($arryOrder)){
           $totalrecords=$num=$arryOrder[0]->c;
           
        }
        
    
        $totalrecords=ceil($totalrecords/$_GET['limit']);
         
        $pagerLink='';

        $pagerLink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
        
        
      
        
	require_once("includes/footer.php");  
?>