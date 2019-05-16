<?
/*
$password = 'z4dNKzoYAg1CkLYZYUqh8DE9f';  

$data = shell_exec('mysqldump -h localhost -u root -p'.$password.' erpdefault > /var/www/html/erp/db/erp_erpdefault.sql');
print_r($data);
exit;
*/
exit;
?>

<?php
//ENTER THE RELEVANT INFO BELOW
$mysqlDatabaseName ='erp_eoptions';
$mysqlUserName ='erp_mkb';
$mysqlPassword ='Isb40868)2';
$mysqlHostName ='localhost';
$mysqlExportPath ='erp_eoptions.sql';

//DO NOT EDIT BELOW THIS LINE
//Export the database and output the status to the page
#$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > /var/www/html/erp/db/' .$mysqlExportPath;

$command = 'mysqldump -u "erp_mkb" -p ""Isb40868)2" erp_sakshay > erp_sakshay.sql';

exec($command,$output=array(),$worked);
switch($worked){
case 0:
echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
break;
case 1:
echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>' .$mysqlExportPath .'</b>';
break;
case 2:
echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
break;
}
?>
