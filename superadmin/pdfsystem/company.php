<?php

include_once("includes/header.php");
require_once("classes/syncdb.class.php");
$ModuleName = "company";
$objUser = new user();
$syncdb = new syncdb();
/*$arryUser = $objUser->getUser($_GET);
$num = $objUser->num_rows;
$pagerLink = $objPager->getPager($arryUser, $RecordsPerPage, $_GET['curP']);
echo '<pre>';print_r($arryUser);
/*****************************Pagination Amit Singh**************************************/
       
        $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
        $limit=$_GET['limit']=10; 
        $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
      
        //$arryUser=$objUser->getUser($_GET); 

            $searchType = !empty($_GET['type'])?$_GET['type']:'';
          $searchKeyword = !empty($_GET['keyword'])?$_GET['keyword']:'';

        $arryUser=$objUser->getUser($_GET,'',$searchType,$searchKeyword);
        $c=0;
        $strURL='';
    
        if(!empty($arryUser)){
            $totalrecords=$num=$arryUser[0]->c;
            //$totalrecords=$num=count((array)$arryUser);
        }
    
        $totalrecords=ceil($totalrecords/$_GET['limit']);
        $pagerLink='';

        $pagerLink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
        //echo $pagerLink;
   
/*******************************************************************/

$RedirectURL = "company.php?curP=" . $_GET['curP'];

if (isset($_POST['submit'])) {
    $vari = $_POST['find'];
    if ($vari == '' AND $vari == NULL) {
        $arryUser = $objUser->getUser($_GET);
    } else {
        $arryUser = $objUser->FindCompUsers($vari);
    }
}

if (!empty($_GET['del_id'])) {
    $_SESSION['mess_company'] = COMPANYUSER_REMOVED;
    $arryUser = $objUser->DeleteUser($_REQUEST['del_id']);
    header("Location:" . $RedirectURL);
    exit;
}
if(!empty($_REQUEST['active_id'])){
			
              $status = $_REQUEST['status']; 
              $compcod = $_REQUEST['compcode']; 
              $compStatus = $_REQUEST['compStatus'];

if($compStatus=='PENDING'){

 $_SESSION['mess_msg'] = 'Company not created yet ';

header("Location:" . $RedirectURL);
    exit;

}
global $compcod;
              $data = array('status'=>$status);
              $active_id = $_REQUEST['active_id']; 

		$objUser->changeCompanyStatus($data,$active_id);
                $syncdb->changeCompanyStatus($status,$compcod);
		header("Location:".$RedirectURL);
	}
require_once("includes/footer.php");
?>


