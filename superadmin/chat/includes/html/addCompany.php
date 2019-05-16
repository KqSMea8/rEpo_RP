<?php
/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * 
 * Description: For add company data 
 * @param: 
 * @return: 
 */



global $FormHelper, $errorformdata, $objVali;
$objPlan=new plan();

if (!empty($_POST['userID'])) {
    //***********************************Amit Singh******************************************************/
	$validatedata = array(
            'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')
                ,array('rule' => 'string', 'message' => 'Please enter only alphabets.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ),
            'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')
                ,array('rule' => 'string', 'message' => 'Please enter only alphabets.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ),
            'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')
                ,array('rule' => 'number', 'message' => 'Please enter only numbers.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ,array('rule' => 'limit', 'message' => 'Please enter 10 digits.')
                ),
            'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
            'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),
             'allow_user' => array(array('rule' => 'notempty', 'message' => 'Please enter allow user.')
                ,array('rule' => 'number', 'message' => 'Please enter only number.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ),
       	);
    //***********************************End by Amit Singh******************************************************/
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
        
        if (empty($errors)) {
            
            $data= array(
                'userFname' => $_POST['userFname']
                ,'userLname' => $_POST['userLname']
                ,'userContacts' => $_POST['userContacts']
                ,'userAddress' => $_POST['userAddress']
                ,'userPackageId' => $_POST['userPackageId']
                ,'status' => $_POST['status']);
            $update_id = $objUser->UpdateUserdata($data, $userID);
            ###By Niraj ######
            $userPackageId=$_POST['userPackageId'];
            $userCompcode=$arryUser->userCompcode;
            //*************************Amit Singh***************************************************/
                    /*$arryPlan=$objPlan->getPlanpackageElement($userPackageId);
                    if(!empty($arryPlan)){ 
                        foreach ($arryPlan as $key=>$value) {
		        $r[]= array($value->ele_key => $value->ele_value);
                        }
                    }
                    $b=serialize($r);*/
            
                $arryPlan=$objPlan->getPackageElement($userPackageId);
                if(!empty($arryPlan)){
                    foreach ($arryPlan as $key=>$value) {

                        $r[]= array('label'=>$value->ele_key,'value'=>$value->ele_value);
                    }
                }
                $b=serialize($r);
                //*************get package_details(Amit Singh)****************
                  $planDetails=$objPlan->getPlanPackage($userPackageId);
                  $packageDetails='';
                    if(!empty($planDetails)){
                        foreach ($planDetails as $results) {
                            $packageDetails=array(

                                'Package Name'=>$results->pckg_name
                                ,'Package Tagline'=>$results->pckg_tagline
                                ,'Package Price'=>$results->pckg_price
                                ,'Package Description'=>base64_encode(addslashes($results->pckg_description))
                                ,'Peackage Time'=>$results->package_time
                            );
                        }
                    }
                
            //*************************End***************************************************/
            $pckg_price= $packagedetail[$userPackageId]->pckg_price;
            $expdate= $packagedetail[$userPackageId]->package_time;
            $datas =array(
                'userCompcode'=>$userCompcode,
                'plan_package_element'=> $b,
                'package_detail'=>serialize($packageDetails),
                'exp_date'=>$expdate,
                'userPackageId'=>$userPackageId,
                'allow_user'=>$_POST['allow_user'],
                'pckg_price' =>$pckg_price
            ); 
            
            $objUser->AddUserPackagedata($datas,$userPackageId);
		header("Location:" . $RedirectURL); /* Redirect browser */
		/* Make sure that code below does not get executed when we redirect. */
		exit;
        }else {
		$FormHelper->errordata = $errorformdata = $errors;
	}
## End By Niraj#########
}

if (isset($_POST['Submit'])) {
    //***********************************Amit Singh***************************************************************/
	$validatedata = array(
            'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')
                ,array('rule' => 'string', 'message' => 'Please enter only alphabets.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ),
            'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')
                ,array('rule' => 'string', 'message' => 'Please enter only alphabets.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ),
            'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')
                ,array('rule' => 'number', 'message' => 'Please enter only numbers.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ,array('rule' => 'limit', 'message' => 'Please enter 10 digits.')
                ),
            'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
            'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),
            
             'allow_user' => array(array('rule' => 'notempty', 'message' => 'Please enter allow user.')
                ,array('rule' => 'number', 'message' => 'Please enter only number.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ),
            
            'userEmail' => array(array('rule' => 'notempty', 'message' => 'Please enter email.')
                ,array('rule' => 'email', 'message' => 'Please enter valid email.')
                ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                ,array('rule' => 'unique', 'message' => 'Email already exists.','table'=>'users','column'=>'userEmail')
                ),
            'userPwd' => array(array('rule' => 'notempty', 'message' => 'Please enter password.')),
	);
    //***********************************End by Amit Singh**************************************************/
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
        //print_r($errors);die;
	$aa = array();
        
	if(empty($errors)) {
                
                $randomcode = 'VSTCK'.randomPassword();
		$objUser = new user();
		$password=md5($_POST['userPwd']);
		$data= array('userFname' => $_POST['userFname'], 'userLname' => $_POST['userLname'],'userContacts' => $_POST['userContacts'],'userAddress' => $_POST['userAddress'],'userPackageId' => $_POST['userPackageId'],'username' => $_POST['userEmail'],'userEmail' => $_POST['userEmail'],'password' => $password,'userCompcode'=>$randomcode,'userRoleID'=>'2','status' => $_POST['status']);
		if (!empty($_POST['userID'])) {
				
		} else {	
		$userID = $objUser->AddUserdata($data);

		## By Niraj ##############
                   $userPackageId=$_POST['userPackageId'];
                $objPlan=new plan();
                //************************get plan_package_element (Amit Singh)************************************/
                //$arryPlan=$objPlan->getPlanpackageElement($userPackageId);
                //echo '<pre>';
                $arryPlan=$objPlan->getPackageElement($userPackageId);
                //print_r($arryPlan);
                if(!empty($arryPlan)){
                    foreach ($arryPlan as $key=>$value) {

                        $r[]= array('label'=>$value->ele_key,'value'=>$value->ele_value);
                        //$r[]=array($value->ele_key => $value->ele_value);
                    }
                }
                //*****************************************/
       
                  //*************get package_details(Amit Singh)****************
                  $planDetails=$objPlan->getPlanPackage($userPackageId);
                  //print_r($planDetails);

                if(!empty($planDetails)){
                    foreach ($planDetails as $results) {
                        $packageDetails=array(

                            'Package Name'=>$results->pckg_name
                            ,'Package Tagline'=>$results->pckg_tagline
                            ,'Package Price'=>$results->pckg_price
                            ,'Package Description'=>base64_encode(addslashes($results->pckg_description))
                            ,'Peackage Time'=>$results->package_time
                        );
                    }
                }
                //print_r($packageDetails);die('plan details');  
                $b=serialize($r);
                $pckg_price= $packagedetail[$userPackageId]->pckg_price;
                $expdate= date('Y-m-d', strtotime(date(). ' + '.$packagedetail[$userPackageId]->package_time.' day'));
                $datas =array(
                    'userCompcode'=>$randomcode,
                    'plan_package_element'=> $b, 
                    'package_detail'=>serialize($packageDetails),
                    'exp_date'=>$expdate,
                    'userPackageId'=>$userPackageId,
                    'pckg_price' =>$pckg_price,
                    'allow_user'=>$_POST['allow_user']
                    ); 
                    $objUser->AddUserPackagedata($datas);

                    //*********************************************************************
                        header("Location:" . $RedirectURL); /* Redirect browser */
                        /* Make sure that code below does not get executed when we redirect. */
                        exit;
                        ## End #######

                }
            
	} else {
		$FormHelper->errordata = $errorformdata = $errors;
	}
}
?>
<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">Manage User <span> &raquo; <?php 
//print_r($_GET);die('rajan');
if(!empty($_GET['edit'])){
	if($_GET['tab']=="company"){
		echo "User Details";
	}else if($_GET["tab"]=="compuserlist"){
		echo "Company User List";              
	}else if($_GET["tab"]=="packagelist"){
		echo "Package List";           
	}else if($_GET["tab"]=="paymenthistory"){
		echo "Payment History";        
	}
 }else{
	echo "Add ".$ModuleName;
}
?> </span></div>
<? if (!empty($errMsg)) {?>
<div height="2" align="center" class="red"><?php echo $errMsg;?></div>

<? } ?>
<?php if(!empty($_SESSION['mess_company'])){
	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_company'].'</div>';
	unset($_SESSION['mess_company']);
}?>


<?php 
if(!empty($_GET['edit'])) {
	if($_GET['tab']=="company"){
		include("includes/html/box/user_form.php");
	}else if($_GET['tab']=="compuserlist"){ 
			include("includes/html/box/compuserlist.php");
	}else if($_GET['tab']=="packagelist"){
		include("includes/html/box/packagelist.php");
	}else if($_GET['tab']=="paymenthistory"){
		include("includes/html/box/paymenthistory.php");
	}
}else{
	include("includes/html/box/user_form.php");
}
?>