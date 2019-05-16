<?php
$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
//ini_set('display_errors',1);
$tempId = $_GET['Temp_id'];
$id = isset($_GET['id']) ? $_GET['id'] : '';
//echo $tempId.'<br/>'.$id;
$templateList = $massmail->GetchimpTemplates($tempId);
$chimptempname = $templateList[0]['name']."(copy)";
//echo '<pre>'; print_r($templateList);die('bbbb');

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
        //$Mtemplate=$tempId;
        try{
            $values=array("name"=>$name,"html"=>$html,"folder_id"=>$template_id);
            echo '<pre>';print_r($values);
            $updatetamplate= $Mailchimp_Templates->update($tempId,$values);
            echo '<pre>';print_r($updatetamplate);
            if($updatetamplate['complete']==1) {
                            $data['name'] = $name;
                            //$data['template_id'] = $tempId;
                            $data['description'] = addslashes($html);
                            $result = $massmail->UpdateChimpTemplate($data,$tempId);
                            $_SESSION['message'] = '<div class="success">Update Template successfully.</div>';
                            header("location:viewchimpTemplate.php");
                            exit;
                            
            }
        }catch(Exception $e) {	
	$_SESSION['message']='<div class="error">This template name already exists.</div>';
	header("location:EditchimpTemplate.php");
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






