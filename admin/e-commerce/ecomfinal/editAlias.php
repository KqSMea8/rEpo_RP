<?php  $HideNavigation = 1;
require_once("includes/header.php");
require_once("classes/product.class.php");
require_once("classes/inv.class.php");

$objProduct=new product();
$objCommon = new common();

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
$ModuleName  = "Alias";


if ($_POST) {
	if(empty($_POST['Sku'])) {
		$errMsg = ENTER_ITEM_ID;
	} else {
		if (!empty($_POST['AliasID'])) {
			$objProduct->UpdateAliasItem($_POST);
			$alias_id = $_POST['AliasID'];
			$_SESSION['mess_product'] = ALIAS_UPDATED;
			echo '<script>parent.window.location.reload();</script>';
		}else {
			$alias_id = $objProduct->AddAliasItem($_POST);
			$_SESSION['mess_product'] = ALIAS_ADDED;
			//echo '<script>parent.window.location.reload();</script>';
			//exit;
		}
	}
}




if(!empty($_GET['edit'])){

	$arryAlias = $objProduct->GetAliasItem($_GET['edit']);

	$Sku  = $arryAlias[0]['ProductSku'];
	$item_id = $arryAlias[0]['ProductID'];
} else{
	$Sku  = $_GET['Sku'];
	$item_id = $_GET['item_id'];
	$arryProduct = $objProduct->GetProductByAlias($item_id);
	$arryAlias[0]['description'] = $arryProduct[0]['Name'];
}




$arryManufacture = $objCommon->GetCrmAttribute('Manufacture', '');



require_once("includes/footer.php");

?>
