<?php

//ini_set('display_errors',1);
$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
//ini_set('display_errors',1);

if($_POST){

	CleanPost(); 

	$groups =  $MailchimSetting[0]['name'];
	$merge_vars = array('FNAME'=>$_POST['fname'], 'LNAME'=>$_POST['lname'],
            'GROUPINGS' =>array( array(
            'name' =>$group_Name,
            'groups' =>array($groups)
        )
    ));

$batch[] = array('email' => array('email' =>$_POST['email']), 'merge_vars'=>$merge_vars);
$listsubs = $Mailchimp_Lists->batchSubscribe($cmpId, $batch, false, false, true);

if($listsubs['add_count']==1){
	
	 $data['fname'] = $_POST['fname'];
	 $data['lname'] = $_POST['lname'];
	 $data['euid']  = $listsubs['adds'][0]['euid'];
	 $data['leid']  = $listsubs['adds'][0]['leid'];
	 $data['email'] = $_POST['email'];
	 
	$result = $massmail->AddUserMailChimp($data);
    $_SESSION['message']='<div class="success">User successfully added.</div>';
	header("location:addchimpUser.php");
    exit;
	
}else{
	$_SESSION['message']='<div class="error">'.$listsubs['errors'][0]['error'].'</div>';
	header("location:addchimpUser.php");
    exit;
}

  
}


require_once("../includes/footer.php"); 
?>






