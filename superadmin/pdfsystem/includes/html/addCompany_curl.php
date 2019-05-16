
<?php 


///ini_set('display_errors',1);
global $FormHelper, $errorformdata, $objVali;
//$objPlan = new plan();

if (!empty($_POST['userID'])) {

    $validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
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
        
    );

    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);

    if (empty($errors)) {

        $data = array(
            'firstName' => $_POST['userFname']
            , 'lastName' => $_POST['userLname']
            , 'phone' => $_POST['userContacts']
            , 'country' => $_POST['userCountry']
            , 'state' => $_POST['userState']
            , 'city' => $_POST['userCity']
            , 'address' => $_POST['userAddress']
            , 'packageId' => $_POST['userPackageId']
            , 'status' => $_POST['status']);
        // print_r($data);die;

        $update_id = $objUser->UpdateUserdata($data, $userID);
        header("Location:" . $RedirectURL);
    } else {
        $FormHelper->errordata = $errorformdata = $errors;
    }
}
if (isset($_POST['Submit'])) {
    
    

    $validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')
            , array('rule' => 'string', 'message' => 'Please enter only alphabets.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
        ),
        'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')
            , array('rule' => 'number', 'message' => 'Please enter only numbers.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
            , array('rule' => 'limit', 'message' => 'Please enter 10 digits.')
        ),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),
        'userPackageAmount' => array(array('rule' => 'notempty', 'message' => 'Please enter package amount.'),
            array('rule' => 'number', 'message' => 'Please enter only numbers.')),
        'userReferenceNo' => array(array('rule' => 'notempty', 'message' => 'Please enter reference no.')),
        'userEmail' => array(array('rule' => 'notempty', 'message' => 'Please enter email.')
            , array('rule' => 'email', 'message' => 'Please enter valid email.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
            , array('rule' => 'unique', 'message' => 'Email already exists.', 'table' => 'user', 'column' => 'username')
        ),
        'userPwd' => array(array('rule' => 'notempty', 'message' => 'Please enter password.')),
    );
   
    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);
    $aa = array();

    if (empty($errors)) {
        //***************User table add***********
        $objPackage = new package();
        $userPackageId = $_POST['userPackageId'];
        $planDetails = $objUser->getPackage($userPackageId);
        $planDetails = (array) $planDetails[0];
        $expiryDate = date('Y-m-d', strtotime(date() . ' + ' . $planDetails['timePeriod'] . ' day'));
        $randomcode = 'R' . time() . rand(1111, 9999);
        $objUser = new user();
        $password = md5($_POST['userPwd']);
        $Data = array('firstName' => $_POST['userFname'],
            'lastname' => $_POST['userLname'],
            'phone' => $_POST['userContacts'],
            'address' => $_POST['userAddress'],
            'PackageId' => $_POST['userPackageId'],
            'username' => $_POST['userEmail'],
            'password' => $password,
            'Company_code' => $randomcode,
            'roleId' => '4',
            'status' => $_POST['status'],
            'country' => $_POST['userCountry'],
            'state' => $_POST['userState'],
            'city' => $_POST['userCity'],
            'expiryDate' => $expiryDate,
            'txnId' => $_POST['userReferenceNo'],
            'status' => $_POST['status']);
       
//*************** Company status table Add**********
        $postData = '';
   //create name value pairs seperated by &
   foreach($Data as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   $postData = rtrim($postData, '&');
  //print_r($postData);
//    $ch = curl_init();  
//    $url="http://localhost/pdfviewer/public/page/userAdd";
//    curl_setopt($ch,CURLOPT_URL,$url);
//    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//    curl_setopt($ch,CURLOPT_HEADER, false); 
//    curl_setopt($ch, CURLOPT_POST, count($postData));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
// 
    //$output=curl_exec($ch);
     echo $output;die;
    curl_close($ch);
   
        
        $userID = $objUser->AddUserdata($data);
        $statusdata = array(
            'companycode' => $randomcode,
            'status' => $_POST['status']);
        $companyStatus = $objUser->AddUserCompanystatus($statusdata);
       
        //************payment_history table*********
        
        if (!empty($planDetails)) {
            $order_id = 'O' . time() . rand(1111, 9999);
            $datas = array(
                'orderid' => $order_id,
                'company_code' => $randomcode,
                'plan_id' => $_POST['userPackageId'],
                'plandata' => serialize($planDetails),
                'expiredDate' => $expiryDate,
                'amount' => $planDetails['amount'],
                'txnId' => $_POST['userReferenceNo'],
                'status' => $_POST['status'],
                'payment_status' => 'complete',);          
            $objUser->AddUserPackagedata($datas);
            header("Location:" . $RedirectURL);
            exit;


            
        }
    } else {
        $FormHelper->errordata = $errorformdata = $errors;
    }
}
?>
<div><a href="<?= $RedirectURL ?>" class="back">Back</a></div>


<div class="had">Manage User <span> &raquo; <?php
if (!empty($_GET['edit'])) {
    if ($_GET['tab'] == "company") {
        echo "User Details";
    } else if ($_GET["tab"] == "compuserlist") {
        echo "Company User List";
    } else if ($_GET["tab"] == "packagelist") {
        echo "Plan Detalis List";
    } else if ($_GET["tab"] == "paymenthistory") {
        echo "Payment History";
    } else if ($_GET["tab"] == "paymentview") {
        echo "Payment View";
    }
} else {
    echo "Add " . $ModuleName;
}
?> </span></div>
        <? if (!empty($errMsg)) { ?>
    <div height="2" align="center" class="red"><?php echo $errMsg; ?></div>

        <? } ?>
        <?php
        if (!empty($_SESSION['mess_company'])) {
            echo '<div height="2" align="center"  class="redmsg" >' . $_SESSION['mess_company'] . '</div>';
            unset($_SESSION['mess_company']);
        }
        ?>


<?php
if (!empty($_GET['edit'])) {
    if ($_GET['tab'] == "company") {
        include("includes/html/box/user_form.php");
    } else if ($_GET['tab'] == "compuserlist") {
        include("includes/html/box/compuserlist.php");
    } else if ($_GET['tab'] == "packagelist") {
        include("includes/html/box/packagelist.php");
    } else if ($_GET['tab'] == "paymenthistory") {
        include("includes/html/box/paymenthistory.php");
    } else if ($_GET['tab'] == "paymentview") {
        include("includes/html/box/paymentview.php");
    }
} else {
    include("includes/html/box/user_form.php");
}
?>


<!--    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
<script>
// $("#SubmitButton").click(function () {           
//     var firstName =$("#userFname").val();     
//     var lastName =$("#userLname").val(); 
//     var phone =$("#userContacts").val();
//     var country =$("#userCountry").val();
//     var state =$("#userState").val();
//     var city =$("#userCity").val();
//     var address =$("#userAddress").val();
//     var uPackageId =$("#userPackageId").val();
//     var email =$("#userEmail").val();
//     var uPwd =$("#userPwd").val();
//     var uStatus =$(".status").val();
//     var utxnId=$("#userReferenceNo").val();
//     if (firstName == '') {
//       alert("Please enter first name.");
//        return false;
//    }
//   if (lastName == '') {
//       alert("Please enter last name.");
//        return false;
//    }
//    if (phone == '') {
//       alert("Please enter contact number.");
//        return false;
//    }
//     if (uPackageId == '') {
//       alert("Please select Package .");
//        return false;
//    }
//    
//    if(utxnId ==''){
//        
//        alert("Please enter reference no .");
//        return false;
//    }
//    if (email == '') {
//       alert("Please enter email.");
//        return false;
//    }
//    if (uPwd == '') {
//       alert("Please enter password.");
//        return false;
//    }
//    
//      
//    $.ajax({      
//     url: "http://localhost/pdfviewer/public/page/userAdd",   
//     type: "POST",
//     //data:{id:id,password:password}, 
//     data: {firstName: firstName, lastName: lastName,phone: phone, state: state, city: city, address: address, uPackageId:uPackageId, email:email,country:country, uPwd:uPwd,uStatus:uStatus,userType:4,utxnId:utxnId},
//     success:function(result){         
//             if(result.status == 1){
//                 alert('email already registered');          
//           return false;
//       }
//         if(result.status == 0){
//          alert('"Registered Successfully, Please login",');
//          window.location.href = 'company.php?curP=1';
//            return false;
//        }
//   
//  
//    },
//    
//});
//});
// 

</script>
