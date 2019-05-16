<?
$folder = "data";
$filename = '816133.txt';   //rand(10,999999).".txt";
$separator = "||||";
$FilePath = $folder."/".$filename; 



/***********Write File **************
$_POST["Name"] = 'Parwez Khan';
$_POST["Phone"] = '347583445745757';
$_POST["Email"] = 'pp@pp.com';
if(!file_exists($FilePath)){
	touch($FilePath);
}
$UserContent = '';
foreach($_POST as $key=>$values){
	$UserContent .= $values.$separator;
}

if (!$handle = fopen($FilePath, 'a')) {
	echo $Error = "Cannot open file ($filename)";
}
if(fwrite($handle, $UserContent) === FALSE) {
	echo $Error="Cannot write to file ($filename)";
}

exit;
*/


/***********Read File **************/
if(file_exists($FilePath)){
	$log_file = fopen($FilePath, "r") or exit("Unable to open ".$filename." file!");
	while(!feof($log_file)){
	  $TextLine = fgets($log_file);
	}
	$arryData = explode($separator,$TextLine );
	
	echo '<pre>';
	
	print_r($arryData);
	exit;

	fclose($log_file);
}

/********************************/
?>