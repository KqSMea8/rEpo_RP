<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//session_start();
require 'vendor/autoload.php';
//session_destroy();

use \OpenStack\Bootstrap;
use \OpenStack\Identity\v2\IdentityService;
use \OpenStack\ObjectStore\v1\ObjectStorage;
use \OpenStack\ObjectStore\v1\Resource\Object;
use \OpenStack\ObjectStore\v1\Resource\ACL;
use \OpenStack\Common\Transport;
$ini['username'] = "pramod";
$ini['password'] = "dMeK12I9I1jj";
$ini['tenantId'] = "686913a917184cd88695ffc77d3b48a7";
//$ini['url']= 'http://192.168.0.114:5000';
$ini['url'] = 'http://172.21.15.15:5000';
// Load these from an ini file.
//$ini = parse_ini_file(getenv('HOME') . '/.OpenStack.ini');
$username = $ini['username'];
$password = $ini['password'];
$tenantId = $ini['tenantId'];
$endpoint = $ini['url'];
//unset($_SESSION['auth_token']);

 $idService = new IdentityService($endpoint);  
// $acl = ACL::makePrivate();
 $token = $idService->authenticateAsUser($username, $password, $tenantId);


 $_SESSION['auth_token'] = $token;
 

    
    
 $catalog = $idService->serviceCatalog();
 // Find out where our ObjectStorage instance lives:

  $storageList = $idService->serviceCatalog('object-store');
  
  
  $objectStorageUrl = $storageList[0]['endpoints'][0]['publicURL'];
  $_SESSION['auth_storage_url'] = $objectStorageUrl;
 
  // Create a new ObjectStorage instance:
 $objectStore = new \OpenStack\ObjectStore\v1\ObjectStorage($token, $objectStorageUrl);

          
  // create container
 //$objectStore->createContainer('pramod-2');
   // List containers:
 // change permission
 //$objectStore->container('pramod-1');
 //$objectStore->changeContainerACL('pramod-1',$acl);
 
print_r($objectStore);
exit;
  //$container = $objectStore->container('pramod-2');
   // write file in 
 /* $name = 'images/MEGAeBin Test Results-With-Comments-Oct12_Ver1.4.docx';
$content = file_get_contents($name);

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo,$name); 


$localObject = new Object($name,$content,$mime);
if(!$container->save($localObject))
{
    echo "Not able to wirte please try again";
    exit;
}*/
   // List all of the objects in that container:
  echo "<pre>";
 print_r($container->objects());
 echo "</pre>";
 //    
// to view object
// set the header for the image
 // header("Content-type:video/mp4");
  //$name = 'images/images2.jpeg';
$name = 'logo_small.png';
//$obj = $container->object($name);
//echo $obj->contentType();
//header("Content-type:".$obj->contentType());


     // Print that object's contents:
//print $obj->content();
//var_dump($storageList);


?>
