<?php
$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
//ini_set('display_errors',1);

if($_POST){
     
	/*******************/
	$description = $_POST['description'];
	CleanPost(); 
	$_POST['description'] = $description;
	/*******************/



    $template_id =  $MailchimSetting[0]['template_foder_id'];
    //echo $template_id;die;
    $name = trim($_POST['name']);
    //echo $name;die;
	$html = $_POST['description'];
        //$html='<div>hello test file</div>';
	try{
	$addtamplate   = $Mailchimp_Templates->add($name, $html, $template_id); 
	$data['name'] =  $name;
	$data['template_id'] =  $addtamplate['template_id'];
        $data['description'] =  addslashes($html);
	$result = $massmail->insert( 'c_mail_chimp_templates', $data);
    $_SESSION['message']='<div class="success">Template successfully added.</div>';
	header("location:viewchimpTemplate.php");
    exit;
	}catch(Exception $e) {	
	$_SESSION['message']='<div class="error">This template already exists.</div>';
	header("location:addchimpTemplate.php");
	exit;
	}
}

/*start code for update templates*/
//$Mtemplate='75373';
//$values=array("name"=>"sadc","html"=>"tttt hhh jjjj","folder_id"=>$template_id);
//$updatetamplate= $Mailchimp_Templates->update($Mtemplate,$values);
//echo '<pre>';print_r($updatetamplate);
/*end code for update templates*/
require_once("../includes/footer.php"); 
?>






