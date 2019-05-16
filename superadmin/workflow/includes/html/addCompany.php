<?php
/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * 
 * Description: For add company data 
 * @param: 
 * @return: 
 */



global $FormHelper, $errorformdata, $objVali;
$objPlan=new coupan();

if (!empty($_POST['userID'])) { //print_r($arryUser);
	$validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        );
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
	
	//$data= array('name' => $_POST['userFname'], 'expire_date' => date("Y-m-d",strtotime($_POST['userAddress'])),'allow_users'=>$_POST['userNumber'], 'status' => $_POST['status']);
	$data= array('name' => $_POST['userFname'], 'membership_type' => $_POST['membership_type'],'expire_date' => date("Y-m-d",strtotime($_POST['userAddress'])),'allow_users'=>$_POST['userNumber'], 'status' => $_POST['status']);

	$datanu= array('name' => $_POST['userFname'], 'status' => 'Active');
//echo 'ram';
	$update_id = $objUser->UpdateUserdata($data, $userID);
	$email=$_POST['userContacts'];
	$name=$_POST['userFname'];
	$update_Uid = $objUser->UpdateUseruserdata($name, $userID, $email);
//print_r($update_Uid);

###By Niraj ######
$userPackageId=$_POST['userPackageId'];
	$userCompcode=$arryUser->userCompcode;
        $arryPlan=$objPlan->getPlanpackageElement($userPackageId);
        if(!empty($arryPlan)){ 
          foreach ($arryPlan as $key=>$value) {
		        $r[]= array($value->ele_key => $value->ele_value);
		      }
        }
	$b=serialize($r);
       $pckg_price= $packagedetail[$userPackageId]->pckg_price;
       $expdate= $packagedetail[$userPackageId]->package_time;
       $datas =array(
           'userCompcode'=>$userCompcode,
           'plan_package_element'=> $b,  
           'exp_date'=>$expdate,
           'userPackageId'=>$userPackageId,
           'pckg_price' =>$pckg_price,
             ); 
            $objUser->AddUserPackagedata($datas,$userPackageId);
		header("Location:" . $RedirectURL); /* Redirect browser */
		/* Make sure that code below does not get executed when we redirect. */
		exit;
## End By Niraj#########
}
if (isset($_POST['Submit'])) {
	$validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')),
        'userContacts' =>array(array('rule' => 'notempty', 'message' => 'Please enter email.')
                ,array('rule' => 'email', 'message' => 'Please enter valid email.')
                ),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        'userPwd' => array(array('rule' => 'notempty', 'message' => 'Please enter password.')),
	);
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
	$aa = array();
	if (empty($errors)) {
                $randomcode = 'VSTCK'.randomPassword();
		$objUser = new company();
		$password=md5($_POST['userPwd']);
		//$data= array('name' => $_POST['userFname'],'email' => $_POST['userContacts'],'expire_date' => date("Y-m-d",strtotime($_POST['userAddress'])),'status' => $_POST['status']);
		$data= array('name' => $_POST['userFname'],'membership_type' => $_POST['membership_type'],'password'=>$password,'email' => $_POST['userContacts'],'expire_date' => date("Y-m-d",strtotime($_POST['userAddress'])),'status' => $_POST['status'],'created_date' => date("Y-m-d"),'rand_key'=>$key,);

 
		if (!empty($_POST['userID'])) {
				
		} else {	
		$userID = $objUser->AddUserdata($data);
		$key = $objUser->randomPassword();
		if (!empty($userID)) {
		$datauser= array('cmp_id'=>$userID, 'name' => $_POST['userFname'],'email' => $_POST['userContacts'],'password'=>$password,'created_date' => date("Y-m-d"),'rand_key'=>$key,'status' => 'Active');
	$datauservalue=$objUser->AddUseruserdata($datauser);
//echo 'main'.$datauservalue;
//print_r($datauser);
}
		//echo('user id'.$userID);
		## By Niraj ##############
                   $userPackageId=$_POST['userPackageId'];
	/*$objPlan=new coupan();
        $arryPlan=$objPlan->getPlanpackageElement($userPackageId);
        if(!empty($arryPlan)){
          foreach ($arryPlan as $key=>$value) {
		        $r[]= array($value->ele_key => $value->ele_value);
		      }
        }*/
	/*$b=serialize($r);
        $pckg_price= $packagedetail[$userPackageId]->pckg_price;
        $expdate= date('Y-m-d', strtotime(date(). ' + '.$packagedetail[$userPackageId]->package_time.' day'));
        $datas =array(
           'userCompcode'=>$randomcode,
           'plan_package_element'=> $b,  
           'exp_date'=>$expdate,
           'userPackageId'=>$userPackageId,
           'pckg_price' =>$pckg_price,
             ); */
            //$objUser->AddUserPackagedata($datas);
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


<div class="had">Manage Company <span> &raquo; <? 
//print_r($_GET);die('rajan');
if(!empty($_GET['edit'])){
	if($_GET['tab']=="company"){
		echo "Company Details";
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


<?
if(!empty($_GET['edit'])) {
	if($_GET['tab']=="company"){
		include("includes/html/box/company_form.php");
	}else if($_GET['tab']=="compuserlist"){ 
			include("includes/html/box/compuserlist.php");
	}else if($_GET['tab']=="packagelist"){
		include("includes/html/box/packagelist.php");
	}else if($_GET['tab']=="paymenthistory"){
		include("includes/html/box/paymenthistory.php");
	}
}else{
	include("includes/html/box/company_form.php");
}


?>

