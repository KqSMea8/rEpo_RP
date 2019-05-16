<?php
// https://66.55.11.56/webservice/acl_cdr.php?extension=3022&date_start=2016-05-05&date_end=2016-05-05

$url="https://66.55.11.56/webservice/acl_cdr.php";
$params =  array('extension'=>3022,'date_start'=>'2016-05-05','date_end'=>'2016-05-05');

$result  = api($url,$params=array());

echo  "<pre>";print_r($result);die;

function api($url,$params=array()){
		
		
		  $postData = ''; 
		 
			  
		   	 
	  
		   foreach($params as $k => $v) 
		   { 
		      $postData .= $k . '='.$v.'&'; 
		   }
		   rtrim($postData, '&');		
			$ch = curl_init();
			if(!empty($postData)){
			    //echo $postData;die;
			}
			curl_setopt($ch, CURLOPT_URL,$url);
			
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			
			
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			
			$results = json_decode($server_output);			
			return $results;
	
	}

























?>