<?php 
	include_once("includes/header.php");
	
	$ModuleName = "company";
	$objUser=new company();
	$_GET['userRoleID']=2;
	 $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
    $limit=$_GET['limit']=20; 
    $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
     
    $arryUser=$objUser->getUser($_GET); 
    

   //echo '<pre>';print_r($arryUser); 
   // $c=0;
    //$strURL='';
    
   // if(!empty($arryUser)){
        //$totalrecords=$num=$arryUser[0]->c;


  //  }

$total = $objUser->getRecords();

foreach($total as $key=>$values){
$values = get_object_vars($values);                           
   $num=$totalrecords=$values['Total'];

   
}
    //echo '555555'.$totalrecords; 
    $total=ceil($totalrecords/$_GET['limit']);
    $pageslink='';
   

     $pageslink=$objUser->pagingChat($page,$limit,$offset,$num,$total);
    //echo 'aaaa'.$pageslink;
	//(count($arryUser)>0)?($arryUser=$objPager->getPageRecords()):("");
	 $RedirectURL = "company.php?curP=" . $_GET['curP']; 
	 
   if (!empty($_GET['del_id'])) { 
   	   $_SESSION['mess_company'] = COMPANYUSER_REMOVED;
		$arryUser = $objUser->DeleteUser($_REQUEST['del_id']);
         header("Location:".$RedirectURL);
                 exit;
        }
	require_once("includes/footer.php"); 	
    
?>


