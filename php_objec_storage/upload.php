<?php
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