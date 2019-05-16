
<?php
global $FormHelper, $errorformdata, $objVali;
$objPlan = new plan();

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
        'userCountry' => array(array('rule' => 'notempty', 'message' => 'Please enter country.')),
        'userState' => array(array('rule' => 'notempty', 'message' => 'Please enter state.')),
        'userCity' => array(array('rule' => 'notempty', 'message' => 'Please enter city.')),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),
        'userEmail' => array(array('rule' => 'notempty', 'message' => 'Please enter email.')
            , array('rule' => 'email', 'message' => 'Please enter valid email.')
            , array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
            , array('rule' => 'unique', 'message' => 'Email already exists.', 'table' => 'comp_users', 'column' => 'username')
        ),
        'userPwd' => array(array('rule' => 'notempty', 'message' => 'Please enter password.')),
        'userReferenceNo' => array(array('rule' => 'notempty', 'message' => 'Please enter reference no.')),
    );

    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);
    //print_r($errors);die;
    $aa = array();

    if (empty($errors)) {

        $date = new \DateTime();
        date_sub($date, date_interval_create_from_date_string('1 days'));
        $expiryDate = date_format($date, 'Y-m-d');
        $randomcode = 'R' . time() . rand(1111, 9999);
        $objUser = new user();
        $password =base64_encode($_POST['userPwd']);  
        $data = array('firstName' => $_POST['userFname'], 'lastName' => $_POST['userLname'], 'phone' => $_POST['userContacts'], 'country' => $_POST['userCountry'], 'state' => $_POST['userState'], 'city' => $_POST['userCity'], 'address' => $_POST['userAddress'], 'packageId' => $_POST['userPackageId'], 'username' => $_POST['userEmail'], 'password' => $password, 'company_code' => $randomcode, 'roleId' => '4', 'expiryDate' => $expiryDate, 'onLinePayment'=> $_POST['onLinePayment'], 'code_source' => '/var/www/html/pdfviewer_'.$randomcode, 'status' => $_POST['status']);//sprint_r($data);DIE('fdfdf');
        if (!empty($_POST['userID'])) {
            
        } else {
            $userID = $objUser->AddUserdata($data);
//echo '<pre>'; print_r($data);
if(!empty($userID)){
            $dataArray = array('compId' => $userID, 'createDate' => date('Y-m-d H:i:s'),'status' => 'PENDING');
             $cronsID=  $objUser->AddUserCronsdata($dataArray);
}
             $userPackageId = $_POST['userPackageId'];           
             $planDetails = $objUser->getPackageById($userPackageId);
//echo '<pre>'; print_r( $planDetails);
            if (!empty($planDetails)) {
                foreach ($planDetails as $results) {
                      $packageDetails=array(

		                        'id'=>$results->id
		                        ,'plan_type'=>$results->plan_type
		                        ,'name'=>$results->name
		                        ,'allowedDoc'=>allowedDoc
		                        ,'allowedPage'=>$results->allowedPage
		                        ,'amount'=>$results->amount
					,'overageCostPerDoc'=>$results->overageCostPerDoc
					,'overageCostPerPage'=>$results->overageCostPerPage
					,'allowedVideo'=>$results->allowedVideo
					,'allowMaxvideoSize'=>$results->allowMaxvideoSize
					,'overageCostPerVideo'=>$results->overageCostPerVideo
					,'allowUser'=>$results->allowUser
					,'overageCostPerUser'=>$results->overageCostPerUser
					,'status'=>$results->status
					,'recordInsertedDate'=>$results->recordInsertedDate
					,'timePeriod'=>$results->timePeriod
					,'periodType'=>$results->periodType
					,'deleted'=>$results->deleted
					,'alloweLicense'=>$results->alloweLicense
					,'timePeriod'=>$results->timePeriod
					,'storageType'=>$results->storageType

                            );    
                }
            }
//print_r($packageDetails);die('fj');
            $pckg_price = $packagedetail[$userPackageId]->amount;
            $expdate = date('Y-m-d H:i:s', strtotime(date() . ' + ' . $packagedetail[$userPackageId]->timePeriod . $packagedetail[$userPackageId]->periodType)); 
            $paymentData = array(
            'company_code' => $randomcode,
            'plandata' => serialize($packageDetails),
            'expiredDate' => $expdate,
            'plan_id' => $userPackageId,
            'txnId' => $_POST['userReferenceNo'],
            'amount' => $pckg_price,
            'payment_status' => 'complete',
            'status' => '1',
            );
//echo '<pre>'; 
            //print_r($paymentData);die('plan details');
            $objUser->AddUserPackagedata($paymentData);
            header("Location:" . $RedirectURL);
            exit;
            ## End #######
        }
    } else {
        $FormHelper->errordata = $errorformdata = $errors;
    }
}
?>
<div><a href="<?= $RedirectURL ?>" class="back">Back</a></div>


<div class="had">Manage User <span> &raquo; <?php
echo "Add " . $ModuleName;
?> </span></div>
<? if (!empty($errMsg)) {?>
<div height="2" align="center" class="red"><?php echo $errMsg; ?></div>

<? } ?>
        <?php
         if (!empty($_SESSION['mess_company'])) {
            echo '<div height="2" align="center"  class="redmsg" >' . $_SESSION['mess_company'] . '</div>';
            unset($_SESSION['mess_company']);
        }
        ?>
<?php
include("includes/html/box/user_form.php");
?>


</script>

