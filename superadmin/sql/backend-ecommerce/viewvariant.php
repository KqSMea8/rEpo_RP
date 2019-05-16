<?php

$FancyBox = 1;
$ThisPageName = 'managevariant.php';
$EditPage = 1;
include_once("includes/header.php");
require_once("classes/inv.class.php");
require_once("classes/variant.class.php");
$objvariant=new varient();
$objCommon=new common();
//echo '<pre>'; print_r($Config);
$ModuleName = 'Variant';


$variantType=$objvariant->GetVariantType();
if(!empty($_GET['editVId'])){

	//echo 'dd';die;
	$GetVariantEditList=$objvariant->GetVariant($_GET['editVId']);
	//echo '<pre>'; print_r($GetVariantEditList);die;
	$GetMultipleEditVariantOption=$objvariant->GetMultipleVariantOption($_GET['editVId']);

}



require_once("includes/footer.php");
?>

