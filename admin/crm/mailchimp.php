<?php

$FancyBox=1;
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");


$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);
$Mailchimp_Reports = new Mailchimp_Reports($MailChimp);
//echo _SiteUrl.'admin/crm/mailchimp.php';die;
//ini_set('display_errors',1);
$Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];

if($_POST){
	CleanPost(); 
$name =  trim($_POST['name']);

  //$list_floder = $Mailchimp_Folders->getList('template');
	try{
	  $list_floder = $Mailchimp_Folders->getList('template');
	}
	catch(Exception $e) {
	    $_SESSION['mess_mass']='<div class="error">Details are not valid . Please try to later.</div>';
	}
   // $Mailchimp_Folders->del('109','template');
   // $Mailchimp_Folders->del('110','template');
   //echo "<pre>";print_r($list_floder);die;
#add folder under template
try{
$addfolder_template = $Mailchimp_Folders->add($name,'template');
$addfolder_template_id =  $addfolder_template['folder_id'];


} catch(Exception $e) {
  $_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';
   
}

#add folder under Campaigns
try{
$addfolder_campaign = $Mailchimp_Folders->add($name,'campaign');
$addfolder_campaign_id =  $addfolder_campaign['folder_id'];
} catch(Exception $e) {
  $_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';

}

#add group

try{
$addgroup =  $Mailchimp_Lists->interestGroupAdd($cmpId, $name);
}catch(Exception $e) {
$_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';

}



if(!empty($addfolder_template_id) && !empty($addfolder_campaign_id) && $addgroup['complete']==1){
	  $data['name'] = $name;
	  $data['template_foder_id'] = $addfolder_template_id;
	  $data['campaign_folder_id'] = $addfolder_campaign_id;
	  $data['group_id'] = $addgroup['complete'];
	  $data['list_id'] =  $cmpId;
	  
	  $result = $massmail->CreateAccountMailChimp($data);
	  $MailchimSetting = $massmail->GetMailchimSetting();
	  $_SESSION['mess_mass']='<div class="success">Account created successfully.</div>';
	  header('Location: ' . _SiteUrl.'admin/crm/mailchimp.php'); exit;
}else{
	$_SESSION['mess_mass']='<div class="error">Mail chimp account is invalid. Please fill the valid credentials.</div>';
   
}


}
// code for Recent send campaign
//GetchimpReport

$RReport=$massmail->GetchimpReport();
//echo '<pre>';print_r($RReport);die('hello');

//echo '<pre>';print_r($LastInsertedID);die('hello');
//echo $LastInsertedID[0]['id'];
if(!empty($RReport)) {
try{
$LastInsertedID=$massmail->MailLastInsetID();
$LastRentCmpID=$massmail->GetResentSendCampaignID($LastInsertedID[0]['id']);
//echo '<pre>';print_r($LastRentCmpID);
//echo $LastRentCmpID[0]['campaign_id'];
if(!empty($LastRentCmpID[0]['campaign_id'])){
    //$RCmpID="'".$_GET['ReCmpID']."'";
    //echo $RCmpID;
$viewreport=$Mailchimp_Reports->opened($LastRentCmpID[0]['campaign_id']);
$viewsummer=$Mailchimp_Reports->summary($LastRentCmpID[0]['campaign_id']);
$GetcampaignSummery=$massmail->GetchimpCampaignSummery($LastRentCmpID[0]['campaign_id']);
//echo '<pre>';print_r($GetcampaignSummery);
//echo "<pre>";print_r($viewreport);
//echo "<br/> part 2 <br/>";
//echo "<pre>";print_r($viewsummer);die;
$openrate=$viewsummer['unique_opens']*100/$viewsummer['emails_sent'];
 $Openrate=round($openrate,1).'%';
 $OpenrateWidth=round($openrate,0).'%';
//echo $viewsummer['emails_sent'];
//die();
    
}
}
catch(Exception $e) {
    $_SESSION['mess_mass']='<div class="error">Details are not valid. Please try to later.</div>';
}
}

 
require_once("../includes/footer.php"); 
?>






