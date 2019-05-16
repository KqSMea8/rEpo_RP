<?php
require_once("includes/config.php"); 
require_once("includes/function.php");
$Username = mydecrypt($Config['DbUser']);
$Password = mydecrypt($Config['DbPassword']); 
$db_name = 'erp_parwez';

$erpdefault = 'defaultdb'; //'erpdefault';
$sqlpath = '/var/www/html/upload/sql/'.$erpdefault.'.sql';
$Base = md5($_GET['base']); 
 
 
 

if(!empty($_GET['action'])){
	if($Base=='d9d381ffad485b880b42f6eb69c12cbd'){
	$link=mysql_connect($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
	if(!$link){die("Could not connect to MySQL");}
	 

	if($_GET['action']=="AddDatabse"){
		$sql = 'CREATE Database IF NOT EXISTS '.$db_name;
		mysql_query($sql) or die (mysql_error());
	}else if($_GET['action']=="RemoveDatabse"){
		$sql = 'DROP Database IF EXISTS '.$db_name; 
		mysql_query($sql) or die (mysql_error());
	}else if($_GET['action']=="dumpimport"){	 //Old 2.06 Inno DB,  0.08 MyIsam
	
		#shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' --single-transaction --quick --lock-tables=false '.$erpdefault.' | mysql -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$db_name); 

		

		shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$erpdefault.' | mysql -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$db_name); 

	}else if($_GET['action']=="dumpfolder"){ //dump to folder  0.03
 
		shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$erpdefault.' > '.$sqlpath); 
	}else if($_GET['action']=="import"){//import db   3.18 and 1.25
		shell_exec('mysql -u '.$Username.' -p'.$Password.' '.$db_name.' < '.$sqlpath); 
	}else if($_GET['action']=="query"){//import query
		 	
		 

		mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());

		$sql = "SELECT TABLE_NAME 
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$erpdefault."' ";
 
		$result=mysql_query($sql,$link) or die (mysql_error());
		$i=0;
		while($row = mysql_fetch_assoc($result)) {
			$i++;
			$table = $row['TABLE_NAME'];
			echo $i.'. '.$table.'<br>';

			$sql = 'ALTER TABLE '.$erpdefault.'.'.$table.' ENGINE=MyISAM';
echo '<br>'.$sql;  
			//$q=mysql_query($sql,$link) or die (mysql_error());

			/*$sql = 'CREATE TABLE '.$db_name.'.'.$table.' LIKE '.$erpdefault.'.'.$table;
			$q=mysql_query($sql,$link) or die (mysql_error());
		
			$sql = 'INSERT INTO '.$db_name.'.'.$table.' SELECT * from '.$erpdefault.'.'.$table;
			$q=mysql_query($sql,$link) or die (mysql_error());*/

			 
			 
		}
		 
		


	}

	echo 'Done';
}
}
?>

