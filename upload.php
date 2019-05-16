<?php
session_start();
if($_SESSION['MemberID']  == '' || $_SESSION['UserName']  == '' || $_SESSION['Email']  == '') {	
	header('location: 404.php');
	exit;
}

ini_set('display_errors',1);
error_reporting(E_ALL);








/*
$ftp_host = '75.112.188.150'; 
$ftp_user_name = 'ezneterp';  
$ftp_user_pass = 'Hnzs&t4';  
 
 
//$conn_id = ftp_ssl_connect($ftp_host,'21') or die ("could not connect"); //port 990 or 21
 $conn_id = ftp_connect( $ftp_host) or die ("could not connect");
  echo  $conn_id;die;
$login_result = ftp_login( $conn_id, $ftp_user_name, $ftp_user_pass );
 print_r($login_result); die;
  
//ftp_pasv($conn_id, true);

ftp_chdir($conn_id, '/erp/upload/news/');

 
$uploaded = ftp_put($conn_id, "2.jpg", $file , FTP_BINARY); 
$uploaded1 = ftp_put($conn_id, "2.jpg", $file , FTP_ASCII);
 
echo $uploaded.' - '.$uploaded1;die;

die;

*/
/*********************/
/******75.112.188.112 Permission denied*******/
/*
IP: 75.112.188.112
User: crmprod_ftpusrparwez01
Password: 6MiutQrzVUor#9M
Port: 21*/

$ftp_host = '75.112.188.111';  
$ftp_user_name = 'devftp';  
$ftp_user_pass = 'Htpl!#70Znt0'; 

/*
$ftp_host = '75.112.188.112';  
$ftp_user_name = 'crmprod_ftpusrparwez01';  
$ftp_user_pass = '6MiutQrzVUor#9M'; 
 */

$conn_id = ftp_ssl_connect($ftp_host) or die ("could not connect"); //port 990 or 21
// $conn_id = ftp_connect( $ftp_host) or die ("could not connect");
  
$login_result = ftp_login( $conn_id, $ftp_user_name, $ftp_user_pass );
 //echo $conn_id; print_r($login_result); die;
  
//ftp_pasv($conn_id, true);

//ftp_chdir($conn_id, '/erp/upload/news'); 

$file = 'upload/news/2.jpg';  
$remote_file = '/erp/upload5/news/2.jpg';

$uploaded = ftp_put($conn_id, $remote_file, $file , FTP_BINARY); 

$uploaded1 = ftp_put($conn_id, $remote_file, $file , FTP_ASCII);

 /*o enable write access you have to edit the /etc/vsftpd.conf file and uncomment the
#write_enable=YES*/

echo $uploaded.'-'.$uploaded1;die;

if($uploaded){
	echo "success";
}
else{
	echo "fail";
}
 
 
/* Close the connection */
ftp_close( $conn_id );


die;

/************************/
/************************/
$copy = copy( $remote_file_url, $file );
if(!$copy ) {
    echo "Doh! failed to copy $file";
}
else{
    echo "WOOT! success to copy $file";
}

 

/************************/
/************************/
ob_start();
require 'vendor/autoload.php';


use \OpenStack\Bootstrap;
use \OpenStack\Identity\v2\IdentityService;
use \OpenStack\ObjectStore\v1\ObjectStorage;
use \OpenStack\ObjectStore\v1\Resource\Object;
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip','mp4','mov','pdf');
$temp_path = '/opt/lampp/temp/';
$ini['username'] = "demo";
$ini['password'] = "pass@123";
$ini['tenantId'] = "163e0ee32577466f9f06d1a506aca147";
$ini['url']= 'http://192.168.0.114:5000';
	// $ini['url'] = 'http://192.168.0.114:8080/v1';
// Load these from an ini file.
//$ini = parse_ini_file(getenv('HOME') . '/.OpenStack.ini');
$username = $ini['username'];
$password = $ini['password'];
$tenantId = $ini['tenantId'];
$endpoint = $ini['url'];
//unset($_SESSION['auth_token']);

 $idService = new IdentityService($endpoint);  
 $token = $idService->authenticateAsUser($username, $password, $tenantId);
 $_SESSION['auth_token'] = $token;
 

    
    
 $catalog = $idService->serviceCatalog();
 // Find out where our ObjectStorage instance lives:

  $storageList = $idService->serviceCatalog('object-store');
  
  
  $objectStorageUrl = $storageList[0]['endpoints'][0]['publicURL'];
  $_SESSION['auth_storage_url'] = $objectStorageUrl;

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0 && !empty($token)){  

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
        
    // Create a new ObjectStorage instance:
    $objectStore = new \OpenStack\ObjectStore\v1\ObjectStorage($token, $objectStorageUrl);
    // create container
     $container = $objectStore->container('pramod-2');
     // move temp file
     $file_name =  $_FILES['upl']['name'];
     $new_fileName =  time().'.'.substr($file_name, strrpos($file_name, '.')+1);
    
     if(move_uploaded_file($_FILES['upl']['tmp_name'],$new_fileName)){
                // save file
            shell_exec('chmod -R 777 /opt/lampp/htdocs/php_objec_storage/');
            $name =  $new_fileName;
           $content = file_get_contents($name);
           $finfo = finfo_open(FILEINFO_MIME_TYPE);
           $mime = finfo_file($finfo,$name); 
           // delete
           
           $localObject = new Object($name,$content,$mime);
           
           if(!$container->save($localObject))
           {

               echo '{"status":"error"}';
                       exit;

           }
           unlink($new_fileName);
	}
    
     echo '{"status":"success"}';
		exit;
	
}else{

echo '{"status":"error"}';
exit;
}
