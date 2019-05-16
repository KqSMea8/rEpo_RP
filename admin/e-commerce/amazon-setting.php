<?php

	$SERVICE_URL   = str_replace( 'amazon', 'mws.amazonservices', $AmazonSetting[0]['url'] );
    $SERVICE_URL   = str_replace( 'mws.amazonservices.co.jp', 'mws.amazonservices.jp', $SERVICE_URL ); // fix MWS JP URL
	$SERVICE_URL   = 'https://' . $SERVICE_URL;
	$SERVICE_PRODUCT_URL   = $SERVICE_URL.'/Products/2011-10-01';
	$orderURL      = $SERVICE_URL.'/Orders/2013-09-01';
  	
	define ('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');
    if($AmazonSetting[0]['group_title']=='Europe'){
    	$this->AWS_ACCESS_KEY_ID = 'AKIAJZPWDA32JIKGHKDA';
    	$this->AWS_SECRET_ACCESS_KEY = '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';
    }else{
	$this->AWS_ACCESS_KEY_ID='AKIAJTXPSMPE7FGSR5EQ';
	$this->AWS_SECRET_ACCESS_KEY='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';
     }
  
    define('APPLICATION_NAME', 'vstacksERP');
    define('APPLICATION_VERSION', '1.0');
   
 /*   define ('MERCHANT_ID', $AmazonSetting[0]['merchant_id']);
    define ('MARKETPLACE_ID', $AmazonSetting[0]['marketplace_id']); 
	define ('SERVICE_URL', $SERVICE_URL);	
	define ('SERVICE_ORDER_URL', $orderURL);	
	define ('MWS_AUTH_TOKEN', $AmazonSetting[0]['mws_auth_token']);	*/
	
	$this->MERCHANT_ID       = $AmazonSetting[0]['merchant_id'];
	$this->MARKETPLACE_ID    = $AmazonSetting[0]['marketplace_id'];
	$this->SERVICE_URL       = $SERVICE_URL;
	$this->SERVICE_ORDER_URL = $orderURL;
	$this->MWS_AUTH_TOKEN    = $AmazonSetting[0]['mws_auth_token'];
	$this->SERVICE_PRODUCT_URL = $SERVICE_PRODUCT_URL;
	$this->URL				   = $AmazonSetting[0]['url'];
   
    set_include_path(get_include_path() . PATH_SEPARATOR . $amazon_setting_path.'amazon');


    if (!function_exists("__autoload")) {
     function __autoload($className){
        $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $includePaths = explode(PATH_SEPARATOR, get_include_path());
        foreach($includePaths as $includePath){
            if(file_exists($includePath . DIRECTORY_SEPARATOR . $filePath)){
                require_once $filePath;
                return;
            }
        }
    }
    }
