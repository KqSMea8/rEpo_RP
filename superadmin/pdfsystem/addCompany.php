<?php
$ThisPageName = 'addCompany.php'; if(empty($_GET["edit"]))$EditPage = 1;
 
require_once("includes/header.php");
$ModuleName = "company";
$RedirectURL = "company.php?curP=".$_GET['curP'];
if(empty($_GET['tab'])) $_GET['tab']="company";

$EditUrl = "addComapny.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab=";
$ActionUrl = $EditUrl.$_GET["tab"];
$objUser=new user();
$userID = $_GET['edit']; 
//$arryUser=$objUser->getUser($_GET,$userID);
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
             
require_once("includes/footer.php");
?>

  
