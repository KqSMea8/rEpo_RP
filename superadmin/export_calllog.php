<?php  	

ini_set('display_errors',1);
	include_once("includes/settings.php");
    require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");
	$ModuleName = "Company";
	$objphone = new phone();
	$serverid=$_GET['id'];
/*************************/
$sql="Select * FROM call_log where server='$serverid'";
$results=$objphone->get_results($sql);
$filename = "Call_Log_".date('d-m-Y').".xls";
if(!empty($results)){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Date\tFrom\tTo\tStatus\tCol-4\tCol-5\tCol-6\tCol-7\tCol-8\tCol-9\tCol-10\tCol-11";

	$data = '';
	foreach($results as $key=>$result){
		 
		$line = $result->call_date."\t".stripslashes($result->call_from)."\t".stripslashes($result->call_to)."\t".stripslashes($result->call_status)."\t".$result->col4."\t".$result->col5."\t".$result->col7."\t".$result->col8."\t".$result->col9."\t".$result->col10."\t".$result->col11."\t".$result->col12."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

