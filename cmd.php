<?php

$password = 'PyJtCk7TFo';    //'0yl(F1na5q$q(';  //66.55.11.23


//$password = 'root123#';  //207.201.237.101

/*
$link=mysql_connect ('localhost','root',$password,TRUE);
if(!$link){die("Could not connect to MySQL");}
echo 'connected';
*/

//$data = shell_exec('ls -lart');

$data = shell_exec('mysqldump -h localhost -u root -p'.$password.' erp_parwez005 | mysql -h localhost -u root -p'.$password.' erp_new');
print_r($data);
exit;

#$data = shell_exec('mysqldump -h localhost -u root -proot123#  erp_test | mysql -h localhost -u root -proot123# test_backup1');

?>

<?php
$connection=mysql_connect('localhost','erp_mkb','Isb40868)2');
mysql_query('CREATE DATABASE menagerie1');
$data = shell_exec('mysqldump -h localhost -u erp_mkb -pIsb40868)2  erp_parwez005 | mysql -h localhost -u erp_mkb -pIsb40868)2 menagerie1');


exit;
?>

<?







$Command = 'mysqldump -h localhost -u "erp_mkb" -p "Isb40868)2" erp_sakshay | mysql -h localhost -u "erp_mkb" -p "Isb40868)2" erp_new';
/*
//$output = shell_exec('ls -lart');

//$Command = 'mysql -u "erp_mkb" -p "Isb40868)2" -e "SHOW DATABASES"';

$Command = 'mysql -uroot -p';
*/

exec('mysqldump -u "erp_mkb" -p ""Isb40868)2" erp_sakshay > my_database_dump.sql');exit;

$output = system($Command);
echo "<pre>$output</pre>jjj";
?>
