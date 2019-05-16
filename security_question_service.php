<?php  
require_once("includes/config.php"); 
require_once("includes/function.php");
$Username = mydecrypt($Config['DbUser']);
$Password = mydecrypt($Config['DbPassword']); 
$db_name = 'erp';

$link=mysql_connect($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());


if(empty($_GET['limit'])) $_GET['limit']=10;
if(!empty($_GET['rand'])){
	$addSql = ' ORDER BY rand() ';
}else{
	$addSql = ' ORDER BY QuestionID Asc ';
}

$sql="SELECT * FROM `question` where 1  ".$addSql." limit 0, ".$_GET['limit'];
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $menuDta[]=$result;
}
echo json_encode($menuDta);
?>


