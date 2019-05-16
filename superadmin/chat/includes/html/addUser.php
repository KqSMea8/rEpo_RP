<?php 
global $FormHelper, $errorformdata, $objVali;

if (isset($_POST['Submit'])) {
    $validatedata = array(
        'userFname' => array(array('rule' => 'notempty', 'message' => 'Please enter first name.')),
        'userLname' => array(array('rule' => 'notempty', 'message' => 'Please enter last name.')),
        'userContacts' => array(array('rule' => 'notempty', 'message' => 'Please enter contact number.')),
        'userAddress' => array(array('rule' => 'notempty', 'message' => 'Please enter address.')),
        'userPackageId' => array(array('rule' => 'notempty', 'message' => 'Please select package.')),
        'userDispalyname' => array(array('rule' => 'notempty', 'message' => 'Please enter user name.')),
        'userEmail' => array(array('rule' => 'notempty', 'message' => 'Please enter email.')),
        'userPwd' => array(array('rule' => 'notempty', 'message' => 'Please enter password.')),
    );
    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);
    $aa = array();
    if (empty($errors)) {
        $objUser = new user();
        $data= array('userFname' => $_POST['userFname'], 'userLname' => $_POST['userLname'],'userContacts' => $_POST['userContacts'],'userAddress' => $_POST['userAddress'],'userPackageId' => $_POST['userPackageId'],'userDispalyname' => $_POST['userDispalyname'],'userEmail' => $_POST['userEmail'],'userPwd' => $_POST['userPwd']);
       /* $data = array('userdata' =>
            array('pckg_name' => $_POST['pckg_name'], 'pckg_tagline' => $_POST['pckg_tagline'], 'pckg_price' => $_POST['pckg_price'], 'pckg_description' => $_POST['pckg_description'], 'status' => $_POST['status']), 'elementdata' => $_POST['element']);
       */
        if (!empty($_POST['userID'])) {
            $userID = $_POST['userID'];
            $update_id = $objUser->UpdateUserdata($data, $userID);
            header("Location:" . $RedirectURL);
       
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
<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage User <span> &raquo;
	<? 
	if(!empty($_GET['edit'])){
		if($_GET['tab']=="UserInfo"){
			echo "User Details";
		}
	}else{
		echo "Add ".$ModuleName;
	}
	 ?>
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } ?>
  <?php if(!empty($_SESSION['mess_user'])){
  	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_user'].'</div>';
  	unset($_SESSION['mess_user']);  	
  }?>


	<? 
	if(!empty($_GET['edit'])) {
		if($_GET['tab']=="UserInfo"){
			include("includes/html/box/user_form.php");
		}
	}else{
		include("includes/html/box/user_form.php");
	}
	
	
	?>

