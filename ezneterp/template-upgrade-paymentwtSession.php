<?php
//ValidateCrmSession();
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/erp.company.class.php");
require_once($Prefix . "classes/erp.cmp.class.php");
require_once($Prefix . "classes/erp.admin.class.php");

require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/sales.customer.class.php");
require_once($Prefix . "classes/dbfunction.class.php");
require_once($Prefix . "classes/chat.class.php");

$objSale = new sale();
$objConfig = new admin();
$objCompany = new company();
$objRegion = new region();
$objCmp = new cmp();
$objchat = new chat();
//$arrayOrderInfo=$objCmp->showOderInformation();
$arryCountry = $objRegion->getCountry('', '');

if (!empty($_POST['pack_id'])) {
    $arrayPkjName = $objCmp->ezneterpPackagesById($_POST['pack_id']);
    
           $arrayInv = $arrayPkjName[0]['features'];
           $arrinvt = unserialize($arrayInv);
           $inventryModule = $arrayPkjName[0]['inventryModule'];
           

} else {
    header("location: pricing-signup");
    exit;
}


if ($_POST['submit']) {

    if ($_POST['TotalAmount'] != $_SESSION["UpgradeAmountToPay"] || $_POST['MaxUser'] != $_SESSION["UpgradeMaxUser"]) {
        unset($_SESSION["UpgradeAmountToPay"]);
        unset($_SESSION["UpgradeMaxUser"]);
        $_SESSION["PricingMsg"] = "Error processing your request. Please try again.";
        header('location:index.php?slug=upgradeWTS&pack_id=' . $_POST['pack_id']);
        exit;
    }




    if ($objConfig->isCmpEmailExists($_POST['Email'], '')) {
        $_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
    } else if ($objCompany->isDisplayNameExists($_POST['DisplayName'], '')) {
        $_SESSION['mess_company'] = DISPLAY_ALREADY_REGISTERED;
    } else {

        $packData = array();
        $packData = $objCmp->getPackagesByName($_POST['PaymentPlan']);
        //echo '<pre>';print_r($packData);
        $packDataUnserialize = unserialize($packData[0]['features']);
        $packageFeatureId = implode(",", $packDataUnserialize);

        require_once("paypal_pro.inc.php");
        require_once ("paypalfunctions.php");

        $firstName = urlencode($_POST['customer_first_name']);
        $lastName = urlencode($_POST['customer_last_name']);
        $creditCardType = urlencode($_POST['customer_credit_card_type']);
        $creditCardNumber = urlencode($_POST['customer_credit_card_number']);
        $expDateMonth = urlencode($_POST['cc_expiration_month']);
        $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
        $expDateYear = urlencode($_POST['cc_expiration_year']);
        $cvv2Number = urlencode($_POST['cc_cvv2_number']);
        $address1 = urlencode($_POST['customer_address1']);
        $address2 = urlencode($_POST['customer_address2']);
        $city = urlencode($_POST['customer_city']);
        $state = urlencode($_POST['customer_state']);
        $zip = urlencode($_POST['customer_zip']);
        $amount = urlencode($_POST['TotalAmount']);
        $currencyCode = "USD";
        $paymentAction = urlencode("Sale");
        if ($_POST['recurring'] == 1) { // For Recurring
            $profileStartDate = urlencode(date('Y-m-d h:i:s'));
            $billingPeriod = urlencode($_POST['billingPeriod']); // or "Day", "Week", "SemiMonth", "Year"
            $billingFreq = urlencode($_POST['billingFreq']); // combination of this and billingPeriod must be at most a year
            $initAmt = $amount;
            $failedInitAmtAction = urlencode("ContinueOnFailure");
            $desc = urlencode("Recurring $" . $amount);
            $autoBillAmt = urlencode("AddToNextBilling");
            $profileReference = urlencode("Anonymous");
            $methodToCall = 'CreateRecurringPaymentsProfile';
            $nvpRecurring = '&BILLINGPERIOD=' . $billingPeriod . '&BILLINGFREQUENCY=' . $billingFreq . '&PROFILESTARTDATE=' . $profileStartDate . '&INITAMT=' . $initAmt . '&FAILEDINITAMTACTION=' . $failedInitAmtAction . '&DESC=' . $desc . '&AUTOBILLAMT=' . $autoBillAmt . '&PROFILEREFERENCE=' . $profileReference;
        } else {
            $nvpRecurring = '';
            $methodToCall = 'doDirectPayment';
        }



        $nvpstr = '&PAYMENTACTION=' . $paymentAction . '&AMT=' . $amount . '&CREDITCARDTYPE=' . $creditCardType . '&ACCT=' . $creditCardNumber . '&EXPDATE=' . $padDateMonth . $expDateYear . '&CVV2=' . $cvv2Number . '&FIRSTNAME=' . $firstName . '&LASTNAME=' . $lastName . '&STREET=' . $address1 . '&CITY=' . $city . '&STATE=' . $state . '&ZIP=' . $zip . '&COUNTRYCODE=US&CURRENCYCODE=' . $currencyCode . $nvpRecurring;

        if ($_POST['TotalAmount'] > 0) {
            /* $paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );
              $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
              $ack = strtoupper($resArray["ACK"]); */

            $paymentType = "Sale";
            $expDate = $padDateMonth . $expDateYear;
            $countryCode = "US";
            $orderDescription = "Account Signup Payment";
            $resArray = DirectPayment($paymentType, $amount, $creditCardType, $creditCardNumber, $expDate, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $countryCode, $currencyCode, $orderDescription);
            if ($resArray["RESPMSG"] == "Approved") {
                $ack = "SUCCESS";
                $resArray["TRANSACTIONID"] = $resArray["CORRELATIONID"];
            }

            //echo '<pre>'; print_r($resArray);exit;	
        } else {
            $ack = "SUCCESS";
        }


        if ($ack != "SUCCESS") {
            /* echo '<tr>';
              echo '<td colspan="2" style="font-weight:bold;color:red;" align="center">Error! Please check that u will provide all information correctly :(</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td align="right">Ack:</td>';
              echo '<td>'.$resArray["ACK"].'</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td align="right">Correlation ID:</td>';
              echo '<td>'.$resArray['CORRELATIONID'].'</td>';
              echo '</tr>';

              exit; */

            $_SESSION["PricingMsg"] = 'Payment Error : ' . $resArray["RESPMSG"];

            header('location:index.php?slug=upgradeWTS&pack_id=' . $_POST['pack_id']);
            exit;
        } else {
            /* echo '<tr>';
              echo '<td colspan="2" style="font-weight:bold;color:Green" align="center">Thank You For Your Payment :)</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td align="right"> Transaction ID:</td>';
              echo '<td>'.$resArray["TRANSACTIONID"].'</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td align="right"> Amount:</td>';
              echo '<td>'.$currencyCode.$resArray['AMT'].'</td>';
              echo '</tr>'; */

            ///////////////////////////////////
            //$OrderID=$objCmp->AddOrder($_POST);


            /*  add company start from here */

            /*             * *********************** */
        	
        	
        	
          $arrayDepartment = $arrayPkjName[0]['features'];
          $Depart = unserialize($arrayDepartment);
          $DeparmnetList = implode(",", $Depart);
          
          
           if(in_array(2,$Depart)){
          	$_POST['maxProduct'] = $arrayPkjName[0]['maxProduct'];
          }else{
          	
          	$_POST['maxProduct']='';
          	
          }
          
            $_POST['Department'] = $DeparmnetList;

            $_POST['Status'] = 0;
            //$_POST['Department'] = 5;
            //$_POST["Timezone"]= '-04:00';
            $_POST["DateFormat"] = 'j M, Y';
            $_POST["currency_id"] = '9';

            // need to get from packages



            $arrayPkj = $objCmp->ezneterpPackagesByName($arrayPkjName[0]['name']);

            /*             * ************** */
            $packDataUnserialize = unserialize($arrayPkj[0]['features']);
            $packageFeatureId = implode(",", $packDataUnserialize);
            /*             * ************** */

            $_POST["MaxUser"] = $arrayPkj[0]['allow_users'];
            $_POST['PaymentPlan'] = $arrayPkj[0]['name'];
            $_POST['StorageLimit'] = $arrayPkj[0]['space'];
            $_POST['StorageLimitUnit'] = 'GB';

            $_POST['ContactPerson'] = $_POST['customer_first_name'] . ' ' . $_POST['customer_last_name'];
            $_POST['Address'] = $_POST['customer_address1'] . ' ' . $_POST['customer_address2'];
            $_POST['ZipCode'] = $_POST['customer_zip'];

            $NumMonth = 1;
            $arryDate = explode("-", date('Y-m-d'));
            list($year, $month, $day) = $arryDate;
            $TempDate = mktime(0, 0, 0, $month + $NumMonth, $day, $year);
            $ExpiryDate = date("Y-m-d", $TempDate);
            $_POST["ExpiryDate"] = $ExpiryDate;
            /*             * ******************** */

            $CmpID = $objCompany->AddCompany($_POST);
            $arryCompany['Email'] = $_POST['Email'];
            $arryCompany['BuyNow'] = 1;
            $Password = substr(md5(rand(100, 10000)), 0, 8);
            $arryCompany['Password'] = $Password;
            $objCmp->ActiveCompany($arryCompany);


            //$licence = $objchat->chatCurl('companyregister', array('companyid' => $CmpID, 'server' => $_SERVER['HTTP_HOST']));



            // add order /
            $country_id = $_POST['country_id'];
            $arryCountryCode = $objRegion->getCountry($_POST['country_id'], '');
            $country_code = $arryCountryCode[0]['code'];
            $_POST['country_id'] = $country_code;
            $_POST['CrmAdminID'] = $CmpID;
			$_SESSION['CrmAdminID']=$CmpID;
            $OrderID = $objCmp->AddErpOrder($_POST);
            
            $objCmp->ActivateOrder($CmpID, $OrderID, $resArray["TRANSACTIONID"]);
            // add order /


            /* invoice start here */


            $results = $objCompany->GetDefaultCompany();

            $count = count($results);

            if ($count > 0) {

                $_POST['country_id'] = $country_id;
                $_POST['customer_email_id'] = $_POST['Email'];
                //$results[0]['DisplayName']='sakshay';  //for testinNafees.spn@gmail.comg only
                $DbName = $Config['DbMain'] . "_" . $results[0]['DisplayName'];
                $Config['DbName'] = $DbName;
                $objConfig->dbName = $Config['DbName'];
                $link = $objConfig->connect();
                $_SESSION['CmpDatabase'] = $DbName;
                $_SESSION['CmpID'] = $CmpID;
               //$order_id = $objSale->GenerateInVoiceEntryUI($_POST);
                //$objSale->basicInv($order_id, $_POST);
                unset($_SESSION['CmpDatabase']);
                unset($_SESSION['CmpID']);
            }


            /* invoice end here */



            /*             * ********************** */
            //$_SESSION['mess_company'] = COMPANY_REG;
            $AddDatabase = 1;
            $UpdateAdminMenu = 1;

            /*             * ********************* */
            if ($AddDatabase == 1) {

                /*                 * ******Connecting to main database******** */
                $Config['DbName'] = $Config['DbMain'];
                $objConfig->dbName = $Config['DbName'];
                $objConfig->connect();
                /*                 * **************************************** */
                $DbName = $objCompany->AddDatabse($_POST['DisplayName']);
                if (!empty($DbName)) {
                    ImportDatabase($Config['DbHost'], $DbName, $Config['DbUser'], $Config['DbPassword'], $Prefix . 'superadmin/sql/erp_company.sql');
                }
            }

            /*             * ********************* */


            /* add company end  from here */

            if ($OrderID > 0 && $UpdateAdminMenu == 1) {

                $UpdateAdminMenu = 1;
                /*                 * ********************* */
                if ($UpdateAdminMenu == 1) {
                    $DbName = $Config['DbMain'] . "_" . $_POST['DisplayName'];
                    $Config['DbMain'] = $DbName;
                    $objConfig->dbName = $Config['DbMain'];
                    $objConfig->connect();
                    $objCompany->UpdateAdminModules($CmpID,$DeparmnetList);
                    //$objCompany->UpdateAdminSubModules($CmpID,5,strtolower($_POST['PaymentPlan']));
                    //$objCmp->UpdateAdminSubModules($CmpID, 5, strtolower($_POST['PaymentPlan']), $packageFeatureId);
                    if(in_array('3,4,6,7,8',$arrinvt)){
                   	
                   	if(!empty($inventryModule)){
                   		
                   		$objCmp->EzneterpUpdateInventryModule($inventryModule);
                   		
                     	}
                    }
                
                
                
                }
                /*                 * ********************* */
            }
            ///////////////////////////////////

            header("location: index.php?slug=thanks");
            exit;
        }
    }
}



//$arryCountry = $objRegion->getCountryWithCode('', ''); edited by amit 11 feb
?>


<style type="text/css">
    .tabs {
        display: block;
    }

    #page-title {
        color: #333;
        font-size: 32px;
        font-weight: 300;
        margin: 50px 0 0;
        padding: 0 0 30px;
        text-align: left;
    }

    #payment-form {
        margin: 0px auto auto;
    }
</style>

<script language="JavaScript1.2" type="text/javascript">




    function validatePayment() {

        if (ValidateForSimpleBlank(document.getElementById("customer_first_name"), "First Name")
                && ValidateForSimpleBlank(document.getElementById("customer_last_name"), "Last Name")
                && ValidateMandRange(document.getElementById("DisplayName"), "User Name", 3, 30)
                && isUserName(document.getElementById("DisplayName"))
                && ValidateForSimpleBlank(document.getElementById("Email"), "Email")
                && isEmail(document.getElementById("Email"))
                && ValidateForSimpleBlank(document.getElementById("CompanyName"), "Company Name")
                && ValidateMandRange(document.getElementById("customer_credit_card_number"), "Card Number", 10, 20)
                && ValidateForSimpleBlank(document.getElementById("cc_cvv2_number"), "CSV Number")
                && ValidateForSimpleBlank(document.getElementById("customer_address1"), "Address Line 1")
                && ValidateForSimpleBlank(document.getElementById("customer_city"), "City")
                && ValidateForSimpleBlank(document.getElementById("customer_state"), "State")
                && isZipCode(document.getElementById("customer_zip"))
                ) {

            //var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID=&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

            //CheckMultipleExist(Url,"Email", "Email Address","DisplayName", "User Name")
						ShowHideLoader('1','S');
            return true;

        } else {
            return false;
        }


    }
</script>



<div class="top-cont1"></div>
<div class="main-content">
    <div class="werp">
        <div class="banner"><img src="img/about-us.jpg" /></div>
    </div>
	
</div>
<div class="inner-cont-text">
    <div class="werp">
        <div class="bradecrumb">
                <nav>
                    <a href="home">Home</a>
                    <a href="#">Checkout</a>
                </nav>
            </div>
    </div>
    <div class="inner-content">
        <div class="werp">
            <h1>Checkout</h1>
        </div>
    </div>
</div>
<section id="mainContent">
    <?php //echo $datah['Content']; ?>

    <?php
    $arrDuration = explode("/", $_POST['PlanDuration']);
    ?>

    <div class="InfoText">

        <div class="wrap clearfix"><article id="leftPart">

                <div class="detailedContent">
                    <div class="column" id="content">
                        <div class="section"><a id="main-content"></a>

                            <?php /*?><h1 style="text-align: center;" class="title" id="page-title">Checkout</h1><?php */?>
                            <div class="Checkout">
                                <table id="cart-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="20%" class="text-center">Item</th>
                                            <th width="30%" class="text-center">Number of users</th>
                                            <th width="20%" class="text-center">Plan Type</th>
                                            <th width="20%" class="text-center">Price $</th>
                                            <th width="15%" class="text-center">Subtotal $</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartcontents">
                                        <tr>
                                            <td>ERP: <?php echo $arrayPkjName[0]['name']; ?></td>
                                            <td class="text-center"><?php echo $_POST['MaxUser']; ?></td>
                                            <td class="text-center"><?php echo $arrayPkjName[0]['name']; ?></td>
                                            <td class="text-center"><?php echo $_POST['TotalAmount']; ?></td>
                                            <td class="text-right"><?php echo $_POST['TotalAmount']; ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="4">
                                                <h3>Total:</h3>
                                            </td>
                                            <td class="text-right">
                                                <h3 id="total-display">$ <?php echo $_POST['TotalAmount']; ?></h3>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                            <div class="region region-content">
                                <div class="block block-system" id="block-system-main">


                                    <div class="content">
                                        <div class="messages error clientside-error"
                                             id="clientsidevalidation-payment-form-errors" style="display: none;">
                                            <ul style="display: none;"></ul>
                                        </div>

                                        <div class="message_success" id="msg_div" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>


                                        <div class="pay-mn">
                                            <form accept-charset="UTF-8" id="payment-form" name="paymentform"
                                                  method="post" action="upgrade-paymentWTS"
                                                  novalidate="novalidate" onSubmit="return validatePayment();"
                                                  style="width: 100%;">

                                                <? if($_POST['TotalAmount']>0){ ?>
                                                <div class="payinfo-lft">

                                                    <h1 class="payment-heading">Payment Information</h1>


                                                    <div>


                                                        <div
                                                            class="form-item form-type-select form-item-customer-credit-card-type">
                                                            <label for="edit-customer-credit-card-type">Card Type </label> <select
                                                                class="form-select valid" name="customer_credit_card_type"
                                                                id="customer_credit_card_type">
                                                                <option value="Visa">Visa</option>
                                                                <option value="MasterCard"
                                                                <?php
                                                                if ($arrayOrderInfo[0]['customer_credit_card_type'] == "MasterCard") {
                                                                    echo "selected";
                                                                }
                                                                ?>>MasterCard</option>
                                                                <option value="Discover"
                                                                        <?php
                                                                        if ($arrayOrderInfo[0]['customer_credit_card_type'] == "Discover") {
                                                                            echo "selected";
                                                                        }
                                                                        ?>>Discover</option>
                                                                <option value="Amex"
<?php
if ($arrayOrderInfo[0]['customer_credit_card_type'] == "Amex") {
    echo "selected";
}
?>>American
                                                                    Express</option>
                                                            </select></div>
                                                        <div
                                                            class="form-item form-type-textfield form-item-customer-credit-card-number">
                                                            <label for="edit-customer-credit-card-number">Card Number <span
                                                                    title="This field is required." class="form-required">*</span> </label>
                                                            <input type="text" class="form-text required" maxlength="128" size="60"
                                                                   value="" name="customer_credit_card_number"
                                                                   id="customer_credit_card_number"> <span class="odr-cl"
                                                                   style="display: none;"><?= !empty($arrayOrderInfo[0]['customer_credit_card_number']) ? '***********' . substr($arrayOrderInfo[0]['customer_credit_card_number'], -2 - 3) : ''; ?>
                                                            </span></div>
                                                        <div class="form-item form-type-select form-item-cc-expiration-month"><label
                                                                for="edit-cc-expiration-month">Expiry Month </label> <select
                                                                class="form-select" name="cc_expiration_month"
                                                                id="edit-cc-expiration-month">
                                                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                                    <option value="<?php echo $i; ?>"
    <?php
    if ($arrayOrderInfo[0]['cc_expiration_month'] == $i) {
        echo "selected";
    }
    ?>>
                                                                        <?php echo $i; ?></option>
                                                                    <?php } ?>

                                                            </select></div>
                                                        <div class="form-item form-type-select form-item-cc-expiration-year"><label
                                                                for="edit-cc-expiration-year">Expiry Year </label> <select
                                                                class="form-select" name="cc_expiration_year"
                                                                id="edit-cc-expiration-year">
                                                                        <?php
                                                                    $startYear = date("Y");

                                                                    for ($j = $startYear; $j <= $startYear + 20; $j++) {
                                                                        ?>
                                                                    <option value="<?php echo $j; ?>"
    <?php
    if ($arrayOrderInfo[0]['cc_expiration_year'] == $j) {
        echo "selected";
    }
    ?>>
    <?php echo $j; ?></option>
<?php } ?>
                                                            </select></div>
                                                        <div class="form-item form-type-textfield form-item-cc-cvv2-number"><label
                                                                for="edit-cc-cvv2-number">CSV Number <span
                                                                    title="This field is required." class="form-required">*</span> </label>
                                                            <input type="password" class="form-text required" maxlength="5"
                                                                   size="60"
                                                                   value="<?= !empty($arrayOrderInfo[0]['cc_cvv2_number']) ? stripslashes($arrayOrderInfo[0]['cc_cvv2_number']) : ''; ?>"
                                                                   name="cc_cvv2_number" id="edit-cc-cvv2-number"></div>
                                                        <div class="form-item form-type-textfield form-item-customer-address1">
                                                            <label for="edit-customer-address1">Address Line 1 <span
                                                                    title="This field is required." class="form-required">*</span> </label>
                                                            <input type="text" class="form-text required" maxlength="150" size="60"
                                                                   value="<?= !empty($arrayOrderInfo[0]['customer_address1']) ? stripslashes($arrayOrderInfo[0]['customer_address1']) : ''; ?>"
                                                                   name="customer_address1" id="edit-customer-address1"></div>
                                                        <div class="form-item form-type-textfield form-item-customer-address2">
                                                            <label for="edit-customer-address2">Address Line 2 (Optional) </label> <input
                                                                type="text" class="form-text" maxlength="150" size="60"
                                                                value="<?= !empty($arrayOrderInfo[0]['customer_address2']) ? stripslashes($arrayOrderInfo[0]['customer_address2']) : ''; ?>"
                                                                name="customer_address2" id="edit-customer-address2"></div>
                                                        <div class="form-item form-type-textfield form-item-customer-city"><label
                                                                for="edit-customer-city">City <span title="This field is required."
                                                                                                class="form-required">*</span> </label> <input type="text"
                                                                                                           class="form-text required" maxlength="40" size="60"
                                                                                                           value="<?= !empty($arrayOrderInfo[0]['customer_city']) ? stripslashes($arrayOrderInfo[0]['customer_city']) : ''; ?>"
                                                                                                           name="customer_city" id="edit-customer-city"></div>
                                                        <div class="form-item form-type-textfield form-item-customer-state"><label
                                                                for="edit-customer-state">State <span title="This field is required."
                                                                                                  class="form-required">*</span> </label> <input type="text"
                                                                                                           class="form-text required" maxlength="40" size="60"
                                                                                                           value="<?= !empty($arrayOrderInfo[0]['customer_state']) ? stripslashes($arrayOrderInfo[0]['customer_state']) : ''; ?>"
                                                                                                           name="customer_state" id="edit-customer-state"></div>
                                                        <div class="form-item form-type-select form-item-customer-country"><label
                                                                for="edit-customer-country">Country </label> 


                                                            <?
                                                            if($arryCompany[0]['country_id'] != ''){
                                                            $CountrySelected = $arryCompany[0]['country_id']; 
                                                            }else{
                                                            $CountrySelected = 1;
                                                            }
                                                            ?>
                                                            <select name="country_id" class="form-select valid" id="country_id" >
                                                                <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                                                                <option value="<?= $arryCountry[$i]['country_id'] ?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
<?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <? } ?>
                                                        </select>   

                                                    </div>









                                                    <div class="form-item form-type-textfield form-item-customer-zip"><label
                                                            for="edit-customer-zip">Zip Code <span title="This field is required."
                                                                                               class="form-required">*</span> </label> <input type="text"
                                                                                                       class="form-text required" maxlength="20" size="60"
                                                                                                       value="<?= !empty($arrayOrderInfo[0]['customer_zip']) ? stripslashes($arrayOrderInfo[0]['customer_zip']) : ''; ?>"
                                                                                                       name="customer_zip" id="edit-customer-zip"></div>


                                                </div>


                                            </div>
                                            <? } ?>
                                            <div class="cmp-info-rght">

                                                <h1 class="payment-heading">Create Account</h1>

                                                <div>

                                                    <div class="form-item form-type-textfield form-item-customer-first-name">
                                                        <label for="edit-customer-first-name">First Name <span
                                                                title="This field is required." class="form-required">*</span> </label>
                                                        <input type="text" class="form-text required" maxlength="128" size="60"
                                                               value="<?= !empty($arrayOrderInfo[0]['customer_first_name']) ? stripslashes($arrayOrderInfo[0]['customer_first_name']) : ''; ?>"
                                                               name="customer_first_name" id="customer_first_name"></div>
                                                    <div class="form-item form-type-textfield form-item-customer-last-name">
                                                        <label for="edit-customer-last-name">Last Name <span
                                                                title="This field is required." class="form-required">*</span> </label>
                                                        <input type="text" class="form-text required" maxlength="128" size="60"
                                                               value="<?= !empty($arrayOrderInfo[0]['customer_last_name']) ? stripslashes($arrayOrderInfo[0]['customer_last_name']) : ''; ?>"
                                                               name="customer_last_name" id="customer_last_name"></div>


                                                    <div class="form-item form-type-textfield form-item-customer-last-name">
                                                        <label for="edit-customer-last-name">User Name <span
                                                                title="This field is required." class="form-required">*</span> </label>
                                                        <input type="text" class="form-text required" maxlength="60" size="60"
                                                               value="" name="DisplayName" id="DisplayName" onKeyPress="return isUniqueKey(event);"></div>



                                                    <div class="form-item form-type-textfield form-item-customer-last-name">
                                                        <label for="edit-customer-last-name">E-mail address<span
                                                                title="This field is required." class="form-required">*</span> </label>
                                                        <input type="text" class="form-text required" maxlength="254" size="60"
                                                               value="" name="Email" id="Email"
                                                               onKeyPress="Javascript:ClearAvail('MsgSpan_Email');"
                                                               onBlur="Javascript:CheckAvail('MsgSpan_Email', 'Company', '<?= $_GET['edit'] ?>');
                                                               "></div>


                                                    <div class="form-item form-type-textfield form-item-customer-last-name">
                                                        <label for="edit-customer-last-name">Company Name <span
                                                                title="This field is required." class="form-required">*</span> </label>
                                                        <input type="text" maxlength="50" size="60" value="" name="CompanyName"
                                                               id="CompanyName" class="text-full form-text"></div>
                                                    <input type="hidden" name="CouponCode" id="CouponCode" value="<?= $_POST['CouponCode'] ?>" />

                                                </div>


                                            </div>

<?php
foreach ($_POST as $key => $values) {
    echo '<input type="hidden" name="' . $key . '" value="' . $values . '">';
}
?> <input type="hidden" name="PaymentPlan"
                                                   value="<?php echo $arrayPkj[0]['name']; ?>">

                                            <input type="submit" class="form-submit" value="submit" name="submit"
                                                   id="submit" style="margin-left: 45%;"></form>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </article></div>

</div>


</section>
</div>
