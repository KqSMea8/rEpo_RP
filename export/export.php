<?php   
require_once("../includes/config.php"); 

if(!empty($_GET['db'])) $Config['DbName'] = $_GET['db'];

$link=mysql_connect ($Config['DbHost'],$Config['DbUser'],$Config['DbPassword'],TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());

echo 'MySql Connected.<br><br>';



//ENTER THE RELEVANT INFO BELOW
$mysqlDatabaseName =$Config['DbName'];
$mysqlUserName =$Config['DbUser'];
$mysqlPassword =$Config['DbPassword'];
$mysqlHostName =$Config['DbHost'];
$mysqlImportFilename =$Config['DbName'].'.sql';

//DO NOT EDIT BELOW THIS LINE
//Export the database and output the status to the page
$command='mysql -h ' .$mysqlHostName .' -u ' .$mysqlUserName .' -p "' .$mysqlPassword .'" ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;


//$command = "mysqldump -u erp_mkb -p <Isb40868)2> erp > tut_backup.sql";

exec($command,$output=array(),$worked);
echo '<br><br>work status: '.$worked;
switch($worked){
    case 0:
        echo 'Import file <b>' .$mysqlImportFilename .'</b> successfully imported to database <b>' .$mysqlDatabaseName .'</b>';
        break;
    case 1:
        echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
        break;
}


?>

