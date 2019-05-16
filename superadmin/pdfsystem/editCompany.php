<?php
$ThisPageName = 'editCompany.php'; if(empty($_REQUEST["edit"]))$EditPage = 1;
$InnerPage=1;
require_once("includes/header.php");
require_once("classes/syncdb.class.php");
$ModuleName = "company";
$RedirectURL = "company.php?curP=".$_GET['curP'];
if(empty($_REQUEST['tab'])) $_REQUEST['tab']="company";
$page=$_REQUEST['curP']=empty($_REQUEST['curP'])?1:$_REQUEST['curP'];
        $limit=$_REQUEST['limit']=10 ; 
        $offset=$_REQUEST['offset']= (($_REQUEST['curP']-1)*$_REQUEST['limit']);
$EditUrl = "editComapny.php?edit=".$_REQUEST["edit"]."&curP=".$_REQUEST["curP"]."&tab=";
$ActionUrl = $EditUrl.$_REQUEST["tab"];
$objUser=new user();
$userID = $_REQUEST['edit']; 

$arryUser=$objUser->getUser($_REQUEST,$userID);
//print_r($arryUser);
$compcod=$arryUser->company_code;


$setting=$objUser->getSettingData($userID);

global $compcod;
$objPackage=new package();
$syncdb=new syncdb();

//print_r($settingData);die('dfdf');
$arryPackage=$objUser->getPackage($_GET);

$package=array();
$packagedetail=array();
	if(!empty($arryPackage)){
		foreach($arryPackage as $arryPack){
                    //print_r($arryPack);
	       $package[$arryPack->id]=$arryPack->name;
               $packagedetail[$arryPack->id]=$arryPack;
                
		  }
	      }


               
//if (!empty($_GET["edit"])){
//	//$date = $_REQUEST['date']; 
//       // $dates = $_REQUEST['dates'];   
//      //$arryUser = $objUser->search($date,$dates);
//
//}
if (!empty($_REQUEST["edit"])){
	$userID = $_REQUEST['edit'];     
$arryUser = $objUser->getUser($_REQUEST['edit'], $userID);
//print_r($arryUser);

}


if (!empty($_REQUEST["edit"]) && $_REQUEST['tab'] == "orderlist"){
$arryOrder=$syncdb->getCompanyOrderList($_REQUEST,$searchType,$searchKeyword,$compcod);
    //print_r($arryOrder); die('abcd');
        $c=0;
        $strURL='';
  
        if(!empty($arryOrder)){ 
           $totalorderrecord=$numorder=count($arryOrder);
           
        }
      //echo '$totalorderrecord'. $totalorderrecord; die('wwww');
    
        $totalrecords=ceil($totalorderrecord/$_GET['limit']);
       
        $pagerLinkorder='';

        $pagerLinkorder=$objUser->pagingChat($page,$limit,$offset,$numorder,$totalrecords);
	 //echo $pagerLink; die('asasa');

}

if (!empty($_REQUEST["edit"]) && $_REQUEST['tab'] == "setting"){

$settingData=$syncdb->getSettingByCompanyCode($compcod);

if(isset($_POST['Submit']))
{
          $paymentMode=0;
	 foreach($settingData as $rows){                                   
                  if($rows['optionKey']=='ALLOWED_STORE')
                       {
                           $allow_store = $rows['optionValue'];
                       }
                   
           if(in_array('PAYMENT_MODE_ON_LINE',$rows))
                {
                    $paymentMode= '1';
                }
}

if($_POST['allowLicense'] >= $allow_store ){


 $data = array(
            'ALLOW_SHOPPING' => $_POST['allowedShopping']?$_POST['allowedShopping']:'0', 
            'ALLOW_ANNOTATION' => $_POST['allowedAnnotation']?$_POST['allowedAnnotation']:'0',
            'PAYMENT_MODE_ON_LINE' => $_POST['paymentMode']?$_POST['paymentMode']:'0', 
            'ALLOWED_STORE' => $_POST['allowLicense']?$_POST['allowLicense']:'0',     

);   

	$addallowedstore = $syncdb->updateSetting($data,$compcod,$paymentMode);
header("Refresh:0");
    die; 


}
else
{
$_SESSION['mess_msg'] = "Please add increase allow license. "; 

}

//die;

 
	}	 
}

//http://75.112.188.111/erp_old/erp/superadmin/pdfsystem/editComapny.php?edit=3&curP=1&tab=setting


////
/*print_r($_POST);
if(!empty($_POST['allowedStore'])){
$optionKey='ALLOWED_STORE';
$optionValue=$_POST['allowedStore'];
 $addallowedstore = $syncdb->AddAllowedStore($compcod,$optionKey,$optionValue);
}
}*/
if (!empty($_REQUEST["edit"])){
    $Todate = $_REQUEST['Todate']; 
    $Fromdate = $_REQUEST['Fromdate'];  
    $compcod = $arryUser->company_code;
    $id=$_GET['id'];
    $arryOrderHis = $objUser->getOrderHistory($_REQUEST,$compcod,$id,$Todate,$Fromdate);
    $c=0;
        $strURL='';
    
        if(!empty($arryOrderHis)){
            $totalrecords=$num=$arryOrderHis[0]->c;
           
        }
    
        $totalrecords=ceil($totalrecords/$_REQUESTSS['limit']);
         
        $pagerLink='';

        $pagerLink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
    
   
}
if (!empty($_REQUEST["date"])){
    $compcod = $arryUser->company_code;
    $arryOrderHis =  $objUser->search($date,$dates, $compcod);
}



if(!empty($_REQUEST["edit"]) && $_REQUEST['tab'] == "compuserlist"){
 $compcod = $arryUser->company_code;
 $arrycompUser = $syncdb->GetCompUsers($_REQUEST,$compcod,4);
$totalCount=0;
        $strURL='';
    
        if(!empty($arrycompUser)){
        $totalrecords=$num=$arrycompUser[0]['totalCount'];
           
        }   
      $pagerLink=$syncdb->paging($page,$limit,$totalrecords,$userID);

 }
 
 
 if(!empty($_REQUEST["edit"])){
 $compcod = $arryUser->company_code;
  $status = 1;
  $planDetails=$objUser->getPlanPackage($compcod,$status);
 }

require_once("includes/footer.php");
?>

