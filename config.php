<?php
	global $Config;

	date_default_timezone_set('Asia/Calcutta');

	if($_SERVER['SERVER_NAME']=='localhost'){
		$Config['DbHost']			= 'localhost';
		$Config['DbUser']			= 'root';
		$Config['DbPassword']		= '';
		$Config['DbName']			= 'agrinde_erp';
		$Config['Url']				= 'http://localhost/agrinde_erp/';
	
	}else{
		
		$Config['DbHost']			= 'localhost';
		$Config['DbUser']			= 'root';   // Cpanel UserName & Password
		$Config['DbPassword']		= 'yG534b6oce';	
		$Config['DbName']			= 'erp';
		$Config['Url']				= 'http://ec2-54-221-39-140.compute-1.amazonaws.com/erp/';
	}

$link=mysql_connect ($Config['DbHost'],$Config['DbUser'],$Config['DbPassword'],TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());

echo 'MySql Connected.<br><br>';


$q=mysql_query("select * from admin ",$link) or die (mysql_error());
$ar1=mysql_fetch_array($q);
print_r($ar1); exit;




?>