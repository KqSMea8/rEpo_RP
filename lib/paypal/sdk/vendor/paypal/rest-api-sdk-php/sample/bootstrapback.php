<?php
/*
 * Sample bootstrap file.
 */

// Include the composer Autoloader
// The location of your project's vendor autoloader.
$composerAutoload = dirname(dirname(dirname(__DIR__))) . '/autoload.php';
if (!file_exists($composerAutoload)) {
    //If the project is used as its own project, it would use rest-api-sdk-php composer autoloader.
    $composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';


    if (!file_exists($composerAutoload)) {
        echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
        exit(1);
    }
}
require $composerAutoload;
require __DIR__ . '/common.php';

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

// Suppress DateTime warnings, if not set already
date_default_timezone_set(@date_default_timezone_get());

// Adding Error Reporting for understanding errors properly
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

// Replace these values by entering your own ClientId and Secret by visiting https://developer.paypal.com/webapps/developer/applications/myapps
//$clientId = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';


//$clientSecret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';

/******* Demo***********/
$clientId = 'AeltrsAaLhkq_ENX_XqyJc3Xo5USwg7mBb9I2_xvmYL8GRp51q6Bd8PlyO5C5J6jksdboR1Rz7I73zRe';
$clientSecret = 'EN7TfQIXvzBDRhjl1YNqeAmX5zJeEHL9Ks8bkf-zGuXAwlQ0F77MNwABd49LGOzyToB2F7qqItWIJTet';


/********* Live ***********/

$clientId = 'AQZ4wvC7sS6xKMgfNWdyqjmAYDxKLkdKNE5TEepaDKWIXouZKC5tki2rr1_nW-L0ok-b4VipmLB-0ny4';
$clientSecret = 'EDjgqc4HE-1TcHn9v-Ja96RwD_Im8sgpGFGI9f42CWr616-AquIfqrgDIhx2CYnnL7qQ1wq40HouUZkq';

/**
 * All default curl options are stored in the array inside the PayPalHttpConfig class. To make changes to those settings
 * for your specific environments, feel free to add them using the code shown below
 * Uncomment below line to override any default curl options.
 */
//PayPalHttpConfig::$defaultCurlOptions[CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1_2;


/** @var \Paypal\Rest\ApiContext $apiContext */
$apiContext = getApiContext($clientId, $clientSecret);
//print_r($apiContext);die;
return $apiContext;
/**
 * Helper method for getting an APIContext for all calls
 * @param string $clientId Client ID
 * @param string $clientSecret Client Secret
 * @return PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret)
{

    // #### SDK configuration
    // Register the sdk_config.ini file in current directory
    // as the configuration source.
    /*
    if(!defined("PP_CONFIG_PATH")) {
        define("PP_CONFIG_PATH", __DIR__);
    }
    */


    // ### Api context
    // Use an ApiContext object to authenticate
    // API calls. The clientId and clientSecret for the
    // OAuthTokenCredential class can be retrieved from
    // developer.paypal.com

    $apiContext = new ApiContext(
        new OAuthTokenCredential(
            $clientId,
            $clientSecret
        )
    );

    // Comment this line out and uncomment the PP_CONFIG_PATH
    // 'define' block if you want to use static file
    // based configuration
	//live or sandbox
    $apiContext->setConfig(
        array(
            'mode' => 'live',
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
            'cache.enabled' => true,
            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
            //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
        )
    );

    // Partner Attribution Id
    // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
    // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
    // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');

    return $apiContext;
}
