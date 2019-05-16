<?php

$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
$ModuleName = 'MailChimp';
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);
$Mailchimp_Reports = new Mailchimp_Reports($MailChimp);

//ini_set('display_errors',1);

$Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];
//print_r($Campaignfolder);die;


//list Campaigns
   
   
   
	 $ChimpCampaignList = $massmail->GetchimpCampaign();
         //echo "<pre>";print_r($ChimpCampaignList);
         foreach($ChimpCampaignList as $values){
             if($values['status'] == 'send'){
              $campIdAll .= $values['campaign_id'].",";
             }  
             
         }
         
  
           if(!empty($campIdAll)){
             $campIdAll=  substr($campIdAll,0,  strlen($campIdAll)-1);
           }else{
             $campIdAll=false;
           }
        // $campIdAll = $campIdAll?substr($campIdAll,0,  strlen($campIdAll)-1):$campIdAll;
         //echo $campIdAll;die;
         $filter = array('campaign_id'=>$campIdAll);
         //echo "<pre>";print_r($filter);
		$updatelistcmp = array();
         if(!empty($campIdAll)){
         $listCampaign = $Mailchimp_Campaigns->getList($filter);
         //echo "<pre>";print_r($listCampaign);die;
         //$filattr=array('id','folder_id','status');
         $filattr = array('title','subject','from_email','from_name','create_time','send_time','emails_sent','summary','folder_id','id');
         $updatelistcmp = $massmail->filterArray($filattr, $listCampaign['data']);
         
         }
         //echo "<pre>";print_r($updatelistcmp);die;
         
         
         /*
         for($i=1; $i<count($updatelistcmp);$i++)
         {
             echo $updatelistcmp[$i]['emails_sent'];die('hello');
             
         }*/
         
         /*
         for($i=0; $i<count($listCampaign['data']); $i++)
         {
             
             //echo "$i<br/>";
             echo $listCampaign['data'][$i]['id'];
         }*/
         /*
         foreach ($listCampaign['data'] as $key=>$values)
         {
             //echo "<br/>".$values['id'];
         }*/
         //echo "<br />this is size".count($listCampaign['data']);
         //$updatelistcmp=$massmail->filterArray($filattr,$listCampaign['data']);
         //echo "<pre>";print_r($updatelistcmp);die;
         
         
             
                                    
         //echo "<pre>";print_r($listCampaign);die;
	 //echo '<pre>';print_r($ChimpCampaignList);die;
         //echo $ChimpCampaignList[0]['campaign_id'];
	 $num = $massmail->numRows();
     $pagerLink = $objPager->getPager($updatelistcmp, $RecordsPerPage, $_GET['curP']);
     (count($updatelistcmp) > 0) ? ($updatelistcmp = $objPager->getPageRecords()) : ("");
	

/*start Get All Report List From database*/
     $ChimpReportList = $massmail->GetchimpReport();
     $allchimp=array();
     //echo '<pre>';print_r($ChimpReportList);
     if(!empty($ChimpReportList)){
        foreach($ChimpReportList as $val){
            $allchimp[]=$val['campaign_id'];
        } 
     }
     //print_r($allchimp);
     /*
     if($ChimpReportList[0]['campaign_id']!==e0d5c2dd14){
         
         echo 'hahah';
     }
     else{
         echo 'gaga';
         
     }*/
     /*end report list from database*/
     
     /*start code insert data in report table*/
     
  //   echo '<pre>';print_r($updatelistcmp);die;
     
if(!empty($updatelistcmp)){
$data=$tempp=array();
       //  for($i=1;$i<sizeof($updatelistcmp);$i++){
       $i=0;
         foreach($updatelistcmp as $key =>$repvalues){
            if($i!=0 && !in_array($repvalues['id'],$allchimp)){     
                
       
             $data['title']=$repvalues['title'];
             $data['subject']=$repvalues['subject'];
             $data['from_email']=$repvalues['from_email'];
             $data['from_name']=$repvalues['from_name'];
             $data['campaign_id']=$repvalues['id'];
             
             $data['status'] = 'sent';
             $data['created_date']=$repvalues['create_time'];
             $data['send_date']=$repvalues['send_time'];
             $data['type']='MailChamp';
             //echo "<pre>";print_r($data);die;
             $result = $massmail->AddchimpReport($data);
             //$lastid=$massmail->lastInsertId();
             //echo $lastid;die('hello');
         }
         
            
            $i++;
         
}
}
//$tempp[1]['id']!==$ChimpReportList[0]['campaign_id'];

//echo $tempp[1]['id'];
//echo '<br />';
//echo $ChimpReportList[0]['campaign_id'];
//echo '<pre>';print_r($tempp);
//die;
/*end code to insert data In report table*/


//$viewreport=$Mailchimp_Reports->opened('04aed5a5c3');
//$viewsummer=$Mailchimp_Reports->summary('04aed5a5c3');
//echo "<pre>";print_r($viewreport);
//echo "<br/> part 2" ;
//echo "<pre>";print_r($viewsummer);

//die('hello');
//opened(string apikey, string cid, struct opts)

require_once("../includes/footer.php"); 
?>






