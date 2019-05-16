<?
session_start();
$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix . "classes/item.class.php");
require_once($Prefix."classes/configure.class.php");

$objConfig = new admin();
$objItem = new items();

/* * ******Connecting to main database******** */
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
$ItemID = isset($_REQUEST['ItemID']) ? $_REQUEST['ItemID'] : "";
$catID = isset($_REQUEST['CatID']) ? $_REQUEST['CatID'] : "";

$ImageId = isset($_REQUEST['ImgVal']) ? $_REQUEST['ImgVal'] : "";
$Sku = isset($_REQUEST['Sku']) ? $_REQUEST['Sku'] : "";





if ($action == "deleteImage"){
    $tab = "alterimages";
}
else{
    $ActionUrl = "editItem.php?edit=" . $ItemID . "&curP=1&CatID=" . $catID . "&tab=" . $tab;
}

if ($action != "") {
    switch ($action) {

       

        case 'deleteImage':
           
            $checkImage = $objItem->deleteImage($ItemID, $ImageId);
            if (isset($checkImage)) {
                $_SESSION['mess_product'] = 'Item image has been deleted successfully.';
                echo $ActionUrl;
            }
            break;
            exit;

        case 'checkProductSku':
            $checkSku = $objItem->checkProductSku($ProductSku);

            if (count($checkSku) > 0) {
                echo "1";
            } else {
                echo "0";
            }
            break;
            exit;

      

       
           
            
            
            
            
    }
}
?>
