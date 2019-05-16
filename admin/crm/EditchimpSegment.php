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
$segmId=$_GET['Segm_id'];
//echo $segmId;
$ChimpSegmList = $massmail->GetchimpSegment($segmId);
//echo '<pre>'; print_r($ChimpSegmList);die;
//$num = $massmail->numRows();
//$pagerLink = $objPager->getPager($ChimpUserList, $RecordsPerPage, $_GET['curP']);
// (count($ChimpUserList) > 0) ? ($ChimpUserList = $objPager->getPageRecords()) : ("");

if(!empty($_POST['name'])){
	CleanPost(); 
	$name =  $_POST['name'];
        /*start code for the update segment*/
            //$seg_id='22377';
        try{
            $segment_opts=array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $segmId)));
            $opts=array("name"=>$name,"segment_opts"=>$segment_opts);
            //echo '<pre>'; print_r($segment_opts);
            //echo '<br/><pre>';print_r($opts);
            //echo '<br/>'.$cmpId;
            $updateseg = $Mailchimp_Lists->segmentUpdate($cmpId, $segmId, $opts);
            //echo '<pre>'; print_r($updateseg);die;
            if(!empty($updateseg['complete'])==1){
                 $data['name']=$name;
                 $results=$massmail->UpdateChimpSegment($data,$segmId);
                 $_SESSION['message']='<div class="success">Update segment successfully.</div>';
	          header("location:viewchimpSegment.php");
             exit;
            }
            }
    catch(Exception $e){
    	//echo "Name Already Exist.";
    	$_SESSION['message']='<div class="success">Segment Name Already Exist.</div>';
	header("location:viewchimpSegment.php");
    exit;
    }

            /*End code for the update segment*/
}
            /*
	try{
              
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
*/
/*start code for the update segment*/
//$seg_id='22377';
//$segment_opts=array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $seg_id)));
//$opts=array("name"=>"oopp","segment_opts"=>$segment_opts);
//$updateseg = $Mailchimp_Lists->segmentUpdate($cmpId, $seg_id, $opts);
//echo '<pre>'; print_r($updateseg);
/*End code for the update segment*/
require_once("../includes/footer.php");

?>






