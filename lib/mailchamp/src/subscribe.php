<?php

ini_set('display_errors','1');
require 'Mailchimp.php';

$MailChimp = new MailChimp('c5085810ebeb6dd716f087ee1b7da949-us10');

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);



$merge_vars = array('FNAME'=>'Test', 'LNAME'=>'Account',
            'GROUPINGS' => array( array(
            'name' => 'compnay-group',
            'groups' => array('vsatcks')
        )
    ));

$batch[] = array('email' => array('email' => 'pankajkumar.kumar@gmail.com'), 'merge_vars'=>$merge_vars);
$listsubs = $Mailchimp_Lists->batchSubscribe('799283c68c', $batch, false, false, true);


echo "<pre>"; print_r($listsubs);
/*
Array
(
    [add_count] => 1
    [adds] => Array
        (
            [0] => Array
                (
                    [email] => pankaj.jingle@gmail.com
                    [euid] => 7944afbcfb
                    [leid] => 14082845
                )

        )

    [update_count] => 0
    [updates] => Array
        (
        )

    [error_count] => 0
    [errors] => Array
        (
        )

)
*/
$email =  array('emails' => array('euid' => '54881744a7'));
 $meberinfo = $Mailchimp_Lists->memberInfo('799283c68c', $email);
  echo "<pre>";print_r($meberinfo);




?>