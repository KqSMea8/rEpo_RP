<?php

//require_once("includes/config.php"); 
require_once("includes/function.php");
/*
date_default_timezone_set("UTC");
echo $CurrenTime = gmdate("Y-m-d H:i:s");
echo '<br>';
echo $CurrenTime = date("Y-m-d H:i:s", time());
*/
echo GetIPAddress(); die;


 /*

if(!empty($_GET['db'])) $Config['DbName'] = $_GET['db'];


//echo mydecrypt($Config['DbUser']);


$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());

echo 'MySql Connected.<br><br>';


$_POST["sql"] = "INSERT INTO `admin` (`AdminID`, `AdminEmail`, `Password`, `Name`, `Status`) VALUES
(1, 'test@virtualstacks.com', '345345435345345', 'admin', 1);";

$q=mysql_query($_POST["sql"],$link) or die (mysql_error());
echo "Query has been executed successfully.<br><br>";

*/

echo  time(); 

echo 'aa<pre>';print_r($_SERVER);die;


echo getcwd();

phpinfo();


?>


