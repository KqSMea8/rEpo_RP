<?php
include ('includes/function.php');

include ('includes/header.php');

ValidateCrmSession();
require_once($Prefix."classes/cmp.class.php");
//Arequire_once($Prefix."classes/company.class.php");
//Arequire_once($Prefix."classes/rsl.class.php");

$objReseller=new rs();

$objCmp=new cmp();
$objCompany=new company();

$rsDiscount=$objReseller->resellerDiscount($_SESSION['CrmRsID']);



$pack_id=$_GET['pack_id'];

if($pack_id==7){
	$rSDiscount=$rsDiscount[0]['DiscountS'];
}else if($pack_id==8){
	$rSDiscount=$rsDiscount[0]['DiscountP'];
}else if($pack_id=9){
	$rSDiscount=$rsDiscount[0]['DiscountE'];
}else{
	$rSDiscount=$rsDiscount[0]['DiscountPC'];
}

if($pack_id>0){

	$arrayPkj=$objCmp->getPackagesById($pack_id);
	//print_r($arrayPkj);
	if(empty($arrayPkj[0]['name'])){
		header("location: dashboard");
		exit;
	}

	//$_SESSION['CrmCmpID'];
	$arrayCompany=$objCompany->GetCompanyDetail($_SESSION['CrmCmpID']);

	if(empty($arrayCompany[0]['CmpID'])){
		header("location: dashboard");
		exit;
	}

	$arrayCurrentOrder = $objCmp->GetCurrentOrder($_SESSION['CrmCmpID']);
	$Deduction = 0;
	if($arrayCurrentOrder[0]['OrderID']>0){
		// $arrayCurrentOrder[0]['TotalAmount'];
		$TimeSec = strtotime($arrayCurrentOrder[0]['EndDate']) - strtotime($arrayCurrentOrder[0]['StartDate']);
		$Days = round($TimeSec)/ (24*3600);
		$OneDayPrice = $arrayCurrentOrder[0]['TotalAmount']/$Days;

		$TimeLeft = strtotime($arrayCurrentOrder[0]['EndDate']) - strtotime(date('Y-m-d'));
		$DaysLeft = round($TimeLeft)/ (24*3600);
		if($DaysLeft>0 && $OneDayPrice>0){
			$Deduction = round($DaysLeft*$OneDayPrice);
		}

	}


}else{
	header("location: upgrade.php");
	exit;
}


include ('includes/footer.php');
?>
