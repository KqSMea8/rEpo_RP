<?php
/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * 
 * Description: For add company data 
 * @param: 
 * @return: 
 */

global $FormHelper, $errorformdata, $objVali;
if (!empty($_POST['userID'])) {
	$validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')),
        'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')),
        'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),		
       	);
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
	$data= array('userFname' => $_POST['userFname'], 'userLname' => $_POST['userLname'],'userContacts' => $_POST['userContacts'],'userAddress' => $_POST['userAddress'],'userPackageId' => $_POST['userPackageId'],'status' => $_POST['status']);
	$update_id = $objUser->UpdateUserdata($data, $userID);
	header("Location:" . $RedirectURL);

}
if (isset($_POST['Submit'])) {
	$validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')),
        'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')),
        'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),
        'userEmail' => array(array('rule' => 'notempty', 'message' => 'Please enter email.')),
        'userPwd' => array(array('rule' => 'notempty', 'message' => 'Please enter password.')),
	);
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
	$aa = array();
	if (empty($errors)) {
		$objUser = new user();
		$password=md5($_POST['userPwd']);
		$data= array('userFname' => $_POST['userFname'], 'userLname' => $_POST['userLname'],'userContacts' => $_POST['userContacts'],'userAddress' => $_POST['userAddress'],'userPackageId' => $_POST['userPackageId'],'username' => $_POST['userEmail'],'userEmail' => $_POST['userEmail'],'password' => $password,'userCompcode'=>$randomcode,'userRoleID'=>'2','status' => $_POST['status']);
		if (!empty($_POST['userID'])) {
				
		} else {	
		$userID = $objUser->AddUserdata($data);
		header("Location:" . $RedirectURL); /* Redirect browser */
		/* Make sure that code below does not get executed when we redirect. */
		exit;
		}
	} else {
		$FormHelper->errordata = $errorformdata = $errors;
	}
}
?>
<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">Manage User <span> &raquo; <? 
if(!empty($_GET['edit'])){
	if($_GET['tab']=="company"){
		echo "User Details";
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
		include("includes/html/box/user_form.php");
	}
}else{
	include("includes/html/box/user_form.php");
}


?>

