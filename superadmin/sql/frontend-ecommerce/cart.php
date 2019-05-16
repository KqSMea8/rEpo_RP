<?php
require_once("includes/header.php");
include_once("includes/header_menu.php");
require_once("classes/company.class.php");

$objCompany = new company();
if (empty($_SESSION["guestId"])) {
    $Cid = (!empty($_SESSION['Cid'])) ? ($_SESSION['Cid']) : (session_id());
} else {
    $Cid = isset($_SESSION["guestId"]) ? $_SESSION["guestId"] : "";
}

$oa_attributes = isset($_REQUEST["oa_attributes"]) ? $_REQUEST["oa_attributes"] : array();
$oa_attributes = is_array($oa_attributes) ? $oa_attributes : array();


print_r($_FILES['uploadFile']);

// if (!empty($_GET['Price'])) {
if (!empty($_POST['Quantity'])) {
    //By Chetan14Sep//
    $arr = array();
    //By karishma 5 oct 2015//

    if (isset($_POST['varselect'])) {
        $varselectval = '';
        $varIDval = '';
        foreach ($_POST['varselect'] as $key => $val) {
            if (is_array($val)) {
               
               
                $varIDval .=$_POST['variantID'][$key] . ',';

                $objVariant = new varient();
                $variants = $objVariant->GetVariantDispaly($key);
                $Variant_Val = implode(',', $val);

                $variantVal = $objVariant->GetMultipleVariantOption($key, $Variant_Val);
                if (count($variantVal) > 1) {
                    $vals = array_map(function($arr) {
                        return $arr['option_value'];
                    }, $variantVal);
                    $vals = implode(",", $vals);
                } else {
                    $vals = $variantVal[0]['option_value'];
                }
                $varselectval[$key] = $vals;
                
            } elseif ($val != '') {
                $varselectval[$key] = $val;
                $varIDval .=$_POST['variantID'][$key] . ',';


                $objVariant = new varient();
                $variants = $objVariant->GetVariantDispaly($key);
                $Variant_Val = $val;

                $variantVal = $objVariant->GetMultipleVariantOption($key, $Variant_Val);
                if (count($variantVal) > 1) {
                    $vals = array_map(function($arr) {
                        return $arr['option_value'];
                    }, $variantVal);
                    $vals = implode(",", $vals);
                } else {
                    $vals = $variantVal[0]['option_value'];
                }
                 $varselectval[$key] = $vals;
            }
        }
         $varselectval = json_encode($varselectval);  


        $varIDval = substr($varIDval, 0, -1);
        array_push($arr, array('variantID' => $varIDval, 'variantVal' => $varselectval));
    }

   

    /* if(isset($_GET['variantID']))
      {
      array_push($arr,array('variantID' => implode($_GET['variantID']), 'variantVal'=>$_GET['variantVal']));

      } */
	
    $objOrder->AddToCart($_POST['ProductID'], $Cid, $_POST['Quantity'], $oa_attributes, $arr,$_POST['AliasID'],$_FILES['uploadFile']);
    //End//
    $objOrder->checkQuantityDiscounts($Cid);
    header("location: cart.php");
    exit;
} else if (!empty($_REQUEST['oid']) && $_REQUEST['action'] == "reorder") {

    $objOrder->ReOrder($_REQUEST['oid'], $Cid);
    $objOrder->checkQuantityDiscounts($Cid);
    $_SESSION['successMsg'] = CART_REORDER;
    header("location: cart.php");
    exit;
} else if ($_POST['CartSubmit'] == '1') {
    $objOrder->UpdateCart($_POST);
    $arryNumCart = $objOrder->GetNumItemCart($Cid);
    $objOrder->checkQuantityDiscounts($Cid);

    if (!empty($_POST['CartSubmitFromCheckOut'])) {
        header("location: checkout.php");
        exit;
    } else {
        $_SESSION['successMsg'] = CART_UPDATED;
        header("location: cart.php");
        exit;
    }
} else if (!empty($_REQUEST['Wlpid'])) {
    $wl_product = $objProduct->getWishlistProduct($_REQUEST['Wlpid']);
    $variantArr[0]['variantID']=$wl_product["Variant_ID"];
    $variantArr[0]['variantVal']=$wl_product["Variant_val_Id"];
    
    $objOrder->AddToCart($wl_product["ProductID"], $Cid, "1", $wl_product["product_attributes"],$variantArr,$wl_product["AliasID"],$_FILES['uploadFile']);
    $objOrder->checkQuantityDiscounts($Cid);
    header("location: cart.php");
    exit;
} else if (!empty($_REQUEST['Wlid'])) { 
    $wl_products = $objProduct->GetProductByWishListId($Cid, $_REQUEST['Wlid']);
    
    foreach ($wl_products["whishlist_products"] as $product) {
        //if ($product["out_of_stock"] == "No" || $product["out_of_stock"] == "")
        //{
        $variantArr[0]['variantID']=$product["Variant_ID"];
        $variantArr[0]['variantVal']=$product["Variant_val_Id"];
        $wl_product = $objProduct->getWishlistProduct($product["Wlpid"]);
        $objOrder->AddToCart($wl_product["ProductID"], $Cid, "1", $wl_product["product_attributes"],$variantArr,$product["AliasID"],$_FILES['uploadFile']);
        $objOrder->checkQuantityDiscounts($Cid);
        //}
    }

    header("location: cart.php");
    exit;
} else {

    $objOrder->checkQuantityDiscounts($Cid);
}




$arryCart = $objOrder->GetCart($Cid);

$numCart = $objOrder->numRows();

$CartSubtotalAmount = $objOrder->getCartSubtotalAmount($Cid);
// echo "=>".$SubtotalAmount;
$discountDetails = $objDiscount->getDiscountAmount($CartSubtotalAmount, $Cid);

$discountAmount = $discountDetails['discountAmount'];
$_SESSION['discountValue'] = $discountDetails['discountValue'];
$_SESSION['discountType'] = $discountDetails['discountType'];

if (!empty($_SESSION['promo_code'])) {
    $promo_result = $objDiscount->checkPromoCode($CartSubtotalAmount, $_SESSION['promo_code'], $Cid);

    $_SESSION['promo_discount_amount'] = $promo_result['promo_discount_amount'];
}


// calculate  group discount
if ($groupDiscont) {

    $PayableCartAmount = $CartSubtotalAmount - $discountAmount - $_SESSION['promo_discount_amount'];
    $type = $groupDiscont['type'];
    $val = $groupDiscont['val'];
    if ($type == 'percent') {
        $GroupdiscountAmount = $PayableCartAmount * $val / 100;
    } elseif ($type == 'flat' && $PayableCartAmount >= $val) {

        $GroupdiscountAmount = $val;
    }

    $_SESSION['groupDiscontSetting'] = $groupDiscont;
}
?>

<?

require_once("includes/footer.php"); 
?>
