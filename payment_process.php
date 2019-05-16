<?php
session_start();
require_once("includes/header.php");

include_once("includes/header_menu.php");


//ValidateMemberSession($ThisPage);

        global $Config;

        $payment_method = $_POST['payment_method'];


        if (empty($arryNumCart[0]['NumCartItem'])) {
            header('location:cart.php');
            exit;
        }

        if (empty($_SESSION["guestId"])) {
            $Cid = isset($_SESSION['Cid']) ? $_SESSION['Cid'] : "";
        } else {
            $Cid = isset($_SESSION["guestId"]) ? $_SESSION["guestId"] : "";
        }

        if (!empty($_POST['ProductIDs'])) {


            $_SESSION['OrderID'] = $objOrder->AddOrder($_POST);
           
            if($settings["DiscountsPromo"] == "Yes" && !empty($_SESSION['promo_discount_amount']))
            {
                $objDiscount->addPromoHistory($_SESSION['promo_campaign_id'],$_SESSION['OrderID'],$Cid,$_SESSION['promo_discount_amount']);
                
            }

            //$objOrder->RemoveCart($_POST['MemberID']);
            $_SESSION['ProductIDs'] = $_POST['ProductIDs'];

            if ($_SESSION['add_to_address_book'] == "Yes") {
                $objCustomer->UpdateCustomerShippingAddressFromCheckout($Cid);
            }
        }

        if (empty($_SESSION['OrderID'])) {
            echo 'Invalid Transaction';
            exit;
        }



        $failUrl = $Config['homeCompleteUrl'] . "/cancelOrder.php?cid=" . base64_encode($Cid);
        $successUrl = $Config['homeCompleteUrl'] . "/completed.php?cid=" . base64_encode($Cid) . '&OrderID=' . base64_encode($_SESSION['OrderID']) . '&pg=' . $payment_method;
        $notifyUrl = $Config['homeCompleteUrl'] . "/notify.php?cid=" . base64_encode($Cid) . '&OrderID=' . base64_encode($_SESSION['OrderID']) . '&pg=' . $payment_method;

        if(!empty($_POST['TotalPrice'])){
            
            $Config['DbName'] = $Config['DbMain'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();
            
             $arryPayCurrency = $objRegion->getPaymentCurrency($Config['paypalipn_Currency_Code']);
             $PaypalCurrencyVal = $arryPayCurrency[0]['currency_value']/$Config['CurrencyCompanyVal'];
           
             $totalPriceForPaypal = $_POST['TotalPrice']*$PaypalCurrencyVal;
			 
			 $totalPriceForPaypal = number_format($totalPriceForPaypal, 2, '.', '');
        }


        switch ($payment_method) {

            case 'cashondelivary':
                 echo "<div align='center' style='padding:200px; font-size: 16px; font-weight: bold;'><img src='../images/ajaxloader.gif'><br>Please Wait... </div>";
                $successUrl = $Config['homeCompleteUrl'] . "/completed.php?cid=" . base64_encode($Cid) . '&OrderID=' . base64_encode($_SESSION['OrderID']) . '&pg=' . $payment_method . '';
                header('Location:' . $successUrl);
                exit;
                break;

            case 'paypalipn':
                if($settings['paypalipn_Mode'] == "TEST"){
                    $actionUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                }else{
                    $actionUrl = "https://secure.paypal.com/cgi-bin/webscr";
                }
                $formdata = '<form name="myPayPal" action="'.$actionUrl.'"  method="post" id="payPalForm">';
                $formdata .= '<input type="hidden" name="business" value="'.$settings['paypalipn_business'].'">';
                $formdata .= '<input type="hidden" name="receiver_email" value="'.$settings['paypalipn_business'].'">';
                $formdata .= '<input type="hidden" name="item_name" value="'.$settings['StoreName'].' Order #'.$_SESSION['OrderID'].'">';
                $formdata .= '<input type="hidden" name="item_number" value="'.$_SESSION['OrderID'].'">';
                $formdata .= '<input type="hidden" name="first_name" value="'.$_POST['BillingName'].'">';
                $formdata .= '<input type="hidden" name="address1" value="'.$_POST['BillingAddress'].'">';
                $formdata .= '<input type="hidden" name="city" value="'.$_POST['BillingCity'].'">';
                $formdata .= '<input type="hidden" name="state" value="'.$_POST['BillingState'].'">';
                $formdata .= '<input type="hidden" name="zip" value="'.$_POST['BillingZip'].'">';


                $formdata .= '<input type="hidden" name="currency_code" value="'.$settings['paypalipn_Currency_Code'].'">';
                $formdata .= '<input type="hidden" name="cmd" value="_xclick">';
                $formdata .= '<input type="hidden" name="bn" value="PCart_cart_IPN_US">';

                $formdata .= '<input type="hidden" name="quantity" value="1">';
                $formdata .= '<input type="hidden" name="invoice" value="'.$_SESSION['OrderID'].'">';
                $formdata .= '<input type="hidden" name="custom" value="'.$_SESSION['OrderID'].'">';
                $formdata .= '<input type="hidden" name="shipping" value="0.00">';
                $formdata .= '<input type="hidden" name="amount" value="'.$totalPriceForPaypal.'">';

                $formdata .= '<input type="hidden" name="address_name" value="'.$_POST['ShippingName'].'">';
                $formdata .= '<input type="hidden" name="address_street" value="'.$_POST['ShippingAddress'].'">';
                $formdata .= '<input type="hidden" name="address_city" value="'.$_POST['ShippingCity'].'">';
                $formdata .= '<input type="hidden" name="address_state" value="'.$_POST['ShippingState'].'">';
                $formdata .= '<input type="hidden" name="address_zip" value="'.$_POST['ShippingZip'].'">';
                $formdata .= '<input type="hidden" name="address_country" value="'.$_POST['ShippingCountry'].'">';
                $formdata .= '<input type="hidden" name="address_status" value="unconfirmed">';

                $formdata .= '<input type="hidden" name="country" value="'.$_POST['BillingCountry'].'">';
                $formdata .= '<input type="hidden" name="email" value="'.$_POST['Email'].'">';
                $formdata .= '<input type="hidden" name="no_shipping" value="2">';


                $formdata .= '<input type="hidden" name="payer_id" value="'.$_POST['Cid'].'">';
                $formdata .= '<input type="hidden" name="notify_version" value="1.6">';
                $formdata .= '<input type="hidden" name="notify_url" value="' . $notifyUrl . '">';
                $formdata .= '<input type="hidden" name="return" value="' . $successUrl . '">';
                $formdata .= '<input type="hidden" name="cancel_return" value="' . $failUrl . '">';

                $formdata .= '</form>';
                echo $formdata;
                echo "<div align='center' style='padding:200px; font-size: 16px; font-weight: bold;'><img src='../images/ajaxloader.gif'><br>Please wait and do not press BACK or REFRESH button of your browser.
                              <br>Please be patient while your transaction is being processed....</div>";
                echo "<script> document.getElementById('payPalForm').submit();</script>";
                exit;
                break;
        }




        require_once("includes/footer.php");
        ?>

   