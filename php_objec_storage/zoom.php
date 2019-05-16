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
$ini['username'] = "erpobjectuser";
$ini['password'] = "5btCwCJJVooy";
$ini['tenantId'] = "1f6a6bc07df34bf69bfb4c2036df266b";
$ini['url']= ' http://75.112.188.224:5000';
//$ini['url'] = 'http://172.21.15.15:5000';
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

/*$rty = $objectStore->hasContainer('thumb21');
   var_dump($rty);    die('check');   */
 //$dir = $_SERVER['DOCUMENT_ROOT'].'/videosubs_object/public/documents';
 $dir = $_SERVER['DOCUMENT_ROOT'].'/videosubs/public/documents';

  $acl = ACL::makePublic();
 $value = 'sanjiv';
 $objectStore->createContainer($value);
 $objectStore->changeContainerACL($value,$acl);
$container = $objectStore->container($value);


?>

