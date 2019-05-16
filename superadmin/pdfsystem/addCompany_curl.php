<?php

$ThisPageName = 'addCompany.php'; if(empty($_GET["edit"]))$EditPage = 1;
$InnerPage=1;
require_once("includes/header.php");
$ModuleName = "company";
$RedirectURL = "company.php?curP=".$_GET['curP'];
if(empty($_GET['tab'])) $_GET['tab']="company";

$EditUrl = "addComapny.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab=";
$ActionUrl = $EditUrl.$_GET["tab"];
$objUser=new user();
$userID = $_GET['edit']; 
$arryUser=$objUser->getUser($_GET,$userID);
$compcod=$arryUser->company_code;

$objPackage=new package();
$arryPackage=$objPackage->getPackage($_GET);
$package=array();
$packagedetail=array();
	if(!empty($arryPackage)){
		foreach($arryPackage as $arryPack){
		$package[$arryPack->id]=$arryPack->name;
                $packagedetail[$arryPack->id]=$arryPack;
		  }
	      }
               
if (!empty($_GET["edit"])){
	$date = $_REQUEST['date']; 
        $dates = $_REQUEST['dates'];   
      $arryUser = $objUser->search($date,$dates);

}
if (!empty($_GET["edit"])){
	$userID = $_REQUEST['edit'];     
$arryUser = $objUser->getUser($_GET['edit'], $userID);

}

if (!empty($_GET["edit"])){
    $compcod = $arryUser->company_code;
    $id=$_GET['id'];
    $arryOrderHis = $objUser->getOrderHistory($compcod,$id);
   
}
if (!empty($_GET["date"])){
    $compcod = $arryUser->company_code;
    $arryOrderHis =  $objUser->search($date,$dates, $compcod);
}
//if (!empty($_GET["edit"]) && $_GET["tab"]=='paymentview'){
//     $compcod = $arryUser->company_code;
//     $userRoleID = $arryUser->roleId;;
//     $arryOrderHis = $objUser->getOrderHistory($compcod,$userRoleID);
//}


if(!empty($_GET["edit"])){
 $compcod = $arryUser->company_code;
 $arrycompUser = $objUser->GetCompUsers($compcod,3);

 }
 
 
 if(!empty($_GET["edit"])){
 $compcod = $arryUser->company_code;
  $status = 1;
  $planDetails=$objUser->getPlanPackage($compcod,$status);
 }

require_once("includes/footer.php");
?>


