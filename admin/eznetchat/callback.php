<?php
require_once("../includes/settings.php");
require_once($Prefix . "classes/lead.class.php");

$objLead = new lead();

$data = file_get_contents("test.txt",true);

$json = '{"text*701":"Ravi","text*528":"Solanki","email*578":"test11@gmail.com","number*826":"8010695859","textarea*474":"tessadfsdfbdsf"}';
$dt = json_decode($json,true);

$leadData = array();

$leadData = array('FirstName'=>$dt['text*701'],'LastName'=>$dt['text*528'],'primary_email'=>$dt['email*578'],'Mobile'=>$dt['number*826'],'description'=>$dt['textarea*474']);

$leadId = $objLead->AddLead($leadData);

?>


