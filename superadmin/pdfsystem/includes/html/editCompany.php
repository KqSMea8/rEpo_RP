<?php 
//ini_set('display_errors',1);
//error_reporting(E_ALL);

global $FormHelper, $errorformdata, $objVali;
$objPlan = new plan();

if (!empty($_POST['userID'])) {

    $validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        //'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')
         //   , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
         //   , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        //),
        'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')
            , array('rule' => 'number', 'message' => 'Please enter only numbers.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
            , array('rule' => 'limit', 'message' => 'Please enter 10 digits.')
        ),
        'userCountry' => array(array('rule' => 'notempty', 'message' => 'Please enter country name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        'userState' => array(array('rule' => 'notempty', 'message' => 'Please enter state name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        'userCity' => array(array('rule' => 'notempty', 'message' => 'Please enter city name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),

     'allow_storage' => array(array('rule' => 'number', 'message' => 'Please enter only numbers.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
            
        ),
        
    );

    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);

    if (empty($errors)) {

        $data = array(
            'firstName' => $_POST['userFname']
            //, 'lastName' => $_POST['userLname']
            , 'phone' => $_POST['userContacts']
            , 'country' => $_POST['userCountry']
            , 'state' => $_POST['userState']
            , 'city' => $_POST['userCity']
            , 'address' => $_POST['userAddress']
            , 'packageId' => $_POST['userPackageId']
            , 'status' => $_POST['status'],
          //  ,'onLinePayment'=> $_POST['onLinePayment'],
 
);    

        $update_id = $objUser->UpdateUserdata($data, $userID);
        $update_storage = $objUser->UpdateUserstorage($_POST, $userID);
        header("Location:" . $RedirectURL);
    } else {
        $FormHelper->errordata = $errorformdata = $errors;
    }
}

?>
<div><a href="<?= $RedirectURL ?>" class="back">Back</a></div>


<div class="had">Manage User <span> &raquo; <?php
if (!empty($_REQUEST['edit'])) {
    if ($_REQUEST['tab']  == "company") {
        echo "User Details";
    } else if ($_REQUEST['tab']  == "compuserlist") {
        echo "Company User List";
    } else if ($_REQUEST['tab']  == "packagelist") {
        echo "Plan Detalis List";
    } else if ($_REQUEST['tab']  == "paymenthistory") {
        echo "Payment History";
    } else if ($_REQUEST['tab'] == "paymentview") {
        echo "Payment View";
    }else if ($_REQUEST['tab'] == "orderlist") {
        echo "Order List";
    }
   else if ($_REQUEST['tab'] == "setting") {
        echo "Setting";
    }
} else {
    echo "Edit " . $ModuleName;
}
?> </span></div>
        <? if (!empty($errMsg)) { ?>
    <div height="2" align="center" class="red"><?php echo $errMsg; ?></div>

        <? } ?>
        <?php
        if (!empty($_SESSION['mess_msg'])) {
            echo '<div height="2" align="center"  class="redmsg" >' . $_SESSION['mess_msg'] . '</div>';
            unset($_SESSION['mess_msg']);
        }
        ?>


<?php
if (!empty($_REQUEST['edit'])) {

    if ($_REQUEST['tab'] == "company") {
        include("includes/html/box/edit_form.php");
    } else if ($_REQUEST['tab'] == "compuserlist") {
        include("includes/html/box/compuserlist.php");
    } else if ($_REQUEST['tab'] == "packagelist") {
        include("includes/html/box/packagelist.php");
    } else if ($_REQUEST['tab'] == "paymenthistory") {
        include("includes/html/box/paymenthistory.php");
    } else if ($_REQUEST['tab'] == "paymentview") {
        include("includes/html/box/paymentview.php");
    }else if ($_REQUEST['tab'] == "orderlist") {
        include("includes/html/box/orderList.php");
    }
else if ($_REQUEST['tab'] == "setting") {
        include("includes/html/box/setting.php");
    }
} 

?>
