<?
session_start();
$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix."includes/function.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix . "classes/product.class.php");
require_once($Prefix . "classes/cartsettings.class.php");
require_once($Prefix . "classes/manufacturer.class.php");
require_once($Prefix.  "classes/customer.class.php");
require_once($Prefix.  "classes/discount.class.php");
require_once($Prefix."classes/configure.class.php");
$objConfig = new admin();
$objProduct = new product();
$objCartSettings = new Cartsettings();
$objManufacturer = new manufacturer();
$objCustomer = new Customer();
$objDiscount = new discount();
	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

/* * ******Connecting to main database******** */
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */
CleanGet();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
$productID = isset($_REQUEST['productID']) ? $_REQUEST['productID'] : "";
$catID = isset($_REQUEST['CatID']) ? $_REQUEST['CatID'] : "";
$attrVal = isset($_REQUEST['attrVal']) ? $_REQUEST['attrVal'] : "";
$discVal = isset($_REQUEST['discVal']) ? $_REQUEST['discVal'] : "";
$ImageId = isset($_REQUEST['ImgVal']) ? $_REQUEST['ImgVal'] : "";
$ProductSku = isset($_REQUEST['ProductSku']) ? $_REQUEST['ProductSku'] : "";

$Ssid = isset($_REQUEST['Ssid']) ? $_REQUEST['Ssid'] : "";
$Srid = isset($_REQUEST['Srid']) ? $_REQUEST['Srid'] : "";
$MethodId = isset($_REQUEST['MethodId']) ? $_REQUEST['MethodId'] : "";
$Mcode = isset($_REQUEST['Mcode']) ? $_REQUEST['Mcode'] : "";
$chrCode = isset($_REQUEST['chrcode']) ? $_REQUEST['chrcode'] : "";
$TemplateId = isset($_REQUEST['TemplateId']) ? $_REQUEST['TemplateId'] : "";


if ($action == "deleteAttribute"){
    $tab = "viewattributes";
}
elseif ($action == "deleteDiscount"){
    $tab = "discount";
}
elseif ($action == "deleteDiscount"){
    $tab = "discount";
}
elseif ($action == "deleteImage"){
    $tab = "alterimages";
}
else{
    $tab = "";
}
    
    $ActionUrl = "editProduct.php?edit=" . $productID . "&curP=1&CatID=" . $catID . "&tab=" . $tab;


if ($action != "") {
    switch ($action) {

        case 'deleteAttribute':
            $checkAttr = $objProduct->deleteAttribute($productID, $attrVal);
            if (isset($checkAttr)) {
                $_SESSION['mess_product'] = 'Product attributes has been deleted successfully.';
                echo $ActionUrl;
            }
            break;
            exit;
        case 'deleteDiscount':
            $checkDisc = $objProduct->deleteDiscount($productID, $discVal);
            if (isset($checkDisc)) {
                $_SESSION['mess_product'] = 'Product discount has been deleted successfully.';
                echo $ActionUrl;
            }
            break;
            exit;

        case 'deleteImage':
            $checkImage = $objProduct->deleteImage($productID, $ImageId);
            if (isset($checkImage)) {
                $_SESSION['mess_product'] = 'Product image has been deleted successfully.';
                echo $ActionUrl;
            }
            break;
            exit;

        case 'checkProductSku':
            $checkSku = $objProduct->checkProductSku($ProductSku);

            if (count($checkSku) > 0) {
                echo "1";
            } else {
                echo "0";
            }
            break;
            exit;

        case 'checkManufacturer':
            $checkSku = $objManufacturer->checkManufacturer($Mcode);

            if (count($checkSku) > 0) {
                echo "1";
            } else {
                echo "0";
            }
            break;
            exit;

        case 'deleteShippingRate':
            $checkDelete = $objCartSettings->deleteShippingRate($Srid, $Ssid);
            $ActionUrl = "shippingRates.php?curP=1&Ssid=" . $Ssid . "&MethodId=" . $MethodId . "";
            if (isset($checkDelete)) {
                $_SESSION['mess_ship'] = 'Shipping Rate has been deleted successfully.';
                echo $ActionUrl;
            }
            break;
            exit;
            
            case 'getSubscriber':
            $getSubscribers = $objCustomer->GetSubcribersForEmail($chrCode);
          
            if (count($getSubscribers) > 0) {
                
                foreach($getSubscribers as $k)
                {
                    $strEmail .= '<span> <input type="checkbox" name="Email[]"  value="'.$k['Email'].'">'.$k['Email'].'</span>';
                }
                
                echo $strEmail;
            }
            break;
            exit;
            
           case 'getNewsletterTemplate':
            $getNewsletterTemplate = $objCustomer->getNewsletterTemplateById($TemplateId);
            if (count($getNewsletterTemplate) > 0) {
                
                 $contentHtml = $getNewsletterTemplate[0]['Template_Subject']."##".$getNewsletterTemplate[0]['Template_Content'];
                  echo $contentHtml;
            }
            else {
                echo "";
            }
           
            break;
            exit;
            
            case 'checkTaxClass':
                $TaxClassName = isset($_REQUEST['ClassName'])?$_REQUEST['ClassName']:"";
            $getTaxClass = $objCartSettings->CheckTaxClass($TaxClassName);
            if (count($getTaxClass) > 0) {
                
                echo "Yes";
            }
            else {
                echo "";
            }
           
            break;
            exit;
            
             case 'checkCustomerGroupName':
                 $GroupName = isset($_REQUEST['GroupName'])?$_REQUEST['GroupName']:"";
                 $getGroupName = $objCustomer->checkCustomerGroupName($GroupName);
            if (count($getGroupName) > 0) {
                
                echo "Yes";
            }
            else {
                echo "";
            }
           
            break;
            exit;
            
            case 'checkPromoCode':
                 $PromoCode = isset($_REQUEST['PromoCode'])?$_REQUEST['PromoCode']:"";
                 $getPromoCode = $objDiscount->checkPromoCodeExists($PromoCode);
            if (count($getPromoCode) > 0) {
                
                echo "Yes";
            }
            else {
                echo "";
            }
           
            break;
            exit;
            
            
    }
}
?>
