<?php
   // $_POST['OrderID']=26284;
	require_once("/var/www/html/erp/lib/paypal/sdk/vendor/paypal/rest-api-sdk-php/sample/bootstrap.php");	
	use PayPal\Api\OpenIdTokeninfo;
    use PayPal\Api\OpenIdUserinfo;
	use PayPal\Api\Invoice;
	$invoice = new Invoice();
	


// This would be refresh token retrieved from http://paypal.github.io/PayPal-PHP-SDK/sample/doc/lipp/ObtainUserConsent.html
//$refreshToken = "SCNWVZfdg43XaOmoEicazpkXyda32CGnP208EkuQ_QBIrXCYMhlvORFHHyoXPT0VbEMIHYVJEm0gVf1Vf72YgJzPScBenKoVPq__y1QRT7wwJo3WYADwUW4Q5ic";
//$refreshToken = "imrqBWnVB9ycbzn0DBQ0KedwS7XJffGhKPEgpBDwvEzHLfiDVT53gwIi2sErH7V58DYYSf-nJFyFm0QhT8DNruym2wlc30una9-RsCKYsBlPI2k58ia6BioURCY";

//$refreshToken = "sde6dGXpVp2V31ycZ6WEMbevuyiNQf-mzEquFCLRQRCs3EAeU0h5koXkOEwrkfH3SJPfcPyhxZNZzflBEJD7YWU95E-jHyJCk7JMp5sb33BcW7jHspetxOdJ7IQ";
//$refreshToken ='4QypadKOB4okA_kOwo7DJPJ7NM_JdMqjmPElasAl6hyHVXEB-u4WMBdDXJF7FJWfiGmb48qI6dtHgnjani01ygCRHcf1eNZZbWjFo0xjkF-cT6hNMonk8DdH9ks';

	
//$refreshToken ='grU5mdXz1S9OoQks1sny3dFwwTvm7KDgQHb4zWSwuXlruN7fhzPUm9ESMwkPSrtyG7sTdLfmcLaJYcebGcXicBjp66SLS3kfl2WUU5Km1x86X0qqzH7JbRRt5lU';
//$refreshToken ='R103.Wr3D2rGD6H1hyNZVdLyt3GLckrsrySk8lxv9dkciUPmTx2UjjDL0x7cEiBfmtpjeSOY1addUIQwD8s3u-_UL3uQVdGbKfk99gClxUxewYtsDIGwUDtfsk0pzclOu-6aiJX7W1fWan13hcH88';
$refreshToken=$PaypalToken;
	
try {
    // ### Use Refresh Token. MAKE SURE TO update `MerchantInfo.Email` based on
    $invoice->updateAccessToken($refreshToken, $apiContext);
    

    $tokenInfo = new OpenIdTokeninfo();
    $tokenInfo = $tokenInfo->createFromRefreshToken(array('refresh_token' => $refreshToken), $apiContext);

    $params = array('access_token' => $tokenInfo->getAccessToken());
    $userInfo = OpenIdUserinfo::getUserinfo($params, $apiContext);
    if($_SESSION['AdminID']==37){
     // pr( $userInfo,1);
    }
   // print_r($userInfo->getemail());
   // print_r($userInfo['email']);die;
    if(!empty($userInfo->getemail())){
  	 return array('status'=>'1','message'=>'Valid');
    } else{ 
  	 return array('status'=>'0','message'=>'Invalid Paypal Authorization');
  	 }
   // print_r($responce);
} catch (Exception $ex) {

 return array('status'=>'0','message'=>'Invalid Paypal Authorization');
//print_r($ex);die;
  // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 	//ResultPrinter::printError("User Information", "User Info", null, $params, $ex);
    //exit(1);
}


 
?>
