<?php

/*
  session_start();
  require_once("define.php");

  require_once("includes/config.php");
  require_once("classes/dbClass.php");
  require_once("includes/function.php");
  require_once("classes/region.class.php");
  require_once("classes/admin.class.php");
  require_once("classes/MyMailer.php");
  require_once("classes/orders.class.php");
  require_once("classes/leave.class.php");
  require_once("classes/time.class.php");
  require_once("classes/customer.class.php");
  require_once("classes/orders.class.php");
  require_once("classes/cartsettings.class.php");
  require_once("classes/payment.class.php");
  require_once("classes/region.class.php");
  require_once("classes/paypal_pro.inc.php");

  $objConfig=new admin();
 */

require_once("includes/settings.php");
/* * ******Connecting to main database******** */


if (!empty($_POST['task'])) {
    $responce = array();
    switch ($_POST['task']) {
        case 'login':
            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $_SESSION['CmpDatabase'];
            $objConfig->connect();
            $objCustomer = new Customer();
            $objOrder = new orders();
            if ($arryMember = $objCustomer->ValidateCustomer($_POST['email'], $_POST['password'], $_POST['type'])) {

                if (md5($_POST['password']) != $arryMember[0]['Password']) {
                    $responce['errorMsg'] = INVALID_LOGIN;
                } else {
                    //print_r($arryMember);
                    //echo $arryMember[0]['Type']; exit;
                    $objCustomer->updateSessionCustomer($arryMember[0]['Cid']);
                    $responce['userDetail'] = $arryMember[0];
                    $_SESSION['Password'] = $arryMember[0]['Password'];
                    $_SESSION['Email'] = $arryMember[0]['Email'];
                    $_SESSION['Cid'] = $arryMember[0]['Cid'];
                    $_SESSION['Level'] = $arryMember[0]['Level'];
                    $_SESSION['GroupID'] = $arryMember[0]['GroupID'];
                    $_SESSION['Name'] = ucfirst($arryMember[0]['FirstName']) . ' ' . ucfirst($arryMember[0]['LastName']);
                    $_SESSION['CompanyName'] = $arryMember[0]['Company'];

                    if (!empty($_POST['Remember'])) {
                        setcookie("RememberUserName", $arryMember[0]['Email'], time() + (5 * 3600));
                        setcookie("RememberPassword", $arryMember[0]['Password'], time() + (5 * 3600));
                    }
                    $arryCart = $objOrder->GetCart(session_id());
                    $numCart = $objOrder->numRows();
                    if ($numCart > 0) {
                        $PrdIDs = '';
                        foreach ($arryCart as $key => $values) {
                            $PrdIDs .= $values['ProductID'] . ',';
                        }
                        $objCustomer->UpdateCustomerCart($_SESSION['Cid'], $PrdIDs);
                    }
                    $responce['userDetail']['AddressDetail'] = $objCustomer->getShippingAddresses($arryMember[0]['Cid']);
                }
            } else {
                $responce['errorMsg'] = INVALID_LOGIN;
            }
            echo json_encode($responce);
            exit;

            break;

        case 'guestLogin':
            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $_SESSION['CmpDatabase'];
            $objConfig->connect();
            $objCustomer = new Customer();
            $objOrder = new orders();
            $guestCustomerId = $objCustomer->expressLogin();
            $Cid = $_SESSION["guestId"];

            $arryCart = $objOrder->GetCart(session_id());
            $numCart = $objOrder->numRows();
            if ($numCart > 0) {
                $PrdIDs = '';
                foreach ($arryCart as $key => $values) {
                    $PrdIDs .= $values['ProductID'] . ',';
                }
                $objCustomer->UpdateCustomerCart($_SESSION['guestId'], $PrdIDs);
                //header('location:checkout.php');
                //exit;
            }
            if (!empty($Cid)) {
                $responce['userDetail'] = $objCustomer->getCustomerById($Cid);
                $responce['address'] = $objCustomer->getShippingAddresses($Cid);
            } else {
                $responce['errorMsg'] = INVALID_LOGIN;
            }
            echo json_encode($responce);
            exit;
            break;
        case 'saveAddress':
            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $_SESSION['CmpDatabase'];
            $objConfig->connect();
            $objCustomer = new Customer();
            $objcartsettings = new Cartsettings();
           
            $addreassvalue = $_POST['addressdata'];
            
            if ($_POST['isregistration'] == 'yes') {
                $rr = SaveUser($addreassvalue);

                if ($rr === false) {
                    $responce['errorMsg'] = 'Email allready exist';
                    $responce['emailValidation'] = 'Email allready exist';
                    echo json_encode($responce);
                    die;
                }
            }
            // SaveUser()

            $_SESSION['DelivaryDate'] = !empty($addreassvalue['DelivaryDate']) ? $addreassvalue['DelivaryDate'] : "";
            $_SESSION['shipping_address_id'] = !empty($addreassvalue['shipping_address_id']) ? $addreassvalue['shipping_address_id'] : "";
            $_SESSION['add_to_address_book'] = !empty($addreassvalue['add_to_address_book']) ? $addreassvalue['add_to_address_book'] : "";
            $countryId = !empty($addreassvalue['country_id_shipp']) ? $addreassvalue['country_id_shipp'] : "";
            $stateId = !empty($addreassvalue['main_state_id_shipp']) ? $addreassvalue['main_state_id_shipp'] : "";
            $_SESSION['AddressType'] = !empty($addreassvalue['AddressType']) ? $addreassvalue['AddressType'] : "";
            //
                 
                
                
            if (!empty($addreassvalue)) {
                if (!empty($_SESSION['Cid']))
                    $addreassvalue['Cid'] = $_SESSION['Cid'];
                else if ($_SESSION['guestId'])
                    $addreassvalue['Cid'] = $_SESSION['guestId'];
                if (!empty($addreassvalue['Cid'])) { 
                    $objCustomer->UpdateCustomerFromCheckoutPage($addreassvalue); 
                    if($addreassvalue['add_to_address_book'] == "Yes")
                    {
                        $objCustomer->addShippingAddressFromCheckout($addreassvalue);
                    }
                    
                     $responce['Shippingmethod'] = $objcartsettings->getShippingMethods($countryId, $stateId);
                }                
                else {
                    $responce['errorMsg'] = INVALID_LOGIN;
                }
               
            }
            echo json_encode($responce);
            exit;
            break;
        case 'shippingmethod':
            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $_SESSION['CmpDatabase'];
            $objConfig->connect();
            $objPayment = new payment();
            $objCustomer = new Customer();
            $objOrder = new orders();
            $objcartsettings = new Cartsettings();
            $objRegion = new region();
            //$settings = array();
            if (empty($_SESSION["guestId"]))
                $Cid = isset($_SESSION['Cid']) ? $_SESSION['Cid'] : "";
            else
                $Cid = isset($_SESSION["guestId"]) ? $_SESSION["guestId"] : "";

            if (!empty($_POST['method'])) {
                $_SESSION['Ssid'] = isset($_POST['method']) ? $_POST['method'] : "";
            }

            $arryCart = $objOrder->GetCart($Cid);
            $numCart = $objOrder->numRows();
            if ($numCart > 0) {
                $TotalWeight = 0;
                $SubTotal = 0;
                $TotalItems = 0;
                $TotalQuantity = 0;
                $TaxAmount = 0;
                $TotalWeight = 0;

				
                foreach ($arryCart as $key => $values) {
					// added ny karishma 13 oct for alias
					$ProductName=(!empty($values['AliasID'])) ? ($values['ItemAliasCode']) : ($values['Name']);
                	$arryCart[$key]['Name'] = $ProductName;
                	
                	// end
                    $GroupPrice = json_decode($values['GroupPrice'], true);
                    $SubTotal += ($GroupPrice[$GroupID] > 0) ? ($values['Quantity'] * $GroupPrice[$GroupID]) : ($values['Quantity'] * $values['Price']);
                    $ProductIDs .= $values['ProductID'] . ",";
                    $TotalQuantity += $values['Quantity'];
                    $TaxAmount += $values['Quantity'] * $values['Price'] * $values['TaxRate'] / 100;

                    $TotalWeight += ($values['Quantity'] * $values['Weight']);
					$TotalItems++;
                    // added by karishma
                    $Variant_ID = $values['Variant_ID'];
                    $Variant_val_Id = $values['Variant_val_Id'];

                    $Variant_IDArray = explode(',', $Variant_ID);
                    $Variant_val_IdArray = json_decode($Variant_val_Id, true);
                    $objVariant = new varient();
                    $variant_name = '';
                    foreach ($Variant_IDArray as $key1 => $val1) {
                    	if($val1!=''){
                    		$variants = $objVariant->GetVariantDispaly($val1);
                        if (is_array($Variant_val_IdArray[$val])) {

                            $vals = implode(',', $Variant_val_IdArray[$val1]);
                        } else {

                            $vals = $Variant_val_IdArray[$val1];
                        }

                        $variant_name .= $variants[0]['variant_name'] . '(' . $vals . ')<br>';
                    	}
                        
                    }

                    $arryVariant[$key]['Name'] = $variant_name;

                    $arryCart[$key]['ProductDisplayPrice'] = display_price($values['Price'], '', '', '', '');
                    $arryCart[$key]['ProductDisplayTotalPrice'] = display_price($values['Quantity'] * $values['Price'], '', '', '', '');
                    $AttrVal='';
                	if (!empty($values['OptionsAttribute'])) {
                                            	
                                              $optionArr= json_decode($values['OptionsAttribute']);
                                                foreach($optionArr as $val){
                                               		$AttrVal .= $val;
                                                	$AttrVal .= '<br>';
                                                }
												
                     }
                                            
                                                         
                    $arryCart[$key]['DiplayAttribute'] = $AttrVal;
                    
                    // end karishma
                }






                if (!empty($_SESSION['Ssid'])) {

                    $shippingCharge = $objcartsettings->getCustomShippingPrice($_SESSION['Ssid'], $TotalWeight, $TotalItems, $SubTotal);
                    $shippingMethod = $objcartsettings->getShippingMethodById($_SESSION['Ssid']);
                }
                $shippingCharge = number_format($shippingCharge, 2, '.', '');
                //$arryCustomer = $objCustomer->getCustomerById($Cid);
                //$address 		= $objCustomer->getShippingAddressById($_SESSION['shipping_address_id']);
                //Calculate Price  
                $orderdata = array();

                $orderdata['SubTotalPrice'] = display_price($SubTotal, '', '', '', '');
                $orderdata['Shipping'] = display_price($shippingCharge, '', '', '', '');
                $orderdata['TaxAmount'] = display_price($TaxAmount, '', '', '', '');

                $_SESSION['TotalQuantity'] = rtrim($TotalQuantity, ",");
                $SubTotalPrice = $SubTotal;
                $TotalPrice = $SubTotal + $shippingCharge + $TaxAmount;

                if ($_SESSION['discountAmount'] > 0) {
                    $TotalPrice = $TotalPrice - $_SESSION['discountAmount'];
                    $discountAmount +=$_SESSION['discountAmount'];
                }
                if ($_SESSION['promo_discount_amount'] > 0) {
                    $TotalPrice = $TotalPrice - $_SESSION['promo_discount_amount'];
                    $discountAmount +=$_SESSION['promo_discount_amount'];
                }
                if ($_SESSION['GroupdiscountAmount'] > 0) {
                    $TotalPrice = $TotalPrice - $_SESSION['GroupdiscountAmount'];
                    $discountAmount +=$_SESSION['GroupdiscountAmount'];
                }

                $orderdata['discountAmount'] = display_price($discountAmount, '', '', '', '');
            }
            $responce['paymentmethod'] = $objPayment->getActivePaymentMethods();

            $Config['DbName'] = $Config['DbMain'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();
            $arryPayCurrency = $objRegion->getPaymentCurrency($settings['paypalipn_Currency_Code']);
            $arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'], '');
            $PaypalCurrencyVal = $arryPayCurrency[0]['currency_value'] / $arrySelCurrency[0]['currency_value'];
            //$totalPriceForPaypal = $TotalPrice*$PaypalCurrencyVal;
            //$totalPriceForPaypal = $TotalPrice * $_SESSION['TotalQuantity'];
            $totalPriceForPaypal = display_price($TotalPrice, '', '', '', '');
            // $totalPriceForPaypal = modified_price($TotalPrice, '', '', '', '');
            //$totalPriceForPaypal = number_format($totalPriceForPaypal, 2, '.', '');
            // echo '<pre>';
             //print_r($arryCart); die; 
            $orderdata['TotalPrice'] = $totalPriceForPaypal;
            $responce['arryCart'] = $arryCart;
            $responce['orderdata'] = $orderdata;
            $responce['variantdata'] = $arryVariant;

            echo json_encode($responce);
            exit;
            break;

        case 'paymentmethod':
			
            $data = array();
            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $_SESSION['CmpDatabase'];
            $objConfig->connect();
            $objCustomer = new Customer();
            $objOrder = new orders();
            $objcartsettings = new Cartsettings();
            $objRegion = new region();
            // $settings = array();
            if (empty($_SESSION["guestId"]))
                $Cid = isset($_SESSION['Cid']) ? $_SESSION['Cid'] : "";
            else
                $Cid = isset($_SESSION["guestId"]) ? $_SESSION["guestId"] : "";

            if (!empty($_POST['Ssid'])) {
                $_SESSION['Ssid'] = isset($_POST['Ssid']) ? $_POST['Ssid'] : "";
            }

            $arryCart = $objOrder->GetCart($Cid);
            $numCart = $objOrder->numRows();

            if ($numCart > 0) {
                $TotalWeight = 0;
                $SubTotal = 0;
                $TotalItems = 0;
                $TotalQuantity = 0;
                $TaxAmount = 0;
                $TotalWeight = 0;
                $arryVariant = array();
                foreach ($arryCart as $key => $values) {
                    $GroupPrice = json_decode($values['GroupPrice'], true);
                    $SubTotal += ($GroupPrice[$GroupID] > 0) ? ($values['Quantity'] * $GroupPrice[$GroupID]) : ($values['Quantity'] * $values['Price']);
                    $ProductIDs .= $values['ProductID'] . ",";
                    $TotalQuantity += $values['Quantity'];
                    $TaxAmount += $values['Quantity'] * $values['Price'] * $values['TaxRate'] / 100;

                    $TotalWeight += ($values['Quantity'] * $values['Weight']);

                    // added by karishma
                    $Variant_ID = $values['Variant_ID'];
                    $Variant_val_Id = $values['Variant_val_Id'];


                    // end karishma
                }

				
                if (!empty($_SESSION['Ssid'])) {

                    $shippingCharge = $objcartsettings->getCustomShippingPrice($_SESSION['Ssid'], $TotalWeight, $TotalItems, $SubTotal);
                    $shippingMethod = $objcartsettings->getShippingMethodById($_SESSION['Ssid']);
                }
                $shippingCharge = number_format($shippingCharge, 2, '.', '');
                $arryCustomer = $objCustomer->getCustomerById($Cid);
                $address = $objCustomer->getShippingAddressById($_SESSION['shipping_address_id']);


                //Calculate Price  
                // added by karishma 5oct2015
                $_SESSION['Variant_ID'] = $Variant_ID;
                $_SESSION['Variant_val_Id'] = $Variant_val_Id;


                $_SESSION['TotalQuantity'] = rtrim($TotalQuantity, ",");
                $SubTotalPrice = $SubTotal;
                $TotalPrice = $SubTotal + $shippingCharge + $TaxAmount;
                if ($_SESSION['discountAmount'] > 0) {
                    $TotalPrice = $TotalPrice - $_SESSION['discountAmount'];
                }
                if ($_SESSION['promo_discount_amount'] > 0) {
                    $TotalPrice = $TotalPrice - $_SESSION['promo_discount_amount'];
                }
                if ($_SESSION['GroupdiscountAmount'] > 0) {
                    $TotalPrice = $TotalPrice - $_SESSION['GroupdiscountAmount'];
                }

                //Connecting to main database
                $Config['DbName'] = $Config['DbMain'];
                $objConfig->dbName = $Config['DbName'];
                $objConfig->connect();
                $arryPayCurrency = $objRegion->getPaymentCurrency($settings['paypalipn_Currency_Code']);
                $arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'], '');
                if (!empty($arryCustomer[0]['State'])) {
                    $arryState = $objRegion->getStateName($arryCustomer[0]['State']);
                    $data['BillingStateName'] = stripslashes($arryState[0]["name"]);
                } else if (!empty($arryCustomer[0]['OtherState'])) {
                    $data['BillingStateName'] = stripslashes($arryCustomer[0]['OtherState']);
                }

                if (!empty($arryCustomer[0]['City'])) {
                    $arryCity = $objRegion->getCityName($arryCustomer[0]['City']);
                    $data['BillingCityName'] = stripslashes($arryCity[0]["name"]);
                } else if (!empty($arryCustomer[0]['OtherCity'])) {
                    $data['BillingCityName'] = stripslashes($arryCustomer[0]['OtherCity']);
                }

                if ($arryCustomer[0]['Country'] > 0) {
                    $arryCountryName = $objRegion->GetCountryName($arryCustomer[0]['Country']);
                    $data['BillingCountryName'] = stripslashes($arryCountryName[0]["name"]);
                }
                $data['BillingName'] = ucfirst($arryCustomer[0]['FirstName']) . " " . ucfirst($arryCustomer[0]['LastName']);
                $data['BillingCompany'] = $arryCustomer[0]['Company'];
                $data['BillingAddress'] = $arryCustomer[0]['Address1'] . " " . $arryCustomer[0]['Address2'];
                ;
                $data['BillingZipCode'] = $arryCustomer[0]['ZipCode'];
                $data['BillingPhone'] = $arryCustomer[0]['Phone'];
                $data['BillingEmail'] = $arryCustomer[0]['Email'];
                // added by karishma
                $data['BillingFirstName'] = ucfirst($arryCustomer[0]['FirstName']);
                $data['BillingLastName'] = ucfirst($arryCustomer[0]['LastName']);

                if ($_SESSION['shipping_address_id'] == "new" ) {

                    if (!empty($arryCustomer[0]['ShippingState'])) {
                        $arryState = $objRegion->getStateName($arryCustomer[0]['ShippingState']);
                        $data['ShippStateName'] = stripslashes($arryState[0]["name"]);
                    } else if (!empty($arryCustomer[0]['OtherShippingState'])) {
                        $data['ShippStateName'] = stripslashes($arryCustomer[0]['OtherShippingState']);
                    }

                    if (!empty($arryCustomer[0]['ShippingCity'])) {
                        $arryCity = $objRegion->getCityName($arryCustomer[0]['ShippingCity']);
                        $data['ShippCityName'] = stripslashes($arryCity[0]["name"]);
                    } else if (!empty($arryCustomer[0]['OtherShippingCity'])) {
                        $data['ShippCityName'] = stripslashes($arryCustomer[0]['OtherShippingCity']);
                    }

                    if ($arryCustomer[0]['ShippingCountry'] > 0) {
                        $arryCountryName = $objRegion->GetCountryName($arryCustomer[0]['ShippingCountry']);
                        $data['ShippCountryName'] = stripslashes($arryCountryName[0]["name"]);
                    }

                    $data['ShippingName'] = stripslashes($arryCustomer[0]['ShippingName']);
                    $data['ShippingCompany'] = stripslashes($arryCustomer[0]['ShippingCompany']);
                    $data['ShippingAddress'] = stripslashes($arryCustomer[0]['ShippingAddress1'] . " " . $arryCustomer[0]['ShippingAddress2']);
                    $data['ShippingCity'] = stripslashes($data['ShippCityName']);
                    $data['ShippingState'] = stripslashes($data['ShippStateName']);
                    $data['ShippingCountry'] = stripslashes($data['ShippCountryName']);
                    $data['ShippingZip'] = $arryCustomer[0]['ShippingZip'];
                    $data['ShippingPhone'] = $arryCustomer[0]['ShippingPhone'];
                } else {
                    if (!empty($address[0]['State'])) {
                        $arryState = $objRegion->getStateName($address[0]['State']);
                        $data['ShippStateName'] = stripslashes($arryState[0]["name"]);
                    } else if (!empty($address[0]['OtherState'])) {
                        $data['ShippStateName'] = stripslashes($address[0]['OtherState']);
                    }

                    if (!empty($address[0]['City'])) {
                        $arryCity = $objRegion->getCityName($address[0]['City']);
                        $data['ShippCityName'] = stripslashes($arryCity[0]["name"]);
                    } else if (!empty($address[0]['OtherCity'])) {
                        $data['ShippCityName'] = stripslashes($address[0]['OtherCity']);
                    }

                    if ($address[0]['Country'] > 0) {
                        $arryCountryName = $objRegion->GetCountryName($address[0]['Country']);
                        $data['ShippCountryName'] = stripslashes($arryCountryName[0]["name"]);
                    }

                    $data['ShippingName'] = stripslashes($address[0]['Name']);
                    $data['ShippingCompany'] = stripslashes($address[0]['Company']);
                    $data['ShippingAddress'] = stripslashes($address[0]['Address1'] . " " . $address[0]['Address2']);
                    $data['ShippingCity'] = stripslashes($data['ShippCityName']);
                    $data['ShippingState'] = stripslashes($data['ShippStateName']);
                    $data['ShippingCountry'] = stripslashes($data['ShippCountryName']);
                    $data['ShippingZip'] = $address[0]['Zip'];
                    $data['ShippingPhone'] = $address[0]['Phone'];
                }
            }
           
			
            if (!empty($_SESSION['ProductIDs'])) {  
                $orderdata = array();
                $orderdata['Cid'] = $Cid;
                $orderdata['ProductIDs'] = $_SESSION['ProductIDs'];
                $orderdata['currency_id'] = $_SESSION['currency_id'];
                $orderdata['SubTotalPrice'] = modified_price($SubTotalPrice);
                $orderdata['TotalPrice'] = modified_price($TotalPrice);
                $orderdata['TotalQuantity'] = $TotalQuantity;
                $orderdata['Tax'] = modified_price($TaxAmount);
                $orderdata['Shipping'] = modified_price($shippingCharge);
                $orderdata['ShippingMethod'] = $shippingMethod[0]['CarrierName'];
                $orderdata['Weight'] = $TotalWeight;
                $orderdata['WeightUnit'] = 'lbs';
                $orderdata['DiscountAmount'] = modified_price($_SESSION['discountAmount']);
                $orderdata['DiscountValue'] = $_SESSION['discountValue'];
                $orderdata['DiscountType'] = $_SESSION['discountType'];
                $orderdata['PromoCampaignID'] = $_SESSION['promo_campaign_id'];
                $orderdata['PromoDiscountAmount'] = modified_price($_SESSION['promo_discount_amount']);
                $orderdata['BillingName'] = $data['BillingName'];
                $orderdata['BillingAddress'] = $data['BillingAddress'];
                $orderdata['BillingCity'] = $data['BillingCityName'];
                $orderdata['BillingState'] = $data['BillingStateName'];
                $orderdata['BillingCountry'] = $data['BillingCountryName'];
                $orderdata['BillingZip'] = $data['BillingZipCode'];
                $orderdata['BillingCompany'] = $data['BillingCompany'];
                $orderdata['Phone'] = $data['BillingPhone'];
                $orderdata['Email'] = $data['BillingEmail'];
                $orderdata['ShippingName'] = $data['ShippingName'];
                $orderdata['ShippingCompany'] = $data['ShippingCompany'];
                $orderdata['ShippingAddress'] = $data['ShippingAddress'];
                $orderdata['ShippingCity'] = $data['ShippingCity'];
                $orderdata['ShippingState'] = $data['ShippingState'];
                $orderdata['ShippingCountry'] = $data['ShippingCountry'];
                $orderdata['ShippingZip'] = $data['ShippingZip'];
                $orderdata['ShippingPhone'] = $data['ShippingPhone'];
                $orderdata['DelivaryDate'] = $_SESSION['DelivaryDate'];
                $orderdata['AddressType'] = $_SESSION['AddressType'];

                $orderdata['GroupdiscountAmount'] = '';
                $orderdata['GroupDiscountSetting'] = '';
                $Config['DbName'] = $_SESSION['CmpDatabase'];
                $objConfig->dbName = $_SESSION['CmpDatabase'];
                $objConfig->connect();
                $_SESSION['OrderID'] = $objOrder->AddOrder($orderdata);
				

                if ($settings["DiscountsPromo"] == "Yes" && !empty($_SESSION['promo_discount_amount'])) {
                    $objDiscount->addPromoHistory($_SESSION['promo_campaign_id'], $_SESSION['OrderID'], $Cid, $_SESSION['promo_discount_amount']);
                }
                if ($_SESSION['add_to_address_book'] == "Yes") {
                    $objCustomer->UpdateCustomerShippingAddressFromCheckout($Cid);
                }
            }

            $orderdata['SubTotalPrice'] = display_price($SubTotalPrice);
            $orderdata['TotalPrice'] = display_price($TotalPrice);
            $orderdata['Tax'] = display_price($TaxAmount);
            $orderdata['Shipping'] = display_price($shippingCharge);
            $orderdata['DiscountAmount'] = display_price($_SESSION['discountAmount']);
            $orderdata['PromoDiscountAmount'] = display_price($_SESSION['promo_discount_amount']);
            //print_r($_SESSION);
            //$PaypalCurrencyVal = $arryPayCurrency[0]['currency_value'] / $arrySelCurrency[0]['currency_value'];
            // $totalPriceForPaypal = $TotalPrice * $PaypalCurrencyVal;
            //$totalPriceForPaypal = $TotalPrice ;
            // $totalPriceForPaypal = number_format($totalPriceForPaypal, 2, '.', '');
            $totalPriceForPaypal = modified_price($TotalPrice);

            if ($_POST['method'] == 'cashondelivary') { 
                if (!empty($_SESSION['OrderID']) && !empty($Cid)) { 
                    $objOrder->PaymentDone($Cid, $_SESSION['OrderID'], $_POST['method']);
                    $objOrder->RemoveCart($Cid);
                    unset($_SESSION['DelivaryDate']);
                    unset($_SESSION['shipping_address_id']);
                    unset($_SESSION['add_to_address_book']);
                    //unset($_SESSION['OrderID']);
                    unset($_SESSION['Amount']);
                    unset($_SESSION['ProductIDs']);
                    unset($_SESSION['Ssid']);
                    unset($_SESSION['shipping_address_id']);
                    unset($_SESSION['AddressType']);
                    unset($_SESSION['discountAmount']);
                    unset($_SESSION['discountValue']);
                    unset($_SESSION['discountType']);
                    unset($_SESSION['promo_campaign_id']);
                    unset($_SESSION['promo_discount_amount']);
                    unset($_SESSION['promo_code']);
                    $responce['orderdata'] = $orderdata;
                    $responce['orderid'] = base64_encode($_SESSION['OrderID']);
                    $responce['cid'] = base64_encode($Cid);
                    $responce['arryCart'] = $arryCart;
                } else {
					$responce['errordetail']['L_LONGMESSAGE0'] ='order Fail';
                    $responce['errorMsg'] = 'order Fail';
                }
            } else if ($_POST['method'] == 'paypalpro') {

                $firstName = urlencode($data['BillingFirstName']);
                $lastName = urlencode($data['BillingLastName']);
                $creditCardType = urlencode($_POST['optiondata']['ct']);
                $creditCardNumber = urlencode($_POST['optiondata']['cn']);
                $expDateMonth = urlencode($_POST['optiondata']['em']);
                $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
                $expDateYear = urlencode($_POST['optiondata']['ey']);
                $cvv2Number = urlencode($_POST['optiondata']['cvv']);
                $address1 = urlencode($orderdata['BillingAddress']);
                //$address2 = urlencode($_POST['address2']);
                $city = urlencode($orderdata['BillingCity']);
                $state = urlencode($orderdata['BillingState']);
                $zip = urlencode($orderdata['BillingZip']);

                $amount = urlencode($totalPriceForPaypal);

                if ($Config['Currency'] != '')
                    $currencyCode = $Config['Currency'];
                else
                    $currencyCode = $settings['paypalpro_Currency_Code'];
                $paymentAction = urlencode("Sale");
                $nvpRecurring = '';
                $methodToCall = 'doDirectPayment';

                $nvpstr = '&PAYMENTACTION=' . $paymentAction . '&AMT=' . $amount . '&CREDITCARDTYPE=' . $creditCardType . '&ACCT=' . $creditCardNumber . '&EXPDATE=' . $padDateMonth . $expDateYear . '&CVV2=' . $cvv2Number . '&FIRSTNAME=' . $firstName . '&LASTNAME=' . $lastName . '&STREET=' . $address1 . '&CITY=' . $city . '&STATE=' . $state . '&ZIP=' . $zip . '&COUNTRYCODE=US&CURRENCYCODE=' . $currencyCode . $nvpRecurring;

                $Username = $settings['paypalpro_Username'];
                $APIPassword = $settings['paypalpro_APIPassword'];
                $APISignature = $settings['paypalpro_APISignature'];
                $Mode = $settings['paypalpro_Mode'];

                $paymentmode = TRUE;
                if (strtolower($Mode) == 'test') {
                    $paymentmode = FALSE;
                }
                if (empty($Username) || empty($APIPassword) || empty($APISignature)) {
                    $responce['errorMsg'] = 'Payment Setting Not available';
                }
                $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', $paymentmode, FALSE);
                $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
                $ack = strtoupper($resArray["ACK"]);
                $_SESSION['PaymentResponse'] = $resArray;
                if ($ack == "SUCCESS") {

                    $objOrder->PaymentDone($Cid, $_SESSION['OrderID'], $_POST['method']);
                    $objOrder->RemoveCart($Cid);
                    unset($_SESSION['DelivaryDate']);
                    unset($_SESSION['shipping_address_id']);
                    unset($_SESSION['add_to_address_book']);
                    //unset($_SESSION['OrderID']);
                    unset($_SESSION['Amount']);
                    unset($_SESSION['ProductIDs']);
                    unset($_SESSION['Ssid']);
                    unset($_SESSION['shipping_address_id']);
                    unset($_SESSION['AddressType']);
                    unset($_SESSION['discountAmount']);
                    unset($_SESSION['discountValue']);
                    unset($_SESSION['discountType']);
                    unset($_SESSION['promo_campaign_id']);
                    unset($_SESSION['promo_discount_amount']);
                    unset($_SESSION['promo_code']);


                    $responce['orderdata'] = $orderdata;
                    $responce['orderid'] = base64_encode($_SESSION['OrderID']);
                    $responce['cid'] = base64_encode($Cid);
                    $responce['arryCart'] = $arryCart;
                } else {
                    $responce['errorMsg'] = 'Payment Fail';
                    $responce['errordetail'] = $resArray;
                }
            }
            if ($_POST['method'] == 'paypalipn') {
                $responce['orderid'] = $_SESSION['OrderID'];
            }

            echo json_encode($responce);
            exit;
            break;
    }
}

function SaveUser($data) {
    global $Config;
    global $objConfig;
    global $objCustomer;
    global $objRegion;
    global $objOrder;
    $responce = array();

    $checkEmail = $objCustomer->checkCustomerEmail($data['Email']);



    if (!empty($checkEmail[0]['Cid']))
        return false;

    $customerId = $objCustomer->addCustomer($data);

    /*     * ******Connecting to main database******** */
    $Config['DbName'] = $Config['DbMain'];
    $objConfig->dbName = $Config['DbName'];
    $objConfig->connect();
    /*     * **************************************** */
    $Country = $data['Country'];
    $main_state_id = $data['main_state_id'];
    $OtherState = $data['OtherState'];
    $main_city_id = $data['main_city_id'];
    $OtherCity = $data['OtherCity'];
    if ($Country > 0) {
        $arryCountryName = $objRegion->GetCountryName($Country);
        $CountryName = stripslashes($arryCountryName[0]["name"]);
    }

    if (!empty($main_state_id)) {
        $arryState = $objRegion->getStateName($main_state_id);
        $StateName = stripslashes($arryState[0]["name"]);
    } else if (!empty($OtherState)) {
        $StateName = stripslashes($OtherState);
    }

    if (!empty($main_city_id)) {
        $arryCity = $objRegion->getCityName($main_city_id);
        $CityName = stripslashes($arryCity[0]["name"]);
    } else if (!empty($OtherCity)) {
        $CityName = stripslashes($OtherCity);
    }

    /*     * **************************************** */

    /*     * ******Connecting to main database******** */
    $Config['DbName'] = $_SESSION['CmpDatabase'];
    $objConfig->dbName = $Config['DbName'];
    $objConfig->connect();
    /*     * **************************************** */

    if (!empty($customerId)) {
        //add to sale customer table for sync
        $objOrder->sync_customer_in_sales($data);

        // end
        //Send Registration Email to Customer/Admin
        $objCustomer->customerRegistrationEmail($data, $CountryName, $StateName, $CityName);
        $responce['cid'] = $customerId;
        /*         * ********************************************CODE FOR LOGIN USER******************************************************************* */
        if ($arryMember = $objCustomer->ValidateCustomer($data['Email'], $data['Password'], $data['LoginType'])) {
            $objCustomer->updateSessionCustomer($arryMember[0]['Cid']);
            $_SESSION['Password'] = $arryMember[0]['Password'];
            $_SESSION['Email'] = $arryMember[0]['Email'];
            $_SESSION['Cid'] = $arryMember[0]['Cid'];
            $_SESSION['Level'] = $arryMember[0]['Level'];
            $_SESSION['GroupID'] = $arryMember[0]['GroupID'];
            $_SESSION['Name'] = ucfirst($arryMember[0]['FirstName']) . ' ' . ucfirst($arryMember[0]['LastName']);
            $_SESSION['CompanyName'] = $arryMember[0]['Company'];

            if (!empty($_POST['Remember'])) {
                setcookie("RememberUserName", $arryMember[0]['Email'], time() + (5 * 3600));
                setcookie("RememberPassword", $arryMember[0]['Password'], time() + (5 * 3600));
            }
            /*             * **** Update Member Cart On Login **** */
            $arryCart = $objOrder->GetCart(session_id());
            $numCart = $objOrder->numRows();
            if ($numCart > 0) {
                $PrdIDs = '';
                foreach ($arryCart as $key => $values) {
                    $PrdIDs .= $values['ProductID'] . ',';
                }
                $objCustomer->UpdateCustomerCart($_SESSION['Cid'], $PrdIDs);
            }
        } else {
            $responce['error'] = INVALID_LOGIN;
        }
        /*         * ********************************************END CODE FOR LOGIN USER******************************************************************* */
    }
    return $responce;
}

?>