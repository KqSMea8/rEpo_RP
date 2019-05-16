<?php
/**************************************************/
$ThisPageName = 'viewProduct.php'; $EditPage = 1;
/**************************************************/
require_once("includes/header.php");
require_once("classes/product.class.php");
require_once("classes/category.class.php");
require_once($Prefix."classes/region.class.php");
require_once("classes/manufacturer.class.php");
require_once("classes/cartsettings.class.php");
require_once($Prefix."classes/function.class.php");
require_once("classes/item.class.php");
//By Chetan 10Sep//
require_once("classes/variant.class.php");
$objvariant=new varient();
//End//
$objFunction=new functions();

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
$objRegion=new region();
$objManufacturer = new Manufacturer();
$objcartsettings=new Cartsettings();
$objCategory=new category();
$objItem = new items();

$arryManufacturer = $objManufacturer->getManufacturer('',1,'','','');
$arryTaxClasses =$objcartsettings->getClasses();


$listAllCategory =  $objCategory->ListAllCategories();

$RedirectURL = "viewProduct.php?curP=".$_GET['curP']."";
if($_GET['tab'] == "basic")
{
	$ModuleName  = "Basic Properties";
}
elseif($_GET['tab'] == "other")
{
	$ModuleName  = "Other Properties";
}
elseif($_GET['tab'] == "alterimages")
{
	$ModuleName  = "Alternative Images";
}
elseif($_GET['tab'] == "description")
{
	$ModuleName  = "Description";
}

elseif($_GET['tab'] == "seo")
{
	$ModuleName  = "Seo Properties";
}

elseif($_GET['tab'] == "addattributes")
{
	$ModuleName  = "Attributes";
}

elseif($_GET['tab'] == "inventory")
{
	$ModuleName  = "Inventory";
}
elseif($_GET['tab'] == "discount")
{
	$ModuleName  = "Discount";
}
elseif($_GET['tab'] == "recommended")
{
	$ModuleName  = "Recommended";
}
else {
	$ModuleName  = "Product";
}

$objProduct=new product();

if(!empty($_GET['edit'])){
	$MaxTotalImageCount = $objProduct->GetTotalImagesCount($_GET['edit']);
}
if($MaxTotalImageCount > 0)
{
	$startImageCount = $MaxTotalImageCount+1;
	$MaxProductImage =$MaxTotalImageCount+3;
}
else {
	$startImageCount =1;
	$MaxProductImage =3;
}
 
 
if($_GET['edit'] != "")
{
	$MaxProductImageArr = $objProduct->GetAlternativeImage($_GET['edit']);
	$AttributesArr = $objProduct->GetProductAttributes($_GET['edit']);
	$DiscountArr = $objProduct->GetProductDiscount($_GET['edit']);
	$ProdSku = $objProduct->GetProductSku($_GET['edit']);
}
if($_GET['attID'] != "")
{
	$productAttribute = $objProduct->GetAttributeByID($_GET['attID']);
	if($productAttribute[0]['gaid']>0){
		$arrayOptionList= $objProduct->GetOptionList($productAttribute[0]['gaid']);


	}else{
		$arrayOptionList= $objProduct->GetProductOptionList($_GET['attID']);
	}
	$NumLine = sizeof($arrayOptionList);
	if($NumLine>0)$NumLine = $NumLine; else $NumLine=4;
}
 
if($_GET['disID'] != "")
{
	$productDiscount = $objProduct->GetDiscountByID($_GET['disID']);
}
 
if(!empty($_POST['CategoryID']))
{
	$categoryIdGetPost = $_POST['CategoryID'];
}
else
{
	$categoryIdGetPost = $categoryIdGetPost;
}
 
$EditUrl = "editProduct.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&CatID=".$categoryIdGetPost."&tab=";
if($_GET["tab"] != "")
{
	if($_GET["tab"] == "editattributes")
	$tabUrl = "viewattributes";
	elseif($_GET["tab"] == "addattributes")
	$tabUrl = "viewattributes";
	elseif($_GET["tab"] == "editDiscount")
	$tabUrl = "discount";
	else
	$tabUrl = $_GET["tab"];
}
$ActionUrl = $EditUrl.$tabUrl;

if (class_exists(category)) {
	$objCategory=new category();
	$arryCategory=$objCategory->GetCategoriesListing(0,0);
	$numCategory=$objCategory->numRows();
} else {
	echo "Class Not Found Error !! Category Class Not Found !";
	exit;
}



/*********  Multiple Actions To Perform **********/
if(!empty($_GET['multiple_action_id'])){
	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
	$RedirectURLPage = "viewProduct.php?curP=".$_GET['curP']."&CatID=".$_GET['dCatID'];
	switch($_GET['multipleAction']){
		case 'delete':
			$objProduct->RemoveMultipleProduct($multiple_action_id,0);
			$_SESSION['mess_product'] = 'Product(s) '.REMOVED;
			break;
		case 'active':
			$objProduct->MultipleProductStatus($multiple_action_id,1);
			$_SESSION['mess_product'] = 'Product(s) '.ACTIVATED;
			break;
		case 'inactive':
			$objProduct->MultipleProductStatus($multiple_action_id,0);
			$_SESSION['mess_product'] = 'Product(s) '.INACTIVATED;
			break;
	}
	header("location: ".$RedirectURLPage);

}

/*********  End Multiple Actions **********/

if($_GET['del_id'] && !empty($_GET['del_id'])){
	$_SESSION['mess_product'] = 'Product(s) '.REMOVED;
	$objProduct->RemoveProduct($_GET['del_id'], $_GET['CategoryID'],0);
	header("location: ".$RedirectURL);
}




if($_GET['featured_id'] && !empty($_GET['featured_id'])){
	 
	$_SESSION['mess_product'] = 'Featured '.STATUS;
	$objProduct->changeFeaturedStatus($_GET['featured_id']);
	header("location: ".$RedirectURL);
	exit;
}

if($_GET['active_id'] && !empty($_GET['active_id'])){
	$_SESSION['mess_product'] = $ModuleName.STATUS;
	$objProduct->changeProductStatus($_GET['active_id']);
	header("location: ".$RedirectURL);
	exit;
}




if (is_object($objProduct)) {
	if ($_POST) {
		 
		if (!empty($_POST['ProductID'])) {
			//$_SESSION['mess_product'] = $MSG[23];
			//$objProduct->UpdateProduct($_POST);
			$ImageId = $_POST['ProductID'];
			$ItemsArray['ItemID'][] = $_POST['ProductID'];
				
			//if($_POST['Status']==1 && $_POST['OldStatus']!=1 && $_POST['PostedByID']>1 ){
			//$objProduct->ProductActiveEmail($_POST['ProductID']);
			//}
			switch($_GET['tab']){
				case 'basic':
					$objProduct->UpdateBasic($_POST);
					$_SESSION['mess_product'] = UPDATE_BASIC;
					break;
				case 'alterimages':
					//$objProduct->UpdateAlterimages($_POST);
					$_SESSION['mess_product'] = UPDATE_IMAGE;
					break;
				case 'other':
					$objProduct->UpdateOther($_POST);
					$_SESSION['mess_product'] = UPDATE_OTHER;
					break;
				case 'description':
					$objProduct->UpdateDescription($_POST);
					$_SESSION['mess_product'] = UPDATE_DESCRIPTION;
					break;
				case 'seo':
					$objProduct->UpdateSeo($_POST);
					$_SESSION['mess_product'] = UPDATE_SEO;
					break;
				case 'addattributes':
					$PattID = $objProduct->InsertAttributes($_POST);
					$_POST['PattID'] = $PattID;
					$objProduct->AddUpdateGlobalAttOption('',$_POST);
					$_SESSION['mess_product'] = INSERT_ATTRIBUTES;
					break;
				case 'editattributes':
					$objProduct->UpdateAttributes($_POST);
					$_POST['PattID'] = $_POST['AttributeId'];
					$objProduct->AddUpdateGlobalAttOption('',$_POST);
					$_SESSION['mess_product'] = UPDATE_ATTRIBUTES;
					break;
				case 'discount':
					$objProduct->InsertDiscount($_POST);
					$_SESSION['mess_product'] = INSERT_DISCOUNT;
					break;
				case 'editDiscount':
					$objProduct->UpdateDiscount($_POST);
					$_SESSION['mess_product'] = UPDATE_DISCOUNT;
					break;
				case 'inventory':
					$objProduct->UpdateInventory($_POST);
					$_SESSION['mess_product'] = UPDATE_INVENTORY;
					break;
				case 'recommended':

					$objProduct->AddRecommendedProduct($_POST);
					$_SESSION['mess_product'] = SAVE_RECOMMENDED;
					break;
				case 'Variant':                                         //By Chetan10Sep//

					$objProduct->UpdateVariantProduct($_POST,'product');
					$_SESSION['mess_product'] = VARIANT_UPDATED;
					break;

			}
			/******************************/
			if ($_SESSION['sync_type'] == 'automatic') {
				$objItem->sync_items($ItemsArray);
			}
			/******************************/
				
		} else {

			$_SESSION['mess_product'] = 'Product'.ADDED;
			$ImageId = $objProduct->AddProduct($_POST);
			/********************Sync Item During added**********************/
			$ItemsArray['ItemID'][] = $ImageId;
			if ($_SESSION['sync_type'] == 'automatic') {
				$objItem->sync_items($ItemsArray);
			}
			/*****************************************/
		}

		/*virtual file upload*/
		if($_FILES['virtual_file']['name'] != ''){
				
			$fileExtension = GetExtension($_FILES['virtual_file']['name']);

			$fileName = $_POST['ProductSku'].".".$fileExtension;

			$MainDir = $Prefix."upload/products/document/".$_SESSION['CmpID']."/";
			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}
			
			$fileDestination = $MainDir.$fileName;
			//echo $fileDestination; die('sdsadssa');

			if(@move_uploaded_file($_FILES['virtual_file']['tmp_name'], $fileDestination)){
				$objProduct->UpdateVirtualFile($fileName,$ImageId);
					
			}else{
				if(!empty($_SESSION['mess_product'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_product'] .= $ErrorPrefix.' Unable to upload file';
			}
				
				
		}
		if($_FILES['Image']['name'] != ''){

			$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
			//echo "=>".$FileArray['ErrorMsg'];exit;
			if(empty($FileArray['ErrorMsg'])){
				$ImageExtension = GetExtension($_FILES['Image']['name']);
				$imageName = $_POST['ProductSku'].".".$ImageExtension;

				$MainDir = $Prefix."upload/products/images/".$_SESSION['CmpID']."/";
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}
				$ImageDestination = $MainDir.$imageName;

				if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
					$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
					unlink($_POST['OldImage']);
				}

				if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
					$objProduct->UpdateImage($imageName,$ImageId);
					$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
				}
			}else{
				$ErrorMsg = $FileArray['ErrorMsg'];
			}
			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_product'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_product'] .= $ErrorPrefix.$ErrorMsg;
			}
		}


		/*****************************/
		if($_GET['tab'] == "alterimages")
		{
			//$objProduct->AddAlternativeImage($ImageId);
			for($i=1;$i<=$_POST['MaxProductImage'];$i++){
				if($_FILES['Image'.$i]['name'] != ''){
						
					$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'.$i],"Image");
					if(empty($FileArray['ErrorMsg'])){

						$ImageExtension = GetExtension($_FILES['Image'.$i]['name']);
						$imageName = $ProdSku."_".$i.".".$ImageExtension;
							
						$MainDir = $Prefix."upload/products/images/secondary/".$_SESSION['CmpID']."/";
						if (!is_dir($MainDir)) {
							mkdir($MainDir);
							chmod($MainDir,0777);
						}

						$ImageDestination = $MainDir.$imageName;
							

						$alt_text = $_POST['alt_text'.$i];
						if(@move_uploaded_file($_FILES['Image'.$i]['tmp_name'], $ImageDestination)){
							$objProduct->UpdateAlternativeImage($ImageId,$imageName,$alt_text);					$objConfigure->UpdateStorage($ImageDestination,0,0);
						}
					}else{
						$ErrorMsg = $FileArray['ErrorMsg'];
					}
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_product'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_product'] .= $ErrorPrefix.$ErrorMsg;
					}

				}

			}
		}
		/***************************/

		if (!empty($_GET['edit'])) {
			header("Location:".$ActionUrl);
			exit;
		}else{
			$EditRedirectURL = "editProduct.php?edit=".$ImageId."&curP=1&CatID=".$_POST['CategoryID']."&tab=basic";
			header("Location:".$EditRedirectURL);
			exit;
		}


			
	}


	if ($_GET['edit'] && !empty($_GET['edit'])) {
		$arryProduct = $objProduct->GetProductEdit($_GET['edit']);
		$ParentID    = $arryProduct[0]['ParentID'];
			
		$ProductSalePrice = $arryProduct[0]['Price'];
		if($ParentID > 0){
			$CategoryID	   = $ParentID;
			$SubCategoryID = $arryProduct[0]['CategoryID'];
		}else{
			$CategoryID = $arryProduct[0]['CategoryID'];
		}
		$ProductID   = $_GET['edit'];
	}

	if($arryProduct[0]['Status'] != ''){
		$ProductStatus = $arryProduct[0]['Status'];
	}else{
		$ProductStatus = 1;
	}
}

$CategoryID = $categoryIdGetPost;


//By Chetan 10Sep//
if($_GET['tab']=='Variant')
{
	$GetVariantList=$objvariant->GetVariant('','');
	$num = $objvariant->numRows();

	$pagerLink = $objPager->getPager($GetVariantList, $RecordsPerPage, $_GET['curP']);
	(count($GetVariantList) > 0) ? ($GetVariantList = $objPager->getPageRecords()) : ("");

	$varient = explode(",",$arryProduct[0]['variant_id']);

}
//End//
//By Bhoodev 29Sep//
if($_GET['tab'] == 'Alias'){
	$arryAlias = $objProduct->GetAliasbySku($arryProduct[0]['ProductSku']);
	//$arryAlias = $objItem->GetAliasbyItemID($arryProduct[0]['ItemID']);
	$AliasNum=COUNT($arryAlias);
	if($_GET['del_alias'] && !empty($_GET['del_alias'])){
		$_SESSION['mess_product'] = ALIAS_REMOVED;
		$objProduct->RemoveAlias($_GET['del_alias'], $_GET['CategoryID'], 0);
		$_SESSION['mess_product'] = ALIAS_REMOVED;
		header("location: editProduct.php?edit=".$_GET['edit']."&CatID=".$_GET['CatID']."&tab=Alias");
	}
}
//End//
if($_GET['tab'] == 'addattributes'){
	//attID
	$NumLine =2;

}

require_once("includes/footer.php");

?>
