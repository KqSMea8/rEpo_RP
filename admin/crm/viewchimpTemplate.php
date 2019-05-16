<?php

$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
$ModuleName = 'MailChimp Template';
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

//ini_set('display_errors',1);



if($_POST){
  header("location:viewchimpTemplate.php");
  exit;
}else{   
         $templateList = $massmail->GetchimpTemplates();
         //echo '<pre>'; print_r($templateList).'<br>';die('jjj');
         //foreach($templateList as $key=>$tmplist)
         //{
             //echo $tmplist[id];
         //}
         //print_r($templateList[0]['id']);
         
	 $template_id =  $MailchimSetting[0]['template_foder_id'];
         //echo 
	// $ChimpUserList = $massmail->GetMailchimviewchimpTemplate();
	 
        $types= array('types'=>'user');
     $filters = array('folder_id'=>$template_id);
     $listtamplate   = $Mailchimp_Templates->getList($types, $filters);
     //echo '<pre>'; print_r($listtamplate).'<br>';die;
     //echo '<pre>'; print_r($listtamplate['user']);die;
     //$newdata=array_merge($templateList,$listtamplate['user']);
     
     //$newdata=$listtamplate['user']+$templateList;
   
     //echo '<pre>'; print_r($newdata);die();
     $num = count($listtamplate['user']);
     //echo $num;
     $pagerLink = $objPager->getPager($listtamplate['user'], $RecordsPerPage, $_GET['curP']);
     //echo $pagerLink;
     (count($listtamplate['user']) > 0) ? ($listtamplate['user'] = $objPager->getPageRecords()) : ("");
     
}
/* start merge code function 
    for($i=0; $i< sizeof($templateList); $i++)
    {   
        foreach($templateList[$i] as $key=>$value)
       {
            $key = ($key == 'id')?'id_new':$key;       
            $tmp[$i][$key]=$value;   
        }
    }
    $templateList=$tmp;
    //echo '<pre>'; print_r($templateList);die;
    for($i=0; $i< sizeof($listtamplate['user']); $i++)
    {
        $data3[$i] = $listtamplate['user'][$i]+$templateList[$i];
       // echo '<pre>'; print_r($data3[$i]['id']);die;
    }
    $num1=count($data3);
     }
    }*/
    //echo $num1;
    //echo '<pre>'; print_r($data3);die;
/* End merge code function */
//$deltamplate   = $Mailchimp_Templates->del('57069');
//echo "<pre>";print_r($deltamplate);

if ((!empty($_GET['del_id'])) && (!empty($_GET['id']))) {
        //print_r($_GET['id_new']);die;
    //echo $_GET['id'];die('hhh');
        $massmail->deleteMailchimTemplate($_GET['del_id']);
        
        
    $deltamplate   = $Mailchimp_Templates->del($_GET['del_id']);
    header("location:viewchimpTemplate.php");
    exit;
}


require_once("../includes/footer.php"); 
?>






