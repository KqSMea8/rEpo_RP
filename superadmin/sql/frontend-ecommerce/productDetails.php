<?php

require_once("includes/header.php");
include_once("includes/header_menu.php");
require_once("classes/variant.class.php");
$objvariant = new varient();
$GroupID = $_SESSION['GroupID'];


if (!empty($_GET['id'])) {
    $arryProductDetail = $objProduct->GetProducts($_GET['id'], 0, 0, 1, '',$_GET['AliasID']);
    $arryProductAlternativeImages = $objProduct->GetAlternativeImage($_GET['id']);
    $arryProductAttributes = $objProduct->GetProductAttributesForFront($_GET['id']);

} else if (!empty($_POST['ProductID'])) {

    //Code for addtocart

    $oa_attributes = isset($_POST["oa_attributes"]) ? $_POST["oa_attributes"] : array();
    $oa_attributes = is_array($oa_attributes) ? $oa_attributes : array();

    if (!empty($_POST['Price'])) {
        //By Chetan 11Sep//
        $arr = array();
        //By karishma 5 oct 2015//	
        if (isset($_GET['varselect'])) {
        $varselectval = '';
        $varIDval = '';
        foreach ($_GET['varselect'] as $key => $val) {
            if (is_array($val)) {
               
               
                $varIDval .=$_GET['variantID'][$key] . ',';

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
                $varIDval .=$_GET['variantID'][$key] . ',';


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

        /* if(isset($_POST['variantID']))
          {
          array_push($arr,array('variantID' => $_POST['variantID'], 'variantVal'=>$_POST['variantVal']));

          } */
        $objOrder->AddToCart($_POST['ProductID'], $Cid, $_POST['Quantity'], $oa_attributes, $arr);
        //End//
        $objOrder->checkQuantityDiscounts($Cid);
        header("location: productDetails.php?id=" . $_POST['ProductID']);
        exit;
    }

    //end code
} else {
    header("location: index.php");
    exit;
}

if ($settings['AfterProductAddedGoTo'] == "Current Page") {
    $formMethod = 'method="post" action="productDetails.php"';
} else {
    $formMethod = 'method="post" action="cart.php"';
}


/* * *******************Code for product Review/Rating/Recommended*************************** */
if (!empty($_POST['Rating'])) {
    $InsertId = $objProduct->AddProductReview($_POST);
    if (!empty($InsertId)) {
        $_SESSION['successMsg'] = REVIEW_THANK;
        header("location: productDetails.php?id=" . $arryProductDetail[0]['ProductID'] . "&review=1");
        exit;
    }
}

if ($arryProductDetail[0]['ProductID'] > 0) {
    $arryProductReview = $objProduct->getReviewsByProduct($arryProductDetail[0]['ProductID']);
    $TotalProductRating = $objProduct->countProductRating($arryProductDetail[0]['ProductID']);
    if (count($arryProductReview) > 0) {
        $AvgProductRating = $TotalProductRating[0]['total'] / count($arryProductReview);
    }
    $arryProductRecommended = $objProduct->getRecommendedByProduct($arryProductDetail[0]['ProductID']);
    $num = $objProduct->numRows();


    /*     * ************************************End Code Review/Rating***************************************************** */


    /*     * *******************Code for product Discount AND WISHLIST*************************** */
    $arryProductDiscount = $objProduct->getDiscountByProduct($arryProductDetail[0]['ProductID']);
    if (!empty($_SESSION['Cid'])) {
        $arryWishlist = $objProduct->getWishlist($_SESSION['Cid']);
    }

    if (!empty($_POST['Wlid'])) {
        $oa_attributes = isset($_REQUEST["oa_attributes"]) ? $_REQUEST["oa_attributes"] : array();
        $oa_attributes = is_array($oa_attributes) ? $oa_attributes : array();

        $addedProduct = $objProduct->addProductWishlist($_POST, $oa_attributes);
    }

    if (!empty($_POST['Name']) && !empty($_POST['WhishlistCid'])) {

        $addedProduct = $objProduct->addWishlist($_POST, $oa_attributes);
    }


    /*     * *******************EndCode for product Discount*************************** */


    //$GroupPrice= json_decode($arryProductDetail[0]['GroupPrice'], true);


    $SalePrice = ($arryProductDetail[0]['Price'] > 0) ? ($arryProductDetail[0]['Price']) : ($arryProductDetail[0]['Price']);
    //$SalePrice = ($GroupPrice[$GroupID]>0)?$GroupPrice[$GroupID]:(($arryProductDetail[0]['Price']>0)?($arryProductDetail[0]['Price']):($arryProductDetail[0]['Price']));
    $PrdLink = $Config['Url'] . $Config['DisplayName'] . '/productDetails.php?id=' . $arryProductDetail[0]['ProductID'];
    $CartLink = 'cart.php?ProductID=' . $_GET['id'] . '&Price=' . round($Price, 2) . '&StoreID=' . $arryProductDetail[0]['PostedByID'] . '&Tax=' . round($Tax, 2);
    $SalePriceHTML = display_price($SalePrice, '', '', '', '');
    $PriceHTML = display_price($arryProductDetail[0]['Price2'], '', '', '', '');
    if($arryProductDetail[0]['Price2']=='0.00000') $PriceHTML='';
    //$PriceHTML = ($GroupPrice[$GroupID]>0)?number_format($arryProductDetail[0]['Price'], 2, '.', ''):(display_price($arryProductDetail[0]['Price2'],'','','',''));
    //***** Similar Items *************/
    //$arrySimilarItems=$objProduct->SimilarProducts($_GET['id'],$arryProductDetail[0]['CategoryID'],1);
    $ImageLocation = 'resizeimage.php?img=upload/products/images/' . $arryProductDetail[0]['Image'] . '&w=160&h=160';
    $objRecent->add($PrdLink, $arryProductDetail[0]['Name'], $ImageLocation, $SalePrice);

    /*     * ************************* */
    $_GET['cat'] = $arryProductDetail[0]['CategoryID'];
    $Mid = $arryProductDetail[0]['Mid'];
    if ($Mid > 0) {
        $ManufacturerName = $objManufacturer->getManufacturerByProductId($Mid);
    }
}
/* * *******Send Email To Friend ************** */


if ($_POST['Submit'] == "Email to a Friend") {
    $sendMail = $objProduct->emailToFriend($_POST);
    if ($sendMail == 1) {
        $_SESSION['successMsg'] = SENT_FRIEND_EMAIL;
    }
}
/* * *******End Email To Friend ************** */

$objProduct->UpdateViewedDate($_GET['id']);




require_once("includes/footer.php");
?>
