<?php
function zipFilesAndDownload($file_names,$archive_file_name,$file_path)
{
	$zip = new ZipArchive();
	if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
    	exit("cannot open <".$archive_file_name.">\n");
	}
	foreach($file_names as $files)
	{
  		$zip->addFile($file_path.$files,$files);
	}
	$zip->close();
	header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=".$archive_file_name); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	readfile($archive_file_name);
	//unlink($archive_file_name);
	exit;
}

$file_names = array('nouser.jpg','hrms.jpg','logo.png');
$archive_file_name = rand(1,1000).'_test.zip';
$file_path='images/'; 

zipFilesAndDownload($file_names,$archive_file_name,$file_path);
?>