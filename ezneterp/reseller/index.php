<?php
//echo 'Heloooooooooooooo';
include ('../includes/function.php');

include ('includes/header.php');

require_once($Prefix."classes/rsl.class.php");
$objReseller=new rs();
//echo '<script>alert("fgvsjdbgvfdsbfg");</script>';
if($_GET['email']==''){
    
    if(!empty($_SESSION['CrmRsID'])){
	header("Location:dashboard.php");	
    }else{
	header("Location:user.php");
  }

}

if(!empty($_GET['email'])) {
       //print_r($arryCompany);exit;
    $arryCompany['Email'] = base64_decode($_GET['email']);
    $Password = substr(md5(rand(100,10000)),0,8);
    $Password = $Password;

    if($objReseller->CheckResellerEmail($arryCompany['Email'])){
            $ReturnFlag = $objReseller->ActiveReseller($arryCompany['Email'],$Password); 
    }else{				
            $_SESSION['mess_act'] = 'Invalid Email';			
    }				
    header("Location:user.php?activated=activated");
    exit;

}else{
    $_SESSION['mess_act'] = 'Invalid Email';
}
	
include ('includes/footer.php');
?>
