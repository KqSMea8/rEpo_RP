<?php

session_start(); 

$_GET['FromDate'] = '01/09/2019';


if(!empty($_GET['FromDate'])){
$FromDate = $_GET['FromDate'];
$CurrentFormat = "m/d/Y";
$date = DateTime::createFromFormat($CurrentFormat , $FromDate);
echo $date->format('Y-m-d');die;
}

//ADD Cookie
//$ExpiryTime = time()+86400*30; //will set the cookie to expire in 30 days
//setcookie ("AuthSecretKey","SecretKey12345", $ExpiryTime);
/*RemoveCookie */
//setcookie ("AuthSecretKey","");  
echo '<pre>';print_r($_COOKIE);

 

 
die;

$timeArry = explode("-","2018-12-15");
list($year, $month, $day) = $timeArry;
$TempDate  = mktime(0, 0, 0, $month +2 , $day, $year);
echo $nextMoth = date("m",$TempDate);

die;

 ini_set('display_errors',0);
error_reporting(E_ALL);
/*
require_once("classes/function.class.php");
require_once("includes/function.php");
$objFunction=new functions();

$ResponseArray = $objFunction->UploadFileFTP('', '');
die;
*/
$FieldValue = 'Demo9214';
 if (!preg_match('/^[A-Za-z0-9]*$/', $FieldValue)) {
		echo $message .= "<br>".$errorimg."Please Enter Valid ".$FieldLabel." Address !";	
}else{
	echo 'ok';
}

die;

 echo md5('34');
$callbacks = array('disconnect' => 'my_ssh_disconnect',
            'ignore' => 'my_ssh_ignore',
            'debug' => 'my_ssh_debug',
            'macerror' => 'my_ssh_macerror');


        $connection = ssh2_connect('75.112.188.112', 33433, array('hostkey' => 'ssh-rsa'));


        ssh2_auth_pubkey_file($connection, 'configmgmt', '/var/www/html/configmgmt/.ssh/id_rsa.pub', '/var/www/html/configmgmt/.ssh/id_rsa');
        //ssh2_auth_password($connection, 'filetransfer', 'lJ7uqOta5Oz1');
       echo $sftp = ssh2_sftp($connection);



die;

	
function ConvertNumberToWordsUS55($number) {
     
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $dollar     = ' dollar ';
    $dollars     = ' dollars ';
    $decimal     = ' cent ';
     $decimals     = ' cents ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'ConvertNumberToWordsUS only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . ConvertNumberToWordsUS(abs($number));
    }
    
    $string = $string2 = $fraction = null;
   
    if (strpos($number, '.') !== false) {	
        list($number, $fraction) = explode('.', $number);
 	 
	 if($fraction<10 && strlen($fraction)==1) $fraction = $fraction.'0';
	 $fraction = ltrim($fraction,"0");
	 
    }


    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];

            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . ConvertNumberToWordsUS($remainder);
            }
            break;
     
        default: 
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = ConvertNumberToWordsUS($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= ConvertNumberToWordsUS($remainder);
            }
            break;
    }

	// echo $string;exit;

 	
     
 

    if (null !== $fraction && is_numeric($fraction)) {

	    $string .= ($number>1)?($dollars):($dollar);

        /*$words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
		echo $number;exit;
        }
        $string .= implode(' ', $words);*/
	 


 switch (true) {
        case $fraction < 21:
            $string2 = $dictionary[$fraction];
            break;
        case $fraction < 100:  
            $tens   = ((int) ($fraction / 10)) * 10;
            $units  = $fraction % 10;
            $string2 = $dictionary[$tens];
            if ($units) {
                $string2 .= $hyphen . $dictionary[$units];
            }
		 
            break;
        case $fraction < 1000:
            $hundreds  = $fraction / 100;
            $remainder = $fraction % 100;
            $string2 = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string2 .= $conjunction . ConvertNumberToWordsUS($remainder);
            }
            break;
     
        default: 
            $baseUnit = pow(1000, floor(log($fraction, 1000)));
            $numBaseUnits = (int) ($fraction / $baseUnit);
            $remainder = $fraction % $baseUnit;
            $string2 = ConvertNumberToWordsUS($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string2 .= $remainder < 100 ? $conjunction : $separator;
                $string2 .= ConvertNumberToWordsUS($remainder);
            }
            break;
    }

 //echo $string2;exit;
	 $string .= $string2;


	$string .= ($fraction>1)?($decimals):($decimal);
	
	 
    }	
    
    return $string;
}



$AmountInWords =  ConvertNumberToWordsUS(998.87);
if(strpos($AmountInWords, 'dollar') == false) {
	$AmountInWords .= ' dollars';	
}
echo $AmountInWords;
exit;



$date="1980-10-22";
echo date("l",strtotime($date)); 

session_start();

$old_sessionid = session_id();

session_regenerate_id();

$new_sessionid = session_id();

echo "Old Session: $old_sessionid<br />";
echo "New Session: $new_sessionid<br />";

print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
<body onbeforeunload="return myFunction()">

<p>Close this window, press F5 or click on the link below to invoke the onbeforeunload event.</p>

<a href="http://www.w3schools.com">Click here to go to w3schools.com</a>
      
<script>
function myFunction() {
    return "Write something clever here...";
}
</script>

</body>
</html>



