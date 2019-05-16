<?php
require_once("includes/config.php"); 
require_once("includes/function.php");
$Username = mydecrypt($Config['DbUser']);
$Password = mydecrypt($Config['DbPassword']); 
$db_name = 'erp_anil';
 

shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' erpdefault | mysql -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$db_name);

?>

