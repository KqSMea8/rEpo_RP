<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For config page SuperAdmin chat management system config.php
 */
//ini_set('display_errors',1);
//error_reporting(E_ALL);
global $Config;
require_once('../../includes/config.php'); 
require_once('define.php'); 

function mydecryptpos($text){
	$salt ='2210198022101980';
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}


$Config['chatdbhost']=$Config['DbHost'];
$Config['chatdbuser']=mydecryptpos($Config['DbUser']);
$Config['chatdbpassword']=mydecryptpos($Config['DbPassword']);
$Config['chatdbname']=$Config['DbName'];
$Config['ecomfolder']=$Config['DbName'];
?>
