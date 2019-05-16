<?php 
	include_once("includes/header.php");
	
	$ModuleName = "UserInfo";
	$objUser=new user();
	//**********pagignation Amit Singh************************************************************/
    $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
    $limit=$_GET['limit']=1; 
    $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
      print_r($_GET);die();
    $arryUser=$objUser->getUser($_GET); 
  // print_r($arryUser[0]); die();
    $c=0;
    $strURL='';
    
    if(!empty($arryUser)){
        $totalrecords=$num=$arryUser[0]->c;
    }
    echo '555555'.$totalrecords; 
    $totalrecords=ceil($totalrecords/$_GET['limit']);
    $pageslink='';
    
     $pageslink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
    echo 'aaaa'.$pageslink;
    //echo  $RedirectURL.'dfsvfsddgdsh';	
    
    //**********pagignation
    /*$pagerLink = $objPager->getPager($arryUser, $RecordsPerPage, $_GET['curP']);
    (count($arryUser) > 0) ? ($arryUser = $objPager->getPageRecords()) : ("");
   
    //*****************************************************************************/
	//$arryUser=$objUser->getUser($_GET); 
	//$num=$objUser->num_rows;

	//$pagerLink=$objPager->getPager($arryUser,$RecordsPerPage,$_GET['curP']);
	//(count($arryUser)>0)?($arryUser=$objPager->getPageRecords()):("");
	 $RedirectURL = "user.php?curP=" . $_GET['curP']; 
	 
   if (!empty($_GET['del_id'])) { 
		$arryUser = $objUser->DeleteUser($_REQUEST['del_id']);
                 echo 'Row deleted successfully.';
                 header("Location:".$RedirectURL);
                 exit;
        }
	require_once("includes/footer.php"); 	
    
?>


