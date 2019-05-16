<?php  
	include_once("includes/header.php");
	require_once("../classes/server.class.php");
	$Config['StartPage']=0;
	$Config['RecordsPerPage'] = $RecordsPerPage;
	
	$ThisPageName="databaseBackup.php";
	$objServer = new server();
	$file = array();
	$files = array();
	$arryFolder = array(); 
	(empty($_GET['databaseName']))?($_GET['databaseName']=""):("");



	if(!empty($_GET['Truncate'])){   
		/*******Delete DB Backup*****************/
		$db = $_GET['Truncate'];          
		$file = glob($dataBaseMainpath."$db/*.*");
		$file =  array_reverse($file);
		foreach($file as $key=>$values) {				
			unlink($values);				
		} 
		rmdir($dataBaseMainpath.$db);		 
		/***************************************/
		$_SESSION['mess_Database'] = DATABASE_BACKUP_REMOVED;
		header("Location:".$ThisPageName);		 
		exit;
	}





  	$listfolder = glob($dataBasefolder."/*",GLOB_ONLYDIR);
	foreach($listfolder as $folder){
		$result = explode("/", $folder);  
	 	$folder = $result[4];
		if(!empty($folder))$arryFolder[] = $folder;
	}
 	 if(!empty($arryFolder)) asort($arryFolder);

	
	 if(!empty($_GET['databaseName'])){
		$databasename = $_GET['databaseName'];
		
      $file = glob($dataBasefolder."/$databasename/*.*");
		
	}
	

	
	/***** Function for sort ********/ 
	function build_sorter($key) {
		
    return function ($a, $b) use ($key) {
		        return strnatcmp($a[$key], $b[$key]);
		    };
		}
	/***** End sort ********/ 
		
  	
	if(!empty($file)){
	  	foreach($file as $key=>$values) {
	  		 $filedetail = pathinfo($values);
	  		 $FileSize = $objServer->GetFileSize($values);
	  		 $x = array('filename'=>$filedetail['filename'],'extension'=>$filedetail['extension'],'date'=>filemtime($values),'filesize'=>$FileSize);
	  		 array_push($files,$x);
	  	}
	}
   /***** Sort **********/
	usort($files, build_sorter('date'));
	$files=(array_reverse($files));

   /***** End sort ********/ 
	
/******* For Delete File ******/
    if (!empty($_GET['del_id'])) { 
     $getfolder = $_GET['del_id'];
      $result = explode("/", $getfolder);  
	 $arrayfolder = $result[0];
     unlink($dataBaseMainpath."/".$_GET['del_id']);
    $_SESSION['mess_Database'] = DATABASE_BACKUP_REMOVED;

	header("location:databaseBackup.php?databaseName=".$arrayfolder);
	exit;
}
/********* End ***********/

    $num =count($files);
	$pagerLink=$objPager->getPager($files,$RecordsPerPage,$_GET['curP']);
	(count($files)>0)?($files=$objPager->getPageRecords()):("");



/*******************************************************************************************/
if(!empty($_GET['testing'])){
	$dataBasefolder = 'http://erpdb.local/MKB/';
	function FetchPage($path){
		$file = fopen($path, "r"); 

		if (!$file)
		{
		exit("The was a connection error!");
		} 

		$data = '';

		while (!feof($file))
		{
		// Extract the data from the file / url

		$data .= fgets($file, 1024);
		}
		return $data;
	} 
	$string = FetchPage($dataBasefolder);
	pr($string);
}
/*******************************************************************************************/



	require_once("includes/footer.php"); 	 
?>
  
