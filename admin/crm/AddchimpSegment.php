<?php


$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once(_ROOT."/lib/mailchamp/src/config.php");


$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);


//ini_set('display_errors',1);
$ChimpUserList = $massmail->GetMailchimUser();
//echo '<pre>';print_r($ChimpUserList);
$num = $massmail->numRows();
//echo $num;
//$pagerLink = $objPager->getPager($ChimpUserList, $RecordsPerPage, $_GET['curP']);
 //(count($ChimpUserList) > 0) ? ($ChimpUserList = $objPager->getPageRecords()) : ("");

if(!empty($_POST['name'])){
	CleanPost(); 
	$name =  $_POST['name'];
	try{
     $segmentId = $Mailchimp_Lists->StaticSegmentAdd($cmpId,$name);
     //echo '<pre>'; print_r($segmentId);die;
     foreach($_POST['check'] as $chk){
	       $batch =  array('emails' => array('euid' => $chk));
          $listseg = $Mailchimp_Lists->staticSegmentMembersAdd($cmpId,$segmentId['id'], $batch);
                                      }
          //echo "<pre>";print_r($listseg);die;
          //echo "<pre>";print_r($ChimpUserList);die;
          if($listseg['success_count']==1){
          	$data['name'] = $_POST['name'];
	         $data['segment_id'] = $segmentId['id'];
	 
	          $result = $massmail->AddchimpSegment($data);
             $_SESSION['message']='<div class="success">Segment successfully added.</div>';
	          header("location:AddchimpSegment.php");
             exit;
                  }
    }
    catch(Exception $e){
    	//echo "Name Already Exist.";
    	$_SESSION['message']='<div class="success">Segment Name Already Exist.</div>';
	header("location:AddchimpSegment.php");
    exit;
    }
 
	
} 

else{
//$_SESSION['message']='<div class="error">'.$listsubs['errors'][0]['error'].'</div>';
	//header("location:AddchimpSegment.php");
    //exit;
}

/*start code for the update segment*/
//$seg_id='22377';
//$segment_opts=array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $seg_id)));
//$opts=array("name"=>"oopp","segment_opts"=>$segment_opts);
//$updateseg = $Mailchimp_Lists->segmentUpdate($cmpId, $seg_id, $opts);
//echo '<pre>'; print_r($updateseg);
/*End code for the update segment*/
require_once("../includes/footer.php");

?>






