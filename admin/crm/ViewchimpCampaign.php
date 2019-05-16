<?php

$FancyBox = 1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
$ModuleName = 'MailChimp';
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT . "/lib/mailchamp/src/config.php");
//ini_set('display_errors',1);
$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);
$Mailchimp_Reports = new Mailchimp_Reports($MailChimp);

//ini_set('display_errors',1);

$Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];
$today = time();
//echo $today;
//print_r($Campaignfolder);die;

//code for update campaign
//$id='e0d5c2dd14';
//$name='newupdate';
//$value=array('subject'=>'hello');
//$seg='21197';
//$options=array('subject'=>'hello');
//$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $seg)));
//$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => array('17989','17985'))));
//echo "<pre>";print_r($segment);die;

//$content = array('html'=>'some pretty html content','text' => 'text text text *|UNSUB|*');
//$name=($options,$content,$segment);
//$name=name('hello');

//die('hfhfhf');

if ($_POST) {
    header("location:ViewchimpCampaign.php");
    exit;
} else {
    //list Campaigns


    /* start code for campignlist from database */
    $ChimpCampaignList = $massmail->GetchimpCampaign();
    //echo '<pre>';print_r($ChimpCampaignList);
    //code for change the key of the array
    $temp = $templist = array();
    for ($i = 0; $i < sizeof($ChimpCampaignList); $i++) {

        foreach ($ChimpCampaignList[$i] as $key => $values) {

            $key = ($key == 'id') ? 'id_local' : $key;
            $key = ($key == 'status') ? 'status_send' : $key;
            //echo $key;die('newid');
            $temp[$i][$key] = $values;
        }
    }
    $templist = $temp;
//echo '<pre>';print_r($templist);die('kkk');
    /* End code for campignlist from database */
    
    
    $campIdAll = '';
    /* start code for GET campign with comm seprated values and list of the campaign from API */
    foreach ($ChimpCampaignList as $values) {
        $campIdAll .=$values['campaign_id'] . ",";
    }
    $campIdAll = strlen($campIdAll) ? substr($campIdAll, 0, strlen($campIdAll) - 1) : $campIdAll;
    //echo $campIdAll;
    $filter = array('campaign_id' => $campIdAll);
    $listCampaign = $Mailchimp_Campaigns->getList($filter);
    //$newdata=$ChimpCampaignList+$listCampaign['data'];
    //$result = array_merge($templist, $listCampaign['data']);
   /* END code for GET campign with comm seprated values and list of the campaign from API */
    
    
    /* start code for Array Merge */
    for ($i = 0; $i < sizeof($listCampaign['data']); $i++) {
		if(!empty($templist)){
        	$result[$i] = array_merge($listCampaign['data'][$i], $templist[$i]);
    	}else{
			$result[$i] = $listCampaign['data'][$i];
		}
	}
    //echo "<pre>";print_r($result);die;
    
    /* End code for Array Merge */
    //echo '<pre>';print_r($newdata);
    //echo $ChimpCampaignList[0]['campaign_id'];
    $num = $massmail->numRows();
    $pagerLink = $objPager->getPager($result, $RecordsPerPage, $_GET['curP']);
    (count($result) > 0) ? ($result = $objPager->getPageRecords()) : ("");
}

/* start code for DELETE campaign from local and API Database both */
if (!empty($_GET['del_id'])) {
    
    $massmail->deleteMailchimCampaign($_GET['del_id']);
    $massmail->deleteMailchimReport($_GET['del_campaign']);
    $CampaignId = array('campaignId' => $_GET['del_campaign']);
    //print_r($CampaignId);die;
    $Mailchimp_Campaigns->delete($CampaignId['campaignId']);
    header("location:ViewchimpCampaign.php");
    exit;
}
/* END code for DELETE campaign from local and API Database both */


/* start code for SEND MAIL campaign from local and API Database both */
if (!empty($_GET['Camp_id'])) {
    //echo 'hello';
    //$SCampaignId = array('ScampaignId' =>$_GET['Camp_id']);
    //echo $_GET['Camp_id'];
    //print_r($CampaignId);die;
    $sendemail = $Mailchimp_Campaigns->send($_GET['Camp_id']);

    if ($sendemail['complete'] == 1) {
        echo 'test';
        $massmail->UpdateStatusMailchimCampaign($_GET['S_id']);
        $_SESSION['message'] = '<div class="success">Mail Send successfully.</div>';
        header("location:ViewchimpCampaign.php");
        exit;
    } else {

        $_SESSION['message'] = '<div class="success">Try Again.</div>';
        header("location:ViewchimpCampaign.php");
        exit;
    }
}
/* END code for SEND MAIL campaign from local and API Database both */

//$seg='21197';
//$seg=20605;

//$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $seg)));
//$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => array('17989','17985'))));
//echo "<pre>";print_r($segment);die;

//$content = array('html'=>'some pretty html content','text' => 'hello hello hello *|UNSUB|*');
//$option=array('title'=>'test2','subject'=>'demo2','from_email'=>'sachin.motla77@gmail.com','from_name'=>'sachin');
//$name=array('options','content','segment_opts');
//$value=array($option,$content,$segment);

//$value=$option,$content,$segment;
//$value=array('value' => $option,'value' => $content,'value' => $segment);
//$id=72e637cb4e;
//echo $cmpId;die();
//$update=$Mailchimp_Campaigns->update('72e637cb4e','options,content,segment_opts', array($option,$content,$segment));

//$optionsupdate=$Mailchimp_Campaigns->update('72e637cb4e',options,$option);
//$segmentupdate=$Mailchimp_Campaigns->update('72e637cb4e',segment_opts,$segment);

//$update=var_dump($Mailchimp_Campaigns->update('72e637cb4e', 'content', array('tiwc200_content00_non_exisiting' => 'NEW TEST CONTENT')));
//$update=$Mailchimp_Campaigns->update('72e637cb4e','newtestcmap', array('subject' => 'testzzz'));

//echo '<pre>';print_r($optionsupdate);
//echo '<br/>';
//echo '<pre>';print_r($segmentupdate);
//echo '<pre>';print_r($segmentupdate['data']['segment_opts']['conditions'][0]['value']);
//die('hrkkinju');

/*Test code for mail champ report and summery
$viewreport=$Mailchimp_Reports->opened('04aed5a5c3');
$viewsummer=$Mailchimp_Reports->summary('04aed5a5c3');
echo "<pre>";print_r($viewreport);
echo "<br/> part 2" ;
echo "<pre>";print_r($viewsummer);
die('hello');
opened(string apikey, string cid, struct opts)

Test code for mail champ report and summery*/

require_once("../includes/footer.php");
?>






