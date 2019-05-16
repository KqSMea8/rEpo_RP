<?php

$FancyBox = 1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once(_ROOT . "/lib/mailchamp/src/config.php");


$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);


//ini_set('display_errors',1);
/* start code for chose template */
$template_id = $MailchimSetting[0]['template_foder_id'];
// $ChimpUserList = $massmail->GetMailchimviewchimpTemplate();

$types = array('types' => 'user');
$filters = array('folder_id' => $template_id);
$_SESSION['Retime']=$_GET['Rtime']; 
//echo $_SESSION['Retime'];die();

if(!empty($_GET['S_id'])){
    $id=$_GET['S_id'];
    $Camp_id=$_GET['Camp_id'];
    //echo '<pre>';print_r($Camp_id);die('reuse');
    
 if (!isset($_POST['Submit'])) {  
    //if($_SESSION['Retime']!=$_GET['Rtime']){
    $reuselist = $Mailchimp_Campaigns->replicate($Camp_id);
     $Reuse_Id=$reuselist['id'];
 }
}

$listtamplate = $Mailchimp_Templates->getList($types, $filters);
//print_r($listtamplate);die;
//echo '<pre>'; print_r($listtamplate);die;
$num = count($listtamplate['user']);
$pagerLink = $objPager->getPager($listtamplate['user'], $RecordsPerPage, $_GET['curP']);
(count($listtamplate['user']) > 0) ? ($listtamplate['user'] = $objPager->getPageRecords()) : ("");

/* end code for chose tempale */
/* start code for chose segment */
$ChimpSegmentList = $massmail->GetchimpSegment();
//echo '<pre>';print_r($ChimpSegmentList);die;
$num = $massmail->numRows();
$pagerLink = $objPager->getPager($ChimpSegmentList, $RecordsPerPage, $_GET['curP']);
(count($ChimpSegmentList) > 0) ? ($ChimpSegmentList = $objPager->getPageRecords()) : ("");
/* end code for chose segment */

/* start code for submit code */
//print_r($_POST);
 

if (isset($_POST['Submit'])) {
    //print_r($_POST);die('submit');
    if (!empty($_POST['subject'])) {
        //print_r($_POST);die;
        $Rcmp_Id=$_POST['RcmpId'];
        $title = $_POST['title'];
        $subject = $_POST['subject'];
        $femail = $_POST['femail'];
        $frname = $_POST['frname'];
        $tname = $_POST['tname'];
        $Tempn = $_POST['Tempn'];
        $seg = $_POST['Seg'];
        //$seg=17989;
        //$seg=array('17989','17985');

        try {
            $options = array('list_id' => $cmpId, 'subject' => $subject, 'title'=>$title,'from_email' => $femail, 'from_name' => $frname, 'template_id' => $Tempn, 'auto_footer' => false);
//echo "<pre>";print_r($options);die();
            $segment = array('match' => 'all', 'conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $seg)));
//$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => array('17989','17985'))));
//echo "<pre>";print_r($segment);die;

            $content = array('html' => 'some pretty html content', 'text' => 'text text text *|UNSUB|*');
            $optionsupdate=$Mailchimp_Campaigns->update($Rcmp_Id,options,$options);
            //echo '<pre>';print_r($optionsupdate);
            $segmentupdate=$Mailchimp_Campaigns->update($Rcmp_Id,segment_opts,$segment);
            //$addCampaign = $Mailchimp_Campaigns->create('plaintext', $options, $content, $segment);
//echo '<pre>';print_r($segmentupdate);die;

            if (!empty($segmentupdate['data']['id'])) {
                $data['subject'] = $segmentupdate['data']['subject'];
                $data['title'] = $segmentupdate['data']['title'];
                $data['from_email'] = $segmentupdate['data']['from_email'];
                $data['from_name'] = $segmentupdate['data']['from_name'];
	        $data['campaign_id'] = $segmentupdate['data']['id'];
                $data['segment_id'] = $segmentupdate['data']['segment_opts']['conditions'][0]['value'];
                $data['template_id'] = $segmentupdate['data']['template_id'];
                $data['status'] = 'Unsend';
                $data['type']='MailChamp';
                $data['parent_Id']=$Camp_id;
                
                //print_r($data);die;
                $result = $massmail->AddchimpCampaign($data);
                $_SESSION['message'] = '<div class="success">Update Campaign successfully</div>';
                header("location:ReusechimpCampaign.php");
                exit;
            }

//echo "<pre>";print_r($addCampaign);
        } catch (Exception $e) {
            echo "Name Already Exist.";
            $_SESSION['message'] = '<div class="success">Please Fill All the Fields</div>';
            header("location:ReusechimpCampaign.php");
            exit;
        }
    } else {
        echo 'Please Enter the Subject';
    }
}



/* End code for submit code */

require_once("../includes/footer.php");
?>






