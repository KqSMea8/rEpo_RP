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

/*$rty = $objectStore->hasContainer('thumb21');
   var_dump($rty);    die('check');   */
 //$dir = $_SERVER['DOCUMENT_ROOT'].'/videosubs_object/public/documents';
 $dir = $_SERVER['DOCUMENT_ROOT'].'/videosubs/public/documents';

  $acl = ACL::makePublic();
  function dirToArray($dir) { 
  global   $objectStore ; 
  global   $acl ;  
  global  $container; 
  $result = array(); 
  $cdir = scandir($dir);


   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".","..","thumb","thumb21"))) 
      { 
      if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
        {  
 if(!$objectStore->hasContainer($value)) 

        {
        $objectStore->createContainer($value);
        $objectStore->changeContainerACL($value,$acl);
     
$container = $objectStore->container($value);
        //chmod($dir . DIRECTORY_SEPARATOR . $value,0777); 

$result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
     // global $container;
if (file_exists($dir.DIRECTORY_SEPARATOR.$value)) {
foreach ($result[$value] as $docImage) {
 global $container;
if(!is_array($docImage)){
 $content = file_get_contents($dir . DIRECTORY_SEPARATOR . $value.'/'.$docImage);

   $finfo = finfo_open(FILEINFO_MIME_TYPE);
   $mime = finfo_file($finfo,$dir . DIRECTORY_SEPARATOR . $value.'/'.$docImage); 
   
   $localObject = new Object($docImage,$content,$mime);
  if(!($container->save($localObject))){
    echo "<br> File not saved".$docImage."<br>";
  }else{
    echo "<br>Saved=$docImage<br>";
  }   
 
  }
  }
  }}
  else{
//print_r($value); die('feerw');
      // $objectStore->createContainer($value);
$objectStore->changeContainerACL($value,$acl);
     
$container = $objectStore->container($value);
/*echo '<pre>';
print_r($container); die('conta');*/
$result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);

     // global $container;
if (file_exists($dir.DIRECTORY_SEPARATOR.$value)) {
foreach ($result[$value] as $docImage) {
 global $container;
if(!is_array($docImage)){
 $content = file_get_contents($dir . DIRECTORY_SEPARATOR . $value.'/'.$docImage);

   $finfo = finfo_open(FILEINFO_MIME_TYPE);
   $mime = finfo_file($finfo,$dir . DIRECTORY_SEPARATOR . $value.'/'.$docImage); 
   
   $localObject = new Object($docImage,$content,$mime);
  if(!($container->save($localObject))){
    echo "<br> File not saved".$docImage."<br>";
  }else{
    echo "<br>Saved in =$docImage<br>";
  }
  }
  }
  }
  }



   /*$content = file_get_contents($dir . DIRECTORY_SEPARATOR . $value.'/'.$result[$value][0]);
   $finfo = finfo_open(FILEINFO_MIME_TYPE);
   $mime = finfo_file($finfo,$dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $value.'/'.$result[$value][0]);  
   $localObject = new Object($dir . DIRECTORY_SEPARATOR . $value.'/'.$result[$value][0],$content,$mime);

      if(!$container->save($localObject))
      {
        echo "Not able to wirte please try again";
        exit;
      }*/
        
        } 
         else  
         { 
            $result[] = $value; 
         } 
      } 
   } 
 
   return $result;  
} 
$data = dirToArray($dir);
echo '<pre>';
print_r($data);
 die;
    /*foreach ($files as $file)
    {
    if (is_dir($file)) { 
      print_r($file);
        if(!$objectStore->hasContainer($file))
        {
        $objectStore->createContainer($file);
        $objectStore->changeContainerACL($file,$acl);
        $container = $objectStore->container($file);
        }
    }*/

 /*else {

    echo $file;

$content = file_get_contents($files);

$localObject = new Object($file,$content);
if(!$container->save($localObject)){
  echo '{"status":"error"}';
  exit;
}
    }}*/

  
die;
 

        // create new container
if(!$objectStore->hasContainer('author_'.$id))
{
$objectStore->createContainer('author_'.$id);
$objectStore->changeContainerACL('author_'.$id,$acl);
}
$container = $objectStore->container('author_59');

$content = file_get_contents($file['tmp_name']);

// $finfo = finfo_open(FILEINFO_MIME_TYPE);

$mime = $file['type']; 
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$encrptdocname = (time()) . '.' . $ext;
$localObject = new Object($encrptdocname,$content,$mime);
if(!$container->save($localObject)){
  echo '{"status":"error"}';
  exit;
}
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
 exit;
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

