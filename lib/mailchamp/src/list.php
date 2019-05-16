<?php
ini_set('display_errors','1');
require 'Mailchimp.php';

//$MailChimp = new MailChimp('c5085810ebeb6dd716f087ee1b7da949-us10');
$MailChimp = new MailChimp('6a05f5250045957c384c3e80cf917ca1-us10');

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

$list = $Mailchimp_Lists->getList();
echo "<pre>";print_r($list);



$addfolder= $Mailchimp_Folders->add('vstacks','template');

#list folder
$folderlist  = $Mailchimp_Folders->getList('template');
echo "<pre>";print_r($folderlist);die;



$batch[] = array('email' =>'sachin.motla77@gmail.com');
	$delet = $Mailchimp_Lists->BatchUnsubscribe('a61d996a4a',$batch,true,false,false);
	echo "<pre>";print_r($delet);die;


//$addgroup =  $Mailchimp_Lists->interestGroupingAdd('a61d996a4a', 'testing', 'checkboxes','24181');
$addgroup =  $Mailchimp_Lists->interestGroupAdd('a61d996a4a', 'testing');
echo "<pre>";print_r($addgroup);




/*

$merge_vars = array(
    'GROUPINGS' => array( array(
            'name' => 'compnay-group', // or name instead			//You have to find the number via the API
            'groups' => "vsatcks",
        )
    )
);

$batch[] = array('email' => array('email' => 'user1@mail.com'), $merge_vars);


$listsubs = $Mailchimp_Lists->batchSubscribe('799283c68c', $batch, false, false, false);
echo "<pre>";print_r($listsubs);

email] => user1@mail.com
                    [euid] => c6fbd7bb9c
                    [leid] => 13811489
*/



  //$segmentId = $Mailchimp_Lists->StaticSegmentAdd('799283c68c','first_segment-1');
  $segmentId = '1525';
 // echo "<pre>";print_r($segmentId);die; //
 
 
  
  //$batch = array('email'=>'user1@mail.com','euid'=>'c6fbd7bb9c','leid'=>'13811489');
  
  //$listseg = $Mailchimp_Lists->staticSegmentMembersAdd('799283c68c',$segmentId, $batch); 
 // echo "<pre>";print_r($listseg);

/*
$result = $MailChimp->call('lists/subscribe', array(
    'id'                => 'LIST_ID',
    'email'             => array( 'email' => $_POST['email'] ),
    'merge_vars'        => array(
        'MERGE2' => $_POST['name'] // MERGE name from list settings
        // there MERGE fields must be set if required in list settings
    ),
    'double_optin'      => false,
    'update_existing'   => true,
    'replace_interests' => false
));
*/


// get list for the user list
//$list = $Mailchimp_Lists->getList(array('web_id'=>'20761'));
//echo "<pre>";print_r($list);

###### start folder ########

#add folder
$addfolder= $Mailchimp_Folders->add('vstacks-5','template');

#list folder
$folderlist  = $Mailchimp_Folders->getList('template');
echo "<pre>";print_r($folderlist);die;

###### start templates ########

#add tamplate
//$html = "hello testing";
//$addtamplate   = $Mailchimp_Templates->add('vstacks-templates-2', $html, '69');
//echo "<pre>";print_r($addtamplate); //[template_id] => 8369

#listing tamplate
//$types= array('types'=>'user');
//$filters = array('folder_id'=>69);
//$listtamplate   = $Mailchimp_Templates->getList($types, $filters);
//echo "<pre>";print_r($listtamplate);

#info tamplate
//$infotamplate   = $Mailchimp_Templates->info('8369', 'user');
//echo "<pre>";print_r($infotamplate);


#delete tamplate
//$deltamplate   = $Mailchimp_Templates->del('8369');
//echo "<pre>";print_r($deltamplate);

#### Campaigns##########

#create Campaigns
//$options= array('list_id'=>'799283c68c','subject'=>'test mail','from_email'=>'pankaj.kumar@vstacks.in','from_name'=>'pankaj yadav','to_name'=>'toname' ,'template_id'=>'8421');
//$content = array('html'=>'some pretty html content','text' => 'text text text *|UNSUB|*');
//$addCampaign = $Mailchimp_Campaigns->create('plaintext', $options, $content);
//echo "<pre>";print_r($addCampaign);

#list Campaigns
//$filter = array('folder_id'=>297);
//$listCampaign = $Mailchimp_Campaigns->getList($filter);
//echo "<pre>";print_r($listCampaign);

#sendTest Campaigns
//$test_emails = array('pankaj.jingle@gmail.com','ravisolanki343@gmail.com');
//$sendTestCampaign = $Mailchimp_Campaigns->sendTest('0da34bbd1d', $test_emails);
//echo "<pre>";print_r($sendTestCampaig);

# send Campaigns
//$sendemail  = $Mailchimp_Campaigns->send('0da34bbd1d');
//echo "<pre>";print_r($sendemail);

########### add segment ###############





//$list_insert_groping = $Mailchimp_Lists->interestGroupings('799283c68c',true);
//echo "<pre>";print_r($list_insert_groping);
/*
$merge_vars = array(
    'GROUPINGS' => array( array(
            'name' => 'Members', // or name instead			//You have to find the number via the API
            'groups' => "pankaj-group6",
        )
    )
);

$batch[] = array('email' => array('email' => 'user1224@mail.com'), $merge_vars);


$merge_vars = array(
    'GROUPINGS' => array(
        0 => array(
            'id' => "593", //You have to find the number via the API
            'groups' => "pankaj-group6",
        )
    )
);
*/
//$batch[] = array('email' => 'user30@mail.com');
//$listsubs =  $Mailchimp_Lists->updateMember('c748b851fe', $batch, $merge_vars);
///$batch[] = array('email' => array('email' => 'user30@mail.com'), $merge_vars);
/*

 $batch = Array('email' => array('email'=>'user141@gmail.com'),array(
    'GROUPINGS'=>array(
        array('name'=>'Members', 'groups'=>'pankaj-group6'),
        ))
    );
*/

//$listsubs = $Mailchimp_Lists->batchSubscribe('c748b851fe', $batch, false, false, false);
//echo "<pre>";print_r($listsubs);


	 
	// By default this sends a confirmation email - you will not see new members
	// until the link contained in it is clicked!
	//$retval = $Mailchimp_Lists -> batchSubscribe( 'c748b851fe',$merge_vars,false, false,true);







//$list_insert = $Mailchimp_Lists->interestGroupAdd('c748b851fe','pankaj-group5','597');
//$list_insert = $Mailchimp_Lists->interestGroupAdd('c748b851fe','pankaj-group8');
//$list_insert = $Mailchimp_Lists->interestGroupingAdd('c748b851fe','pankaj-group2','checkboxes','');


//echo "<pre>";print_r($list_insert);

//$list_insert_groping = $Mailchimp_Lists->interestGroupings('799283c68c',true);
//echo "<pre>";print_r($list_insert_groping);


//$batch[] = array('email' => array('email' => 'user1@mail.com'));

//$subscriber = $Mailchimp_Lists -> batchSubscribe('c748b851fe', $batch, false, false, '');





if( $result === false ) {
    // response wasn't even json
}
else if( isset($result->status) && $result->status == 'error' ) {
    // Error info: $result->status, $result->code, $result->name, $result->error
}

?>